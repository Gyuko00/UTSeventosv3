<?php

require_once __DIR__ . '/../services/auth.service.php';

class LoginController
{
    private $loginService;

    public function __construct(PDO $db)
    {
        $this->loginService = new AuthService($db);
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['status' => 'error', 'message' => 'Método no permitido.']);
            return;
        }

        $usuario = $_POST['usuario'] ?? null;
        $contrasenia = $_POST['contrasenia'] ?? null;

        if (!$usuario || !$contrasenia) {
            echo json_encode(['status' => 'error', 'message' => 'Credenciales incompletas.']);
            return;
        }

        $result = $this->loginService->login($usuario, $contrasenia);

        if ($result['status'] === 'success') {
            echo json_encode(['status' => 'success', 'message' => 'Inicio de sesión exitoso.', 'rol' => $result['rol']]);
        } else {
            echo json_encode($result);
        }
    }

    public function logout()
    {
        $this->loginService->logout();
        header('Location: ' . URL_PATH . '/auth/loginForm');
        exit;
    }
}








