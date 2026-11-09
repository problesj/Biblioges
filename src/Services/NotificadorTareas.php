<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;

/**
 * Aviso por correo tras ejecutar una tarea programada.
 * Usa la configuración MAIL_* de .env. Un fallo de envío nunca afecta a la tarea: solo se registra.
 */
class NotificadorTareas
{
    /** @var callable|null recibe ['para', 'asunto', 'html', 'texto'] en lugar de enviar (pruebas) */
    private $transporte;

    public function __construct(?callable $transporte = null)
    {
        $this->transporte = $transporte;
    }

    /** Reportes de cobertura. $d: manual, inicio, fin, exito, registros, errores, estado_tarea, proxima */
    private function armarCoberturas(object $tarea, array $d): bool
    {
        $estado = $d['exito'] ? 'Completada' : 'Con errores';
        $filas = [
            'Tarea' => $tarea->nombre,
            'Estado' => $estado,
            'Ejecución' => $d['manual'] ? 'Manual (Ejecutar ahora)' : 'Programada',
            'Inicio' => $this->fecha($d['inicio']),
            'Fin' => $this->fecha($d['fin']),
        ];
        foreach ($d['registros'] as $tipo => $cantidad) {
            $filas['Cobertura ' . ($tipo === 'basica' ? 'básica' : $tipo)] = $cantidad . ' registro(s) guardado(s)';
        }
        foreach ($d['errores'] as $i => $error) {
            $filas['Error' . (count($d['errores']) > 1 ? ' ' . ($i + 1) : '')] = $error;
        }
        $filas['Próxima ejecución'] = $d['proxima'] ? $this->fecha($d['proxima']) : 'No hay (la tarea no se repite o terminó)';

        return $this->enviarAviso($tarea, $estado, $filas, $this->url('tareas-programadas'), 'Ver tareas programadas');
    }

    /** Copias desde Alma. $d: manual, simulacion, inicio, fin, estado, mensaje, resumen, ejecucion_id, proxima */
    private function armarCopiasAlma(object $tarea, array $d): bool
    {
        $estados = ['completada' => 'Completada', 'detenida' => 'Detenida', 'error' => 'Con errores'];
        $estado = ($estados[$d['estado']] ?? $d['estado']) . ($d['simulacion'] ? ' (simulación)' : '');
        $r = $d['resumen'];
        $filas = [
            'Tarea' => $tarea->nombre,
            'Estado' => $estado,
            'Ejecución' => $d['manual'] ? 'Manual (Ejecutar ahora)' : 'Programada',
            'Inicio' => $this->fecha($d['inicio']),
            'Fin' => $this->fecha($d['fin']),
        ];
        if ($d['mensaje']) {
            $filas['Observación'] = $d['mensaje'];
        }
        foreach (['consideradas' => 'Filas consideradas', 'actualizada' => 'Copias actualizadas', 'sin_cambios' => 'Sin cambios', 'eliminadas' => 'Eliminadas', 'a_electronico' => 'Pasan a electrónico', 'mms_corregido' => 'MMS corregidos', 'discrepancia' => 'Discrepancias', 'duplicada' => 'MMS repetido', 'revisar' => 'Para revisar', 'declaradas_sin_disponibles' => 'Declaradas sin disponibles'] as $clave => $texto) {
            if (isset($r[$clave])) {
                $filas[$texto] = (string) $r[$clave];
            }
        }
        $filas['Próxima ejecución'] = $d['proxima'] ? $this->fecha($d['proxima']) : 'No hay (la tarea no se repite o terminó)';

        return $this->enviarAviso($tarea, $estado, $filas, $this->url('tareas-programadas/ejecuciones/' . (int) $d['ejecucion_id']), 'Ver el detalle de la ejecución');
    }

    /** Aviso de reportes de cobertura. Nunca lanza errores: un fallo solo se registra. */
    public function coberturas(object $tarea, array $d): bool
    {
        try {
            return $this->armarCoberturas($tarea, $d);
        } catch (\Throwable $e) {
            error_log('NotificadorTareas: no se pudo preparar el aviso de la tarea ' . ($tarea->id ?? '?') . ': ' . $e->getMessage());

            return false;
        }
    }

    /** Aviso de copias desde Alma. Nunca lanza errores: un fallo solo se registra. */
    public function copiasAlma(object $tarea, array $d): bool
    {
        try {
            return $this->armarCopiasAlma($tarea, $d);
        } catch (\Throwable $e) {
            error_log('NotificadorTareas: no se pudo preparar el aviso de la tarea ' . ($tarea->id ?? '?') . ': ' . $e->getMessage());

            return false;
        }
    }

    /** Dirección absoluta del sistema, también desde el cron (sin depender de helpers.php). */
    private function url(string $ruta): string
    {
        if (function_exists('app_url')) {
            return app_url($ruta);
        }

        return rtrim((string) ($_ENV['APP_URL'] ?? ''), '/') . '/' . ltrim($ruta, '/');
    }

    private function enviarAviso(object $tarea, string $estado, array $filas, string $enlace, string $textoEnlace): bool
    {
        $para = trim((string) ($tarea->correo_notificacion ?? ''));
        if ($para === '') {
            return false;
        }
        $asunto = '[Biblioges] Tarea "' . $tarea->nombre . '": ' . $estado;
        $e = static fn ($v) => htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
        $html = '<p>Se ejecutó una tarea programada del Sistema de Bibliografía.</p><table cellpadding="4" style="border-collapse:collapse;font-family:Arial,sans-serif;font-size:14px">';
        $texto = "Se ejecutó una tarea programada del Sistema de Bibliografía.\n\n";
        foreach ($filas as $etiqueta => $valor) {
            $html .= '<tr><td style="border-bottom:1px solid #ddd"><strong>' . $e($etiqueta) . '</strong></td><td style="border-bottom:1px solid #ddd">' . nl2br($e($valor)) . '</td></tr>';
            $texto .= $etiqueta . ': ' . $valor . "\n";
        }
        $html .= '</table><p><a href="' . $e($enlace) . '">' . $e($textoEnlace) . '</a></p><p style="color:#777;font-size:12px">Para dejar de recibir este aviso, edite la tarea y deje vacío el correo.</p>';
        $texto .= "\n{$textoEnlace}: {$enlace}\n\nPara dejar de recibir este aviso, edite la tarea y deje vacío el correo.\n";

        return $this->enviar($para, $asunto, $html, $texto);
    }

    public function enviar(string $para, string $asunto, string $html, string $texto): bool
    {
        if ($this->transporte !== null) {
            ($this->transporte)(['para' => $para, 'asunto' => $asunto, 'html' => $html, 'texto' => $texto]);

            return true;
        }
        try {
            $env = static function (string $clave): string {
                $v = trim((string) ($_ENV[$clave] ?? ''));

                return strtolower($v) === 'null' ? '' : $v;
            };
            $remitente = $env('MAIL_FROM_ADDRESS');
            if (!filter_var($remitente, FILTER_VALIDATE_EMAIL)) {
                $remitente = $env('MAIL_USERNAME');
            }
            if (!filter_var($remitente, FILTER_VALIDATE_EMAIL)) {
                throw new \RuntimeException('falta configurar MAIL_FROM_ADDRESS en .env');
            }
            $correo = new PHPMailer(true);
            $correo->CharSet = PHPMailer::CHARSET_UTF8;
            $correo->Timeout = 20;
            $metodo = strtolower($env('MAIL_MAILER') ?: 'smtp');
            if ($metodo === 'smtp') {
                $correo->isSMTP();
                $correo->Host = $env('MAIL_HOST');
                $correo->Port = (int) ($env('MAIL_PORT') ?: 587);
                $cifrado = strtolower($env('MAIL_ENCRYPTION'));
                if (in_array($cifrado, ['tls', 'starttls'], true)) {
                    $correo->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                } elseif (in_array($cifrado, ['ssl', 'smtps'], true)) {
                    $correo->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                }
                if ($env('MAIL_USERNAME') !== '') {
                    $correo->SMTPAuth = true;
                    $correo->Username = $env('MAIL_USERNAME');
                    $correo->Password = (string) ($_ENV['MAIL_PASSWORD'] ?? '');
                }
            } elseif ($metodo === 'sendmail') {
                $correo->isSendmail();
            } else {
                $correo->isMail();
            }
            $correo->setFrom($remitente, $this->nombreRemitente($env));
            $correo->addAddress($para);
            $correo->Subject = $asunto;
            $correo->isHTML(true);
            $correo->Body = $html;
            $correo->AltBody = $texto;
            $correo->send();
            error_log('NotificadorTareas: aviso enviado a ' . $para . ' (' . $asunto . ')');

            return true;
        } catch (\Throwable $e) {
            error_log('NotificadorTareas: no se pudo enviar el aviso a ' . $para . ': ' . $e->getMessage());

            return false;
        }
    }

    /** MAIL_FROM_NAME, o APP_NAME, o "Biblioges"; ignora referencias sin resolver como ${APP_NAME}. */
    private function nombreRemitente(callable $env): string
    {
        foreach (['MAIL_FROM_NAME', 'APP_NAME'] as $clave) {
            $nombre = $env($clave);
            if ($nombre !== '' && strpos($nombre, '${') === false) {
                return $nombre;
            }
        }

        return 'Biblioges';
    }

    private function fecha(?string $valor): string
    {
        return $valor ? date('d/m/Y H:i', strtotime($valor)) : '-';
    }
}
