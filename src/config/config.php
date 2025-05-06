// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    error_log("Sesión iniciada en config.php");
} 