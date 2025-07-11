<?php

/**
 * CONFIGURACIÓN DE BASE DE DATOS
 * 
 * Archivo de configuración que define los parámetros de conexión
 * a la base de datos MySQL del sistema de gestión de eventos.
 * Incluye credenciales, opciones de PDO y configuraciones de seguridad.
 * 
 * Configuraciones incluidas:
 * - Credenciales de conexión a MySQL
 * - Codificación UTF-8 para soporte de caracteres especiales
 * - Atributos PDO para manejo seguro de errores y consultas
 * - Configuración optimizada para prepared statements
 * 
 */

return [
    'host' => 'localhost',
    'db_name' => 'utseventos',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8mb4',
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ],
];
?>
