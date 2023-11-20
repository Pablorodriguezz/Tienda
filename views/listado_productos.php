<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require './bootsrap.php' ?>
    <link rel="stylesheet" href="../util/listado_productos.css">

    <title>Listado productos</title>

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="login.php">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="cesta.php">Cesta</a>
        </li>
        </li>
      </ul>
    </div>
  </div>
</nav>
    <?php
    session_start();
    require './bd.php';
    $usuario = $_SESSION["usuario"];
    echo "<h1>Bienvenid@: " .  $usuario . "</h1>";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los datos del formulario
        $sql = "SELECT idCesta FROM cestas WHERE usuario = '$usuario'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $err = "";
        } else {
            while ($row = $result->fetch_assoc()) {
                $idCesta= $row["idCesta"];
            }

        }


        $cantidad = $_POST['cantidad'];
        $idProducto = $_POST["idProducto"];


        $sqlCest = "INSERT INTO productoscestas (idProducto, idCesta, cantidad) VALUES ('$idProducto', $idCesta, '$cantidad');";
        $conn->query($sqlCest);
    }

    
    if (isset($_SESSION["usuario"])) {
        echo '<a href="./logout.php">Cerrar sesión</a>';

    } else {
        echo '<a href="./login.php">Login</a>';
    }
    if (isset($_SESSION['rol']) && $_SESSION['rol'] == 'admin') {
        // Muestra el botón de "Añadir Producto"
        echo '<a href="producto.php"><button>Subir producto</button></a>';
    }

    

    // Consulta para obtener los nombres de los productos y sus imágenes
    $sql = "SELECT * FROM productos";
    $result = $conn->query($sql);
    echo "<table class='table table-borderless'>";
    echo "<thead class='table-danger'>";
    echo "<tr>";
    echo "<th class='a' scope='col' >id</th>";
    echo "<th class='a' scope='col' >nombre</th>";
    echo "<th class='a' scope='col' >precio</th>";
    echo "<th class='a' scope='col' >descripcion</th>";
    echo "<th class='a' scope='col' >cantidad</th>";
    echo "<th class='a' scope='col' >imagen</th>";
    echo "<th class='a' scope='col' >Añadir Cesta</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td class="b">' . $row["idProducto"] . '</td>';
            echo '<td class="b">' . $row["nombreProducto"] . '</td>';
            echo '<td class="b">' . $row["precio"] . '</td>';
            echo '<td class="b">' . $row["descripcion"] . '</td>';
            echo '<td class="b">' . $row["cantidad"] . '</td>';
            echo '<td class="b"><img src="' . $row["imagen"] . '" alt="' . $row["nombreProducto"] . '" width="100" height="100"></td>';
            ?>
                <td>
                <form action="" method="post">
                    <input type="hidden" name="idProducto" value="<?php echo $row["idProducto"]?>">
                    <input type="number" name="cantidad" id="" min="1" max="5">
                    <input type="submit" value="Añadir a la cesta">
                </form>
                </td>
            <?php
            echo '</tr>';
        }
    } else {
        echo "<li>No hay productos disponibles</li>";
    }

    $conn->close();



    ?>
</head>

<body>




</body>

</html>