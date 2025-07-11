<!--
/**
 * LAYOUT PRINCIPAL DE AUTENTICACIÓN
 * 
 * Layout centralizado para el módulo de autenticación que estructura
 * las páginas de login y registro. Proporciona un contenedor centrado
 * con diseño de tarjeta para los formularios de autenticación.
 * 
 * Características:
 * - Contenedor centrado vertical y horizontalmente
 * - Diseño de tarjeta con sombra y bordes redondeados
 * - Responsive con max-width adaptativo
 * - Integración con header y footer del sistema
 * - Renderizado dinámico de contenido mediante variable $content
 * 
 */
-->

<?php require __DIR__ . '/header.layout.php'; ?>

<main class="min-h-screen flex flex-col bg-gray-50">
  <div class="flex-grow flex items-center justify-center p-4">
    <div class="w-full max-w-3xl">
      <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="p-8">
          <?= $content ?? '' ?>
        </div>
      </div>
    </div>
  </div>
</main>

<?php require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . 
        DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'core' . 
        DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 
        'layouts' . DIRECTORY_SEPARATOR . 'footer.layout.php'; ?>
