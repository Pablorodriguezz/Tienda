<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require './bootsrap.php' ?>
    <link rel="stylesheet" href="./css/login.css">

    <title>Document</title>

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

        $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
        $resultado = $conexion->query($sql);

        if ($resultado->num_rows === 0) {
            echo "El usuario/contraseña son incorrectos";
        } else {

            while ($fila = $resultado->fetch_assoc()) { //coje una tabla y cada fila la transforma en una array
                $password_cifrada = $fila["contrasena"];
            }

            $acceso_valido = password_verify($contrasenia, $password_cifrada);

            if ($acceso_valido) {
                session_start();
                $_SESSION["usuario"] = $usuario;
                header('location: producto.php');
            } else {
                echo "El usuario/contraseña son incorrectos";
            }
        }

        if ($acceso_valido) {
            $_SESSION["usuario"] = $usuario;
            $usuario = $_SESSION["usuario"];
            $_SESSION["rol"] = $rol;
            // Verificar si el usuario ya tiene una cesta
            $sql_check_cesta = "SELECT * FROM cestas WHERE usuario = '$usuario'";
            $result_check_cesta = $conexion->query($sql_check_cesta);
      
            if ($result_check_cesta->num_rows == 0) {
              // El usuario no tiene una cesta, por lo tanto, se crea una cesta vacía
              $sql_crear_cesta = "INSERT INTO cestas (usuario) VALUES ('$usuario')";
              if ($conexion->query($sql_crear_cesta) === TRUE) {
                echo "Se ha adjuntado una cesta vacía al iniciar sesión.";
              } else {
                echo "Error al crear la cesta: " . $conexion->error;
              }
            }
            header('location: listado_productos.php');
          } else {
            $error = "El usuario/contraseña son incorrectos";
          }
        }
    
    ?>
    <div class="intro">
        <div style="padding-right: 3em;">

            <img src="./img/amazom.jpg" alt="" width="400px">
        </div>
        <form action="" method="post" style="border-left: 2px solid #FF9900; padding-left:3em">
            <div class="caja">
                <h3 class="h3_login">Ingrese su cuenta</h3>
                <div class="cajaInterna">
                <label class="label_nombre">Usuario:</label>
                <input class="form-control" type="text" name="usuario">
                <?php if (isset($err_usuario)) echo $err_usuario ?>
                <br><br>
                <label class="label_nombre">Contraseña:</label>
                <input class="form-control" type="password" name="contrasenia">
                </div>
            </div>
            <br><br>
            <?php if (isset($err_fecha)) echo $err_fecha ?>
            <input class="btn btn-primary mb-3" type="submit" value="enviar">
        </form>
    </div>



</body>

</html>