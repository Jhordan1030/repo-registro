<?php
session_start();
include 'config.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

$correo_estudiante = $_SESSION['usuario'];
// Aquí puedes agregar más lógica para mostrar datos del estudiante
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Estudiante</title>
</head>
<body>
    <h1>Bienvenido, Estudiante</h1>
    <p>Correo: <?php echo $correo_estudiante; ?></p>
    <a href="logout.php">Cerrar Sesión</a>
</body>
</html>
