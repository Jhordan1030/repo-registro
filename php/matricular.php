<?php
session_start();
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_estudiante = $_SESSION['usuario']['id_usuario'];
    $id_asignatura = $_POST['materia'];

    $sql = "INSERT INTO inscripciones (id_estudiante, id_asignatura) VALUES (:id_estudiante, :id_asignatura)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_estudiante', $id_estudiante);
    $stmt->bindParam(':id_asignatura', $id_asignatura);
    
    if ($stmt->execute()) {
        echo "Matriculación exitosa.";
    } else {
        echo "Error en la matriculación.";
    }
}
?>
