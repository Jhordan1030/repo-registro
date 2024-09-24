<?php
session_start();
include 'config.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

$correo_docente = $_SESSION['usuario'];

// Obtener el nivel asignado al docente
$sql_nivel = "SELECT nivel_asignado FROM docente WHERE correo = '$correo_docente'";
$result_nivel = $conn->query($sql_nivel);

// Verificar si la consulta fue exitosa
if ($result_nivel === false) {
    die("Error en la consulta: " . $conn->error);
}

if ($result_nivel->num_rows > 0) {
    $row = $result_nivel->fetch_assoc();
    $nivel_asignado = $row['nivel_asignado'];

    // Obtener estudiantes en el mismo nivel
    $sql_estudiantes = "SELECT e.nombre, e.correo, e.nivel_matricula
                        FROM estudiante e
                        WHERE e.nivel_matricula = '$nivel_asignado'";
    $result_estudiantes = $conn->query($sql_estudiantes);

    // Verificar si la consulta fue exitosa
    if ($result_estudiantes === false) {
        die("Error en la consulta de estudiantes: " . $conn->error);
    }
} else {
    echo "No se encontró el nivel asignado para el docente.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estudiantes</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #007BFF;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
    </style>
</head>
<body>
    <h1>Estudiantes en tu Nivel</h1>
    
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Nivel Matriculado</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result_estudiantes->num_rows > 0) {
                while ($estudiante = $result_estudiantes->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $estudiante['nombre'] . "</td>";
                    echo "<td>" . $estudiante['correo'] . "</td>";
                    echo "<td>" . $estudiante['nivel_matricula'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No hay estudiantes en este nivel.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    
    <a href="panel_docente.php">Regresar al Panel</a>
</body>
</html>
