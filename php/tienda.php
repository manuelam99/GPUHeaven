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
    <link href="../open-iconic-master/open-iconic-master/font/css/open-iconic-bootstrap.css" rel="stylesheet">
    <title>GPU Heaven</title>
</head>

<?php

$con = mysqli_connect("localhost", "root", "root", "gpu_heaven");

$cardsTodo = "";
$cardsAMD = "";
$cardsNVIDIA = "";
// Check connection
if (mysqli_connect_errno()) {
    $cards = "error";
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result = mysqli_query($con, "SELECT * FROM productos;");

while ($row = mysqli_fetch_array($result)) {

    $iden = 'a';
    $dir = $row['fotos_producto'] . '/';
    $fotos = array_slice(scandir('../images/' . $dir), 2);

    $cardsTodo .= '<div class="card">';

    $cardsTodo .= '<div id="demo' . $row['id_producto'] . $iden . '" class="carousel slide" data-interval="false" data-ride="carousel">';
    $cardsTodo .= '<ul class="carousel-indicators">' .
        '<li data-target="#demo' . $row['id_producto'] . $iden . '" data-slide-to="0" class="active"</li>' .
        '<li data-target="#demo' . $row['id_producto'] . $iden . '" data-slide-to="1"</li>' .
        '<li data-target="#demo' . $row['id_producto'] . $iden . '" data-slide-to="2"</li>' .
        '</ul>';

    $cardsTodo .= '<div class="carousel-inner">';

    foreach ($fotos as $llave => $foto) {
        if ($llave == 0) {
            $cardsTodo .= '<div class="carousel-item active">';
        } else {
            $cardsTodo .= '<div class="carousel-item">';
        }
        $cardsTodo .= '<img src="../images/' . $dir . $foto . '" class="imagen-fluid" alt="Image">';
        $cardsTodo .= '</div>';
    }

    $cardsTodo .= '</div>';
    $cardsTodo .= '<a class="carousel-control-prev" href="#demo' . $row['id_producto'] . $iden . '" data-slide="prev">' .
        '<span class="carousel-control-prev-icon"></span>' .
        '</a>' .
        '<a class="carousel-control-next" href="#demo' . $row['id_producto'] . $iden . '" data-slide="next">' .
        '<span class="carousel-control-next-icon"></span>' .
        '</a>';
    $cardsTodo .= '</div>';

    //$cardsTodo .= '<img class="card-img-top"'. 'src="../images/'. $dir.$fotos[0].'" ' .'alt="Card image">';
    $cardsTodo .= '<div class="card-body">';
    $cardsTodo .= '<h4 class="card-title">' . $row['nom_producto'] . '</h4>';
    $cardsTodo .= '<p class="card-text">' . 'Stock: ' . $row['stock_producto'] . '</p>';
    $cardsTodo .= '<p class="card-text">' . 'Precio: $' . number_format($row['prec_producto']) . '</p>';
    $cardsTodo .= '<form action="./producto.php" method="post">';
    $cardsTodo .= '<div class="row">';
    $cardsTodo .= '<a href="#" class="btn btn-outline-primary col-lg-4 col-md-12 col-s-12">Carrito</a>';
    $cardsTodo .= '<a href="#" class="btn btn-outline-success col-lg-4 col-md-12 col-s-12">Comprar</a>';
    $cardsTodo .= '<button type="submit" name="prod" value="'.$row['id_producto'].'" '.'class="btn btn-outline-info col-lg-4 col-md-12 col-s-12">Ver Mas</button>';
    $cardsTodo .= '</div>';
    $cardsTodo .= '</form>';
    $cardsTodo .= '</div>';
    $cardsTodo .= '</div>';
    if ($row['fab_producto'] == "NVIDIA") {
        $iden = 'b';
        $cardsNVIDIA .= '<div class="card">';

        $cardsNVIDIA .= '<div id="demo' . $row['id_producto'] . $iden . '" class="carousel slide" data-interval="false" data-ride="carousel">';
        $cardsNVIDIA .= '<ul class="carousel-indicators">' .
            '<li data-target="#demo' . $row['id_producto'] . $iden . '" data-slide-to="0" class="active"</li>' .
            '<li data-target="#demo' . $row['id_producto'] . $iden . '" data-slide-to="1"</li>' .
            '<li data-target="#demo' . $row['id_producto'] . $iden . '" data-slide-to="2"</li>' .
            '</ul>';

        $cardsNVIDIA .= '<div class="carousel-inner">';

        foreach ($fotos as $llave => $foto) {
            if ($llave == 0) {
                $cardsNVIDIA .= '<div class="carousel-item active">';
            } else {
                $cardsNVIDIA .= '<div class="carousel-item">';
            }
            $cardsNVIDIA .= '<img src="../images/' . $dir . $foto . '" class="imagen-fluid" alt="Image">';
            $cardsNVIDIA .= '</div>';
        }

        $cardsNVIDIA .= '</div>';
        $cardsNVIDIA .= '<a class="carousel-control-prev" href="#demo' . $row['id_producto'] . $iden . '" data-slide="prev">' .
            '<span class="carousel-control-prev-icon"></span>' .
            '</a>' .
            '<a class="carousel-control-next" href="#demo' . $row['id_producto'] . $iden . '" data-slide="next">' .
            '<span class="carousel-control-next-icon"></span>' .
            '</a>';
        $cardsNVIDIA .= '</div>';

        //$cardsNVIDIA .= '<img class="card-img-top" src="../images/" alt="Card image">';
        $cardsNVIDIA .= '<div class="card-body">';
        $cardsNVIDIA .= '<h4 class="card-title">' . $row['nom_producto'] . '</h4>';
        $cardsNVIDIA .= '<p class="card-text">' . 'Stock: ' . $row['stock_producto'] . '</p>';
        $cardsNVIDIA .= '<p class="card-text">' . 'Precio: $' . number_format($row['prec_producto']) . '</p>';
        $cardsNVIDIA .= '<form action="./producto.php" method="post">';
        $cardsNVIDIA .= '<div class="row">';
        $cardsNVIDIA .= '<a href="#" class="btn btn-outline-primary col-lg-4 col-md-12 col-s-12">Carrito</a>';
        $cardsNVIDIA .= '<a href="#" class="btn btn-outline-success col-lg-4 col-md-12 col-s-12">Comprar</a>';
        $cardsNVIDIA .= '<button type="submit" name="prod" value="'.$row['id_producto'].'" '.'class="btn btn-outline-info col-lg-4 col-md-12 col-s-12">Ver Mas</button>';
        $cardsNVIDIA .= '</div>';
        $cardsNVIDIA .= '</form>';
        $cardsNVIDIA .= '</div>';
        $cardsNVIDIA .= '</div>';
    } elseif ($row['fab_producto'] == "AMD") {
        $iden = 'c';
        $cardsAMD .= '<div class="card">';

        $cardsAMD .= '<div id="demo' . $row['id_producto'] . $iden . '" class="carousel slide" data-interval="false" data-ride="carousel">';
        $cardsAMD .= '<ul class="carousel-indicators">' .
            '<li data-target="#demo' . $row['id_producto'] . $iden . '" data-slide-to="0" class="active"</li>' .
            '<li data-target="#demo' . $row['id_producto'] . $iden . '" data-slide-to="1"</li>' .
            '<li data-target="#demo' . $row['id_producto'] . $iden . '" data-slide-to="2"</li>' .
            '</ul>';

        $cardsAMD .= '<div class="carousel-inner">';

        foreach ($fotos as $llave => $foto) {
            if ($llave == 0) {
                $cardsAMD .= '<div class="carousel-item active">';
            } else {
                $cardsAMD .= '<div class="carousel-item">';
            }
            $cardsAMD .= '<img src="../images/' . $dir . $foto . '" class="imagen-fluid" alt="Image">';
            $cardsAMD .= '</div>';
        }

        $cardsAMD .= '</div>';
        $cardsAMD .= '<a class="carousel-control-prev" href="#demo' . $row['id_producto'] . $iden . '" data-slide="prev">' .
            '<span class="carousel-control-prev-icon"></span>' .
            '</a>' .
            '<a class="carousel-control-next" href="#demo' . $row['id_producto'] . $iden . '" data-slide="next">' .
            '<span class="carousel-control-next-icon"></span>' .
            '</a>';
        $cardsAMD .= '</div>';

        //$cardsAMD .= '<img class="card-img-top" src="../images/" alt="Card image">';
        $cardsAMD .= '<div class="card-body">';
        $cardsAMD .= '<h4 class="card-title">' . $row['nom_producto'] . '</h4>';
        $cardsAMD .= '<p class="card-text">' . 'Stock: ' . $row['stock_producto'] . '</p>';
        $cardsAMD .= '<p class="card-text">' . 'Precio: $' . number_format($row['prec_producto']) . '</p>';
        $cardsAMD .= '<form action="./producto.php" method="post">';
        $cardsAMD .= '<div class="row">';
        $cardsAMD .= '<a href="#" class="btn btn-outline-primary col-lg-4 col-md-12 col-s-12">Carrito</a>';
        $cardsAMD .= '<a href="#" class="btn btn-outline-success col-lg-4 col-md-12 col-s-12">Comprar</a>';
        $cardsAMD .= '<button type="submit" name="prod" value="'.$row['id_producto'].'" '.'class="btn btn-outline-info col-lg-4 col-md-12 col-s-12">Ver Mas</button>';
        $cardsAMD .= '</div>';
        $cardsAMD .= '</form>';
        $cardsAMD .= '</div>';
        $cardsAMD .= '</div>';
    }
}

mysqli_close($con);
?>

<body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <!-- Brand -->
        <a class="navbar-brand" href="../index.html">
        <span class="oi oi-monitor text-light mr-1" title="Cart" aria-hidden="true"></span>GPUH
        </a>

        <!-- Links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="../index.html">Inicio</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="./tienda.php">Compra</a>
            </li>

            <li class="nav-item">
                <a class="nav-link " href="#">Usuario</a>
            </li>
        </ul>
        <div class="float-right">
            <a href="#"><span class="oi oi-cart text-light" title="Cart" aria-hidden="true"></span></a>
        </div>
    </nav>
    <div class="jumbotron">
        <h1 class="display-1 text-center">Los mejores precios, la mejor disponibilidad</h1>
    </div>
    <!-- Links -->
    <ul class="nav nav-tabs justify-content-center">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#todo">Todo</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#amd">AMD</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#nvidia">NVIDIA</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane container active mt-4" id="todo">
            <div class="card-columns">
                <?php echo $cardsTodo; ?>
            </div>
        </div>
        <div class="tab-pane container fade mt-4" id="amd">
            <div class="card-columns">
                <?php echo $cardsAMD; ?>
            </div>
        </div>
        <div class="tab-pane container fade mt-4" id="nvidia">
            <div class="card-columns">
                <?php echo $cardsNVIDIA; ?>
            </div>
        </div>
    </div>

</body>

</html>