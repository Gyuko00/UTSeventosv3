<?php

/**
 * MODELO DE AUTENTICACIÓN PARA SISTEMA DE EVENTOS
 * 
 * Maneja las operaciones de registro y autenticación de usuarios en el sistema.
 * Actúa como orquestador entre los modelos de Persona y Usuario, garantizando
 * la integridad de los datos mediante transacciones de base de datos.
 * 
 * Funcionalidades incluidas:
 * - Registro de usuarios con validación de duplicados
 * - Autenticación de usuarios con credenciales
 * - Manejo de transacciones para operaciones complejas
 * - Validación de documentos y nombres de usuario únicos
 * - Asignación automática de roles por defecto
 * 
 * Dependencias requeridas:
 * - PersonaModel para gestión de datos personales
 * - UsuarioModel para gestión de credenciales
 * - Conexión PDO activa para transacciones
 * 
 */

require_once __DIR__ . '/persona.model.php';
require_once __DIR__ . '/usuario.model.php';

class AuthModel
{
    private $personaModel;
    private $usuarioModel;

    public function __construct(PDO $db)
    {
        $this->personaModel = new PersonaModel($db);
        $this->usuarioModel = new UsuarioModel($db);
    }

    public function registrar(array $personaData, array $usuarioData)
    {
        try {
            $this->personaModel->getDB()->beginTransaction();

            if ($this->personaModel->existeDocumento($personaData['numero_documento'])) {
                throw new Exception('El número de documento ya está registrado.');
            }

            if ($this->usuarioModel->existeUsuario($usuarioData['usuario'])) {
                throw new Exception('El nombre de usuario ya está en uso.');
            }

            $idPersona = $this->personaModel->registrarPersona($personaData);
            $usuarioData['id_persona'] = $idPersona;
            $usuarioData['id_rol'] = 3;

            $this->usuarioModel->registrarUsuario($usuarioData);

            $this->personaModel->getDB()->commit();

            return ['status' => 'success', 'message' => 'Registro exitoso.'];
        } catch (Exception $e) {
            $this->personaModel->getDB()->rollBack();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function login($usuario, $contrasenia)
    {
        return $this->usuarioModel->login($usuario, $contrasenia);
    }
}
?>
