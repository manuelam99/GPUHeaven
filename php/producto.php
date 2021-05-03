<!DOCTYPE html>
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

$con = mysqli_connect("localhost", "root", "root", "gpu_heaven");
// Check connection
if (mysqli_connect_errno()) {
    $cards = "error";
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$query = "SELECT * FROM productos WHERE id_producto ='" . $_POST['prod'] . "'";

$result = mysqli_query($con, $query);

$producto = mysqli_fetch_row($result);

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
                <p class="hola">PUTA MADRE</p>
            </div>
        </div>
    </div>

</body>

</html>