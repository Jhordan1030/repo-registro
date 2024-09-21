<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_estudiante = $_POST['id_estudiante'];

    // Consulta para obtener las notas del estudiante
    $sql = "SELECT a.nombre_asignatura, n.calificacion, n.fecha_registro
            FROM notas n
            JOIN inscripciones i ON n.id_inscripcion = i.id_inscripcion
            JOIN asignaturas a ON i.id_asignatura = a.id_asignatura
            WHERE i.id_estudiante = :id_estudiante";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_estudiante', $id_estudiante);
    $stmt->execute();
    
    // Verificar si el estudiante tiene notas
    if ($stmt->rowCount() > 0) {
        echo "<h2>Notas del Estudiante</h2>";
        echo "<table border='1'>
                <tr>
                    <th>Asignatura</th>
                    <th>Calificación</th>
                    <th>Fecha de Registro</th>
                </tr>";
        
        // Mostrar cada nota obtenida
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row['nombre_asignatura'] . "</td>";
            echo "<td>" . $row['calificacion'] . "</td>";
            echo "<td>" . $row['fecha_registro'] . "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
    } else {
        echo "<p>No se encontraron notas para este estudiante.</p>";
    }
}
?>
