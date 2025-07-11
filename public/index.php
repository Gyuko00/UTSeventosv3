<?php

/**
 * PUNTO DE ENTRADA PRINCIPAL DEL SISTEMA
 * 
 * Archivo bootstrap que inicializa la aplicación y maneja todas las
 * peticiones HTTP entrantes mediante el sistema de enrutamiento.
 * Este archivo actúa como el controlador frontal (front controller)
 * que centraliza el manejo de todas las rutas de la aplicación.
 * 
 * Funcionalidades principales:
 * - Carga automática de clases y dependencias del sistema
 * - Inicialización del router principal de la aplicación
 * - Procesamiento y distribución de peticiones HTTP
 * - Manejo centralizado de rutas y controladores
 * 
 */

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'autoload.php';

$router = new Router();
$router->run();

?>