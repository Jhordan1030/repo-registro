<?php
session_start();
include 'config.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h1>Bienvenido al Panel de Administración</h1>
    <p>Usuario: <?php echo $_SESSION['usuario']; ?></p>

    <h2>Opciones</h2>
    <button onclick="location.href='agregar_docente.php'">Agregar Docente</button>
    <button onclick="location.href='agregar_estudiante.php'">Agregar Estudiante</button>
    <button onclick="location.href='gestionar_matriculas.php'">Gestionar Matrículas</button>
    <button onclick="location.href='ver_docentes.php'">Ver Lista de Docentes</button>
    <button onclick="location.href='ver_estudiantes.php'">Ver Lista de Estudiantes</button>


    <a href="loginAdmin.php">Cerrar Sesión</a>
</div>
</body>
</html>
