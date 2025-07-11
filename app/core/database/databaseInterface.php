<?php

/**
 * INTERFAZ DE CONEXIÓN A BASE DE DATOS
 * 
 * Define el contrato estándar que debe implementar cualquier clase encargada
 * de gestionar conexiones a la base de datos en el sistema de gestión de eventos.
 * Establece los métodos mínimos requeridos para garantizar la compatibilidad
 * y facilitar el intercambio de implementaciones de conexión.
 * 
 * Propósito:
 * - Estandarizar la interfaz de conexión a base de datos
 * - Facilitar la implementación de diferentes drivers de conexión
 * - Permitir el testing con mock objects
 * - Garantizar la consistencia en el manejo de conexiones
 * 
 * Implementaciones esperadas:
 * - MySQLConnection
 * - PostgreSQLConnection (futuro)
 * - TestConnection (para pruebas unitarias)
 * 
 */

interface DatabaseInterface
{
    public function getConnection(): ?PDO;
}
?>
