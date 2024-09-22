<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
</head>
<body>
    <h1>Registro de Usuario</h1>
    <form action="process_register.php" method="post">
        <label for="tipo">Tipo de usuario:</label>
        <select name="tipo" id="tipo">
            
            <option value="docente">Docente</option>
            <option value="estudiante">Estudiante</option>
        </select><br>

        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" required><br>

        <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" id="usuario"><br>

        <label for="correo">Correo:</label>
        <input type="email" name="correo" id="correo" required><br>

        <label for="contraseña">Contraseña:</label>
        <input type="password" name="contraseña" id="contraseña" required><br>

        <label for="nivel">Nivel:</label>
        <input type="text" name="nivel" id="nivel"><br>

        <input type="submit" value="Registrar">
    </form>
</body>
</html>
