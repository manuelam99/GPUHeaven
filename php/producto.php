<!DOCTYPE html>
<?php
// Start the session
session_start();
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
$queryCarrito = "SELECT id_usuario from carrito WHERE id_usuario = '" . $id_usr . "';";

$resultQueryCarrito = mysqli_query($con, $queryCarrito);
$articulos = mysqli_num_rows($resultQueryCarrito);

$query = "SELECT * FROM productos WHERE id_producto ='" . $_POST['prod'] . "'";

$result = mysqli_query($con, $query);

$producto = mysqli_fetch_row($result);

$stock = $producto[5];

mysqli_close($con);

$dir = $producto[3] . '/';
$fotos = array_slice(scandir('../images/' . $dir), 2);
$carousel = "";

foreach ($fotos as $llave => $foto) {
    if ($llave == 0) {
        $carousel .= '<div class="carousel-item active">';
    } else {
        $carousel .= '<div class="carousel-item">';
    }
    $carousel .= '<img src="../images/' . $dir . $foto . '" class="img-fluid mx-auto d-block" alt="Image">';
    $carousel .= '</div>';
}

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

    <div class="container-fluid">
        <div class="row align-items-center">
            <div id="demo" class="carousel slide col-lg-6" data-interval="false" data-ride="carousel">

                <!-- Indicators -->
                <ul class="carousel-indicators">
                    <li data-target="#demo" data-slide-to="0" class="active"></li>
                    <li data-target="#demo" data-slide-to="1"></li>
                    <li data-target="#demo" data-slide-to="2"></li>
                </ul>

                <!-- The slideshow -->
                <div class="carousel-inner">
                    <?php echo $carousel ?>
                </div>

                <!-- Left and right controls -->
                <a class="carousel-control-prev" href="#demo" data-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </a>
                <a class="carousel-control-next" href="#demo" data-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </a>

            </div>
            <div class="col-lg-6">
                <h2><?php echo $producto[1] ?></h2>
                <p><?php echo $producto[2] ?></p>
                <p>Precio: $<?php echo number_format($producto[4]) ?></p>
                <p>Stock: <?php echo $producto[5] ?></p>
                <div class="container d-flex justify-content-center">
                    <form action="./agregarACarrito.php" method="post" class="mx-5">
                        <button type="submit" name="prod" value="<?php echo $_POST['prod'] ?>" class="btn btn-outline-primary" <?php echo ($stock < 1) ? "disabled" : "" ?>>Agregar a Carrito</button>
                    </form>
                    <form action="./checkoutIndiv.php" method="post" class="mx-5">
                        <button type="submit" name="prod" value="<?php echo $_POST['prod'] ?>" class="btn btn-outline-success" <?php echo ($stock < 1) ? "disabled" : "" ?>>Comprar Ahora</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>