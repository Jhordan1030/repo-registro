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

// Obtener lista de materias
$query_materias = "SELECT * FROM materias";
$result_materias = $conn->query($query_materias);

// Filtrar estudiantes por materia
$materia_id = isset($_POST['materia_id']) ? $_POST['materia_id'] : null;
$query_estudiantes_matriculados = "SELECT u.nombre AS nombre, u.apellido AS apellido, u.email AS correo, m.nombre AS materia 
    FROM matriculas mt 
    JOIN materias m ON mt.materia_id = m.id 
    JOIN usuarios u ON mt.estudiante_email = u.email" . 
    ($materia_id ? " WHERE mt.materia_id = ?" : "");

$stmt_estudiantes = $conn->prepare($query_estudiantes_matriculados);
if ($materia_id) {
    $stmt_estudiantes->bind_param("i", $materia_id);
}
$stmt_estudiantes->execute();
$result_estudiantes = $stmt_estudiantes->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estudiantes Matriculados</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #f9f9f9;
        }
        h2 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        form {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Lista de Estudiantes Matriculados por Materia</h2>

        <form action="" method="POST">
            <label for="materia">Selecciona una materia:</label>
            <select name="materia_id" required>
                <option value="">Todas las materias</option>
                <?php while ($materia = $result_materias->fetch_assoc()): ?>
                    <option value="<?= $materia['id'] ?>" <?= ($materia_id == $materia['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($materia['nombre']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <button type="submit">Buscar</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Nombre y Apellido</th>
                    <th>Correo</th>
                    <th>Materia</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($estudiante = $result_estudiantes->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($estudiante['nombre'] . ' ' . $estudiante['apellido']) ?></td>
                        <td><?= htmlspecialchars($estudiante['correo']) ?></td>
                        <td><?= htmlspecialchars($estudiante['materia']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="panel_docente.php">Regresar</a>
    </div>
</body>
</html>

<?php
$stmt_docente->close();
$stmt_estudiantes->close();
$conn->close();
?>
