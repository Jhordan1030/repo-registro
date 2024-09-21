<?php
include 'conexion.php';

// Consulta para obtener la lista de estudiantes y sus materias
$sql = "SELECT u.nombre, u.apellido, a.nombre_asignatura
        FROM inscripciones i
        JOIN usuarios u ON i.id_estudiante = u.id_usuario
        JOIN asignaturas a ON i.id_asignatura = a.id_asignatura";

$stmt = $conn->prepare($sql);
$stmt->execute();

// Verificar si hay estudiantes
if ($stmt->rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['nombre']) . "</td>";
        echo "<td>" . htmlspecialchars($row['apellido']) . "</td>";
        echo "<td>" . htmlspecialchars($row['nombre_asignatura']) . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='3'>No hay estudiantes registrados.</td></tr>";
}
?>
