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

// Habilitar o deshabilitar materias
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accion'])) {
    $materia_id = $_POST['materia_id'];
    $accion = $_POST['accion'];

    if ($accion == 'habilitar') {
        $query_habilitar = "UPDATE materias SET habilitada = 1 WHERE id = ?";
    } else {
        $query_habilitar = "UPDATE materias SET habilitada = 0 WHERE id = ?";
    }
    
    $stmt_habilitar = $conn->prepare($query_habilitar);
    $stmt_habilitar->bind_param("i", $materia_id);
    $stmt_habilitar->execute();
}

// Obtener materias
$query_materias = "SELECT * FROM materias";
$result_materias = $conn->query($query_materias);

// Obtener lista de estudiantes matriculados por materia
$query_estudiantes_matriculados = "SELECT m.nombre AS materia, u.email AS estudiante FROM matriculas mt JOIN materias m ON mt.materia_id = m.id JOIN usuarios u ON mt.estudiante_email = u.email";
$result_estudiantes = $conn->query($query_estudiantes_matriculados);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Docente</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h1>Panel de Docente</h1>
    
    <h2>Habilitar/Deshabilitar Materias</h2>
    <form action="" method="POST">
        <label for="materia">Selecciona una materia:</label>
        <select name="materia_id" required>
            <?php while ($materia = $result_materias->fetch_assoc()): ?>
                <option value="<?= $materia['id'] ?>"><?= $materia['nombre'] ?></option>
            <?php endwhile; ?>
        </select>
        <select name="accion">
            <option value="habilitar">Habilitar</option>
            <option value="deshabilitar">Deshabilitar</option>
        </select>
        <button type="submit">Aplicar</button>
    </form>

    <h2>Lista de Estudiantes Matriculados por Materia</h2>
    <table>
        <thead>
            <tr>
                <th>Materia</th>
                <th>Estudiante</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($estudiante = $result_estudiantes->fetch_assoc()): ?>
                <tr>
                    <td><?= $estudiante['materia'] ?></td>
                    <td><?= $estudiante['estudiante'] ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <h2>Subir Notas</h2>
<form action="ingresar_notas.php" method="POST" id="form-notas">
    <label for="materia">Selecciona una materia:</label>
    <select name="materia_id" required>
        <?php
        // Reiniciar el puntero del resultado de materias
        $result_materias->data_seek(0);
        while ($materia = $result_materias->fetch_assoc()): ?>
            <option value="<?= $materia['id'] ?>"><?= $materia['nombre'] ?></option>
        <?php endwhile; ?>
    </select>
    <label for="email">Correo del Estudiante:</label>
    <input type="email" name="email" required>
    <label for="parcial1">Nota Parcial 1:</label>
    <input type="number" name="parcial1" min="0" max="10" required id="parcial1">
    <label for="parcial2">Nota Parcial 2:</label>
    <input type="number" name="parcial2" min="0" max="10" required id="parcial2">
    <label for="promedio">Promedio:</label>
    <input type="text" name="promedio" readonly id="promedio">
    <button type="submit">Subir Notas</button>
</form>

<script>
    const parcial1Input = document.getElementById('parcial1');
    const parcial2Input = document.getElementById('parcial2');
    const promedioInput = document.getElementById('promedio');

    function calcularPromedio() {
        const parcial1 = parseFloat(parcial1Input.value) || 0;
        const parcial2 = parseFloat(parcial2Input.value) || 0;
        const promedio = (parcial1 + parcial2) / 2;
        promedioInput.value = promedio.toFixed(2); // Mostrar dos decimales
    }

    parcial1Input.addEventListener('input', calcularPromedio);
    parcial2Input.addEventListener('input', calcularPromedio);
</script>


    <a href="logout.php">Cerrar Sesión</a>
</body>
</html>

<?php
$stmt_docente->close();
$conn->close();
?>
