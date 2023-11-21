<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../util/register.css">
</head>

<body>

    <?php
    session_start();
    require './bd.php';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $usuario = $_POST["usuario"];
        $contrasenia = $_POST["contrasenia"];
        $contrasenia = password_hash($contrasenia, PASSWORD_DEFAULT);
        $fechaNacimiento = $_POST["nacimiento"];

        if (strlen($usuario) < 4 || strlen($usuario) > 12 || !preg_match('/^[a-zA-Z_]+$/', $usuario)) {
            die("Error: El nombre de usuario no es válido.");
        }

        $edad = date_diff(date_create($fechaNacimiento), date_create('today'))->y;
        if ($edad < 12 || $edad > 120) {
            die("Error: Debes tener entre 12 y 120 años para registrarte.");
        }

        // Insert user data into the 'usuarios' table
        $sql = "INSERT INTO usuarios (usuario, contrasena, fechaNacimiento) VALUES ('$usuario', '$contrasenia', '$fechaNacimiento')";
        $conn->query($sql);

        // Retrieve the automatically generated ID for the last inserted row
        $idUsuario = $conn->insert_id;

        // Insert a record into the 'cestas' table using the obtained $idUsuario
        $sqlCesta = "INSERT INTO cestas (idCesta, usuario, precioTotal) VALUES ('$idUsuario', '$usuario', 0)";
        $conn->query($sqlCesta);

        header('location: login.php');

    }
    ?>

    <div class="wrapper">
        <form style="padding: 50px;" action="" method="post">
            <h1>Registro</h1>
            <div class="input-box">
                <label class="label_nombre">Usuario:</label>
                <input class="form-control" type="text" name="usuario">
                <br><br>
            </div>
            <div class="input-box">
                <label class="label_nombre">Contraseña:</label>
                <input class="form-control" type="password" name="contrasenia">
            </div>
            <div class="input-box">
                <label class="form-label">Fecha de nacimiento</label>
                <input class="form-control" type="date" name="nacimiento">
            </div>
            <div class="remember-forgot">
                <p>Si tienes cuenta inicia sesión <a href="login.php">aquí</a></p>
            </div>
            <br>
            <input class="btn btn-primary mb-3 boton" type="submit" value="Registrarse">
        </form>
    </div>

</body>

</html>