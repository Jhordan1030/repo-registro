<?php
session_start();
include 'db.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];

// Obtener materias habilitadas
$query_materias = "SELECT * FROM materias WHERE habilitada = 1";
$result_materias = $conn->query($query_materias);

// Obtener materias matriculadas del estudiante
$query_matriculas = "SELECT m.nombre FROM matriculas mt JOIN materias m ON mt.materia_id = m.id WHERE mt.estudiante_email = ?";
$stmt_matriculas = $conn->prepare($query_matriculas);
$stmt_matriculas->bind_param("s", $email);
$stmt_matriculas->execute();
$result_matriculas = $stmt_matriculas->get_result();

$materias_matriculadas = [];
while ($row = $result_matriculas->fetch_assoc()) {
    $materias_matriculadas[] = $row['nombre'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Matriculas</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h1>Matriculación</h1>
    <form action="matricular.php" method="POST">
        <label for="materia">Selecciona una materia para matricularte:</label>
        <select name="materia_id" required>
            <?php while ($materia = $result_materias->fetch_assoc()): ?>
                <?php if (!in_array($materia['id'], array_column($materias_matriculadas, 'id'))): ?>
                    <option value="<?= $materia['id'] ?>"><?= $materia['nombre'] ?></option>
                <?php endif; ?>
            <?php endwhile; ?>
        </select>
        <button type="submit">Matricularse</button>
    </form>

    <h2>Materias Matriculadas</h2>
    <ul>
        <?php foreach ($materias_matriculadas as $materia_matriculada): ?>
            <li><?= $materia_matriculada ?></li>
        <?php endforeach; ?>
    </ul>

    <a href="panel_estudiante.php">Volver</a>
</body>
</html>

<?php
$stmt_matriculas->close();
$conn->close();
?>
