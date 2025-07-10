<?php

namespace App\Models;

use PDO;

/**
 * Modelo para la tabla unidades
 * 
 * Esta tabla centraliza la información de departamentos y facultades
 * permitiendo una estructura jerárquica flexible
 */
class Unidad
{
    protected $pdo;
    protected $table = 'unidades';

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Obtener todas las unidades
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
     * Obtener unidad por ID
     */
    public function getById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Obtener unidad por código
     */
    public function getByCodigo($codigo)
    {
        $sql = "SELECT * FROM {$this->table} WHERE codigo = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$codigo]);
        return $stmt->fetch();
    }

    /**
     * Obtener unidades por sede
     */
    public function getBySede($sedeId, $estado = null)
    {
        $sql = "SELECT * FROM {$this->table} WHERE sede_id = ?";
        $params = [$sedeId];

        if ($estado !== null) {
            $sql .= " AND estado = ?";
            $params[] = $estado;
        }

        $sql .= " ORDER BY nombre";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Obtener unidades padre (facultades)
     */
    public function getUnidadesPadre($sedeId = null)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id_unidad_padre IS NULL";
        $params = [];

        if ($sedeId !== null) {
            $sql .= " AND sede_id = ?";
            $params[] = $sedeId;
        }

        $sql .= " ORDER BY nombre";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Obtener unidades hijas de una unidad padre
     */
    public function getUnidadesHijas($codigoUnidadPadre)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id_unidad_padre = ? ORDER BY nombre";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$codigoUnidadPadre]);
        return $stmt->fetchAll();
    }

    /**
     * Obtener jerarquía completa de una unidad
     */
    public function getJerarquia($unidadId)
    {
        $sql = "
        WITH RECURSIVE jerarquia AS (
            SELECT id, codigo, nombre, id_unidad_padre, sede_id, 0 as nivel
            FROM {$this->table}
            WHERE id = ?
            
            UNION ALL
            
            SELECT u.id, u.codigo, u.nombre, u.id_unidad_padre, u.sede_id, j.nivel + 1
            FROM {$this->table} u
            INNER JOIN jerarquia j ON u.codigo = j.id_unidad_padre
        )
        SELECT * FROM jerarquia ORDER BY nivel
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$unidadId]);
        return $stmt->fetchAll();
    }

    /**
     * Crear nueva unidad
     */
    public function create($data)
    {
        $sql = "
        INSERT INTO {$this->table} (codigo, nombre, sede_id, id_unidad_padre, estado)
        VALUES (?, ?, ?, ?, ?)
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $data['codigo'],
            $data['nombre'],
            $data['sede_id'],
            $data['id_unidad_padre'] ?? null,
            $data['estado'] ?? 1
        ]);

        return $this->pdo->lastInsertId();
    }

    /**
     * Actualizar unidad
     */
    public function update($id, $data)
    {
        $sql = "
        UPDATE {$this->table} 
        SET codigo = ?, nombre = ?, sede_id = ?, id_unidad_padre = ?, estado = ?, fecha_actualizacion = CURRENT_TIMESTAMP
        WHERE id = ?
        ";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['codigo'],
            $data['nombre'],
            $data['sede_id'],
            $data['id_unidad_padre'] ?? null,
            $data['estado'] ?? 1,
            $id
        ]);
    }

    /**
     * Eliminar unidad
     */
    public function delete($id)
    {
        // Verificar si tiene unidades hijas
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE id_unidad_padre = (SELECT codigo FROM {$this->table} WHERE id = ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch();

        if ($result['count'] > 0) {
            throw new \Exception("No se puede eliminar la unidad porque tiene unidades hijas asociadas.");
        }

        // Verificar si está siendo utilizada en otras tablas
        $this->verificarUsoEnOtrasTablas($id);

        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    /**
     * Verificar si la unidad está siendo utilizada en otras tablas
     */
    private function verificarUsoEnOtrasTablas($unidadId)
    {
        // Verificar en asignaturas_departamentos
        $sql = "SELECT COUNT(*) as count FROM asignaturas_departamentos WHERE id_unidad = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$unidadId]);
        $result = $stmt->fetch();

        if ($result['count'] > 0) {
            throw new \Exception("No se puede eliminar la unidad porque está asociada a asignaturas.");
        }

        // Verificar en carreras_espejos
        $sql = "SELECT COUNT(*) as count FROM carreras_espejos WHERE id_unidad = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$unidadId]);
        $result = $stmt->fetch();

        if ($result['count'] > 0) {
            throw new \Exception("No se puede eliminar la unidad porque está asociada a carreras.");
        }
    }

    /**
     * Obtener unidades con información de sede
     */
    public function getAllWithSede($estado = null)
    {
        $sql = "
        SELECT u.*, s.nombre as nombre_sede 
        FROM {$this->table} u
        INNER JOIN sedes s ON u.sede_id = s.id
        ";

        $params = [];

        if ($estado !== null) {
            $sql .= " WHERE u.estado = ?";
            $params[] = $estado;
        }

        $sql .= " ORDER BY s.nombre, u.nombre";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Obtener unidades con información de unidad padre
     */
    public function getAllWithPadre($estado = null)
    {
        $sql = "
        SELECT u.*, up.nombre as nombre_unidad_padre, s.nombre as nombre_sede
        FROM {$this->table} u
        LEFT JOIN {$this->table} up ON u.id_unidad_padre = up.codigo
        INNER JOIN sedes s ON u.sede_id = s.id
        ";

        $params = [];

        if ($estado !== null) {
            $sql .= " WHERE u.estado = ?";
            $params[] = $estado;
        }

        $sql .= " ORDER BY s.nombre, up.nombre, u.nombre";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Buscar unidades por nombre
     */
    public function search($term, $estado = null)
    {
        $sql = "
        SELECT u.*, s.nombre as nombre_sede 
        FROM {$this->table} u
        INNER JOIN sedes s ON u.sede_id = s.id
        WHERE u.nombre LIKE ? OR u.codigo LIKE ?
        ";

        $params = ["%{$term}%", "%{$term}%"];

        if ($estado !== null) {
            $sql .= " AND u.estado = ?";
            $params[] = $estado;
        }

        $sql .= " ORDER BY u.nombre";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Obtener estadísticas de unidades
     */
    public function getStats()
    {
        $sql = "
        SELECT 
            COUNT(*) as total_unidades,
            COUNT(CASE WHEN id_unidad_padre IS NULL THEN 1 END) as unidades_padre,
            COUNT(CASE WHEN id_unidad_padre IS NOT NULL THEN 1 END) as unidades_hijas,
            COUNT(CASE WHEN estado = 1 THEN 1 END) as unidades_activas,
            COUNT(CASE WHEN estado = 0 THEN 1 END) as unidades_inactivas
        FROM {$this->table}
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetch();
    }
} 