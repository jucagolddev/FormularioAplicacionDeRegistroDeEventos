<?php
// Configuración de errores
ini_set('display_errors', 1);
error_reporting(E_ALL);

// =========================================================================
// 1. LÓGICA PHP DE VALIDACIÓN Y PROCESAMIENTO
// =========================================================================

// --- SOLUCIÓN: ASEGURAMOS LA DEFINICIÓN DE LAS VARIABLES ---
$errores = [];
$registroExitoso = false; // Siempre se define aquí.
// -----------------------------------------------------------

// Comprobamos si el formulario ha sido enviado (la variable de un campo existe)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Función de validación de existencia
    function validarCampo($campo, $nombre) {
        // Verifica si el campo no existe, es un array vacío o una cadena vacía/solo espacios
        if (!isset($_POST[$campo]) || (is_array($_POST[$campo]) && empty($_POST[$campo])) || (is_string($_POST[$campo]) && trim($_POST[$campo]) === '')) {
            return "El campo '{$nombre}' es obligatorio.";
        }
        return null;
    }

    // Validar campos obligatorios
    $campos_obligatorios = [
        'nombreCompleto' => 'Nombre completo',
        'email' => 'Correo electrónico',
        'fechaNacimiento' => 'Fecha de nacimiento',
        'fechaEvento' => 'Fecha del evento',
        'tipoEntrada' => 'Tipo de entrada',
        'usuario' => 'Nombre de usuario',
        'password' => 'Contraseña',
        'confirmPassword' => 'Confirmación de contraseña',
        'terminos' => 'Términos y condiciones'
    ];

    foreach ($campos_obligatorios as $campo => $nombre) {
        if ($error = validarCampo($campo, $nombre)) {
            $errores[] = $error;
        }
    }

    // Validación de coincidencia de contraseñas
    if (empty($errores)) {
        if (($_POST['password'] ?? '') !== ($_POST['confirmPassword'] ?? '')) {
            $errores[] = "Las contraseñas no coinciden.";
        }
    }

    // Si no hay errores, marcamos el registro como exitoso
    if (empty($errores)) {
        $registroExitoso = true;
        // NOTA: Aquí iría la lógica real de guardar datos en base de datos,
        // enviar emails, etc.
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $registroExitoso ? '✅ Registro Exitoso' : 'Inscripción al Evento: CódigoGenial'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        /* Nuevo esquema de color para el recibo y errores */
        body {
            background-color: #121212;
            color: #f8f9fa; /* Texto principal Blanco */
            padding-top: 50px;
            padding-bottom: 50px;
        }
        .form-container, .recibo-container {
            max-width: 800px;
            margin: auto;
            background-color: #212529; /* Contenedor Gris Oscuro/Negro Suave */
            padding: 40px;
            border-radius: 18px; 
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5); 
        }
        .section-heading {
            border-left: 5px solid #dc3545;
            padding-left: 10px;
            padding-bottom: 5px;
            margin-top: 35px;
            margin-bottom: 25px;
            color: #dc3545;
            font-weight: 700;
            font-size: 1.5rem;
        }
        .recibo-header {
            color: #dc3545;
            font-weight: 700;
            margin-bottom: 25px;
        }
        /* Estilos del Recibo (Tarjeta) */
        .recibo-card {
            border: 1px solid #dc3545; 
            background-color: #343a40; /* Fondo más oscuro para la tarjeta */
            color: #f8f9fa; /* Texto de la tarjeta blanco */
        }
        .recibo-card .card-header {
            background-color: #dc3545 !important; /* Cabecera de la tarjeta en Rojo */
            color: white; 
        }
        .recibo-item {
            padding: 8px 0;
            border-bottom: 1px dashed #495057; /* Líneas divisorias grises oscuras */
            display: flex;
            justify-content: space-between;
        }
        .recibo-item-label {
            font-weight: 600;
            color: #adb5bd; /* Gris claro para las etiquetas */
        }
        .recibo-item-value {
            color: #f8f9fa; /* Blanco para los valores */
        }
        /* Cambio clave para el texto "oculto" */
        .recibo-card .text-muted {
            color: #f8f9fa !important; /* Forzar blanco suave para el texto muted dentro de la tarjeta */
            font-weight: bold; /* Hacerlo negrita para más visibilidad */
            margin-top: 15px; /* Pequeño margen para separarlo del contenido de la tarjeta */
        }
        /* El "Recibirás un correo..." también es text-muted, lo haremos más claro */
        .recibo-container > .text-muted {
            color: #adb5bd !important; /* Gris claro para el texto "Recibirás un correo..." */
        }

        /* Botones y acentos */
        .btn-primary {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-primary:hover {
            background-color: #c82333;
            border-color: #c82333;
        }
        /* Ajuste de color para inputs y select en caso de que se muestre el formulario */
        .form-control, .form-select {
            background-color: #343a40;
            color: #f8f9fa;
            border-color: #495057;
        }
        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.5);
            border-color: #dc3545;
        }
        .form-label {
            color: #f8f9fa;
        }
        .text-primary {
            color: #dc3545 !important;
        }
        .text-secondary {
            color: #adb5bd !important;
        }
    </style>
</head>
<body>

    <div class="container">

        <?php if ($registroExitoso): 
            // 2. Extracción de datos para el recibo (con sanitización básica)
            $nombre = htmlspecialchars($_POST['nombreCompleto'] ?? 'Asistente');
            $email = htmlspecialchars($_POST['email'] ?? 'N/A');
            $fechaNac = htmlspecialchars($_POST['fechaNacimiento'] ?? 'N/A');
            $tipoEntrada = htmlspecialchars($_POST['tipoEntrada'] ?? 'N/A');
            $fechaEvento = htmlspecialchars($_POST['fechaEvento'] ?? 'N/A');
            $comidas = implode(', ', array_map('htmlspecialchars', $_POST['comida'] ?? ['Sin preferencias']));
            $usuario = htmlspecialchars($_POST['usuario'] ?? 'N/A');
        ?>
            <div class="recibo-container text-center">
                <h1 class="recibo-header"><i class="bi bi-check-circle-fill"></i>¡Registro Completado con Éxito!</h1>
                <p class="lead mb-4">¡Gracias por registrarte, <?php echo $nombre; ?>!</p>
                <p>Tu inscripción ha sido procesada correctamente. A continuación, un resumen de tus datos de registro.</p>

                <div class="card recibo-card mt-5">
                    <div class="card-header">
                        <h4 class="mb-0">Detalles de la Inscripción</h4>
                    </div>
                    <div class="card-body text-start">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="recibo-item-label">Nombre Completo:</p>
                                <p class="recibo-item-value"><?php echo $nombre; ?></p>
                            </div>
                            <div class="col-md-6">
                                <p class="recibo-item-label">Correo Electrónico:</p>
                                <p class="recibo-item-value"><?php echo $email; ?></p>
                            </div>
                        </div>
                        <hr style="border-top: 1px dashed #495057;">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="recibo-item-label">Evento:</p>
                                <p class="recibo-item-value">CódigoGenial 2024</p>
                            </div>
                            <div class="col-md-6">
                                <p class="recibo-item-label">Fecha de Evento:</p>
                                <p class="recibo-item-value"><?php echo $fechaEvento; ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="recibo-item-label">Tipo de Entrada:</p>
                                <p class="recibo-item-value text-danger fw-bold"><?php echo $tipoEntrada; ?></p>
                            </div>
                            <div class="col-md-6">
                                <p class="recibo-item-label">Preferencias de Comida:</p>
                                <p class="recibo-item-value"><?php echo $comidas; ?></p>
                            </div>
                        </div>
                        <hr style="border-top: 1px dashed #495057;">
                        <div class="text-center mt-3">
                            <p class="small text-muted">Tu nombre de usuario es: <?php echo $usuario; ?></p>
                        </div>
                    </div>
                </div>

                <p class="text-muted small mt-4">Recibirás un correo de confirmación a <?php echo $email; ?> pronto.</p>
                <a href="formulario.html" class="btn btn-primary mt-3">Volver a registrar otro asistente</a>
            </div>

        <?php else: // Muestra el formulario o los errores ?>
            
            <div class="form-container">
                <h1 class="text-center mb-3 text-primary">Formulario de Inscripción</h1>
                <p class="text-center mb-5 text-secondary">Completa tus datos para asegurar tu plaza.</p>

                <?php if (!empty($errores)): // Mostrar errores si la validación falló ?>
                    <div class="alert alert-danger" role="alert">
                        <strong>Se encontraron errores:</strong>
                        <ul>
                            <?php foreach ($errores as $error): ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    <h2 class="section-heading">1. Información Personal</h2>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nombreCompleto" class="form-label">Nombre completo (*)</label>
                            <input type="text" class="form-control" id="nombreCompleto" name="nombreCompleto" placeholder="Tu Nombre" value="<?php echo htmlspecialchars($_POST['nombreCompleto'] ?? ''); ?>" required>
                            <div class="invalid-feedback">Por favor, introduce tu nombre completo.</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Correo electrónico (*)</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="ejemplo@dominio.com" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
                            <div class="invalid-feedback">Introduce un correo electrónico válido.</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="telefono" class="form-label">Número de teléfono</label>
                            <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="(+34) 600-000-000" value="<?php echo htmlspecialchars($_POST['telefono'] ?? ''); ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="fechaNacimiento" class="form-label">Fecha de nacimiento (*)</label>
                            <input type="date" class="form-control" id="fechaNacimiento" name="fechaNacimiento" value="<?php echo htmlspecialchars($_POST['fechaNacimiento'] ?? ''); ?>" required>
                            <div class="invalid-feedback">Este campo es obligatorio.</div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label d-block">Género</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="genero" id="generoM" value="Masculino" <?php echo (($_POST['genero'] ?? 'Masculino') === 'Masculino') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="generoM">Masculino</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="genero" id="generoF" value="Femenino" <?php echo (($_POST['genero'] ?? '') === 'Femenino') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="generoF">Femenino</label>
                            </div>
                        </div>
                    </div>

                    <h2 class="section-heading">2. Información del Evento</h2>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="fechaEvento" class="form-label">Fecha del evento (*)</label>
                            <input type="date" class="form-control" id="fechaEvento" name="fechaEvento" value="<?php echo htmlspecialchars($_POST['fechaEvento'] ?? ''); ?>" required>
                            <div class="invalid-feedback">Este campo es obligatorio.</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tipoEntrada" class="form-label">Tipo de entrada (*)</label>
                            <select class="form-select" id="tipoEntrada" name="tipoEntrada" required>
                                <option value="" <?php echo (!isset($_POST['tipoEntrada']) || $_POST['tipoEntrada'] === '') ? 'selected' : ''; ?>>Selecciona una opción</option>
                                <option value="General" <?php echo (($_POST['tipoEntrada'] ?? '') === 'General') ? 'selected' : ''; ?>>General</option>
                                <option value="VIP" <?php echo (($_POST['tipoEntrada'] ?? '') === 'VIP') ? 'selected' : ''; ?>>VIP (Acceso especial)</option>
                            <option value="Estudiante" <?php echo (($_POST['tipoEntrada'] ?? '') === 'Estudiante') ? 'selected' : ''; ?>>Estudiante (Requiere ID)</option>
                            </select>
                            <div class="invalid-feedback">Por favor, selecciona un tipo de entrada.</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label d-block">Preferencias de comida (*)</label>
                        <?php $comidas_seleccionadas = $_POST['comida'] ?? ['Sin preferencias']; ?>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="comida[]" id="comidaVeggie" value="Vegetariano" <?php echo in_array('Vegetariano', $comidas_seleccionadas) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="comidaVeggie">Vegetariano</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="comida[]" id="comidaVegan" value="Vegano" <?php echo in_array('Vegano', $comidas_seleccionadas) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="comidaVegan">Vegano</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="comida[]" id="comidaGluten" value="Sin gluten" <?php echo in_array('Sin gluten', $comidas_seleccionadas) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="comidaGluten">Sin gluten</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="comida[]" id="comidaNoPref" value="Sin preferencias" <?php echo in_array('Sin preferencias', $comidas_seleccionadas) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="comidaNoPref">Sin preferencias</label>
                        </div>
                    </div>


                    <h2 class="section-heading">3. Información de Acceso</h2>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="usuario" class="form-label">Nombre de usuario (*)</label>
                            <input type="text" class="form-control" id="usuario" name="usuario" value="<?php echo htmlspecialchars($_POST['usuario'] ?? ''); ?>" required>
                            <div class="invalid-feedback">Crea un nombre de usuario.</div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="password" class="form-label">Contraseña (*)</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <div class="invalid-feedback">Introduce una contraseña.</div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="confirmPassword" class="form-label">Confirmación de contraseña (*)</label>
                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                            <div class="invalid-feedback">Confirma tu contraseña.</div>
                        </div>
                    </div>

                    <h2 class="section-heading">4. Preferencias y Acuerdos</h2>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="notificaciones" name="notificaciones" value="si" <?php echo isset($_POST['notificaciones']) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="notificaciones">¿Desea recibir notificaciones por correo electrónico?</label>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="terminos" name="terminos" value="aceptado" <?php echo isset($_POST['terminos']) ? 'checked' : ''; ?> required>
                        <label class="form-check-label" for="terminos">Acepto los términos y condiciones. (*)</label>
                        <div class="invalid-feedback">Debes aceptar los términos y condiciones para continuar.</div>
                    </div>
                    
                    <h2 class="section-heading">5. Encuesta Adicional</h2>
                    <?php $calif_val = htmlspecialchars($_POST['calificacion'] ?? '5'); ?>
                    <div class="mb-3">
                        <label for="calificacion" class="form-label">Calificación de eventos anteriores (1 a 10): <span id="valorCalificacion"><?php echo $calif_val; ?></span></label>
                        <input type="range" class="form-range" min="1" max="10" step="1" id="calificacion" name="calificacion" value="<?php echo $calif_val; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="comentarios" class="form-label">Comentarios adicionales</label>
                        <textarea class="form-control" id="comentarios" name="comentarios" rows="3" placeholder="¿Tienes alguna sugerencia o nota especial?"><?php echo htmlspecialchars($_POST['comentarios'] ?? ''); ?></textarea>
                    </div>

                    <h2 class="section-heading">6. Adjuntar Archivo</h2>
                    <div class="mb-3">
                        <label for="adjunto" class="form-label">Adjuntar un archivo (ej. ID de estudiante para entrada)</label>
                        <input class="form-control" type="file" id="adjunto" name="adjunto">
                    </div>

                    <button class="btn btn-primary btn-lg w-100 mt-4" type="submit"> Registrarme al Evento</button>
                </form>
            </div>

        <?php endif; ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <script>
        // La validación de Bootstrap solo debe inicializarse si se muestra el formulario
        // Como la variable ya está definida en la parte superior, esta comprobación es segura.
        <?php if (!$registroExitoso): ?> 
            // 1. Validaciones de Bootstrap
            (function () {
                'use strict'
                var forms = document.querySelectorAll('.needs-validation')
                Array.prototype.slice.call(forms)
                    .forEach(function (form) {
                        form.addEventListener('submit', function (event) {
                            // Validación de Confirmación de Contraseña
                            var password = document.getElementById('password');
                            var confirmPassword = document.getElementById('confirmPassword');
                            if (password.value !== confirmPassword.value) {
                                confirmPassword.setCustomValidity('Las contraseñas no coinciden.');
                            } else {
                                confirmPassword.setCustomValidity('');
                            }

                            if (!form.checkValidity()) {
                                event.preventDefault()
                                event.stopPropagation()
                            }

                            form.classList.add('was-validated')
                        }, false)
                    })
            })()
            
            // 2. Mostrar el valor del Range Slider
            document.getElementById('calificacion').addEventListener('input', function() {
                document.getElementById('valorCalificacion').textContent = this.value;
            });
        <?php endif; ?>

    </script>
</body>
</html>