<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Consulta para verificar docente
    $sql = "SELECT * FROM docente WHERE usuario='$usuario' AND contraseña='$contrasena'";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0) {
        $_SESSION['usuario'] = $usuario;
        header("Location: panel_docente.php"); // Redirige al panel del docente
        exit();
    } else {
        echo "Usuario o contraseña incorrectos.";
    }
}
?>

<!-- Agrega aquí un enlace para volver a la página principal -->
<a href="index.php">Volver</a>
