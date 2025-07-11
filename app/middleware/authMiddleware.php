<?php

/**
 * MIDDLEWARE DE CONTROL DE ACCESO Y ROLES
 * 
 * Sistema de autenticación y autorización para el sistema de gestión de eventos.
 * Controla el acceso a diferentes rutas basándose en los roles de usuario asignados
 * y gestiona las redirecciones automáticas según el estado de autenticación.
 * 
 * Roles del sistema:
 * - 1: Administrador - Acceso completo al sistema
 * - 2: Ponente - Gestión de eventos y presentaciones
 * - 3: Invitado/Usuario normal - Acceso limitado a funcionalidades básicas
 * - 4: Control - Supervisión y monitoreo del sistema
 * 
 * Funcionalidades:
 * - Verificación de sesiones activas y roles de usuario
 * - Redirección automática a login o páginas de error
 * - Funciones helper para validación rápida de roles específicos
 * 
 */

session_start();

function verificarAccesoConRoles(
    array $rolesPermitidos = [], 
    string $redirectLogin = '/auth/loginForm',
    string $redirectDenied = '/auth/acceso_denegado'
) {
    if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['rol']) || empty($_SESSION['id_usuario'])) {
        header('Location: ' . $redirectLogin);
        exit;
    }
    
    if (empty($rolesPermitidos)) {
        return;
    }
    
    if (!in_array($_SESSION['rol'], $rolesPermitidos, true)) {
        header('Location: ' . $redirectDenied);
        exit;
    }
}

function soloAdmin() {
    verificarAccesoConRoles([1]);
}

function soloAdminYPonente() {
    verificarAccesoConRoles([1, 2]);
}

function soloControl() {
    verificarAccesoConRoles([4]);
}

function todosLosRoles() {
    verificarAccesoConRoles([1, 2, 3, 4]);
}
?>