<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_estudiante = $_POST['id_estudiante'];
    $id_asignatura = $_POST['id_asignatura'];
    $calificacion = $_POST['calificacion'];

    $sql = "INSERT INTO notas (id_inscripcion, calificacion) 
            SELECT id_inscripcion, :calificacion 
            FROM inscripciones 
            WHERE id_estudiante = :id_estudiante AND id_asignatura = :id_asignatura";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_estudiante', $id_estudiante);
    $stmt->bindParam(':id_asignatura', $id_asignatura);
    $stmt->bindParam(':calificacion', $calificacion);
    $stmt->execute();

    echo "Nota subida correctamente.";
}
?>
