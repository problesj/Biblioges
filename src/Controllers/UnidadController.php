<?php

namespace App\Controllers;

use App\Models\Unidad;
use App\Models\Sede;
use PDO;

/**
 * Controlador para manejar las operaciones de unidades
 */
class UnidadController
{
    private $pdo;
    private $unidadModel;
    private $sedeModel;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->unidadModel = new Unidad($pdo);
        $this->sedeModel = new Sede($pdo);
    }

    /**
     * Mostrar lista de unidades
     */
    public function index()
    {
        try {
            $unidades = $this->unidadModel->getAllWithPadre();
            $sedes = $this->sedeModel->getAll();
            $stats = $this->unidadModel->getStats();

            return [
                'success' => true,
                'data' => [
                    'unidades' => $unidades,
                    'sedes' => $sedes,
                    'stats' => $stats
                ]
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al obtener las unidades: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        try {
            $sedes = $this->sedeModel->getAll();
            $unidadesPadre = $this->unidadModel->getUnidadesPadre();

            return [
                'success' => true,
                'data' => [
                    'sedes' => $sedes,
                    'unidades_padre' => $unidadesPadre
                ]
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al cargar el formulario: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Guardar nueva unidad
     */
    public function store($data)
    {
        try {
            // Validar datos requeridos
            if (empty($data['codigo']) || empty($data['nombre']) || empty($data['sede_id'])) {
                return [
                    'success' => false,
                    'message' => 'Los campos código, nombre y sede son obligatorios.'
                ];
            }

            // Verificar si el código ya existe
            $unidadExistente = $this->unidadModel->getByCodigo($data['codigo']);
            if ($unidadExistente) {
                return [
                    'success' => false,
                    'message' => 'El código de unidad ya existe.'
                ];
            }

            // Validar que la sede existe
            $sede = $this->sedeModel->getById($data['sede_id']);
            if (!$sede) {
                return [
                    'success' => false,
                    'message' => 'La sede seleccionada no existe.'
                ];
            }

            // Validar unidad padre si se proporciona
            if (!empty($data['id_unidad_padre'])) {
                $unidadPadre = $this->unidadModel->getByCodigo($data['id_unidad_padre']);
                if (!$unidadPadre) {
                    return [
                        'success' => false,
                        'message' => 'La unidad padre seleccionada no existe.'
                    ];
                }
            }

            // Crear la unidad
            $unidadId = $this->unidadModel->create($data);

            return [
                'success' => true,
                'message' => 'Unidad creada exitosamente.',
                'data' => ['id' => $unidadId]
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al crear la unidad: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Mostrar unidad específica
     */
    public function show($id)
    {
        try {
            $unidad = $this->unidadModel->getById($id);
            if (!$unidad) {
                return [
                    'success' => false,
                    'message' => 'Unidad no encontrada.'
                ];
            }

            // Obtener unidades hijas si las tiene
            $unidadesHijas = $this->unidadModel->getUnidadesHijas($unidad['codigo']);

            // Obtener jerarquía completa
            $jerarquia = $this->unidadModel->getJerarquia($id);

            return [
                'success' => true,
                'data' => [
                    'unidad' => $unidad,
                    'unidades_hijas' => $unidadesHijas,
                    'jerarquia' => $jerarquia
                ]
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al obtener la unidad: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit($id)
    {
        try {
            $unidad = $this->unidadModel->getById($id);
            if (!$unidad) {
                return [
                    'success' => false,
                    'message' => 'Unidad no encontrada.'
                ];
            }

            $sedes = $this->sedeModel->getAll();
            $unidadesPadre = $this->unidadModel->getUnidadesPadre();

            return [
                'success' => true,
                'data' => [
                    'unidad' => $unidad,
                    'sedes' => $sedes,
                    'unidades_padre' => $unidadesPadre
                ]
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al cargar la unidad: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Actualizar unidad
     */
    public function update($id, $data)
    {
        try {
            // Verificar que la unidad existe
            $unidad = $this->unidadModel->getById($id);
            if (!$unidad) {
                return [
                    'success' => false,
                    'message' => 'Unidad no encontrada.'
                ];
            }

            // Validar datos requeridos
            if (empty($data['codigo']) || empty($data['nombre']) || empty($data['sede_id'])) {
                return [
                    'success' => false,
                    'message' => 'Los campos código, nombre y sede son obligatorios.'
                ];
            }

            // Verificar si el código ya existe (excluyendo la unidad actual)
            $unidadExistente = $this->unidadModel->getByCodigo($data['codigo']);
            if ($unidadExistente && $unidadExistente['id'] != $id) {
                return [
                    'success' => false,
                    'message' => 'El código de unidad ya existe.'
                ];
            }

            // Validar que la sede existe
            $sede = $this->sedeModel->getById($data['sede_id']);
            if (!$sede) {
                return [
                    'success' => false,
                    'message' => 'La sede seleccionada no existe.'
                ];
            }

            // Validar unidad padre si se proporciona
            if (!empty($data['id_unidad_padre'])) {
                $unidadPadre = $this->unidadModel->getByCodigo($data['id_unidad_padre']);
                if (!$unidadPadre) {
                    return [
                        'success' => false,
                        'message' => 'La unidad padre seleccionada no existe.'
                    ];
                }

                // Evitar referencias circulares
                if ($data['id_unidad_padre'] == $unidad['codigo']) {
                    return [
                        'success' => false,
                        'message' => 'Una unidad no puede ser padre de sí misma.'
                    ];
                }
            }

            // Actualizar la unidad
            $this->unidadModel->update($id, $data);

            return [
                'success' => true,
                'message' => 'Unidad actualizada exitosamente.'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al actualizar la unidad: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Eliminar unidad
     */
    public function destroy($id)
    {
        try {
            // Verificar que la unidad existe
            $unidad = $this->unidadModel->getById($id);
            if (!$unidad) {
                return [
                    'success' => false,
                    'message' => 'Unidad no encontrada.'
                ];
            }

            // Eliminar la unidad
            $this->unidadModel->delete($id);

            return [
                'success' => true,
                'message' => 'Unidad eliminada exitosamente.'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al eliminar la unidad: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Buscar unidades
     */
    public function search($term)
    {
        try {
            $unidades = $this->unidadModel->search($term);

            return [
                'success' => true,
                'data' => $unidades
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al buscar unidades: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Obtener unidades por sede
     */
    public function getBySede($sedeId)
    {
        try {
            $unidades = $this->unidadModel->getBySede($sedeId, 1); // Solo activas

            return [
                'success' => true,
                'data' => $unidades
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al obtener unidades por sede: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Obtener unidades padre
     */
    public function getUnidadesPadre($sedeId = null)
    {
        try {
            $unidadesPadre = $this->unidadModel->getUnidadesPadre($sedeId);

            return [
                'success' => true,
                'data' => $unidadesPadre
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al obtener unidades padre: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Obtener unidades hijas
     */
    public function getUnidadesHijas($codigoUnidadPadre)
    {
        try {
            $unidadesHijas = $this->unidadModel->getUnidadesHijas($codigoUnidadPadre);

            return [
                'success' => true,
                'data' => $unidadesHijas
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al obtener unidades hijas: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Obtener estadísticas
     */
    public function getStats()
    {
        try {
            $stats = $this->unidadModel->getStats();

            return [
                'success' => true,
                'data' => $stats
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al obtener estadísticas: ' . $e->getMessage()
            ];
        }
    }
} 