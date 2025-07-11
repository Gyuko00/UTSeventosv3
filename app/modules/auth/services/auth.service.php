<?php
/*
Servicio de Autenticación
Este servicio maneja la lógica de negocio para la autenticación.
*/
require_once __DIR__ . '/../models/auth.model.php';

class AuthService
{
    private $authModel;

    public function __construct(PDO $db)
    {
        $this->authModel = new AuthModel($db);
    }

    public function register(array $personaData, array $userData)
    {
        return $this->authModel->registrar($personaData, $userData);
    }

    public function login($usuario, $contrasenia)
    {
        return $this->authModel->login($usuario, $contrasenia);
    }
}
?>
