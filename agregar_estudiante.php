<?php
session_start();
include 'config.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php"); // Redirigir si no está autenticado
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_estudiante = $_POST['nombre_estudiante'];
    $usuario_estudiante = $_POST['usuario_estudiante'];
    $correo_estudiante = $_POST['correo_estudiante'];
    $contraseña_estudiante = md5($_POST['contraseña_estudiante']);
    $nivel_matricula = $_POST['nivel_matricula'];

    $sql = "INSERT INTO Estudiante (nombre, usuario, correo, contraseña, nivel_matricula) 
            VALUES ('$nombre_estudiante', '$usuario_estudiante', '$correo_estudiante', '$contraseña_estudiante', '$nivel_matricula')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Estudiante agregado con éxito.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Obtener niveles
$niveles = $conn->query("SELECT * FROM Niveles");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Estudiante</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Agregar Estudiante</h1>
    <form method="POST" action="">
        <label for="nombre_estudiante">Nombre:</label>
        <input type="text" name="nombre_estudiante" required>
        
        <label for="usuario_estudiante">Usuario:</label>
        <input type="text" name="usuario_estudiante" required>
        
        <label for="correo_estudiante">Correo:</label>
        <input type="email" name="correo_estudiante" required>
        
        <label for="contraseña_estudiante">Contraseña:</label>
        <input type="password" name="contraseña_estudiante" required>
        
        <label for="nivel_matricula">Nivel de Matrícula:</label>
        <select name="nivel_matricula" required>
            <option value="">Seleccionar nivel</option>
            <?php while ($nivel = $niveles->fetch_assoc()): ?>
                <option value="<?php echo $nivel['id_nivel']; ?>"><?php echo $nivel['nombre']; ?></option>
            <?php endwhile; ?>
        </select>
        
        <input type="submit" value="Agregar Estudiante">
    </form>
    <a href="panel.php">Regresar al Panel</a>
</body>
</html>
