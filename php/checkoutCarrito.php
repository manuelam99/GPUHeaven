<!DOCTYPE html>
<?php
// Start the session
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
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
    <link type="text/css" rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <title>GPU Heaven</title>
</head>

<?php

require_once "./coneccion.php";

$id_usr = $_SESSION["id"];

$query = "SELECT p.nom_producto AS nombre, p.prec_producto AS precio, c.cantidad_producto AS cantidad, p.id_producto AS id_prod, 
                                                p.fotos_producto AS ruta_f, p.stock_producto AS stock  
          FROM carrito c, productos p 
          WHERE p.id_producto = c.id_producto AND c.id_usuario = '" . $id_usr . "';";

$result = mysqli_query($con, $query);

$articulos = mysqli_num_rows($result);

$contenidoCarrito = "";
$subtotal = 0.0;
$sqlInsert = "INSERT INTO transacciones (id_producto, id_usuario, cantidad, precio) VALUES";
$sqlUpdate = "";

while ($row = mysqli_fetch_array($result)) {
    $dir = $row['ruta_f'] . '/';
    $fotos = array_slice(scandir('../images/' . $dir), 2);

    $contenidoCarrito .= '<hr>';

    $contenidoCarrito .= '<div class="row align-items-center justify-content-center">';
    $contenidoCarrito .= '<div class="col-lg-6">';
    $contenidoCarrito .= '<img src="../images/' . $dir . $fotos[0] . '" alt="Imagen" class="imagen-fluid">';
    $contenidoCarrito .= '</div>';
    $contenidoCarrito .= '<div class="col-lg-6">';
    $contenidoCarrito .= '<h4>' . $row['nombre'] . '</h4>
                          <p>$' . number_format($row['precio']) . '</p>
                          <p>Unidades: ' . $row['cantidad'] . '</p>';
    $contenidoCarrito .= '</div>';
    $contenidoCarrito .= '</div>';
    $contenidoCarrito .= '<hr>';
    $subtotal += $row['precio'] * $row['cantidad'];

    $sqlInsert .= "(" . $row['id_prod'] . ", " . $id_usr . ", " . $row['cantidad'] . ", " . $row['precio'] * $row['cantidad'] . "),";
    $sqlUpdate .= "UPDATE productos SET stock_producto = stock_producto - " . $row['cantidad'] . " WHERE id_producto = " . $row['id_prod'] . ";";
}

$sqlInsert = rtrim($sqlInsert, ',');
$sqlInsert .= ";";


mysqli_close($con);
?>

<body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <!-- Brand -->
        <a class="navbar-brand" href="../index.php">
        <i class="fas fa-desktop mr-1"></i>GPUH
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Links -->
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
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

                <li class="nav-item d-flex align-items-center">
                    <a href="./carrito.php">
                        <i class="fas fa-shopping-cart text-white"></i>
                        <?php echo ($articulos > 0) ? '<span class="badge badge-danger rounded-circle">' . $articulos . '</span>' : '' ?>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-3">
        <?php echo (!empty($contenidoCarrito)) ? $contenidoCarrito : "<h2>Carrito Vacio</h2>"; ?>
        <div class="row align-items-center justify-content-center my-5">
            <div class="col-lg-6">
                <h5 class="display-4 text-center">Total: $<?php echo number_format($subtotal); ?></h5>
            </div>
            <div class="col-lg-6 text-center">
                <form action="./compra.php" method="post">
                    <input type="text" name="sqlU" class="d-none" value="<?php echo $sqlUpdate ?>" readonly>
                    <button type="submit" class="btn btn-success" name="sqlI" value="<?php echo $sqlInsert ?>">Confirmar Compra</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>