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

$query = "SELECT username, nom_usuario, email_usuario, fecha_nac, tarj_usuario, direc_usuario 
                                    FROM usuarios WHERE id_usuario = '1';";

$result = mysqli_query($con, $query);

$usuario = mysqli_fetch_row($result);

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
        <div class="float-right">
            <a href="#"><span class="oi oi-cart text-light" title="Cart" aria-hidden="true"></span></a>
        </div>
    </nav>

    <div class="container mt-3">
        <h2>Nombre: <?php echo $usuario[1] ?></h2>
        <h3>Username: <?php echo $usuario[0] ?></h3>
        <hr />
        <ul class="nav nav-tabs justify-content-center">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#info">Información</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#compras">Historial de Compras</a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane container active mt-4" id="info">
                <form action="">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Correo</span>
                        </div>
                        <input type="email" name="correo" id="correo" class="form-control" value="<?php echo $usuario[2] ?>" disabled>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-warning">Modificar</button>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Fecha</span>
                        </div>
                        <input type="date" name="fecha" id="fecha" class="form-control" value="<?php echo $usuario[3] ?>" disabled>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-warning">Modificar</button>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Tarjeta</span>
                        </div>
                        <input type="text" name="tarj" id="tarj" class="form-control" value="<?php echo $usuario[4] ?>" disabled>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-warning">Modificar</button>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Dirección</span>
                        </div>
                        <input type="text" name="direc" id="direc" class="form-control" value="<?php echo $usuario[5] ?>" disabled>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-warning">Modificar</button>
                        </div>
                    </div>
                    <button class="btn btn-success" type="submit" disabled>Guardar Cambios</button>
                </form>
            </div>
            <div class="tab-pane container fade mt-4" id="compras">

            </div>
        </div>
    </div>

</body>

</html>