<?php
session_start();
include 'config.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Mensaje de operación
$mensaje = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nivel_id = $_POST['nivel_id'];
    $accion = $_POST['accion'];

    // Actualiza el estado de las matrículas según la acción
    if ($accion == 'habilitar') {
        $sql = "UPDATE matriculas SET estado = 'habilitada' WHERE id_nivel = '$nivel_id'";
        $mensaje = "Las matrículas del nivel han sido habilitadas.";
    } else {
        $sql = "UPDATE matriculas SET estado = 'deshabilitada' WHERE id_nivel = '$nivel_id'";
        $mensaje = "Las matrículas del nivel han sido deshabilitadas.";
    }

    if ($conn->query($sql) === TRUE) {
        // Éxito
    } else {
        $mensaje = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Matrículas</title>
</head>
<body>
    <h1>Gestionar Matrículas</h1>
    
    <form method="POST" action="">
        <label for="nivel_id">Seleccionar Nivel:</label>
        <select name="nivel_id" required>
            <option value="">Seleccionar nivel</option>
            <?php 
            // Consulta para obtener los niveles
            $niveles = $conn->query("SELECT * FROM niveles");
            while ($nivel = $niveles->fetch_assoc()): ?>
                <option value="<?php echo $nivel['id_nivel']; ?>"><?php echo $nivel['nombre']; ?></option>
            <?php endwhile; ?>
        </select>

        <label for="accion">Acción:</label>
        <select name="accion" required>
            <option value="">Seleccionar acción</option>
            <option value="habilitar">Habilitar</option>
            <option value="deshabilitar">Deshabilitar</option>
        </select>

        <input type="submit" value="Actualizar Matrículas">
    </form>

    <?php if ($mensaje): ?>
        <p><?php echo $mensaje; ?></p>
    <?php endif; ?>

    <h2>Niveles con Matrículas Habilitadas</h2>
    <ul>
        <?php
        // Consulta para obtener niveles con matrículas habilitadas
        $niveles_habilitados = $conn->query("SELECT n.nombre FROM niveles n
                                              JOIN matriculas m ON n.id_nivel = m.id_nivel
                                              WHERE m.estado = 'habilitada'
                                              GROUP BY n.id_nivel");

        if ($niveles_habilitados && $niveles_habilitados->num_rows > 0) {
            while ($row = $niveles_habilitados->fetch_assoc()) {
                echo "<li>" . $row['nombre'] . "</li>";
            }
        } else {
            echo "<li>No hay niveles con matrículas habilitadas.</li>";
        }
        ?>
    </ul>

    <a href="panel.php">Volver al Panel</a>
</body>
</html>

