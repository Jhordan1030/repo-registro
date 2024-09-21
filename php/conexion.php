<?php
$host = 'localhost';
$dbname = 'registro_notas';
$user = 'root'; // Cambia esto si tienes otro usuario
$password = ''; // Cambia esto si tienes otra contraseña

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>
