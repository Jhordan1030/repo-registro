<?php
session_start();
include 'db.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];

if (!isset($_GET['materia_id'])) {
    echo "No se seleccionó ninguna materia.";
    exit();
}

$materia_id = $_GET['materia_id'];

// Verificar si el usuario es docente
$query_docente = "SELECT * FROM usuarios WHERE email = ? AND tipo = 'docente'";
$stmt_docente = $conn->prepare($query_docente);
$stmt_docente->bind_param("s", $email);
$stmt_docente->execute();
$result_docente = $stmt_docente->get_result();

if ($result_docente->num_rows == 0) {
    echo "Acceso no autorizado.";
    exit();
}

// Obtener lista de estudiantes matriculados en la materia seleccionada
$query_estudiantes = "SELECT u.nombre, u.apellido, u.email
                      FROM matriculas mt
                      JOIN usuarios u ON mt.estudiante_email = u.email
                      WHERE mt.materia_id = ?";
$stmt_estudiantes = $conn->prepare($query_estudiantes);
$stmt_estudiantes->bind_param("i", $materia_id);
$stmt_estudiantes->execute();
$result_estudiantes = $stmt_estudiantes->get_result();

// Si se envían calificaciones
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $estudiante_email = $_POST['email'];
    $parcial1 = $_POST['parcial1'];
    $parcial2 = $_POST['parcial2'];
    $final = ($parcial1 + $parcial2) / 2;  // Cálculo de la nota final

    $query_notas = "INSERT INTO notas (estudiante_email, materia_id, parcial1, parcial2, final)
                    VALUES (?, ?, ?, ?, ?)
                    ON DUPLICATE KEY UPDATE parcial1 = VALUES(parcial1), parcial2 = VALUES(parcial2), final = VALUES(final)";
    $stmt_notas = $conn->prepare($query_notas);
    $stmt_notas->bind_param("siidd", $estudiante_email, $materia_id, $parcial1, $parcial2, $final);
    $stmt_notas->execute();

    echo "Notas guardadas correctamente.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calificar Estudiantes</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h1>Calificar Estudiantes en la Materia Seleccionada</h1>

    <form action="" method="POST">
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Email</th>
                    <th>Parcial 1</th>
                    <th>Parcial 2</th>
                    <th>Guardar</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($estudiante = $result_estudiantes->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($estudiante['nombre']) ?></td>
                        <td><?= htmlspecialchars($estudiante['apellido']) ?></td>
                        <td><?= htmlspecialchars($estudiante['email']) ?></td>
                        <td><input type="number" name="parcial1" min="0" max="10" step="0.01" required></td>
                        <td><input type="number" name="parcial2" min="0" max="10" step="0.01" required></td>
                        <td>
                            <input type="hidden" name="email" value="<?= htmlspecialchars($estudiante['email']) ?>">
                            <button type="submit">Guardar</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </form>

    <a href="seleccionar_materia.php">Volver a Selección de Materia</a>
</body>
</html>

<?php
$stmt_docente->close();
$stmt_estudiantes->close();
$conn->close();
?>
