<!DOCTYPE html>
<?php
// Start the session
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ./login.php");
    exit;
}

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="../open-iconic-master/open-iconic-master/font/css/open-iconic-bootstrap.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="../css/main.css">
    <title>GPU Heaven</title>
</head>

<?php

require_once "./coneccion.php";

$id_usr = $_SESSION["id"];

$query = "SELECT p.nom_producto AS nombre, p.prec_producto AS precio, c.cantidad_producto AS cantidad, 
                                                p.fotos_producto AS ruta_f, p.stock_producto AS stock  
          FROM carrito c, productos p 
          WHERE p.id_producto = c.id_producto AND c.id_usuario = '" . $id_usr . "';";

$result = mysqli_query($con, $query);

$contenidoCarrito = "";
$subtotal = 0.0;

while ($row = mysqli_fetch_array($result)) {
    $dir = $row['ruta_f'] . '/';
    $fotos = array_slice(scandir('../images/' . $dir), 2);

    $contenidoCarrito .= '<hr>';

    $contenidoCarrito .= '<div class="row align-items-center justify-content-center">';
    $contenidoCarrito .= '<div class="col-lg-4">';
    $contenidoCarrito .= '<img src="../images/' . $dir . $fotos[0] . '" alt="Imagen" class="imagen-fluid">';
    $contenidoCarrito .= '</div>';
    $contenidoCarrito .= '<div class="col-lg-4">';
    $contenidoCarrito .= '<h4>' . $row['nombre'] . '</h4>
                          <p>$' . number_format($row['precio']) . '</p>
                          <p>Unidades: ' . $row['cantidad'] . '</p>';
    $contenidoCarrito .= '</div>';
    $contenidoCarrito .= '<div class="col-lg-4">';
    $contenidoCarrito .= '<button type="button" class="btn btn-danger">Eliminar</button>';
    $contenidoCarrito .= '</div>';
    $contenidoCarrito .= '</div>';

    $contenidoCarrito .= '<hr>';
    $subtotal += $row['precio']*$row['cantidad'];
}

mysqli_close($con);
?>

<body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <!-- Brand -->
        <a class="navbar-brand" href="../index.php">
            <span class="oi oi-monitor text-light mr-1" title="Cart" aria-hidden="true"></span>GPUH
        </a>

        <!-- Links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="../index.php">Inicio</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="./tienda.php">Compra</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="./usuario.php">Usuario</a>
            </li>
        </ul>
        <div class="nav navbar-nav">
            <a href="./carrito.php"><span class="oi oi-cart text-light" title="Cart" aria-hidden="true"></span></a>
        </div>
    </nav>

    <div class="container mt-3">
        <?php echo (!empty($contenidoCarrito)) ? $contenidoCarrito : "<h2>Carrito Vacio</h2>"; ?>
        <h5 class="display-4">Subtotal: $<?php echo number_format($subtotal); ?></h5>
    </div>

</body>

</html>