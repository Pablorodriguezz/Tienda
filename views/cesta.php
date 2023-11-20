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
    session_start();
    require './bd.php';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los datos del formulario
        $idProducto = $_POST['nombre'];
        $idCesta = floatval($_POST['idCesta']);
        $cantidad = $_POST['cantidad'];
        
    $sql = "INSERT INTO ProductosCestas (nombreProducto, idCesta, cantidad) VALUES ('$nombre', $idCesta, $cantidad,'$ruta_final')";

    if ($conn->query($sql) == TRUE) {
        echo "producto añadido con exito";
    } else {
        echo "error al añadir producto";
    }



// Insertar los datos en la tabla "Productos"
    }

$conn->close();
    ?>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        </li>
      </ul>
    </div>
  </div>
</nav>
</body>
</html>