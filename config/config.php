<?php

/**
 * CONFIGURACIÓN GENERAL DE LA APLICACIÓN
 * 
 * Archivo de configuración principal del sistema de gestión de eventos.
 * Define constantes globales, configuraciones de entorno y parámetros
 * básicos necesarios para el funcionamiento de la aplicación.
 * 
 * Configuraciones incluidas:
 * - URL base dinámica según el entorno (HTTP/HTTPS)
 * - Nombre y entorno de la aplicación
 * - Configuración de zona horaria (Colombia)
 * - Parámetros de seguridad básicos
 * 
 */

$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
$host = $_SERVER['HTTP_HOST'];
$folderPath = dirname($_SERVER['SCRIPT_NAME']);

define('URL_PATH', $protocol . $host . $folderPath);
define('APP_NAME', 'UTSeventos');
define('APP_ENV', 'development');
define('SECURE', true);
date_default_timezone_set('America/Bogota');
?>
