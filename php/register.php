<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $tipo = $_POST['tipo'];
    $contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);

    $query = "INSERT INTO usuarios (email, nombre, apellido, tipo, contraseña) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssss", $email, $nombre, $apellido, $tipo, $contraseña);

    if ($stmt->execute()) {
        echo "Usuario registrado con éxito.";
    } else {
        echo "Error al registrar: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Usuario</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <form action="" method="POST">
        <input type="text" name="nombre" required placeholder="Nombre">
        <input type="text" name="apellido" required placeholder="Apellido">
        <input type="email" name="email" required placeholder="Correo electrónico">
        <select name="tipo" required>
            <option value="estudiante">Estudiante</option>
            <option value="docente">Docente</option>
        </select>
        <input type="password" name="contraseña" required placeholder="Contraseña">
        <button type="submit" href="login.php">Registrar</button>
    </form>
</body>
</html>
