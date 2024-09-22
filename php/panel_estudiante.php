<?php
session_start();
include 'db.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];

// Funciones para obtener información del estudiante, notas y materias matriculadas
function getEstudianteInfo($conn, $email) {
    $query = "SELECT nombre, apellido FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function getNotas($conn, $email) {
    $query = "SELECT m.nombre AS materia, n.parcial1, n.parcial2, n.final FROM notas n JOIN materias m ON n.materia_id = m.id WHERE n.estudiante_email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    return $stmt->get_result();
}

function getMateriasMatriculadas($conn, $email) {
    $query = "SELECT m.nombre FROM matriculas mt JOIN materias m ON mt.materia_id = m.id WHERE mt.estudiante_email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    return $stmt->get_result();
}

$estudiante = getEstudianteInfo($conn, $email);
$notas = getNotas($conn, $email);
$materiasMatriculadas = getMateriasMatriculadas($conn, $email);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Estudiante</title>
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
        h1 {
            margin: 0;
            font-size: 24px;
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .final {
            font-weight: bold;
        }
        .green {
            color: green;
        }
        .red {
            color: red;
        }
    </style>
</head>
<body>
    <header>
        <h1>Bienvenido, <?= htmlspecialchars($estudiante['nombre']) . ' ' . htmlspecialchars($estudiante['apellido']) ?></h1>
    </header>

    <div class="container">
        <div>
            <button onclick="location.href='matriculas.php'">Matriculas</button>
            <button onclick="location.href='notas.php'">Notas</button>
        </div>


        <a href="login.php">Cerrar Sesión</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>
