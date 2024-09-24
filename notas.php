<?php
session_start();
include 'config.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

$correo_docente = $_SESSION['usuario'];

// Obtener el nivel del docente
$sql_nivel = "SELECT nivel_asignado FROM docente WHERE correo = '$correo_docente'";
$result_nivel = $conn->query($sql_nivel);
$nivel_docente = ($result_nivel && $result_nivel->num_rows > 0) ? $result_nivel->fetch_assoc()['nivel_asignado'] : null;

// Obtener las materias correspondientes al nivel del docente
if ($nivel_docente) {
    $sql_materias = "SELECT id_materia, nombre FROM materias WHERE id_nivel = $nivel_docente";
    $result_materias = $conn->query($sql_materias);
}

// Obtener calificaciones al seleccionar una materia
$calificaciones = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['materia_id'])) {
    $materia_id = $_POST['materia_id'];

    // Obtener estudiantes y sus calificaciones
    $sql_estudiantes = "SELECT e.id_estudiante, e.nombre, n.calificacion 
                        FROM estudiante e 
                        LEFT JOIN notas n ON e.id_estudiante = n.id_estudiante AND n.id_materia = $materia_id 
                        WHERE e.nivel_matricula = $nivel_docente";
    $result_calificaciones = $conn->query($sql_estudiantes);

    if ($result_calificaciones && $result_calificaciones->num_rows > 0) {
        while ($row = $result_calificaciones->fetch_assoc()) {
            $calificaciones[] = $row;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Notas</title>
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
        form {
            margin-bottom: 20px;
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
        .aprobado {
            background-color: #28a745; /* Verde */
            color: white;
            padding: 5px;
            text-align: center;
        }
        .reprobado {
            background-color: #dc3545; /* Rojo */
            color: white;
            padding: 5px;
            text-align: center;
        }
        button {
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Notas de Estudiantes</h1>
    <p>Correo: <?php echo $correo_docente; ?></p>

    <form method="POST" action="">
        <label for="materia">Seleccionar Materia:</label>
        <select name="materia_id" id="materia" required>
            <option value="">Seleccione una materia</option>
            <?php
            if ($result_materias && $result_materias->num_rows > 0) {
                while ($materia = $result_materias->fetch_assoc()) {
                    echo "<option value='{$materia['id_materia']}'>{$materia['nombre']}</option>";
                }
            }
            ?>
        </select>
        <input type="submit" value="Ver Calificaciones">
    </form>

    <?php if (!empty($calificaciones)): ?>
        <h2>Calificaciones de la Materia Seleccionada</h2>
        <table>
            <tr>
                <th>Nombre del Estudiante</th>
                <th>Calificación</th>
                <th>Aprobado</th>
            </tr>
            <?php foreach ($calificaciones as $calificacion): ?>
                <tr>
                    <td><?php echo $calificacion['nombre']; ?></td>
                    <td><?php echo $calificacion['calificacion'] !== null ? $calificacion['calificacion'] : 'No asignada'; ?></td>
                    <td class="<?php echo ($calificacion['calificacion'] !== null && $calificacion['calificacion'] >= 7.0) ? 'aprobado' : 'reprobado'; ?>">
                        <?php
                        echo ($calificacion['calificacion'] !== null && $calificacion['calificacion'] >= 7.0) ? 'Sí' : 'No';
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <button onclick="window.location.href='panel_docente.php';">Regresar al Panel Docente</button>
</body>
</html>
