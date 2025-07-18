<?php

namespace App\Models;

use PDO;

/**
 * Modelo simple para la tabla sedes usando PDO
 */
class SedeSimple
{
    protected $pdo;
    protected $table = 'sedes';

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Obtener todas las sedes
     */
    public function getAll($estado = null)
    {
        $sql = "SELECT * FROM {$this->table}";
        $params = [];

        if ($estado !== null) {
            $sql .= " WHERE estado = ?";
            $params[] = $estado;
        }

        $sql .= " ORDER BY nombre";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Obtener sede por ID
     */
    public function getById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Obtener sede por código
     */
    public function getByCodigo($codigo)
    {
        $sql = "SELECT * FROM {$this->table} WHERE codigo = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$codigo]);
        return $stmt->fetch();
    }
} 