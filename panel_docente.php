<?php
session_start();
include 'config.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

$correo_docente = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Docente</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #007BFF;
        }
        nav {
            margin-bottom: 20px;
        }
        nav a {
            margin: 0 10px;
            text-decoration: none;
            color: #007BFF;
            padding: 10px;
            border: 1px solid #007BFF;
            border-radius: 4px;
        }
        nav a:hover {
            background-color: #007BFF;
            color: white;
        }
    </style>
</head>
<body>
    <h1>Bienvenido, Docente</h1>
    <p>Correo: <?php echo $correo_docente; ?></p>
    
    <nav>
        <a href="estudiantes.php">Estudiantes</a>
        <a href="calificaciones.php">Calificar</a>
        <a href="notas.php">Notas</a>
        <a href="index.php">Cerrar Sesión</a>
    </nav>

    <h2>Contenido del Panel</h2>
    <p>Aquí puedes gestionar tus tareas como docente.</p>
</body>
</html>
