<?php
session_start();
include 'db.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];

// Verificar si el docente está autenticado
$query_docente = "SELECT * FROM usuarios WHERE email = ? AND tipo = 'docente'";
$stmt_docente = $conn->prepare($query_docente);
$stmt_docente->bind_param("s", $email);
$stmt_docente->execute();
$result_docente = $stmt_docente->get_result();

if ($result_docente->num_rows == 0) {
    echo "Acceso no autorizado.";
    exit();
}

// Obtener materias
$query_materias = "SELECT * FROM materias";
$result_materias = $conn->query($query_materias);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Subir Notas</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
        }
        h2 {
            text-align: center;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input[type="number"], input[type="email"], select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #28a745;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #218838;
        }
        a {
            display: block;
            margin-top: 20px;
            text-align: center;
            color: #007bff;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Subir Notas</h2>
        <form action="ingresar_notas.php" method="POST" id="form-notas">
            <label for="materia">Selecciona una materia:</label>
            <select name="materia_id" required>
                <?php while ($materia = $result_materias->fetch_assoc()): ?>
                    <option value="<?= $materia['id'] ?>"><?= $materia['nombre'] ?></option>
                <?php endwhile; ?>
            </select>

            <label for="email">Correo del Estudiante:</label>
            <input type="email" name="email" required>

            <label for="parcial1">Nota Parcial 1:</label>
            <input type="number" name="parcial1" min="0" max="10" required id="parcial1">

            <label for="parcial2">Nota Parcial 2:</label>
            <input type="number" name="parcial2" min="0" max="10" required id="parcial2">

            <label for="promedio">Promedio:</label>
            <input type="text" name="promedio" readonly id="promedio">

            <button type="submit">Subir Notas</button>
        </form>

        <script>
            const parcial1Input = document.getElementById('parcial1');
            const parcial2Input = document.getElementById('parcial2');
            const promedioInput = document.getElementById('promedio');

            function calcularPromedio() {
                const parcial1 = parseFloat(parcial1Input.value) || 0;
                const parcial2 = parseFloat(parcial2Input.value) || 0;
                const promedio = (parcial1 + parcial2) / 2;
                promedioInput.value = promedio.toFixed(2); // Mostrar dos decimales
            }

            parcial1Input.addEventListener('input', calcularPromedio);
            parcial2Input.addEventListener('input', calcularPromedio);
        </script>

        <a href="panel_docente.php">Regresar</a>
    </div>
</body>
</html>

<?php
$stmt_docente->close();
$conn->close();
?>
