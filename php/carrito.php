<!DOCTYPE html>
<?php
// Start the session
session_start();
/*
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ./login.php");
    exit;
}
*/
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

while ($row = mysqli_fetch_array($result)) {
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
        <hr>
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-4">
                <img src="" alt="Imagen" class="imagen-fluid">
            </div>
            <div class="col-lg-4 text-center">
                <p>Nombre</p>
                <p>Precio</p>
                <p>Cantidad</p>
            </div>
            <div class="col-lg-4">
                <button type="button" class="btn btn-danger">Eliminar</button>
            </div>
        </div>
        <hr>
    </div>

</body>

</html>