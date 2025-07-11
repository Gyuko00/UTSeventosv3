<?php
/*
Controlador de Registro
Este controlador gestiona la lógica específica de registro de nuevos usuarios.
*/
require_once __DIR__ . '/../services/auth.service.php';

class RegisterController
{
    private $registerService;

    public function __construct(PDO $db)
    {
        $this->registerService = new AuthService($db);
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['status' => 'error', 'message' => 'Método no permitido.']);
            return;
        }

        header('Content-Type: application/json');

        $persona = [
            'tipo_documento' => $_POST['tipo_documento'] ?? null,
            'numero_documento' => $_POST['numero_documento'] ?? null,
            'nombres' => $_POST['nombres'] ?? null,
            'apellidos' => $_POST['apellidos'] ?? null,
            'telefono' => $_POST['telefono'] ?? null,
            'correo_personal' => $_POST['correo_personal'] ?? null,
            'departamento' => $_POST['departamento'] ?? null,
            'municipio' => $_POST['municipio'] ?? null,
            'direccion' => $_POST['direccion'] ?? null,
        ];

        $usuario = [
            'usuario' => $_POST['usuario'] ?? null,
            'contrasenia' => $_POST['contrasenia'] ?? null
        ];

        if (in_array(null, $persona, true) || in_array(null, $usuario, true)) {
            echo json_encode(['status' => 'error', 'message' => 'Todos los campos son obligatorios.']);
            return;
        }

        $response = $this->registerService->register($persona, $usuario);
        echo json_encode($response);
    }
}
?>
