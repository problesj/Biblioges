<?php

namespace App\Controllers;

use src\Models\BibliografiaDeclarada;
use src\Models\BibliografiaDisponible;
use src\Models\Sede;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class BibliografiaDisponibleController extends BaseController
{
    /**
     * Muestra la lista de bibliografías disponibles.
     */
    public function index(Request $request, Response $response): Response
    {
        $bibliografias = BibliografiaDisponible::with(['bibliografiaDeclarada', 'sede'])
            ->orderBy('fecha_creacion', 'desc')
            ->get();

        return $this->render($response, 'bibliografias_disponibles/index.twig', [
            'bibliografias' => $bibliografias
        ]);
    }

    /**
     * Muestra el formulario para crear una nueva bibliografía disponible.
     */
    public function create(Request $request, Response $response): Response
    {
        $bibliografias = BibliografiaDeclarada::where('estado', true)->get();
        $sedes = Sede::where('estado', true)->get();

        return $this->render($response, 'bibliografias_disponibles/form.twig', [
            'bibliografias' => $bibliografias,
            'sedes' => $sedes
        ]);
    }

    /**
     * Almacena una nueva bibliografía disponible.
     */
    public function store(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        try {
            $bibliografia = new BibliografiaDisponible();
            $bibliografia->bibliografia_declarada_id = $data['bibliografia_declarada_id'];
            $bibliografia->tipo_disponibilidad = $data['tipo_disponibilidad'];
            $bibliografia->sede_id = $data['sede_id'];
            $bibliografia->ejemplares = $data['tipo_disponibilidad'] !== 'digital' ? $data['ejemplares'] : null;
            $bibliografia->ejemplares_digitales = $data['tipo_disponibilidad'] !== 'fisico' ? $data['ejemplares_digitales'] : null;
            $bibliografia->estado = true;
            $bibliografia->save();

            return $response->withHeader('Location', '/bibliografias-disponibles')
                ->withStatus(302);
        } catch (\Exception $e) {
            return $this->render($response, 'bibliografias_disponibles/form.twig', [
                'error' => 'Error al crear la bibliografía disponible: ' . $e->getMessage(),
                'bibliografias' => BibliografiaDeclarada::where('estado', true)->get(),
                'sedes' => Sede::where('estado', true)->get(),
                'data' => $data
            ]);
        }
    }

    /**
     * Muestra los detalles de una bibliografía disponible.
     */
    public function show(Request $request, Response $response, array $args): Response
    {
        $bibliografia = BibliografiaDisponible::with(['bibliografiaDeclarada', 'sede'])
            ->findOrFail($args['id']);

        return $this->render($response, 'bibliografias_disponibles/show.twig', [
            'bibliografia' => $bibliografia
        ]);
    }

    /**
     * Muestra el formulario para editar una bibliografía disponible.
     */
    public function edit(Request $request, Response $response, array $args): Response
    {
        $bibliografia = BibliografiaDisponible::findOrFail($args['id']);
        $bibliografias = BibliografiaDeclarada::where('estado', true)->get();
        $sedes = Sede::where('estado', true)->get();

        return $this->render($response, 'bibliografias_disponibles/form.twig', [
            'bibliografia' => $bibliografia,
            'bibliografias' => $bibliografias,
            'sedes' => $sedes
        ]);
    }

    /**
     * Actualiza una bibliografía disponible existente.
     */
    public function update(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        try {
            $bibliografia = BibliografiaDisponible::findOrFail($args['id']);
            $bibliografia->bibliografia_declarada_id = $data['bibliografia_declarada_id'];
            $bibliografia->tipo_disponibilidad = $data['tipo_disponibilidad'];
            $bibliografia->sede_id = $data['sede_id'];
            $bibliografia->ejemplares = $data['tipo_disponibilidad'] !== 'digital' ? $data['ejemplares'] : null;
            $bibliografia->ejemplares_digitales = $data['tipo_disponibilidad'] !== 'fisico' ? $data['ejemplares_digitales'] : null;
            $bibliografia->estado = isset($data['estado']);
            $bibliografia->save();

            return $response->withHeader('Location', '/bibliografias-disponibles')
                ->withStatus(302);
        } catch (\Exception $e) {
            return $this->render($response, 'bibliografias_disponibles/form.twig', [
                'error' => 'Error al actualizar la bibliografía disponible: ' . $e->getMessage(),
                'bibliografia' => BibliografiaDisponible::find($args['id']),
                'bibliografias' => BibliografiaDeclarada::where('estado', true)->get(),
                'sedes' => Sede::where('estado', true)->get(),
                'data' => $data
            ]);
        }
    }

    /**
     * Elimina una bibliografía disponible.
     */
    public function destroy(Request $request, Response $response, array $args): Response
    {
        try {
            $bibliografia = BibliografiaDisponible::findOrFail($args['id']);
            $bibliografia->delete();

            return $response->withHeader('Location', '/bibliografias-disponibles')
                ->withStatus(302);
        } catch (\Exception $e) {
            return $this->render($response, 'bibliografias_disponibles/index.twig', [
                'error' => 'Error al eliminar la bibliografía disponible: ' . $e->getMessage(),
                'bibliografias' => BibliografiaDisponible::with(['bibliografiaDeclarada', 'sede'])->get()
            ]);
        }
    }
} 