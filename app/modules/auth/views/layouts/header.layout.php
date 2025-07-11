<!--
 * HEADER DE AUTENTICACIÓN
 * 
 * Componente de cabecera para páginas de login y registro del sistema
 * UTSeventos. Implementa diseño responsivo con menú hamburguesa para
 * móviles utilizando TailwindCSS y colores corporativos UTS.
 * 
 * Características:
 * - Navegación responsive con menú hamburguesa
 * - Colores corporativos UTS (#c9d230, #2e7d32, #a5c93a)
 * - Enlaces entre formularios de Login y Registro
 * - Integración con sistema de rutas (URL_PATH)
 *
-->
 
<?php require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 
            '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 
            'views' . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR . 'html.layout.php'; ?>

<header class="bg-[#c9d230] shadow-md">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
    <!-- Logo y navegación para móviles y escritorio -->
    <div class="flex justify-between items-center">
      <h1 class="text-2xl font-bold text-[#2e7d32]">UTSeventos</h1>
      <!-- Navegación para escritorio -->
      <nav class="hidden md:flex space-x-4">
        <a href="<?= URL_PATH ?>/auth/loginForm" class="text-[#2e7d32] font-medium hover:text-[#1b5e20]">Inicio de sesión</a>
        <a href="<?= URL_PATH ?>/auth/registerForm" class="text-[#2e7d32] font-medium hover:text-[#1b5e20]">Registrarse</a>
      </nav>
      <!-- Botón para menú móvil -->
      <button id="menu-toggle" class="md:hidden focus:outline-none">
        <svg class="h-6 w-6 fill-current text-[#2e7d32]" viewBox="0 0 24 24">
          <path d="M4 5h16a1 1 0 0 0 0-2H4a1 1 0 1 0 0 2zm0 6h16a1 1 0 0 0 0-2H4a1 1 0 1 0 0 2zm0 6h16a1 1 0 0 0 0-2H4a1 1 0 1 0 0 2z"></path>
        </svg>
      </button>
    </div>
    <!-- Menú móvil -->
    <div id="menu" class="hidden md:hidden mt-3 space-y-2">
      <a href="<?= URL_PATH ?>/auth/loginForm" class="block text-[#2e7d32] font-medium hover:bg-[#a5c93a] px-3 py-2 rounded-md">Inicio de sesión</a>
      <a href="<?= URL_PATH ?>/auth/registerForm" class="block text-[#2e7d32] font-medium hover:bg-[#a5c93a] px-3 py-2 rounded-md">Registrarse</a>
    </div>
  </div>
</header>


<script src="<?= URL_PATH ?>/assets/js/auth/header_menu.js"></script>
