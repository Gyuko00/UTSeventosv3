<?php

/**
 * MODELO DE DATOS PERSONALES
 * 
 * Maneja las operaciones CRUD relacionadas con la entidad personas
 * en la base de datos. Incluye validaciones y métodos específicos
 * para el registro y consulta de información personal.
 * 
 * Funcionalidades incluidas:
 * - Validación de existencia de documentos
 * - Registro de nuevas personas con datos completos
 * - Consultas optimizadas para verificaciones
 * - Herencia de funcionalidades base del core Model
 * 
 * Dependencias requeridas:
 * - Clase Model del core del sistema
 * - Conexión PDO activa para consultas
 * - Tabla 'personas' en la base de datos
 * 
 */

require_once __DIR__ . '/../../../core/models/model.php';

class PersonaModel extends Model
{
    public function __construct(PDO $db, $table = 'personas')
    {
        parent::__construct($db, $table);
    }

    public function existeDocumento($numeroDocumento)
    {
        $sql = 'SELECT id_persona FROM ' . $this->table . ' WHERE numero_documento = :numero_documento';
        $stmt = $this->query($sql, [':numero_documento' => $numeroDocumento]);
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    public function registrarPersona(array $personaData)
    {
        $sql = 'INSERT INTO ' . $this->table . ' (tipo_documento, numero_documento, nombres, apellidos, telefono, correo_personal, departamento, municipio, direccion)
                VALUES (:tipo_documento, :numero_documento, :nombres, :apellidos, :telefono, :correo_personal, :departamento, :municipio, :direccion)';
        $this->query($sql, $personaData);
        return $this->db->lastInsertId();
    }
}
?>
