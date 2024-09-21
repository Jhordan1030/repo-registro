<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);  // Encriptar la contraseña
    $rol = $_POST['rol'];

    $sql = "INSERT INTO usuarios (nombre, apellido, correo, contraseña, rol) VALUES (:nombre, :apellido, :correo, :password, :rol)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':apellido', $apellido);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':rol', $rol);
    $stmt->execute();

    header("Location: ../html/login.html");
    exit();
}
?>
