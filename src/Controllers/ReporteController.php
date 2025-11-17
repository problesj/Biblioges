<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Illuminate\Database\Capsule\Manager as DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use src\Controllers\BaseController;
use App\Core\ListStateManager;
use App\Core\Session;
use PDO;
use PDOException;

class ReporteController extends BaseController
{
    protected $pdo;
    
    /**
     * Convierte valores especiales de ejemplares a números para la base de datos
     */
    private function convertirValorEspecialANumero($valor)
    {
        // Si ya es un número, devolverlo
        if (is_numeric($valor)) {
            return (int) $valor;
        }
        
        // Convertir strings especiales a números
        switch ($valor) {
            case 'Sin ejemplares impresos':
            case 'Sin ejemplares digitales':
                return -1;
            case 'Sin ejemplares disponibles':
                return -2;
            case 'Ilimitado':
                return 0;
            default:
                return 0;
        }
    }

    /**
     * Calcula ejemplares impresos y digitales para una asignatura según la nueva lógica especificada
     */
    private function calcularEjemplaresAsignatura($bibliografiaDetallada, $sedeId) {
        $titulosDeclarados = $bibliografiaDetallada->count();
        $titulosDisponibles = 0;
        $ejemplaresImpresos = 0;
        $ejemplaresDigitales = 0;
        $tieneEjemplaresDigitalesIlimitados = false;
        $tieneEjemplaresDigitalesDisponibles = false;
        $todasLasBibliografiasDeclaradasTienenDigitalesIlimitados = true;
        $totalBibliografiasDeclaradas = 0;
        
        // Si no hay bibliografías declaradas, asignar valores especiales
        if ($titulosDeclarados == 0) {
            return [
                'titulos_declarados' => 0,
                'titulos_disponibles' => 0,
                'ejemplares_impresos' => -2, // -2 indica "Sin información"
                'ejemplares_digitales' => -2, // -2 indica "Sin información"
                'cobertura_basica' => 0
            ];
        }
        
        foreach ($bibliografiaDetallada as $bibliografia) {
            $totalBibliografiasDeclaradas++;
            
            // Ejemplares impresos
            $ejemImp = DB::table('vw_bib_declarada_sede_noejem')
                ->where('id_bib_declarada', $bibliografia->id)
                ->where('id_sede', $sedeId)
                ->value('no_ejem_imp_sede') ?? 0;
            $ejemplaresImpresos += $ejemImp;
            
            // Ejemplares digitales
            $bibliografiasDigitales = DB::table('bibliografias_disponibles')
                ->where('bibliografia_declarada_id', $bibliografia->id)
                ->whereIn('disponibilidad', ['ambos', 'electronico'])
                ->get();
            
            if ($bibliografiasDigitales->isEmpty()) {
                // No hay bibliografías digitales disponibles para esta bibliografía declarada
                $ejemDig = -1; // -1 indica "Sin ejemplares digitales"
                $todasLasBibliografiasDeclaradasTienenDigitalesIlimitados = false;
            } else {
                $tieneEjemplaresDigitalesDisponibles = true;
                $ejemDig = $bibliografiasDigitales->pluck('ejemplares_digitales');
                
                // Verificar si alguna bibliografía tiene ejemplares ilimitados (0) o > 0
                if ($ejemDig->contains(0) || $ejemDig->sum() > 0) {
                    $tieneEjemplaresDigitalesIlimitados = true;
                }
                
                // Verificar si esta bibliografía declarada tiene ejemplares digitales ilimitados
                if (!$ejemDig->contains(0)) {
                    $todasLasBibliografiasDeclaradasTienenDigitalesIlimitados = false;
                }
                
                $ejemDig = $ejemDig->contains(0) ? 0 : $ejemDig->sum();
            }
            // Solo sumar valores positivos para evitar acumular indicadores negativos
            if ($ejemDig > 0) {
                $ejemplaresDigitales += $ejemDig;
            }
            
            // Disponibilidad
            $disponible = DB::table('bibliografias_disponibles')
                ->where('bibliografia_declarada_id', $bibliografia->id)
                ->where('estado', 1)
                ->where(function ($query) use ($sedeId) {
                    $query->whereIn('disponibilidad', ['electronico', 'ambos'])
                          ->orWhere(function ($q) use ($sedeId) {
                              $q->where('disponibilidad', 'impreso')
                                ->whereExists(function ($sub) use ($sedeId) {
                                    $sub->select(DB::raw(1))
                                        ->from('bibliografias_disponibles_sedes')
                                        ->whereRaw('bibliografias_disponibles_sedes.bibliografia_disponible_id = bibliografias_disponibles.id')
                                        ->where('bibliografias_disponibles_sedes.sede_id', $sedeId)
                                        ->where('bibliografias_disponibles_sedes.ejemplares', '>', 0);
                                });
                          });
                })
                ->exists();
            if ($disponible) {
                $titulosDisponibles++;
            }
        }
        
        // Aplicar valores especiales después del cálculo
        if ($ejemplaresImpresos == 0) {
            $ejemplaresImpresos = -1; // -1 indica "Sin ejemplares impresos"
        }
        
        // Si no hay títulos disponibles, asignar -2 para ambos
        if ($titulosDisponibles == 0) {
            $ejemplaresImpresos = -2; // -2 indica "Sin información"
            $ejemplaresDigitales = -2; // -2 indica "Sin información"
        } else {
            // Si hay títulos disponibles, verificar el estado de ejemplares digitales
            if ($tieneEjemplaresDigitalesDisponibles && $tieneEjemplaresDigitalesIlimitados) {
                // Si TODAS las bibliografías declaradas tienen ejemplares digitales ilimitados, mostrar "Ilimitado"
                if ($todasLasBibliografiasDeclaradasTienenDigitalesIlimitados && $totalBibliografiasDeclaradas > 0) {
                    $ejemplaresDigitales = 0; // 0 indica "Ilimitado"
                } else {
                    $ejemplaresDigitales = -3; // -3 indica "Ilimitado parcialmente"
                }
            } elseif (!$tieneEjemplaresDigitalesDisponibles) {
                $ejemplaresDigitales = -1; // -1 indica "Sin ejemplares digitales"
            }
        }
        
        $coberturaBasica = $titulosDeclarados > 0 ? round(($titulosDisponibles / $titulosDeclarados) * 100, 2) : 0;
        
        return [
            'titulos_declarados' => $titulosDeclarados,
            'titulos_disponibles' => $titulosDisponibles,
            'ejemplares_impresos' => $ejemplaresImpresos,
            'ejemplares_digitales' => $ejemplaresDigitales,
            'cobertura_basica' => $coberturaBasica
        ];
    }

    /**
     * Calcula la cobertura básica en tiempo real para una carrera específica
     */
    private function calcularCoberturaBasicaTiempoReal($codigoCarrera, $sedeId, $tiposFormacionFiltro = [])
    {
        // Obtener asignaturas regulares de la carrera
        $asignaturasRegulares = DB::table('vw_mallas')
            ->where('id_sede', $sedeId)
            ->where('codigo_carrera', $codigoCarrera)
            ->where('tipo_asignatura', 'REGULAR')
            ->select('codigo_asignatura as codigo')
            ->distinct()
            ->get();

        // Obtener asignaturas de formación si hay filtros aplicados
        $asignaturasFormacion = collect();
        if (!empty($tiposFormacionFiltro)) {
            $asignaturasFormacion = DB::table('vw_mallas')
                ->where('id_sede', $sedeId)
                ->where('codigo_carrera', $codigoCarrera)
                ->whereIn('tipo_asignatura', $tiposFormacionFiltro)
                ->whereNotNull('codigo_asignatura_formacion')
                ->select('codigo_asignatura_formacion as codigo')
                ->distinct()
                ->get();
        }

        // Combinar todas las asignaturas
        $asignaturas = $asignaturasRegulares->concat($asignaturasFormacion);

        if ($asignaturas->isEmpty()) {
            return 'Sin información';
        }

        // Obtener códigos de asignaturas
        $codigosAsignaturas = $asignaturas->pluck('codigo')->toArray();

        // Contar títulos declarados únicos
        $titulosDeclarados = DB::table('bibliografias_declaradas')
            ->join('asignaturas_bibliografias', 'bibliografias_declaradas.id', '=', 'asignaturas_bibliografias.bibliografia_id')
            ->join('asignaturas', 'asignaturas_bibliografias.asignatura_id', '=', 'asignaturas.id')
            ->join('asignaturas_departamentos', 'asignaturas.id', '=', 'asignaturas_departamentos.asignatura_id')
            ->whereIn('asignaturas_departamentos.codigo_asignatura', $codigosAsignaturas)
            ->where('asignaturas_bibliografias.tipo_bibliografia', 'basica')
            ->where('asignaturas_bibliografias.estado', 'activa')
            ->distinct('bibliografias_declaradas.id')
            ->count('bibliografias_declaradas.id');

        // Contar títulos disponibles únicos con lógica específica por sede
        $titulosDisponibles = DB::table('bibliografias_declaradas')
            ->join('asignaturas_bibliografias', 'bibliografias_declaradas.id', '=', 'asignaturas_bibliografias.bibliografia_id')
            ->join('asignaturas', 'asignaturas_bibliografias.asignatura_id', '=', 'asignaturas.id')
            ->join('asignaturas_departamentos', 'asignaturas.id', '=', 'asignaturas_departamentos.asignatura_id')
            ->whereIn('asignaturas_departamentos.codigo_asignatura', $codigosAsignaturas)
            ->where('asignaturas_bibliografias.tipo_bibliografia', 'basica')
            ->where('asignaturas_bibliografias.estado', 'activa')
            ->whereExists(function ($query) use ($sedeId) {
                $query->select(DB::raw(1))
                    ->from('bibliografias_disponibles')
                    ->whereRaw('bibliografias_disponibles.bibliografia_declarada_id = bibliografias_declaradas.id')
                    ->where('bibliografias_disponibles.estado', 1)
                    ->where(function ($subQuery) use ($sedeId) {
                        $subQuery->whereIn('bibliografias_disponibles.disponibilidad', ['electronico', 'ambos'])
                                ->orWhere(function ($q) use ($sedeId) {
                                    $q->where('bibliografias_disponibles.disponibilidad', 'impreso')
                                      ->whereExists(function ($sub) use ($sedeId) {
                                          $sub->select(DB::raw(1))
                                              ->from('bibliografias_disponibles_sedes')
                                              ->whereRaw('bibliografias_disponibles_sedes.bibliografia_disponible_id = bibliografias_disponibles.id')
                                              ->where('bibliografias_disponibles_sedes.sede_id', $sedeId)
                                              ->where('bibliografias_disponibles_sedes.ejemplares', '>', 0);
                                      });
                                });
                    });
            })
            ->distinct('bibliografias_declaradas.id')
            ->count('bibliografias_declaradas.id');

        // Calcular cobertura
        if ($titulosDeclarados > 0) {
            return round(($titulosDisponibles / $titulosDeclarados) * 100, 2);
        }

        return 0;
    }

    /**
     * Calcula la cobertura complementaria en tiempo real para una carrera específica
     */
    private function calcularCoberturaComplementariaTiempoReal($codigoCarrera, $sedeId, $tiposFormacionFiltro = [])
    {
        // Obtener asignaturas regulares de la carrera
        $asignaturasRegulares = DB::table('vw_mallas')
            ->where('id_sede', $sedeId)
            ->where('codigo_carrera', $codigoCarrera)
            ->where('tipo_asignatura', 'REGULAR')
            ->select('codigo_asignatura as codigo')
            ->distinct()
            ->get();

        // Obtener asignaturas de formación si hay filtros aplicados
        $asignaturasFormacion = collect();
        if (!empty($tiposFormacionFiltro)) {
            $asignaturasFormacion = DB::table('vw_mallas')
                ->where('id_sede', $sedeId)
                ->where('codigo_carrera', $codigoCarrera)
                ->whereIn('tipo_asignatura', $tiposFormacionFiltro)
                ->whereNotNull('codigo_asignatura_formacion')
                ->select('codigo_asignatura_formacion as codigo')
                ->distinct()
                ->get();
        }

        // Combinar todas las asignaturas
        $asignaturas = $asignaturasRegulares->concat($asignaturasFormacion);

        if ($asignaturas->isEmpty()) {
            return 'Sin información';
        }

        // Obtener códigos de asignaturas
        $codigosAsignaturas = $asignaturas->pluck('codigo')->toArray();

        // Contar títulos declarados únicos
        $titulosDeclarados = DB::table('bibliografias_declaradas')
            ->join('asignaturas_bibliografias', 'bibliografias_declaradas.id', '=', 'asignaturas_bibliografias.bibliografia_id')
            ->join('asignaturas', 'asignaturas_bibliografias.asignatura_id', '=', 'asignaturas.id')
            ->join('asignaturas_departamentos', 'asignaturas.id', '=', 'asignaturas_departamentos.asignatura_id')
            ->whereIn('asignaturas_departamentos.codigo_asignatura', $codigosAsignaturas)
            ->where('asignaturas_bibliografias.tipo_bibliografia', 'complementaria')
            ->where('asignaturas_bibliografias.estado', 'activa')
            ->distinct('bibliografias_declaradas.id')
            ->count('bibliografias_declaradas.id');

        // Contar títulos disponibles únicos con lógica específica por sede
        $titulosDisponibles = DB::table('bibliografias_declaradas')
            ->join('asignaturas_bibliografias', 'bibliografias_declaradas.id', '=', 'asignaturas_bibliografias.bibliografia_id')
            ->join('asignaturas', 'asignaturas_bibliografias.asignatura_id', '=', 'asignaturas.id')
            ->join('asignaturas_departamentos', 'asignaturas.id', '=', 'asignaturas_departamentos.asignatura_id')
            ->whereIn('asignaturas_departamentos.codigo_asignatura', $codigosAsignaturas)
            ->where('asignaturas_bibliografias.tipo_bibliografia', 'complementaria')
            ->where('asignaturas_bibliografias.estado', 'activa')
            ->whereExists(function ($query) use ($sedeId) {
                $query->select(DB::raw(1))
                    ->from('bibliografias_disponibles')
                    ->whereRaw('bibliografias_disponibles.bibliografia_declarada_id = bibliografias_declaradas.id')
                    ->where('bibliografias_disponibles.estado', 1)
                    ->where(function ($subQuery) use ($sedeId) {
                        $subQuery->whereIn('bibliografias_disponibles.disponibilidad', ['electronico', 'ambos'])
                                ->orWhere(function ($q) use ($sedeId) {
                                    $q->where('bibliografias_disponibles.disponibilidad', 'impreso')
                                      ->whereExists(function ($sub) use ($sedeId) {
                                          $sub->select(DB::raw(1))
                                              ->from('bibliografias_disponibles_sedes')
                                              ->whereRaw('bibliografias_disponibles_sedes.bibliografia_disponible_id = bibliografias_disponibles.id')
                                              ->where('bibliografias_disponibles_sedes.sede_id', $sedeId)
                                              ->where('bibliografias_disponibles_sedes.ejemplares', '>', 0);
                                      });
                                });
                    });
            })
            ->distinct('bibliografias_declaradas.id')
            ->count('bibliografias_declaradas.id');

        // Calcular cobertura
        if ($titulosDeclarados > 0) {
            return round(($titulosDisponibles / $titulosDeclarados) * 100, 2);
        }

        return 0;
    }

    /**
     * Calcula el total de ejemplares digitales considerando valores especiales
     */
    private function calcularTotalEjemplaresDigitales($items) {
        $tieneEjemplaresDigitalesIlimitados = false;
        $tieneEjemplaresDigitalesDisponibles = false;
        $tieneEjemplaresDigitalesLimitados = false;
        $tieneSinEjemplaresDigitales = false;
        $tieneSinInformacion = false;
        $totalEjemplaresLimitados = 0;
        $totalItems = 0;
        
        foreach ($items as $item) {
            // Manejar tanto objetos como arrays
            $ejemplaresDigitales = is_array($item) ? ($item['ejemplares_digitales'] ?? 0) : ($item->ejemplares_digitales ?? 0);
            $totalItems++;
            
            if ($ejemplaresDigitales == -2) {
                // Sin información
                $tieneSinInformacion = true;
            } elseif ($ejemplaresDigitales == -1) {
                // Sin ejemplares digitales
                $tieneSinEjemplaresDigitales = true;
            } elseif ($ejemplaresDigitales == -3) {
                // Ilimitado parcialmente
                $tieneEjemplaresDigitalesDisponibles = true;
                $tieneEjemplaresDigitalesIlimitados = true;
                $tieneEjemplaresDigitalesLimitados = true;
            } elseif ($ejemplaresDigitales == 0) {
                // Ilimitado
                $tieneEjemplaresDigitalesDisponibles = true;
                $tieneEjemplaresDigitalesIlimitados = true;
            } elseif ($ejemplaresDigitales > 0) {
                // Ejemplares limitados
                $tieneEjemplaresDigitalesDisponibles = true;
                $tieneEjemplaresDigitalesLimitados = true;
                $totalEjemplaresLimitados += $ejemplaresDigitales;
            }
        }
        
        // Determinar el valor final
        if (!$tieneEjemplaresDigitalesDisponibles) {
            if ($tieneSinInformacion) {
                return -2; // Sin información
            } else {
                return -1; // Sin ejemplares digitales
            }
        } elseif ($tieneEjemplaresDigitalesIlimitados && ($tieneEjemplaresDigitalesLimitados || $tieneSinEjemplaresDigitales || $tieneSinInformacion)) {
            return -3; // Ilimitado parcialmente
        } elseif ($tieneEjemplaresDigitalesIlimitados && !$tieneEjemplaresDigitalesLimitados && !$tieneSinEjemplaresDigitales && !$tieneSinInformacion) {
            return 0; // Ilimitado (solo si TODAS son ilimitadas)
        } else {
            return $totalEjemplaresLimitados; // Total de ejemplares limitados
        }
    }

    /**
     * Convierte valores especiales de ejemplares a texto legible para exportación
     */
    private function convertirValorEspecial($valor, $tipo = 'digitales', $titulosDisponibles = 0) {
        if ($valor == -2) {
            return 'Sin información';
        } elseif ($valor == -3) {
            return 'Ilimitado parcialmente';
        } elseif ($valor == -1) {
            return $tipo == 'digitales' ? 'Sin ejemplares digitales' : 'Sin ejemplares impresos';
        } elseif ($valor == 0 && $titulosDisponibles > 0) {
            return 'Ilimitado';
        } else {
            return $valor;
        }
    }

    /**
     * Calcula ejemplares para reporte expandido usando la misma lógica que el reporte web
     */
    private function calcularEjemplaresExpandido($bibliografiaId, $sedeId) {
        // Obtener bibliografías disponibles para esta bibliografía declarada
        $bibliografiasDisponibles = DB::table("bibliografias_disponibles")
            ->where("bibliografia_declarada_id", $bibliografiaId)
            ->where("estado", 1)
            ->select("disponibilidad", "ejemplares_digitales")
            ->get();

        // Usar la nueva lógica para calcular ejemplares
        $resultado = $this->calcularEjemplaresNuevaLogica($bibliografiaId, $sedeId, $bibliografiasDisponibles);
        
        return [
            'ejemplares_impresos' => $resultado["ejemplares_impresos"],
            'ejemplares_digitales' => $resultado["ejemplares_digitales"],
            'disponible' => $resultado["disponible"]
        ];
    }

    /**
     * Calcula ejemplares impresos y digitales según la nueva lógica especificada
     */
    private function calcularEjemplaresNuevaLogica($bibliografiaId, $sedeId, $bibliografiasDisponibles) {
        $ejemplaresImpresos = 0;
        $ejemplaresDigitales = 0;
        $disponible = false;
        $tieneEjemplaresDigitalesIlimitados = false;
        $tieneEjemplaresDigitalesDisponibles = false;
        
        // Si no hay bibliografías disponibles, no está disponible
        if ($bibliografiasDisponibles->isEmpty()) {
            return [
                'ejemplares_impresos' => -2, // -2 indica "Sin información"
                'ejemplares_digitales' => -2, // -2 indica "Sin información"
                'disponible' => false
            ];
        }
        
        // Calcular ejemplares impresos: sumar bibliografías con disponibilidad "impreso" y "ambos"
        $bibliografiasImpresas = $bibliografiasDisponibles->whereIn('disponibilidad', ['impreso', 'ambos']);
        if ($bibliografiasImpresas->isNotEmpty()) {
            // Obtener ejemplares impresos de la bibliografía declarada para la sede
            $ejemplaresImpresos = DB::table('vw_bib_declarada_sede_noejem')
                ->where('id_bib_declarada', $bibliografiaId)
                ->where('id_sede', $sedeId)
                ->value('no_ejem_imp_sede') ?? 0;
        }
        
        // Calcular ejemplares digitales: considerar bibliografías con disponibilidad "ambos" y "electronico"
        $bibliografiasDigitales = $bibliografiasDisponibles->whereIn('disponibilidad', ['ambos', 'electronico']);
        
        if ($bibliografiasDigitales->isNotEmpty()) {
            $tieneEjemplaresDigitalesDisponibles = true;
            
            // Verificar si alguna bibliografía digital tiene ejemplares_digitales = 0 (ilimitado) o > 0
            $ejemplaresDigitalesValues = $bibliografiasDigitales->pluck('ejemplares_digitales');
            if ($ejemplaresDigitalesValues->contains(0) || $ejemplaresDigitalesValues->sum() > 0) {
                $tieneEjemplaresDigitalesIlimitados = true;
            }
            
            // Verificar si alguna bibliografía digital tiene ejemplares_digitales = 0 (ilimitado)
            $tieneIlimitado = $bibliografiasDigitales->where('ejemplares_digitales', 0)->isNotEmpty();
            
            if ($tieneIlimitado) {
                $ejemplaresDigitales = 0; // 0 indica "Ilimitado"
            } else {
                // Sumar ejemplares digitales de las bibliografías con ejemplares específicos
                $ejemplaresDigitales = $bibliografiasDigitales->where('ejemplares_digitales', '>', 0)->sum('ejemplares_digitales');
            }
        }
        
        // Determinar disponibilidad
        // Solo está disponible si tiene ejemplares impresos en la sede O ejemplares digitales disponibles
        $disponible = $ejemplaresImpresos > 0 || ($tieneEjemplaresDigitalesDisponibles && ($ejemplaresDigitales > 0 || $ejemplaresDigitales == 0));
        
        // Aplicar valores especiales para mostrar en la interfaz
        if ($ejemplaresImpresos == 0) {
            $ejemplaresImpresos = -1; // -1 indica "Sin ejemplares impresos"
        }
        
        // Aplicar lógica para ejemplares digitales
        if (!$tieneEjemplaresDigitalesDisponibles) {
            $ejemplaresDigitales = -1; // -1 indica "Sin ejemplares digitales"
        } elseif ($tieneEjemplaresDigitalesDisponibles && $tieneEjemplaresDigitalesIlimitados) {
            // Si hay ejemplares digitales disponibles e ilimitados, verificar si es parcialmente ilimitado
            $tieneIlimitado = $bibliografiasDigitales->where('ejemplares_digitales', 0)->isNotEmpty();
            $tieneLimitado = $bibliografiasDigitales->where('ejemplares_digitales', '>', 0)->isNotEmpty();
            
            if ($tieneIlimitado && $tieneLimitado) {
                $ejemplaresDigitales = -3; // -3 indica "Ilimitado parcialmente"
            } else if ($tieneIlimitado && !$tieneLimitado) {
                $ejemplaresDigitales = 0; // 0 indica "Ilimitado"
            }
            // Si solo tiene limitados, mantener el valor calculado anteriormente
        }
        
        return [
            'ejemplares_impresos' => $ejemplaresImpresos,
            'ejemplares_digitales' => $ejemplaresDigitales,
            'disponible' => $disponible
        ];
    }

    public function __construct()
    {
        global $twig;
        parent::__construct($twig, new \Slim\Psr7\Response());
        
        // Configuración de la base de datos
        $dbConfig = [
            'host' => $_ENV['DB_HOST'] ?? 'localhost',
            'port' => $_ENV['DB_PORT'] ?? '3306',
            'dbname' => $_ENV['DB_DATABASE'] ?? 'biblioges',
            'user' => $_ENV['DB_USERNAME'] ?? 'root',
            'password' => $_ENV['DB_PASSWORD'] ?? ''
        ];

        try {
            $dsn = "mysql:host={$dbConfig['host']};port={$dbConfig['port']};dbname={$dbConfig['dbname']};charset=utf8mb4";
            $this->pdo = new PDO($dsn, $dbConfig['user'], $dbConfig['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
            ]);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    public function coberturaAsignatura(Request $request, Response $response, array $args): Response
    {
        $codigo = $args['codigo'];
        
        // Obtener total de bibliografías declaradas ÚNICAS (sin duplicados)
        $totalBibliografias = DB::table('bibliografias_declaradas')
            ->join('asignaturas_bibliografias', 'bibliografias_declaradas.id', '=', 'asignaturas_bibliografias.bibliografia_id')
            ->join('asignaturas', 'asignaturas_bibliografias.asignatura_id', '=', 'asignaturas.id')
            ->where('asignaturas.codigo', $codigo)
            ->distinct('bibliografias_declaradas.id')
            ->count('bibliografias_declaradas.id');
            
        // Obtener bibliografías disponibles ÚNICAS (sin duplicados)
        $bibliografiasDisponibles = DB::table('bibliografias_declaradas')
            ->join('asignaturas_bibliografias', 'bibliografias_declaradas.id', '=', 'asignaturas_bibliografias.bibliografia_id')
            ->join('asignaturas', 'asignaturas_bibliografias.asignatura_id', '=', 'asignaturas.id')
            ->where('asignaturas.codigo', $codigo)
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('bibliografias_disponibles')
                    ->whereRaw('bibliografias_disponibles.bibliografia_declarada_id = bibliografias_declaradas.id')
                    ->where('bibliografias_disponibles.estado', 1)
                    ->where(function ($subQuery) {
                        $subQuery->whereIn('bibliografias_disponibles.disponibilidad', ['electronico', 'ambos'])
                                ->orWhere(function ($q) {
                                    $q->where('bibliografias_disponibles.disponibilidad', 'impreso')
                                      ->whereExists(function ($sub) {
                                          $sub->select(DB::raw(1))
                                              ->from('bibliografias_disponibles_sedes')
                                              ->whereRaw('bibliografias_disponibles_sedes.bibliografia_disponible_id = bibliografias_disponibles.id')
                                              ->where('bibliografias_disponibles_sedes.ejemplares', '>', 0);
                                      });
                                });
                    });
            })
            ->distinct('bibliografias_declaradas.id')
            ->count('bibliografias_declaradas.id');
            
        // Calcular cobertura
        $cobertura = $totalBibliografias > 0 
            ? ($bibliografiasDisponibles / $totalBibliografias) * 100 
            : 0;
            
        $response->getBody()->write(json_encode([
            'asignatura_codigo' => $codigo,
            'total_bibliografias' => $totalBibliografias,
            'bibliografias_disponibles' => $bibliografiasDisponibles,
            'cobertura' => round($cobertura, 2) . '%'
        ]));
        
        return $response->withHeader('Content-Type', 'application/json');
    }
    
    public function coberturaCarrera(Request $request, Response $response, array $args): Response
    {
        $carreraId = $args['id'];
        $excluirFormacionGeneral = $request->getQueryParams()['excluir_formacion_general'] ?? false;
        
        // Obtener asignaturas de la carrera
        $query = DB::table('carrera_asignatura')
            ->join('asignaturas', 'carrera_asignatura.asignatura_codigo', '=', 'asignaturas.codigo')
            ->where('carrera_asignatura.carrera_id', $carreraId);
            
        if ($excluirFormacionGeneral) {
            $query->join('tipos_asignaturas', 'asignaturas.tipo_id', '=', 'tipos_asignaturas.id')
                ->where('tipos_asignaturas.nombre', '!=', 'FORMACIÓN GENERAL');
        }
        
        $asignaturas = $query->pluck('asignaturas.codigo')->toArray();
        
        // Obtener total de bibliografías declaradas ÚNICAS (sin duplicados)
        $totalBibliografias = DB::table('bibliografias_declaradas')
            ->join('asignaturas_bibliografias', 'bibliografias_declaradas.id', '=', 'asignaturas_bibliografias.bibliografia_id')
            ->join('asignaturas', 'asignaturas_bibliografias.asignatura_id', '=', 'asignaturas.id')
            ->whereIn('asignaturas.codigo', $asignaturas)
            ->distinct('bibliografias_declaradas.id')
            ->count('bibliografias_declaradas.id');
            
        // Obtener bibliografías disponibles ÚNICAS (sin duplicados)
        $bibliografiasDisponibles = DB::table('bibliografias_declaradas')
            ->join('asignaturas_bibliografias', 'bibliografias_declaradas.id', '=', 'asignaturas_bibliografias.bibliografia_id')
            ->join('asignaturas', 'asignaturas_bibliografias.asignatura_id', '=', 'asignaturas.id')
            ->whereIn('asignaturas.codigo', $asignaturas)
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('bibliografias_disponibles')
                    ->whereRaw('bibliografias_disponibles.bibliografia_declarada_id = bibliografias_declaradas.id')
                    ->where('bibliografias_disponibles.estado', 1)
                    ->where(function ($subQuery) {
                        $subQuery->whereIn('bibliografias_disponibles.disponibilidad', ['electronico', 'ambos'])
                                ->orWhere(function ($q) {
                                    $q->where('bibliografias_disponibles.disponibilidad', 'impreso')
                                      ->whereExists(function ($sub) {
                                          $sub->select(DB::raw(1))
                                              ->from('bibliografias_disponibles_sedes')
                                              ->whereRaw('bibliografias_disponibles_sedes.bibliografia_disponible_id = bibliografias_disponibles.id')
                                              ->where('bibliografias_disponibles_sedes.ejemplares', '>', 0);
                                      });
                                });
                    });
            })
            ->distinct('bibliografias_declaradas.id')
            ->count('bibliografias_declaradas.id');
            
        // Calcular cobertura
        $cobertura = $totalBibliografias > 0 
            ? ($bibliografiasDisponibles / $totalBibliografias) * 100 
            : 0;
            
        $response->getBody()->write(json_encode([
            'carrera_id' => $carreraId,
            'total_bibliografias' => $totalBibliografias,
            'bibliografias_disponibles' => $bibliografiasDisponibles,
            'cobertura' => round($cobertura, 2) . '%',
            'excluir_formacion_general' => $excluirFormacionGeneral
        ]));
        
        return $response->withHeader('Content-Type', 'application/json');
    }
    
    public function cobertura(Request $request, Response $response, array $args): Response
    {
        // Obtener todas las carreras para el formulario
        $carreras = DB::table('carreras')->get();
        
        global $twig;
        $html = $twig->render('reportes/coberturas/index.twig', [
            'carreras' => $carreras
        ]);
        
        $response->getBody()->write($html);
        return $response->withHeader('Content-Type', 'text/html');
    }

    public function clearState(Request $request, Response $response, array $args): Response
    {
        try {
            // Verificar autenticación
            if (!isset($_SESSION['user_id'])) {
                if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                    header('Content-Type: application/json');
                    echo json_encode([
                        'success' => false,
                        'message' => 'Por favor inicie sesión para acceder a los reportes',
                        'redirect' => '/login'
                    ]);
                    return $response;
                }
                
                $_SESSION['error'] = 'Por favor inicie sesión para acceder a los reportes';
                header('Location: /login');
                exit;
            }

            // Limpiar el estado del listado
            $session = new Session();
            $stateManager = new ListStateManager($session, 'reporte_coberturas');
            $stateManager->clearState();

            return $response
                ->withHeader('Location', '/reportes/coberturas')
                ->withStatus(302);

        } catch (\Exception $e) {
            error_log("Error en ReporteController@clearState: " . $e->getMessage());
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(500)
                ->withBody($response->getBody()->write(json_encode([
                    'success' => false,
                    'message' => 'Error al limpiar los filtros: ' . $e->getMessage()
                ])));
        }
    }

    public function clearStateBibliografias(Request $request, Response $response, array $args): Response
    {
        try {
            // Verificar autenticación
            if (!isset($_SESSION['user_id'])) {
                if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                    header('Content-Type: application/json');
                    echo json_encode([
                        'success' => false,
                        'message' => 'Por favor inicie sesión para acceder a los reportes',
                        'redirect' => '/login'
                    ]);
                    return $response;
                }
                
                $_SESSION['error'] = 'Por favor inicie sesión para acceder a los reportes';
                header('Location: /login');
                exit;
            }

            // Limpiar el estado del listado
            $session = new Session();
            $stateManager = new ListStateManager($session, 'reporte_bibliografias');
            $stateManager->clearState();

            return $response
                ->withHeader('Location', '/biblioges/reportes/listado-bibliografias')
                ->withStatus(302);

        } catch (\Exception $e) {
            error_log("Error en ReporteController@clearStateBibliografias: " . $e->getMessage());
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(500)
                ->withBody($response->getBody()->write(json_encode([
                    'success' => false,
                    'message' => 'Error al limpiar los filtros: ' . $e->getMessage()
                ])));
        }
    }
    
    public function getAsignaturasFormacion(Request $request, Response $response, array $args): Response
    {
        $carreraId = $args['carreraId'];
        
        $asignaturas = DB::table('carrera_asignatura')
            ->join('asignaturas', 'carrera_asignatura.asignatura_codigo', '=', 'asignaturas.codigo')
            ->where('carrera_asignatura.carrera_id', $carreraId)
            ->select('asignaturas.codigo as id', 'asignaturas.nombre')
            ->get();
            
        $response->getBody()->write(json_encode($asignaturas));
        return $response->withHeader('Content-Type', 'application/json');
    }
    
    public function generarReporteCobertura(Request $request, Response $response, array $args): Response
    {
        // Implementación básica para generar reporte
        $response->getBody()->write(json_encode([
            'success' => true,
            'message' => 'Reporte generado correctamente'
        ]));
        
        return $response->withHeader('Content-Type', 'application/json');
    }
    
    public function bibliografias(Request $request, Response $response, array $args): Response
    {
        $view = new \Twig\Environment(new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../templates'));
        $template = $view->load('reportes/bibliografias.twig');
        
        $response->getBody()->write($template->render([]));
        return $response->withHeader('Content-Type', 'text/html');
    }
    
    public function ejemplares(Request $request, Response $response, array $args): Response
    {
        $view = new \Twig\Environment(new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../templates'));
        $template = $view->load('reportes/ejemplares.twig');
        
        $response->getBody()->write($template->render([]));
        return $response->withHeader('Content-Type', 'text/html');
    }
    
    public function estudiantes(Request $request, Response $response, array $args): Response
    {
        $view = new \Twig\Environment(new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../templates'));
        $template = $view->load('reportes/estudiantes.twig');
        
        $response->getBody()->write($template->render([]));
        return $response->withHeader('Content-Type', 'text/html');
    }
    
    public function profesores(Request $request, Response $response, array $args): Response
    {
        $view = new \Twig\Environment(new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../templates'));
        $template = $view->load('reportes/profesores.twig');
        
        $response->getBody()->write($template->render([]));
        return $response->withHeader('Content-Type', 'text/html');
    }
    
    public function asignaturas(Request $request, Response $response, array $args): Response
    {
        $view = new \Twig\Environment(new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../templates'));
        $template = $view->load('reportes/asignaturas.twig');
        
        $response->getBody()->write($template->render([]));
        return $response->withHeader('Content-Type', 'text/html');
    }
    
    public function carreras(Request $request, Response $response, array $args): Response
    {
        $view = new \Twig\Environment(new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../templates'));
        $template = $view->load('reportes/carreras.twig');
        
        $response->getBody()->write($template->render([]));
        return $response->withHeader('Content-Type', 'text/html');
    }
    
    public function autores(Request $request, Response $response, array $args): Response
    {
        $view = new \Twig\Environment(new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../templates'));
        $template = $view->load('reportes/autores.twig');
        
        $response->getBody()->write($template->render([]));
        return $response->withHeader('Content-Type', 'text/html');
    }

    public function bibliografiasDeclaradas(Request $request, Response $response, array $args): Response
    {
        error_log('ReporteController@bibliografiasDeclaradas: Iniciando método');
        
        // Obtener datos de sesión
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $sessionData = [
            'user_id' => $_SESSION['user_id'] ?? null,
            'user_email' => $_SESSION['user_email'] ?? null,
            'user_nombre' => $_SESSION['user_nombre'] ?? null,
            'user_rol' => $_SESSION['user_rol'] ?? null
        ];
        
        // Inicializar el gestor de estado del listado
        $session = new Session();
        $stateManager = new ListStateManager($session, 'reporte_bibliografias');
        
        // Obtener parámetros de la URL
        $urlParams = $_GET;
        
        // Obtener estado (combinando sesión y URL)
        $state = $stateManager->getState($urlParams);
        
        // Guardar estado en sesión
        $stateManager->saveState($state);
        
        // Extraer parámetros del estado
        $page = $state['page'];
        $perPage = $state['per_page'];
        $sortColumn = $state['sort'];
        $sortDirection = $state['direction'];
        $allowedPerPage = [5, 10, 15, 20];
        $allowedColumns = ['titulo', 'autores', 'anio_publicacion', 'editorial', 'tipo', 'estado', 'num_asignaturas', 'num_bibliografias_disponibles', 'tipos_bibliografias'];
        
        $offset = ($page - 1) * $perPage;

        // Obtener filtros del estado
        $busqueda = $state['busqueda'] ?? null;
        $tipoBusqueda = $state['tipo_busqueda'] ?? 'todos';
        $estado = $state['estado'] ?? null;
        $tipo = $state['tipo'] ?? null;
        $tipoBibliografia = $state['tipo_bibliografia'] ?? null;
        $bibliografiasDisponibles = $state['bibliografias_disponibles'] ?? null;
        $carreraId = !empty($state['carrera_id']) ? (int)$state['carrera_id'] : null;
        
        // Obtener lista de carreras para el dropdown
        $carrerasSql = "SELECT id, nombre FROM carreras WHERE estado = 1 ORDER BY nombre";
        $carrerasStmt = $this->pdo->prepare($carrerasSql);
        $carrerasStmt->execute();
        $carreras = $carrerasStmt->fetchAll(\PDO::FETCH_ASSOC);
        
        // Validar dirección de ordenamiento
        if (!in_array($sortDirection, ['ASC', 'DESC'])) {
            $sortDirection = 'ASC';
        }
        
        // Construir la consulta base para contar total de registros
        $countSql = "SELECT COUNT(DISTINCT bd.id) as total
        FROM bibliografias_declaradas bd
        LEFT JOIN bibliografias_autores ba ON bd.id = ba.bibliografia_id
        LEFT JOIN autores a ON ba.autor_id = a.id
        LEFT JOIN asignaturas_bibliografias ab ON bd.id = ab.bibliografia_id
        LEFT JOIN bibliografias_disponibles bdis ON bd.id = bdis.bibliografia_declarada_id
        WHERE 1=1";
        
        // Construir la consulta principal
        $sql = "SELECT 
                bd.id,
                bd.titulo,
                bd.tipo,
                bd.anio_publicacion,
                bd.editorial,
                bd.estado,
                GROUP_CONCAT(DISTINCT CONCAT(a.apellidos, ', ', a.nombres) SEPARATOR '; ') as autores,
                COUNT(DISTINCT ab.asignatura_id) as num_asignaturas,
                COUNT(DISTINCT bdis.id) as num_bibliografias_disponibles,
                GROUP_CONCAT(DISTINCT ab.tipo_bibliografia SEPARATOR ', ') as tipos_bibliografias
        FROM bibliografias_declaradas bd
        LEFT JOIN bibliografias_autores ba ON bd.id = ba.bibliografia_id
        LEFT JOIN autores a ON ba.autor_id = a.id
        LEFT JOIN asignaturas_bibliografias ab ON bd.id = ab.bibliografia_id
        LEFT JOIN bibliografias_disponibles bdis ON bd.id = bdis.bibliografia_declarada_id
        WHERE 1=1";
        
        $params = [];
        
        // Aplicar filtros si existen
        if (!empty($busqueda)) {
            if ($tipoBusqueda === 'titulo') {
                $sql .= " AND bd.titulo LIKE ?";
                $countSql .= " AND bd.titulo LIKE ?";
                $params[] = '%' . $busqueda . '%';
            } elseif ($tipoBusqueda === 'autor') {
                $sql .= " AND (a.apellidos LIKE ? OR a.nombres LIKE ?)";
                $countSql .= " AND (a.apellidos LIKE ? OR a.nombres LIKE ?)";
                $params[] = '%' . $busqueda . '%';
                $params[] = '%' . $busqueda . '%';
            } elseif ($tipoBusqueda === 'editorial') {
                $sql .= " AND bd.editorial LIKE ?";
                $countSql .= " AND bd.editorial LIKE ?";
                $params[] = '%' . $busqueda . '%';
            } elseif ($tipoBusqueda === 'asignatura') {
                $sql .= " AND EXISTS (SELECT 1 FROM asignaturas_bibliografias ab2 JOIN asignaturas asig ON ab2.asignatura_id = asig.id WHERE ab2.bibliografia_id = bd.id AND asig.nombre LIKE ?)";
                $countSql .= " AND EXISTS (SELECT 1 FROM asignaturas_bibliografias ab2 JOIN asignaturas asig ON ab2.asignatura_id = asig.id WHERE ab2.bibliografia_id = bd.id AND asig.nombre LIKE ?)";
                $params[] = '%' . $busqueda . '%';
            } else {
                // Búsqueda general
                $sql .= " AND (bd.titulo LIKE ? OR bd.editorial LIKE ? OR a.apellidos LIKE ? OR a.nombres LIKE ?)";
                $countSql .= " AND (bd.titulo LIKE ? OR bd.editorial LIKE ? OR a.apellidos LIKE ? OR a.nombres LIKE ?)";
                $params[] = '%' . $busqueda . '%';
                $params[] = '%' . $busqueda . '%';
                $params[] = '%' . $busqueda . '%';
                $params[] = '%' . $busqueda . '%';
            }
        }
        
        if (!empty($tipo)) {
            $sql .= " AND bd.tipo = ?";
            $countSql .= " AND bd.tipo = ?";
            $params[] = $tipo;
        }
        
        if ($estado !== null && $estado !== '') {
            $sql .= " AND bd.estado = ?";
            $countSql .= " AND bd.estado = ?";
            $params[] = $estado;
        }
        
        if (!empty($tipoBibliografia)) {
            $sql .= " AND EXISTS (SELECT 1 FROM asignaturas_bibliografias ab2 WHERE ab2.bibliografia_id = bd.id AND ab2.tipo_bibliografia = ?)";
            $countSql .= " AND EXISTS (SELECT 1 FROM asignaturas_bibliografias ab2 WHERE ab2.bibliografia_id = bd.id AND ab2.tipo_bibliografia = ?)";
            $params[] = $tipoBibliografia;
        }
        
        if (!empty($bibliografiasDisponibles)) {
            if ($bibliografiasDisponibles === 'con_disponibles') {
                $sql .= " AND EXISTS (SELECT 1 FROM bibliografias_disponibles bdis2 WHERE bdis2.bibliografia_declarada_id = bd.id)";
                $countSql .= " AND EXISTS (SELECT 1 FROM bibliografias_disponibles bdis2 WHERE bdis2.bibliografia_declarada_id = bd.id)";
            } elseif ($bibliografiasDisponibles === 'sin_disponibles') {
                $sql .= " AND NOT EXISTS (SELECT 1 FROM bibliografias_disponibles bdis2 WHERE bdis2.bibliografia_declarada_id = bd.id)";
                $countSql .= " AND NOT EXISTS (SELECT 1 FROM bibliografias_disponibles bdis2 WHERE bdis2.bibliografia_declarada_id = bd.id)";
            }
        }
        
        // Filtro por carrera: filtrar bibliografías asociadas a asignaturas de la carrera seleccionada
        if ($carreraId !== null && $carreraId > 0) {
            $carreraFilterSql = " AND EXISTS (
                SELECT 1 
                FROM asignaturas_bibliografias ab3
                INNER JOIN mallas m ON ab3.asignatura_id = m.asignatura_id
                WHERE ab3.bibliografia_id = bd.id 
                AND m.carrera_id = ?
            )";
            $sql .= $carreraFilterSql;
            $countSql .= $carreraFilterSql;
            $params[] = $carreraId;
        }
        
        // Agregar GROUP BY para la consulta principal
        $sql .= " GROUP BY bd.id, bd.titulo, bd.tipo, bd.anio_publicacion, bd.editorial, bd.estado";
        
        // Obtener total de registros
        $stmt = $this->pdo->prepare($countSql);
        $stmt->execute($params);
        $totalRecords = $stmt->fetch()['total'];
        
        // Calcular información de paginación
        $totalPages = ceil($totalRecords / $perPage);
        $currentPage = $page;
        
        // Agregar ORDER BY y LIMIT a la consulta principal
        $sql .= " ORDER BY {$sortColumn} {$sortDirection} LIMIT {$perPage} OFFSET {$offset}";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $bibliografias = $stmt->fetchAll(\PDO::FETCH_OBJ);
        
        error_log('ReporteController@bibliografiasDeclaradas: Total bibliografías encontradas: ' . count($bibliografias));

        global $twig;
        $html = $twig->render('reportes/bibliografias_declaradas/index.twig', [
            'bibliografias' => $bibliografias,
            'session' => $sessionData,
            'app_url' => app_url(),
            'current_page' => 'listado-bibliografias',
            'carreras' => $carreras,
            'filtros' => [
                'busqueda' => $busqueda ?? '',
                'tipo_busqueda' => $tipoBusqueda ?? 'todos',
                'estado' => $estado ?? '',
                'tipo' => $tipo ?? '',
                'tipo_bibliografia' => $tipoBibliografia ?? '',
                'bibliografias_disponibles' => $bibliografiasDisponibles ?? '',
                'carrera_id' => $carreraId ? (string)$carreraId : ''
            ],
            'paginacion' => [
                'current_page' => $page,
                'per_page' => $perPage,
                'total_records' => $totalRecords,
                'total_pages' => $totalPages,
                'has_previous' => $page > 1,
                'has_next' => $page < $totalPages,
                'previous_page' => $page - 1,
                'next_page' => $page + 1,
                'allowed_per_page' => $allowedPerPage
            ],
            'ordenamiento' => [
                'column' => $sortColumn,
                'direction' => $sortDirection
            ],
            'stateManager' => $stateManager
        ]);
        
        error_log('ReporteController@bibliografiasDeclaradas: Vista renderizada correctamente');
        $response->getBody()->write($html);
        return $response->withHeader('Content-Type', 'text/html');
    }

    public function getBibliografiasDeclaradas(Request $request, Response $response, array $args): Response
    {
        $params = $request->getQueryParams();
        
        $page = isset($params['page']) ? (int)$params['page'] : 1;
        $limit = isset($params['length']) ? (int)$params['length'] : 10;
        $start = ($page - 1) * $limit;
        
        $search = $params['search']['value'] ?? '';
        $titulo = $params['titulo'] ?? '';
        $autor = $params['autor'] ?? '';
        $editorial = $params['editorial'] ?? '';
        $estado = $params['estado'] ?? '';
        $tipo = $params['tipo'] ?? '';
        $tipoBibliografia = $params['tipo_bibliografia'] ?? '';
        $bibliografiasDisponibles = $params['bibliografias_disponibles'] ?? '';
        
        $query = DB::table('bibliografias_declaradas as bd')
            ->select([
                'bd.id',
                'bd.titulo',
                'bd.tipo',
                'bd.anio_publicacion',
                'bd.editorial',
                'bd.estado',
                DB::raw('GROUP_CONCAT(DISTINCT CONCAT(a.apellidos, ", ", a.nombres) SEPARATOR "; ") as autores'),
                DB::raw('COUNT(DISTINCT ab.asignatura_id) as num_asignaturas'),
                DB::raw('COUNT(DISTINCT bdis.id) as num_bibliografias_disponibles'),
                DB::raw('GROUP_CONCAT(DISTINCT ab.tipo_bibliografia SEPARATOR ", ") as tipos_bibliografias')
            ])
            ->leftJoin('bibliografias_autores as ba', 'bd.id', '=', 'ba.bibliografia_id')
            ->leftJoin('autores as a', 'ba.autor_id', '=', 'a.id')
            ->leftJoin('asignaturas_bibliografias as ab', 'bd.id', '=', 'ab.bibliografia_id')
            ->leftJoin('bibliografias_disponibles as bdis', 'bd.id', '=', 'bdis.bibliografia_declarada_id')
            ->groupBy('bd.id', 'bd.titulo', 'bd.tipo', 'bd.anio_publicacion', 'bd.editorial', 'bd.estado');
        
        // Aplicar filtros
        if (!empty($titulo)) {
            $query->where('bd.titulo', 'LIKE', '%' . $titulo . '%');
        }
        
        if (!empty($autor)) {
            $query->where(function($q) use ($autor) {
                $q->where('a.apellidos', 'LIKE', '%' . $autor . '%')
                  ->orWhere('a.nombres', 'LIKE', '%' . $autor . '%');
            });
        }
        
        if (!empty($editorial)) {
            $query->where('bd.editorial', 'LIKE', '%' . $editorial . '%');
        }
        
        if (!empty($estado)) {
            $query->where('bd.estado', $estado);
        }
        
        if (!empty($tipo)) {
            $query->where('bd.tipo', $tipo);
        }
        
        // Filtro por tipo de bibliografía
        if (!empty($tipoBibliografia)) {
            $query->whereExists(function($q) use ($tipoBibliografia) {
                $q->select(DB::raw(1))
                  ->from('asignaturas_bibliografias')
                  ->whereRaw('asignaturas_bibliografias.bibliografia_id = bd.id')
                  ->where('asignaturas_bibliografias.tipo_bibliografia', $tipoBibliografia);
            });
        }
        
        if (!empty($bibliografiasDisponibles)) {
            if ($bibliografiasDisponibles === 'con_disponibles') {
                $query->having('num_bibliografias_disponibles', '>', 0);
            } elseif ($bibliografiasDisponibles === 'sin_disponibles') {
                $query->having('num_bibliografias_disponibles', '=', 0);
            }
        }
        
        // Búsqueda general
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('bd.titulo', 'LIKE', '%' . $search . '%')
                  ->orWhere('a.apellidos', 'LIKE', '%' . $search . '%')
                  ->orWhere('a.nombres', 'LIKE', '%' . $search . '%')
                  ->orWhere('bd.editorial', 'LIKE', '%' . $search . '%');
            });
        }
        
        // Obtener total de registros (clonar query para no afectar la consulta principal)
        $countQuery = clone $query;
        $totalRecords = $countQuery->count();
        
        // Aplicar ordenamiento
        $orderColumn = $params['order'][0]['column'] ?? 0;
        $orderDir = $params['order'][0]['dir'] ?? 'asc';
        
        $columns = ['bd.titulo', 'autores', 'bd.anio_publicacion', 'bd.editorial', 'bd.tipo', 'bd.estado', 'num_asignaturas', 'num_bibliografias_disponibles', 'tipos_bibliografias'];
        
        if (isset($columns[$orderColumn])) {
            $query->orderBy($columns[$orderColumn], $orderDir);
        }
        
        // Aplicar paginación
        $data = $query->offset($start)->limit($limit)->get();
        
        // Formatear datos para DataTables
        $formattedData = [];
        foreach ($data as $row) {
            // Formatear tipos de bibliografías
            $tiposBibliografias = $row->tipos_bibliografias ?: 'Sin asignar';
            if ($tiposBibliografias !== 'Sin asignar') {
                $tiposArray = explode(', ', $tiposBibliografias);
                $tiposFormateados = array_map(function($tipo) {
                    return ucfirst($tipo);
                }, $tiposArray);
                $tiposBibliografias = implode(', ', $tiposFormateados);
            }
            
            $formattedData[] = [
                'id' => $row->id,
                'titulo' => $row->titulo,
                'autores' => $row->autores ?: 'Sin autores',
                'anio_publicacion' => $row->anio_publicacion ?: 'N/A',
                'editorial' => $row->editorial ?: 'N/A',
                'tipo' => ucfirst($row->tipo),
                'estado' => $row->estado ? 'Activo' : 'Inactivo',
                'num_asignaturas' => $row->num_asignaturas,
                'num_bibliografias_disponibles' => $row->num_bibliografias_disponibles,
                'tipos_bibliografias' => $tiposBibliografias
            ];
        }
        
        $response->getBody()->write(json_encode([
            'draw' => isset($params['draw']) ? (int)$params['draw'] : 1,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $formattedData
        ]));
        
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function exportarBibliografiasDeclaradas(Request $request, Response $response, array $args): Response
    {
        $params = $request->getQueryParams();
        
        // Búsqueda general
        $busqueda = $params['busqueda'] ?? '';
        $tipo_busqueda = $params['tipo_busqueda'] ?? 'todos';
        $estado = $params['estado'] ?? '';
        $tipo = $params['tipo'] ?? '';
        $tipoBibliografia = $params['tipo_bibliografia'] ?? '';
        $bibliografiasDisponibles = $params['bibliografias_disponibles'] ?? '';
        $carreraId = !empty($params['carrera_id']) ? (int)$params['carrera_id'] : null;
        
        $query = DB::table('bibliografias_declaradas as bd')
            ->select([
                'bd.titulo',
                'bd.tipo',
                'bd.anio_publicacion',
                'bd.editorial',
                'bd.estado',
                DB::raw('GROUP_CONCAT(DISTINCT CONCAT(a.apellidos, ", ", a.nombres) SEPARATOR "; ") as autores'),
                DB::raw('COUNT(DISTINCT ab.asignatura_id) as num_asignaturas'),
                DB::raw('COUNT(DISTINCT bdis.id) as num_bibliografias_disponibles'),
                DB::raw('GROUP_CONCAT(DISTINCT ab.tipo_bibliografia SEPARATOR ", ") as tipos_bibliografias')
            ])
            ->leftJoin('bibliografias_autores as ba', 'bd.id', '=', 'ba.bibliografia_id')
            ->leftJoin('autores as a', 'ba.autor_id', '=', 'a.id')
            ->leftJoin('asignaturas_bibliografias as ab', 'bd.id', '=', 'ab.bibliografia_id')
            ->leftJoin('asignaturas as asig', 'ab.asignatura_id', '=', 'asig.id')
            ->leftJoin('bibliografias_disponibles as bdis', 'bd.id', '=', 'bdis.bibliografia_declarada_id')
            ->groupBy('bd.id', 'bd.titulo', 'bd.tipo', 'bd.anio_publicacion', 'bd.editorial', 'bd.estado');
        
        // Aplicar búsqueda general
        if (!empty($busqueda)) {
            $busquedaTerm = '%' . $busqueda . '%';
            switch ($tipo_busqueda) {
                case 'titulo':
                    $query->where('bd.titulo', 'LIKE', $busquedaTerm);
                    break;
                case 'autor':
                    $query->where(function($q) use ($busquedaTerm) {
                        $q->where('a.apellidos', 'LIKE', $busquedaTerm)
                          ->orWhere('a.nombres', 'LIKE', $busquedaTerm);
                    });
                    break;
                case 'editorial':
                    $query->where('bd.editorial', 'LIKE', $busquedaTerm);
                    break;
                case 'asignatura':
                    $query->where('asig.nombre', 'LIKE', $busquedaTerm);
                    break;
                default: // 'todos'
                    $query->where(function($q) use ($busquedaTerm) {
                        $q->where('bd.titulo', 'LIKE', $busquedaTerm)
                          ->orWhere('bd.editorial', 'LIKE', $busquedaTerm)
                          ->orWhere('a.apellidos', 'LIKE', $busquedaTerm)
                          ->orWhere('a.nombres', 'LIKE', $busquedaTerm)
                          ->orWhere('asig.nombre', 'LIKE', $busquedaTerm);
                    });
                    break;
            }
        }
        
        if (!empty($estado)) {
            $query->where('bd.estado', $estado);
        }
        
        if (!empty($tipo)) {
            $query->where('bd.tipo', $tipo);
        }
        
        // Filtro por tipo de bibliografía
        if (!empty($tipoBibliografia)) {
            $query->whereExists(function($q) use ($tipoBibliografia) {
                $q->select(DB::raw(1))
                  ->from('asignaturas_bibliografias')
                  ->whereRaw('asignaturas_bibliografias.bibliografia_id = bd.id')
                  ->where('asignaturas_bibliografias.tipo_bibliografia', $tipoBibliografia);
            });
        }
        
        if (!empty($bibliografiasDisponibles)) {
            if ($bibliografiasDisponibles === 'con_disponibles') {
                $query->having('num_bibliografias_disponibles', '>', 0);
            } elseif ($bibliografiasDisponibles === 'sin_disponibles') {
                $query->having('num_bibliografias_disponibles', '=', 0);
            }
        }
        
        // Filtro por carrera: filtrar bibliografías asociadas a asignaturas de la carrera seleccionada
        if ($carreraId !== null && $carreraId > 0) {
            $query->whereExists(function($q) use ($carreraId) {
                $q->select(DB::raw(1))
                  ->from('asignaturas_bibliografias as ab3')
                  ->join('mallas as m', 'ab3.asignatura_id', '=', 'm.asignatura_id')
                  ->whereRaw('ab3.bibliografia_id = bd.id')
                  ->where('m.carrera_id', $carreraId);
            });
        }
        
        $data = $query->orderBy('bd.titulo')->get();
        
        // Crear archivo Excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Configurar encabezados
        $headers = [
            'Título',
            'Autor(es)',
            'Año Edición',
            'Editorial',
            'Tipo',
            'Estado',
            '# Asignaturas',
            '# Bibliografías Disponibles',
            'Tipos de Bibliografía'
        ];
        
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '1', $header);
            $sheet->getColumnDimension($col)->setAutoSize(true);
            $col++;
        }
        
        // Aplicar estilo a encabezados
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4E73DF']
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
            ]
        ];
        
        $sheet->getStyle('A1:I1')->applyFromArray($headerStyle);
        
        // Llenar datos
        $row = 2;
        foreach ($data as $item) {
            // Formatear tipos de bibliografías
            $tiposBibliografias = $item->tipos_bibliografias ?: 'Sin asignar';
            if ($tiposBibliografias !== 'Sin asignar') {
                $tiposArray = explode(', ', $tiposBibliografias);
                $tiposFormateados = array_map(function($tipo) {
                    return ucfirst($tipo);
                }, $tiposArray);
                $tiposBibliografias = implode(', ', $tiposFormateados);
            }
            
            $sheet->setCellValue('A' . $row, $item->titulo);
            $sheet->setCellValue('B' . $row, $item->autores ?: 'Sin autores');
            $sheet->setCellValue('C' . $row, $item->anio_publicacion ?: 'N/A');
            $sheet->setCellValue('D' . $row, $item->editorial ?: 'N/A');
            $sheet->setCellValue('E' . $row, ucfirst($item->tipo));
            $sheet->setCellValue('F' . $row, $item->estado ? 'Activo' : 'Inactivo');
            $sheet->setCellValue('G' . $row, $item->num_asignaturas);
            $sheet->setCellValue('H' . $row, $item->num_bibliografias_disponibles);
            $sheet->setCellValue('I' . $row, $tiposBibliografias);
            $row++;
        }
        
        // Aplicar bordes a toda la tabla
        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ];
        
        $lastRow = $row - 1;
        $sheet->getStyle('A1:I' . $lastRow)->applyFromArray($borderStyle);
        
        // Crear archivo
        $writer = new Xlsx($spreadsheet);
        $filename = 'listado_bibliografias_' . date('Y-m-d_H-i-s') . '.xlsx';
        
        $response = $response->withHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response = $response->withHeader('Content-Disposition', 'attachment; filename="' . $filename . '"');
        $response = $response->withHeader('Cache-Control', 'max-age=0');
        
        ob_start();
        $writer->save('php://output');
        $content = ob_get_clean();
        
        $response->getBody()->write($content);
        return $response;
    }
    
    public function editoriales(Request $request, Response $response, array $args): Response
    {
        $view = new \Twig\Environment(new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../templates'));
        $template = $view->load('reportes/editoriales.twig');
        
        $response->getBody()->write($template->render([]));
        return $response->withHeader('Content-Type', 'text/html');
    }
    
    // Listado de carreras por sede para el reporte de cobertura básica
    public function coberturaBasica(Request $request, Response $response, array $args): Response
    {
        error_log('ReporteController@coberturaBasica: Iniciando método');
        
        // Obtener datos de sesión
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $sessionData = [
            'user_id' => $_SESSION['user_id'] ?? null,
            'user_email' => $_SESSION['user_email'] ?? null,
            'user_nombre' => $_SESSION['user_nombre'] ?? null,
            'user_rol' => $_SESSION['user_rol'] ?? null
        ];
        error_log('ReporteController@coberturaBasica: Session data: ' . print_r($sessionData, true));
        
        // Inicializar el gestor de estado del listado
        $session = new Session();
        $stateManager = new ListStateManager($session, 'reporte_coberturas');
        
        // Obtener parámetros de la URL
        $urlParams = $_GET;
        
        // Obtener estado (combinando sesión y URL)
        $state = $stateManager->getState($urlParams);
        
        // Guardar estado en sesión
        $stateManager->saveState($state);
        
        // Extraer parámetros del estado
        $page = $state['page'];
        $perPage = $state['per_page'];
        $sortColumn = $state['sort'];
        $sortDirection = $state['direction'];
        $allowedPerPage = [5, 10, 15, 20];
        $allowedColumns = ['sede', 'codigo', 'nombre', 'tipo_programa', 'estado', 'cobertura_basica', 'cobertura_complementaria'];
        
        $offset = ($page - 1) * $perPage;

        // Obtener filtros del estado
        $sede = $state['sede'] ?? null;
        $tipoPrograma = $state['tipo_programa'] ?? null;
        $estado = $state['estado'] ?? null;
        $nombre = $state['nombre'] ?? null;
        
        // Obtener filtros de asignaturas de la URL
        $tiposFormacionFiltro = $urlParams['tipos_formacion'] ?? [];
        if (!is_array($tiposFormacionFiltro)) {
            $tiposFormacionFiltro = [$tiposFormacionFiltro];
        }
        $tiposFormacionVacio = $urlParams['tipos_formacion_vacio'] ?? null;
        
        // Si no hay filtros en la URL, intentar cargar filtros guardados globales
        if (empty($tiposFormacionFiltro) && !$tiposFormacionVacio) {
            // Obtener filtros guardados globales (sin carrera específica)
            $filtrosGuardados = DB::table('filtros_formaciones')
                ->whereNull('id_carrera_espejo')
                ->first();
                
            if ($filtrosGuardados) {
                $filtrosMarcados = 0;
                $tiposFormacionFiltro = [];
                
                if ($filtrosGuardados->basica) {
                    $tiposFormacionFiltro[] = 'FORMACION_BASICA';
                    $filtrosMarcados++;
                }
                if ($filtrosGuardados->general) {
                    $tiposFormacionFiltro[] = 'FORMACION_GENERAL';
                    $filtrosMarcados++;
                }
                if ($filtrosGuardados->idioma) {
                    $tiposFormacionFiltro[] = 'FORMACION_IDIOMAS';
                    $filtrosMarcados++;
                }
                if ($filtrosGuardados->profesional) {
                    $tiposFormacionFiltro[] = 'FORMACION_PROFESIONAL';
                    $filtrosMarcados++;
                }
                if ($filtrosGuardados->valores) {
                    $tiposFormacionFiltro[] = 'FORMACION_VALORES';
                    $filtrosMarcados++;
                }
                if ($filtrosGuardados->especialidad) {
                    $tiposFormacionFiltro[] = 'FORMACION_ESPECIALIDAD';
                    $filtrosMarcados++;
                }
                if ($filtrosGuardados->especial) {
                    $tiposFormacionFiltro[] = 'FORMACION_ESPECIAL';
                    $filtrosMarcados++;
                }
                
                // Si todos los filtros están en 0, marcar como vacío
                if ($filtrosMarcados == 0) {
                    $tiposFormacionFiltro = [];
                    $tiposFormacionVacio = true;
                }
            }
        }
        
        // Obtener el año actual
        $anioActual = date('Y');
        
        // Construir la consulta base para contar total de registros
        $countSql = "SELECT COUNT(DISTINCT CONCAT(ce.sede_id, '-', ce.carrera_id)) as total
        FROM carreras c
        JOIN carreras_espejos ce ON c.id = ce.carrera_id
        JOIN sedes s ON ce.sede_id = s.id
        WHERE 1=1";
        
        // Construir la consulta principal
        $sql = "SELECT 
                s.nombre as sede,
                ce.codigo_carrera as codigo,
                c.nombre,
                c.tipo_programa,
                c.estado,
                c.id as carrera_id,
                s.id as sede_id
        FROM carreras c
        JOIN carreras_espejos ce ON c.id = ce.carrera_id
        JOIN sedes s ON ce.sede_id = s.id
        WHERE 1=1";
        
        $params = [];
        
        // Aplicar filtros si existen
        if (!empty($sede)) {
            $sql .= " AND s.nombre LIKE ?";
            $countSql .= " AND s.nombre LIKE ?";
            $params[] = '%' . $sede . '%';
        }
        
        if (!empty($tipoPrograma)) {
            $sql .= " AND c.tipo_programa = ?";
            $countSql .= " AND c.tipo_programa = ?";
            $params[] = $tipoPrograma;
        }
        
        if ($estado !== null && $estado !== '') {
            $sql .= " AND c.estado = ?";
            $countSql .= " AND c.estado = ?";
            $params[] = $estado;
        }
        
        if (!empty($nombre)) {
            $sql .= " AND c.nombre LIKE ?";
            $countSql .= " AND c.nombre LIKE ?";
            $params[] = '%' . $nombre . '%';
        }
        
        // Obtener total de registros
        $stmt = $this->pdo->prepare($countSql);
        $stmt->execute($params);
        $totalRecords = $stmt->fetch()['total'];
        
        // Calcular información de paginación
        $totalPages = ceil($totalRecords / $perPage);
        $currentPage = $page;
        
        // Agregar ORDER BY y LIMIT a la consulta principal
        if ($sortColumn === 'cobertura_basica' || $sortColumn === 'cobertura_complementaria') {
            // Para ordenar por cobertura, necesitamos hacer un subquery
            $sql .= " ORDER BY c.nombre ASC LIMIT {$perPage} OFFSET {$offset}";
        } else {
            $sql .= " ORDER BY {$sortColumn} {$sortDirection} LIMIT {$perPage} OFFSET {$offset}";
        }
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $carreras = $stmt->fetchAll(\PDO::FETCH_OBJ);
        
        error_log('ReporteController@coberturaBasica: Total carreras encontradas: ' . count($carreras));

        // Cobertura básica por carrera - Calculada en tiempo real
        $coberturasBasicas = [];
        $carrerasCodigos = array_column($carreras, 'codigo');
        foreach ($carrerasCodigos as $codigoCarrera) {
            // Obtener sede_id para la carrera
            $carreraInfo = collect($carreras)->firstWhere('codigo', $codigoCarrera);
            $sedeId = $carreraInfo->sede_id ?? 1; // Default a sede 1 si no se encuentra
            
            $coberturasBasicas[$codigoCarrera] = $this->calcularCoberturaBasicaTiempoReal($codigoCarrera, $sedeId, $tiposFormacionFiltro);
        }

        // Cobertura complementaria por carrera - Calculada en tiempo real
        $coberturasComplementarias = [];
        foreach ($carrerasCodigos as $codigoCarrera) {
            // Obtener sede_id para la carrera
            $carreraInfo = collect($carreras)->firstWhere('codigo', $codigoCarrera);
            $sedeId = $carreraInfo->sede_id ?? 1; // Default a sede 1 si no se encuentra
            
            $coberturasComplementarias[$codigoCarrera] = $this->calcularCoberturaComplementariaTiempoReal($codigoCarrera, $sedeId, $tiposFormacionFiltro);
        }

        // Agregar datos de cobertura a cada carrera
        foreach ($carreras as $carrera) {
            $carreraCodigo = $carrera->codigo ?? null;
            $coberturaBasica = $coberturasBasicas[$carreraCodigo] ?? 'Sin información';
            $coberturaComplementaria = $coberturasComplementarias[$carreraCodigo] ?? 'Sin información';
            $carrera->cobertura_basica = $coberturaBasica;
            $carrera->cobertura_complementaria = $coberturaComplementaria;
        }
        
        // Ordenar por cobertura si es necesario (después de obtener los datos)
        if ($sortColumn === 'cobertura_basica' || $sortColumn === 'cobertura_complementaria') {
            usort($carreras, function($a, $b) use ($sortColumn, $sortDirection) {
                $aVal = is_numeric($a->$sortColumn) ? $a->$sortColumn : 0;
                $bVal = is_numeric($b->$sortColumn) ? $b->$sortColumn : 0;
                
                if ($sortDirection === 'ASC') {
                    return $aVal <=> $bVal;
                } else {
                    return $bVal <=> $aVal;
                }
            });
        }

        global $twig;
        $html = $twig->render('reportes/coberturas/index.twig', [
            'carreras' => $carreras,
            'session' => $sessionData,
            'app_url' => app_url(),
            'current_page' => 'coberturas',
            'anio_actual' => $anioActual,
            'filtros' => [
                'sede' => $sede ?? '',
                'tipo_programa' => $tipoPrograma ?? '',
                'estado' => $estado ?? '',
                'nombre' => $nombre ?? ''
            ],
            'tipos_formacion_seleccionados' => $tiposFormacionFiltro,
            'hay_filtros_asignaturas' => !empty($tiposFormacionFiltro),
            'paginacion' => [
                'current_page' => $page,
                'per_page' => $perPage,
                'total_records' => $totalRecords,
                'total_pages' => $totalPages,
                'has_previous' => $page > 1,
                'has_next' => $page < $totalPages,
                'previous_page' => $page - 1,
                'next_page' => $page + 1,
                'allowed_per_page' => $allowedPerPage
            ],
            'ordenamiento' => [
                'column' => $sortColumn,
                'direction' => $sortDirection
            ],
            'stateManager' => $stateManager
        ]);
        error_log('ReporteController@coberturaBasica: Vista renderizada correctamente');
        $response->getBody()->write($html);
        return $response->withHeader('Content-Type', 'text/html');
    }

    // Reporte de bibliografía básica por carrera
    public function reporteBibliografiaBasica(Request $request, Response $response, array $args): Response
    {
        // Definir variables de filtro ANTES de cualquier log o uso
        $queryParams = $request->getQueryParams();
        $tiposFormacionFiltro = $queryParams['tipos_formacion'] ?? [];
        if (!is_array($tiposFormacionFiltro)) {
            $tiposFormacionFiltro = [$tiposFormacionFiltro];
        }
        $tiposFormacionVacio = $queryParams['tipos_formacion_vacio'] ?? null;
        $filtrosGuardadosAplicados = false; // Nueva variable para rastrear si se aplicaron filtros guardados
        
        error_log('ReporteController@reporteBibliografiaBasica: Iniciando método');
        $sedeId = $args['sede_id'];
        $carreraId = $args['carrera_id'];
        
        // Obtener la carrera antes de cualquier uso de $carrera->codigo
        $carrera = DB::table('vw_mallas')
                ->where('id_sede', $sedeId)
                ->where('id_carrera', $carreraId)
            ->select(
                'id_sede as sede_id',
                'id_carrera as carrera_id',
                'sede as sede',
                'codigo_carrera as codigo',
                'carrera as nombre'
            )
                ->first();
                
        if (!$carrera) {
            error_log('ReporteController@reporteBibliografiaBasica: No se encontró la carrera');
            $response->getBody()->write('Carrera no encontrada');
            return $response->withStatus(404);
        }
        
        error_log('ReporteController@reporteBibliografiaBasica: Sede ID: ' . $sedeId . ', Carrera ID: ' . $carreraId);
        // Determinar si hay filtros aplicados inicialmente
        $hayFiltrosAplicados = !empty($tiposFormacionFiltro);
        
        error_log('ReporteController@reporteBibliografiaBasica: Query params: ' . print_r($queryParams, true));
        error_log('ReporteController@reporteBibliografiaBasica: Tipos formación filtro: ' . print_r($tiposFormacionFiltro, true));
        error_log('ReporteController@reporteBibliografiaBasica: Tipos formación filtro es array: ' . (is_array($tiposFormacionFiltro) ? 'SÍ' : 'NO'));
        error_log('ReporteController@reporteBibliografiaBasica: Tipos formación filtro está vacío: ' . (empty($tiposFormacionFiltro) ? 'SÍ' : 'NO'));
        error_log('ReporteController@reporteBibliografiaBasica: Hay filtros aplicados: ' . ($hayFiltrosAplicados ? 'SÍ' : 'NO'));

        // Obtener información de la sede y carrera usando la vista vw_mallas con la nueva estructura
        $carrera = DB::table('vw_mallas')
            ->where('id_sede', $sedeId)
            ->where('id_carrera', $carreraId)
            ->select(
                'id_sede as sede_id',
                'id_carrera as carrera_id',
                'sede as sede',
                'codigo_carrera as codigo',
                'carrera as nombre'
            )
            ->first();
            
        if (!$carrera) {
            error_log('ReporteController@reporteBibliografiaBasica: No se encontró la carrera');
            $response->getBody()->write('Carrera no encontrada');
            return $response->withStatus(404);
        }
        
        error_log('ReporteController@reporteBibliografiaBasica: Carrera encontrada: ' . $carrera->nombre);

        // Si no hay filtros en la URL, intentar cargar filtros guardados de la tabla filtros_formaciones
        if (empty($tiposFormacionFiltro) && !$tiposFormacionVacio) {
            // Obtener el id_carrera_espejo para la carrera y sede específica
            $carreraEspejo = DB::table('carreras_espejos')
                ->where('codigo_carrera', $carrera->codigo)
                ->where('sede_id', $sedeId)
                ->first();
            
            if ($carreraEspejo) {
                $filtrosGuardados = DB::table('filtros_formaciones')
                    ->where('id_carrera_espejo', $carreraEspejo->id)
                    ->first();
                    
                if ($filtrosGuardados) {
                    $filtrosGuardadosAplicados = true; // Marcamos que se intentaron aplicar filtros guardados
                    // Solo cargar filtros si al menos uno está marcado como 1
                    $filtrosMarcados = 0;
                    $tiposFormacionFiltro = [];
                    
                    if ($filtrosGuardados->basica) {
                        $tiposFormacionFiltro[] = 'FORMACION_BASICA';
                        $filtrosMarcados++;
                    }
                    if ($filtrosGuardados->general) {
                        $tiposFormacionFiltro[] = 'FORMACION_GENERAL';
                        $filtrosMarcados++;
                    }
                    if ($filtrosGuardados->idioma) {
                        $tiposFormacionFiltro[] = 'FORMACION_IDIOMAS';
                        $filtrosMarcados++;
                    }
                    if ($filtrosGuardados->profesional) {
                        $tiposFormacionFiltro[] = 'FORMACION_PROFESIONAL';
                        $filtrosMarcados++;
                    }
                    if ($filtrosGuardados->valores) {
                        $tiposFormacionFiltro[] = 'FORMACION_VALORES';
                        $filtrosMarcados++;
                    }
                    if ($filtrosGuardados->especialidad) {
                        $tiposFormacionFiltro[] = 'FORMACION_ESPECIALIDAD';
                        $filtrosMarcados++;
                    }
                    if ($filtrosGuardados->especial) {
                        $tiposFormacionFiltro[] = 'FORMACION_ESPECIAL';
                        $filtrosMarcados++;
                    }
                    
                    // Solo aplicar filtros si al menos uno está marcado
                    if ($filtrosMarcados > 0) {
                        error_log('ReporteController@reporteBibliografiaBasica: Filtros guardados cargados: ' . print_r($tiposFormacionFiltro, true));
                    } else {
                        // Si todos los filtros están en 0, marcar como vacío explícitamente
                        $tiposFormacionFiltro = [];
                        $tiposFormacionVacio = true; // Esto forzará que solo se muestren asignaturas regulares
                        error_log('ReporteController@reporteBibliografiaBasica: Todos los filtros guardados están desmarcados, se aplica filtro vacío');
                    }
                }
            }
        }
        
        // Actualizar si hay filtros aplicados y determinar si todos los filtros guardados están en cero
        $hayFiltrosAplicados = !empty($tiposFormacionFiltro);
        $todosFiltrosGuardadosEnCero = $filtrosGuardadosAplicados && empty($tiposFormacionFiltro) && $tiposFormacionVacio;

        // Obtener asignaturas REGULARES de la sede específica
        $regulares = DB::table('vw_mallas')
            ->where('id_sede', $sedeId)
            ->where('codigo_carrera', $carrera->codigo)
            ->where('tipo_asignatura', 'REGULAR')
            ->select('codigo_asignatura as codigo', 'asignatura as nombre', 'tipo_asignatura')
            ->distinct()
            ->get();

        // Obtener asignaturas de formación desde vw_mallas usando los campos específicos
        $formaciones = collect();
        if (!empty($tiposFormacionFiltro)) {
            // Si hay filtros aplicados, usar solo los seleccionados
            $formaciones = DB::table('vw_mallas')
                ->where('codigo_carrera', $carrera->codigo)
                ->whereIn('tipo_asignatura', $tiposFormacionFiltro)
                ->whereNotNull('codigo_asignatura_formacion') // Solo asignaturas de formación
                ->select(
                    'codigo_asignatura_formacion as codigo', 
                    'asignatura_formacion as nombre', 
                    'tipo_asignatura'
                )
                ->distinct()
                ->get();
        } elseif ($tiposFormacionVacio) {
            // El usuario desmarcó todo: solo asignaturas regulares
            $formaciones = collect();
        } else {
            // Primera carga: todas las de formación disponibles (excluyendo REGULAR y ELECTIVA)
            $formaciones = DB::table('vw_mallas')
                ->where('codigo_carrera', $carrera->codigo)
                ->whereNotIn('tipo_asignatura', ['REGULAR', 'FORMACION_ELECTIVA'])
                ->whereNotNull('codigo_asignatura_formacion') // Solo asignaturas de formación
                ->select(
                    'codigo_asignatura_formacion as codigo', 
                    'asignatura_formacion as nombre', 
                    'tipo_asignatura'
                )
                ->distinct()
                ->get();
        }


        // Unir ambos conjuntos y eliminar duplicados por código
        $asignaturas = $regulares->merge($formaciones)->unique('codigo')->values();

        error_log('ReporteController@reporteBibliografiaBasica: Asignaturas regulares encontradas: ' . count($regulares));
        error_log('ReporteController@reporteBibliografiaBasica: Asignaturas de formación encontradas: ' . count($formaciones));
        error_log('ReporteController@reporteBibliografiaBasica: Total asignaturas encontradas (regulares + filtro): ' . count($asignaturas));

        // Obtener todos los tipos de formación disponibles para esta carrera desde vw_mallas
        $tiposFormacionDisponibles = DB::table('vw_mallas')
            ->where('codigo_carrera', $carrera->codigo)
            ->whereNotIn('tipo_asignatura', ['REGULAR', 'FORMACION_ELECTIVA'])
            ->whereNotNull('codigo_asignatura_formacion') // Solo asignaturas de formación
            ->pluck('tipo_asignatura')
            ->unique()
            ->values()
            ->toArray();
            
        error_log('ReporteController@reporteBibliografiaBasica: Tipos formación disponibles: ' . print_r($tiposFormacionDisponibles, true));
        
        // Log adicional para ver todos los tipos de asignatura en la carrera
        $todosLosTipos = DB::table('vw_mallas')
            ->where('codigo_carrera', $carrera->codigo)
            ->pluck('tipo_asignatura')
            ->unique()
            ->values()
            ->toArray();
        error_log('ReporteController@reporteBibliografiaBasica: Todos los tipos de asignatura en la carrera: ' . print_r($todosLosTipos, true));
        


        // Calcular estadísticas para cada asignatura y obtener bibliografía detallada
        foreach ($asignaturas as $asignatura) {
            // Estado
            $asignatura->estado = 'Activa';
            $asignaturaId = DB::table('asignaturas_departamentos')
                ->where('codigo_asignatura', $asignatura->codigo)
                ->value('asignatura_id');
            $bibliografiaDetallada = collect();
            if ($asignaturaId) {
                $bibliografiaDetallada = DB::table('asignaturas_bibliografias')
                    ->join('bibliografias_declaradas', 'asignaturas_bibliografias.bibliografia_id', '=', 'bibliografias_declaradas.id')
                    ->where('asignaturas_bibliografias.asignatura_id', $asignaturaId)
                    ->where('asignaturas_bibliografias.tipo_bibliografia', 'basica')
                    ->where('asignaturas_bibliografias.estado', 'activa')
                    ->select(
                        'bibliografias_declaradas.id',
                        'bibliografias_declaradas.titulo',
                        'bibliografias_declaradas.anio_publicacion',
                        'bibliografias_declaradas.tipo',
                        'bibliografias_declaradas.editorial',
                        'bibliografias_declaradas.edicion',
                        'bibliografias_declaradas.isbn',
                        'bibliografias_declaradas.doi',
                        'bibliografias_declaradas.formato',
                        'bibliografias_declaradas.url',
                        'bibliografias_declaradas.nota'
                    )
                    ->get();
            }
            // Calcular valores por bibliografía usando la nueva función
            $resultado = $this->calcularEjemplaresAsignatura($bibliografiaDetallada, $sedeId);
            $asignatura->titulos_declarados = $resultado['titulos_declarados'];
            $asignatura->titulos_disponibles = $resultado['titulos_disponibles'];
            $asignatura->ejemplares_impresos = $resultado['ejemplares_impresos'];
            $asignatura->ejemplares_digitales = $resultado['ejemplares_digitales'];
            $asignatura->cobertura_basica = $resultado['cobertura_basica'];
        }

        // Calcular totales de la carrera considerando títulos declarados únicos (sin duplicados)
        $totalesCarrera = [
            'titulos_declarados' => 0,
            'titulos_disponibles' => 0,
            'ejemplares_impresos' => 0,
            'ejemplares_digitales' => 0
        ];
        
        // Obtener códigos de asignaturas para calcular totales únicos
        $codigosAsignaturas = $asignaturas->pluck('codigo')->toArray();
        
        // Contar títulos declarados únicos para toda la carrera
        $titulosDeclaradosUnicos = DB::table('bibliografias_declaradas')
            ->join('asignaturas_bibliografias', 'bibliografias_declaradas.id', '=', 'asignaturas_bibliografias.bibliografia_id')
            ->join('asignaturas', 'asignaturas_bibliografias.asignatura_id', '=', 'asignaturas.id')
            ->join('asignaturas_departamentos', 'asignaturas.id', '=', 'asignaturas_departamentos.asignatura_id')
            ->whereIn('asignaturas_departamentos.codigo_asignatura', $codigosAsignaturas)
            ->where('asignaturas_bibliografias.tipo_bibliografia', 'basica')
            ->where('asignaturas_bibliografias.estado', 'activa')
            ->distinct('bibliografias_declaradas.id')
            ->count('bibliografias_declaradas.id');
            
        // Contar títulos disponibles únicos para toda la carrera
        $titulosDisponiblesUnicos = DB::table('bibliografias_declaradas')
            ->join('asignaturas_bibliografias', 'bibliografias_declaradas.id', '=', 'asignaturas_bibliografias.bibliografia_id')
            ->join('asignaturas', 'asignaturas_bibliografias.asignatura_id', '=', 'asignaturas.id')
            ->join('asignaturas_departamentos', 'asignaturas.id', '=', 'asignaturas_departamentos.asignatura_id')
            ->whereIn('asignaturas_departamentos.codigo_asignatura', $codigosAsignaturas)
            ->where('asignaturas_bibliografias.tipo_bibliografia', 'basica')
            ->where('asignaturas_bibliografias.estado', 'activa')
            ->whereExists(function ($query) use ($sedeId) {
                $query->select(DB::raw(1))
                    ->from('bibliografias_disponibles')
                    ->whereRaw('bibliografias_disponibles.bibliografia_declarada_id = bibliografias_declaradas.id')
                    ->where('bibliografias_disponibles.estado', 1)
                    ->where(function ($subQuery) use ($sedeId) {
                        $subQuery->whereIn('bibliografias_disponibles.disponibilidad', ['electronico', 'ambos'])
                                ->orWhere(function ($q) use ($sedeId) {
                                    $q->where('bibliografias_disponibles.disponibilidad', 'impreso')
                                      ->whereExists(function ($sub) use ($sedeId) {
                                          $sub->select(DB::raw(1))
                                              ->from('bibliografias_disponibles_sedes')
                                              ->whereRaw('bibliografias_disponibles_sedes.bibliografia_disponible_id = bibliografias_disponibles.id')
                                              ->where('bibliografias_disponibles_sedes.sede_id', $sedeId)
                                              ->where('bibliografias_disponibles_sedes.ejemplares', '>', 0);
                                      });
                                });
                    });
            })
            ->distinct('bibliografias_declaradas.id')
            ->count('bibliografias_declaradas.id');
        
        // Sumar ejemplares de todas las asignaturas (estos sí se suman)
        foreach ($asignaturas as $asig) {
            // Solo sumar valores positivos (ignorar -1 y -2)
            if (($asig->ejemplares_impresos ?? 0) > 0) {
                $totalesCarrera['ejemplares_impresos'] += $asig->ejemplares_impresos;
            }
            }
        
        // Calcular total de ejemplares digitales considerando valores especiales
        $totalesCarrera['ejemplares_digitales'] = $this->calcularTotalEjemplaresDigitales($asignaturas);
        
        $totalesCarrera['titulos_declarados'] = $titulosDeclaradosUnicos;
        $totalesCarrera['titulos_disponibles'] = $titulosDisponiblesUnicos;
        
            $coberturaBasicaTotal = $totalesCarrera['titulos_declarados'] > 0 
                ? round(($totalesCarrera['titulos_disponibles'] / $totalesCarrera['titulos_declarados']) * 100, 2) 
                : 0;

        // Obtener datos de sesión para la plantilla
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $sessionData = [
            'user_id' => $_SESSION['user_id'] ?? null,
            'user_email' => $_SESSION['user_email'] ?? null,
            'user_nombre' => $_SESSION['user_nombre'] ?? null,
            'user_rol' => $_SESSION['user_rol'] ?? null
        ];

        $view = new \Twig\Environment(new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../templates'));
        $template = $view->load('reportes/coberturas/carrera.twig');
        
        error_log('ReporteController@reporteBibliografiaBasica: Tipos formación seleccionados para plantilla: ' . print_r($tiposFormacionFiltro, true));
        
        $html = $template->render([
            'carrera' => $carrera,
            'asignaturas' => $asignaturas,
            'session' => $sessionData,
            'app_url' => app_url(),
            'tipos_formacion_disponibles' => $tiposFormacionDisponibles,
            'tipos_formacion_seleccionados' => $tiposFormacionFiltro,
            'hay_filtros_aplicados' => $hayFiltrosAplicados,
            'todos_filtros_guardados_en_cero' => $todosFiltrosGuardadosEnCero,
            'totales_carrera' => $totalesCarrera,
            'cobertura_basica_total' => $coberturaBasicaTotal,
            'current_page' => 'coberturas'
        ]);
        
        error_log('ReporteController@reporteBibliografiaBasica: Vista renderizada correctamente');
        $response->getBody()->write($html);
        return $response->withHeader('Content-Type', 'text/html');
    }

    // Reporte de títulos de bibliografía básica por asignatura
    public function reporteTitulosBibliografiaBasica(Request $request, Response $response, array $args): Response
    {
        error_log('ReporteController@reporteTitulosBibliografiaBasica: Iniciando método');
        
        $sedeId = $args['sede_id'];
        $carreraId = $args['carrera_id'];
        $asignaturaCodigo = $args['asignatura_codigo'];
        
        error_log('ReporteController@reporteTitulosBibliografiaBasica: Sede ID: ' . $sedeId . ', Carrera ID: ' . $carreraId . ', Asignatura: ' . $asignaturaCodigo);

        // Obtener datos de sesión
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $sessionData = [
            'user_id' => $_SESSION['user_id'] ?? null,
            'user_email' => $_SESSION['user_email'] ?? null,
            'user_nombre' => $_SESSION['user_nombre'] ?? null,
            'user_rol' => $_SESSION['user_rol'] ?? null
        ];

        // Obtener información de la sede, carrera y asignatura usando la vista vw_mallas con la nueva estructura
        $carrera = DB::table('vw_mallas')
            ->where('id_sede', $sedeId)
            ->where('id_carrera', $carreraId)
            ->select(
                'id_sede as sede_id',
                'id_carrera as carrera_id',
                'sede as sede',
                'codigo_carrera as codigo',
                'carrera as nombre'
            )
            ->first();
            
        if (!$carrera) {
            error_log('ReporteController@reporteTitulosBibliografiaBasica: No se encontró la carrera');
            $response->getBody()->write('Carrera no encontrada');
            return $response->withStatus(404);
        }

        // Debug: Verificar qué asignaturas existen para esta sede y carrera
        $todasAsignaturas = DB::table('vw_mallas')
            ->where('id_sede', $sedeId)
            ->where('id_carrera', $carreraId)
            ->select('codigo_asignatura', 'codigo_asignatura_formacion', 'asignatura', 'asignatura_formacion')
            ->get();
        
        error_log('ReporteController@reporteTitulosBibliografiaBasica: Todas las asignaturas para sede ' . $sedeId . ' y carrera ' . $carreraId . ': ' . json_encode($todasAsignaturas));
        
        // Buscar la asignatura - para asignaturas de formación, buscar en toda la carrera sin limitar por sede
        $asignatura = null;
        
        // Primero intentar buscar en la sede específica
        $asignatura = DB::table('vw_mallas')
            ->where('id_sede', $sedeId)
            ->where('id_carrera', $carreraId)
            ->where(function ($query) use ($asignaturaCodigo) {
                // Buscar en asignaturas regulares
                $query->where('codigo_asignatura', $asignaturaCodigo)
                      // O buscar en asignaturas de formación
                      ->orWhere('codigo_asignatura_formacion', $asignaturaCodigo);
            })
            ->select(
                DB::raw('COALESCE(codigo_asignatura, codigo_asignatura_formacion) as codigo'),
                DB::raw('COALESCE(asignatura, asignatura_formacion) as nombre')
            )
            ->first();
        
        // Si no se encuentra en la sede específica, buscar en toda la carrera (para asignaturas de formación)
        if (!$asignatura) {
            error_log('ReporteController@reporteTitulosBibliografiaBasica: No se encontró en sede específica, buscando en toda la carrera');
            $asignatura = DB::table('vw_mallas')
                ->where('id_carrera', $carreraId)
                ->where(function ($query) use ($asignaturaCodigo) {
                    // Buscar en asignaturas regulares
                    $query->where('codigo_asignatura', $asignaturaCodigo)
                          // O buscar en asignaturas de formación
                          ->orWhere('codigo_asignatura_formacion', $asignaturaCodigo);
                })
                ->select(
                    DB::raw('COALESCE(codigo_asignatura, codigo_asignatura_formacion) as codigo'),
                    DB::raw('COALESCE(asignatura, asignatura_formacion) as nombre')
                )
                ->first();
        }
            
        if (!$asignatura) {
            error_log('ReporteController@reporteTitulosBibliografiaBasica: No se encontró la asignatura');
            error_log('ReporteController@reporteTitulosBibliografiaBasica: Buscando código: ' . $asignaturaCodigo);
            $response->getBody()->write('Asignatura no encontrada');
            return $response->withStatus(404);
        }

        // Obtener bibliografías declaradas de tipo básica para la asignatura
        // Primero necesitamos obtener el ID de la asignatura
        // Para asignaturas de formación, buscar usando el código de formación
        $asignaturaId = DB::table('asignaturas_departamentos')
            ->where('codigo_asignatura', $asignaturaCodigo)
            ->value('asignatura_id');
            
        // Si no se encuentra, intentar buscar como asignatura de formación
        if (!$asignaturaId) {
            $asignaturaId = DB::table('asignaturas_departamentos')
                ->where('codigo_asignatura_formacion', $asignaturaCodigo)
                ->value('asignatura_id');
        }
            
        if (!$asignaturaId) {
            error_log('ReporteController@reporteTitulosBibliografiaBasica: No se encontró el ID de la asignatura para el código: ' . $asignaturaCodigo);
            $response->getBody()->write('Asignatura no encontrada en asignaturas_departamentos');
            return $response->withStatus(404);
        }
        
        $bibliografiasDeclaradas = DB::table('asignaturas_bibliografias')
            ->join('bibliografias_declaradas', 'asignaturas_bibliografias.bibliografia_id', '=', 'bibliografias_declaradas.id')
            ->where('asignaturas_bibliografias.asignatura_id', $asignaturaId)
            ->where('asignaturas_bibliografias.tipo_bibliografia', 'basica')
            ->where('asignaturas_bibliografias.estado', 'activa')
            ->select(
                'bibliografias_declaradas.id',
                'bibliografias_declaradas.titulo',
                'bibliografias_declaradas.anio_publicacion',
                'bibliografias_declaradas.tipo',
                'bibliografias_declaradas.editorial',
                'bibliografias_declaradas.edicion',
                'bibliografias_declaradas.isbn',
                'bibliografias_declaradas.doi',
                'bibliografias_declaradas.formato',
                'bibliografias_declaradas.url',
                'bibliografias_declaradas.nota'
            )
            ->get();
            
        error_log('ReporteController@reporteTitulosBibliografiaBasica: Total bibliografías encontradas: ' . count($bibliografiasDeclaradas));

        // Calcular estadísticas para cada bibliografía declarada
        foreach ($bibliografiasDeclaradas as $bibliografia) {
            error_log('ReporteController@reporteTitulosBibliografiaBasica: Procesando bibliografía: ' . $bibliografia->titulo);
            
            // Obtener el primer autor
            $primerAutor = DB::table('bibliografias_autores')
                ->join('autores', 'bibliografias_autores.autor_id', '=', 'autores.id')
                ->where('bibliografias_autores.bibliografia_id', $bibliografia->id)
                ->select(DB::raw("CONCAT(autores.apellidos, ', ', autores.nombres) as nombre_completo"))
                ->first();
            
            // Construir título declarado concatenado
            $tituloDeclarado = $bibliografia->titulo;
            if ($bibliografia->editorial) {
                $tituloDeclarado .= ' - ' . $bibliografia->editorial;
            }
            if ($primerAutor) {
                $tituloDeclarado .= ' - ' . $primerAutor->nombre_completo;
            }
            
            // Obtener todas las bibliografías disponibles para esta bibliografía declarada
            $bibliografiasDisponibles = DB::table('bibliografias_disponibles')
                ->where('bibliografia_declarada_id', $bibliografia->id)
                ->where('estado', 1)
                ->select('disponibilidad', 'ejemplares_digitales')
                ->get();

            // Usar la nueva lógica para calcular ejemplares
            $resultado = $this->calcularEjemplaresNuevaLogica($bibliografia->id, $sedeId, $bibliografiasDisponibles);
            $ejemplaresImpresos = $resultado['ejemplares_impresos'];
            $ejemplaresDigitales = $resultado['ejemplares_digitales'];
            $disponible = $resultado['disponible'];

            // Asignar valores a la bibliografía
            $bibliografia->ejemplares_impresos = $ejemplaresImpresos;
            $bibliografia->ejemplares_digitales = $ejemplaresDigitales;
            $bibliografia->disponible = $disponible;
        }

        $view = new \Twig\Environment(new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../templates'));
        $template = $view->load('reportes/coberturas/asignatura.twig');
        $html = $template->render([
            'carrera' => $carrera,
            'asignatura' => $asignatura,
            'bibliografias' => $bibliografiasDeclaradas,
            'session' => $sessionData,
            'app_url' => app_url(),
            'current_page' => 'coberturas'
        ]);
        
        error_log('ReporteController@reporteTitulosBibliografiaBasica: Vista renderizada correctamente');
        $response->getBody()->write($html);
        return $response->withHeader('Content-Type', 'text/html');
    }

    // Reporte de títulos de bibliografía complementaria por asignatura
    public function reporteTitulosBibliografiaComplementaria(Request $request, Response $response, array $args): Response
    {
        error_log('ReporteController@reporteTitulosBibliografiaComplementaria: Iniciando método');
        
        $sedeId = $args['sede_id'];
        $carreraId = $args['carrera_id'];
        $asignaturaCodigo = $args['asignatura_codigo'];
        
        error_log('ReporteController@reporteTitulosBibliografiaComplementaria: Sede ID: ' . $sedeId . ', Carrera ID: ' . $carreraId . ', Asignatura: ' . $asignaturaCodigo);

        // Obtener datos de sesión
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $sessionData = [
            'user_id' => $_SESSION['user_id'] ?? null,
            'user_email' => $_SESSION['user_email'] ?? null,
            'user_nombre' => $_SESSION['user_nombre'] ?? null,
            'user_rol' => $_SESSION['user_rol'] ?? null
        ];

        // Obtener información de la sede, carrera y asignatura usando la vista vw_mallas con la nueva estructura
        $carrera = DB::table('vw_mallas')
            ->where('id_sede', $sedeId)
            ->where('id_carrera', $carreraId)
            ->select(
                'id_sede as sede_id',
                'id_carrera as carrera_id',
                'sede as sede',
                'codigo_carrera as codigo',
                'carrera as nombre'
            )
            ->first();
            
        if (!$carrera) {
            error_log('ReporteController@reporteTitulosBibliografiaComplementaria: No se encontró la carrera');
            $response->getBody()->write('Carrera no encontrada');
            return $response->withStatus(404);
        }

        // Buscar la asignatura - para asignaturas de formación, buscar en toda la carrera sin limitar por sede
        $asignatura = null;
        
        // Primero intentar buscar en la sede específica
        $asignatura = DB::table('vw_mallas')
            ->where('id_sede', $sedeId)
            ->where('id_carrera', $carreraId)
            ->where(function ($query) use ($asignaturaCodigo) {
                // Buscar en asignaturas regulares
                $query->where('codigo_asignatura', $asignaturaCodigo)
                      // O buscar en asignaturas de formación
                      ->orWhere('codigo_asignatura_formacion', $asignaturaCodigo);
            })
            ->select(
                DB::raw('COALESCE(codigo_asignatura, codigo_asignatura_formacion) as codigo'),
                DB::raw('COALESCE(asignatura, asignatura_formacion) as nombre')
            )
            ->first();
        
        // Si no se encuentra en la sede específica, buscar en toda la carrera (para asignaturas de formación)
        if (!$asignatura) {
            error_log('ReporteController@reporteTitulosBibliografiaComplementaria: No se encontró en sede específica, buscando en toda la carrera');
            $asignatura = DB::table('vw_mallas')
                ->where('id_carrera', $carreraId)
                ->where(function ($query) use ($asignaturaCodigo) {
                    // Buscar en asignaturas regulares
                    $query->where('codigo_asignatura', $asignaturaCodigo)
                          // O buscar en asignaturas de formación
                          ->orWhere('codigo_asignatura_formacion', $asignaturaCodigo);
                })
                ->select(
                    DB::raw('COALESCE(codigo_asignatura, codigo_asignatura_formacion) as codigo'),
                    DB::raw('COALESCE(asignatura, asignatura_formacion) as nombre')
                )
                ->first();
        }
            
        if (!$asignatura) {
            error_log('ReporteController@reporteTitulosBibliografiaComplementaria: No se encontró la asignatura');
            $response->getBody()->write('Asignatura no encontrada');
            return $response->withStatus(404);
        }

        // Obtener bibliografías declaradas de tipo complementaria para la asignatura
        // Primero necesitamos obtener el ID de la asignatura
        // Para asignaturas de formación, buscar usando el código de formación
        $asignaturaId = DB::table('asignaturas_departamentos')
            ->where('codigo_asignatura', $asignaturaCodigo)
            ->value('asignatura_id');
            
        // Si no se encuentra, intentar buscar como asignatura de formación
        if (!$asignaturaId) {
            $asignaturaId = DB::table('asignaturas_departamentos')
                ->where('codigo_asignatura_formacion', $asignaturaCodigo)
                ->value('asignatura_id');
        }
            
        if (!$asignaturaId) {
            error_log('ReporteController@reporteTitulosBibliografiaComplementaria: No se encontró el ID de la asignatura para el código: ' . $asignaturaCodigo);
            $response->getBody()->write('Asignatura no encontrada en asignaturas_departamentos');
            return $response->withStatus(404);
        }
        
        $bibliografiasDeclaradas = DB::table('asignaturas_bibliografias')
            ->join('bibliografias_declaradas', 'asignaturas_bibliografias.bibliografia_id', '=', 'bibliografias_declaradas.id')
            ->where('asignaturas_bibliografias.asignatura_id', $asignaturaId)
            ->where('asignaturas_bibliografias.tipo_bibliografia', 'complementaria')
            ->where('asignaturas_bibliografias.estado', 'activa')
            ->select(
                'bibliografias_declaradas.id',
                'bibliografias_declaradas.titulo',
                'bibliografias_declaradas.anio_publicacion',
                'bibliografias_declaradas.tipo',
                'bibliografias_declaradas.editorial',
                'bibliografias_declaradas.edicion',
                'bibliografias_declaradas.isbn',
                'bibliografias_declaradas.doi',
                'bibliografias_declaradas.formato',
                'bibliografias_declaradas.url',
                'bibliografias_declaradas.nota'
            )
            ->get();
            
        error_log('ReporteController@reporteTitulosBibliografiaComplementaria: Total bibliografías encontradas: ' . count($bibliografiasDeclaradas));

        // Calcular estadísticas para cada bibliografía declarada
        foreach ($bibliografiasDeclaradas as $bibliografia) {
            error_log('ReporteController@reporteTitulosBibliografiaComplementaria: Procesando bibliografía: ' . $bibliografia->titulo);
            
            // Obtener el primer autor
            $primerAutor = DB::table('bibliografias_autores')
                ->join('autores', 'bibliografias_autores.autor_id', '=', 'autores.id')
                ->where('bibliografias_autores.bibliografia_id', $bibliografia->id)
                ->select(DB::raw("CONCAT(autores.apellidos, ', ', autores.nombres) as nombre_completo"))
                ->first();
            
            // Construir título declarado concatenado
            $tituloDeclarado = $bibliografia->titulo;
            if ($bibliografia->editorial) {
                $tituloDeclarado .= ' - ' . $bibliografia->editorial;
            }
            if ($primerAutor) {
                $tituloDeclarado .= ' - ' . $primerAutor->nombre_completo;
            }
            
            // Obtener todas las bibliografías disponibles para esta bibliografía declarada
            $bibliografiasDisponibles = DB::table('bibliografias_disponibles')
                ->where('bibliografia_declarada_id', $bibliografia->id)
                ->where('estado', 1)
                ->select('disponibilidad', 'ejemplares_digitales')
                ->get();

            // Usar la nueva lógica para calcular ejemplares
            $resultado = $this->calcularEjemplaresNuevaLogica($bibliografia->id, $sedeId, $bibliografiasDisponibles);
            $ejemplaresImpresos = $resultado['ejemplares_impresos'];
            $ejemplaresDigitales = $resultado['ejemplares_digitales'];
            $disponible = $resultado['disponible'];

            error_log('ReporteController@reporteTitulosBibliografiaComplementaria: Ejemplares impresos para ' . $bibliografia->titulo . ': ' . $ejemplaresImpresos);
            error_log('ReporteController@reporteTitulosBibliografiaComplementaria: Ejemplares digitales para ' . $bibliografia->titulo . ': ' . $ejemplaresDigitales);
            error_log('ReporteController@reporteTitulosBibliografiaComplementaria: Disponible para ' . $bibliografia->titulo . ': ' . ($disponible ? 'Sí' : 'No'));

            // Asignar valores a la bibliografía
            $bibliografia->ejemplares_impresos = $ejemplaresImpresos;
            $bibliografia->ejemplares_digitales = $ejemplaresDigitales;
            $bibliografia->disponible = $disponible;
        }

        // Obtener datos de sesión para la plantilla
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $sessionData = [
            'user_id' => $_SESSION['user_id'] ?? null,
            'user_email' => $_SESSION['user_email'] ?? null,
            'user_nombre' => $_SESSION['user_nombre'] ?? null,
            'user_rol' => $_SESSION['user_rol'] ?? null
        ];

        $view = new \Twig\Environment(new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../templates'));
        $template = $view->load('reportes/coberturas_complementaria/asignatura.twig');
        $html = $template->render([
            'carrera' => $carrera,
            'asignatura' => $asignatura,
            'bibliografias' => $bibliografiasDeclaradas,
            'session' => $sessionData,
            'app_url' => app_url(),
            'current_page' => 'coberturas'
        ]);
        
        error_log('ReporteController@reporteTitulosBibliografiaComplementaria: Vista renderizada correctamente');
        $response->getBody()->write($html);
        return $response->withHeader('Content-Type', 'text/html');
    }

    // Reporte expandido de bibliografía básica por carrera
    public function reporteBibliografiaBasicaExpandido(Request $request, Response $response, array $args): Response
    {
        try {
            error_log('ReporteController@reporteBibliografiaBasicaExpandido: Iniciando método');
            
            $sedeId = $args['sede_id'];
            $carreraId = $args['carrera_id'];
        
        // Obtener la carrera antes de cualquier uso de $carrera->codigo
        $carrera = DB::table('vw_mallas')
                ->where('id_sede', $sedeId)
                ->where('id_carrera', $carreraId)
            ->select(
                'id_sede as sede_id',
                'id_carrera as carrera_id',
                'sede as sede',
                'codigo_carrera as codigo',
                'carrera as nombre'
            )
                ->first();
                
        if (!$carrera) {
            error_log('ReporteController@reporteBibliografiaBasicaExpandido: No se encontró la carrera');
            $response->getBody()->write('Carrera no encontrada');
            return $response->withStatus(404);
        }
        
        error_log('ReporteController@reporteBibliografiaBasicaExpandido: Sede ID: ' . $sedeId . ', Carrera ID: ' . $carreraId);
        //error_log('ReporteController@reporteBibliografiaBasicaExpandido: Tipos formación filtro: ' . print_r($tiposFormacionFiltro, true));

        // Definir variables de filtro ANTES de cualquier log o uso
        $queryParams = $request->getQueryParams();
        $tiposFormacionFiltro = $queryParams['tipos_formacion'] ?? [];
        if (!is_array($tiposFormacionFiltro)) {
            $tiposFormacionFiltro = [$tiposFormacionFiltro];
        }
        $tiposFormacionVacio = $queryParams['tipos_formacion_vacio'] ?? null;
        $filtrosGuardadosAplicados = false; // Nueva variable para rastrear si se aplicaron filtros guardados
        
        // Si no hay filtros en la URL, intentar cargar filtros guardados de la tabla filtros_formaciones
        if (empty($tiposFormacionFiltro) && !$tiposFormacionVacio) {
            // Obtener el id_carrera_espejo para la carrera y sede específica
            $carreraEspejo = DB::table('carreras_espejos')
                ->where('codigo_carrera', $carrera->codigo)
                ->where('sede_id', $sedeId)
                ->first();
            
            if ($carreraEspejo) {
                $filtrosGuardados = DB::table('filtros_formaciones')
                    ->where('id_carrera_espejo', $carreraEspejo->id)
                    ->first();
                    
                if ($filtrosGuardados) {
                    $filtrosGuardadosAplicados = true; // Marcamos que se intentaron aplicar filtros guardados
                    // Solo cargar filtros si al menos uno está marcado como 1
                    $filtrosMarcados = 0;
                    $tiposFormacionFiltro = [];
                    
                    if ($filtrosGuardados->basica) {
                        $tiposFormacionFiltro[] = 'FORMACION_BASICA';
                        $filtrosMarcados++;
                    }
                    if ($filtrosGuardados->general) {
                        $tiposFormacionFiltro[] = 'FORMACION_GENERAL';
                        $filtrosMarcados++;
                    }
                    if ($filtrosGuardados->idioma) {
                        $tiposFormacionFiltro[] = 'FORMACION_IDIOMAS';
                        $filtrosMarcados++;
                    }
                    if ($filtrosGuardados->profesional) {
                        $tiposFormacionFiltro[] = 'FORMACION_PROFESIONAL';
                        $filtrosMarcados++;
                    }
                    if ($filtrosGuardados->valores) {
                        $tiposFormacionFiltro[] = 'FORMACION_VALORES';
                        $filtrosMarcados++;
                    }
                    if ($filtrosGuardados->especialidad) {
                        $tiposFormacionFiltro[] = 'FORMACION_ESPECIALIDAD';
                        $filtrosMarcados++;
                    }
                    if ($filtrosGuardados->especial) {
                        $tiposFormacionFiltro[] = 'FORMACION_ESPECIAL';
                        $filtrosMarcados++;
                    }
                    
                    // Solo aplicar filtros si al menos uno está marcado
                    if ($filtrosMarcados > 0) {
                        error_log('ReporteController@reporteBibliografiaBasicaExpandido: Filtros guardados cargados: ' . print_r($tiposFormacionFiltro, true));
                    } else {
                        // Si todos los filtros están en 0, marcar como vacío explícitamente
                        $tiposFormacionFiltro = [];
                        $tiposFormacionVacio = true; // Esto forzará que solo se muestren asignaturas regulares
                        error_log('ReporteController@reporteBibliografiaBasicaExpandido: Todos los filtros guardados están desmarcados, se aplica filtro vacío');
                    }
                }
            }
        }
        // Determinar si hay filtros aplicados y si todos los filtros guardados están en cero
        $hayFiltrosAplicados = !empty($tiposFormacionFiltro);
        $todosFiltrosGuardadosEnCero = $filtrosGuardadosAplicados && empty($tiposFormacionFiltro) && $tiposFormacionVacio;
        
        // Ahora sí, logs y resto del código
        error_log('ReporteController@reporteBibliografiaBasicaExpandido: Sede ID: ' . $sedeId . ', Carrera ID: ' . $carreraId);
        error_log('ReporteController@reporteBibliografiaBasicaExpandido: Tipos formación filtro: ' . print_r($tiposFormacionFiltro, true));
        error_log('ReporteController@reporteBibliografiaBasicaExpandido: Tipos formación filtro es array: ' . (is_array($tiposFormacionFiltro) ? 'SÍ' : 'NO'));
        error_log('ReporteController@reporteBibliografiaBasicaExpandido: Tipos formación filtro está vacío: ' . (empty($tiposFormacionFiltro) ? 'SÍ' : 'NO'));
        error_log('ReporteController@reporteBibliografiaBasicaExpandido: Hay filtros aplicados: ' . ($hayFiltrosAplicados ? 'SÍ' : 'NO'));
        error_log('ReporteController@reporteBibliografiaBasicaExpandido: Filtros guardados aplicados: ' . ($filtrosGuardadosAplicados ? 'SÍ' : 'NO'));
        error_log('ReporteController@reporteBibliografiaBasicaExpandido: Tipos formación vacío: ' . ($tiposFormacionVacio ? 'SÍ' : 'NO'));
        error_log('ReporteController@reporteBibliografiaBasicaExpandido: Todos filtros guardados en cero: ' . ($todosFiltrosGuardadosEnCero ? 'SÍ' : 'NO'));

        // La carrera ya fue obtenida anteriormente, no necesitamos consultarla de nuevo
        
        error_log('ReporteController@reporteBibliografiaBasicaExpandido: Carrera encontrada: ' . $carrera->nombre);

        // Obtener asignaturas REGULARES (siempre incluidas)
        $regulares = DB::table('vw_mallas')
            ->where('id_sede', $sedeId)
            ->where('codigo_carrera', $carrera->codigo)
            ->where('tipo_asignatura', 'REGULAR')
            ->whereNotNull('codigo_asignatura')
            ->select('codigo_asignatura as codigo', 'asignatura as nombre', 'tipo_asignatura')
            ->distinct()
            ->get();

        // Obtener asignaturas de los tipos de formación seleccionados
        // Filtrar por sede de la unidad donde está vinculada la asignatura
        $formaciones = collect();
        try {
            if (!empty($tiposFormacionFiltro)) {
                // Si hay filtros aplicados, usar solo los seleccionados
                error_log('ReporteController@reporteBibliografiaBasicaExpandido: Aplicando filtros específicos: ' . print_r($tiposFormacionFiltro, true));
                $formaciones = DB::table('vw_mallas')
                    ->join('asignaturas_departamentos', 'vw_mallas.codigo_asignatura_formacion', '=', 'asignaturas_departamentos.codigo_asignatura')
                    ->join('unidades', 'asignaturas_departamentos.id_unidad', '=', 'unidades.id')
                    ->where('unidades.sede_id', $sedeId) // Filtrar por sede de la unidad
                    ->where('vw_mallas.codigo_carrera', $carrera->codigo)
                    ->whereIn('vw_mallas.tipo_asignatura', $tiposFormacionFiltro)
                    ->whereNotNull('vw_mallas.codigo_asignatura_formacion')
                    ->whereNotNull('vw_mallas.id_asignatura_formacion')
                    ->select(
                        'vw_mallas.id_asignatura_formacion',
                        'vw_mallas.codigo_asignatura_formacion as codigo', 
                        'vw_mallas.asignatura_formacion as nombre', 
                        'vw_mallas.tipo_asignatura',
                        'vw_mallas.id_sede',
                        'unidades.sede_id as unidad_sede_id'
                    )
                    ->get();
            } elseif ($tiposFormacionVacio) {
                // El usuario desmarcó todo o todos los filtros guardados están en cero: solo asignaturas regulares
                error_log('ReporteController@reporteBibliografiaBasicaExpandido: Filtro vacío aplicado - solo asignaturas regulares');
                $formaciones = collect();
            } else {
                // Primera carga: todas las de formación disponibles (solo si no se aplicaron filtros guardados)
                if (!$filtrosGuardadosAplicados) {
                    error_log('ReporteController@reporteBibliografiaBasicaExpandido: Primera carga - todas las asignaturas de formación disponibles');
                    $formaciones = DB::table('vw_mallas')
                        ->join('asignaturas_departamentos', 'vw_mallas.codigo_asignatura_formacion', '=', 'asignaturas_departamentos.codigo_asignatura')
                        ->join('unidades', 'asignaturas_departamentos.id_unidad', '=', 'unidades.id')
                        ->where('unidades.sede_id', $sedeId) // Filtrar por sede de la unidad
                        ->where('vw_mallas.codigo_carrera', $carrera->codigo)
                        ->whereNotIn('vw_mallas.tipo_asignatura', ['FORMACION_ELECTIVA', 'REGULAR'])
                        ->whereNotNull('vw_mallas.codigo_asignatura_formacion')
                        ->whereNotNull('vw_mallas.id_asignatura_formacion')
                        ->select(
                            'vw_mallas.id_asignatura_formacion',
                            'vw_mallas.codigo_asignatura_formacion as codigo', 
                            'vw_mallas.asignatura_formacion as nombre', 
                            'vw_mallas.tipo_asignatura',
                            'vw_mallas.id_sede',
                            'unidades.sede_id as unidad_sede_id'
                        )
                        ->get();
                } else {
                    // Se aplicaron filtros guardados pero todos estaban en cero
                    error_log('ReporteController@reporteBibliografiaBasicaExpandido: Filtros guardados aplicados pero todos en cero - solo asignaturas regulares');
                    $formaciones = collect();
                }
            }
        } catch (\Exception $e) {
            error_log('ReporteController@reporteBibliografiaBasicaExpandido: Error al obtener asignaturas de formación: ' . $e->getMessage());
            $formaciones = collect();
        }
        
        // Ya no necesitamos eliminar duplicados porque el filtro por sede de unidad ya los elimina
        // Solo agregamos distinct para asegurar que no haya duplicados por id_asignatura_formacion
        $formaciones = $formaciones->unique('id_asignatura_formacion')->values();
        
        // Log temporal para depuración de asignaturas de formación
        error_log('ReporteController@reporteBibliografiaBasicaExpandido: Total formaciones filtradas por sede de unidad: ' . count($formaciones));
        foreach ($formaciones as $f) {
            error_log('DEPURACION FORMACION EXPANDIDO: id_sede=' . $f->id_sede . ' unidad_sede_id=' . $f->unidad_sede_id . ' codigo=' . $f->codigo . ' nombre=' . $f->nombre . ' tipo=' . $f->tipo_asignatura . ' id_asignatura_formacion=' . $f->id_asignatura_formacion);
        }

        // Unir ambos conjuntos y eliminar duplicados
        // Para asignaturas regulares usar 'codigo', para formación usar id_asignatura_formacion
        $asignaturas = $regulares->merge($formaciones)->unique(function ($item) {
            // Para asignaturas de formación, usar id_asignatura_formacion como clave única
            if (isset($item->id_asignatura_formacion)) {
                return 'formacion_' . $item->id_asignatura_formacion;
            }
            // Para asignaturas regulares, usar código como clave única
            return 'regular_' . $item->codigo;
        })->values();

        error_log('ReporteController@reporteBibliografiaBasicaExpandido: Asignaturas regulares encontradas: ' . count($regulares));
        error_log('ReporteController@reporteBibliografiaBasicaExpandido: Asignaturas de formación encontradas: ' . count($formaciones));
        error_log('ReporteController@reporteBibliografiaBasicaExpandido: Total asignaturas encontradas (regulares + filtro): ' . count($asignaturas));

        // Obtener todos los tipos de formación disponibles para esta carrera (excluyendo REGULAR y ELECTIVA)
        $tiposFormacionDisponibles = DB::table('vw_mallas')
            ->where('codigo_carrera', $carrera->codigo)
            ->whereNotIn('tipo_asignatura', ['REGULAR'])
            ->whereNotNull('codigo_asignatura_formacion') // Solo asignaturas que tienen código de formación
            ->pluck('tipo_asignatura')
            ->unique()
            ->values()
            ->toArray();
            
        error_log('ReporteController@reporteBibliografiaBasicaExpandido: Tipos formación disponibles: ' . print_r($tiposFormacionDisponibles, true));

        // Obtener datos de bibliografía en formato de tabla plana (una fila por bibliografía)
        $datosBibliografia = collect();
        
        foreach ($asignaturas as $asignatura) {
            error_log('ReporteController@reporteBibliografiaBasicaExpandido: Procesando asignatura: ' . $asignatura->codigo);
            
            // Obtener el ID de la asignatura
            // Para asignaturas de formación, usar id_asignatura_formacion si está disponible
            if (isset($asignatura->id_asignatura_formacion)) {
                $asignaturaId = $asignatura->id_asignatura_formacion;
            } else {
                $asignaturaId = DB::table('asignaturas_departamentos')
                    ->where('codigo_asignatura', $asignatura->codigo)
                    ->value('asignatura_id');
            }
            
            if ($asignaturaId) {
                try {
                    // Obtener bibliografías declaradas de tipo básica para esta asignatura
                    $bibliografias = DB::table('asignaturas_bibliografias')
                        ->join('bibliografias_declaradas', 'asignaturas_bibliografias.bibliografia_id', '=', 'bibliografias_declaradas.id')
                        ->where('asignaturas_bibliografias.asignatura_id', $asignaturaId)
                        ->where('asignaturas_bibliografias.tipo_bibliografia', 'basica')
                        ->where('asignaturas_bibliografias.estado', 'activa')
                        ->select(
                            'bibliografias_declaradas.id',
                            'bibliografias_declaradas.titulo',
                            'bibliografias_declaradas.anio_publicacion',
                            'bibliografias_declaradas.tipo',
                            'bibliografias_declaradas.editorial',
                            'bibliografias_declaradas.edicion',
                            'bibliografias_declaradas.isbn',
                            'bibliografias_declaradas.doi',
                            'bibliografias_declaradas.formato',
                            'bibliografias_declaradas.url',
                            'bibliografias_declaradas.nota'
                        )
                        ->get();
                } catch (\Exception $e) {
                    error_log('ReporteController@reporteBibliografiaBasicaExpandido: Error al obtener bibliografías para asignatura ' . $asignatura->codigo . ': ' . $e->getMessage());
                    $bibliografias = collect();
                }
                
                foreach ($bibliografias as $bibliografia) {
                    try {
                        // Obtener el primer autor
                        $primerAutor = DB::table('bibliografias_autores')
                            ->join('autores', 'bibliografias_autores.autor_id', '=', 'autores.id')
                            ->where('bibliografias_autores.bibliografia_id', $bibliografia->id)
                            ->select(DB::raw("CONCAT(autores.apellidos, ', ', autores.nombres) as nombre_completo"))
                            ->first();
                        
                        // Construir título declarado concatenado
                        $tituloDeclarado = $bibliografia->titulo;
                        if ($bibliografia->editorial) {
                            $tituloDeclarado .= ' - ' . $bibliografia->editorial;
                        }
                        if ($primerAutor) {
                            $tituloDeclarado .= ' - ' . $primerAutor->nombre_completo;
                        }
                        
                        // Obtener bibliografías disponibles para esta bibliografía declarada
                        $bibliografiasDisponibles = DB::table("bibliografias_disponibles")
                            ->where("bibliografia_declarada_id", $bibliografia->id)
                            ->where("estado", 1)
                            ->select("disponibilidad", "ejemplares_digitales")
                            ->get();

                        // Usar la nueva lógica para calcular ejemplares
                        $resultado = $this->calcularEjemplaresNuevaLogica($bibliografia->id, $sedeId, $bibliografiasDisponibles);
                        $ejemplaresImpresos = $resultado["ejemplares_impresos"];
                        $ejemplaresDigitales = $resultado["ejemplares_digitales"];
                        $disponible = $resultado["disponible"];
                        
                        // Calcular cobertura (siempre será 100% si está disponible, 0% si no)
                        $cobertura = $disponible ? 100 : 0;
                        
                        // Crear fila de datos
                        $datosBibliografia->push([
                            'codigo_asignatura' => $asignatura->codigo,
                            'nombre_asignatura' => $asignatura->nombre,
                            'tipo_asignatura' => $asignatura->tipo_asignatura,
                            'titulo_declarado' => $tituloDeclarado,
                            'anio_edicion' => $bibliografia->anio_publicacion,
                            'ejemplares_impresos' => $ejemplaresImpresos,
                            'ejemplares_digitales' => $ejemplaresDigitales,
                            'cobertura' => $cobertura,
                            'disponible' => $disponible,
                            'id_bibliografia_declarada' => $bibliografia->id
                        ]);
                    } catch (\Exception $e) {
                        error_log('ReporteController@reporteBibliografiaBasicaExpandido: Error al procesar bibliografía ' . $bibliografia->id . ' para asignatura ' . $asignatura->codigo . ': ' . $e->getMessage());
                        // Continuar con la siguiente bibliografía
                        continue;
                    }
                }
            }
        }

        // Filtrar solo filas con bibliografía declarada real
        $datosBibliografia = $datosBibliografia->filter(function($fila) {
            return !empty($fila['id_bibliografia_declarada']);
        })->values();

        // Calcular totales de la carrera considerando títulos declarados únicos (sin duplicados)
        $totalesCarrera = [
            'titulos_declarados' => 0,
            'ejemplares_impresos' => 0,
            'ejemplares_digitales' => 0,
            'titulos_disponibles' => 0
        ];
        
        // Obtener códigos de asignaturas para calcular totales únicos
        $codigosAsignaturas = $asignaturas->pluck('codigo')->toArray();
        
        // Contar títulos declarados únicos para toda la carrera
        $titulosDeclaradosUnicos = DB::table('bibliografias_declaradas')
            ->join('asignaturas_bibliografias', 'bibliografias_declaradas.id', '=', 'asignaturas_bibliografias.bibliografia_id')
            ->join('asignaturas', 'asignaturas_bibliografias.asignatura_id', '=', 'asignaturas.id')
            ->join('asignaturas_departamentos', 'asignaturas.id', '=', 'asignaturas_departamentos.asignatura_id')
            ->whereIn('asignaturas_departamentos.codigo_asignatura', $codigosAsignaturas)
            ->where('asignaturas_bibliografias.tipo_bibliografia', 'basica')
            ->where('asignaturas_bibliografias.estado', 'activa')
            ->distinct('bibliografias_declaradas.id')
            ->count('bibliografias_declaradas.id');
            
        // Contar títulos disponibles únicos para toda la carrera
        $titulosDisponiblesUnicos = DB::table('bibliografias_declaradas')
            ->join('asignaturas_bibliografias', 'bibliografias_declaradas.id', '=', 'asignaturas_bibliografias.bibliografia_id')
            ->join('asignaturas', 'asignaturas_bibliografias.asignatura_id', '=', 'asignaturas.id')
            ->join('asignaturas_departamentos', 'asignaturas.id', '=', 'asignaturas_departamentos.asignatura_id')
            ->whereIn('asignaturas_departamentos.codigo_asignatura', $codigosAsignaturas)
            ->where('asignaturas_bibliografias.tipo_bibliografia', 'basica')
            ->where('asignaturas_bibliografias.estado', 'activa')
            ->whereExists(function ($query) use ($sedeId) {
                $query->select(DB::raw(1))
                    ->from('bibliografias_disponibles')
                    ->whereRaw('bibliografias_disponibles.bibliografia_declarada_id = bibliografias_declaradas.id')
                    ->where('bibliografias_disponibles.estado', 1)
                    ->where(function ($subQuery) use ($sedeId) {
                        $subQuery->whereIn('bibliografias_disponibles.disponibilidad', ['electronico', 'ambos'])
                                ->orWhere(function ($q) use ($sedeId) {
                                    $q->where('bibliografias_disponibles.disponibilidad', 'impreso')
                                      ->whereExists(function ($sub) use ($sedeId) {
                                          $sub->select(DB::raw(1))
                                              ->from('bibliografias_disponibles_sedes')
                                              ->whereRaw('bibliografias_disponibles_sedes.bibliografia_disponible_id = bibliografias_disponibles.id')
                                              ->where('bibliografias_disponibles_sedes.sede_id', $sedeId)
                                              ->where('bibliografias_disponibles_sedes.ejemplares', '>', 0);
                                      });
                                });
                    });
            })
            ->distinct('bibliografias_declaradas.id')
            ->count('bibliografias_declaradas.id');
        
        // Sumar ejemplares de todas las filas (estos sí se suman)
        foreach ($datosBibliografia as $fila) {
            $totalesCarrera['ejemplares_impresos'] += $fila['ejemplares_impresos'] ?? 0;
        }
        
        // Calcular total de ejemplares digitales considerando valores especiales
        $totalesCarrera['ejemplares_digitales'] = $this->calcularTotalEjemplaresDigitales($datosBibliografia);
        
        $totalesCarrera['titulos_declarados'] = $titulosDeclaradosUnicos;
        $totalesCarrera['titulos_disponibles'] = $titulosDisponiblesUnicos;
        
            $coberturaBasicaTotal = $totalesCarrera['titulos_declarados'] > 0 
                ? round(($totalesCarrera['titulos_disponibles'] / $totalesCarrera['titulos_declarados']) * 100, 2) 
                : 0;

        // Renderizar la vista Twig con los datos del reporte expandido
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $sessionData = [
            'user_id' => $_SESSION['user_id'] ?? null,
            'user_email' => $_SESSION['user_email'] ?? null,
            'user_nombre' => $_SESSION['user_nombre'] ?? null,
            'user_rol' => $_SESSION['user_rol'] ?? null
        ];

        $view = new \Twig\Environment(new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../templates'));
        $template = $view->load('reportes/coberturas/carrera_expandido.twig');
        $html = $template->render([
            'carrera' => $carrera,
            'datos_bibliografia' => $datosBibliografia,
            'session' => $_SESSION ?? [],
            'app_url' => app_url(),
            'tipos_formacion_disponibles' => $tiposFormacionDisponibles,
            'tipos_formacion_seleccionados' => $tiposFormacionFiltro,
            'hay_filtros_aplicados' => $hayFiltrosAplicados,
            'todos_filtros_guardados_en_cero' => $todosFiltrosGuardadosEnCero,
            'totales_carrera' => $totalesCarrera,
            'cobertura_basica_total' => $coberturaBasicaTotal,
            'current_page' => 'coberturas'
        ]);
        $response->getBody()->write($html);
        return $response->withHeader('Content-Type', 'text/html');
        } catch (\Exception $e) {
            error_log('ReporteController@reporteBibliografiaBasicaExpandido: Error general en el método: ' . $e->getMessage());
            error_log('ReporteController@reporteBibliografiaBasicaExpandido: Stack trace: ' . $e->getTraceAsString());
            $response->getBody()->write('Error interno del servidor. Por favor, inténtelo de nuevo más tarde.');
            return $response->withStatus(500)->withHeader('Content-Type', 'text/html');
        }
    }

    public function exportarBibliografiaBasicaExcel($request, $response, $args): Response
    {
        $sedeId = $args['sede_id'];
        $carreraId = $args['carrera_id'];

        // Obtener la carrera antes de usarla
        $carrera = DB::table('vw_mallas')
            ->where('id_sede', $sedeId)
            ->where('id_carrera', $carreraId)
            ->select(
                'id_sede as sede_id',
                'id_carrera as carrera_id',
                'sede as sede',
                'codigo_carrera as codigo',
                'carrera as nombre'
            )
            ->first();

        if (!$carrera) {
            $response->getBody()->write(json_encode(['error' => 'Carrera no encontrada']));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }

        // Obtener parámetros de filtro de la URL
        $queryParams = $request->getQueryParams();
        $tiposFormacionFiltro = $queryParams['tipos_formacion'] ?? [];
        if (!is_array($tiposFormacionFiltro)) {
            $tiposFormacionFiltro = [$tiposFormacionFiltro];
        }
        $tiposFormacionVacio = $queryParams['tipos_formacion_vacio'] ?? null;
        
        // Obtener asignaturas REGULARES (siempre incluidas)
        $regulares = DB::table('vw_mallas')
            ->where('id_sede', $sedeId)
            ->where('codigo_carrera', $carrera->codigo)
            ->where('tipo_asignatura', 'REGULAR')
            ->select('codigo_asignatura as codigo', 'asignatura as nombre', 'tipo_asignatura')
            ->distinct()
            ->get();

        // Obtener asignaturas de los tipos de formación seleccionados
        $formaciones = collect();
        
        // Lógica simplificada: solo incluir formación si hay filtros explícitos
        if (!empty($tiposFormacionFiltro)) {
            // Si hay filtros aplicados explícitamente, usar solo los seleccionados
        $formaciones = DB::table('vw_mallas')
                ->where('id_sede', $sedeId)
            ->where('codigo_carrera', $carrera->codigo)
                ->whereIn('tipo_asignatura', $tiposFormacionFiltro)
            ->whereNotNull('codigo_asignatura_formacion')
                ->select(
                    'codigo_asignatura_formacion as codigo', 
                    'asignatura_formacion as nombre', 
                    'tipo_asignatura'
                )
            ->distinct()
            ->get();
        }
        // Si no hay filtros explícitos o están vacíos, solo usar regulares (formaciones = collect() vacío)

        $asignaturas = $regulares->merge($formaciones)->unique('codigo')->values();

        // Calcular estadísticas para cada asignatura
        foreach ($asignaturas as $asignatura) {
            // Estado
            $asignatura->estado = 'Activa';
            $asignaturaId = DB::table('asignaturas_departamentos')
                ->where('codigo_asignatura', $asignatura->codigo)
                ->value('asignatura_id');
            $bibliografiaDetallada = collect();
            if ($asignaturaId) {
                $bibliografiaDetallada = DB::table('asignaturas_bibliografias')
                    ->join('bibliografias_declaradas', 'asignaturas_bibliografias.bibliografia_id', '=', 'bibliografias_declaradas.id')
                    ->where('asignaturas_bibliografias.asignatura_id', $asignaturaId)
                    ->where('asignaturas_bibliografias.tipo_bibliografia', 'basica')
                    ->where('asignaturas_bibliografias.estado', 'activa')
                    ->select(
                        'bibliografias_declaradas.id',
                        'bibliografias_declaradas.titulo',
                        'bibliografias_declaradas.anio_publicacion',
                        'bibliografias_declaradas.tipo',
                        'bibliografias_declaradas.editorial',
                        'bibliografias_declaradas.edicion',
                        'bibliografias_declaradas.isbn',
                        'bibliografias_declaradas.doi',
                        'bibliografias_declaradas.formato',
                        'bibliografias_declaradas.url',
                        'bibliografias_declaradas.nota'
                    )
                    ->get();
            }
            // Calcular valores por bibliografía usando la nueva función
            $resultado = $this->calcularEjemplaresAsignatura($bibliografiaDetallada, $sedeId);
            $asignatura->titulos_declarados = $resultado['titulos_declarados'];
            $asignatura->titulos_disponibles = $resultado['titulos_disponibles'];
            $asignatura->ejemplares_impresos = $resultado['ejemplares_impresos'];
            $asignatura->ejemplares_digitales = $resultado['ejemplares_digitales'];
            $asignatura->cobertura_basica = $resultado['cobertura_basica'];
        }

        // Calcular totales de la carrera considerando títulos declarados únicos (sin duplicados)
        $totalesCarrera = [
            'titulos_declarados' => 0,
            'titulos_disponibles' => 0,
            'ejemplares_impresos' => 0,
            'ejemplares_digitales' => 0
        ];
        
        // Obtener códigos de asignaturas para calcular totales únicos
        $codigosAsignaturas = $asignaturas->pluck('codigo')->toArray();
        
        // Contar títulos declarados únicos para toda la carrera
        $titulosDeclaradosUnicos = DB::table('bibliografias_declaradas')
            ->join('asignaturas_bibliografias', 'bibliografias_declaradas.id', '=', 'asignaturas_bibliografias.bibliografia_id')
            ->join('asignaturas', 'asignaturas_bibliografias.asignatura_id', '=', 'asignaturas.id')
            ->join('asignaturas_departamentos', 'asignaturas.id', '=', 'asignaturas_departamentos.asignatura_id')
            ->whereIn('asignaturas_departamentos.codigo_asignatura', $codigosAsignaturas)
            ->where('asignaturas_bibliografias.tipo_bibliografia', 'basica')
            ->where('asignaturas_bibliografias.estado', 'activa')
            ->distinct('bibliografias_declaradas.id')
            ->count('bibliografias_declaradas.id');
            
        // Contar títulos disponibles únicos para toda la carrera
        $titulosDisponiblesUnicos = DB::table('bibliografias_declaradas')
            ->join('asignaturas_bibliografias', 'bibliografias_declaradas.id', '=', 'asignaturas_bibliografias.bibliografia_id')
            ->join('asignaturas', 'asignaturas_bibliografias.asignatura_id', '=', 'asignaturas.id')
            ->join('asignaturas_departamentos', 'asignaturas.id', '=', 'asignaturas_departamentos.asignatura_id')
            ->whereIn('asignaturas_departamentos.codigo_asignatura', $codigosAsignaturas)
            ->where('asignaturas_bibliografias.tipo_bibliografia', 'basica')
            ->where('asignaturas_bibliografias.estado', 'activa')
            ->whereExists(function ($query) use ($sedeId) {
                $query->select(DB::raw(1))
                    ->from('bibliografias_disponibles')
                    ->whereRaw('bibliografias_disponibles.bibliografia_declarada_id = bibliografias_declaradas.id')
                    ->where('bibliografias_disponibles.estado', 1)
                    ->where(function ($subQuery) use ($sedeId) {
                        $subQuery->whereIn('bibliografias_disponibles.disponibilidad', ['electronico', 'ambos'])
                                ->orWhere(function ($q) use ($sedeId) {
                                    $q->where('bibliografias_disponibles.disponibilidad', 'impreso')
                                      ->whereExists(function ($sub) use ($sedeId) {
                                          $sub->select(DB::raw(1))
                                              ->from('bibliografias_disponibles_sedes')
                                              ->whereRaw('bibliografias_disponibles_sedes.bibliografia_disponible_id = bibliografias_disponibles.id')
                                              ->where('bibliografias_disponibles_sedes.sede_id', $sedeId)
                                              ->where('bibliografias_disponibles_sedes.ejemplares', '>', 0);
                                      });
                                });
                    });
            })
            ->distinct('bibliografias_declaradas.id')
            ->count('bibliografias_declaradas.id');
        
        // Sumar ejemplares de todas las asignaturas (estos sí se suman)
        foreach ($asignaturas as $asig) {
            // Solo sumar valores positivos (ignorar -1 y -2)
            if (($asig->ejemplares_impresos ?? 0) > 0) {
                $totalesCarrera['ejemplares_impresos'] += $asig->ejemplares_impresos;
            }
            }
        
        // Calcular total de ejemplares digitales considerando valores especiales
        $totalesCarrera['ejemplares_digitales'] = $this->calcularTotalEjemplaresDigitales($asignaturas);
        
        $totalesCarrera['titulos_declarados'] = $titulosDeclaradosUnicos;
        $totalesCarrera['titulos_disponibles'] = $titulosDisponiblesUnicos;
        
            $coberturaBasicaTotal = $totalesCarrera['titulos_declarados'] > 0 
                ? round(($totalesCarrera['titulos_disponibles'] / $totalesCarrera['titulos_declarados']) * 100, 2) 
                : 0;

        // Crear el archivo Excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Bibliografía Básica');
        $headers = ['Código Asignatura', 'Nombre', 'Tipo Asignatura', 'Estado', 'Títulos Declarados', 'Títulos Disponibles', 'Ejemplares Impresos', 'Ejemplares Digitales', 'Cobertura Básica'];
        $sheet->fromArray($headers, null, 'A1');
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4472C4']],
            'alignment' => ['horizontal' => 'center'],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']]]
        ];
        $sheet->getStyle('A1:I1')->applyFromArray($headerStyle);
        $rowNum = 2;
        foreach ($asignaturas as $asignatura) {
            $sheet->setCellValue('A'.$rowNum, $asignatura->codigo);
            $sheet->setCellValue('B'.$rowNum, $asignatura->nombre);
            $sheet->setCellValue('C'.$rowNum, $asignatura->tipo_asignatura);
            $sheet->setCellValue('D'.$rowNum, $asignatura->estado ?? '');
            $sheet->setCellValue('E'.$rowNum, $asignatura->titulos_declarados ?? '');
            $sheet->setCellValue('F'.$rowNum, $asignatura->titulos_disponibles ?? '');
            // Ejemplares Impresos: usar función helper
            $ejemImpStr = $this->convertirValorEspecial($asignatura->ejemplares_impresos ?? 0, 'impresos', $asignatura->titulos_disponibles ?? 0);
            $sheet->setCellValue('G'.$rowNum, $ejemImpStr);
            
            // Ejemplares Digitales: usar función helper
            $ejemDigStr = $this->convertirValorEspecial($asignatura->ejemplares_digitales ?? 0, 'digitales', $asignatura->titulos_disponibles ?? 0);
            $sheet->setCellValue('H'.$rowNum, $ejemDigStr);
            $sheet->setCellValue('I'.$rowNum, ($asignatura->cobertura_basica ?? '') . '%');
            // Centrar columnas D-I
            $sheet->getStyle('D'.$rowNum.':I'.$rowNum)->getAlignment()->setHorizontal('center');
            $rowNum++;
        }
        // Fila de totales
        $sheet->setCellValue('A'.$rowNum, 'TOTALES DE LA CARRERA');
        $sheet->mergeCells('A'.$rowNum.':D'.$rowNum);
        $sheet->getStyle('A'.$rowNum.':D'.$rowNum)->getAlignment()->setHorizontal('center');
        $sheet->setCellValue('E'.$rowNum, $totalesCarrera['titulos_declarados']);
        $sheet->setCellValue('F'.$rowNum, $totalesCarrera['titulos_disponibles']);
        // Totales ejemplares impresos: usar función helper
        $ejemImpTotStr = $this->convertirValorEspecial($totalesCarrera['ejemplares_impresos'], 'impresos', $totalesCarrera['titulos_disponibles']);
        $sheet->setCellValue('G'.$rowNum, $ejemImpTotStr);
        
        // Totales ejemplares digitales: usar función helper
        $ejemDigTotStr = $this->convertirValorEspecial($totalesCarrera['ejemplares_digitales'], 'digitales', $totalesCarrera['titulos_disponibles']);
        $sheet->setCellValue('H'.$rowNum, $ejemDigTotStr);
        $sheet->setCellValue('I'.$rowNum, $coberturaBasicaTotal.'%');
        // Centrar totales columnas E-I
        $sheet->getStyle('E'.$rowNum.':I'.$rowNum)->getAlignment()->setHorizontal('center');
        $totalStyle = [
            'font' => ['bold' => true],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F2F2F2']],
            'alignment' => ['horizontal' => 'center'],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']]]
        ];
        $sheet->getStyle('A'.$rowNum.':I'.$rowNum)->applyFromArray($totalStyle);
        // Bordes a todo el rango de la tabla
        $lastDataRow = $rowNum;
        $sheet->getStyle('A1:I'.$lastDataRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);
        foreach (range('A','I') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        $fecha = date('Ymd_His');
        $nombreArchivo = 'Reporte_Bibliografia_Basica_'.$sedeId.'_'.$carreraId.'_'.$fecha.'.xlsx';
        $rutaCarpeta = __DIR__.'/../../public/reportes/';
        if (!is_dir($rutaCarpeta)) mkdir($rutaCarpeta, 0777, true);
        $rutaCompleta = $rutaCarpeta.$nombreArchivo;
        $writer = new Xlsx($spreadsheet);
        $writer->save($rutaCompleta);
        
        // Verificar que el archivo se guardó correctamente
        if (!file_exists($rutaCompleta)) {
            error_log('exportarBibliografiaBasicaExcel: Error - archivo no se guardó: ' . $rutaCompleta);
            $response->getBody()->write(json_encode(['error' => 'No se pudo guardar el archivo Excel']));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
        
        // Devolver el archivo como descarga directa
        $fileContent = file_get_contents($rutaCompleta);
        $response->getBody()->write($fileContent);
        
        return $response
            ->withHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
            ->withHeader('Content-Disposition', 'attachment; filename="' . $nombreArchivo . '"')
            ->withHeader('Content-Length', filesize($rutaCompleta));
    }

    public function exportarBibliografiaBasicaExpandidoExcel(Request $request, Response $response, array $args): Response
    {
        try {
            error_log('ReporteController@exportarBibliografiaBasicaExpandidoExcel: Iniciando método');
            
            $sedeId = $args['sede_id'];
            $carreraId = $args['carrera_id'];
            
            // Obtener parámetros de filtro de la URL
            $queryParams = $request->getQueryParams();
            $tiposFormacionFiltro = $queryParams['tipos_formacion'] ?? [];
            // Forzar que siempre sea un array
            if (!is_array($tiposFormacionFiltro)) {
                $tiposFormacionFiltro = [$tiposFormacionFiltro];
            }
            $hayFiltrosAplicados = !empty($tiposFormacionFiltro);
            $tiposFormacionVacio = $queryParams['tipos_formacion_vacio'] ?? null;
            
            error_log('ReporteController@exportarBibliografiaBasicaExpandidoExcel: Sede ID: ' . $sedeId . ', Carrera ID: ' . $carreraId);

            // Obtener información de la sede y carrera
            $carrera = DB::table('vw_mallas')
                ->where('id_sede', $sedeId)
                ->where('id_carrera', $carreraId)
                ->select(
                    'id_sede as sede_id',
                    'id_carrera as carrera_id',
                    'sede as sede',
                    'codigo_carrera as codigo',
                    'carrera as nombre'
                )
                ->first();
                
            if (!$carrera) {
                error_log('ReporteController@exportarBibliografiaBasicaExpandidoExcel: No se encontró la carrera');
                $response->getBody()->write(json_encode(['error' => 'Carrera no encontrada']));
                return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
            }

            // Obtener asignaturas REGULARES (siempre incluidas)
            $regulares = DB::table('vw_mallas')
                ->where('id_sede', $sedeId)
                ->where('codigo_carrera', $carrera->codigo)
                ->where('tipo_asignatura', 'REGULAR')
                ->select('codigo_asignatura as codigo', 'asignatura as nombre', 'tipo_asignatura')
                ->distinct()
                ->get();

            // Obtener asignaturas de los tipos de formación seleccionados
            $formaciones = collect();
            
            // Lógica simplificada: solo incluir formación si hay filtros explícitos
            if (!empty($tiposFormacionFiltro)) {
                // Si hay filtros aplicados explícitamente, usar solo los seleccionados
                $formaciones = DB::table('vw_mallas')
                    ->where('id_sede', $sedeId)
                    ->where('codigo_carrera', $carrera->codigo)
                    ->whereIn('tipo_asignatura', $tiposFormacionFiltro)
                    ->whereNotNull('codigo_asignatura_formacion')
                    ->select(
                        'codigo_asignatura_formacion as codigo', 
                        'asignatura_formacion as nombre', 
                        'tipo_asignatura',
                        'id_sede'
                    )
                    ->distinct()
                    ->get();
            }
            // Si no hay filtros explícitos o están vacíos, solo usar regulares (formaciones = collect() vacío)

            // Unir ambos conjuntos y eliminar duplicados por código
            $asignaturas = $regulares->merge($formaciones)->unique('codigo')->values();

            // Obtener datos de bibliografía en formato de tabla plana (una fila por bibliografía)
            $datosBibliografia = collect();
            
            foreach ($asignaturas as $asignatura) {
                // Obtener el ID de la asignatura
                $asignaturaId = DB::table('asignaturas_departamentos')
                    ->where('codigo_asignatura', $asignatura->codigo)
                    ->value('asignatura_id');
                
                if ($asignaturaId) {
                    // Obtener bibliografías declaradas de tipo básica para esta asignatura
                    $bibliografias = DB::table('asignaturas_bibliografias')
                        ->join('bibliografias_declaradas', 'asignaturas_bibliografias.bibliografia_id', '=', 'bibliografias_declaradas.id')
                        ->where('asignaturas_bibliografias.asignatura_id', $asignaturaId)
                        ->where('asignaturas_bibliografias.tipo_bibliografia', 'basica')
                        ->where('asignaturas_bibliografias.estado', 'activa')
                        ->select(
                            'bibliografias_declaradas.id',
                            'bibliografias_declaradas.titulo',
                            'bibliografias_declaradas.anio_publicacion',
                            'bibliografias_declaradas.tipo',
                            'bibliografias_declaradas.editorial',
                            'bibliografias_declaradas.edicion',
                            'bibliografias_declaradas.isbn',
                            'bibliografias_declaradas.doi',
                            'bibliografias_declaradas.formato',
                            'bibliografias_declaradas.url',
                            'bibliografias_declaradas.nota'
                        )
                        ->get();
                    
                    foreach ($bibliografias as $bibliografia) {
                        // Obtener el primer autor
                        $primerAutor = DB::table('bibliografias_autores')
                            ->join('autores', 'bibliografias_autores.autor_id', '=', 'autores.id')
                            ->where('bibliografias_autores.bibliografia_id', $bibliografia->id)
                            ->select(DB::raw("CONCAT(autores.apellidos, ', ', autores.nombres) as nombre_completo"))
                            ->first();
                        
                        // Construir título declarado concatenado
                        $tituloDeclarado = $bibliografia->titulo;
                        if ($bibliografia->editorial) {
                            $tituloDeclarado .= ' - ' . $bibliografia->editorial;
                        }
                        if ($primerAutor) {
                            $tituloDeclarado .= ' - ' . $primerAutor->nombre_completo;
                        }
                        
                        // Usar la nueva lógica para calcular ejemplares
                        $resultadoEjemplares = $this->calcularEjemplaresExpandido($bibliografia->id, $sedeId);
                        $ejemplaresImpresos = $resultadoEjemplares['ejemplares_impresos'];
                        $ejemplaresDigitales = $resultadoEjemplares['ejemplares_digitales'];
                        $disponible = $resultadoEjemplares['disponible'];
                        
                        // Calcular cobertura (siempre será 100% si está disponible, 0% si no)
                        $cobertura = $disponible ? 100 : 0;
                        
                        // Crear fila de datos
                        $datosBibliografia->push([
                            'codigo_asignatura' => $asignatura->codigo,
                            'nombre_asignatura' => $asignatura->nombre,
                            'tipo_asignatura' => $asignatura->tipo_asignatura,
                            'titulo_declarado' => $tituloDeclarado,
                            'anio_edicion' => $bibliografia->anio_publicacion,
                            'ejemplares_impresos' => $ejemplaresImpresos,
                            'ejemplares_digitales' => $ejemplaresDigitales,
                            'cobertura' => $cobertura,
                        'disponible' => $disponible,
                        'id_bibliografia_declarada' => $bibliografia->id
                        ]);
                    }
                }
            }

            // Calcular totales de la carrera considerando títulos declarados únicos (sin duplicados)
            $totalesCarrera = [
                'titulos_declarados' => 0,
                'titulos_disponibles' => 0,
                'ejemplares_impresos' => 0,
                'ejemplares_digitales' => 0
            ];
            
            // Obtener códigos de asignaturas para calcular totales únicos
            $codigosAsignaturas = $asignaturas->pluck('codigo')->toArray();
            
            // Contar títulos declarados únicos para toda la carrera
            $titulosDeclaradosUnicos = DB::table('bibliografias_declaradas')
                ->join('asignaturas_bibliografias', 'bibliografias_declaradas.id', '=', 'asignaturas_bibliografias.bibliografia_id')
                ->join('asignaturas', 'asignaturas_bibliografias.asignatura_id', '=', 'asignaturas.id')
                ->join('asignaturas_departamentos', 'asignaturas.id', '=', 'asignaturas_departamentos.asignatura_id')
                ->whereIn('asignaturas_departamentos.codigo_asignatura', $codigosAsignaturas)
                ->where('asignaturas_bibliografias.tipo_bibliografia', 'basica')
                ->where('asignaturas_bibliografias.estado', 'activa')
                ->distinct('bibliografias_declaradas.id')
                ->count('bibliografias_declaradas.id');
                
            // Contar títulos disponibles únicos para toda la carrera
            $titulosDisponiblesUnicos = DB::table('bibliografias_declaradas')
                ->join('asignaturas_bibliografias', 'bibliografias_declaradas.id', '=', 'asignaturas_bibliografias.bibliografia_id')
                ->join('asignaturas', 'asignaturas_bibliografias.asignatura_id', '=', 'asignaturas.id')
                ->join('asignaturas_departamentos', 'asignaturas.id', '=', 'asignaturas_departamentos.asignatura_id')
                ->whereIn('asignaturas_departamentos.codigo_asignatura', $codigosAsignaturas)
                ->where('asignaturas_bibliografias.tipo_bibliografia', 'basica')
                ->where('asignaturas_bibliografias.estado', 'activa')
                ->whereExists(function ($query) use ($sedeId) {
                    $query->select(DB::raw(1))
                        ->from('bibliografias_disponibles')
                        ->whereRaw('bibliografias_disponibles.bibliografia_declarada_id = bibliografias_declaradas.id')
                        ->where('bibliografias_disponibles.estado', 1)
                        ->where(function ($subQuery) use ($sedeId) {
                            $subQuery->whereIn('bibliografias_disponibles.disponibilidad', ['electronico', 'ambos'])
                                    ->orWhere(function ($q) use ($sedeId) {
                                        $q->where('bibliografias_disponibles.disponibilidad', 'impreso')
                                          ->whereExists(function ($sub) use ($sedeId) {
                                              $sub->select(DB::raw(1))
                                                  ->from('bibliografias_disponibles_sedes')
                                                  ->whereRaw('bibliografias_disponibles_sedes.bibliografia_disponible_id = bibliografias_disponibles.id')
                                                  ->where('bibliografias_disponibles_sedes.sede_id', $sedeId)
                                                  ->where('bibliografias_disponibles_sedes.ejemplares', '>', 0);
                                          });
                                    });
                        });
                })
                ->distinct('bibliografias_declaradas.id')
                ->count('bibliografias_declaradas.id');
            
            // Sumar ejemplares de todas las filas (estos sí se suman)
            foreach ($datosBibliografia as $fila) {
                $totalesCarrera['ejemplares_impresos'] += $fila['ejemplares_impresos'] ?? 0;
                $totalesCarrera['ejemplares_digitales'] += is_numeric($fila['ejemplares_digitales']) ? $fila['ejemplares_digitales'] : 0;
            }
            
            $totalesCarrera['titulos_declarados'] = $titulosDeclaradosUnicos;
            $totalesCarrera['titulos_disponibles'] = $titulosDisponiblesUnicos;
            
                $coberturaBasicaTotal = $totalesCarrera['titulos_declarados'] > 0 
                    ? round(($totalesCarrera['titulos_disponibles'] / $totalesCarrera['titulos_declarados']) * 100, 2) 
                    : 0;

            // Log de depuración para totales
            error_log('DEPURACION TOTALES EXPANDIDO: titulos_declarados=' . $totalesCarrera['titulos_declarados'] . 
                     ', titulos_disponibles=' . $totalesCarrera['titulos_disponibles'] . 
                     ', ejemplares_impresos=' . $totalesCarrera['ejemplares_impresos'] . 
                     ', ejemplares_digitales=' . $totalesCarrera['ejemplares_digitales'] . 
                     ', cobertura=' . $coberturaBasicaTotal);

            // Crear el archivo Excel
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Bibl. Básica Expandida');
            $headers = ['Código Asignatura', 'Nombre Asignatura', 'Tipo Asignatura', 'Título Declarado', 'Año de Edición', 'Ejemplares Impresos', 'Ejemplares Digitales', 'Cobertura (%)'];
            $sheet->fromArray($headers, null, 'A1');
            $headerStyle = [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4472C4']],
                'alignment' => ['horizontal' => 'center'],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']]]
            ];
            $sheet->getStyle('A1:H1')->applyFromArray($headerStyle);
            $rowNum = 2;
            foreach ($datosBibliografia as $fila) {
                $sheet->setCellValue('A'.$rowNum, $fila['codigo_asignatura']);
                $sheet->setCellValue('B'.$rowNum, $fila['nombre_asignatura']);
                $sheet->setCellValue('C'.$rowNum, $fila['tipo_asignatura']);
                $sheet->setCellValue('D'.$rowNum, $fila['titulo_declarado']);
                $sheet->setCellValue('E'.$rowNum, $fila['anio_edicion']);
                // Ejemplares Impresos: usar función helper
                $ejemImpStr = $this->convertirValorEspecial($fila['ejemplares_impresos'], 'impresos', $fila['disponible'] ? 1 : 0);
                $sheet->setCellValue('F'.$rowNum, $ejemImpStr);
                
                // Ejemplares Digitales: usar función helper
                $ejemDigStr = $this->convertirValorEspecial($fila['ejemplares_digitales'], 'digitales', $fila['disponible'] ? 1 : 0);
                $sheet->setCellValue('G'.$rowNum, $ejemDigStr);
                $sheet->setCellValue('H'.$rowNum, $fila['cobertura'].'%');
                // Centrar columnas E, F, G, H
                $sheet->getStyle('E'.$rowNum.':H'.$rowNum)->getAlignment()->setHorizontal('center');
                $rowNum++;
            }
            
            // Log de depuración antes de escribir totales
            error_log('DEPURACION ESCRIBIR TOTALES: Fila=' . $rowNum . ', titulos_declarados=' . $totalesCarrera['titulos_declarados'] . 
                     ', ejemplares_impresos=' . $totalesCarrera['ejemplares_impresos'] . 
                     ', ejemplares_digitales=' . $totalesCarrera['ejemplares_digitales'] . 
                     ', cobertura=' . $coberturaBasicaTotal);
            
            // Fila de totales
            $sheet->setCellValue('A'.$rowNum, 'TOTALES DE LA CARRERA');
            $sheet->mergeCells('A'.$rowNum.':C'.$rowNum);
            $sheet->getStyle('A'.$rowNum.':C'.$rowNum)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('D'.$rowNum, $totalesCarrera['titulos_declarados']);
            $sheet->setCellValue('E'.$rowNum, '');
            // Totales ejemplares impresos: usar función helper
            $ejemImpTotStr = $this->convertirValorEspecial($totalesCarrera['ejemplares_impresos'], 'impresos', $totalesCarrera['titulos_disponibles']);
            $sheet->setCellValue('F'.$rowNum, $ejemImpTotStr);
            
            // Totales ejemplares digitales: usar función helper
            $ejemDigTotStr = $this->convertirValorEspecial($totalesCarrera['ejemplares_digitales'], 'digitales', $totalesCarrera['titulos_disponibles']);
            $sheet->setCellValue('G'.$rowNum, $ejemDigTotStr);
            $sheet->setCellValue('H'.$rowNum, $coberturaBasicaTotal.'%');
            // Centrar totales columnas D, F, G, H
            $sheet->getStyle('D'.$rowNum.':H'.$rowNum)->getAlignment()->setHorizontal('center');
            $totalStyle = [
                'font' => ['bold' => true],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F2F2F2']],
                'alignment' => ['horizontal' => 'center'],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']]]
            ];
            $sheet->getStyle('A'.$rowNum.':H'.$rowNum)->applyFromArray($totalStyle);
            
            // Bordes a todo el rango de la tabla
            $lastDataRow = $rowNum;
            $sheet->getStyle('A1:H'.$lastDataRow)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000']
                    ]
                ]
            ]);
            
            foreach (range('A','H') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }
            
            $fecha = date('Ymd_His');
            $nombreArchivo = 'Reporte_Expandido_Bibliografia_Basica_'.$sedeId.'_'.$carreraId.'_'.$fecha.'.xlsx';
            $rutaCarpeta = __DIR__.'/../../public/reportes/';
            
            // Verificar y crear la carpeta si no existe
            if (!is_dir($rutaCarpeta)) {
                error_log('ReporteController@exportarBibliografiaBasicaExpandidoExcel: Creando carpeta: ' . $rutaCarpeta);
                if (!mkdir($rutaCarpeta, 0777, true)) {
                    error_log('ReporteController@exportarBibliografiaBasicaExpandidoExcel: Error al crear carpeta: ' . $rutaCarpeta);
                    throw new \Exception('No se pudo crear la carpeta de reportes');
                }
            }
            
            // Verificar permisos de escritura
            if (!is_writable($rutaCarpeta)) {
                error_log('ReporteController@exportarBibliografiaBasicaExpandidoExcel: Error - carpeta no escribible: ' . $rutaCarpeta);
                throw new \Exception('La carpeta de reportes no tiene permisos de escritura');
            }
            
            $rutaCompleta = $rutaCarpeta.$nombreArchivo;
            error_log('ReporteController@exportarBibliografiaBasicaExpandidoExcel: Guardando archivo en: ' . $rutaCompleta);
            
            $writer = new Xlsx($spreadsheet);
            $writer->save($rutaCompleta);
            
            // Verificar que el archivo se guardó correctamente
            if (!file_exists($rutaCompleta)) {
                error_log('ReporteController@exportarBibliografiaBasicaExpandidoExcel: Error - archivo no se guardó: ' . $rutaCompleta);
                throw new \Exception('No se pudo guardar el archivo Excel');
            }
            
            error_log('ReporteController@exportarBibliografiaBasicaExpandidoExcel: Archivo guardado exitosamente. Tamaño: ' . filesize($rutaCompleta) . ' bytes');
            
            error_log('ReporteController@exportarBibliografiaBasicaExpandidoExcel: Archivo generado: ' . $rutaCompleta);
            
            // Verificar que el archivo existe
            if (!file_exists($rutaCompleta)) {
                error_log('ReporteController@exportarBibliografiaBasicaExpandidoExcel: Error - archivo no encontrado: ' . $rutaCompleta);
                $response->getBody()->write(json_encode(['error' => 'Error: El archivo no se generó correctamente']));
                return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
            }
            
            // Devolver el archivo como descarga directa
            $fileContent = file_get_contents($rutaCompleta);
            $response->getBody()->write($fileContent);
            
            return $response
                ->withHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
                ->withHeader('Content-Disposition', 'attachment; filename="' . $nombreArchivo . '"')
                ->withHeader('Content-Length', filesize($rutaCompleta));
        } catch (\Throwable $e) {
            error_log('Error en exportarBibliografiaBasicaExpandidoExcel: ' . $e->getMessage());
            $response->getBody()->write(json_encode(['error' => 'Error al generar el archivo Excel: ' . $e->getMessage()]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    // Reporte de cobertura complementaria inicial
    public function coberturaComplementaria(Request $request, Response $response, array $args): Response
    {
        error_log('ReporteController@coberturaComplementaria: Iniciando método');
        
        // Obtener datos de sesión
        $sessionData = $_SESSION ?? [];
        
        // Obtener todas las carreras con información de sede
        $carreras = DB::table('carreras_espejos')
            ->join('carreras', 'carreras_espejos.carrera_id', '=', 'carreras.id')
            ->join('sedes', 'carreras_espejos.sede_id', '=', 'sedes.id')
            ->select(
                'sedes.nombre as sede',
                'carreras_espejos.codigo_carrera as codigo',
                'carreras.nombre',
                'carreras.tipo_programa',
                'carreras.estado',
                'carreras.id as carrera_id',
                'sedes.id as sede_id'
            )
            ->orderBy('sedes.nombre')
            ->orderBy('carreras_espejos.codigo_carrera')
            ->get();
        error_log('ReporteController@coberturaComplementaria: Total carreras encontradas: ' . count($carreras));

        $view = new \Twig\Environment(new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../templates'));
        $template = $view->load('reportes/coberturas_complementaria/index.twig');
        $html = $template->render([
            'carreras' => $carreras,
            'session' => $sessionData,
            'app_url' => app_url(),
            'current_page' => 'coberturas'
        ]);
        error_log('ReporteController@coberturaComplementaria: Vista renderizada correctamente');
        $response->getBody()->write($html);
        return $response->withHeader('Content-Type', 'text/html');
    }

    // Reporte de bibliografía complementaria por carrera
    public function reporteBibliografiaComplementaria(Request $request, Response $response, array $args): Response
    {
        error_log('ReporteController@reporteBibliografiaComplementaria: Iniciando método');
        
        $sedeId = $args['sede_id'];
        $carreraId = $args['carrera_id'];
        
        error_log('ReporteController@reporteBibliografiaComplementaria: Sede ID: ' . $sedeId . ', Carrera ID: ' . $carreraId);

        // Obtener información de la sede y carrera usando la vista vw_mallas con la nueva estructura
        $carrera = DB::table('vw_mallas')
            ->where('id_sede', $sedeId)
            ->where('id_carrera', $carreraId)
            ->select(
                'id_sede as sede_id',
                'id_carrera as carrera_id',
                'sede as sede',
                'codigo_carrera as codigo',
                'carrera as nombre'
            )
            ->first();
            
        if (!$carrera) {
            error_log('ReporteController@reporteBibliografiaComplementaria: No se encontró la carrera');
            $response->getBody()->write('Carrera no encontrada');
            return $response->withStatus(404);
        }
        
        // Obtener parámetros de filtro de la URL
        $queryParams = $request->getQueryParams();
        $tiposFormacionFiltro = $queryParams['tipos_formacion'] ?? [];
        
        // Forzar que siempre sea un array
        if (!is_array($tiposFormacionFiltro)) {
            $tiposFormacionFiltro = [$tiposFormacionFiltro];
        }
        
        $hayFiltrosAplicados = !empty($tiposFormacionFiltro);
        
        $tiposFormacionVacio = $request->getQueryParams()['tipos_formacion_vacio'] ?? null;
        
        // Si no hay filtros en la URL, intentar cargar filtros guardados
        if (empty($tiposFormacionFiltro) && !$tiposFormacionVacio) {
            // Obtener el id_carrera_espejo para la carrera y sede específica
            $carreraEspejo = DB::table('carreras_espejos')
                ->where('codigo_carrera', $carrera->codigo)
                ->where('sede_id', $sedeId)
                ->first();
            
            if ($carreraEspejo) {
                $filtrosGuardados = DB::table('filtros_formaciones')
                    ->where('id_carrera_espejo', $carreraEspejo->id)
                    ->first();
                if ($filtrosGuardados) {
                    // Solo cargar filtros si al menos uno está marcado como 1
                    $filtrosMarcados = 0;
                    $tiposFormacionFiltro = [];
                    
                    if ($filtrosGuardados->basica == 1) {
                        $tiposFormacionFiltro[] = 'FORMACION_BASICA';
                        $filtrosMarcados++;
                    }
                    if ($filtrosGuardados->general == 1) {
                        $tiposFormacionFiltro[] = 'FORMACION_GENERAL';
                        $filtrosMarcados++;
                    }
                    if ($filtrosGuardados->idioma == 1) {
                        $tiposFormacionFiltro[] = 'FORMACION_IDIOMAS';
                        $filtrosMarcados++;
                    }
                    if ($filtrosGuardados->profesional == 1) {
                        $tiposFormacionFiltro[] = 'FORMACION_PROFESIONAL';
                        $filtrosMarcados++;
                    }
                    if ($filtrosGuardados->valores == 1) {
                        $tiposFormacionFiltro[] = 'FORMACION_VALORES';
                        $filtrosMarcados++;
                    }
                    if ($filtrosGuardados->especialidad == 1) {
                        $tiposFormacionFiltro[] = 'FORMACION_ESPECIALIDAD';
                        $filtrosMarcados++;
                    }
                    if ($filtrosGuardados->especial == 1) {
                        $tiposFormacionFiltro[] = 'FORMACION_ESPECIAL';
                        $filtrosMarcados++;
                    }
                    
                    // Solo aplicar filtros si al menos uno está marcado
                    if ($filtrosMarcados > 0) {
                        $hayFiltrosAplicados = true;
                    error_log('ReporteController@reporteBibliografiaComplementaria: Filtros guardados cargados: ' . print_r($tiposFormacionFiltro, true));
                    } else {
                        // Si todos los filtros están en 0, no aplicar ningún filtro
                        $tiposFormacionFiltro = [];
                        $hayFiltrosAplicados = false;
                        error_log('ReporteController@reporteBibliografiaComplementaria: Todos los filtros guardados están desmarcados, no se aplican filtros');
                    }
                }
            }
        }

        // Obtener asignaturas REGULARES (siempre incluidas)
        $regulares = DB::table('vw_mallas')
            ->where('id_sede', $sedeId)
            ->where('codigo_carrera', $carrera->codigo)
            ->where('tipo_asignatura', 'REGULAR')
            ->select('codigo_asignatura as codigo', 'asignatura as nombre', 'tipo_asignatura')
            ->distinct()
            ->get();

        // Obtener asignaturas de los tipos de formación seleccionados
        $formaciones = collect();
        if (!empty($tiposFormacionFiltro)) {
            // Si hay filtros aplicados explícitamente, usar solo los seleccionados
            $formaciones = DB::table('vw_mallas')
                ->where('codigo_carrera', $carrera->codigo)
                ->whereIn('tipo_asignatura', $tiposFormacionFiltro)
                ->whereNotNull('codigo_asignatura_formacion')
                ->select(
                    'codigo_asignatura_formacion as codigo', 
                    'asignatura_formacion as nombre', 
                    'tipo_asignatura',
                    'id_sede'
                )
                ->distinct()
                ->get();
        } elseif ($tiposFormacionVacio) {
            // El usuario desmarcó todo: solo asignaturas regulares
            $formaciones = collect();
        } else {
            // Primera carga: solo asignaturas regulares (sin formaciones por defecto)
            $formaciones = collect();
        }

        // Unir ambos conjuntos y eliminar duplicados por código
        $asignaturas = $regulares->merge($formaciones)->unique('codigo')->values();

        // Obtener todos los tipos de formación disponibles para esta carrera (excluyendo REGULAR y ELECTIVA)
        $tiposFormacionDisponibles = DB::table('vw_mallas')
            ->where('codigo_carrera', $carrera->codigo)
            ->whereNotIn('tipo_asignatura', ['REGULAR', 'FORMACION_ELECTIVA'])
            ->whereNotNull('codigo_asignatura_formacion') // Solo asignaturas que tienen código de formación
            ->pluck('tipo_asignatura')
            ->unique()
            ->values()
            ->toArray();

        // Calcular estadísticas para cada asignatura y obtener bibliografía detallada
        foreach ($asignaturas as $asignatura) {
            // Estado
            $asignatura->estado = 'Activa';
            $asignaturaId = DB::table('asignaturas_departamentos')
                ->where('codigo_asignatura', $asignatura->codigo)
                ->value('asignatura_id');
            $bibliografiaDetallada = collect();
            if ($asignaturaId) {
                $bibliografiaDetallada = DB::table('asignaturas_bibliografias')
                    ->join('bibliografias_declaradas', 'asignaturas_bibliografias.bibliografia_id', '=', 'bibliografias_declaradas.id')
                    ->where('asignaturas_bibliografias.asignatura_id', $asignaturaId)
                    ->where('asignaturas_bibliografias.tipo_bibliografia', 'complementaria')
                    ->where('asignaturas_bibliografias.estado', 'activa')
                    ->select(
                        'bibliografias_declaradas.id',
                        'bibliografias_declaradas.titulo',
                        'bibliografias_declaradas.anio_publicacion',
                        'bibliografias_declaradas.tipo',
                        'bibliografias_declaradas.editorial',
                        'bibliografias_declaradas.edicion',
                        'bibliografias_declaradas.isbn',
                        'bibliografias_declaradas.doi',
                        'bibliografias_declaradas.formato',
                        'bibliografias_declaradas.url',
                        'bibliografias_declaradas.nota'
                    )
                    ->get();
            }
            // Calcular valores por bibliografía usando la nueva función
            $resultado = $this->calcularEjemplaresAsignatura($bibliografiaDetallada, $sedeId);
            $titulosDeclarados = $resultado['titulos_declarados'];
            $titulosDisponibles = $resultado['titulos_disponibles'];
            $ejemplaresImpresos = $resultado['ejemplares_impresos'];
            $ejemplaresDigitales = $resultado['ejemplares_digitales'];
            $coberturaComplementaria = $resultado['cobertura_basica'];
            $asignatura->titulos_declarados = $titulosDeclarados;
            $asignatura->titulos_disponibles = $titulosDisponibles;
            $asignatura->ejemplares_impresos = $ejemplaresImpresos;
            $asignatura->ejemplares_digitales = $ejemplaresDigitales;
            $asignatura->cobertura_complementaria = $coberturaComplementaria;
        }

        // Calcular totales de la carrera considerando títulos declarados únicos (sin duplicados)
        $totalesCarrera = [
            'titulos_declarados' => 0,
            'titulos_disponibles' => 0,
            'ejemplares_impresos' => 0,
            'ejemplares_digitales' => 0
        ];
        
        // Obtener códigos de asignaturas para calcular totales únicos
        $codigosAsignaturas = $asignaturas->pluck('codigo')->toArray();
        
        // Contar títulos declarados únicos para toda la carrera
        $titulosDeclaradosUnicos = DB::table('bibliografias_declaradas')
            ->join('asignaturas_bibliografias', 'bibliografias_declaradas.id', '=', 'asignaturas_bibliografias.bibliografia_id')
            ->join('asignaturas', 'asignaturas_bibliografias.asignatura_id', '=', 'asignaturas.id')
            ->join('asignaturas_departamentos', 'asignaturas.id', '=', 'asignaturas_departamentos.asignatura_id')
            ->whereIn('asignaturas_departamentos.codigo_asignatura', $codigosAsignaturas)
            ->where('asignaturas_bibliografias.tipo_bibliografia', 'complementaria')
            ->where('asignaturas_bibliografias.estado', 'activa')
            ->distinct('bibliografias_declaradas.id')
            ->count('bibliografias_declaradas.id');
            
        // Contar títulos disponibles únicos para toda la carrera
        $titulosDisponiblesUnicos = DB::table('bibliografias_declaradas')
            ->join('asignaturas_bibliografias', 'bibliografias_declaradas.id', '=', 'asignaturas_bibliografias.bibliografia_id')
            ->join('asignaturas', 'asignaturas_bibliografias.asignatura_id', '=', 'asignaturas.id')
            ->join('asignaturas_departamentos', 'asignaturas.id', '=', 'asignaturas_departamentos.asignatura_id')
            ->whereIn('asignaturas_departamentos.codigo_asignatura', $codigosAsignaturas)
            ->where('asignaturas_bibliografias.tipo_bibliografia', 'complementaria')
            ->where('asignaturas_bibliografias.estado', 'activa')
            ->whereExists(function ($query) use ($sedeId) {
                $query->select(DB::raw(1))
                    ->from('bibliografias_disponibles')
                    ->whereRaw('bibliografias_disponibles.bibliografia_declarada_id = bibliografias_declaradas.id')
                    ->where('bibliografias_disponibles.estado', 1)
                    ->where(function ($subQuery) use ($sedeId) {
                        $subQuery->whereIn('bibliografias_disponibles.disponibilidad', ['electronico', 'ambos'])
                                ->orWhere(function ($q) use ($sedeId) {
                                    $q->where('bibliografias_disponibles.disponibilidad', 'impreso')
                                      ->whereExists(function ($sub) use ($sedeId) {
                                          $sub->select(DB::raw(1))
                                              ->from('bibliografias_disponibles_sedes')
                                              ->whereRaw('bibliografias_disponibles_sedes.bibliografia_disponible_id = bibliografias_disponibles.id')
                                              ->where('bibliografias_disponibles_sedes.sede_id', $sedeId)
                                              ->where('bibliografias_disponibles_sedes.ejemplares', '>', 0);
                                      });
                                });
                    });
            })
            ->distinct('bibliografias_declaradas.id')
            ->count('bibliografias_declaradas.id');
        
        // Sumar ejemplares de todas las asignaturas (estos sí se suman)
        foreach ($asignaturas as $asig) {
            $totalesCarrera['ejemplares_impresos'] += $asig->ejemplares_impresos ?? 0;
        }
        
        // Calcular total de ejemplares digitales considerando valores especiales
        $totalesCarrera['ejemplares_digitales'] = $this->calcularTotalEjemplaresDigitales($asignaturas);
        
        $totalesCarrera['titulos_declarados'] = $titulosDeclaradosUnicos;
        $totalesCarrera['titulos_disponibles'] = $titulosDisponiblesUnicos;
        
        $coberturaComplementariaTotal = $totalesCarrera['titulos_declarados'] > 0 
            ? round(($totalesCarrera['titulos_disponibles'] / $totalesCarrera['titulos_declarados']) * 100, 2) 
            : 0;

        $coberturaComplementariaTotal = [
            'total_titulos_declarados' => $totalesCarrera['titulos_declarados'],
            'total_titulos_disponibles' => $totalesCarrera['titulos_disponibles'],
            'total_ejemplares_impresos' => $totalesCarrera['ejemplares_impresos'],
            'total_ejemplares_digitales' => $totalesCarrera['ejemplares_digitales'],
            'cobertura_complementaria_total' => $coberturaComplementariaTotal
        ];

        $view = new \Twig\Environment(new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../templates'));
        $template = $view->load('reportes/coberturas_complementaria/carrera.twig');
        
        error_log('ReporteController@reporteBibliografiaComplementaria: Tipos formación seleccionados para plantilla: ' . print_r($tiposFormacionFiltro, true));
        
        $html = $template->render([
            'carrera' => $carrera,
            'asignaturas' => $asignaturas,
            'tipos_formacion_disponibles' => $tiposFormacionDisponibles,
            'tipos_formacion_seleccionados' => $tiposFormacionFiltro,
            'hay_filtros_aplicados' => $hayFiltrosAplicados,
            'cobertura_complementaria_total' => $coberturaComplementariaTotal,
            'session' => $_SESSION ?? [],
            'app_url' => app_url(),
            'current_page' => 'coberturas'
        ]);
        
        $response->getBody()->write($html);
        return $response->withHeader('Content-Type', 'text/html');
    }

    // Método para guardar filtros de formación
    public function guardarFiltrosFormacion(Request $request, Response $response, array $args): Response
    {
        try {
            error_log('ReporteController@guardarFiltrosFormacion: Iniciando método');
        
        $sedeId = $args['sede_id'];
        $carreraId = $args['carrera_id'];
        
            // Obtener datos del cuerpo de la petición (JSON)
            $body = $request->getBody()->getContents();
            $data = json_decode($body, true);
            $filtros = $data['filtros'] ?? [];

            error_log('ReporteController@guardarFiltrosFormacion: Sede ID: ' . $sedeId . ', Carrera ID: ' . $carreraId);
            error_log('ReporteController@guardarFiltrosFormacion: Filtros recibidos: ' . print_r($filtros, true));

            // Obtener información de la carrera
        $carrera = DB::table('vw_mallas')
            ->where('id_sede', $sedeId)
            ->where('id_carrera', $carreraId)
                ->select('codigo_carrera as codigo')
            ->first();
            
            if (!$carrera) {
                error_log('ReporteController@guardarFiltrosFormacion: No se encontró la carrera');
                $response->getBody()->write(json_encode(['error' => 'Carrera no encontrada']));
                return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
            }

            // Obtener el id_carrera_espejo para la carrera y sede específica
            $carreraEspejo = DB::table('carreras_espejos')
                ->where('codigo_carrera', $carrera->codigo)
                ->where('sede_id', $sedeId)
                ->first();
            
            if (!$carreraEspejo) {
                error_log('ReporteController@guardarFiltrosFormacion: No se encontró carrera_espejo para codigo_carrera: ' . $carrera->codigo . ' y sede_id: ' . $sedeId);
                $response->getBody()->write(json_encode([
                    'error' => 'No se encontró la configuración de carrera para la sede especificada'
                ]));
                return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
            }

            // Mapear los filtros a los campos de la tabla
            $datosFiltros = [
                'id_carrera_espejo' => $carreraEspejo->id,
                'basica' => in_array('FORMACION_BASICA', $filtros) ? 1 : 0,
                'general' => in_array('FORMACION_GENERAL', $filtros) ? 1 : 0,
                'idioma' => in_array('FORMACION_IDIOMAS', $filtros) ? 1 : 0,
                'profesional' => in_array('FORMACION_PROFESIONAL', $filtros) ? 1 : 0,
                'valores' => in_array('FORMACION_VALORES', $filtros) ? 1 : 0,
                'especialidad' => in_array('FORMACION_ESPECIALIDAD', $filtros) ? 1 : 0,
                'especial' => in_array('FORMACION_ESPECIAL', $filtros) ? 1 : 0
            ];

            // Verificar si ya existen filtros para esta carrera
            $filtrosExistentes = DB::table('filtros_formaciones')
                ->where('id_carrera_espejo', $carreraEspejo->id)
            ->first();
            
            if ($filtrosExistentes) {
                // Actualizar filtros existentes
                DB::table('filtros_formaciones')
                    ->where('id_carrera_espejo', $carreraEspejo->id)
                    ->update($datosFiltros);
                error_log('ReporteController@guardarFiltrosFormacion: Filtros actualizados');
                } else {
                // Insertar nuevos filtros
                DB::table('filtros_formaciones')->insert($datosFiltros);
                error_log('ReporteController@guardarFiltrosFormacion: Nuevos filtros insertados');
            }

            $mensaje = 'Filtros guardados correctamente para la carrera ' . $carrera->codigo;
            
            $response->getBody()->write(json_encode([
                'success' => true,
                'message' => $mensaje,
                'codigo_carrera' => $carrera->codigo,
                'filtros' => $filtros
            ]));
            
            return $response->withHeader('Content-Type', 'application/json');
            
        } catch (\Throwable $e) {
            error_log('Error en guardarFiltrosFormacion: ' . $e->getMessage());
            $response->getBody()->write(json_encode([
                'error' => 'Error al guardar los filtros: ' . $e->getMessage()
            ]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    // Reporte de bibliografía complementaria expandido por carrera
    public function reporteBibliografiaComplementariaExpandido(Request $request, Response $response, array $args): Response
    {
        error_log('ReporteController@reporteBibliografiaComplementariaExpandido: Iniciando método');
            
            $sedeId = $args['sede_id'];
            $carreraId = $args['carrera_id'];
            
            // Obtener parámetros de filtro de la URL
            $queryParams = $request->getQueryParams();
            $tiposFormacionFiltro = $queryParams['tipos_formacion'] ?? [];
            
            // Forzar que siempre sea un array
            if (!is_array($tiposFormacionFiltro)) {
                $tiposFormacionFiltro = [$tiposFormacionFiltro];
            }
            
            $hayFiltrosAplicados = !empty($tiposFormacionFiltro);
        
            $tiposFormacionVacio = $queryParams['tipos_formacion_vacio'] ?? null;
            
        // Si no hay filtros en la URL, intentar cargar filtros guardados
        if (!$hayFiltrosAplicados) {
            // Obtener la carrera antes de usarla
            $carrera = DB::table('vw_mallas')
                ->where('id_sede', $sedeId)
                ->where('id_carrera', $carreraId)
                ->select(
                    'id_sede as sede_id',
                    'id_carrera as carrera_id',
                    'sede as sede',
                    'codigo_carrera as codigo',
                    'carrera as nombre'
                )
                ->first();
                
            if (!$carrera) {
                error_log('ReporteController@reporteBibliografiaComplementariaExpandido: No se encontró la carrera');
                $response->getBody()->write('Carrera no encontrada');
                return $response->withStatus(404);
            }
            
            // Obtener el id_carrera_espejo para la carrera y sede específica
            $carreraEspejo = DB::table('carreras_espejos')
                ->where('codigo_carrera', $carrera->codigo)
                ->where('sede_id', $sedeId)
                ->first();
            
            if ($carreraEspejo) {
                $filtrosGuardados = DB::table('filtros_formaciones')
                    ->where('id_carrera_espejo', $carreraEspejo->id)
                    ->first();
                    
                if ($filtrosGuardados) {
                    // Solo cargar filtros si al menos uno está marcado como 1
                    $filtrosMarcados = 0;
                    $tiposFormacionFiltro = [];
                    
                    if ($filtrosGuardados->basica == 1) {
                        $tiposFormacionFiltro[] = 'FORMACION_BASICA';
                        $filtrosMarcados++;
                    }
                    if ($filtrosGuardados->general == 1) {
                        $tiposFormacionFiltro[] = 'FORMACION_GENERAL';
                        $filtrosMarcados++;
                    }
                    if ($filtrosGuardados->idioma == 1) {
                        $tiposFormacionFiltro[] = 'FORMACION_IDIOMAS';
                        $filtrosMarcados++;
                    }
                    if ($filtrosGuardados->profesional == 1) {
                        $tiposFormacionFiltro[] = 'FORMACION_PROFESIONAL';
                        $filtrosMarcados++;
                    }
                    if ($filtrosGuardados->valores == 1) {
                        $tiposFormacionFiltro[] = 'FORMACION_VALORES';
                        $filtrosMarcados++;
                    }
                    if ($filtrosGuardados->especialidad == 1) {
                        $tiposFormacionFiltro[] = 'FORMACION_ESPECIALIDAD';
                        $filtrosMarcados++;
                    }
                    if ($filtrosGuardados->especial == 1) {
                        $tiposFormacionFiltro[] = 'FORMACION_ESPECIAL';
                        $filtrosMarcados++;
                    }
                    
                    // Solo aplicar filtros si al menos uno está marcado
                    if ($filtrosMarcados > 0) {
                        $hayFiltrosAplicados = true;
                        error_log('ReporteController@reporteBibliografiaComplementariaExpandido: Filtros guardados cargados: ' . print_r($tiposFormacionFiltro, true));
                    } else {
                        // Si todos los filtros están en 0, no aplicar ningún filtro
                        $tiposFormacionFiltro = [];
                        $hayFiltrosAplicados = false;
                        error_log('ReporteController@reporteBibliografiaComplementariaExpandido: Todos los filtros guardados están desmarcados, no se aplican filtros');
                    }
                }
            }
        }
        
        error_log('ReporteController@reporteBibliografiaComplementariaExpandido: Sede ID: ' . $sedeId . ', Carrera ID: ' . $carreraId);

            // Obtener asignaturas REGULARES (siempre incluidas)
            $regulares = DB::table('vw_mallas')
                ->where('id_sede', $sedeId)
                ->where('codigo_carrera', $carrera->codigo)
                ->where('tipo_asignatura', 'REGULAR')
                ->select('codigo_asignatura as codigo', 'asignatura as nombre', 'tipo_asignatura')
                ->distinct()
                ->get();

            // Obtener asignaturas de los tipos de formación seleccionados
            $formaciones = collect();
            if (!empty($tiposFormacionFiltro)) {
                // Si hay filtros aplicados, usar solo los seleccionados
                $formaciones = DB::table('vw_mallas')
                    ->where('codigo_carrera', $carrera->codigo)
                    ->whereIn('tipo_asignatura', $tiposFormacionFiltro)
                    ->select(
                        'codigo_asignatura as codigo', 
                        'asignatura as nombre', 
                        'tipo_asignatura'
                    )
                    ->distinct()
                    ->get();
            } elseif ($tiposFormacionVacio) {
                // El usuario desmarcó todo: solo asignaturas regulares
                $formaciones = collect();
            } else {
                // Primera carga: solo asignaturas regulares (sin formaciones por defecto)
                $formaciones = collect();
            }

            // Unir ambos conjuntos y eliminar duplicados por código
            $asignaturas = $regulares->merge($formaciones)->unique('codigo')->values();

        // Obtener todos los tipos de formación disponibles para esta carrera (excluyendo REGULAR y ELECTIVA)
        $tiposFormacionDisponibles = DB::table('vw_mallas')
            ->where('codigo_carrera', $carrera->codigo)
            ->whereNotIn('tipo_asignatura', ['REGULAR', 'FORMACION_ELECTIVA'])
            ->whereNotNull('codigo_asignatura_formacion') // Solo asignaturas que tienen código de formación
            ->pluck('tipo_asignatura')
            ->unique()
            ->values()
            ->toArray();

        error_log('ReporteController@reporteBibliografiaComplementariaExpandido: Asignaturas regulares encontradas: ' . count($regulares));
        error_log('ReporteController@reporteBibliografiaComplementariaExpandido: Asignaturas de formación encontradas: ' . count($formaciones));
        error_log('ReporteController@reporteBibliografiaComplementariaExpandido: Total asignaturas encontradas (regulares + filtro): ' . count($asignaturas));

        // Obtener datos de bibliografía en formato de tabla plana (una fila por bibliografía)
        $datosBibliografia = collect();
        
            foreach ($asignaturas as $asignatura) {
            error_log('ReporteController@reporteBibliografiaComplementariaExpandido: Procesando asignatura: ' . $asignatura->codigo);
            
            // Obtener el ID de la asignatura
                $asignaturaId = DB::table('asignaturas_departamentos')
                    ->where('codigo_asignatura', $asignatura->codigo)
                    ->value('asignatura_id');
            
                if ($asignaturaId) {
                // Obtener bibliografías declaradas de tipo complementaria para esta asignatura
                $bibliografias = DB::table('asignaturas_bibliografias')
                        ->join('bibliografias_declaradas', 'asignaturas_bibliografias.bibliografia_id', '=', 'bibliografias_declaradas.id')
                        ->where('asignaturas_bibliografias.asignatura_id', $asignaturaId)
                        ->where('asignaturas_bibliografias.tipo_bibliografia', 'complementaria')
                        ->where('asignaturas_bibliografias.estado', 'activa')
                        ->select(
                            'bibliografias_declaradas.id',
                            'bibliografias_declaradas.titulo',
                            'bibliografias_declaradas.anio_publicacion',
                            'bibliografias_declaradas.tipo',
                            'bibliografias_declaradas.editorial',
                            'bibliografias_declaradas.edicion',
                            'bibliografias_declaradas.isbn',
                            'bibliografias_declaradas.doi',
                            'bibliografias_declaradas.formato',
                            'bibliografias_declaradas.url',
                            'bibliografias_declaradas.nota'
                        )
                        ->get();
                
                // Solo agregar filas si hay bibliografías complementarias activas y tienen id
                if ($bibliografias->isNotEmpty()) {
                    foreach ($bibliografias as $bibliografia) {
                        if (!$bibliografia->id) continue;
                        // Obtener el primer autor
                        $primerAutor = DB::table('bibliografias_autores')
                            ->join('autores', 'bibliografias_autores.autor_id', '=', 'autores.id')
                            ->where('bibliografias_autores.bibliografia_id', $bibliografia->id)
                            ->select(DB::raw("CONCAT(autores.apellidos, ', ', autores.nombres) as nombre_completo"))
                            ->first();
                        
                        // Construir título declarado concatenado
                        $tituloDeclarado = $bibliografia->titulo;
                        if ($bibliografia->editorial) {
                            $tituloDeclarado .= ' - ' . $bibliografia->editorial;
                        }
                        if ($primerAutor) {
                            $tituloDeclarado .= ' - ' . $primerAutor->nombre_completo;
                        }
                        
                        // Obtener bibliografías disponibles para esta bibliografía declarada
                        $bibliografiasDisponibles = DB::table('bibliografias_disponibles')
                            ->where('bibliografia_declarada_id', $bibliografia->id)
                            ->where('estado', 1)
                            ->select('disponibilidad', 'ejemplares_digitales')
                            ->get();

                        // Usar la nueva lógica para calcular ejemplares
                        $resultado = $this->calcularEjemplaresNuevaLogica($bibliografia->id, $sedeId, $bibliografiasDisponibles);
                        $ejemplaresImpresos = $resultado['ejemplares_impresos'];
                        $ejemplaresDigitales = $resultado['ejemplares_digitales'];
                        $disponible = $resultado['disponible'];
                        
                        // Calcular cobertura (siempre será 100% si está disponible, 0% si no)
                        $cobertura = $disponible ? 100 : 0;
                        
                        // Crear fila de datos
                        $datosBibliografia->push([
                            'codigo_asignatura' => $asignatura->codigo,
                            'nombre_asignatura' => $asignatura->nombre,
                            'tipo_asignatura' => $asignatura->tipo_asignatura,
                            'titulo_declarado' => $tituloDeclarado,
                            'anio_edicion' => $bibliografia->anio_publicacion,
                            'ejemplares_impresos' => $ejemplaresImpresos,
                            'ejemplares_digitales' => $ejemplaresDigitales,
                            'cobertura' => $cobertura,
                            'disponible' => $disponible,
                            'id_bibliografia_declarada' => $bibliografia->id
                        ]);
                    }
                }
            } else {
                // Si no existe asignaturaId, también agregar fila vacía
                $datosBibliografia->push([
                    'codigo_asignatura' => $asignatura->codigo,
                    'nombre_asignatura' => $asignatura->nombre,
                    'tipo_asignatura' => $asignatura->tipo_asignatura,
                    'titulo_declarado' => '',
                    'anio_edicion' => '',
                    'ejemplares_impresos' => 'Sin información',
                    'ejemplares_digitales' => 'Sin información',
                    'cobertura' => 0,
                    'disponible' => false,
                    'id_bibliografia_declarada' => null
                ]);
            }
            }

            // Filtrar solo filas con bibliografía declarada real
        $datosBibliografia = $datosBibliografia->filter(function($fila) {
            return !empty($fila['id_bibliografia_declarada']);
        })->values();

        // Calcular totales de la carrera considerando títulos declarados únicos (sin duplicados)
        $totalesCarrera = [
            'titulos_declarados' => 0,
            'ejemplares_impresos' => 0,
            'ejemplares_digitales' => 0,
            'titulos_disponibles' => 0
        ];
        
        // Obtener códigos de asignaturas para calcular totales únicos
        $codigosAsignaturas = $asignaturas->pluck('codigo')->toArray();
        
        // Contar títulos declarados únicos para toda la carrera
        $titulosDeclaradosUnicos = DB::table('bibliografias_declaradas')
            ->join('asignaturas_bibliografias', 'bibliografias_declaradas.id', '=', 'asignaturas_bibliografias.bibliografia_id')
            ->join('asignaturas', 'asignaturas_bibliografias.asignatura_id', '=', 'asignaturas.id')
            ->join('asignaturas_departamentos', 'asignaturas.id', '=', 'asignaturas_departamentos.asignatura_id')
            ->whereIn('asignaturas_departamentos.codigo_asignatura', $codigosAsignaturas)
            ->where('asignaturas_bibliografias.tipo_bibliografia', 'complementaria')
            ->where('asignaturas_bibliografias.estado', 'activa')
            ->distinct('bibliografias_declaradas.id')
            ->count('bibliografias_declaradas.id');
            
        // Contar títulos disponibles únicos para toda la carrera
        $titulosDisponiblesUnicos = DB::table('bibliografias_declaradas')
            ->join('asignaturas_bibliografias', 'bibliografias_declaradas.id', '=', 'asignaturas_bibliografias.bibliografia_id')
            ->join('asignaturas', 'asignaturas_bibliografias.asignatura_id', '=', 'asignaturas.id')
            ->join('asignaturas_departamentos', 'asignaturas.id', '=', 'asignaturas_departamentos.asignatura_id')
            ->whereIn('asignaturas_departamentos.codigo_asignatura', $codigosAsignaturas)
            ->where('asignaturas_bibliografias.tipo_bibliografia', 'complementaria')
            ->where('asignaturas_bibliografias.estado', 'activa')
            ->whereExists(function ($query) use ($sedeId) {
                $query->select(DB::raw(1))
                    ->from('bibliografias_disponibles')
                    ->whereRaw('bibliografias_disponibles.bibliografia_declarada_id = bibliografias_declaradas.id')
                    ->where('bibliografias_disponibles.estado', 1)
                    ->where(function ($subQuery) use ($sedeId) {
                        $subQuery->whereIn('bibliografias_disponibles.disponibilidad', ['electronico', 'ambos'])
                                ->orWhere(function ($q) use ($sedeId) {
                                    $q->where('bibliografias_disponibles.disponibilidad', 'impreso')
                                      ->whereExists(function ($sub) use ($sedeId) {
                                          $sub->select(DB::raw(1))
                                              ->from('bibliografias_disponibles_sedes')
                                              ->whereRaw('bibliografias_disponibles_sedes.bibliografia_disponible_id = bibliografias_disponibles.id')
                                              ->where('bibliografias_disponibles_sedes.sede_id', $sedeId)
                                              ->where('bibliografias_disponibles_sedes.ejemplares', '>', 0);
                                      });
                                });
                    });
            })
            ->distinct('bibliografias_declaradas.id')
            ->count('bibliografias_declaradas.id');
        
        // Sumar ejemplares de todas las filas (estos sí se suman)
        foreach ($datosBibliografia as $fila) {
            $totalesCarrera['ejemplares_impresos'] += $fila['ejemplares_impresos'] ?? 0;
        }
        
        // Calcular total de ejemplares digitales considerando valores especiales
        $totalesCarrera['ejemplares_digitales'] = $this->calcularTotalEjemplaresDigitales($datosBibliografia);
        
        $totalesCarrera['titulos_declarados'] = $titulosDeclaradosUnicos;
        $totalesCarrera['titulos_disponibles'] = $titulosDisponiblesUnicos;
        
            $coberturaComplementariaTotal = $totalesCarrera['titulos_declarados'] > 0 
                ? round(($totalesCarrera['titulos_disponibles'] / $totalesCarrera['titulos_declarados']) * 100, 2) 
                : 0;

        $view = new \Twig\Environment(new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../templates'));
        $template = $view->load('reportes/coberturas_complementaria/carrera_expandido.twig');
        
        error_log('ReporteController@reporteBibliografiaComplementariaExpandido: Tipos formación seleccionados para plantilla: ' . print_r($tiposFormacionFiltro, true));
        
        $html = $template->render([
            'carrera' => $carrera,
            'datos_bibliografia' => $datosBibliografia,
            'session' => $_SESSION ?? [],
            'app_url' => app_url(),
            'tipos_formacion_disponibles' => $tiposFormacionDisponibles,
            'tipos_formacion_seleccionados' => $tiposFormacionFiltro,
            'hay_filtros_aplicados' => $hayFiltrosAplicados,
            'totales_carrera' => $totalesCarrera,
            'cobertura_complementaria_total' => $coberturaComplementariaTotal,
            'current_page' => 'coberturas'
        ]);
        
        $response->getBody()->write($html);
        return $response->withHeader('Content-Type', 'text/html');
    }

    public function guardarCoberturaBasica(Request $request, Response $response, array $args): Response
    {
        error_log('INICIO guardarCoberturaBasica');
        error_log('Args: ' . print_r($args, true));
            
            $sedeId = $args['sede_id'];
            $carreraId = $args['carrera_id'];
            
        $body = $request->getBody()->getContents();
        error_log('Body recibido: ' . $body);
        $data = json_decode($body, true);
        error_log('Data decodificada: ' . print_r($data, true));
        
        try {
            if (!$data || !isset($data['detalles']) || !is_array($data['detalles'])) {
                $response->getBody()->write(json_encode(['error' => 'Datos de detalles inválidos']));
                return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
            }
            
            $detalles = $data['detalles'];
            $fechaMedicion = $data['fecha_medicion'] ?? date('Y-m-d H:i:s');
            // Convertir fecha_medicion a formato MySQL compatible si viene en ISO 8601
            if (strpos($fechaMedicion, 'T') !== false) {
                $fechaMedicion = str_replace('Z', '', $fechaMedicion);
                $fechaMedicion = date('Y-m-d H:i:s', strtotime($fechaMedicion));
            }
            $anio = date('Y', strtotime($fechaMedicion));

            // Obtener el código de la carrera
            $carrera = DB::table('vw_mallas')
                ->where('id_sede', $sedeId)
                ->where('id_carrera', $carreraId)
                ->select('codigo_carrera as codigo')
                ->first();
                
            if (!$carrera) {
                $response->getBody()->write(json_encode(['error' => 'Carrera no encontrada']));
                return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
            }

            $codigoCarrera = $carrera->codigo;

            // Obtener el id del reporte de coberturas básicas
            $reporte = DB::table('reportes')->where('nombre', 'Reporte de Coberturas Básicas')->first();
            if (!$reporte) {
                $response->getBody()->write(json_encode(['error' => 'No existe el reporte de coberturas básicas en la tabla reportes']));
                return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
            }
            $idReporte = $reporte->id;

            // Borrar registros existentes del año en curso para la carrera
                DB::table('reporte_coberturas_carreras_basicas')
                    ->where('id_reporte', $idReporte)
                ->where('codigo_carrera', $codigoCarrera)
                ->whereYear('fecha_medicion', $anio)
                    ->delete();
                    
            // Insertar los nuevos detalles
            foreach ($detalles as $detalle) {
                // Convertir valores especiales a números para la base de datos
                $ejemplaresImpresos = $this->convertirValorEspecialANumero($detalle['ejemplares_impresos'] ?? 0);
                $ejemplaresDigitales = $this->convertirValorEspecialANumero($detalle['ejemplares_digitales'] ?? 0);
                
                DB::table('reporte_coberturas_carreras_basicas')->insert([
                    'id_reporte' => $idReporte,
                    'codigo_carrera' => $codigoCarrera,
                    'codigo_asignatura' => $detalle['codigo_asignatura'],
                    'id_bibliografia_declarada' => $detalle['id_bibliografia_declarada'],
                    'fecha_medicion' => $fechaMedicion,
                    'no_ejem_imp' => $ejemplaresImpresos,
                    'no_ejem_dig' => $ejemplaresDigitales,
                    'no_bib_disponible_basica' => $detalle['disponible'] ?? 0
                ]);
            }

            $response->getBody()->write(json_encode(['success' => true, 'message' => 'Cobertura básica guardada correctamente']));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (\Throwable $e) {
            error_log('Error en guardarCoberturaBasica: ' . $e->getMessage());
            $response->getBody()->write(json_encode(['error' => 'Error al guardar cobertura básica: ' . $e->getMessage()]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    public function guardarCoberturaComplementaria(Request $request, Response $response, array $args): Response
    {
        error_log('INICIO guardarCoberturaComplementaria');
        error_log('Args: ' . print_r($args, true));
            
            $sedeId = $args['sede_id'];
            $carreraId = $args['carrera_id'];
            
        $body = $request->getBody()->getContents();
        error_log('Body recibido: ' . $body);
        $data = json_decode($body, true);
        error_log('Data decodificada: ' . print_r($data, true));
        
        try {
            if (!$data || !isset($data['detalles']) || !is_array($data['detalles'])) {
                $response->getBody()->write(json_encode(['error' => 'Datos de detalles inválidos']));
                return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
            }
            
            $detalles = $data['detalles'];
            $fechaMedicion = $data['fecha_medicion'] ?? date('Y-m-d H:i:s');
            // Convertir fecha_medicion a formato MySQL compatible si viene en ISO 8601
            if (strpos($fechaMedicion, 'T') !== false) {
                $fechaMedicion = str_replace('Z', '', $fechaMedicion);
                $fechaMedicion = date('Y-m-d H:i:s', strtotime($fechaMedicion));
            }
            $anio = date('Y', strtotime($fechaMedicion));

            // Obtener el código de la carrera
            $carrera = DB::table('vw_mallas')
                ->where('id_sede', $sedeId)
                ->where('id_carrera', $carreraId)
                ->select('codigo_carrera as codigo')
                ->first();
                
            if (!$carrera) {
                $response->getBody()->write(json_encode(['error' => 'Carrera no encontrada']));
                return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
            }

            $codigoCarrera = $carrera->codigo;

            // Obtener el id del reporte de coberturas complementarias
            $reporte = DB::table('reportes')->where('nombre', 'Reporte de Coberturas Complementarias')->first();
            if (!$reporte) {
                $response->getBody()->write(json_encode(['error' => 'No existe el reporte de coberturas complementarias en la tabla reportes']));
                return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
            }
            $idReporte = $reporte->id;

            // Borrar registros existentes del año en curso para la carrera
                DB::table('reporte_coberturas_carreras_complementarias')
                    ->where('id_reporte', $idReporte)
                ->where('codigo_carrera', $codigoCarrera)
                ->whereYear('fecha_medicion', $anio)
                    ->delete();
                    
            // Insertar los nuevos detalles
            foreach ($detalles as $detalle) {
                // Convertir valores especiales a números para la base de datos
                $ejemplaresImpresos = $this->convertirValorEspecialANumero($detalle['ejemplares_impresos'] ?? 0);
                $ejemplaresDigitales = $this->convertirValorEspecialANumero($detalle['ejemplares_digitales'] ?? 0);
                
                DB::table('reporte_coberturas_carreras_complementarias')->insert([
                    'id_reporte' => $idReporte,
                    'codigo_carrera' => $codigoCarrera,
                    'codigo_asignatura' => $detalle['codigo_asignatura'],
                    'id_bibliografia_declarada' => ($detalle['id_bibliografia_declarada'] === '' || is_null($detalle['id_bibliografia_declarada'])) ? null : $detalle['id_bibliografia_declarada'],
                    'fecha_medicion' => $fechaMedicion,
                    'no_ejem_imp' => $ejemplaresImpresos,
                    'no_ejem_dig' => $ejemplaresDigitales,
                    'no_bib_disponible_complementaria' => $detalle['disponible'] ?? 0
                ]);
            }

            $response->getBody()->write(json_encode(['success' => true, 'message' => 'Cobertura complementaria guardada correctamente']));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (\Throwable $e) {
            error_log('Error en guardarCoberturaComplementaria: ' . $e->getMessage());
            $response->getBody()->write(json_encode(['error' => 'Error al guardar cobertura complementaria: ' . $e->getMessage()]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    public function exportarBibliografiaComplementariaExcel($request, $response, $args): Response
    {
        try {
            error_log('ReporteController@exportarBibliografiaComplementariaExcel: Iniciando método');
            
        $sedeId = $args['sede_id'];
        $carreraId = $args['carrera_id'];

        // Obtener parámetros de filtro de la URL
        $queryParams = $request->getQueryParams();
        $tiposFormacionFiltro = $queryParams['tipos_formacion'] ?? [];
        
        // Forzar que siempre sea un array
        if (!is_array($tiposFormacionFiltro)) {
            $tiposFormacionFiltro = [$tiposFormacionFiltro];
        }
        
        $hayFiltrosAplicados = !empty($tiposFormacionFiltro);
        $tiposFormacionVacio = $queryParams['tipos_formacion_vacio'] ?? null;

        // Obtener información de la sede y carrera
        $carrera = DB::table('vw_mallas')
                ->where('id_sede', $sedeId)
                ->where('id_carrera', $carreraId)
            ->select(
                'id_sede as sede_id',
                'id_carrera as carrera_id',
                'sede as sede',
                'codigo_carrera as codigo',
                'carrera as nombre'
            )
            ->first();
            
        if (!$carrera) {
            $response->getBody()->write(json_encode(['error' => 'Carrera no encontrada']));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }



        // Obtener asignaturas REGULARES (siempre incluidas)
        $regulares = DB::table('vw_mallas')
            ->where('id_sede', $sedeId)
            ->where('codigo_carrera', $carrera->codigo)
                ->where('tipo_asignatura', 'REGULAR')
                ->select('codigo_asignatura as codigo', 'asignatura as nombre', 'tipo_asignatura')
                ->distinct()
                ->get();

        // Obtener asignaturas de los tipos de formación seleccionados
        $formaciones = collect();
        // Lógica simplificada: solo incluir formación si hay filtros explícitos
        if (!empty($tiposFormacionFiltro)) {
            // Si hay filtros aplicados explícitamente, usar solo los seleccionados
                $formaciones = DB::table('vw_mallas')
                ->where('id_sede', $sedeId)
                ->where('codigo_carrera', $carrera->codigo)
                ->whereIn('tipo_asignatura', $tiposFormacionFiltro)
                ->whereNotNull('codigo_asignatura_formacion')
                ->select(
                    'codigo_asignatura_formacion as codigo', 
                    'asignatura_formacion as nombre', 
                    'tipo_asignatura'
                )
                    ->distinct()
                    ->get();
        }
        // Si no hay filtros explícitos o están vacíos, solo usar regulares (formaciones = collect() vacío)

            $asignaturas = $regulares->merge($formaciones)->unique('codigo')->values();

        // Calcular estadísticas para cada asignatura
            foreach ($asignaturas as $asignatura) {
            // Estado
            $asignatura->estado = 'Activa';
                $asignaturaId = DB::table('asignaturas_departamentos')
                    ->where('codigo_asignatura', $asignatura->codigo)
                    ->value('asignatura_id');
            $bibliografiaDetallada = collect();
                if ($asignaturaId) {
                $bibliografiaDetallada = DB::table('asignaturas_bibliografias')
                        ->join('bibliografias_declaradas', 'asignaturas_bibliografias.bibliografia_id', '=', 'bibliografias_declaradas.id')
                        ->where('asignaturas_bibliografias.asignatura_id', $asignaturaId)
                        ->where('asignaturas_bibliografias.tipo_bibliografia', 'complementaria')
                        ->where('asignaturas_bibliografias.estado', 'activa')
                        ->select(
                            'bibliografias_declaradas.id',
                            'bibliografias_declaradas.titulo',
                            'bibliografias_declaradas.anio_publicacion',
                            'bibliografias_declaradas.tipo',
                            'bibliografias_declaradas.editorial',
                            'bibliografias_declaradas.edicion',
                            'bibliografias_declaradas.isbn',
                            'bibliografias_declaradas.doi',
                            'bibliografias_declaradas.formato',
                            'bibliografias_declaradas.url',
                            'bibliografias_declaradas.nota'
                        )
                        ->get();
            }
            // Calcular valores por bibliografía usando la nueva función
            $resultado = $this->calcularEjemplaresAsignatura($bibliografiaDetallada, $sedeId);
            $titulosDeclarados = $resultado['titulos_declarados'];
            $titulosDisponibles = $resultado['titulos_disponibles'];
            $ejemplaresImpresos = $resultado['ejemplares_impresos'];
            $ejemplaresDigitales = $resultado['ejemplares_digitales'];
            $coberturaComplementaria = $resultado['cobertura_basica'];
            $asignatura->titulos_declarados = $titulosDeclarados;
            $asignatura->titulos_disponibles = $titulosDisponibles;
            $asignatura->ejemplares_impresos = $ejemplaresImpresos;
            $asignatura->ejemplares_digitales = $ejemplaresDigitales;
            $asignatura->cobertura_complementaria = $coberturaComplementaria;
        }

        // Calcular totales de la carrera
            $totalesCarrera = [
            'titulos_declarados' => 0,
            'titulos_disponibles' => 0,
            'ejemplares_impresos' => 0,
            'ejemplares_digitales' => 0
        ];
        $codigosAsignaturas = $asignaturas->pluck('codigo');
        if ($codigosAsignaturas->isEmpty()) {
            $totalesCarrera['titulos_declarados'] = 0;
            $totalesCarrera['titulos_disponibles'] = 0;
            $totalesCarrera['ejemplares_impresos'] = 0;
            $totalesCarrera['ejemplares_digitales'] = 0;
            $coberturaComplementariaTotal = 0;
        } else {
            $bibliografiasDeclaradasUnicas = DB::table('asignaturas_bibliografias')
                ->join('asignaturas_departamentos', 'asignaturas_bibliografias.asignatura_id', '=', 'asignaturas_departamentos.asignatura_id')
                ->where('asignaturas_bibliografias.tipo_bibliografia', 'complementaria')
                ->whereIn('asignaturas_departamentos.codigo_asignatura', $codigosAsignaturas)
                ->distinct('asignaturas_bibliografias.bibliografia_id')
                ->pluck('asignaturas_bibliografias.bibliografia_id');
            $totalesCarrera['titulos_declarados'] = $bibliografiasDeclaradasUnicas->count();
            $bibliografiasDisponiblesUnicas = DB::table('asignaturas_bibliografias')
                ->join('asignaturas_departamentos', 'asignaturas_bibliografias.asignatura_id', '=', 'asignaturas_departamentos.asignatura_id')
                ->join('bibliografias_disponibles', 'asignaturas_bibliografias.bibliografia_id', '=', 'bibliografias_disponibles.bibliografia_declarada_id')
                ->where('asignaturas_bibliografias.tipo_bibliografia', 'complementaria')
                ->where('bibliografias_disponibles.estado', 1)
                ->whereIn('asignaturas_departamentos.codigo_asignatura', $codigosAsignaturas)
                ->where(function ($query) use ($sedeId) {
                    $query->where('bibliografias_disponibles.disponibilidad', 'electronico')
                          ->orWhere('bibliografias_disponibles.disponibilidad', 'ambos')
                          ->orWhere(function ($q) use ($sedeId) {
                              $q->where('bibliografias_disponibles.disponibilidad', 'impreso')
                                ->whereExists(function ($subQuery) use ($sedeId) {
                                    $subQuery->select(DB::raw(1))
                                            ->from('bibliografias_disponibles_sedes')
                                            ->whereRaw('bibliografias_disponibles_sedes.bibliografia_disponible_id = bibliografias_disponibles.id')
                                            ->where('bibliografias_disponibles_sedes.sede_id', $sedeId)
                                            ->where('bibliografias_disponibles_sedes.ejemplares', '>', 0);
                                });
                          });
                })
                ->distinct('asignaturas_bibliografias.bibliografia_id')
                ->pluck('asignaturas_bibliografias.bibliografia_id');
            $totalesCarrera['titulos_disponibles'] = $bibliografiasDisponiblesUnicas->count();
            if ($bibliografiasDeclaradasUnicas->count() > 0) {
                $totalesCarrera['ejemplares_impresos'] = DB::table('vw_bib_declarada_sede_noejem')
                    ->whereIn('id_bib_declarada', $bibliografiasDeclaradasUnicas)
                    ->where('id_sede', $sedeId)
                    ->sum('no_ejem_imp_sede') ?? 0;
            }
            if ($bibliografiasDisponiblesUnicas->count() > 0) {
                $bibliografiasDigitalesTotal = DB::table('bibliografias_disponibles')
                    ->whereIn('bibliografia_declarada_id', $bibliografiasDisponiblesUnicas)
                    ->whereIn('disponibilidad', ['ambos', 'electronico'])
                    ->get();

                if ($bibliografiasDigitalesTotal->isEmpty()) {
                    // No hay bibliografías digitales disponibles
                    $totalesCarrera['ejemplares_digitales'] = -1; // -1 indica "Sin ejemplares digitales"
                } else {
                    $ejemplaresDigitalesTotal = $bibliografiasDigitalesTotal->pluck('ejemplares_digitales');
                    // Si hay algún 0, el resultado es 0 (Ilimitado)
                    $totalesCarrera['ejemplares_digitales'] = $ejemplaresDigitalesTotal->contains(0) ? 0 : $ejemplaresDigitalesTotal->sum();
                }
            }
            $coberturaComplementariaTotal = $totalesCarrera['titulos_declarados'] > 0 
                ? round(($totalesCarrera['titulos_disponibles'] / $totalesCarrera['titulos_declarados']) * 100, 2) 
                : 0;
        }

        // Crear el archivo Excel
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Bibliografía Complementaria');
        $headers = ['Código Asignatura', 'Nombre', 'Tipo Asignatura', 'Estado', 'Títulos Declarados', 'Títulos Disponibles', 'Ejemplares Impresos', 'Ejemplares Digitales', 'Cobertura Complementaria'];
            $sheet->fromArray($headers, null, 'A1');
            $headerStyle = [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4472C4']],
                'alignment' => ['horizontal' => 'center'],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']]]
            ];
        $sheet->getStyle('A1:I1')->applyFromArray($headerStyle);
            $rowNum = 2;
        foreach ($asignaturas as $asignatura) {
            $sheet->setCellValue('A'.$rowNum, $asignatura->codigo);
            $sheet->setCellValue('B'.$rowNum, $asignatura->nombre);
            $sheet->setCellValue('C'.$rowNum, $asignatura->tipo_asignatura);
            $sheet->setCellValue('D'.$rowNum, $asignatura->estado ?? '');
            $sheet->setCellValue('E'.$rowNum, $asignatura->titulos_declarados ?? '');
            $sheet->setCellValue('F'.$rowNum, $asignatura->titulos_disponibles ?? '');
            // Ejemplares Impresos: usar función helper
            $ejemImpStr = $this->convertirValorEspecial($asignatura->ejemplares_impresos ?? 0, 'impresos', $asignatura->titulos_disponibles ?? 0);
            $sheet->setCellValue('G'.$rowNum, $ejemImpStr);
            
            // Ejemplares Digitales: usar función helper
            $ejemDigStr = $this->convertirValorEspecial($asignatura->ejemplares_digitales ?? 0, 'digitales', $asignatura->titulos_disponibles ?? 0);
            $sheet->setCellValue('H'.$rowNum, $ejemDigStr);
            $sheet->setCellValue('I'.$rowNum, ($asignatura->cobertura_complementaria ?? '') . '%');
            // Centrar columnas D-I
            $sheet->getStyle('D'.$rowNum.':I'.$rowNum)->getAlignment()->setHorizontal('center');
                $rowNum++;
            }
        // Fila de totales
            $sheet->setCellValue('A'.$rowNum, 'TOTALES DE LA CARRERA');
        $sheet->mergeCells('A'.$rowNum.':D'.$rowNum);
        $sheet->getStyle('A'.$rowNum.':D'.$rowNum)->getAlignment()->setHorizontal('center');
        $sheet->setCellValue('E'.$rowNum, $totalesCarrera['titulos_declarados']);
        $sheet->setCellValue('F'.$rowNum, $totalesCarrera['titulos_disponibles']);
        // Totales ejemplares impresos: usar función helper
        $ejemImpTotStr = $this->convertirValorEspecial($totalesCarrera['ejemplares_impresos'], 'impresos', $totalesCarrera['titulos_disponibles']);
        $sheet->setCellValue('G'.$rowNum, $ejemImpTotStr);
        
        // Totales ejemplares digitales: usar función helper
        $ejemDigTotStr = $this->convertirValorEspecial($totalesCarrera['ejemplares_digitales'], 'digitales', $totalesCarrera['titulos_disponibles']);
        $sheet->setCellValue('H'.$rowNum, $ejemDigTotStr);
        $sheet->setCellValue('I'.$rowNum, $coberturaComplementariaTotal.'%');
        // Centrar totales columnas E-I
        $sheet->getStyle('E'.$rowNum.':I'.$rowNum)->getAlignment()->setHorizontal('center');
            $totalStyle = [
                'font' => ['bold' => true],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F2F2F2']],
                'alignment' => ['horizontal' => 'center'],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']]]
            ];
        $sheet->getStyle('A'.$rowNum.':I'.$rowNum)->applyFromArray($totalStyle);
        // Bordes a todo el rango de la tabla
            $lastDataRow = $rowNum;
        $sheet->getStyle('A1:I'.$lastDataRow)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000']
                    ]
                ]
            ]);
        foreach (range('A','I') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }
            $fecha = date('Ymd_His');
        $nombreArchivo = 'Reporte_Bibliografia_Complementaria_'.$sedeId.'_'.$carreraId.'_'.$fecha.'.xlsx';
            $rutaCarpeta = __DIR__.'/../../public/reportes/';
            if (!is_dir($rutaCarpeta)) mkdir($rutaCarpeta, 0777, true);
            $rutaCompleta = $rutaCarpeta.$nombreArchivo;
            $writer = new Xlsx($spreadsheet);
            $writer->save($rutaCompleta);
            
            // Cerrar el writer explícitamente
            $writer = null;
            
            // Verificar que el archivo se guardó correctamente
            if (!file_exists($rutaCompleta)) {
                error_log('exportarBibliografiaComplementariaExcel: Error - archivo no se guardó: ' . $rutaCompleta);
                $response->getBody()->write(json_encode(['error' => 'No se pudo guardar el archivo Excel']));
                return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
            }
            
            error_log('exportarBibliografiaComplementariaExcel: Archivo generado correctamente: ' . $rutaCompleta);
            
            // Devolver el archivo como descarga directa
            $fileContent = file_get_contents($rutaCompleta);
            
            // Limpiar cualquier salida previa
            if (ob_get_level()) {
                ob_end_clean();
            }
            
            $response->getBody()->write($fileContent);
            
            return $response
                ->withHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
                ->withHeader('Content-Disposition', 'attachment; filename="' . $nombreArchivo . '"')
                ->withHeader('Content-Length', filesize($rutaCompleta))
                ->withHeader('Cache-Control', 'no-cache, must-revalidate')
                ->withHeader('Pragma', 'no-cache');
        } catch (\Throwable $e) {
            error_log('Error en exportarBibliografiaComplementariaExcel: ' . $e->getMessage());
            $response->getBody()->write(json_encode(['error' => 'Error al generar el archivo Excel: ' . $e->getMessage()]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    public function exportarBibliografiaComplementariaExpandidoExcel(Request $request, Response $response, array $args): Response
    {
        try {
            error_log('ReporteController@exportarBibliografiaComplementariaExpandidoExcel: Iniciando método');
        
        $sedeId = $args['sede_id'];
        $carreraId = $args['carrera_id'];
        
        // Obtener parámetros de filtro de la URL
        $queryParams = $request->getQueryParams();
        $tiposFormacionFiltro = $queryParams['tipos_formacion'] ?? [];
        
        // Forzar que siempre sea un array
        if (!is_array($tiposFormacionFiltro)) {
            $tiposFormacionFiltro = [$tiposFormacionFiltro];
        }
        
        $hayFiltrosAplicados = !empty($tiposFormacionFiltro);
        $tiposFormacionVacio = $queryParams['tipos_formacion_vacio'] ?? null;
        
            error_log('ReporteController@exportarBibliografiaComplementariaExpandidoExcel: Sede ID: ' . $sedeId . ', Carrera ID: ' . $carreraId);

            // Obtener información de la sede y carrera
        $carrera = DB::table('vw_mallas')
            ->where('id_sede', $sedeId)
            ->where('id_carrera', $carreraId)
            ->select(
                'id_sede as sede_id',
                'id_carrera as carrera_id',
                'sede as sede',
                'codigo_carrera as codigo',
                'carrera as nombre'
            )
            ->first();
            
        if (!$carrera) {
                error_log('ReporteController@exportarBibliografiaComplementariaExpandidoExcel: No se encontró la carrera');
                $response->getBody()->write(json_encode(['error' => 'Carrera no encontrada']));
                return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }



        // Obtener asignaturas REGULARES (siempre incluidas)
        $regulares = DB::table('vw_mallas')
            ->where('id_sede', $sedeId)
            ->where('codigo_carrera', $carrera->codigo)
            ->where('tipo_asignatura', 'REGULAR')
            ->select('codigo_asignatura as codigo', 'asignatura as nombre', 'tipo_asignatura')
            ->distinct()
            ->get();

        // Obtener asignaturas de los tipos de formación seleccionados
        $formaciones = collect();
        // Lógica simplificada: solo incluir formación si hay filtros explícitos
        if (!empty($tiposFormacionFiltro)) {
            // Si hay filtros aplicados explícitamente, usar solo los seleccionados
            $formaciones = DB::table('vw_mallas')
                ->where('id_sede', $sedeId)
                ->where('codigo_carrera', $carrera->codigo)
                ->whereIn('tipo_asignatura', $tiposFormacionFiltro)
                ->whereNotNull('codigo_asignatura_formacion')
                ->select(
                    'codigo_asignatura_formacion as codigo', 
                    'asignatura_formacion as nombre', 
                    'tipo_asignatura'
                )
                ->distinct()
                ->get();
        }
        // Si no hay filtros explícitos o están vacíos, solo usar regulares (formaciones = collect() vacío)

        // Unir ambos conjuntos y eliminar duplicados por código
        $asignaturas = $regulares->merge($formaciones)->unique('codigo')->values();

        // Obtener datos de bibliografía en formato de tabla plana (una fila por bibliografía)
        $datosBibliografia = collect();
        
        foreach ($asignaturas as $asignatura) {
            // Obtener el ID de la asignatura
            $asignaturaId = DB::table('asignaturas_departamentos')
                ->where('codigo_asignatura', $asignatura->codigo)
                ->value('asignatura_id');
            
            if ($asignaturaId) {
                // Obtener bibliografías declaradas de tipo complementaria para esta asignatura
                $bibliografias = DB::table('asignaturas_bibliografias')
                    ->join('bibliografias_declaradas', 'asignaturas_bibliografias.bibliografia_id', '=', 'bibliografias_declaradas.id')
                    ->where('asignaturas_bibliografias.asignatura_id', $asignaturaId)
                    ->where('asignaturas_bibliografias.tipo_bibliografia', 'complementaria')
                    ->where('asignaturas_bibliografias.estado', 'activa')
                    ->select(
                        'bibliografias_declaradas.id',
                        'bibliografias_declaradas.titulo',
                        'bibliografias_declaradas.anio_publicacion',
                        'bibliografias_declaradas.tipo',
                        'bibliografias_declaradas.editorial',
                        'bibliografias_declaradas.edicion',
                        'bibliografias_declaradas.isbn',
                        'bibliografias_declaradas.doi',
                        'bibliografias_declaradas.formato',
                        'bibliografias_declaradas.url',
                        'bibliografias_declaradas.nota'
                    )
                    ->get();
                
                    // Solo agregar filas si hay bibliografías complementarias activas y tienen id
                    if ($bibliografias->isNotEmpty()) {
                    foreach ($bibliografias as $bibliografia) {
                            if (!$bibliografia->id) continue;
                        // Obtener el primer autor
                        $primerAutor = DB::table('bibliografias_autores')
                            ->join('autores', 'bibliografias_autores.autor_id', '=', 'autores.id')
                            ->where('bibliografias_autores.bibliografia_id', $bibliografia->id)
                            ->select(DB::raw("CONCAT(autores.apellidos, ', ', autores.nombres) as nombre_completo"))
                            ->first();
                        
                        // Construir título declarado concatenado
                        $tituloDeclarado = $bibliografia->titulo;
                        if ($bibliografia->editorial) {
                            $tituloDeclarado .= ' - ' . $bibliografia->editorial;
                        }
                        if ($primerAutor) {
                            $tituloDeclarado .= ' - ' . $primerAutor->nombre_completo;
                        }
                        
                        // Usar la nueva lógica para calcular ejemplares
                        $resultadoEjemplares = $this->calcularEjemplaresExpandido($bibliografia->id, $sedeId);
                        $ejemplaresImpresos = $resultadoEjemplares['ejemplares_impresos'];
                        $ejemplaresDigitales = $resultadoEjemplares['ejemplares_digitales'];
                        $disponible = $resultadoEjemplares['disponible'];
                        
                        // Calcular cobertura (siempre será 100% si está disponible, 0% si no)
                        $cobertura = $disponible ? 100 : 0;
                        
                        // Crear fila de datos
                        $datosBibliografia->push([
                            'codigo_asignatura' => $asignatura->codigo,
                            'nombre_asignatura' => $asignatura->nombre,
                            'tipo_asignatura' => $asignatura->tipo_asignatura,
                            'titulo_declarado' => $tituloDeclarado,
                            'anio_edicion' => $bibliografia->anio_publicacion,
                            'ejemplares_impresos' => $ejemplaresImpresos,
                            'ejemplares_digitales' => $ejemplaresDigitales,
                            'cobertura' => $cobertura,
                            'disponible' => $disponible,
                            'id_bibliografia_declarada' => $bibliografia->id
                        ]);
                        }
                    }
                } else {
                    // Si no existe asignaturaId, también agregar fila vacía
                    $datosBibliografia->push([
                        'codigo_asignatura' => $asignatura->codigo,
                        'nombre_asignatura' => $asignatura->nombre,
                        'tipo_asignatura' => $asignatura->tipo_asignatura,
                        'titulo_declarado' => '',
                        'anio_edicion' => '',
                        'ejemplares_impresos' => 'Sin información',
                        'ejemplares_digitales' => 'Sin información',
                        'cobertura' => 0,
                        'disponible' => false,
                        'id_bibliografia_declarada' => null
                ]);
            }
        }

        // Filtrar solo filas con bibliografía declarada real
        $datosBibliografia = $datosBibliografia->filter(function($fila) {
            return !empty($fila['id_bibliografia_declarada']);
        })->values();

        // Calcular totales de la carrera considerando títulos declarados únicos (sin duplicados)
        $totalesCarrera = [
                'titulos_declarados' => 0,
                'ejemplares_impresos' => 0,
            'ejemplares_digitales' => 0,
            'titulos_disponibles' => 0
        ];
        
        // Obtener códigos de asignaturas para calcular totales únicos
        $codigosAsignaturas = $asignaturas->pluck('codigo')->toArray();
        
        // Contar títulos declarados únicos para toda la carrera
        $titulosDeclaradosUnicos = DB::table('bibliografias_declaradas')
            ->join('asignaturas_bibliografias', 'bibliografias_declaradas.id', '=', 'asignaturas_bibliografias.bibliografia_id')
            ->join('asignaturas', 'asignaturas_bibliografias.asignatura_id', '=', 'asignaturas.id')
            ->join('asignaturas_departamentos', 'asignaturas.id', '=', 'asignaturas_departamentos.asignatura_id')
            ->whereIn('asignaturas_departamentos.codigo_asignatura', $codigosAsignaturas)
            ->where('asignaturas_bibliografias.tipo_bibliografia', 'complementaria')
            ->where('asignaturas_bibliografias.estado', 'activa')
            ->distinct('bibliografias_declaradas.id')
            ->count('bibliografias_declaradas.id');
            
        // Contar títulos disponibles únicos para toda la carrera
        $titulosDisponiblesUnicos = DB::table('bibliografias_declaradas')
            ->join('asignaturas_bibliografias', 'bibliografias_declaradas.id', '=', 'asignaturas_bibliografias.bibliografia_id')
            ->join('asignaturas', 'asignaturas_bibliografias.asignatura_id', '=', 'asignaturas.id')
            ->join('asignaturas_departamentos', 'asignaturas.id', '=', 'asignaturas_departamentos.asignatura_id')
            ->whereIn('asignaturas_departamentos.codigo_asignatura', $codigosAsignaturas)
            ->where('asignaturas_bibliografias.tipo_bibliografia', 'complementaria')
            ->where('asignaturas_bibliografias.estado', 'activa')
            ->whereExists(function ($query) use ($sedeId) {
                $query->select(DB::raw(1))
                    ->from('bibliografias_disponibles')
                    ->whereRaw('bibliografias_disponibles.bibliografia_declarada_id = bibliografias_declaradas.id')
                    ->where('bibliografias_disponibles.estado', 1)
                    ->where(function ($subQuery) use ($sedeId) {
                        $subQuery->whereIn('bibliografias_disponibles.disponibilidad', ['electronico', 'ambos'])
                                ->orWhere(function ($q) use ($sedeId) {
                                    $q->where('bibliografias_disponibles.disponibilidad', 'impreso')
                                      ->whereExists(function ($sub) use ($sedeId) {
                                          $sub->select(DB::raw(1))
                                              ->from('bibliografias_disponibles_sedes')
                                              ->whereRaw('bibliografias_disponibles_sedes.bibliografia_disponible_id = bibliografias_disponibles.id')
                                              ->where('bibliografias_disponibles_sedes.sede_id', $sedeId)
                                              ->where('bibliografias_disponibles_sedes.ejemplares', '>', 0);
                                      });
                                });
                    });
            })
            ->distinct('bibliografias_declaradas.id')
            ->count('bibliografias_declaradas.id');
        
        // Sumar ejemplares de todas las filas (estos sí se suman)
        foreach ($datosBibliografia as $fila) {
            $totalesCarrera['ejemplares_impresos'] += $fila['ejemplares_impresos'] ?? 0;
        }
        
        // Calcular total de ejemplares digitales considerando valores especiales
        $totalesCarrera['ejemplares_digitales'] = $this->calcularTotalEjemplaresDigitales($datosBibliografia);
        
        $totalesCarrera['titulos_declarados'] = $titulosDeclaradosUnicos;
        $totalesCarrera['titulos_disponibles'] = $titulosDisponiblesUnicos;
        
                $coberturaComplementariaTotal = $totalesCarrera['titulos_declarados'] > 0 
                    ? round(($totalesCarrera['titulos_disponibles'] / $totalesCarrera['titulos_declarados']) * 100, 2) 
                    : 0;

            // Crear el archivo Excel
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Bibl. Complementaria Expandida');
            $headers = ['Código Asignatura', 'Nombre Asignatura', 'Tipo Asignatura', 'Título Declarado', 'Año de Edición', 'Ejemplares Impresos', 'Ejemplares Digitales', 'Cobertura (%)'];
            $sheet->fromArray($headers, null, 'A1');
            $headerStyle = [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4472C4']],
                'alignment' => ['horizontal' => 'center'],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']]]
            ];
            $sheet->getStyle('A1:H1')->applyFromArray($headerStyle);
            $rowNum = 2;
            foreach ($datosBibliografia as $fila) {
                $sheet->setCellValue('A'.$rowNum, $fila['codigo_asignatura']);
                $sheet->setCellValue('B'.$rowNum, $fila['nombre_asignatura']);
                $sheet->setCellValue('C'.$rowNum, $fila['tipo_asignatura']);
                $sheet->setCellValue('D'.$rowNum, $fila['titulo_declarado']);
                $sheet->setCellValue('E'.$rowNum, $fila['anio_edicion']);
                // Ejemplares Impresos: usar función helper
                $ejemImpStr = $this->convertirValorEspecial($fila['ejemplares_impresos'], 'impresos', $fila['disponible'] ? 1 : 0);
                $sheet->setCellValue('F'.$rowNum, $ejemImpStr);
                
                // Ejemplares Digitales: usar función helper
                $ejemDigStr = $this->convertirValorEspecial($fila['ejemplares_digitales'], 'digitales', $fila['disponible'] ? 1 : 0);
                $sheet->setCellValue('G'.$rowNum, $ejemDigStr);
                $sheet->setCellValue('H'.$rowNum, $fila['cobertura'].'%');
                // Centrar columnas E, F, G, H
                $sheet->getStyle('E'.$rowNum.':H'.$rowNum)->getAlignment()->setHorizontal('center');
                $rowNum++;
            }
            
            // Log de depuración antes de escribir totales
            error_log('DEPURACION ESCRIBIR TOTALES: Fila=' . $rowNum . ', titulos_declarados=' . $totalesCarrera['titulos_declarados'] . 
                     ', ejemplares_impresos=' . $totalesCarrera['ejemplares_impresos'] . 
                     ', ejemplares_digitales=' . $totalesCarrera['ejemplares_digitales'] . 
                     ', cobertura=' . $coberturaComplementariaTotal);
            
            // Fila de totales
            $sheet->setCellValue('A'.$rowNum, 'TOTALES DE LA CARRERA');
            $sheet->mergeCells('A'.$rowNum.':C'.$rowNum);
            $sheet->getStyle('A'.$rowNum.':C'.$rowNum)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('D'.$rowNum, $totalesCarrera['titulos_declarados']);
            $sheet->setCellValue('E'.$rowNum, '');
            // Totales ejemplares impresos: usar función helper
            $ejemImpTotStr = $this->convertirValorEspecial($totalesCarrera['ejemplares_impresos'], 'impresos', $totalesCarrera['titulos_disponibles']);
            $sheet->setCellValue('F'.$rowNum, $ejemImpTotStr);
            
            // Totales ejemplares digitales: usar función helper
            $ejemDigTotStr = $this->convertirValorEspecial($totalesCarrera['ejemplares_digitales'], 'digitales', $totalesCarrera['titulos_disponibles']);
            $sheet->setCellValue('G'.$rowNum, $ejemDigTotStr);
            $sheet->setCellValue('H'.$rowNum, $coberturaComplementariaTotal.'%');
            // Centrar totales columnas D, F, G, H
            $sheet->getStyle('D'.$rowNum.':H'.$rowNum)->getAlignment()->setHorizontal('center');
            $totalStyle = [
                'font' => ['bold' => true],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F2F2F2']],
                'alignment' => ['horizontal' => 'center'],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']]]
            ];
            $sheet->getStyle('A'.$rowNum.':H'.$rowNum)->applyFromArray($totalStyle);
            
            // Bordes a todo el rango de la tabla
            $lastDataRow = $rowNum;
            $sheet->getStyle('A1:H'.$lastDataRow)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000']
                    ]
                ]
            ]);
            
            foreach (range('A','H') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }
            
            $fecha = date('Ymd_His');
            $nombreArchivo = 'Reporte_Expandido_Bibliografia_Complementaria_'.$sedeId.'_'.$carreraId.'_'.$fecha.'.xlsx';
            $rutaCarpeta = __DIR__.'/../../public/reportes/';
            if (!is_dir($rutaCarpeta)) mkdir($rutaCarpeta, 0777, true);
            $rutaCompleta = $rutaCarpeta.$nombreArchivo;
            $writer = new Xlsx($spreadsheet);
            $writer->save($rutaCompleta);
            
            // Cerrar el writer explícitamente
            $writer = null;
            
            // Verificar que el archivo se guardó correctamente
            if (!file_exists($rutaCompleta)) {
                error_log('exportarBibliografiaComplementariaExpandidoExcel: Error - archivo no se guardó: ' . $rutaCompleta);
                $response->getBody()->write(json_encode(['error' => 'No se pudo guardar el archivo Excel']));
                return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
            }
            
            error_log('ReporteController@exportarBibliografiaComplementariaExpandidoExcel: Archivo generado: ' . $rutaCompleta);
            
            // Devolver el archivo como descarga directa
            $fileContent = file_get_contents($rutaCompleta);
            
            // Limpiar cualquier salida previa
            if (ob_get_level()) {
                ob_end_clean();
            }
            
            $response->getBody()->write($fileContent);
            
            return $response
                ->withHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
                ->withHeader('Content-Disposition', 'attachment; filename="' . $nombreArchivo . '"')
                ->withHeader('Content-Length', filesize($rutaCompleta))
                ->withHeader('Cache-Control', 'no-cache, must-revalidate')
                ->withHeader('Pragma', 'no-cache');
        } catch (\Throwable $e) {
            error_log('Error en exportarBibliografiaComplementariaExpandidoExcel: ' . $e->getMessage());
            $response->getBody()->write(json_encode(['error' => 'Error al generar el archivo Excel: ' . $e->getMessage()]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    // Reporte fusionado de coberturas básicas y complementarias
    public function reporteCoberturasFusionado(Request $request, Response $response, array $args): Response
    {
        error_log('ReporteController@reporteCoberturasFusionado: Iniciando método');
        
        $sedeId = $args['sede_id'];
        $carreraId = $args['carrera_id'];
        
        // Obtener información de la carrera
        $carrera = DB::table('vw_mallas')
            ->where('id_sede', $sedeId)
            ->where('id_carrera', $carreraId)
            ->select(
                'id_sede as sede_id',
                'id_carrera as carrera_id',
                'sede as sede',
                'codigo_carrera as codigo',
                'carrera as nombre'
            )
            ->first();
            
        if (!$carrera) {
            error_log('ReporteController@reporteCoberturasFusionado: Carrera no encontrada');
            $response->getBody()->write('Carrera no encontrada');
            return $response->withStatus(404);
        }

        // Obtener datos de cobertura básica desde la tabla de reportes guardados
        $datosBasicos = DB::table('reporte_coberturas_carreras_basicas')
            ->where('codigo_carrera', $carrera->codigo)
            ->whereYear('fecha_medicion', date('Y'))
            ->select(
                'codigo_asignatura',
                'id_bibliografia_declarada',
                'no_ejem_imp as ejemplares_impresos',
                'no_ejem_dig as ejemplares_digitales',
                'no_bib_disponible_basica as disponible'
            )
            ->get();

        // Obtener datos de cobertura complementaria desde la tabla de reportes guardados
        $datosComplementarios = DB::table('reporte_coberturas_carreras_complementarias')
            ->where('codigo_carrera', $carrera->codigo)
            ->whereYear('fecha_medicion', date('Y'))
            ->select(
                'codigo_asignatura',
                'id_bibliografia_declarada',
                'no_ejem_imp as ejemplares_impresos',
                'no_ejem_dig as ejemplares_digitales',
                'no_bib_disponible_complementaria as disponible'
            )
            ->get();

        // Si no hay datos guardados, mostrar alerta
        if ($datosBasicos->isEmpty() && $datosComplementarios->isEmpty()) {
            error_log('ReporteController@reporteCoberturasFusionado: No hay reportes generados');
            
            $view = new \Twig\Environment(new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../templates'));
            $template = $view->load('reportes/coberturas/carrera_fusionado.twig');
            
            $html = $template->render([
                'carrera' => $carrera,
                'datos_basicos' => [],
                'datos_complementarios' => [],
                'cobertura_basica' => 0,
                'cobertura_complementaria' => 0,
                'totales_basica' => ['titulos_declarados' => 0, 'titulos_disponibles' => 0],
                'totales_complementaria' => ['titulos_declarados' => 0, 'titulos_disponibles' => 0],
                'sin_datos' => true,
                'session' => $_SESSION ?? [],
                'app_url' => app_url()
            ]);
            
            $response->getBody()->write($html);
            return $response->withHeader('Content-Type', 'text/html');
        }

        // Procesar datos básicos
        $datosBasicosProcesados = collect();
        if (!$datosBasicos->isEmpty()) {
            foreach ($datosBasicos as $dato) {
                // Obtener información de la bibliografía declarada
                $bibliografia = DB::table('bibliografias_declaradas')
                    ->where('id', $dato->id_bibliografia_declarada)
                    ->first();
                    
                if ($bibliografia) {
                    // Obtener información de la asignatura
                    $asignatura = DB::table('asignaturas_departamentos')
                        ->where('codigo_asignatura', $dato->codigo_asignatura)
                        ->first();
                        
                    if ($asignatura) {
                        $asignaturaInfo = DB::table('asignaturas')
                            ->where('id', $asignatura->asignatura_id)
                            ->first();
                            
                        $datosBasicosProcesados->push([
                            'codigo_asignatura' => $dato->codigo_asignatura,
                            'nombre_asignatura' => $asignaturaInfo->nombre ?? 'N/A',
                            'tipo_asignatura' => $asignaturaInfo->tipo ?? 'N/A',
                            'titulo_declarado' => $bibliografia->titulo,
                            'anio_edicion' => $bibliografia->anio_publicacion,
                            'ejemplares_impresos' => $dato->ejemplares_impresos,
                            'ejemplares_digitales' => $dato->ejemplares_digitales,
                            'cobertura' => $dato->disponible ? 100 : 0,
                            'id_bibliografia_declarada' => $dato->id_bibliografia_declarada
                        ]);
                    }
                }
            }
        }

        // Procesar datos complementarios
        $datosComplementariosProcesados = collect();
        if (!$datosComplementarios->isEmpty()) {
            foreach ($datosComplementarios as $dato) {
                // Obtener información de la bibliografía declarada
                $bibliografia = DB::table('bibliografias_declaradas')
                    ->where('id', $dato->id_bibliografia_declarada)
                    ->first();
                    
                if ($bibliografia) {
                    // Obtener información de la asignatura
                    $asignatura = DB::table('asignaturas_departamentos')
                        ->where('codigo_asignatura', $dato->codigo_asignatura)
                        ->first();
                        
                    if ($asignatura) {
                        $asignaturaInfo = DB::table('asignaturas')
                            ->where('id', $asignatura->asignatura_id)
                            ->first();
                            
                        $datosComplementariosProcesados->push([
                            'codigo_asignatura' => $dato->codigo_asignatura,
                            'nombre_asignatura' => $asignaturaInfo->nombre ?? 'N/A',
                            'tipo_asignatura' => $asignaturaInfo->tipo ?? 'N/A',
                            'titulo_declarado' => $bibliografia->titulo,
                            'anio_edicion' => $bibliografia->anio_publicacion,
                            'ejemplares_impresos' => $dato->ejemplares_impresos,
                            'ejemplares_digitales' => $dato->ejemplares_digitales,
                            'cobertura' => $dato->disponible ? 100 : 0,
                            'id_bibliografia_declarada' => $dato->id_bibliografia_declarada
                        ]);
                    }
                }
            }
        }

        // Calcular coberturas totales
        $coberturaBasica = $datosBasicosProcesados->isNotEmpty() 
            ? round(($datosBasicosProcesados->where('cobertura', '>', 0)->count() / $datosBasicosProcesados->count()) * 100, 2)
            : 0;
            
        $coberturaComplementaria = $datosComplementariosProcesados->isNotEmpty()
            ? round(($datosComplementariosProcesados->where('cobertura', '>', 0)->count() / $datosComplementariosProcesados->count()) * 100, 2)
            : 0;

        // Calcular totales
        $totalesBasica = [
            'titulos_declarados' => $datosBasicosProcesados->count(),
            'titulos_disponibles' => $datosBasicosProcesados->where('cobertura', '>', 0)->count()
        ];
        
        $totalesComplementaria = [
            'titulos_declarados' => $datosComplementariosProcesados->count(),
            'titulos_disponibles' => $datosComplementariosProcesados->where('cobertura', '>', 0)->count()
        ];

        // Agrupar por asignatura
        $asignaturas = [];
        foreach ($datosBasicosProcesados as $item) {
            $codigo = $item['codigo_asignatura'];
            if (!isset($asignaturas[$codigo])) {
                $asignaturas[$codigo] = [
                    'nombre' => $item['nombre_asignatura'],
                    'tipo' => $item['tipo_asignatura'],
                    'basica' => [],
                    'complementaria' => []
                ];
            }
            $asignaturas[$codigo]['basica'][] = $item;
        }
        foreach ($datosComplementariosProcesados as $item) {
            $codigo = $item['codigo_asignatura'];
            if (!isset($asignaturas[$codigo])) {
                $asignaturas[$codigo] = [
                    'nombre' => $item['nombre_asignatura'],
                    'tipo' => $item['tipo_asignatura'],
                    'basica' => [],
                    'complementaria' => []
                ];
            }
            $asignaturas[$codigo]['complementaria'][] = $item;
        }

        // Renderizar la vista
        $view = new \Twig\Environment(new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../templates'));
        $template = $view->load('reportes/coberturas/carrera_fusionado.twig');
        
        $html = $template->render([
            'carrera' => $carrera,
            'datos_basicos' => $datosBasicosProcesados,
            'datos_complementarios' => $datosComplementariosProcesados,
            'asignaturas' => $asignaturas,
            'cobertura_basica' => $coberturaBasica,
            'cobertura_complementaria' => $coberturaComplementaria,
            'totales_basica' => $totalesBasica,
            'totales_complementaria' => $totalesComplementaria,
            'sin_datos' => false,
            'session' => $_SESSION ?? [],
            'app_url' => app_url()
        ]);
        
        error_log('ReporteController@reporteCoberturasFusionado: Vista renderizada correctamente');
        $response->getBody()->write($html);
        return $response->withHeader('Content-Type', 'text/html');
    }

    // Exportar reporte fusionado a Excel
    public function exportarCoberturasFusionadoExcel(Request $request, Response $response, array $args): Response
    {
        error_log('ReporteController@exportarCoberturasFusionadoExcel: Iniciando método');
        
        $sedeId = $args['sede_id'];
        $carreraId = $args['carrera_id'];
        
        // Obtener información de la carrera
        $carrera = DB::table('vw_mallas')
            ->where('id_sede', $sedeId)
            ->where('id_carrera', $carreraId)
            ->select(
                'sede as sede',
                'codigo_carrera as codigo',
                'carrera as nombre'
            )
            ->first();
            
        if (!$carrera) {
            $response->getBody()->write(json_encode(['error' => 'Carrera no encontrada']));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }

        // Obtener datos de cobertura básica
        $datosBasicos = DB::table('reporte_coberturas_carreras_basicas')
            ->where('codigo_carrera', $carrera->codigo)
            ->whereYear('fecha_medicion', date('Y'))
            ->get();

        // Obtener datos de cobertura complementaria
        $datosComplementarios = DB::table('reporte_coberturas_carreras_complementarias')
            ->where('codigo_carrera', $carrera->codigo)
            ->whereYear('fecha_medicion', date('Y'))
            ->get();

        // Si no hay datos, retornar error
        if ($datosBasicos->isEmpty() && $datosComplementarios->isEmpty()) {
            $response->getBody()->write(json_encode(['error' => 'No hay reportes generados para esta carrera']));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        // Procesar y agrupar datos igual que en la vista fusionada
        $datosBasicosProcesados = collect();
        foreach ($datosBasicos as $dato) {
            $bibliografia = DB::table('bibliografias_declaradas')->where('id', $dato->id_bibliografia_declarada)->first();
            $asignatura = DB::table('asignaturas_departamentos')->where('codigo_asignatura', $dato->codigo_asignatura)->first();
            if ($bibliografia && $asignatura) {
                $asignaturaInfo = DB::table('asignaturas')->where('id', $asignatura->asignatura_id)->first();
                $datosBasicosProcesados->push([
                    'codigo_asignatura' => $dato->codigo_asignatura,
                    'nombre_asignatura' => $asignaturaInfo->nombre ?? 'N/A',
                    'tipo_asignatura' => $asignaturaInfo->tipo ?? 'N/A',
                    'titulo_declarado' => $bibliografia->titulo,
                    'anio_edicion' => $bibliografia->anio_publicacion,
                    'ejemplares_impresos' => $dato->no_ejem_imp,
                    'ejemplares_digitales' => $dato->no_ejem_dig,
                    'cobertura' => $dato->no_bib_disponible_basica ? 100 : 0
                ]);
            }
        }
        $datosComplementariosProcesados = collect();
        foreach ($datosComplementarios as $dato) {
            $bibliografia = DB::table('bibliografias_declaradas')->where('id', $dato->id_bibliografia_declarada)->first();
            $asignatura = DB::table('asignaturas_departamentos')->where('codigo_asignatura', $dato->codigo_asignatura)->first();
            if ($bibliografia && $asignatura) {
                $asignaturaInfo = DB::table('asignaturas')->where('id', $asignatura->asignatura_id)->first();
                $datosComplementariosProcesados->push([
                    'codigo_asignatura' => $dato->codigo_asignatura,
                    'nombre_asignatura' => $asignaturaInfo->nombre ?? 'N/A',
                    'tipo_asignatura' => $asignaturaInfo->tipo ?? 'N/A',
                    'titulo_declarado' => $bibliografia->titulo,
                    'anio_edicion' => $bibliografia->anio_publicacion,
                    'ejemplares_impresos' => $dato->no_ejem_imp,
                    'ejemplares_digitales' => $dato->no_ejem_dig,
                    'cobertura' => $dato->no_bib_disponible_complementaria ? 100 : 0
                ]);
            }
        }
        // Agrupar por asignatura
        $asignaturas = [];
        foreach ($datosBasicosProcesados as $item) {
            $codigo = $item['codigo_asignatura'];
            if (!isset($asignaturas[$codigo])) {
                $asignaturas[$codigo] = [
                    'nombre' => $item['nombre_asignatura'],
                    'tipo' => $item['tipo_asignatura'],
                    'basica' => [],
                    'complementaria' => []
                ];
            }
            $asignaturas[$codigo]['basica'][] = $item;
        }
        foreach ($datosComplementariosProcesados as $item) {
            $codigo = $item['codigo_asignatura'];
            if (!isset($asignaturas[$codigo])) {
                $asignaturas[$codigo] = [
                    'nombre' => $item['nombre_asignatura'],
                    'tipo' => $item['tipo_asignatura'],
                    'basica' => [],
                    'complementaria' => []
                ];
            }
            $asignaturas[$codigo]['complementaria'][] = $item;
        }
        // Crear hoja fusionada
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Reporte Fusionado');
        $headers = [
            'Tipo de actividad curricular',
            'Nombre de la actividad o asignatura',
            'Título (Obligatoria)', 'Año (Obligatoria)', 'N° ejemplares físicos (Obligatoria)', 'N° ejemplares electrónicos (Obligatoria)', '% Cobertura (Obligatoria)',
            'Título (Complementaria)', 'Año (Complementaria)', 'N° ejemplares físicos (Complementaria)', 'N° ejemplares electrónicos (Complementaria)', '% Cobertura (Complementaria)'
        ];
        $sheet->fromArray($headers, null, 'A1');
        $rowNum = 2;
        foreach ($asignaturas as $asignatura) {
            $len_basica = count($asignatura['basica']);
            $len_complementaria = count($asignatura['complementaria']);
            $max_filas = max($len_basica, $len_complementaria);
            for ($i = 0; $i < $max_filas; $i++) {
                $b = $asignatura['basica'][$i] ?? null;
                $c = $asignatura['complementaria'][$i] ?? null;
                $sheet->setCellValue('A'.$rowNum, $i == 0 ? $asignatura['tipo'] : '');
                $sheet->setCellValue('B'.$rowNum, $i == 0 ? $asignatura['nombre'] : '');
                // Básica
                $sheet->setCellValue('C'.$rowNum, $b['titulo_declarado'] ?? '');
                $sheet->setCellValue('D'.$rowNum, $b['anio_edicion'] ?? '');
                $sheet->setCellValue('E'.$rowNum, $b ? $this->convertirValorEspecial($b['ejemplares_impresos'], 'impresos', $b['ejemplares_digitales'] ?? 0) : '');
                $sheet->setCellValue('F'.$rowNum, $b ? $this->convertirValorEspecial($b['ejemplares_digitales'], 'digitales', $b['ejemplares_digitales'] ?? 0) : '');
                $sheet->setCellValue('G'.$rowNum, isset($b['cobertura']) ? $b['cobertura'].'%' : '');
                // Complementaria
                $sheet->setCellValue('H'.$rowNum, $c['titulo_declarado'] ?? '');
                $sheet->setCellValue('I'.$rowNum, $c['anio_edicion'] ?? '');
                $sheet->setCellValue('J'.$rowNum, $c ? $this->convertirValorEspecial($c['ejemplares_impresos'], 'impresos', $c['ejemplares_digitales'] ?? 0) : '');
                $sheet->setCellValue('K'.$rowNum, $c ? $this->convertirValorEspecial($c['ejemplares_digitales'], 'digitales', $c['ejemplares_digitales'] ?? 0) : '');
                $sheet->setCellValue('L'.$rowNum, isset($c['cobertura']) ? $c['cobertura'].'%' : '');
                $rowNum++;
            }
        }
        // Formato: negrita encabezados y bordes
        $sheet->getStyle('A1:L1')->getFont()->setBold(true);
        $sheet->getStyle('A1:L'.($rowNum-1))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        foreach (range('A','L') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        $filename = 'Reporte_Fusionado_Coberturas_' . $carrera->sede . '_' . $carrera->codigo . '_' . str_replace(' ', '_', $carrera->nombre) . '.xlsx';
        $filepath = __DIR__ . '/../../public/exports/' . $filename;
        if (!is_dir(dirname($filepath))) {
            mkdir(dirname($filepath), 0755, true);
        }
        $writer = new Xlsx($spreadsheet);
        $writer->save($filepath);
        $response->getBody()->write(json_encode([
            'url' => '/biblioges/exports/' . $filename
        ]));
        return $response->withHeader('Content-Type', 'application/json');
    }

    // Guardar reporte fusionado
    public function guardarCoberturaFusionado(Request $request, Response $response, array $args): Response
    {
        error_log('ReporteController@guardarCoberturaFusionado: Iniciando método');
        
        $sedeId = $args['sede_id'];
        $carreraId = $args['carrera_id'];
        
        $body = $request->getBody()->getContents();
        $data = json_decode($body, true);
        
        try {
            if (!$data) {
                $response->getBody()->write(json_encode(['error' => 'Datos inválidos']));
                return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
            }
            
            // Obtener el código de la carrera
            $carrera = DB::table('vw_mallas')
                ->where('id_sede', $sedeId)
                ->where('id_carrera', $carreraId)
                ->select('codigo_carrera as codigo')
                ->first();
                
            if (!$carrera) {
                $response->getBody()->write(json_encode(['error' => 'Carrera no encontrada']));
                return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
            }

            $response->getBody()->write(json_encode([
                'success' => true, 
                'message' => 'Reporte fusionado guardado correctamente'
            ]));
            
            return $response->withHeader('Content-Type', 'application/json');
            
        } catch (\Exception $e) {
            error_log('Error en guardarCoberturaFusionado: ' . $e->getMessage());
            $response->getBody()->write(json_encode(['error' => 'Error al guardar el reporte: ' . $e->getMessage()]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    public function exportarCoberturasExcel(Request $request, Response $response, array $args): Response
    {
        error_log('ReporteController@exportarCoberturasExcel: Iniciando método');
        
        // Obtener el año actual
        $anioActual = date('Y');
        
        // Construir la consulta base sin paginación para obtener todos los registros
        $sql = "SELECT 
                s.nombre as sede,
                ce.codigo_carrera as codigo,
                c.nombre,
                c.tipo_programa,
                c.estado,
                c.id as carrera_id,
                s.id as sede_id
        FROM carreras c
        JOIN carreras_espejos ce ON c.id = ce.carrera_id
        JOIN sedes s ON ce.sede_id = s.id
        WHERE 1=1";
        
        $params = [];
        
        // Aplicar filtros si existen
        if (!empty($_GET['sede'])) {
            $sql .= " AND s.nombre LIKE ?";
            $params[] = '%' . $_GET['sede'] . '%';
        }
        
        if (!empty($_GET['tipo_programa'])) {
            $sql .= " AND c.tipo_programa = ?";
            $params[] = $_GET['tipo_programa'];
        }
        
        if (isset($_GET['estado']) && $_GET['estado'] !== '') {
            $sql .= " AND c.estado = ?";
            $params[] = $_GET['estado'];
        }
        
        if (!empty($_GET['nombre'])) {
            $sql .= " AND c.nombre LIKE ?";
            $params[] = '%' . $_GET['nombre'] . '%';
        }
        
        // Ordenar por sede y nombre por defecto
        $sql .= " ORDER BY s.nombre ASC, c.nombre ASC";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $carreras = $stmt->fetchAll(\PDO::FETCH_OBJ);
        
        error_log('ReporteController@exportarCoberturasExcel: Total carreras encontradas: ' . count($carreras));

        // Cobertura básica por carrera
        $coberturasBasicas = [];
        $carrerasCodigos = array_column($carreras, 'codigo');
        foreach ($carrerasCodigos as $codigoCarrera) {
            $ultimaFecha = DB::table('reporte_coberturas_carreras_basicas')
                ->where('codigo_carrera', $codigoCarrera)
                ->whereYear('fecha_medicion', $anioActual)
                ->max('fecha_medicion');
            if ($ultimaFecha) {
                $cobertura = DB::table('reporte_coberturas_carreras_basicas')
                    ->select(
                        DB::raw('COUNT(DISTINCT id_bibliografia_declarada) AS total_declaradas'),
                        DB::raw('COUNT(DISTINCT CASE WHEN no_bib_disponible_basica > 0 THEN id_bibliografia_declarada END) AS total_disponibles'),
                        DB::raw('ROUND(LEAST(COUNT(DISTINCT CASE WHEN no_bib_disponible_basica > 0 THEN id_bibliografia_declarada END) * 100.0 / NULLIF(COUNT(DISTINCT id_bibliografia_declarada), 0), 100), 2) AS cobertura')
                    )
                    ->where('codigo_carrera', $codigoCarrera)
                    ->where('fecha_medicion', $ultimaFecha)
                    ->first();
                $coberturasBasicas[$codigoCarrera] = $cobertura->cobertura ?? 'Sin información';
            } else {
                $coberturasBasicas[$codigoCarrera] = 'Sin información';
            }
        }

        // Cobertura complementaria por carrera - Calculada en tiempo real
        $coberturasComplementarias = [];
        foreach ($carrerasCodigos as $codigoCarrera) {
            // Obtener sede_id para la carrera
            $carreraInfo = collect($carreras)->firstWhere('codigo', $codigoCarrera);
            $sedeId = $carreraInfo->sede_id ?? 1; // Default a sede 1 si no se encuentra
            
            $coberturasComplementarias[$codigoCarrera] = $this->calcularCoberturaComplementariaTiempoReal($codigoCarrera, $sedeId);
        }

        // Agregar datos de cobertura a cada carrera
        foreach ($carreras as $carrera) {
            $carreraCodigo = $carrera->codigo ?? null;
            $coberturaBasica = $coberturasBasicas[$carreraCodigo] ?? 'Sin información';
            $coberturaComplementaria = $coberturasComplementarias[$carreraCodigo] ?? 'Sin información';
            $carrera->cobertura_basica = $coberturaBasica;
            $carrera->cobertura_complementaria = $coberturaComplementaria;
        }

        // Crear el archivo Excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Configurar el título del reporte
        $sheet->setCellValue('A1', 'REPORTE DE COBERTURAS - ' . $anioActual);
        $sheet->mergeCells('A1:H1');
        
        // Estilo para el título
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('4E73DF');
        $sheet->getStyle('A1')->getFont()->getColor()->setRGB('FFFFFF');
        
        // Configurar encabezados
        $headers = [
            'A3' => 'Sede',
            'B3' => 'Código Carrera',
            'C3' => 'Nombre Carrera',
            'D3' => 'Tipo Programa',
            'E3' => 'Estado',
            'F3' => 'Cobertura Básica (' . $anioActual . ')',
            'G3' => 'Cobertura Complementaria (' . $anioActual . ')'
        ];
        
        foreach ($headers as $cell => $header) {
            $sheet->setCellValue($cell, $header);
            $sheet->getStyle($cell)->getFont()->setBold(true);
            $sheet->getStyle($cell)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('E3F2FD');
            $sheet->getStyle($cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        }
        
        // Agregar datos
        $row = 4;
        foreach ($carreras as $carrera) {
            $sheet->setCellValue('A' . $row, $carrera->sede);
            $sheet->setCellValue('B' . $row, $carrera->codigo);
            $sheet->setCellValue('C' . $row, $carrera->nombre);
            
            // Tipo de programa
            $tipoPrograma = '';
            if ($carrera->tipo_programa == 'P') {
                $tipoPrograma = 'Pregrado';
            } elseif ($carrera->tipo_programa == 'G') {
                $tipoPrograma = 'Postgrado';
            } elseif ($carrera->tipo_programa == 'O') {
                $tipoPrograma = 'Otro';
            } else {
                $tipoPrograma = $carrera->tipo_programa;
            }
            $sheet->setCellValue('D' . $row, $tipoPrograma);
            
            // Estado
            $estado = $carrera->estado == 1 ? 'Activo' : 'Inactivo';
            $sheet->setCellValue('E' . $row, $estado);
            
            // Coberturas
            $coberturaBasica = $carrera->cobertura_basica;
            if (is_numeric($coberturaBasica)) {
                $coberturaBasica = number_format($coberturaBasica, 2) . '%';
            }
            $sheet->setCellValue('F' . $row, $coberturaBasica);
            
            $coberturaComplementaria = $carrera->cobertura_complementaria;
            if (is_numeric($coberturaComplementaria)) {
                $coberturaComplementaria = number_format($coberturaComplementaria, 2) . '%';
            }
            $sheet->setCellValue('G' . $row, $coberturaComplementaria);
            
            $row++;
        }
        
        // Autoajustar columnas
        foreach (range('A', 'G') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
        
        // Agregar bordes a toda la tabla
        $lastRow = $row - 1;
        $tableRange = 'A3:G' . $lastRow;
        $sheet->getStyle($tableRange)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        
        // Configurar el writer
        $writer = new Xlsx($spreadsheet);
        
        // Generar nombre del archivo
        $fecha = date('Y-m-d_H-i-s');
        $filename = 'Reporte_Coberturas_' . $anioActual . '_' . $fecha . '.xlsx';
        
        // Configurar headers para descarga
        $response = $response->withHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response = $response->withHeader('Content-Disposition', 'attachment; filename="' . $filename . '"');
        $response = $response->withHeader('Cache-Control', 'max-age=0');
        
        // Escribir el archivo al output
        ob_start();
        $writer->save('php://output');
        $content = ob_get_clean();
        
        $response->getBody()->write($content);
        
        error_log('ReporteController@exportarCoberturasExcel: Archivo Excel generado correctamente');
        return $response;
    }
} 