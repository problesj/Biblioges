<?php

namespace App\Core;

/**
 * Límite de intentos fallidos de inicio de sesión: 5 por correo e IP y 20 por IP en 15 minutos.
 * Se guarda en archivos en storage/framework/login_intentos (no requiere cambios en la base de datos).
 */
class LimiteIntentosLogin
{
    private const MAX_POR_CUENTA = 5;
    private const MAX_POR_IP = 20;
    private const VENTANA = 900;

    private string $dir;

    public function __construct(?string $dir = null)
    {
        $this->dir = $dir ?? dirname(__DIR__, 2) . '/storage/framework/login_intentos';
    }

    /** Segundos de bloqueo que quedan (0 = puede intentar). */
    public function bloqueo(string $email, string $ip): int
    {
        $ahora = time();
        $espera = 0;
        foreach ([[$this->clave('c', $email, $ip), self::MAX_POR_CUENTA], [$this->clave('i', '', $ip), self::MAX_POR_IP]] as [$clave, $limite]) {
            $fallos = $this->leer($clave, $ahora);
            if (count($fallos) >= $limite) {
                $espera = max($espera, min($fallos) + self::VENTANA - $ahora);
            }
        }

        return max(0, $espera);
    }

    public function registrarFallo(string $email, string $ip): void
    {
        $ahora = time();
        foreach ([$this->clave('c', $email, $ip), $this->clave('i', '', $ip)] as $clave) {
            $fallos = $this->leer($clave, $ahora);
            $fallos[] = $ahora;
            $this->escribir($clave, $fallos);
        }
    }

    public function limpiar(string $email, string $ip): void
    {
        $ruta = $this->ruta($this->clave('c', $email, $ip));
        if (is_file($ruta)) {
            @unlink($ruta);
        }
    }

    private function clave(string $tipo, string $email, string $ip): string
    {
        return $tipo . '_' . hash('sha256', mb_strtolower(trim($email)) . '|' . $ip);
    }

    private function ruta(string $clave): string
    {
        return $this->dir . '/' . $clave . '.json';
    }

    private function leer(string $clave, int $ahora): array
    {
        $ruta = $this->ruta($clave);
        if (!is_file($ruta)) {
            return [];
        }
        $datos = json_decode((string) @file_get_contents($ruta), true);
        if (!is_array($datos)) {
            return [];
        }

        return array_values(array_filter($datos, static fn ($t) => is_int($t) && $t > $ahora - self::VENTANA));
    }

    private function escribir(string $clave, array $fallos): void
    {
        if (!is_dir($this->dir) && !@mkdir($this->dir, 0770, true) && !is_dir($this->dir)) {
            error_log('Login: no se pudo crear ' . $this->dir);
            return;
        }
        @file_put_contents($this->ruta($clave), json_encode(array_slice($fallos, -50)), LOCK_EX);
    }
}
