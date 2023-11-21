<link rel="stylesheet" href="../util/cesta.css">
<?php require './bootsrap.php' ?>
<?php
session_start();
require './bd.php';

// Retrieve the cesta information based on the user
$usuario = $_SESSION["usuario"];
$sql = "SELECT * FROM cestas WHERE usuario = '$usuario'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $idCesta = $row["idCesta"];

    // Retrieve the products added to the cesta
    $sqlProducts = "SELECT p.idProducto, p.nombreProducto, pc.cantidad, p.precio
                    FROM productoscestas pc
                    INNER JOIN productos p ON pc.idProducto = p.idProducto
                    WHERE pc.idCesta = '$idCesta'";
    $resultProducts = $conn->query($sqlProducts);
    echo '<a href="listado_productos.php"><button>Volver a listado productos</button></a>';
    if ($resultProducts->num_rows > 0) {
        echo "<h1>Cesta de Compra</h1>";
        echo "<table border='1'>";
        echo "<tr><th>Producto</th><th>Cantidad</th><th>Precio Unitario</th><th>Precio Total</th></tr>";

        $totalCesta = 0;

        while ($rowProduct = $resultProducts->fetch_assoc()) {
            $producto = $rowProduct["nombreProducto"];
            $cantidad = $rowProduct["cantidad"];
            $precioUnitario = $rowProduct["precio"];
            $precioTotal = $cantidad * $precioUnitario;

            echo "<tr>";
            echo "<td>$producto</td><td>$cantidad</td><td>$precioUnitario</td><td>$precioTotal</td>";
            echo "</tr>";

            $totalCesta += $precioTotal;
        }

        echo "</table>";

        // Display the total price for the entire cesta
        echo "<p>Total de la Cesta: $totalCesta</p>";
    } else {
        echo "<p>No hay productos en la cesta.</p>";
    }
} else {
    echo "<p>No se encontró la cesta del usuario.</p>";
}

$conn->close();
?>
