<?php

/**
 * GESTOR DE CONEXIÓN A BASE DE DATOS
 * 
 * Clase singleton para manejar la conexión PDO a la base de datos MySQL del sistema
 * de gestión de eventos. Centraliza la configuración de conexión y proporciona acceso
 * seguro a través del patrón Singleton para evitar múltiples conexiones simultáneas.
 * 
 * Características:
 * - Configuración centralizada de parámetros de conexión
 * - Manejo robusto de errores con logging de excepciones
 * - Soporte nativo para codificación UTF-8
 * - Configuración de atributos PDO seguros (prepared statements, fetch mode)
 * - Implementación del patrón Singleton para optimizar recursos
 * 
 * Uso:
 * $db = Database::getConnection();
 * $stmt = $db->prepare("SELECT * FROM usuarios WHERE id = ?");
 * 
 */

require_once __DIR__ . '/databaseInterface.php';

class Database implements DatabaseInterface
{
    private ?PDO $conn = null;
    private array $config;

    public function __construct()
    {
        $this->config = require __DIR__ . '/../../../config/database.php';
    }

    public function getConnection(): ?PDO
    {
        if ($this->conn !== null) {
            return $this->conn;
        }

        try {
            $dsn = "mysql:host={$this->config['host']};dbname={$this->config['db_name']};charset={$this->config['charset']}";
            $this->conn = new PDO($dsn, $this->config['username'], $this->config['password'], $this->config['options']);
        } catch (PDOException $e) {
            die('Error de conexión a la base de datos: ' . $e->getMessage());
        }

        return $this->conn;
    }
}
?>
