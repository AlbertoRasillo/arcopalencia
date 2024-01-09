<?php
// Establecer el tiempo de vida de la sesión en segundos (por ejemplo, 30 minutos)
$tiempo_vida = 1800; // 30 minutos
session_set_cookie_params($tiempo_vida);

// Iniciar o reanudar la sesión
session_start();

// Verificar la autenticación del usuario
if (!isset($_SESSION['id_usuario']) or $_SESSION['rol'] != "socio") {
    header("Location: login.php");
    exit();
}

// Verificar la expiración por inactividad
if (isset($_SESSION['ultimo_acceso']) && (time() - $_SESSION['ultimo_acceso'] > $tiempo_vida)) {
    // La sesión ha expirado por inactividad
    session_unset();     // Desactivar todas las variables de sesión
    session_destroy();   // Destruir la sesión
    header("Location: login.php"); // Redirigir a la página de inicio de sesión
    exit();
}

// Actualizar el tiempo de la última acción
$_SESSION['ultimo_acceso'] = time();
?>
