<?php
session_start();
include 'db.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_SESSION['email'];
    $materia_id = $_POST['materia_id'];

    // Verificar si el estudiante ya está matriculado en esta materia
    $query_verificacion = "SELECT * FROM matriculas WHERE estudiante_email = ? AND materia_id = ?";
    $stmt_verificacion = $conn->prepare($query_verificacion);
    $stmt_verificacion->bind_param("si", $email, $materia_id);
    $stmt_verificacion->execute();
    $result_verificacion = $stmt_verificacion->get_result();

    if ($result_verificacion->num_rows > 0) {
        // Ya está matriculado en esta materia
        echo "Ya estás matriculado en esta materia.";
    } else {
        // Insertar en la tabla de matriculas
        $query = "INSERT INTO matriculas (estudiante_email, materia_id) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $email, $materia_id);

        if ($stmt->execute()) {
            echo "Matriculación exitosa.";
        } else {
            echo "Error al matricularse: " . $conn->error;
        }

        $stmt->close();
    }

    $stmt_verificacion->close();
}

$conn->close();
header("Location: panel_estudiante.php");
exit();
?>
