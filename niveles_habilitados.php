<?php
include 'config.php';

// Consulta para obtener los niveles con matrículas habilitadas
$niveles_habilitados = $conn->query("SELECT n.nombre FROM Niveles n
                                      JOIN Matriculas m ON n.id_nivel = m.id_nivel
                                      WHERE m.estado = 'habilitada'");

if ($niveles_habilitados && $niveles_habilitados->num_rows > 0) {
    while ($row = $niveles_habilitados->fetch_assoc()) {
        echo "<li>" . $row['nombre'] . "</li>";
    }
} else {
    echo "<li>No hay niveles con matrículas habilitadas.</li>";
}
?>
