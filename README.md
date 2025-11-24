# 📝 Formulario de Inscripción - CódigoGenial

![Estado del Proyecto](https://img.shields.io/badge/Estado-Terminado-success)
![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?style=flat&logo=php&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5-7952B3?style=flat&logo=bootstrap&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=flat&logo=html5&logoColor=white)

Una aplicación web completa para el registro de asistentes a eventos. Incluye un formulario validado en el frontend y backend, interfaz en modo oscuro (Dark Mode) y generación dinámica de un "recibo digital" tras el registro exitoso.

## 🚀 Características

* **Diseño Responsivo y Moderno:** Interfaz adaptada a móviles y escritorio utilizando **Bootstrap 5** con un tema personalizado en modo oscuro ("Dark Mode").
* **Validación Dual:**
    * **Frontend:** Feedback visual inmediato usando las clases de validación de Bootstrap y JavaScript (coincidencia de contraseñas, campos requeridos).
    * **Backend (PHP):** Saneamiento de datos y validación estricta en el servidor para seguridad.
* **Persistencia de Datos (Sticky Form):** Si hay un error en el envío, el formulario recuerda los datos introducidos previamente para no tener que volver a escribirlos.
* **Generación de Recibo:** Tras un registro exitoso, la vista cambia automáticamente a una tarjeta de confirmación con el resumen de los datos.
* **Elementos Interactivos:** Sliders de calificación dinámicos y casillas de verificación inteligentes.

## 🛠️ Tecnologías Utilizadas

* **HTML5 / CSS3:** Estructura semántica y hoja de estilos personalizada (`estilos.css`).
* **Bootstrap 5.3:** Framework CSS para la maquetación y componentes (modales, alertas, inputs).
* **PHP:** Lógica del servidor para el procesamiento del formulario y renderizado condicional.
* **JavaScript:** Lógica del lado del cliente para validaciones en tiempo real.

## 📂 Estructura del Proyecto

```text
├── index.php          # Archivo principal (Lógica PHP + Vista Formulario/Recibo)
├── formulario.html    # Versión estática del formulario (sin lógica PHP)
├── estilos.css        # Hoja de estilos personalizada (Dark theme)
└── README.md          # Documentación del proyecto
