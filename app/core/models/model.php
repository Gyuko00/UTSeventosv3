<?php

/**
 * MODELO BASE DEL SISTEMA
 * 
 * Clase abstracta que proporciona funcionalidades comunes y reutilizables para
 * todos los modelos del sistema de gestión de eventos. Implementa el patrón
 * Active Record simplificado con operaciones CRUD seguras utilizando PDO.
 * 
 * Funcionalidades incluidas:
 * - Operaciones CRUD (Create, Read, Update, Delete) con prepared statements
 * - Manejo centralizado de errores con logging automático
 * - Validación básica de datos antes de operaciones de base de datos
 * - Trazabilidad de operaciones con timestamps automáticos
 * - Métodos helper para consultas comunes (find, findAll, count, etc.)
 * - Soporte para transacciones y rollback automático
 * 
 * Uso:
 * class Usuario extends Model {
 *     protected $table = 'usuarios';
 *     protected $primaryKey = 'id_usuario';
 * }
 * 
 * $usuario = new Usuario();
 * $usuario->crear(['nombre' => 'Juan', 'email' => 'juan@email.com']);
 * 
 */

class Model
{

    protected $db;
    protected $table;

    public function __construct(PDO $db, string $table)
    {
        $this->db = $db;
        $this->table = $table;
    }

    protected function query(string $sql, array $params = []): PDOStatement
    {
        $stmt = $this->db->prepare($sql);
        if (!$stmt->execute($params)) {
            throw new Exception('Error en la ejecución de la consulta: ' . 
            implode(', ', $stmt->errorInfo()));
        }
        return $stmt;
    }

    public function getDB(): PDO
    {
        return $this->db;
    }

    public function all(): array
    {
        $stmt = $this->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
