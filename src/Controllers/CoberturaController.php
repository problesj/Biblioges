<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Core\Session;
use App\Core\Config;
use src\Models\Carrera;
use src\Models\Asignatura;
use src\Models\Bibliografia;
use src\Models\BibliografiaDisponible;
use src\Models\CoberturaCarrera;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class CoberturaController extends BaseController
{
    protected $session;

    public function __construct()
    {
        parent::__construct();
        $this->session = new Session();
    }

    /**
     * Muestra el formulario para generar reporte de cobertura
     */
    public function index()
    {
        // Obtener todas las carreras
        $carreras = Carrera::getAll();
        
        // Log para depuración
        error_log('Carreras obtenidas: ' . print_r($carreras->toArray(), true));
        
        // Verificar si hay carreras
        if ($carreras->isEmpty()) {
            error_log('No se encontraron carreras');
        }

        // Renderizar la vista
        try {
            echo $this->twig->render('reportes/cobertura/index.twig', [
                'carreras' => $carreras
            ]);
        } catch (\Exception $e) {
            error_log('Error al renderizar la vista: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getAsignaturasFormacion($carreraId)
    {
        $carrera = Carrera::find($carreraId);
        if (!$carrera) {
            $this->jsonResponse(['error' => 'Carrera no encontrada'], 404);
            return;
        }

        $asignaturas = $carrera->asignaturas()
            ->where('tipo', 'formacion')
            ->orderBy('nombre')
            ->get();

        $this->jsonResponse($asignaturas);
    }

    /**
     * Genera el reporte de cobertura para una carrera
     */
    public function generarReporte()
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                throw new \Exception('Por favor inicie sesión para acceder a esta función');
            }

            // Verificar datos recibidos
            if (!isset($_POST['carrera_id'])) {
                throw new \Exception('Debe seleccionar una carrera');
            }

            $carreraId = (int)$_POST['carrera_id'];
            $asignaturasFormacion = isset($_POST['asignaturas_formacion']) ? $_POST['asignaturas_formacion'] : [];

            // Obtener la carrera
            $carrera = Carrera::find($carreraId);
            if (!$carrera) {
                throw new \Exception('No se encontró la carrera seleccionada');
            }

            // Obtener asignaturas regulares (excluyendo electivas)
            $asignaturas = Asignatura::where('carrera_id', $carreraId)
                ->where('tipo', 'regular')
                ->get();

            // Si hay asignaturas de formación seleccionadas, incluirlas
            if (!empty($asignaturasFormacion)) {
                $asignaturasFormacion = Asignatura::whereIn('id', $asignaturasFormacion)->get();
                $asignaturas = $asignaturas->concat($asignaturasFormacion);
            }

            // Obtener sedes únicas de la carrera
            $sedes = $asignaturas->pluck('sede')->unique()->values();

            $resultados = [];
            $totalesPorSede = [];

            // Inicializar totales por sede
            foreach ($sedes as $sede) {
                $totalesPorSede[$sede] = [
                    'total_bibliografias_declaradas' => 0,
                    'total_bibliografias_disponibles_declaradas' => 0,
                    'total_bibliografias_disponibles' => 0
                ];
            }

            // Calcular cobertura por asignatura y sede
            foreach ($asignaturas as $asignatura) {
                $resultados[$asignatura->id] = [
                    'codigo' => $asignatura->codigo,
                    'nombre' => $asignatura->nombre,
                    'sedes' => []
                ];

                foreach ($sedes as $sede) {
                    // Obtener bibliografías declaradas básicas
                    $bibliografiasBasicas = Bibliografia::where('asignatura_id', $asignatura->id)
                        ->where('tipo', 'basica')
                        ->get();

                    // Obtener bibliografías declaradas complementarias
                    $bibliografiasComplementarias = Bibliografia::where('asignatura_id', $asignatura->id)
                        ->where('tipo', 'complementaria')
                        ->get();

                    // Calcular cobertura básica
                    $coberturaBasica = $this->calcularCobertura($bibliografiasBasicas, $sede);

                    // Calcular cobertura complementaria
                    $coberturaComplementaria = $this->calcularCobertura($bibliografiasComplementarias, $sede);

                    // Actualizar totales por sede
                    $totalesPorSede[$sede]['total_bibliografias_declaradas'] += 
                        $bibliografiasBasicas->count() + $bibliografiasComplementarias->count();
                    $totalesPorSede[$sede]['total_bibliografias_disponibles_declaradas'] += 
                        $coberturaBasica['bibliografias_disponibles_declaradas'] + 
                        $coberturaComplementaria['bibliografias_disponibles_declaradas'];
                    $totalesPorSede[$sede]['total_bibliografias_disponibles'] += 
                        $coberturaBasica['total_bibliografias_disponibles'] + 
                        $coberturaComplementaria['total_bibliografias_disponibles'];

                    $resultados[$asignatura->id]['sedes'][$sede] = [
                        'cobertura_basica' => $coberturaBasica['porcentaje'],
                        'cobertura_complementaria' => $coberturaComplementaria['porcentaje']
                    ];
                }
            }

            // Calcular cobertura total por sede
            $coberturaTotalPorSede = [];
            foreach ($sedes as $sede) {
                $totales = $totalesPorSede[$sede];
                $coberturaTotalPorSede[$sede] = [
                    'cobertura_basica' => $totales['total_bibliografias_declaradas'] > 0 
                        ? ($totales['total_bibliografias_disponibles_declaradas'] / $totales['total_bibliografias_declaradas']) * 100 
                        : 0,
                    'cobertura_complementaria' => $totales['total_bibliografias_declaradas'] > 0 
                        ? ($totales['total_bibliografias_disponibles_declaradas'] / $totales['total_bibliografias_declaradas']) * 100 
                        : 0
                ];
            }

            // Guardar reporte en la base de datos
            foreach ($sedes as $sede) {
                $totales = $totalesPorSede[$sede];
                $coberturaTotal = $coberturaTotalPorSede[$sede];

                CoberturaCarrera::create([
                    'carrera_id' => $carrera->id,
                    'codigo_carrera' => $carrera->codigo,
                    'nombre_carrera' => $carrera->nombre,
                    'sede' => $sede,
                    'cobertura_basica' => $coberturaTotal['cobertura_basica'],
                    'cobertura_complementaria' => $coberturaTotal['cobertura_complementaria'],
                    'fecha_calculo' => now(),
                    'total_bibliografias_declaradas' => $totales['total_bibliografias_declaradas'],
                    'total_bibliografias_disponibles_declaradas' => $totales['total_bibliografias_disponibles_declaradas'],
                    'total_bibliografias_disponibles' => $totales['total_bibliografias_disponibles']
                ]);
            }

            // Generar archivo Excel
            $this->generarExcel($carrera, $resultados, $coberturaTotalPorSede);

            $this->session->set('success', [
                'title' => 'Éxito',
                'text' => 'El reporte se ha generado correctamente',
                'icon' => 'success'
            ]);

            header('Location: ' . Config::get('app_url') . 'reportes/cobertura');
            exit;

        } catch (\Exception $e) {
            error_log("Error en CoberturaController@generarReporte: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            $this->session->set('error', [
                'title' => 'Error',
                'text' => 'Error al generar el reporte: ' . $e->getMessage(),
                'icon' => 'error'
            ]);
            header('Location: ' . Config::get('app_url') . 'reportes/cobertura');
            exit;
        }
    }

    /**
     * Calcula la cobertura para un conjunto de bibliografías en una sede específica
     */
    private function calcularCobertura($bibliografias, $sede)
    {
        $totalBibliografias = $bibliografias->count();
        $bibliografiasDisponiblesDeclaradas = 0;
        $totalBibliografiasDisponibles = 0;

        foreach ($bibliografias as $bibliografia) {
            $tieneDisponible = false;
            $bibliografiasDisponibles = BibliografiaDisponible::where('bibliografia_id', $bibliografia->id)->get();
            $totalBibliografiasDisponibles += $bibliografiasDisponibles->count();

            foreach ($bibliografiasDisponibles as $disponible) {
                // Verificar si la bibliografía está disponible en la sede
                if ($disponible->tipo === 'electronica' || 
                    ($disponible->tipo === 'impreso' && $disponible->sede === $sede) ||
                    ($disponible->tipo === 'ambos' && $disponible->sede === $sede)) {
                    $tieneDisponible = true;
                    break;
                }
            }

            if ($tieneDisponible) {
                $bibliografiasDisponiblesDeclaradas++;
            }
        }

        $porcentaje = $totalBibliografias > 0 
            ? ($bibliografiasDisponiblesDeclaradas / $totalBibliografias) * 100 
            : 0;

        return [
            'porcentaje' => $porcentaje,
            'bibliografias_disponibles_declaradas' => $bibliografiasDisponiblesDeclaradas,
            'total_bibliografias_disponibles' => $totalBibliografiasDisponibles
        ];
    }

    /**
     * Genera el archivo Excel con el reporte
     */
    private function generarExcel($carrera, $resultados, $coberturaTotalPorSede)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Configurar encabezados
        $sheet->setCellValue('A1', 'Reporte de Cobertura Bibliográfica');
        $sheet->setCellValue('A2', 'Carrera: ' . $carrera->nombre);
        $sheet->setCellValue('A3', 'Fecha: ' . date('d/m/Y H:i:s'));

        // Encabezados de columnas
        $sheet->setCellValue('A5', 'Código');
        $sheet->setCellValue('B5', 'Asignatura');
        $columna = 'C';
        foreach (array_keys($coberturaTotalPorSede) as $sede) {
            $sheet->setCellValue($columna . '5', 'Cobertura Básica ' . $sede);
            $columna++;
            $sheet->setCellValue($columna . '5', 'Cobertura Complementaria ' . $sede);
            $columna++;
        }

        // Datos de asignaturas
        $fila = 6;
        foreach ($resultados as $asignatura) {
            $sheet->setCellValue('A' . $fila, $asignatura['codigo']);
            $sheet->setCellValue('B' . $fila, $asignatura['nombre']);
            
            $columna = 'C';
            foreach (array_keys($coberturaTotalPorSede) as $sede) {
                $sheet->setCellValue($columna . $fila, number_format($asignatura['sedes'][$sede]['cobertura_basica'], 2) . '%');
                $columna++;
                $sheet->setCellValue($columna . $fila, number_format($asignatura['sedes'][$sede]['cobertura_complementaria'], 2) . '%');
                $columna++;
            }
            $fila++;
        }

        // Totales por sede
        $fila += 2;
        $sheet->setCellValue('A' . $fila, 'Cobertura Total por Sede');
        $fila++;
        
        foreach ($coberturaTotalPorSede as $sede => $cobertura) {
            $sheet->setCellValue('A' . $fila, $sede);
            $sheet->setCellValue('B' . $fila, 'Básica: ' . number_format($cobertura['cobertura_basica'], 2) . '%');
            $sheet->setCellValue('C' . $fila, 'Complementaria: ' . number_format($cobertura['cobertura_complementaria'], 2) . '%');
            $fila++;
        }

        // Guardar archivo
        $writer = new Xlsx($spreadsheet);
        $filename = 'cobertura_' . $carrera->codigo . '_' . date('Y-m-d_H-i-s') . '.xlsx';
        $writer->save(Config::get('app_path') . '/storage/reports/' . $filename);

        return $filename;
    }
} 