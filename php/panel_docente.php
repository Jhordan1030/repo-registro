<?php
session_start();
include 'db.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];

// Verificar si el docente está autenticado
$query_docente = "SELECT * FROM usuarios WHERE email = ? AND tipo = 'docente'";
$stmt_docente = $conn->prepare($query_docente);
$stmt_docente->bind_param("s", $email);
$stmt_docente->execute();
$result_docente = $stmt_docente->get_result();

if ($result_docente->num_rows == 0) {
    echo "Acceso no autorizado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Docente</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        header {
            background-color: #4CAF50;
            color: white;
            padding: 10px 0;
            text-align: center;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 15px;
            margin: 5px;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <header>
        <h1>Panel de Docente</h1>
    </header>

    <div class="container">
        <h2>Opciones</h2>
        <div>
            <button onclick="location.href='habilitar_materias.php'">Habilitar/Deshabilitar Materias</button>
            <button onclick="location.href='listar_estudiantes.php'">Listar Estudiantes Matriculados</button>
            <button onclick="location.href='subir_notas.php'">Subir Notas</button>
        </div>
        
        <a href="login.php">Cerrar Sesión</a>
    </div>

</body>
</html>

<?php
$stmt_docente->close();
$conn->close();
?>
