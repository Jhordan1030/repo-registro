<?php
session_start();
include 'db.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];
$query = "SELECT tipo FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user['tipo'] === 'estudiante') {
    header("Location: panel_estudiante.php");
} elseif ($user['tipo'] === 'docente') {
    header("Location: panel_docente.php");
}

$stmt->close();
$conn->close();
?>
