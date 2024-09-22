<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo = $_POST['tipo'];
    $nombre = $_POST['nombre'];
    $usuario = $_POST['usuario'];
    $correo = $_POST['correo'];
    $contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);
    $nivel = $_POST['nivel'];

    try {
        if ($tipo == 'docente') {
            $sql = "INSERT INTO Docente (nombre, usuario, correo, contraseña, nivel_asignado) VALUES (?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nombre, $usuario, $correo, $contraseña, $nivel]);
        } elseif ($tipo == 'estudiante') {
            $sql = "INSERT INTO Estudiante (nombre, usuario, correo, contraseña, nivel_matricula) VALUES (?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nombre, $usuario, $correo, $contraseña, $nivel]);
        }

        echo "Registro exitoso!";
    } catch (PDOException $e) {
        echo "Error al registrar: " . $e->getMessage();
    }
}
?>
