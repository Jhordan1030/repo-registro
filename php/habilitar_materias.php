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

    $query_habilitar = $accion == 'habilitar' ? 
        "UPDATE materias SET habilitada = 1 WHERE id = ?" : 
        "UPDATE materias SET habilitada = 0 WHERE id = ?";
    
    $stmt_habilitar = $conn->prepare($query_habilitar);
    $stmt_habilitar->bind_param("i", $materia_id);
    $stmt_habilitar->execute();
}

// Obtener materias
$query_materias = "SELECT * FROM materias";
$result_materias = $conn->query($query_materias);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Habilitar Materias</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
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
        <a href="panel_docente.php">Regresar</a>
    </div>
</body>
</html>

<?php
$stmt_docente->close();
$conn->close();
?>
