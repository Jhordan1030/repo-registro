<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $contraseña = password_hash($_POST['contraseña'], PASSWORD_BCRYPT);
    $rol = $_POST['rol'];

    $sql = "INSERT INTO usuarios (nombre, apellido, correo, contraseña, rol) VALUES (:nombre, :apellido, :correo, :contraseña, :rol)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':apellido', $apellido);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':contraseña', $contraseña);
    $stmt->bindParam(':rol', $rol);
    
    if ($stmt->execute()) {
        echo "Registro exitoso.";
    } else {
        echo "Error en el registro.";
    }
}
?>
