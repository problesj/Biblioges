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
            // error_log("Error en UsuarioController@index: " . $e->getMessage());
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
            // error_log("Error en UsuarioController@create: " . $e->getMessage());
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
            // error_log("Error en UsuarioController@store: " . $e->getMessage());
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
            // error_log("Error en UsuarioController@show: " . $e->getMessage());
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
            // error_log("Error en UsuarioController@edit: " . $e->getMessage());
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

    /**
     * Mostrar el perfil del usuario autenticado
     */
    public function perfil($request, $response, $args = [])
    {
        try {
            $userId = $_SESSION['user_id'] ?? null;
            if (!$userId) {
                return $response->withHeader('Location', '/biblioges/login')->withStatus(302);
            }
            $usuario = $this->usuarioModel->find($userId);
            if (!$usuario) {
                return $response->withHeader('Location', '/biblioges/login')->withStatus(302);
            }
            return $this->render($response, 'perfil.twig', [
                'usuario' => $usuario,
                'app_url' => $GLOBALS['twig']->getGlobals()['app_url'] ?? '',
                'session' => $_SESSION,
                'current_page' => 'perfil'
            ]);
        } catch (\Exception $e) {
            error_log("Error en UsuarioController@perfil: " . $e->getMessage());
            return $response->withHeader('Location', '/biblioges/login')->withStatus(302);
        }
    }

    /**
     * Actualizar el perfil del usuario autenticado (API)
     */
    public function actualizarPerfil($request, $response, $args = [])
    {
        // Limpiar cualquier salida anterior
        while (ob_get_level()) {
            ob_end_clean();
        }
        
        try {
            error_log('=== INICIO actualizarPerfil ===');
            
            $userId = $_SESSION['user_id'] ?? null;
            if (!$userId) {
                error_log('Usuario no autenticado');
                $response->getBody()->write(json_encode(['success' => false, 'message' => 'No autenticado']));
                return $response->withStatus(401)->withHeader('Content-Type', 'application/json');
            }
            
            $body = $request->getBody()->getContents();
            error_log('Body recibido: ' . $body);
            
            $data = json_decode($body, true);
            if (!$data) {
                error_log('Error al decodificar JSON: ' . json_last_error_msg());
                $response->getBody()->write(json_encode(['success' => false, 'message' => 'Datos inválidos: ' . json_last_error_msg()]));
                return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
            }
            
            error_log('Datos decodificados: ' . print_r($data, true));
            
            $nombre = trim($data['nombre'] ?? '');
            $email = trim($data['email'] ?? '');
            
            if ($nombre === '' || $email === '') {
                error_log('Campos obligatorios vacíos');
                $response->getBody()->write(json_encode(['success' => false, 'message' => 'Nombre y correo electrónico son obligatorios']));
                return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
            }
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                error_log('Email inválido: ' . $email);
                $response->getBody()->write(json_encode(['success' => false, 'message' => 'El correo electrónico no es válido']));
                return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
            }
            
            // Verificar unicidad del email
            error_log('Verificando unicidad del email: ' . $email . ' para usuario: ' . $userId);
            if ($this->usuarioModel->emailExists($email, $userId)) {
                error_log('Email ya existe');
                $response->getBody()->write(json_encode(['success' => false, 'message' => 'El correo electrónico ya está en uso por otro usuario']));
                return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
            }
            
            // Actualizar usuario
            error_log('Actualizando usuario con ID: ' . $userId);
            $updateData = [
                'nombre' => $nombre,
                'email' => $email
            ];
            error_log('Datos a actualizar: ' . print_r($updateData, true));
            
            $success = $this->usuarioModel->update($userId, $updateData);
            if (!$success) {
                error_log('Error al actualizar usuario en la base de datos');
                $response->getBody()->write(json_encode(['success' => false, 'message' => 'Error al actualizar el usuario en la base de datos']));
                return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
            }
            
            // Actualizar sesión
            $_SESSION['user_nombre'] = $nombre;
            $_SESSION['user_email'] = $email;
            
            // Devolver datos actualizados
            $usuario = $this->usuarioModel->find($userId);
            error_log('Usuario actualizado: ' . print_r($usuario, true));
            
            $responseData = [
                'success' => true, 
                'message' => 'Perfil actualizado correctamente', 
                'data' => $usuario
            ];
            
            error_log('Respuesta a enviar: ' . json_encode($responseData));
            error_log('=== FIN actualizarPerfil ===');
            
            $response->getBody()->write(json_encode($responseData));
            return $response->withHeader('Content-Type', 'application/json');
                
        } catch (\Exception $e) {
            error_log('Error en actualizarPerfil: ' . $e->getMessage());
            error_log('Stack trace: ' . $e->getTraceAsString());
            $response->getBody()->write(json_encode(['success' => false, 'message' => 'Error interno al actualizar el perfil: ' . $e->getMessage()]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    /**
     * Actualizar la contraseña del usuario autenticado (API)
     */
    public function actualizarPassword($request, $response, $args = [])
    {
        try {
            $userId = $_SESSION['user_id'] ?? null;
            if (!$userId) {
                $response->getBody()->write(json_encode(['success' => false, 'message' => 'No autenticado']));
                return $response->withStatus(401)->withHeader('Content-Type', 'application/json');
            }
            $data = json_decode($request->getBody()->getContents(), true);
            if (!$data) {
                $response->getBody()->write(json_encode(['success' => false, 'message' => 'Datos inválidos']));
                return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
            }
            $passwordActual = $data['password_actual'] ?? '';
            $passwordNuevo = $data['password_nuevo'] ?? '';
            $passwordConfirmar = $data['password_confirmar'] ?? '';
            if ($passwordActual === '' || $passwordNuevo === '' || $passwordConfirmar === '') {
                $response->getBody()->write(json_encode(['success' => false, 'message' => 'Todos los campos de contraseña son obligatorios']));
                return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
            }
            if ($passwordNuevo !== $passwordConfirmar) {
                $response->getBody()->write(json_encode(['success' => false, 'message' => 'La nueva contraseña y su confirmación no coinciden']));
                return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
            }
            if (strlen($passwordNuevo) < 8) {
                $response->getBody()->write(json_encode(['success' => false, 'message' => 'La nueva contraseña debe tener al menos 8 caracteres']));
                return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
            }
            // Obtener usuario actual
            $usuario = $this->usuarioModel->find($userId);
            if (!$usuario) {
                $response->getBody()->write(json_encode(['success' => false, 'message' => 'Usuario no encontrado']));
                return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
            }
            // Verificar contraseña actual
            if (!password_verify($passwordActual, $usuario['password'])) {
                $response->getBody()->write(json_encode(['success' => false, 'message' => 'La contraseña actual es incorrecta']));
                return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
            }
            // Hashear nueva contraseña
            $passwordHash = password_hash($passwordNuevo, PASSWORD_DEFAULT);
            // Actualizar contraseña
            $this->usuarioModel->update($userId, [
                'password' => $passwordHash
            ]);
            $response->getBody()->write(json_encode(['success' => true, 'message' => 'Contraseña actualizada correctamente']));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (\Exception $e) {
            error_log('Error en actualizarPassword: ' . $e->getMessage());
            $response->getBody()->write(json_encode(['success' => false, 'message' => 'Error interno al actualizar la contraseña']));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }
} 