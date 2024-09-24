<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $contraseña = md5($_POST['contraseña']); // Usar MD5 para la comparación

    // Verificar si es docente
    $query_docente = "SELECT * FROM docente WHERE correo='$correo' AND contraseña='$contraseña'";
    $result_docente = $conn->query($query_docente);

    if ($result_docente->num_rows > 0) {
        $_SESSION['usuario'] = $correo;
        header("Location: panel_docente.php");
        exit();
    }

    // Verificar si es estudiante
    $query_estudiante = "SELECT * FROM estudiante WHERE correo='$correo' AND contraseña='$contraseña'";
    $result_estudiante = $conn->query($query_estudiante);

    if ($result_estudiante->num_rows > 0) {
        $_SESSION['usuario'] = $correo;
        header("Location: panel_estudiante.php");
        exit();
    }

    // Si las credenciales son incorrectas
    echo "Correo o contraseña incorrectos.";
}
?>
