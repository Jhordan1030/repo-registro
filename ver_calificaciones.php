<?php
session_start();
include 'config.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

$correo_estudiante = $_SESSION['usuario'];

// Conectar a la base de datos y obtener calificaciones
$sql = "SELECT * FROM calificaciones WHERE correo_estudiante = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $correo_estudiante);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ver Calificaciones</title>
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
        th, td {
            border: 1px solid #007BFF;
            padding: 10px;
            text-align: left;
        }
        th {
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
    <h1>Calificaciones de <?php echo $correo_estudiante; ?></h1>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Materia</th>
                    <th>Calificación</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['materia']); ?></td>
                        <td><?php echo htmlspecialchars($row['calificacion']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay calificaciones disponibles.</p>
    <?php endif; ?>

    <div class="footer">
        <button onclick="window.location.href='panel_estudiante.php';">Regresar al Panel</button>
    </div>
</body>
</html>
