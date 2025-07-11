<?php

/**
 * MODELO DE GESTIÓN DE USUARIOS
 * 
 * Maneja las operaciones relacionadas con credenciales y autenticación
 * de usuarios. Incluye encriptación de contraseñas, validación de
 * credenciales y gestión de sesiones de usuario.
 * 
 * Funcionalidades incluidas:
 * - Validación de existencia de nombres de usuario
 * - Registro de usuarios con encriptación de contraseñas
 * - Autenticación con verificación de password hash
 * - Consultas JOIN para obtener datos completos del usuario
 * - Manejo seguro de contraseñas con password_hash/verify
 * 
 * Dependencias requeridas:
 * - Clase Model del core del sistema
 * - Conexión PDO activa para consultas
 * - Tablas 'usuarios' y 'personas' relacionadas
 * 
 */

require_once __DIR__ . '/../../../core/models/model.php';

class UsuarioModel extends Model
{
    public function __construct(PDO $db, $table = 'usuarios')
    {
        parent::__construct($db, $table);
    }

    public function existeUsuario($usuario)
    {
        $sql = 'SELECT id_usuario FROM ' . $this->table . ' WHERE usuario = :usuario';
        $stmt = $this->query($sql, [':usuario' => $usuario]);
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    public function registrarUsuario(array $usuarioData)
    {
        $sql = 'INSERT INTO ' . $this->table . ' (usuario, contrasenia, id_rol, id_persona)
                VALUES (:usuario, :contrasenia, :id_rol, :id_persona)';
        $usuarioData['contrasenia'] = password_hash($usuarioData['contrasenia'], PASSWORD_DEFAULT);
        $this->query($sql, $usuarioData);
    }

    public function login($usuario, $contrasenia)
    {
        $sql = 'SELECT u.id_usuario, u.contrasenia, u.id_rol, p.nombres, p.apellidos
                FROM ' . $this->table . ' u
                JOIN personas p ON u.id_persona = p.id_persona
                WHERE u.usuario = :usuario';
        $stmt = $this->query($sql, [':usuario' => $usuario]);
        $usuarioEncontrado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuarioEncontrado && password_verify($contrasenia, $usuarioEncontrado['contrasenia'])) {
            return [
                'status' => 'success',
                'usuario' => $usuarioEncontrado['id_usuario'],
                'nombre_completo' => $usuarioEncontrado['nombres'] . ' ' . $usuarioEncontrado['apellidos'],
                'rol' => $usuarioEncontrado['id_rol']
            ];
        } else {
            return ['status' => 'error', 'message' => 'Credenciales incorrectas.'];
        }
    }
}
?>
