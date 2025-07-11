<?php

/**
 * ROUTER PRINCIPAL DEL SISTEMA
 * 
 * Maneja el enrutamiento de peticiones HTTP en el sistema de gestión de eventos.
 * Interpreta URLs con formato /modulo/metodo/parametros y ejecuta el controlador
 * correspondiente. Implementa un sistema de enrutamiento simple pero efectivo
 * para organizar la aplicación por módulos.
 * 
 * Funcionamiento:
 * - Parsea la URL para extraer módulo, método y parámetros
 * - Carga automáticamente el controlador del módulo solicitado
 * - Ejecuta el método especificado pasando los parámetros
 * - Maneja errores 404 para rutas no encontradas
 * 
 * Ejemplo de uso:
 * URL: /usuarios/crear/123 → UsuariosController::crear(123)
 * URL: /eventos/detalle/45 → EventosController::detalle(45)
 *
 */

class Router
{
    private $module = 'auth';
    private $controller = 'AuthController';
    private $method = 'loginForm';
    private $params = [];

    public function __construct()
    {
        $this->parseUrl();
    }

    private function parseUrl()
    {
        $basePath = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
        $requestUri = str_replace($basePath, '', $_SERVER['REQUEST_URI']);
        $uri = explode('?', trim($requestUri, '/'))[0];
        $segments = explode('/', $uri);

        if (!empty($segments[0])) {
            $this->module = strtolower($segments[0]);
            array_shift($segments);
        }

        $this->controller = ucfirst($this->module) . 'Controller';

        if (!empty($segments[0])) {
            $this->method = $segments[0];
            array_shift($segments);
        }

        $this->params = $segments;
    }

    public function run()
    {
        $controllerPath = __DIR__ . "/../modules/{$this->module}/controllers/{$this->controller}.php";

        if (!file_exists($controllerPath)) {
            $this->redirectToError("Controlador no encontrado: {$this->controller} en módulo {$this->module}");
        }

        require_once $controllerPath;

        if (!class_exists($this->controller)) {
            $this->redirectToError("Clase no encontrada: {$this->controller}");
        }

        $db = new Database();
        $controllerInstance = new $this->controller($db->getConnection());

        if (!method_exists($controllerInstance, $this->method)) {
            $this->redirectToError("Método no encontrado: {$this->method}");
        }

        call_user_func_array([$controllerInstance, $this->method], $this->params);
    }

    private function redirectToError($message)
    {
        header('HTTP/1.0 404 Not Found');
        echo "<h2>Error de ruta</h2><p>{$message}</p>";
        exit();
    }
}
?>
