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

$message = ""; // Variable para el mensaje de éxito

if ($nivel_docente) {
    // Obtener las materias correspondientes al nivel del docente
    $sql_materias = "SELECT id_materia, nombre FROM materias WHERE id_nivel = $nivel_docente";
    $result_materias = $conn->query($sql_materias);
}

// Procesar la asignación de calificaciones
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['materia_id'], $_POST['calificacion'], $_POST['estudiante_id'])) {
    $materia_id = $_POST['materia_id'];
    $calificacion = $_POST['calificacion'];
    $estudiante_id = $_POST['estudiante_id'];

    // Verificar si ya existe un registro de calificación
    $sql_check = "SELECT * FROM notas WHERE id_estudiante = $estudiante_id AND id_materia = $materia_id";
    $result_check = $conn->query($sql_check);

    if ($result_check && $result_check->num_rows > 0) {
        // Actualizar la calificación existente
        $sql_update = "UPDATE notas SET calificacion = $calificacion WHERE id_estudiante = $estudiante_id AND id_materia = $materia_id";
        if ($conn->query($sql_update) === TRUE) {
            $message = "Calificación actualizada correctamente.";
        }
    } else {
        // Insertar nueva calificación
        $sql_insert = "INSERT INTO notas (id_estudiante, id_materia, calificacion) VALUES ($estudiante_id, $materia_id, $calificacion)";
        if ($conn->query($sql_insert) === TRUE) {
            $message = "Calificación asignada correctamente.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calificaciones</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #e9ecef;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #007BFF;
            text-align: center;
            margin-bottom: 30px;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: auto;
        }
        label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }
        select, input[type="text"], input[type="submit"], button {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #007BFF;
            border-radius: 4px;
            font-size: 16px;
        }
        input[type="submit"], button {
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover, button:hover {
            background-color: #0056b3;
        }
        .alert {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border: 1px solid #c3e6cb;
            border-radius: 4px;
            margin-top: 20px;
            display: <?php echo !empty($message) ? 'block' : 'none'; ?>;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Asignación de Calificaciones</h1>
    <div class="container">
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

            <label for="estudiante">Seleccionar Estudiante:</label>
            <select name="estudiante_id" id="estudiante" required>
                <option value="">Seleccione un estudiante</option>
                <?php
                $sql_estudiantes = "SELECT id_estudiante, nombre FROM estudiante WHERE nivel_matricula = $nivel_docente";
                $result_estudiantes = $conn->query($sql_estudiantes);
                if ($result_estudiantes && $result_estudiantes->num_rows > 0) {
                    while ($estudiante = $result_estudiantes->fetch_assoc()) {
                        echo "<option value='{$estudiante['id_estudiante']}'>{$estudiante['nombre']}</option>";
                    }
                }
                ?>
            </select>

            <label for="calificacion">Calificación:</label>
            <input type="text" name="calificacion" id="calificacion" required>

            <input type="submit" value="Asignar Calificación">
        </form>

        <?php if (!empty($message)): ?>
            <div class="alert"><?php echo $message; ?></div>
        <?php endif; ?>

        <div class="footer">
    <button onclick="window.location.href='panel_docente.php';">Regresar</button>
</div>

    </div>
</body>
</html>
