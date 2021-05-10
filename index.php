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
    <link href="./open-iconic-master/open-iconic-master/font/css/open-iconic-bootstrap.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="./css/main.css">
    <title>GPU Heaven</title>
</head>

<?php

require_once "./php/coneccion.php";

$id_usr = $_SESSION["id"];
$queryCarrito = "SELECT id_usuario from carrito WHERE id_usuario = '" . $id_usr . "';";

$resultQueryCarrito = mysqli_query($con, $queryCarrito);
$articulos = mysqli_num_rows($resultQueryCarrito);

mysqli_close($con);
?>

<body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <!-- Brand -->
        <a class="navbar-brand" href="./index.php">
            <span class="oi oi-monitor text-light mr-1" title="Cart" aria-hidden="true"></span>GPUH
        </a>

        <!-- Links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="./index.php">Inicio</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="./php/tienda.php">Compra</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="./php/usuario.php">Usuario</a>
            </li>
        </ul>
        <div class="nav navbar-nav">
            <a href="./php/carrito.php">
                <span class="oi oi-cart text-light" title="Cart" aria-hidden="true"></span>
                <?php echo ($articulos > 0) ? '<span class="badge badge-danger rounded-circle">' . $articulos . '</span>' : '' ?>
            </a>
        </div>
    </nav>
    <div class="jumbotron mb-0">
        <h1 class="display-1 text-center">GPU Heaven, nosotros si tenemos stock</h1>
    </div>

    <div class="container-fluid my-0" style="height: 100vh;">
        <div class="row h-100">
            <div class="col-sm-12 col-md-6 col-lg-6 bg-success h-100 d-flex flex-column justify-content-center align-items-center">
                <img src="./images/jensenHuang.jpg" alt="Imagen" class="img-fluid rounded-circle mb-3" style="max-width: 50%">
                <i style="max-width: 75%;">
                    <h5>"No existe mejor proveedor que GPU Heaven. Estamos orgullosos de tener una tán cercana alianza con ellos.
                         En ningún otro lugar encontrarás el mismo calibre de servicio y atención, y mucho menos, mejores precios."</h5>
                </i>
                <h4>-Jensen Huang, CEO de NVIDIA Corporation</h4>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6 h-100">

            </div>
        </div>
    </div>
    <div class="container-fluid my-0" style="height: 100vh;">
        <div class="row h-100">
            <div class="col-sm-12 col-md-6 col-lg-6 h-100">

            </div>
            <div class="col-sm-12 col-md-6 col-lg-6 h-100 bg-danger d-flex flex-column justify-content-center align-items-center">
                <img src="./images/lisaSu.jpg" alt="Imagen" class="img-fluid rounded-circle mb-3" style="max-width: 50%">
                <i style="max-width: 75%;">
                    <h5>"En todos mis años trabajando para AMD, nunca me había ecnontrado con un proveedor tán enfocado 
                         en la buena experiencia del cliente. 
                         Si lo que quieres es un servicio incomparable (a los mejores precios), no dudes comprar en GPU Heaven."</h5>
                </i>
                <h4>-Dra. Lisa Su, CEO de AMD Inc.</h4>
            </div>
        </div>
    </div>

</body>

</html>