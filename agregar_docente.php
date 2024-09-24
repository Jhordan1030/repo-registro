<?php
session_start();
include 'config.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php"); // Redirigir si no está autenticado
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_docente = $_POST['nombre_docente'];
    $usuario_docente = $_POST['usuario_docente'];
    $correo_docente = $_POST['correo_docente'];
    $contraseña_docente = md5($_POST['contraseña_docente']);
    $nivel_asignado = $_POST['nivel_asignado'];

    // Verificar si ya existe un docente en el nivel asignado
    $check_sql = "SELECT * FROM Docente WHERE nivel_asignado = '$nivel_asignado'";
    $result = $conn->query($check_sql);

    if ($result->num_rows > 0) {
        echo "Error: Ya existe un docente asignado a este nivel.";
    } else {
        // Insertar nuevo docente
        $sql = "INSERT INTO Docente (nombre, usuario, correo, contraseña, nivel_asignado) 
                VALUES ('$nombre_docente', '$usuario_docente', '$correo_docente', '$contraseña_docente', '$nivel_asignado')";
        
        if ($conn->query($sql) === TRUE) {
            echo "Docente agregado con éxito.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Obtener niveles
$niveles = $conn->query("SELECT * FROM Niveles");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Docente</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Agregar Docente</h1>
    <form method="POST" action="">
        <label for="nombre_docente">Nombre:</label>
        <input type="text" name="nombre_docente" required>
        
        <label for="usuario_docente">Usuario:</label>
        <input type="text" name="usuario_docente" required>
        
        <label for="correo_docente">Correo:</label>
        <input type="email" name="correo_docente" required>
        
        <label for="contraseña_docente">Contraseña:</label>
        <input type="password" name="contraseña_docente" required>
        
        <label for="nivel_asignado">Nivel Asignado:</label>
        <select name="nivel_asignado" required>
            <option value="">Seleccionar nivel</option>
            <?php while ($nivel = $niveles->fetch_assoc()): ?>
                <option value="<?php echo $nivel['id_nivel']; ?>"><?php echo $nivel['nombre']; ?></option>
            <?php endwhile; ?>
        </select>
        
        <input type="submit" value="Agregar Docente">
    </form>
    <a href="panel.php">Regresar al Panel</a>
</body>
</html>
