<?php
/*
Controlador de Autenticación
Este controlador gestiona las operaciones de autenticación del sistema,
incluyendo el registro de nuevos invitados y el login de usuarios.
*/
require_once __DIR__ . '/../../../core/services/render.php';
require_once __DIR__ . '/login.controller.php';
require_once __DIR__ . '/register.controller.php';

class AuthController
{
    private $loginController;
    private $registerController;
    private $render;

    public function __construct(PDO $db)
    {
        $this->loginController = new LoginController($db);
        $this->registerController = new RegisterController($db);
        $this->render = new Render();
    }

    public function loginForm()
    {
        $this->render->render('auth/login', [], 'auth');
    }

    public function registerForm()
    {
        $this->render->render('auth/register', [], 'auth');
    }

    public function accesoDenegado()
    {
        $this->render->render('auth/acceso_denegado', [], 'auth');
    }

    public function register()
    {
        $this->registerController->register();
    }

    public function login()
    {
        $this->loginController->login();
    }

    public function logout()
    {
        $this->loginController->logout();
    }

}
?>
