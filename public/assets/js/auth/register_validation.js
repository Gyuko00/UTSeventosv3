/**
 * SCRIPT DE VALIDACIÓN Y REGISTRO DE USUARIOS
 * 
 * Controla el formulario de registro con validaciones del lado del cliente
 * para todos los campos requeridos. Incluye validación de formatos,
 * detección de emojis y envío asíncrono de datos.
 * 
 * Funcionalidades incluidas:
 * - Validación de documentos, nombres, teléfonos y correos
 * - Validación de credenciales con políticas de seguridad
 * - Detección y prevención de emojis en campos
 * - Envío asíncrono con manejo de errores
 * - Integración con SweetAlert2 para notificaciones
 * 
 * Elementos requeridos:
 * - Formulario con ID 'registroForm'
 * - Campos con atributos name correspondientes
 * - Librería SweetAlert2 para alertas
 * 
 */

document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("registroForm");
  if (!form) return;

  const hasEmoji = (text) =>
    /[\p{Emoji_Presentation}\p{Extended_Pictographic}]/gu.test(text);

  const getValue = (name) =>
    form.querySelector(`[name="${name}"]`)?.value.trim() || "";

  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    const errors = [];

    const validations = [
      {
        field: "tipo_documento",
        value: getValue("tipo_documento"),
        validation: (value) => !value,
        error: "Debe seleccionar un tipo de documento.",
      },
      {
        field: "numero_documento",
        value: getValue("numero_documento"),
        validation: (value) => !/^\d{5,10}$/.test(value),
        error:
          "El número de documento debe contener solo números, entre 5 y 10 dígitos. No se permiten letras, espacios ni emojis.",
      },
      {
        field: "nombres",
        value: getValue("nombres"),
        validation: (value) => !/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,50}$/.test(value),
        error:
          "Los nombres deben tener entre 2 y 50 letras. No se permiten emojis ni caracteres especiales, tampoco debe tener espacios en blanco al inicio o al final.",
      },
      {
        field: "apellidos",
        value: getValue("apellidos"),
        validation: (value) => !/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,50}$/.test(value),
        error:
          "Los apellidos deben tener entre 2 y 50 letras. No se permiten emojis ni caracteres especiales, tampoco debe tener espacios en blanco al inicio o al final.",
      },
      {
        field: "telefono",
        value: getValue("telefono").replace(/\D/g, ""),
        validation: (value) => !/^\d{7,13}$/.test(value),
        error: "El teléfono debe contener solo números (entre 7 y 13 dígitos).",
      },
      {
        field: "correo_personal",
        value: getValue("correo_personal"),
        validation: (value) =>
          !/^([\w.%+-]+)@([\w-]+\.)+[\w]{2,}$/i.test(value),
        error: "Ingrese un correo electrónico válido.",
      },
      {
        field: "departamento",
        value: getValue("departamento"),
        validation: (value) => !value,
        error: "Debe seleccionar un departamento.",
      },
      {
        field: "municipio",
        value: getValue("municipio"),
        validation: (value) => !value,
        error: "Debe seleccionar un municipio.",
      },
      {
        field: "direccion",
        value: getValue("direccion"),
        validation: (value) => value.length < 5 || value.length > 100,
        error: "La dirección debe tener entre 5 y 100 caracteres, sin emojis.",
      },
      {
        field: "usuario",
        value: getValue("usuario"),
        validation: (value) => !/^[a-zA-Z0-9_.-]{4,20}$/.test(value),
        error:
          "El nombre de usuario debe tener entre 4 y 20 caracteres. Solo se permiten letras, números, guiones, puntos y guiones bajos.",
      },
      {
        field: "contrasenia",
        value: getValue("contrasenia"),
        validation: (value) =>
          !/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,}$/.test(value),
        error:
          "La contraseña debe tener mínimo 8 caracteres, incluyendo al menos una letra mayúscula, una minúscula y un número. No se permiten emojis.",
      },
    ];

    validations.forEach(({ value, validation, error }) => {
      if (validation(value) || hasEmoji(value)) {
        errors.push(error);
      }
    });

    if (errors.length > 0) {
      return Swal.fire({
        icon: "error",
        title: "Errores en el formulario",
        html: `<ul style='text-align:left'>${errors
          .map((e) => `<li>${e}</li>`)
          .join("")}</ul>`,
        confirmButtonColor: "#d33",
      });
    }

    const formData = new FormData(form);
    try {
      const response = await fetch(form.action, {
        method: "POST",
        body: formData,
      });

      const text = await response.text();
      let result;

      try {
        result = JSON.parse(text);
      } catch {
        throw new Error("Respuesta no es JSON válida");
      }

      if (result.status === "success") {
        await Swal.fire({
          icon: "success",
          title: "Registro exitoso",
          text: result.message,
          confirmButtonColor: "#3085d6",
        });
        const loginUrl = form.dataset.loginUrl;
        window.location.href = loginUrl;
      } else {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: result.message || "No se pudo registrar.",
          confirmButtonColor: "#d33",
        });
      }
    } catch (err) {
      console.error("Error en fetch:", err);
      Swal.fire({
        icon: "error",
        title: "Error de red",
        text: "No se pudo conectar con el servidor o la respuesta no fue válida.",
        confirmButtonColor: "#d33",
      });
    }
  });
});
