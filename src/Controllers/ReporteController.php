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

class ReporteController extends BaseController
{
    public function __construct()
    {
        global $twig;
        parent::__construct($twig, new \Slim\Psr7\Response());
    }

    public function coberturaAsignatura(Request $request, Response $response, array $args): Response
    {
        $codigo = $args['codigo'];
        
        // Obtener total de bibliografías declaradas
        $totalBibliografias = DB::table('bibliografias_declaradas')
            ->whereExists(function ($query) use ($codigo) {
                $query->select(DB::raw(1))
                    ->from('asignaturas')
                    ->where('asignaturas.codigo', $codigo);
            })
            ->count();
            
        // Obtener bibliografías disponibles
        $bibliografiasDisponibles = DB::table('bibliografias_declaradas')
            ->whereExists(function ($query) use ($codigo) {
                $query->select(DB::raw(1))
                    ->from('asignaturas')
                    ->where('asignaturas.codigo', $codigo);
            })
            ->where('disponible', true)
            ->count();
            
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
        
        // Obtener total de bibliografías declaradas
        $totalBibliografias = DB::table('bibliografias_declaradas')
            ->whereExists(function ($query) use ($asignaturas) {
                $query->select(DB::raw(1))
                    ->from('asignaturas')
                    ->whereIn('asignaturas.codigo', $asignaturas);
            })
            ->count();
            
        // Obtener bibliografías disponibles
        $bibliografiasDisponibles = DB::table('bibliografias_declaradas')
            ->whereExists(function ($query) use ($asignaturas) {
                $query->select(DB::raw(1))
                    ->from('asignaturas')
                    ->whereIn('asignaturas.codigo', $asignaturas);
            })
            ->where('disponible', true)
            ->count();
            
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
        
        $view = new \Twig\Environment(new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../templates'));
        $template = $view->load('reportes/coberturas/index.twig');
        
        $response->getBody()->write($template->render([
            'carreras' => $carreras
        ]));
        
        return $response->withHeader('Content-Type', 'text/html');
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
        try {
            // Usar el método render del BaseController
            return $this->render($response, 'reportes/bibliografias_declaradas.twig', [
                'app_url' => $GLOBALS['twig']->getGlobals()['app_url'] ?? '',
                'session' => $_SESSION,
                'current_page' => 'reportes',
                'user' => [
                    'id' => $_SESSION['user_id'] ?? null,
                    'email' => $_SESSION['user_email'] ?? null,
                    'nombre' => $_SESSION['user_nombre'] ?? null,
                    'rol' => $_SESSION['user_rol'] ?? null
                ]
            ]);
            
        } catch (\Exception $e) {
            error_log("ERROR en bibliografiasDeclaradas: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            
            // Devolver una respuesta de error
            $response->getBody()->write("Error al cargar el reporte: " . $e->getMessage());
            return $response->withStatus(500)->withHeader('Content-Type', 'text/html');
        }
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
        
        // Obtener el año actual
        $anioActual = date('Y');
        
        // Obtener sedes, carreras y sus relaciones usando la estructura correcta
        $carreras = DB::table('carreras')
            ->join('carreras_espejos', 'carreras.id', '=', 'carreras_espejos.carrera_id')
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
        error_log('ReporteController@coberturaBasica: Total carreras encontradas: ' . count($carreras));

        // Obtener datos de cobertura básica y complementaria para el año actual
        $coberturasBasicas = DB::table('vw_car_cobertura_basica')
            ->where('anho', $anioActual)
            ->pluck('cobertura_basica', 'codigo_carrera')
            ->toArray();
            
        $coberturasComplementarias = DB::table('vw_car_cobertura_complementaria')
            ->where('anho', $anioActual)
            ->pluck('cobertura_complementaria', 'codigo_carrera')
            ->toArray();

        // Agregar datos de cobertura a cada carrera
        foreach ($carreras as $carrera) {
            $carrera->cobertura_basica = $coberturasBasicas[$carrera->codigo] ?? null;
            $carrera->cobertura_complementaria = $coberturasComplementarias[$carrera->codigo] ?? null;
        }

        $view = new \Twig\Environment(new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../templates'));
        $template = $view->load('reportes/coberturas/index.twig');
        $html = $template->render([
            'carreras' => $carreras,
            'session' => $sessionData,
            'app_url' => app_url(),
            'current_page' => 'coberturas',
            'anio_actual' => $anioActual
        ]);
        error_log('ReporteController@coberturaBasica: Vista renderizada correctamente');
        $response->getBody()->write($html);
        return $response->withHeader('Content-Type', 'text/html');
    }

    // Reporte de bibliografía básica por carrera
    public function reporteBibliografiaBasica(Request $request, Response $response, array $args): Response
    {
        error_log('ReporteController@reporteBibliografiaBasica: Iniciando método');
        
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
        
        $tiposFormacionVacio = $request->getQueryParams()['tipos_formacion_vacio'] ?? null;
        
        // Si no hay filtros en la URL, intentar cargar filtros guardados
        if (empty($tiposFormacionFiltro) && !$tiposFormacionVacio) {
            $carreraTemp = DB::table('vw_mallas')
                ->where('id_sede', $sedeId)
                ->where('id_carrera', $carreraId)
                ->select('codigo_carrera as codigo')
                ->first();
                
            if ($carreraTemp) {
                $filtrosGuardados = DB::table('filtros_formaciones')
                    ->where('codigo_carrera', $carreraTemp->codigo)
                    ->first();
                    
                if ($filtrosGuardados) {
                    // Convertir los filtros guardados a array de tipos de formación
                    if ($filtrosGuardados->basica) $tiposFormacionFiltro[] = 'FORMACION_BASICA';
                    if ($filtrosGuardados->general) $tiposFormacionFiltro[] = 'FORMACION_GENERAL';
                    if ($filtrosGuardados->idioma) $tiposFormacionFiltro[] = 'FORMACION_IDIOMAS';
                    if ($filtrosGuardados->profesional) $tiposFormacionFiltro[] = 'FORMACION_PROFESIONAL';
                    if ($filtrosGuardados->valores) $tiposFormacionFiltro[] = 'FORMACION_VALORES';
                    if ($filtrosGuardados->especialidad) $tiposFormacionFiltro[] = 'FORMACION_ESPECIALIDAD';
                    if ($filtrosGuardados->especial) $tiposFormacionFiltro[] = 'FORMACION_ESPECIAL';
                    
                    $hayFiltrosAplicados = !empty($tiposFormacionFiltro);
                    error_log('ReporteController@reporteBibliografiaBasica: Filtros guardados cargados: ' . print_r($tiposFormacionFiltro, true));
                }
            }
        }
        
        error_log('ReporteController@reporteBibliografiaBasica: Sede ID: ' . $sedeId . ', Carrera ID: ' . $carreraId);
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

        // Obtener asignaturas REGULARES (siempre incluidas)
        $regulares = DB::table('vw_mallas')
            ->where('id_sede', $sedeId)
            ->where('id_carrera', $carreraId)
            ->where('tipo_asignatura', 'REGULAR')
            ->select('codigo_asignatura as codigo', 'asignatura as nombre', 'tipo_asignatura')
            ->distinct()
            ->get();

        // Obtener asignaturas de los tipos de formación seleccionados
        $formaciones = collect();
        if (!empty($tiposFormacionFiltro)) {
            // Si hay filtros aplicados, usar solo los seleccionados
            $formaciones = DB::table('vw_mallas')
                ->where('id_sede', $sedeId)
                ->where('id_carrera', $carreraId)
                ->whereIn('tipo_asignatura', $tiposFormacionFiltro)
                ->whereNotNull('codigo_asignatura_formacion')
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
            // Primera carga: todas las de formación disponibles
            $formaciones = DB::table('vw_mallas')
                ->where('id_sede', $sedeId)
                ->where('id_carrera', $carreraId)
                ->whereNotIn('tipo_asignatura', ['FORMACION_ELECTIVA', 'REGULAR'])
                ->whereNotNull('codigo_asignatura_formacion')
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

        // Obtener todos los tipos de formación disponibles para esta carrera (excluyendo REGULAR y ELECTIVA)
        $tiposFormacionDisponibles = DB::table('vw_mallas')
            ->where('id_sede', $sedeId)
            ->where('id_carrera', $carreraId)
            ->whereNotIn('tipo_asignatura', ['FORMACION_ELECTIVA', 'REGULAR'])
            ->whereNotNull('codigo_asignatura_formacion') // Solo asignaturas que tienen código de formación
            ->pluck('tipo_asignatura')
            ->unique()
            ->values()
            ->toArray();
            
        error_log('ReporteController@reporteBibliografiaBasica: Tipos formación disponibles: ' . print_r($tiposFormacionDisponibles, true));

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
            // Calcular valores por bibliografía
            $titulosDeclarados = $bibliografiaDetallada->count();
            $titulosDisponibles = 0;
            $ejemplaresImpresos = 0;
            $ejemplaresDigitales = 0;
            foreach ($bibliografiaDetallada as $bibliografia) {
                // Ejemplares impresos
                $ejemImp = DB::table('vw_bib_declarada_sede_noejem')
                    ->where('id_bib_declarada', $bibliografia->id)
                    ->where('id_sede', $sedeId)
                    ->value('no_ejem_imp_sede') ?? 0;
                $ejemplaresImpresos += $ejemImp;
                // Ejemplares digitales
                $ejemDig = DB::table('bibliografias_disponibles')
                    ->where('bibliografia_declarada_id', $bibliografia->id)
                    ->where('disponibilidad', '!=', 'impreso')
                    ->pluck('ejemplares_digitales');
                $ejemDig = $ejemDig->contains(0) ? 0 : $ejemDig->sum();
                $ejemplaresDigitales += $ejemDig;
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
            $coberturaBasica = $titulosDeclarados > 0 ? round(($titulosDisponibles / $titulosDeclarados) * 100, 2) : 0;
            $asignatura->titulos_declarados = $titulosDeclarados;
            $asignatura->titulos_disponibles = $titulosDisponibles;
            $asignatura->ejemplares_impresos = $ejemplaresImpresos;
            $asignatura->ejemplares_digitales = $ejemplaresDigitales;
            $asignatura->cobertura_basica = $coberturaBasica;
        }

        // Calcular totales de la carrera
        $totalesCarrera = [
            'titulos_declarados' => 0,
            'titulos_disponibles' => 0,
            'ejemplares_impresos' => 0,
            'ejemplares_digitales' => 0
        ];

        // Obtener todas las bibliografías declaradas únicas de la carrera (sin duplicados)
        // Crear una consulta que maneje tanto asignaturas regulares como de formación
        $codigosAsignaturas = $asignaturas->pluck('codigo');

        if ($codigosAsignaturas->isEmpty()) {
            $totalesCarrera['titulos_declarados'] = 0;
            $totalesCarrera['titulos_disponibles'] = 0;
            $totalesCarrera['ejemplares_impresos'] = 0;
            $totalesCarrera['ejemplares_digitales'] = 0;
            $coberturaBasicaTotal = 0;
        } else {
            // Solo contar bibliografías declaradas de las asignaturas visibles
            $bibliografiasDeclaradasUnicas = DB::table('asignaturas_bibliografias')
                ->join('asignaturas_departamentos', 'asignaturas_bibliografias.asignatura_id', '=', 'asignaturas_departamentos.asignatura_id')
                ->where('asignaturas_bibliografias.tipo_bibliografia', 'basica')
                ->whereIn('asignaturas_departamentos.codigo_asignatura', $codigosAsignaturas)
                ->distinct('asignaturas_bibliografias.bibliografia_id')
                ->pluck('asignaturas_bibliografias.bibliografia_id');

            $totalesCarrera['titulos_declarados'] = $bibliografiasDeclaradasUnicas->count();

            // Solo contar bibliografías disponibles de las asignaturas visibles
            $bibliografiasDisponiblesUnicas = DB::table('asignaturas_bibliografias')
                ->join('asignaturas_departamentos', 'asignaturas_bibliografias.asignatura_id', '=', 'asignaturas_departamentos.asignatura_id')
                ->join('bibliografias_disponibles', 'asignaturas_bibliografias.bibliografia_id', '=', 'bibliografias_disponibles.bibliografia_declarada_id')
                ->where('asignaturas_bibliografias.tipo_bibliografia', 'basica')
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

            // Calcular total de ejemplares impresos
            if ($bibliografiasDeclaradasUnicas->count() > 0) {
                $totalesCarrera['ejemplares_impresos'] = DB::table('vw_bib_declarada_sede_noejem')
                    ->whereIn('id_bib_declarada', $bibliografiasDeclaradasUnicas)
                    ->where('id_sede', $sedeId)
                    ->sum('no_ejem_imp_sede') ?? 0;
            }

            // Calcular total de ejemplares digitales
            if ($bibliografiasDisponiblesUnicas->count() > 0) {
                $ejemplaresDigitalesTotal = DB::table('bibliografias_disponibles')
                    ->whereIn('bibliografia_declarada_id', $bibliografiasDisponiblesUnicas)
                    ->where('disponibilidad', '!=', 'impreso')
                    ->pluck('ejemplares_digitales');

                // Si hay algún 0, el resultado es 0 (Ilimitado)
                $totalesCarrera['ejemplares_digitales'] = $ejemplaresDigitalesTotal->contains(0) ? 0 : $ejemplaresDigitalesTotal->sum();
            }

            // Calcular cobertura básica total
            $coberturaBasicaTotal = $totalesCarrera['titulos_declarados'] > 0 
                ? round(($totalesCarrera['titulos_disponibles'] / $totalesCarrera['titulos_declarados']) * 100, 2) 
                : 0;
        }

        error_log('ReporteController@reporteBibliografiaBasica: Totales calculados: ' . print_r($totalesCarrera, true));
        error_log('ReporteController@reporteBibliografiaBasica: Cobertura básica total: ' . $coberturaBasicaTotal . '%');

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
            'totales_carrera' => $totalesCarrera,
            'cobertura_basica_total' => $coberturaBasicaTotal
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
            
        if (!$asignatura) {
            error_log('ReporteController@reporteTitulosBibliografiaBasica: No se encontró la asignatura');
            $response->getBody()->write('Asignatura no encontrada');
            return $response->withStatus(404);
        }

        // Obtener bibliografías declaradas de tipo básica para la asignatura
        // Primero necesitamos obtener el ID de la asignatura
        $asignaturaId = DB::table('asignaturas_departamentos')
            ->where('codigo_asignatura', $asignaturaCodigo)
            ->value('asignatura_id');
            
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
            
            // # Ejemplares impresos (suma de ejemplares de la sede)
            $ejemplaresImpresos = DB::table('vw_bib_declarada_sede_noejem')
                ->where('id_bib_declarada', $bibliografia->id)
                ->where('id_sede', $sedeId)
                ->value('no_ejem_imp_sede') ?? 0;
                
            error_log('ReporteController@reporteTitulosBibliografiaBasica: Ejemplares impresos para ' . $bibliografia->titulo . ': ' . $ejemplaresImpresos);

            // # Ejemplares digitales (usar bibliografias_disponibles)
            $ejemplaresDigitales = DB::table('bibliografias_disponibles')
                ->where('bibliografia_declarada_id', $bibliografia->id)
                ->where('disponibilidad', '!=', 'impreso')
                ->pluck('ejemplares_digitales');

            // Si hay algún 0, el resultado es 0 (Ilimitado)
            $ejemplaresDigitales = $ejemplaresDigitales->contains(0) ? 0 : $ejemplaresDigitales->sum();
            
            error_log('ReporteController@reporteTitulosBibliografiaBasica: Ejemplares digitales para ' . $bibliografia->titulo . ': ' . $ejemplaresDigitales);

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
                
            error_log('ReporteController@reporteTitulosBibliografiaBasica: Disponible para ' . $bibliografia->titulo . ': ' . ($disponible ? 'Sí' : 'No'));

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

    // Reporte expandido de bibliografía básica por carrera
    public function reporteBibliografiaBasicaExpandido(Request $request, Response $response, array $args): Response
    {
        error_log('ReporteController@reporteBibliografiaBasicaExpandido: Iniciando método');
        
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
        
        $tiposFormacionVacio = $request->getQueryParams()['tipos_formacion_vacio'] ?? null;
        
        // Si no hay filtros en la URL, intentar cargar filtros guardados
        if (empty($tiposFormacionFiltro) && !$tiposFormacionVacio) {
            $carreraTemp = DB::table('vw_mallas')
                ->where('id_sede', $sedeId)
                ->where('id_carrera', $carreraId)
                ->select('codigo_carrera as codigo')
                ->first();
                
            if ($carreraTemp) {
                $filtrosGuardados = DB::table('filtros_formaciones')
                    ->where('codigo_carrera', $carreraTemp->codigo)
                    ->first();
                    
                if ($filtrosGuardados) {
                    // Convertir los filtros guardados a array de tipos de formación
                    if ($filtrosGuardados->basica) $tiposFormacionFiltro[] = 'FORMACION_BASICA';
                    if ($filtrosGuardados->general) $tiposFormacionFiltro[] = 'FORMACION_GENERAL';
                    if ($filtrosGuardados->idioma) $tiposFormacionFiltro[] = 'FORMACION_IDIOMAS';
                    if ($filtrosGuardados->profesional) $tiposFormacionFiltro[] = 'FORMACION_PROFESIONAL';
                    if ($filtrosGuardados->valores) $tiposFormacionFiltro[] = 'FORMACION_VALORES';
                    if ($filtrosGuardados->especialidad) $tiposFormacionFiltro[] = 'FORMACION_ESPECIALIDAD';
                    if ($filtrosGuardados->especial) $tiposFormacionFiltro[] = 'FORMACION_ESPECIAL';
                    
                    $hayFiltrosAplicados = !empty($tiposFormacionFiltro);
                    error_log('ReporteController@reporteBibliografiaBasicaExpandido: Filtros guardados cargados: ' . print_r($tiposFormacionFiltro, true));
                }
            }
        }
        
        error_log('ReporteController@reporteBibliografiaBasicaExpandido: Sede ID: ' . $sedeId . ', Carrera ID: ' . $carreraId);
        error_log('ReporteController@reporteBibliografiaBasicaExpandido: Tipos formación filtro: ' . print_r($tiposFormacionFiltro, true));

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
            error_log('ReporteController@reporteBibliografiaBasicaExpandido: No se encontró la carrera');
            $response->getBody()->write('Carrera no encontrada');
            return $response->withStatus(404);
        }
        
        error_log('ReporteController@reporteBibliografiaBasicaExpandido: Carrera encontrada: ' . $carrera->nombre);

        // Obtener asignaturas REGULARES (siempre incluidas)
        $regulares = DB::table('vw_mallas')
            ->where('id_sede', $sedeId)
            ->where('id_carrera', $carreraId)
            ->where('tipo_asignatura', 'REGULAR')
            ->select('codigo_asignatura as codigo', 'asignatura as nombre', 'tipo_asignatura')
            ->distinct()
            ->get();

        // Obtener asignaturas de los tipos de formación seleccionados
        $formaciones = collect();
        if (!empty($tiposFormacionFiltro)) {
            // Si hay filtros aplicados, usar solo los seleccionados
            $formaciones = DB::table('vw_mallas')
                ->where('id_sede', $sedeId)
                ->where('id_carrera', $carreraId)
                ->whereIn('tipo_asignatura', $tiposFormacionFiltro)
                ->whereNotNull('codigo_asignatura_formacion')
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
            // Primera carga: todas las de formación disponibles
            $formaciones = DB::table('vw_mallas')
                ->where('id_sede', $sedeId)
                ->where('id_carrera', $carreraId)
                ->whereNotIn('tipo_asignatura', ['FORMACION_ELECTIVA', 'REGULAR'])
                ->whereNotNull('codigo_asignatura_formacion')
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

        error_log('ReporteController@reporteBibliografiaBasicaExpandido: Asignaturas regulares encontradas: ' . count($regulares));
        error_log('ReporteController@reporteBibliografiaBasicaExpandido: Asignaturas de formación encontradas: ' . count($formaciones));
        error_log('ReporteController@reporteBibliografiaBasicaExpandido: Total asignaturas encontradas (regulares + filtro): ' . count($asignaturas));

        // Obtener todos los tipos de formación disponibles para esta carrera (excluyendo REGULAR y ELECTIVA)
        $tiposFormacionDisponibles = DB::table('vw_mallas')
            ->where('id_sede', $sedeId)
            ->where('id_carrera', $carreraId)
            ->whereNotIn('tipo_asignatura', ['FORMACION_ELECTIVA', 'REGULAR'])
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
                    
                    // # Ejemplares impresos (suma de ejemplares de la sede)
                    $ejemplaresImpresos = DB::table('vw_bib_declarada_sede_noejem')
                        ->where('id_bib_declarada', $bibliografia->id)
                        ->where('id_sede', $sedeId)
                        ->value('no_ejem_imp_sede') ?? 0;
                        
                    // # Ejemplares digitales (usar bibliografias_disponibles)
                    $ejemplaresDigitales = DB::table('bibliografias_disponibles')
                        ->where('bibliografia_declarada_id', $bibliografia->id)
                        ->where('disponibilidad', '!=', 'impreso')
                        ->pluck('ejemplares_digitales');

                    // Si hay algún 0, el resultado es 0 (Ilimitado)
                    $ejemplaresDigitales = $ejemplaresDigitales->contains(0) ? 0 : $ejemplaresDigitales->sum();
                    
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

        // Filtrar solo filas con bibliografía declarada real
        $datosBibliografia = $datosBibliografia->filter(function($fila) {
            return !empty($fila['id_bibliografia_declarada']);
        })->values();

        // Calcular totales de la carrera
        $totalesCarrera = [
            'titulos_declarados' => 0,
            'titulos_disponibles' => 0,
            'ejemplares_impresos' => 0,
            'ejemplares_digitales' => 0
        ];

        // Obtener todas las bibliografías declaradas únicas de la carrera (sin duplicados)
        $codigosAsignaturas = $asignaturas->pluck('codigo');

        if ($codigosAsignaturas->isEmpty()) {
            $totalesCarrera['titulos_declarados'] = 0;
            $totalesCarrera['titulos_disponibles'] = 0;
            $totalesCarrera['ejemplares_impresos'] = 0;
            $totalesCarrera['ejemplares_digitales'] = 0;
            $coberturaBasicaTotal = 0;
        } else {
            // Solo contar bibliografías declaradas de las asignaturas visibles
            $bibliografiasDeclaradasUnicas = DB::table('asignaturas_bibliografias')
                ->join('asignaturas_departamentos', 'asignaturas_bibliografias.asignatura_id', '=', 'asignaturas_departamentos.asignatura_id')
                ->where('asignaturas_bibliografias.tipo_bibliografia', 'basica')
                ->whereIn('asignaturas_departamentos.codigo_asignatura', $codigosAsignaturas)
                ->distinct('asignaturas_bibliografias.bibliografia_id')
                ->pluck('asignaturas_bibliografias.bibliografia_id');

            $totalesCarrera['titulos_declarados'] = $bibliografiasDeclaradasUnicas->count();

            // Solo contar bibliografías disponibles de las asignaturas visibles
            $bibliografiasDisponiblesUnicas = DB::table('asignaturas_bibliografias')
                ->join('asignaturas_departamentos', 'asignaturas_bibliografias.asignatura_id', '=', 'asignaturas_departamentos.asignatura_id')
                ->join('bibliografias_disponibles', 'asignaturas_bibliografias.bibliografia_id', '=', 'bibliografias_disponibles.bibliografia_declarada_id')
                ->where('asignaturas_bibliografias.tipo_bibliografia', 'basica')
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

            // Calcular total de ejemplares impresos
            if ($bibliografiasDeclaradasUnicas->count() > 0) {
                $totalesCarrera['ejemplares_impresos'] = DB::table('vw_bib_declarada_sede_noejem')
                    ->whereIn('id_bib_declarada', $bibliografiasDeclaradasUnicas)
                    ->where('id_sede', $sedeId)
                    ->sum('no_ejem_imp_sede') ?? 0;
            }

            // Calcular total de ejemplares digitales
            if ($bibliografiasDisponiblesUnicas->count() > 0) {
                $ejemplaresDigitalesTotal = DB::table('bibliografias_disponibles')
                    ->whereIn('bibliografia_declarada_id', $bibliografiasDisponiblesUnicas)
                    ->where('disponibilidad', '!=', 'impreso')
                    ->pluck('ejemplares_digitales');

                // Si hay algún 0, el resultado es 0 (Ilimitado)
                $totalesCarrera['ejemplares_digitales'] = $ejemplaresDigitalesTotal->contains(0) ? 0 : $ejemplaresDigitalesTotal->sum();
            }

            // Calcular cobertura básica total
            $coberturaBasicaTotal = $totalesCarrera['titulos_declarados'] > 0 
                ? round(($totalesCarrera['titulos_disponibles'] / $totalesCarrera['titulos_declarados']) * 100, 2) 
                : 0;
        }

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
            'totales_carrera' => $totalesCarrera,
            'cobertura_basica_total' => $coberturaBasicaTotal,
            'current_page' => 'coberturas'
        ]);
        $response->getBody()->write($html);
        return $response->withHeader('Content-Type', 'text/html');
    }

    public function exportarBibliografiaBasicaExcel($request, $response, $args)
    {
        $sedeId = $args['sede_id'];
        $carreraId = $args['carrera_id'];

        // Copiar lógica de obtención de datos del método reporteBibliografiaBasica
        $regulares = DB::table('vw_mallas')
            ->where('id_sede', $sedeId)
            ->where('id_carrera', $carreraId)
            ->where('tipo_asignatura', 'REGULAR')
            ->select('codigo_asignatura as codigo', 'asignatura as nombre', 'tipo_asignatura')
            ->distinct()
            ->get();

        $formaciones = DB::table('vw_mallas')
            ->where('id_sede', $sedeId)
            ->where('id_carrera', $carreraId)
            ->whereNotIn('tipo_asignatura', ['FORMACION_ELECTIVA', 'REGULAR'])
            ->whereNotNull('codigo_asignatura_formacion')
            ->select('codigo_asignatura_formacion as codigo', 'asignatura_formacion as nombre', 'tipo_asignatura')
            ->distinct()
            ->get();

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
            // Calcular valores por bibliografía
            $titulosDeclarados = $bibliografiaDetallada->count();
            $titulosDisponibles = 0;
            $ejemplaresImpresos = 0;
            $ejemplaresDigitales = 0;
            foreach ($bibliografiaDetallada as $bibliografia) {
                // Ejemplares impresos
                $ejemImp = DB::table('vw_bib_declarada_sede_noejem')
                    ->where('id_bib_declarada', $bibliografia->id)
                    ->where('id_sede', $sedeId)
                    ->value('no_ejem_imp_sede') ?? 0;
                $ejemplaresImpresos += $ejemImp;
                // Ejemplares digitales
                $ejemDig = DB::table('bibliografias_disponibles')
                    ->where('bibliografia_declarada_id', $bibliografia->id)
                    ->where('disponibilidad', '!=', 'impreso')
                    ->pluck('ejemplares_digitales');
                $ejemDig = $ejemDig->contains(0) ? 0 : $ejemDig->sum();
                $ejemplaresDigitales += $ejemDig;
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
            $coberturaBasica = $titulosDeclarados > 0 ? round(($titulosDisponibles / $titulosDeclarados) * 100, 2) : 0;
            $asignatura->titulos_declarados = $titulosDeclarados;
            $asignatura->titulos_disponibles = $titulosDisponibles;
            $asignatura->ejemplares_impresos = $ejemplaresImpresos;
            $asignatura->ejemplares_digitales = $ejemplaresDigitales;
            $asignatura->cobertura_basica = $coberturaBasica;
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
            $coberturaBasicaTotal = 0;
        } else {
            $bibliografiasDeclaradasUnicas = DB::table('asignaturas_bibliografias')
                ->join('asignaturas_departamentos', 'asignaturas_bibliografias.asignatura_id', '=', 'asignaturas_departamentos.asignatura_id')
                ->where('asignaturas_bibliografias.tipo_bibliografia', 'basica')
                ->whereIn('asignaturas_departamentos.codigo_asignatura', $codigosAsignaturas)
                ->distinct('asignaturas_bibliografias.bibliografia_id')
                ->pluck('asignaturas_bibliografias.bibliografia_id');
            $totalesCarrera['titulos_declarados'] = $bibliografiasDeclaradasUnicas->count();
            $bibliografiasDisponiblesUnicas = DB::table('asignaturas_bibliografias')
                ->join('asignaturas_departamentos', 'asignaturas_bibliografias.asignatura_id', '=', 'asignaturas_departamentos.asignatura_id')
                ->join('bibliografias_disponibles', 'asignaturas_bibliografias.bibliografia_id', '=', 'bibliografias_disponibles.bibliografia_declarada_id')
                ->where('asignaturas_bibliografias.tipo_bibliografia', 'basica')
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
                $ejemplaresDigitalesTotal = DB::table('bibliografias_disponibles')
                    ->whereIn('bibliografia_declarada_id', $bibliografiasDisponiblesUnicas)
                    ->where('disponibilidad', '!=', 'impreso')
                    ->pluck('ejemplares_digitales');

                // Si hay algún 0, el resultado es 0 (Ilimitado)
                $totalesCarrera['ejemplares_digitales'] = $ejemplaresDigitalesTotal->contains(0) ? 0 : $ejemplaresDigitalesTotal->sum();
            }
            $coberturaBasicaTotal = $totalesCarrera['titulos_declarados'] > 0 
                ? round(($totalesCarrera['titulos_disponibles'] / $totalesCarrera['titulos_declarados']) * 100, 2) 
                : 0;
        }

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
            $sheet->setCellValue('G'.$rowNum, $asignatura->ejemplares_impresos ?? '');
            // Ejemplares Digitales: lógica especial
            $ejemDig = $asignatura->ejemplares_digitales;
            if (($asignatura->titulos_disponibles ?? 0) > 0 && $ejemDig == 0) {
                $ejemDigStr = 'Ilimitado';
            } elseif ($ejemDig == 0) {
                $ejemDigStr = 'Sin información';
            } else {
                $ejemDigStr = $ejemDig;
            }
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
        $sheet->setCellValue('G'.$rowNum, $totalesCarrera['ejemplares_impresos']);
        // Totales ejemplares digitales: lógica especial
        $ejemDigTot = $totalesCarrera['ejemplares_digitales'];
        if ($totalesCarrera['titulos_disponibles'] > 0 && $ejemDigTot == 0) {
            $ejemDigTotStr = 'Ilimitado';
        } elseif ($ejemDigTot == 0) {
            $ejemDigTotStr = 'Sin información';
        } else {
            $ejemDigTotStr = $ejemDigTot;
        }
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
        $urlDescarga = '/reportes/'.$nombreArchivo;
        $response->getBody()->write(json_encode(['url' => $urlDescarga]));
        return $response->withHeader('Content-Type', 'application/json');
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
            $tiposFormacionVacio = $request->getQueryParams()['tipos_formacion_vacio'] ?? null;
            
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
                ->where('id_carrera', $carreraId)
                ->where('tipo_asignatura', 'REGULAR')
                ->select('codigo_asignatura as codigo', 'asignatura as nombre', 'tipo_asignatura')
                ->distinct()
                ->get();

            // Obtener asignaturas de los tipos de formación seleccionados
            $formaciones = collect();
            if (!empty($tiposFormacionFiltro)) {
                // Si hay filtros aplicados, usar solo los seleccionados
                $formaciones = DB::table('vw_mallas')
                    ->where('id_sede', $sedeId)
                    ->where('id_carrera', $carreraId)
                    ->whereIn('tipo_asignatura', $tiposFormacionFiltro)
                    ->whereNotNull('codigo_asignatura_formacion')
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
                // Primera carga: todas las de formación disponibles
                $formaciones = DB::table('vw_mallas')
                    ->where('id_sede', $sedeId)
                    ->where('id_carrera', $carreraId)
                    ->whereNotIn('tipo_asignatura', ['FORMACION_ELECTIVA', 'REGULAR'])
                    ->whereNotNull('codigo_asignatura_formacion')
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
                        
                        // # Ejemplares impresos (suma de ejemplares de la sede)
                        $ejemplaresImpresos = DB::table('vw_bib_declarada_sede_noejem')
                            ->where('id_bib_declarada', $bibliografia->id)
                            ->where('id_sede', $sedeId)
                            ->value('no_ejem_imp_sede') ?? 0;
                            
                        // # Ejemplares digitales (usar bibliografias_disponibles)
                        $ejemplaresDigitales = DB::table('bibliografias_disponibles')
                            ->where('bibliografia_declarada_id', $bibliografia->id)
                            ->where('disponibilidad', '!=', 'impreso')
                            ->pluck('ejemplares_digitales');

                        // Si hay algún 0, el resultado es 0 (Ilimitado)
                        $ejemplaresDigitales = $ejemplaresDigitales->contains(0) ? 0 : $ejemplaresDigitales->sum();
                        
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

            // Calcular totales de la carrera
            $totalesCarrera = [
                'titulos_declarados' => 0,
                'titulos_disponibles' => 0,
                'ejemplares_impresos' => 0,
                'ejemplares_digitales' => 0
            ];

            // Obtener todas las bibliografías declaradas únicas de la carrera (sin duplicados)
            $codigosAsignaturas = $asignaturas->pluck('codigo');

            if ($codigosAsignaturas->isEmpty()) {
                $totalesCarrera['titulos_declarados'] = 0;
                $totalesCarrera['titulos_disponibles'] = 0;
                $totalesCarrera['ejemplares_impresos'] = 0;
                $totalesCarrera['ejemplares_digitales'] = 0;
                $coberturaBasicaTotal = 0;
            } else {
                // Solo contar bibliografías declaradas de las asignaturas visibles
                $bibliografiasDeclaradasUnicas = DB::table('asignaturas_bibliografias')
                    ->join('asignaturas_departamentos', 'asignaturas_bibliografias.asignatura_id', '=', 'asignaturas_departamentos.asignatura_id')
                    ->where('asignaturas_bibliografias.tipo_bibliografia', 'basica')
                    ->whereIn('asignaturas_departamentos.codigo_asignatura', $codigosAsignaturas)
                    ->distinct('asignaturas_bibliografias.bibliografia_id')
                    ->pluck('asignaturas_bibliografias.bibliografia_id');

                $totalesCarrera['titulos_declarados'] = $bibliografiasDeclaradasUnicas->count();

                // Solo contar bibliografías disponibles de las asignaturas visibles
                $bibliografiasDisponiblesUnicas = DB::table('asignaturas_bibliografias')
                    ->join('asignaturas_departamentos', 'asignaturas_bibliografias.asignatura_id', '=', 'asignaturas_departamentos.asignatura_id')
                    ->join('bibliografias_disponibles', 'asignaturas_bibliografias.bibliografia_id', '=', 'bibliografias_disponibles.bibliografia_declarada_id')
                    ->where('asignaturas_bibliografias.tipo_bibliografia', 'basica')
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

                // Calcular total de ejemplares impresos
                if ($bibliografiasDeclaradasUnicas->count() > 0) {
                    $totalesCarrera['ejemplares_impresos'] = DB::table('vw_bib_declarada_sede_noejem')
                        ->whereIn('id_bib_declarada', $bibliografiasDeclaradasUnicas)
                        ->where('id_sede', $sedeId)
                        ->sum('no_ejem_imp_sede') ?? 0;
                }

                // Calcular total de ejemplares digitales
                if ($bibliografiasDisponiblesUnicas->count() > 0) {
                    $ejemplaresDigitalesTotal = DB::table('bibliografias_disponibles')
                        ->whereIn('bibliografia_declarada_id', $bibliografiasDisponiblesUnicas)
                        ->where('disponibilidad', '!=', 'impreso')
                        ->pluck('ejemplares_digitales');

                    // Si hay algún 0, el resultado es 0 (Ilimitado)
                    $totalesCarrera['ejemplares_digitales'] = $ejemplaresDigitalesTotal->contains(0) ? 0 : $ejemplaresDigitalesTotal->sum();
                }

                // Calcular cobertura básica total
                $coberturaBasicaTotal = $totalesCarrera['titulos_declarados'] > 0 
                    ? round(($totalesCarrera['titulos_disponibles'] / $totalesCarrera['titulos_declarados']) * 100, 2) 
                    : 0;
            }

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
                if ($fila['ejemplares_impresos'] == 0 && $fila['ejemplares_digitales'] == 0 && !$fila['disponible']) {
                    $sheet->setCellValue('F'.$rowNum, 'Sin información');
                    $sheet->setCellValue('G'.$rowNum, 'Sin información');
                } else {
                    $sheet->setCellValue('F'.$rowNum, $fila['ejemplares_impresos']);
                    // Ejemplares Digitales: lógica especial
                    $ejemDig = $fila['ejemplares_digitales'];
                    if ($ejemDig == 0) {
                        $ejemDigStr = 'Ilimitado';
                    } else {
                        $ejemDigStr = $ejemDig;
                    }
                    $sheet->setCellValue('G'.$rowNum, $ejemDigStr);
                }
                $sheet->setCellValue('H'.$rowNum, $fila['cobertura'].'%');
                // Centrar columnas E, F, G, H
                $sheet->getStyle('E'.$rowNum.':H'.$rowNum)->getAlignment()->setHorizontal('center');
                $rowNum++;
            }
            
            // Fila de totales
            $sheet->setCellValue('A'.$rowNum, 'TOTALES DE LA CARRERA');
            $sheet->mergeCells('A'.$rowNum.':C'.$rowNum);
            $sheet->getStyle('A'.$rowNum.':C'.$rowNum)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('D'.$rowNum, $totalesCarrera['titulos_declarados']);
            $sheet->setCellValue('E'.$rowNum, '');
            $sheet->setCellValue('F'.$rowNum, $totalesCarrera['ejemplares_impresos']);
            // Totales ejemplares digitales: lógica especial
            $ejemDigTot = $totalesCarrera['ejemplares_digitales'];
            if ($totalesCarrera['titulos_disponibles'] > 0 && $ejemDigTot == 0) {
                $ejemDigTotStr = 'Ilimitado';
            } elseif ($ejemDigTot == 0) {
                $ejemDigTotStr = 'Sin información';
            } else {
                $ejemDigTotStr = $ejemDigTot;
            }
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
            if (!is_dir($rutaCarpeta)) mkdir($rutaCarpeta, 0777, true);
            $rutaCompleta = $rutaCarpeta.$nombreArchivo;
            $writer = new Xlsx($spreadsheet);
            $writer->save($rutaCompleta);
            $urlDescarga = '/reportes/'.$nombreArchivo;
            
            error_log('ReporteController@exportarBibliografiaBasicaExpandidoExcel: Archivo generado: ' . $rutaCompleta);
            
            $response->getBody()->write(json_encode(['url' => $urlDescarga]));
            return $response->withHeader('Content-Type', 'application/json');
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
            $carreraTemp = DB::table('vw_mallas')
                ->where('id_sede', $sedeId)
                ->where('id_carrera', $carreraId)
                ->select('codigo_carrera as codigo')
                ->first();
            if ($carreraTemp) {
                $filtrosGuardados = DB::table('filtros_formaciones')
                    ->where('codigo_carrera', $carreraTemp->codigo)
                    ->first();
                if ($filtrosGuardados) {
                    if ($filtrosGuardados->basica) $tiposFormacionFiltro[] = 'FORMACION_BASICA';
                    if ($filtrosGuardados->general) $tiposFormacionFiltro[] = 'FORMACION_GENERAL';
                    if ($filtrosGuardados->idioma) $tiposFormacionFiltro[] = 'FORMACION_IDIOMAS';
                    if ($filtrosGuardados->profesional) $tiposFormacionFiltro[] = 'FORMACION_PROFESIONAL';
                    if ($filtrosGuardados->valores) $tiposFormacionFiltro[] = 'FORMACION_VALORES';
                    if ($filtrosGuardados->especialidad) $tiposFormacionFiltro[] = 'FORMACION_ESPECIALIDAD';
                    if ($filtrosGuardados->especial) $tiposFormacionFiltro[] = 'FORMACION_ESPECIAL';
                    $hayFiltrosAplicados = !empty($tiposFormacionFiltro);
                    error_log('ReporteController@reporteBibliografiaComplementaria: Filtros guardados cargados: ' . print_r($tiposFormacionFiltro, true));
                }
            }
        }
        
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

        // Obtener asignaturas REGULARES (siempre incluidas)
        $regulares = DB::table('vw_mallas')
            ->where('id_sede', $sedeId)
            ->where('id_carrera', $carreraId)
            ->where('tipo_asignatura', 'REGULAR')
            ->select('codigo_asignatura as codigo', 'asignatura as nombre', 'tipo_asignatura')
            ->distinct()
            ->get();

        // Obtener asignaturas de los tipos de formación seleccionados
        $formaciones = collect();
        if (!empty($tiposFormacionFiltro)) {
            // Si hay filtros aplicados, usar solo los seleccionados
            $formaciones = DB::table('vw_mallas')
                ->where('id_sede', $sedeId)
                ->where('id_carrera', $carreraId)
                ->whereIn('tipo_asignatura', $tiposFormacionFiltro)
                ->whereNotNull('codigo_asignatura_formacion')
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
            // Primera carga: todas las de formación disponibles
            $formaciones = DB::table('vw_mallas')
                ->where('id_sede', $sedeId)
                ->where('id_carrera', $carreraId)
                ->whereNotIn('tipo_asignatura', ['FORMACION_ELECTIVA', 'REGULAR'])
                ->whereNotNull('codigo_asignatura_formacion')
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

        // Obtener todos los tipos de formación disponibles para esta carrera (excluyendo REGULAR y ELECTIVA)
        $tiposFormacionDisponibles = DB::table('vw_mallas')
            ->where('id_sede', $sedeId)
            ->where('id_carrera', $carreraId)
            ->whereNotIn('tipo_asignatura', ['FORMACION_ELECTIVA', 'REGULAR'])
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
            // Calcular valores por bibliografía
            $titulosDeclarados = $bibliografiaDetallada->count();
            $titulosDisponibles = 0;
            $ejemplaresImpresos = 0;
            $ejemplaresDigitales = 0;
            foreach ($bibliografiaDetallada as $bibliografia) {
                // Ejemplares impresos
                $ejemImp = DB::table('vw_bib_declarada_sede_noejem')
                    ->where('id_bib_declarada', $bibliografia->id)
                    ->where('id_sede', $sedeId)
                    ->value('no_ejem_imp_sede') ?? 0;
                $ejemplaresImpresos += $ejemImp;
                // Ejemplares digitales
                $ejemDig = DB::table('bibliografias_disponibles')
                    ->where('bibliografia_declarada_id', $bibliografia->id)
                    ->where('disponibilidad', '!=', 'impreso')
                    ->pluck('ejemplares_digitales');
                $ejemDig = $ejemDig->contains(0) ? 0 : $ejemDig->sum();
                $ejemplaresDigitales += $ejemDig;
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
            $coberturaComplementaria = $titulosDeclarados > 0 ? round(($titulosDisponibles / $titulosDeclarados) * 100, 2) : 0;
            $asignatura->titulos_declarados = $titulosDeclarados;
            $asignatura->titulos_disponibles = $titulosDisponibles;
            $asignatura->ejemplares_impresos = $ejemplaresImpresos;
            $asignatura->ejemplares_digitales = $ejemplaresDigitales;
            $asignatura->cobertura_complementaria = $coberturaComplementaria;
        }

        // Calcular totales de la carrera
        $totalTitulosDeclarados = $asignaturas->sum('titulos_declarados');
        $totalTitulosDisponibles = $asignaturas->sum('titulos_disponibles');
        $totalEjemplaresImpresos = $asignaturas->sum('ejemplares_impresos');
        $totalEjemplaresDigitales = $asignaturas->sum('ejemplares_digitales');
        $coberturaComplementariaTotal = $totalTitulosDeclarados > 0 ? round(($totalTitulosDisponibles / $totalTitulosDeclarados) * 100, 2) : 0;

        $coberturaComplementariaTotal = [
            'total_titulos_declarados' => $totalTitulosDeclarados,
            'total_titulos_disponibles' => $totalTitulosDisponibles,
            'total_ejemplares_impresos' => $totalEjemplaresImpresos,
            'total_ejemplares_digitales' => $totalEjemplaresDigitales,
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

            // Mapear los filtros a los campos de la tabla
            $datosFiltros = [
                'codigo_carrera' => $carrera->codigo,
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
                ->where('codigo_carrera', $carrera->codigo)
            ->first();
            
            if ($filtrosExistentes) {
                // Actualizar filtros existentes
                DB::table('filtros_formaciones')
                    ->where('codigo_carrera', $carrera->codigo)
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
        
            $tiposFormacionVacio = $request->getQueryParams()['tipos_formacion_vacio'] ?? null;
            
        // Si no hay filtros en la URL, intentar cargar filtros guardados
        if (empty($tiposFormacionFiltro) && !$tiposFormacionVacio) {
            $carreraTemp = DB::table('vw_mallas')
                ->where('id_sede', $sedeId)
                ->where('id_carrera', $carreraId)
                ->select('codigo_carrera as codigo')
                ->first();
            if ($carreraTemp) {
                $filtrosGuardados = DB::table('filtros_formaciones')
                    ->where('codigo_carrera', $carreraTemp->codigo)
                    ->first();
                if ($filtrosGuardados) {
                    if ($filtrosGuardados->basica) $tiposFormacionFiltro[] = 'FORMACION_BASICA';
                    if ($filtrosGuardados->general) $tiposFormacionFiltro[] = 'FORMACION_GENERAL';
                    if ($filtrosGuardados->idioma) $tiposFormacionFiltro[] = 'FORMACION_IDIOMAS';
                    if ($filtrosGuardados->profesional) $tiposFormacionFiltro[] = 'FORMACION_PROFESIONAL';
                    if ($filtrosGuardados->valores) $tiposFormacionFiltro[] = 'FORMACION_VALORES';
                    if ($filtrosGuardados->especialidad) $tiposFormacionFiltro[] = 'FORMACION_ESPECIALIDAD';
                    if ($filtrosGuardados->especial) $tiposFormacionFiltro[] = 'FORMACION_ESPECIAL';
                    $hayFiltrosAplicados = !empty($tiposFormacionFiltro);
                    error_log('ReporteController@reporteBibliografiaComplementariaExpandido: Filtros guardados cargados: ' . print_r($tiposFormacionFiltro, true));
                }
            }
        }
        
        error_log('ReporteController@reporteBibliografiaComplementariaExpandido: Sede ID: ' . $sedeId . ', Carrera ID: ' . $carreraId);

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
            error_log('ReporteController@reporteBibliografiaComplementariaExpandido: No se encontró la carrera');
            $response->getBody()->write('Carrera no encontrada');
            return $response->withStatus(404);
            }

            // Obtener asignaturas REGULARES (siempre incluidas)
            $regulares = DB::table('vw_mallas')
                ->where('id_sede', $sedeId)
                ->where('id_carrera', $carreraId)
                ->where('tipo_asignatura', 'REGULAR')
                ->select('codigo_asignatura as codigo', 'asignatura as nombre', 'tipo_asignatura')
                ->distinct()
                ->get();

            // Obtener asignaturas de los tipos de formación seleccionados
            $formaciones = collect();
            if (!empty($tiposFormacionFiltro)) {
                // Si hay filtros aplicados, usar solo los seleccionados
                $formaciones = DB::table('vw_mallas')
                    ->where('id_sede', $sedeId)
                    ->where('id_carrera', $carreraId)
                    ->whereIn('tipo_asignatura', $tiposFormacionFiltro)
                    ->whereNotNull('codigo_asignatura_formacion')
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
                // Primera carga: todas las de formación disponibles
                $formaciones = DB::table('vw_mallas')
                    ->where('id_sede', $sedeId)
                    ->where('id_carrera', $carreraId)
                    ->whereNotIn('tipo_asignatura', ['FORMACION_ELECTIVA', 'REGULAR'])
                    ->whereNotNull('codigo_asignatura_formacion')
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

        // Obtener todos los tipos de formación disponibles para esta carrera (excluyendo REGULAR y ELECTIVA)
        $tiposFormacionDisponibles = DB::table('vw_mallas')
            ->where('id_sede', $sedeId)
            ->where('id_carrera', $carreraId)
            ->whereNotIn('tipo_asignatura', ['FORMACION_ELECTIVA', 'REGULAR'])
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
                        
                        // # Ejemplares impresos (suma de ejemplares de la sede)
                        $ejemplaresImpresos = DB::table('vw_bib_declarada_sede_noejem')
                        ->where('id_bib_declarada', $bibliografia->id)
                        ->where('id_sede', $sedeId)
                        ->value('no_ejem_imp_sede') ?? 0;
                            
                        // # Ejemplares digitales (usar bibliografias_disponibles)
                        $ejemplaresDigitales = DB::table('bibliografias_disponibles')
                        ->where('bibliografia_declarada_id', $bibliografia->id)
                        ->where('disponibilidad', '!=', 'impreso')
                        ->pluck('ejemplares_digitales');

                        // Si hay algún 0, el resultado es 0 (Ilimitado)
                        $ejemplaresDigitales = $ejemplaresDigitales->contains(0) ? 0 : $ejemplaresDigitales->sum();
                        
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

            // Calcular totales de la carrera
        $totalesCarrera = [
            'titulos_declarados' => 0,
            'titulos_disponibles' => 0,
            'ejemplares_impresos' => 0,
            'ejemplares_digitales' => 0
        ];

        // Obtener todas las bibliografías declaradas únicas de la carrera (sin duplicados)
        $codigosAsignaturas = $asignaturas->pluck('codigo');

        if ($codigosAsignaturas->isEmpty()) {
            $totalesCarrera['titulos_declarados'] = 0;
            $totalesCarrera['titulos_disponibles'] = 0;
            $totalesCarrera['ejemplares_impresos'] = 0;
            $totalesCarrera['ejemplares_digitales'] = 0;
            $coberturaComplementariaTotal = 0;
                } else {
            // Solo contar bibliografías declaradas de las asignaturas visibles
            $bibliografiasDeclaradasUnicas = DB::table('asignaturas_bibliografias')
                ->join('asignaturas_departamentos', 'asignaturas_bibliografias.asignatura_id', '=', 'asignaturas_departamentos.asignatura_id')
                ->where('asignaturas_bibliografias.tipo_bibliografia', 'complementaria')
                ->whereIn('asignaturas_departamentos.codigo_asignatura', $codigosAsignaturas)
                ->distinct('asignaturas_bibliografias.bibliografia_id')
                ->pluck('asignaturas_bibliografias.bibliografia_id');

            $totalesCarrera['titulos_declarados'] = $bibliografiasDeclaradasUnicas->count();

            // Solo contar bibliografías disponibles de las asignaturas visibles
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

            // Calcular total de ejemplares impresos
            if ($bibliografiasDeclaradasUnicas->count() > 0) {
                $totalesCarrera['ejemplares_impresos'] = DB::table('vw_bib_declarada_sede_noejem')
                    ->whereIn('id_bib_declarada', $bibliografiasDeclaradasUnicas)
                    ->where('id_sede', $sedeId)
                    ->sum('no_ejem_imp_sede') ?? 0;
            }

            // Calcular total de ejemplares digitales
            if ($bibliografiasDisponiblesUnicas->count() > 0) {
                $ejemplaresDigitalesTotal = DB::table('bibliografias_disponibles')
                    ->whereIn('bibliografia_declarada_id', $bibliografiasDisponiblesUnicas)
                    ->where('disponibilidad', '!=', 'impreso')
                    ->pluck('ejemplares_digitales');

                // Si hay algún 0, el resultado es 0 (Ilimitado)
                $totalesCarrera['ejemplares_digitales'] = $ejemplaresDigitalesTotal->contains(0) ? 0 : $ejemplaresDigitalesTotal->sum();
            }

            // Calcular cobertura complementaria total
            $coberturaComplementariaTotal = $totalesCarrera['titulos_declarados'] > 0 
                ? round(($totalesCarrera['titulos_disponibles'] / $totalesCarrera['titulos_declarados']) * 100, 2) 
                : 0;
        }

        $coberturaComplementariaTotal = [
            'total_titulos_declarados' => $totalesCarrera['titulos_declarados'],
            'total_titulos_disponibles' => $totalesCarrera['titulos_disponibles'],
            'total_ejemplares_impresos' => $totalesCarrera['ejemplares_impresos'],
            'total_ejemplares_digitales' => $totalesCarrera['ejemplares_digitales'],
            'cobertura_complementaria_total' => $coberturaComplementariaTotal
        ];

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
                        DB::table('reporte_coberturas_carreras_basicas')->insert([
                            'id_reporte' => $idReporte,
                    'codigo_carrera' => $codigoCarrera,
                    'codigo_asignatura' => $detalle['codigo_asignatura'],
                    'id_bibliografia_declarada' => $detalle['id_bibliografia_declarada'],
                            'fecha_medicion' => $fechaMedicion,
                    'no_ejem_imp' => $detalle['ejemplares_impresos'] ?? 0,
                    'no_ejem_dig' => $detalle['ejemplares_digitales'] ?? 0,
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
                DB::table('reporte_coberturas_carreras_complementarias')->insert([
                    'id_reporte' => $idReporte,
                    'codigo_carrera' => $codigoCarrera,
                    'codigo_asignatura' => $detalle['codigo_asignatura'],
                    'id_bibliografia_declarada' => ($detalle['id_bibliografia_declarada'] === '' || is_null($detalle['id_bibliografia_declarada'])) ? null : $detalle['id_bibliografia_declarada'],
                    'fecha_medicion' => $fechaMedicion,
                    'no_ejem_imp' => $detalle['ejemplares_impresos'] ?? 0,
                    'no_ejem_dig' => $detalle['ejemplares_digitales'] ?? 0,
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

    public function exportarBibliografiaComplementariaExcel($request, $response, $args)
    {
        $sedeId = $args['sede_id'];
        $carreraId = $args['carrera_id'];

        // Copiar lógica de obtención de datos del método reporteBibliografiaComplementaria
            $regulares = DB::table('vw_mallas')
                ->where('id_sede', $sedeId)
                ->where('id_carrera', $carreraId)
                ->where('tipo_asignatura', 'REGULAR')
                ->select('codigo_asignatura as codigo', 'asignatura as nombre', 'tipo_asignatura')
                ->distinct()
                ->get();

                $formaciones = DB::table('vw_mallas')
                    ->where('id_sede', $sedeId)
                    ->where('id_carrera', $carreraId)
                    ->whereNotIn('tipo_asignatura', ['FORMACION_ELECTIVA', 'REGULAR'])
                    ->whereNotNull('codigo_asignatura_formacion')
                    ->select('codigo_asignatura_formacion as codigo', 'asignatura_formacion as nombre', 'tipo_asignatura')
                    ->distinct()
                    ->get();

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
            // Calcular valores por bibliografía
            $titulosDeclarados = $bibliografiaDetallada->count();
            $titulosDisponibles = 0;
            $ejemplaresImpresos = 0;
            $ejemplaresDigitales = 0;
            foreach ($bibliografiaDetallada as $bibliografia) {
                // Ejemplares impresos
                $ejemImp = DB::table('vw_bib_declarada_sede_noejem')
                                ->where('id_bib_declarada', $bibliografia->id)
                                ->where('id_sede', $sedeId)
                                ->value('no_ejem_imp_sede') ?? 0;
                $ejemplaresImpresos += $ejemImp;
                // Ejemplares digitales
                $ejemDig = DB::table('bibliografias_disponibles')
                                ->where('bibliografia_declarada_id', $bibliografia->id)
                                ->where('disponibilidad', '!=', 'impreso')
                                ->pluck('ejemplares_digitales');
                $ejemDig = $ejemDig->contains(0) ? 0 : $ejemDig->sum();
                $ejemplaresDigitales += $ejemDig;
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
            $coberturaComplementaria = $titulosDeclarados > 0 ? round(($titulosDisponibles / $titulosDeclarados) * 100, 2) : 0;
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
                $ejemplaresDigitalesTotal = DB::table('bibliografias_disponibles')
                    ->whereIn('bibliografia_declarada_id', $bibliografiasDisponiblesUnicas)
                    ->where('disponibilidad', '!=', 'impreso')
                    ->pluck('ejemplares_digitales');

                // Si hay algún 0, el resultado es 0 (Ilimitado)
                $totalesCarrera['ejemplares_digitales'] = $ejemplaresDigitalesTotal->contains(0) ? 0 : $ejemplaresDigitalesTotal->sum();
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
            $sheet->setCellValue('G'.$rowNum, $asignatura->ejemplares_impresos ?? '');
            // Ejemplares Digitales: lógica especial
            $ejemDig = $asignatura->ejemplares_digitales;
            if (($asignatura->titulos_disponibles ?? 0) > 0 && $ejemDig == 0) {
                        $ejemDigStr = 'Ilimitado';
            } elseif ($ejemDig == 0) {
                $ejemDigStr = 'Sin información';
                    } else {
                        $ejemDigStr = $ejemDig;
                    }
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
        $sheet->setCellValue('G'.$rowNum, $totalesCarrera['ejemplares_impresos']);
        // Totales ejemplares digitales: lógica especial
        $ejemDigTot = $totalesCarrera['ejemplares_digitales'];
        if ($totalesCarrera['titulos_disponibles'] > 0 && $ejemDigTot == 0) {
                $ejemDigTotStr = 'Ilimitado';
            } elseif ($ejemDigTot == 0) {
                $ejemDigTotStr = 'Sin información';
            } else {
                $ejemDigTotStr = $ejemDigTot;
            }
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
            $urlDescarga = '/reportes/'.$nombreArchivo;
            $response->getBody()->write(json_encode(['url' => $urlDescarga]));
            return $response->withHeader('Content-Type', 'application/json');
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
        $tiposFormacionVacio = $request->getQueryParams()['tipos_formacion_vacio'] ?? null;
        
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
            ->where('id_carrera', $carreraId)
            ->where('tipo_asignatura', 'REGULAR')
            ->select('codigo_asignatura as codigo', 'asignatura as nombre', 'tipo_asignatura')
            ->distinct()
            ->get();

        // Obtener asignaturas de los tipos de formación seleccionados
        $formaciones = collect();
        if (!empty($tiposFormacionFiltro)) {
            // Si hay filtros aplicados, usar solo los seleccionados
            $formaciones = DB::table('vw_mallas')
                ->where('id_sede', $sedeId)
                ->where('id_carrera', $carreraId)
                ->whereIn('tipo_asignatura', $tiposFormacionFiltro)
                ->whereNotNull('codigo_asignatura_formacion')
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
            // Primera carga: todas las de formación disponibles
            $formaciones = DB::table('vw_mallas')
                ->where('id_sede', $sedeId)
                ->where('id_carrera', $carreraId)
                ->whereNotIn('tipo_asignatura', ['FORMACION_ELECTIVA', 'REGULAR'])
                ->whereNotNull('codigo_asignatura_formacion')
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
                
                    if ($bibliografias->isEmpty()) {
                        // Si no hay bibliografías complementarias activas, agregar fila vacía
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
                        
                        // # Ejemplares impresos (suma de ejemplares de la sede)
                        $ejemplaresImpresos = DB::table('vw_bib_declarada_sede_noejem')
                            ->where('id_bib_declarada', $bibliografia->id)
                            ->where('id_sede', $sedeId)
                            ->value('no_ejem_imp_sede') ?? 0;
                            
                        // # Ejemplares digitales (usar bibliografias_disponibles)
                        $ejemplaresDigitales = DB::table('bibliografias_disponibles')
                            ->where('bibliografia_declarada_id', $bibliografia->id)
                            ->where('disponibilidad', '!=', 'impreso')
                            ->pluck('ejemplares_digitales');

                        // Si hay algún 0, el resultado es 0 (Ilimitado)
                        $ejemplaresDigitales = $ejemplaresDigitales->contains(0) ? 0 : $ejemplaresDigitales->sum();
                        
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

        // Calcular totales de la carrera
        $totalesCarrera = [
                'titulos_declarados' => 0,
                'titulos_disponibles' => 0,
                'ejemplares_impresos' => 0,
                'ejemplares_digitales' => 0
            ];

            // Obtener todas las bibliografías declaradas únicas de la carrera (sin duplicados)
            $codigosAsignaturas = $asignaturas->pluck('codigo');

            if ($codigosAsignaturas->isEmpty()) {
                $totalesCarrera['titulos_declarados'] = 0;
                $totalesCarrera['titulos_disponibles'] = 0;
                $totalesCarrera['ejemplares_impresos'] = 0;
                $totalesCarrera['ejemplares_digitales'] = 0;
                $coberturaComplementariaTotal = 0;
            } else {
                // Solo contar bibliografías declaradas de las asignaturas visibles
                $bibliografiasDeclaradasUnicas = DB::table('asignaturas_bibliografias')
                    ->join('asignaturas_departamentos', 'asignaturas_bibliografias.asignatura_id', '=', 'asignaturas_departamentos.asignatura_id')
                    ->where('asignaturas_bibliografias.tipo_bibliografia', 'complementaria')
                    ->whereIn('asignaturas_departamentos.codigo_asignatura', $codigosAsignaturas)
                    ->distinct('asignaturas_bibliografias.bibliografia_id')
                    ->pluck('asignaturas_bibliografias.bibliografia_id');

                $totalesCarrera['titulos_declarados'] = $bibliografiasDeclaradasUnicas->count();

                // Solo contar bibliografías disponibles de las asignaturas visibles
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

                // Calcular total de ejemplares impresos
                if ($bibliografiasDeclaradasUnicas->count() > 0) {
                    $totalesCarrera['ejemplares_impresos'] = DB::table('vw_bib_declarada_sede_noejem')
                        ->whereIn('id_bib_declarada', $bibliografiasDeclaradasUnicas)
                        ->where('id_sede', $sedeId)
                        ->sum('no_ejem_imp_sede') ?? 0;
                }

                // Calcular total de ejemplares digitales
                if ($bibliografiasDisponiblesUnicas->count() > 0) {
                    $ejemplaresDigitalesTotal = DB::table('bibliografias_disponibles')
                        ->whereIn('bibliografia_declarada_id', $bibliografiasDisponiblesUnicas)
                        ->where('disponibilidad', '!=', 'impreso')
                        ->pluck('ejemplares_digitales');

                    // Si hay algún 0, el resultado es 0 (Ilimitado)
                    $totalesCarrera['ejemplares_digitales'] = $ejemplaresDigitalesTotal->contains(0) ? 0 : $ejemplaresDigitalesTotal->sum();
                }

                // Calcular cobertura complementaria total
                $coberturaComplementariaTotal = $totalesCarrera['titulos_declarados'] > 0 
                    ? round(($totalesCarrera['titulos_disponibles'] / $totalesCarrera['titulos_declarados']) * 100, 2) 
                    : 0;
            }

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
                if ($fila['ejemplares_impresos'] == 0 && $fila['ejemplares_digitales'] == 0 && !$fila['disponible']) {
                    $sheet->setCellValue('F'.$rowNum, 'Sin información');
                    $sheet->setCellValue('G'.$rowNum, 'Sin información');
            } else {
                    $sheet->setCellValue('F'.$rowNum, $fila['ejemplares_impresos']);
                    // Ejemplares Digitales: lógica especial
                    $ejemDig = $fila['ejemplares_digitales'];
                    if ($ejemDig == 0) {
                        $ejemDigStr = 'Ilimitado';
                    } else {
                        $ejemDigStr = $ejemDig;
                    }
                    $sheet->setCellValue('G'.$rowNum, $ejemDigStr);
                }
                $sheet->setCellValue('H'.$rowNum, $fila['cobertura'].'%');
                // Centrar columnas E, F, G, H
                $sheet->getStyle('E'.$rowNum.':H'.$rowNum)->getAlignment()->setHorizontal('center');
                $rowNum++;
            }
            
            // Fila de totales
            $sheet->setCellValue('A'.$rowNum, 'TOTALES DE LA CARRERA');
            $sheet->mergeCells('A'.$rowNum.':C'.$rowNum);
            $sheet->getStyle('A'.$rowNum.':C'.$rowNum)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('D'.$rowNum, $totalesCarrera['titulos_declarados']);
            $sheet->setCellValue('E'.$rowNum, '');
            $sheet->setCellValue('F'.$rowNum, $totalesCarrera['ejemplares_impresos']);
            // Totales ejemplares digitales: lógica especial
            $ejemDigTot = $totalesCarrera['ejemplares_digitales'];
            if ($totalesCarrera['titulos_disponibles'] > 0 && $ejemDigTot == 0) {
                $ejemDigTotStr = 'Ilimitado';
            } elseif ($ejemDigTot == 0) {
                $ejemDigTotStr = 'Sin información';
            } else {
                $ejemDigTotStr = $ejemDigTot;
            }
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
            $urlDescarga = '/reportes/'.$nombreArchivo;
            
            error_log('ReporteController@exportarBibliografiaComplementariaExpandidoExcel: Archivo generado: ' . $rutaCompleta);
            
            $response->getBody()->write(json_encode(['url' => $urlDescarga]));
            return $response->withHeader('Content-Type', 'application/json');
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
                $sheet->setCellValue('E'.$rowNum, $b['ejemplares_impresos'] ?? '');
                $sheet->setCellValue('F'.$rowNum, $b['ejemplares_digitales'] ?? '');
                $sheet->setCellValue('G'.$rowNum, isset($b['cobertura']) ? $b['cobertura'].'%' : '');
                // Complementaria
                $sheet->setCellValue('H'.$rowNum, $c['titulo_declarado'] ?? '');
                $sheet->setCellValue('I'.$rowNum, $c['anio_edicion'] ?? '');
                $sheet->setCellValue('J'.$rowNum, $c['ejemplares_impresos'] ?? '');
                $sheet->setCellValue('K'.$rowNum, $c['ejemplares_digitales'] ?? '');
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
} 