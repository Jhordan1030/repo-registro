<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE correo = :correo";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':correo', $correo);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['contraseña'])) {
        if ($user['rol'] == 'docente') {
            header("Location: ../html/docente_panel.html");
        } else {
            header("Location: ../html/estudiante_panel.html");
        }
        exit();
    } else {
        echo "Correo o contraseña incorrectos.";
    }
}
?>
