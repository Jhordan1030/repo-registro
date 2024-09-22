<?php
session_start();
include 'db.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $materia_id = $_POST['materia_id'];
    $email = $_POST['email'];
    $parcial1 = $_POST['parcial1'];
    $parcial2 = $_POST['parcial2'];

    // Calcular el promedio
    $promedio = ($parcial1 + $parcial2) / 2;

    // Verificar que el estudiante está matriculado en la materia
    $query_matricula = "SELECT * FROM matriculas WHERE materia_id = ? AND estudiante_email = ?";
    $stmt_matricula = $conn->prepare($query_matricula);
    $stmt_matricula->bind_param("is", $materia_id, $email);
    $stmt_matricula->execute();
    $result_matricula = $stmt_matricula->get_result();

    if ($result_matricula->num_rows > 0) {
        // Insertar o actualizar las notas
        $query_notas = "INSERT INTO notas (materia_id, estudiante_email, parcial1, parcial2, final) VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE parcial1 = ?, parcial2 = ?, final = ?";
        $stmt_notas = $conn->prepare($query_notas);
        
        // Asignar correctamente los tipos de datos
        $stmt_notas->bind_param("isiiiiid", $materia_id, $email, $parcial1, $parcial2, $promedio, $parcial1, $parcial2, $promedio);
        
        if ($stmt_notas->execute()) {
            echo "Notas subidas con éxito.";
        } else {
            echo "Error al subir las notas: " . $stmt_notas->error;
        }
    } else {
        echo "El estudiante no está matriculado en esta materia.";
    }

    $stmt_matricula->close();
    $stmt_notas->close();
}

$conn->close();
?>
