<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../util/crearproducto.css">
    <?php require './bootsrap.php' ?>
</head>

<body>
    <?php
    session_start();
    require './bd.php';
    if ($_SESSION["rol"] != 'admin') {
        header('location: listado_productos.php');
    }

    $error = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los datos del formulario
        $nombre = $_POST['nombre'];
        $precio = floatval($_POST['precio']);
        $descripcion = $_POST['descripcion'];
        $cantidad = $_POST['cantidad'];

        if (strlen($nombre) > 40) {
            $error = "Error: El nombre del producto debe tener como máximo 40 caracteres.";
        }

        if ($precio < 0 || $precio > 99999.99) {
            $error = "Error: El precio no está entre 0 y 99999.99.";
        }

        if (strlen($descripcion) > 255) {
            $error = "Error: La descripción debe tener como máximo 255 caracteres.";
        }

        if ($cantidad < 0 || $cantidad > 99999) {
            $error = "Error: La cantidad debe estar entre 0 y 99999.";
        }

        if (empty($error)) {
            $nombre_fichero = $_FILES["imagen"]["name"];
            $ruta_temporal = $_FILES["imagen"]["tmp_name"];
            $formato = $_FILES["imagen"]["type"];
            $ruta_final = "../util/img" . $nombre_fichero;

            move_uploaded_file($ruta_temporal, $ruta_final);

            $sql = "INSERT INTO Productos (nombreProducto, precio, descripcion, cantidad, imagen) VALUES ('$nombre', $precio, '$descripcion', $cantidad, '$ruta_final')";

            if ($conn->query($sql) === TRUE) {
                echo "Producto añadido con éxito";
            } else {
                echo "Error al añadir producto: " . $conn->error;
            }
        }
    }

    $conn->close();
    ?>

    <div class="hola">
        <h1>Formulario para crear un nuevo producto</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <label class="form-label">Nombre del producto:</label>
            <input class="form-control" type="text" name="nombre"><br><br>
            <label class="form-label">Precio:</label>
            <input class="form-control" name="precio"><br><br>
            <label class="form-label">Descripción:</label>
            <input class="form-control" type="text" name="descripcion"><br><br>
            <label class="form-label" for="">Cantidad</label>
            <input class="form-control" type="number" name="cantidad"><br><br>
            <label class="form-label">Imagen</label>
            <input class="form-control" type="file" name="imagen"><br><br>
            <input class="btn btn-primary mb-3" type="submit" value="Enviar">
        </form>
        <a href="listado_productos.php">
            <button type="button" class="btn btn-light">Ir a listado productos</button>
        </a>
        <?php
        if (!empty($error)) {
            echo "<div class='alert alert-danger' role='alert'>$error</div>";
        }
        ?>
    </div>

</body>

</html>
