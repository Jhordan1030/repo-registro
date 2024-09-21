<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_asignatura = $_POST['nombre_asignatura'];

    $sql = "SELECT e.nombre, e.apellido, n.calificacion, n.fecha_registro
            FROM notas n
            JOIN inscripciones i ON n.id_inscripcion = i.id_inscripcion
            JOIN asignaturas a ON i.id_asignatura = a.id_asignatura
            JOIN usuarios e ON i.id_estudiante = e.id_usuario
            WHERE a.nombre_asignatura = :nombre_asignatura";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nombre_asignatura', $nombre_asignatura);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        echo "<h2>Notas para la Asignatura: $nombre_asignatura</h2>";
        echo "<table border='1'>
                <tr>
                    <th>Nombre del Estudiante</th>
                    <th>Calificación</th>
                    <th>Fecha de Registro</th>
                </tr>";
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row['nombre'] . " " . $row['apellido'] . "</td>";
            echo "<td>" . $row['calificacion'] . "</td>";
            echo "<td>" . $row['fecha_registro'] . "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
    } else {
        echo "<p>No se encontraron notas para la asignatura: $nombre_asignatura.</p>";
    }
}
?>
