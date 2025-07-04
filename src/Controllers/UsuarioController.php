<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use src\Controllers\BaseController;
use src\Models\Usuario;

class UsuarioController extends BaseController
{
    protected $usuarioModel;

    public function __construct()
    {
        global $twig;
        parent::__construct($twig, new \Slim\Psr7\Response());
        $this->usuarioModel = new Usuario();
    }

    /**
     * Mostrar listado de usuarios
     */
    public function index(Request $request, Response $response, array $args): Response
    {
        try {
            $params = $request->getQueryParams();
            $page = isset($params['page']) ? (int)$params['page'] : 1;
            $search = $params['search'] ?? '';
            $rol = $params['rol'] ?? '';
            $estado = isset($params['estado']) ? (int)$params['estado'] : '';

            $result = $this->usuarioModel->getAll($page, 10, $search, $rol, $estado);
            
            return $this->render($response, 'usuarios/index.twig', [
                'usuarios' => $result['data'],
                'pagination' => [
                    'current_page' => $result['current_page'],
                    'total_pages' => $result['pages'],
                    'total_records' => $result['total']
                ],
                'filters' => [
                    'search' => $search,
                    'rol' => $rol,
                    'estado' => $estado
                ],
                'roles' => $this->usuarioModel->getRoles(),
                'estados' => $this->usuarioModel->getEstados(),
                'app_url' => $GLOBALS['twig']->getGlobals()['app_url'] ?? '',
                'session' => $_SESSION,
                'current_page' => 'usuarios',
                'user' => [
                    'id' => $_SESSION['user_id'] ?? null,
                    'email' => $_SESSION['user_email'] ?? null,
                    'nombre' => $_SESSION['user_nombre'] ?? null,
                    'rol' => $_SESSION['user_rol'] ?? null
                ]
            ]);
        } catch (\Exception $e) {
            error_log("Error en UsuarioController@index: " . $e->getMessage());
            return $this->errorResponse($response, "Error al cargar el listado de usuarios", 500);
        }
    }

    /**
     * Mostrar formulario de creación
     */
    public function create(Request $request, Response $response, array $args): Response
    {
        try {
            return $this->render($response, 'usuarios/create.twig', [
                'roles' => $this->usuarioModel->getRoles(),
                'estados' => $this->usuarioModel->getEstados(),
                'app_url' => $GLOBALS['twig']->getGlobals()['app_url'] ?? '',
                'session' => $_SESSION,
                'current_page' => 'usuarios',
                'user' => [
                    'id' => $_SESSION['user_id'] ?? null,
                    'email' => $_SESSION['user_email'] ?? null,
                    'nombre' => $_SESSION['user_nombre'] ?? null,
                    'rol' => $_SESSION['user_rol'] ?? null
                ]
            ]);
        } catch (\Exception $e) {
            error_log("Error en UsuarioController@create: " . $e->getMessage());
            return $this->errorResponse($response, "Error al cargar el formulario", 500);
        }
    }

    /**
     * Guardar nuevo usuario
     */
    public function store(Request $request, Response $response, array $args): Response
    {
        try {
            // Adaptar para aceptar JSON
            $contentType = $request->getHeaderLine('Content-Type');
            if (strpos($contentType, 'application/json') !== false) {
                $input = (string)$request->getBody();
                $data = json_decode($input, true);
            } else {
                $data = $request->getParsedBody();
            }
            
            // Validaciones
            $errors = $this->validateUsuario($data);
            
            if (!empty($errors)) {
                return $this->jsonResponse($response, [
                    'success' => false,
                    'message' => 'Errores de validación',
                    'errors' => $errors
                ]);
            }

            // Verificar si el email ya existe
            if ($this->usuarioModel->emailExists($data['email'])) {
                return $this->jsonResponse($response, [
                    'success' => false,
                    'message' => 'El email ya está registrado'
                ]);
            }

            // Verificar si el RUT ya existe
            if ($this->usuarioModel->rutExists($data['rut'])) {
                return $this->jsonResponse($response, [
                    'success' => false,
                    'message' => 'El RUT ya está registrado'
                ]);
            }

            $userId = $this->usuarioModel->create($data);
            
            return $this->jsonResponse($response, [
                'success' => true,
                'message' => 'Usuario creado exitosamente',
                'redirect' => $GLOBALS['twig']->getGlobals()['app_url'] . 'usuarios'
            ]);
        } catch (\Exception $e) {
            error_log("Error en UsuarioController@store: " . $e->getMessage());
            return $this->jsonResponse($response, [
                'success' => false,
                'message' => 'Error al crear el usuario'
            ]);
        }
    }

    /**
     * Mostrar usuario específico
     */
    public function show(Request $request, Response $response, array $args): Response
    {
        try {
            $id = $args['id'];
            $usuario = $this->usuarioModel->find($id);
            
            if (!$usuario) {
                return $this->errorResponse($response, "Usuario no encontrado", 404);
            }

            return $this->render($response, 'usuarios/show.twig', [
                'usuario' => $usuario,
                'roles' => $this->usuarioModel->getRoles(),
                'estados' => $this->usuarioModel->getEstados(),
                'app_url' => $GLOBALS['twig']->getGlobals()['app_url'] ?? '',
                'session' => $_SESSION,
                'current_page' => 'usuarios',
                'user' => [
                    'id' => $_SESSION['user_id'] ?? null,
                    'email' => $_SESSION['user_email'] ?? null,
                    'nombre' => $_SESSION['user_nombre'] ?? null,
                    'rol' => $_SESSION['user_rol'] ?? null
                ]
            ]);
        } catch (\Exception $e) {
            error_log("Error en UsuarioController@show: " . $e->getMessage());
            return $this->errorResponse($response, "Error al cargar el usuario", 500);
        }
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Request $request, Response $response, array $args): Response
    {
        try {
            $id = $args['id'];
            $usuario = $this->usuarioModel->find($id);
            
            if (!$usuario) {
                return $this->errorResponse($response, "Usuario no encontrado", 404);
            }

            return $this->render($response, 'usuarios/edit.twig', [
                'usuario' => $usuario,
                'roles' => $this->usuarioModel->getRoles(),
                'estados' => $this->usuarioModel->getEstados(),
                'app_url' => $GLOBALS['twig']->getGlobals()['app_url'] ?? '',
                'session' => $_SESSION,
                'current_page' => 'usuarios',
                'user' => [
                    'id' => $_SESSION['user_id'] ?? null,
                    'email' => $_SESSION['user_email'] ?? null,
                    'nombre' => $_SESSION['user_nombre'] ?? null,
                    'rol' => $_SESSION['user_rol'] ?? null
                ]
            ]);
        } catch (\Exception $e) {
            error_log("Error en UsuarioController@edit: " . $e->getMessage());
            return $this->errorResponse($response, "Error al cargar el formulario", 500);
        }
    }

    /**
     * Actualizar usuario
     */
    public function update(Request $request, Response $response, array $args): Response
    {
        try {
            $id = $args['id'];
            // Adaptar para aceptar JSON
            $contentType = $request->getHeaderLine('Content-Type');
            if (strpos($contentType, 'application/json') !== false) {
                $input = (string)$request->getBody();
                $data = json_decode($input, true);
            } else {
                $data = $request->getParsedBody();
            }
            
            // Verificar si el usuario existe
            $usuario = $this->usuarioModel->find($id);
            if (!$usuario) {
                return $this->jsonResponse($response, [
                    'success' => false,
                    'message' => 'Usuario no encontrado'
                ]);
            }

            // Validaciones
            $errors = $this->validateUsuario($data, $id);
            
            if (!empty($errors)) {
                return $this->jsonResponse($response, [
                    'success' => false,
                    'message' => 'Errores de validación',
                    'errors' => $errors
                ]);
            }

            // Verificar si el email ya existe (excluyendo el usuario actual)
            if ($this->usuarioModel->emailExists($data['email'], $id)) {
                return $this->jsonResponse($response, [
                    'success' => false,
                    'message' => 'El email ya está registrado'
                ]);
            }

            // Verificar si el RUT ya existe (excluyendo el usuario actual)
            if ($this->usuarioModel->rutExists($data['rut'], $id)) {
                return $this->jsonResponse($response, [
                    'success' => false,
                    'message' => 'El RUT ya está registrado'
                ]);
            }

            $success = $this->usuarioModel->update($id, $data);
            
            if ($success) {
                return $this->jsonResponse($response, [
                    'success' => true,
                    'message' => 'Usuario actualizado exitosamente',
                    'redirect' => $GLOBALS['twig']->getGlobals()['app_url'] . 'usuarios'
                ]);
            } else {
                return $this->jsonResponse($response, [
                    'success' => false,
                    'message' => 'Error al actualizar el usuario'
                ]);
            }
        } catch (\Exception $e) {
            error_log("Error en UsuarioController@update: " . $e->getMessage());
            return $this->jsonResponse($response, [
                'success' => false,
                'message' => 'Error al actualizar el usuario'
            ]);
        }
    }

    /**
     * Eliminar usuario
     */
    public function destroy(Request $request, Response $response, array $args): Response
    {
        try {
            $id = $args['id'];
            
            // Verificar si el usuario existe
            $usuario = $this->usuarioModel->find($id);
            if (!$usuario) {
                return $this->jsonResponse($response, [
                    'success' => false,
                    'message' => 'Usuario no encontrado'
                ]);
            }

            // No permitir eliminar el usuario actual
            if ($id == $_SESSION['user_id']) {
                return $this->jsonResponse($response, [
                    'success' => false,
                    'message' => 'No puedes eliminar tu propia cuenta'
                ]);
            }

            $success = $this->usuarioModel->delete($id);
            
            if ($success) {
                return $this->jsonResponse($response, [
                    'success' => true,
                    'message' => 'Usuario eliminado exitosamente'
                ]);
            } else {
                return $this->jsonResponse($response, [
                    'success' => false,
                    'message' => 'Error al eliminar el usuario'
                ]);
            }
        } catch (\Exception $e) {
            error_log("Error en UsuarioController@destroy: " . $e->getMessage());
            return $this->jsonResponse($response, [
                'success' => false,
                'message' => 'Error al eliminar el usuario'
            ]);
        }
    }

    /**
     * Cambiar estado del usuario
     */
    public function changeStatus(Request $request, Response $response, array $args): Response
    {
        try {
            $id = $args['id'];
            // Adaptar para aceptar JSON
            $contentType = $request->getHeaderLine('Content-Type');
            if (strpos($contentType, 'application/json') !== false) {
                $input = (string)$request->getBody();
                $data = json_decode($input, true);
            } else {
                $data = $request->getParsedBody();
            }
            $estado = $data['estado'] ?? null;
            
            if ($estado === null) {
                return $this->jsonResponse($response, [
                    'success' => false,
                    'message' => 'Estado no especificado'
                ]);
            }

            // Verificar si el usuario existe
            $usuario = $this->usuarioModel->find($id);
            if (!$usuario) {
                return $this->jsonResponse($response, [
                    'success' => false,
                    'message' => 'Usuario no encontrado'
                ]);
            }

            // No permitir desactivar el usuario actual
            if ($id == $_SESSION['user_id'] && $estado == 0) {
                return $this->jsonResponse($response, [
                    'success' => false,
                    'message' => 'No puedes desactivar tu propia cuenta'
                ]);
            }

            $success = $this->usuarioModel->changeStatus($id, $estado);
            
            if ($success) {
                $estadoText = $estado ? 'activado' : 'desactivado';
                return $this->jsonResponse($response, [
                    'success' => true,
                    'message' => "Usuario {$estadoText} exitosamente"
                ]);
            } else {
                return $this->jsonResponse($response, [
                    'success' => false,
                    'message' => 'Error al cambiar el estado del usuario'
                ]);
            }
        } catch (\Exception $e) {
            error_log("Error en UsuarioController@changeStatus: " . $e->getMessage());
            return $this->jsonResponse($response, [
                'success' => false,
                'message' => 'Error al cambiar el estado del usuario'
            ]);
        }
    }

    /**
     * Validar datos del usuario
     */
    private function validateUsuario($data, $excludeId = null)
    {
        $errors = [];

        // Validar RUT
        if (empty($data['rut'])) {
            $errors['rut'] = 'El RUT es obligatorio';
        } elseif (!preg_match('/^\d{1,8}-?[\dkK]$/', $data['rut'])) {
            $errors['rut'] = 'El RUT debe tener un formato válido (ej: 12345678-9 o 123456789)';
        }

        // Validar nombre
        if (empty($data['nombre'])) {
            $errors['nombre'] = 'El nombre es obligatorio';
        } elseif (strlen($data['nombre']) < 2) {
            $errors['nombre'] = 'El nombre debe tener al menos 2 caracteres';
        }

        // Validar email
        if (empty($data['email'])) {
            $errors['email'] = 'El email es obligatorio';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'El email no tiene un formato válido';
        }

        // Validar contraseña (solo para creación o si se proporciona en edición)
        if ($excludeId === null || !empty($data['password'])) {
            if (empty($data['password'])) {
                $errors['password'] = 'La contraseña es obligatoria';
            } elseif (strlen($data['password']) < 6) {
                $errors['password'] = 'La contraseña debe tener al menos 6 caracteres';
            }
        }

        // Validar rol
        if (empty($data['rol'])) {
            $errors['rol'] = 'El rol es obligatorio';
        } elseif (!in_array($data['rol'], ['admin', 'admin_bidoc', 'usuario'])) {
            $errors['rol'] = 'El rol seleccionado no es válido';
        }

        return $errors;
    }
} 