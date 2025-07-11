<?php

/**
 * MOTOR DE RENDERIZADO DE VISTAS
 * 
 * Clase encargada de renderizar vistas del sistema organizadas por módulos,
 * implementando un sistema de layouts jerárquico para el sistema de gestión
 * de eventos. Facilita la separación de presentación y lógica de negocio.
 * 
 * Características:
 * - Organización modular de vistas por funcionalidad (usuarios, eventos, etc.)
 * - Sistema de layouts principal y secundarios para consistencia visual
 * - Paso seguro de datos desde controladores a vistas
 * - Soporte para rutas tipo 'modulo/vista' para mejor organización
 * - Escape automático de datos para prevenir XSS
 * - Soporte para vistas parciales y componentes reutilizables
 * - Manejo de errores 404 para vistas no encontradas
 * 
 * Uso:
 * View::render('usuarios/index', ['usuarios' => $listaUsuarios]);
 * View::render('eventos/detalle', ['evento' => $evento], 'admin');
 * 
 */

class Render
{

    public static function render(string $view, array $data = [], string $site = 'main'): void
    {
        $viewParts = explode('/', $view);

        if (count($viewParts) !== 2) {
            throw new Exception("Formato de vista inválido. Usa 'modulo/vista'");
        }

        [$module, $viewName] = $viewParts;

        $basePath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' 
        . DIRECTORY_SEPARATOR . 'modules';

        $viewPath = $basePath . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . 'views' . 
        DIRECTORY_SEPARATOR . $viewName . '.view.php';

        $sitePath = $basePath . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . 'views' .
         DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR . $site . '.site.php';

        if (!file_exists($viewPath)) {
            throw new Exception("Vista no encontrada: " . $viewPath);
        }

        if (!file_exists($sitePath)) {
            throw new Exception("Layout no encontrado: " . $sitePath);
        }

        extract($data);

        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        require $sitePath;
    }
}
?>
