<?php
session_start();
include 'config.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Lógica para filtrar docentes por nivel
$nivel_id = isset($_POST['nivel_id']) ? $_POST['nivel_id'] : '';

// Consulta para obtener la lista de niveles
$niveles = $conn->query("SELECT * FROM Niveles");

// Consulta para obtener la lista de docentes con su nivel (filtrado si se selecciona un nivel)
$sql = "SELECT d.nombre AS nombre_docente, d.usuario, d.correo, n.nombre AS nivel
        FROM Docente d
        JOIN Niveles n ON d.nivel_asignado = n.id_nivel";

if ($nivel_id) {
    $sql .= " WHERE d.nivel_asignado = '$nivel_id'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Docentes</title>
</head>
<body>
    <h1>Lista de Docentes</h1>

    <!-- Formulario para buscar docentes por nivel -->
    <form method="POST" action="">
        <label for="nivel_id">Seleccionar Nivel:</label>
        <select name="nivel_id" required>
            <option value="">Seleccionar nivel</option>
            <?php while ($nivel = $niveles->fetch_assoc()): ?>
                <option value="<?php echo $nivel['id_nivel']; ?>" <?php echo ($nivel_id == $nivel['id_nivel']) ? 'selected' : ''; ?>>
                    <?php echo $nivel['nombre']; ?>
                </option>
            <?php endwhile; ?>
        </select>
        <input type="submit" value="Buscar">
    </form>

    <table border="1">
        <tr>
            <th>Nombre</th>
            <th>Usuario</th>
            <th>Correo</th>
            <th>Nivel Asignado</th>
        </tr>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['nombre_docente']; ?></td>
                    <td><?php echo $row['usuario']; ?></td>
                    <td><?php echo $row['correo']; ?></td>
                    <td><?php echo $row['nivel']; ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">No hay docentes registrados para este nivel.</td>
            </tr>
        <?php endif; ?>
    </table>

    <a href="panel.php">Volver al Panel</a>
</body>
</html>
