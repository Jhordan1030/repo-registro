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

// Obtener notas del estudiante
$query_notas = "SELECT m.nombre AS materia, n.parcial1, n.parcial2, n.final FROM notas n JOIN materias m ON n.materia_id = m.id WHERE n.estudiante_email = ?";
$stmt = $conn->prepare($query_notas);
$stmt->bind_param("s", $email);
$stmt->execute();
$result_notas = $stmt->get_result();

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
    <title>Panel de Estudiante</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h1>Panel de Estudiante</h1>
    
    <nav>
        <ul>
            <li><a href="#matriculas">Matriculas</a></li>
            <li><a href="#notas">Notas</a></li>
        </ul>
    </nav>

    <section id="matriculas">
        <h2>Matriculación</h2>
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
    </section>

    <section id="notas">
        <h2>Mis Notas</h2>
        <table>
            <thead>
                <tr>
                    <th>Materia</th>
                    <th>Parcial 1</th>
                    <th>Parcial 2</th>
                    <th>Nota Final</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($nota = $result_notas->fetch_assoc()): ?>
                    <tr>
                        <td><?= $nota['materia'] ?></td>
                        <td><?= $nota['parcial1'] ?></td>
                        <td><?= $nota['parcial2'] ?></td>
                        <td id="nota-final-<?= $nota['materia'] ?>"><?= $nota['final'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </section>

    <h2>Materias Matriculadas</h2>
    <ul>
        <?php foreach ($materias_matriculadas as $materia_matriculada): ?>
            <li><?= $materia_matriculada ?></li>
        <?php endforeach; ?>
    </ul>

    <a href="logout.php">Cerrar Sesión</a>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const notasFinales = document.querySelectorAll("td[id^='nota-final-']");
            notasFinales.forEach(nota => {
                const valor = parseFloat(nota.textContent);
                if (valor >= 7) {
                    nota.style.color = "green"; // Color verde para aprobados
                } else {
                    nota.style.color = "red"; // Color rojo para reprobados
                }
            });
        });
    </script>
</body>
</html>

<?php
$stmt->close();
$stmt_matriculas->close();
$conn->close();
?>
