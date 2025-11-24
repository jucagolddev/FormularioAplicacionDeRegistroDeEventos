# RA3 - AEE: Creación de un Formulario Completo para Registro de Eventos

Este proyecto consiste en el desarrollo de una aplicación web para la gestión de registros de asistentes a un evento. Se ha implementado un formulario completo utilizando **HTML5** y **Bootstrap 5** para el frontend, y **PHP** para el procesamiento de datos en el backend, cumpliendo con los requisitos del módulo de **Desarrollo Web en Entorno Cliente (DWEC)**.

## Descripción del Proyecto

[cite_start]El objetivo principal es crear una interfaz de usuario atractiva y funcional que permita la recopilación de datos complejos (texto, fechas, selecciones, archivos) y su posterior procesamiento en el servidor mediante el método POST[cite: 49, 50].

### Tecnologías Utilizadas
* **HTML5:** Estructura semántica del formulario.
* [cite_start]**CSS3 / Bootstrap 5:** Estilizado, diseño responsivo y feedback visual de validación[cite: 54].
* [cite_start]**PHP:** Procesamiento de datos del lado del servidor, manejo de arrays y ficheros[cite: 93].

## Funcionalidades Implementadas

El proyecto cubre los siguientes requisitos específicos:

### 1. Interfaz de Usuario (Frontend)
* [cite_start]**Campos variados:** Inclusión de inputs de texto, email, teléfono, fecha, radio buttons, select, checkboxes, range y textarea [cite: 56-79].
* [cite_start]**Subida de Archivos:** Campo `type="file"` habilitado con `enctype="multipart/form-data"`[cite: 80].
* **Diseño Responsivo:** Uso del sistema de rejilla (Grid) y componentes `Card` de Bootstrap.
* [cite_start]**Validación de Cliente:** Uso de atributos HTML5 (`required`) y clases de validación de Bootstrap (`needs-validation`) para feedback visual inmediato [cite: 87-90].

### 2. Lógica del Servidor (Backend)
* [cite_start]**Recepción de Datos:** Script `procesar_evento.php` que captura el envío mediante `$_POST`[cite: 82].
* [cite_start]**Manejo de Estructuras de Datos:** Uso de **Arrays** para procesar las selecciones múltiples (checkboxes de comida)[cite: 9, 19].
* [cite_start]**Validación de Servidor:** Verificación de campos vacíos, coincidencia de contraseñas y aceptación de términos antes de mostrar el recibo[cite: 94].
* **Seguridad Básica:** Saneamiento de entradas utilizando `htmlspecialchars` para prevenir XSS.

## 📂 Estructura del Proyecto

```text
/
├── index.html           # Formulario principal con estilos Bootstrap
└── procesar_evento.php  # Script de procesamiento y vista de confirmación
