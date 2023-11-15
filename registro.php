<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php require './bootsrap.php' ?>

</head>

<body>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $_servidor = 'localhost';
        $_usuario = 'root';
        $_contrasena = 'medac';
        $_base_de_datos = 'amazon';

        $conexion = new Mysqli(
            $_servidor,
            $_usuario,
            $_contrasena,
            $_base_de_datos
        )
            or die("Error de conexión");

        //
        $usuario = $_POST["usuario"];
        $contrasenia = $_POST["contrasenia"];
        $contrasenia = password_hash($contrasenia, PASSWORD_DEFAULT);
        $fechaNacimiento = $_POST["nacimiento"];


        if (
            isset($usuario) && isset($contrasenia)
            && isset($fechaNacimiento)
        ) {

            //introduce datos en la base de datos
            $sql = "INSERT INTO usuarios (usuario,contrasena, fechaNacimiento)
                VALUES ('$usuario', '$contrasenia', '$fechaNacimiento')";

            $conexion->query($sql);
        }
    }
    ?>
    <div class="mb-3" style="margin: 100px 300px; border:5px solid black">
        <h1 style="background-color: black; color:white;  text-align: center; padding:20px;">Formulario para crear un nuevo Usuario</h1>
        <form style="padding: 50px;" action="" method="post">
            <label class="form-label">Usuario:</label>
            <input class="form-control" type="text" name="usuario">
            <?php if (isset($err_usuario)) echo $err_usuario ?>
            <br><br>
            <label class="form-label">Contraseña:</label>
            <input class="form-control" type="password" name="contrasenia">
            <br><br>
            <label class="form-label">Fecha de nacimiento</label>
            <input class="form-control" type="date" name="nacimiento"><br>
            <?php if (isset($err_fecha)) echo $err_fecha ?>
            <input class="btn btn-primary mb-3" type="submit" value="enviar">
        </form>
    </div>



</body>

</html>