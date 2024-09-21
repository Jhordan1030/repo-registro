<?php
$host = 'localhost';  // Cambia si es necesario
$dbname = 'registro_notas';  // Nombre de la base de datos
$username = 'root';  // Usuario de MySQL
$password = '';  // Contraseña de MySQL (cambia si es necesario)

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Conexión fallida: " . $e->getMessage();
}
?>
