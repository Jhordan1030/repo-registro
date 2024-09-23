<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $contraseña = md5($_POST['contraseña']); // Hasheamos la contraseña

    $sql = "SELECT * FROM Administrador WHERE correo='$correo' AND contraseña='$contraseña'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['usuario'] = $correo; // Guardar el correo en la sesión
        header("Location: panel.php"); // Redirigir al panel
        exit();
    } else {
        echo "Correo o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio de Sesión</title>
</head>
<body>
    <form method="POST" action="">
        <label for="correo">Correo:</label>
        <input type="email" name="correo" required>
        <br>
        <label for="contraseña">Contraseña:</label>
        <input type="password" name="contraseña" required>
        <br>
        <input type="submit" value="Iniciar Sesión">
    </form>
</body>
</html>
