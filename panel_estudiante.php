<?php
session_start();
include 'config.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

$correo_estudiante = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Estudiante</title>
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
        .footer {
            margin-top: 20px;
        }
        .footer button {
            padding: 10px 20px;
            border: none;
            background-color: #007BFF;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }
        .footer button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Bienvenido, Estudiante</h1>
    <p>Correo: <?php echo $correo_estudiante; ?></p>
    
    <nav>
        <a href="ver_calificaciones.php">Ver Calificaciones</a>
        <a href="index.php">Cerrar Sesión</a>
    </nav>

    <h2>Panel del Estudiante</h2>
    <p>Aquí puedes ver tus calificaciones y realizar otras tareas.</p>

    <div class="footer">
        <button onclick="window.location.href='index.php';">Cerrar Sesión</button>
    </div>
</body>
</html>
