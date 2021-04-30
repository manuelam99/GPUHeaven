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
    <title>GPU Heaven</title>
</head>

<?php
$con = mysqli_connect("localhost", "root", "root", "gpu_heaven");

$cards = "";
// Check connection
if (mysqli_connect_errno()) {
    $cards = "error";
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result = mysqli_query($con, "SELECT * FROM productos;");

while ($row = mysqli_fetch_array($result)) {
    $cards .= '<div class="card col-xs-12 card col-sm-6 col-md-6 col-lg-4 col-xl-4">';
    $cards .= '<div class="card-body">';
    $cards .= '<h4 class="card-title">' . $row['nom_producto'] . '</h4>';
    $cards .= '<p class="card-text">' . 'Stock: ' . $row['stock_producto'] . '</p>';
    $cards .= '<p class="card-text">' . '$' . $row['prec_producto'] . '</p>';
    $cards .= '<a href="#" class="btn btn-primary">Agregar a Carrito</a>';
    $cards .= '</div>';
    $cards .= '</div>';
}

mysqli_close($con);
?>

<body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <!-- Brand -->
        <a class="navbar-brand" href="../index.html">GPUH</a>

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
        <div class="tab-pane container active" id="todo">
            <div class="row justify-content-center">
                <?php echo $cards; ?>
            </div>
        </div>
        <div class="tab-pane container fade" id="amd">

        </div>
        <div class="tab-pane container fade" id="nvidia">

        </div>
    </div>

</body>

</html>