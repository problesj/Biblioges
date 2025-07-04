<?php

namespace src\Models;

use PDO;
use App\Core\Config;

class Usuario
{
    protected $pdo;

    public function __construct()
    {
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
        } catch (\PDOException $e) {
            error_log("Error de conexión a la base de datos: " . $e->getMessage());
            throw $e;
        }
    }

    public function findByEmail($email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function findByRut($rut)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE rut = :rut");
        $stmt->execute(['rut' => $rut]);
        return $stmt->fetch();
    }

    public function getAll($page = 1, $limit = 10, $search = '', $rol = '', $estado = '')
    {
        $offset = ($page - 1) * $limit;
        
        $whereConditions = [];
        $params = [];
        
        if (!empty($search)) {
            $whereConditions[] = "(nombre LIKE :search OR email LIKE :search OR rut LIKE :search)";
            $params['search'] = "%{$search}%";
        }
        
        if (!empty($rol)) {
            $whereConditions[] = "rol = :rol";
            $params['rol'] = $rol;
        }
        
        if ($estado !== '') {
            $whereConditions[] = "estado = :estado";
            $params['estado'] = $estado;
        }
        
        $whereClause = !empty($whereConditions) ? 'WHERE ' . implode(' AND ', $whereConditions) : '';
        
        // Consulta para obtener el total de registros
        $countSql = "SELECT COUNT(*) as total FROM usuarios {$whereClause}";
        $countStmt = $this->pdo->prepare($countSql);
        $countStmt->execute($params);
        $total = $countStmt->fetch()['total'];
        
        // Consulta principal
        $sql = "SELECT * FROM usuarios {$whereClause} ORDER BY nombre ASC LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        
        foreach ($params as $key => $value) {
            $stmt->bindValue(":{$key}", $value);
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return [
            'data' => $stmt->fetchAll(),
            'total' => $total,
            'pages' => ceil($total / $limit),
            'current_page' => $page
        ];
    }

    public function create($data)
    {
        $sql = "INSERT INTO usuarios (rut, nombre, email, password, rol, estado) 
                VALUES (:rut, :nombre, :email, :password, :rol, :estado)";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'rut' => $data['rut'],
            'nombre' => $data['nombre'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'rol' => $data['rol'],
            'estado' => $data['estado'] ?? 1
        ]);
        
        return $this->pdo->lastInsertId();
    }

    public function update($id, $data)
    {
        $updateFields = [];
        $params = ['id' => $id];
        
        foreach (['rut', 'nombre', 'email', 'rol', 'estado'] as $field) {
            if (isset($data[$field])) {
                $updateFields[] = "{$field} = :{$field}";
                $params[$field] = $data[$field];
            }
        }
        
        // Si se proporciona una nueva contraseña, actualizarla
        if (!empty($data['password'])) {
            $updateFields[] = "password = :password";
            $params['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        
        if (empty($updateFields)) {
            return false;
        }
        
        $sql = "UPDATE usuarios SET " . implode(', ', $updateFields) . " WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        
        return $stmt->execute($params);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function changeStatus($id, $estado)
    {
        $sql = "UPDATE usuarios SET estado = :estado WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id, 'estado' => $estado]);
    }

    public function emailExists($email, $excludeId = null)
    {
        $sql = "SELECT COUNT(*) as count FROM usuarios WHERE email = :email";
        $params = ['email' => $email];
        
        if ($excludeId) {
            $sql .= " AND id != :exclude_id";
            $params['exclude_id'] = $excludeId;
        }
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch()['count'] > 0;
    }

    public function rutExists($rut, $excludeId = null)
    {
        $sql = "SELECT COUNT(*) as count FROM usuarios WHERE rut = :rut";
        $params = ['rut' => $rut];
        
        if ($excludeId) {
            $sql .= " AND id != :exclude_id";
            $params['exclude_id'] = $excludeId;
        }
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch()['count'] > 0;
    }

    public function getRoles()
    {
        return [
            'admin' => 'Administrador',
            'admin_bidoc' => 'Administrador Biblioteca',
            'usuario' => 'Usuario'
        ];
    }

    public function getEstados()
    {
        return [
            1 => 'Activo',
            0 => 'Inactivo'
        ];
    }
} 