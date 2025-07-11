<?php
/*
Servicio de Usuario
Este servicio maneja la lógica de negocio para los usuarios.
*/
class UserService
{
    public function startSession(array $userData)
    {
        session_start();
        $_SESSION['id_usuario'] = $userData['usuario'];
        $_SESSION['nombre'] = $userData['nombre_completo'];
        $_SESSION['rol'] = $userData['rol'];
    }

    public function destroySession()
    {
        session_start();
        session_unset();
        session_destroy();
    }
}
?>
