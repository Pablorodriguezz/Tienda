<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../util/producto.css">
    <?php require './bootsrap.php' ?>
</head>

<body>
    <?php
    session_start();
    require './bd.php';
    if ($_SESSION["rol"] != 'admin') {
        header('location: listado_productos.php');
    }




    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los datos del formulario
        $nombre = $_POST['nombre'];
        $precio = floatval($_POST['precio']);
        $descripcion = $_POST['descripcion'];
        $cantidad = $_POST['cantidad'];


        if (strlen($nombre) > 40) {
            die("Error: El nombre del producto debe tener como máximo 40 caracteres.");
        }

        if ($precio < 0 || $precio > 99999.99) {
            $error = '<div class="alert alert-primary" role="alert">
            El precio no esta entre 0 y 99999.99.
            </div>';
        }


        if (strlen($descripcion) > 255) {
            die("Error: La descripción debe tener como máximo 255 caracteres.");
        }

        if ($cantidad < 0 || $cantidad > 99999) {
            die("Error: La cantidad debe estar entre 0 y 99999.");
        }


        $nombre_fichero = $_FILES["imagen"];
        $nombre_fichero = $nombre_fichero['name'];
        $ruta_termporal = $_FILES["imagen"]["tmp_name"];
        $formato = $_FILES["imagen"]["type"];
        $ruta_final = "../util/img" . $nombre_fichero;

        move_uploaded_file(
            $ruta_termporal,
            $ruta_final
        );

        $sql = "INSERT INTO Productos (nombreProducto, precio, descripcion, cantidad,imagen) VALUES ('$nombre', $precio, '$descripcion', $cantidad,'$ruta_final')";

        if ($conn->query($sql) == TRUE) {
            echo "producto añadido con exito";
        } else {
            echo "error al añadir producto";
        }


        // Añadir Cesta
    
        $sql = "INSERT INTO usuarios (usuario, contrasena, fechaNacimiento) VALUES ('$usuario', '$contrasena', '$fechaNacimiento')";
            $conn->query($cestaSql);
            
            

            // Inserción en la tabla 'cestas'
            $cestaSql = "INSERT INTO cestas ( usuario, precioTotal) VALUES ( '$usuario', 0)";
            $conn->query($cestaSql);
            
    


    }


    $conn->close();
    ?>

    <div class="hola">
        <h1>Formulario para crear un nuevo producto</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <label class="form-label">Nombre del producto:</label>
            <input class="form-control" type="text" name="nombre">
            <?php if (isset($err_usuario))
                echo $err_usuario ?>
                <br><br>
                <label class="form-label">Precio:</label>
                <input class="form-control" name="precio">
            <?php if (isset($err_nombre))
                echo $err_nombre ?>
                <br><br>
                <label class="form-label">Descripción:</label>
                <input class="form-control" type="text" name="descripcion">
            <?php if (isset($err_apellido))
                echo $err_apellido ?>
                <br><br>
                <label class="form-label" for="">Cantidad</label>
                <input class="form-control" type="number" name="cantidad"><br>
                <label class="form-label">Imagen</label>
                <input class="form-control" type="file" name="imagen">
                <input class="btn btn-primary mb-3" type="submit" value="enviar">
            </form>
        <a href="listado_productos.php">
            <button type="button" class="btn btn-light">Ir a listado productos</button>
        </a>
    </div>

    </body>

    </html>