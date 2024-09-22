<?php
session_start();
include 'db.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];

// Obtener notas del estudiante
$query_notas = "SELECT m.nombre AS materia, n.parcial1, n.parcial2, n.final 
                FROM notas n 
                JOIN materias m ON n.materia_id = m.id 
                WHERE n.estudiante_email = ?";
$stmt = $conn->prepare($query_notas);
$stmt->bind_param("s", $email);
$stmt->execute();
$result_notas = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Notas</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Mis Notas</h1>
        <table class="notas-table">
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
                        <td><?= htmlspecialchars($nota['materia']) ?></td>
                        <td><?= htmlspecialchars($nota['parcial1']) ?></td>
                        <td><?= htmlspecialchars($nota['parcial2']) ?></td>
                        <td id="nota-final-<?= htmlspecialchars($nota['materia']) ?>"><?= htmlspecialchars($nota['final']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="panel_estudiante.php" class="btn-volver">Volver al Panel</a>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const notasFinales = document.querySelectorAll("td[id^='nota-final-']");
            notasFinales.forEach(nota => {
                const valor = parseFloat(nota.textContent);
                if (valor >= 7) {
                    nota.style.color = "green"; // Aprobados en verde
                } else {
                    nota.style.color = "red"; // Reprobados en rojo
                }
            });
        });
    </script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
