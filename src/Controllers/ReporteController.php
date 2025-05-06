<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Illuminate\Database\Capsule\Manager as DB;

class ReporteController
{
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
} 