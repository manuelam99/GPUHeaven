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
    <link type="text/css" rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
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
            <i class="fas fa-desktop mr-1"></i>GPUH
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Links -->
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
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

                <li class="nav-item d-flex align-items-center">
                    <a href="./php/carrito.php">
                        <i class="fas fa-shopping-cart text-white"></i>
                        <?php echo ($articulos > 0) ? '<span class="badge badge-danger rounded-circle">' . $articulos . '</span>' : '' ?>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="jumbotron mb-0">
        <h1 class="display-1 text-center">GPU Heaven, nosotros si tenemos stock</h1>
    </div>

    <div class="container-fluid my-0" style="height: 100vh; min-height: 100vh;" id="bgNVIDIA">
        <div class="row h-100">
            <div class="col-sm-12 col-md-6 col-lg-6 d-flex flex-column justify-content-center align-items-center">
                <img src="./images/jensenHuang.jpg" alt="Imagen" class="img-fluid rounded-circle mb-3" style="max-width: 50%">
                <i style="max-width: 75%;">
                    <h5 class="text-white text-center" id="texto">"No existe mejor proveedor que GPU Heaven. Estamos orgullosos de tener una tán cercana alianza con ellos.
                        En ningún otro lugar encontrarás el mismo calibre de servicio y atención, y mucho menos, mejores precios."</h5>
                </i>
                <h4 class="text-white text-center" id="autor">-Jensen Huang, CEO de NVIDIA Corporation</h4>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6 d-flex flex-column justify-content-center align-items-center">
                <h3 class="text-white text-center" id="linkT">Impulsa tu rendimiento con NVIDIA</h3>
                <a href="./php/tienda.php"><button type="button" class="btn btn-dark">Visita la Tienda</button></a>
            </div>
        </div>
    </div>
    <div class="container-fluid my-0" style="height: 100vh; min-height: 100vh;" id="bgAMD">
        <div class="row h-100">
            <div class="col-sm-12 col-md-6 col-lg-6 d-flex flex-column justify-content-center align-items-center">
                <h3 class="text-white text-center" id="linkT">Domina el campo de batalla con AMD</h3>
                <a href="./php/tienda.php"><button type="button" class="btn btn-dark">Visita la Tienda</button></a>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6 d-flex flex-column justify-content-center align-items-center">
                <img src="./images/lisaSu.jpg" alt="Imagen" class="img-fluid rounded-circle mb-3" style="max-width: 50%">
                <i style="max-width: 75%;">
                    <h5 class="text-white text-center" id="texto">"En todos mis años trabajando para AMD, nunca me había encontrado con un proveedor tán enfocado
                        en la buena experiencia del cliente.
                        Si lo que quieres es un servicio incomparable (a los mejores precios), no dudes comprar en GPU Heaven."</h5>
                </i>
                <h4 class="text-white text-center" id="autor">-Dra. Lisa Su, CEO de AMD Inc.</h4>
            </div>
        </div>
    </div>
    <div class="container-fluid my-5">
        <div class="container d-flex justify-content-around">

            <a href="./php/login.php" style="text-decoration: none;">
                <div class="card" style="border: none;">
                    <i class="fas fa-sign-in-alt text-center"></i>
                    <div class="card-body">
                        <h4 class="card-title text-center" id="cuenta">¿Ya tienes cuenta?</h4>
                        <p class="card-text text-center" id="cuenta">¡Inicia Sesión!</p>
                    </div>
                </div>
            </a>

            <a href="./php/registro.php" style="text-decoration: none;">
                <div class="card" style="border: none;">
                    <i class="fas fa-address-card text-center"></i>
                    <div class="card-body">
                        <h4 class="card-title text-center" id="cuenta">¿No tienes cuenta?</h4>
                        <p class="card-text text-center" id="cuenta">¡Regístrate!</p>
                    </div>
                </div>
            </a>

        </div>
    </div>

    <nav class="navbar bg-dark navbar-dark justify-content-center">
        <ul class="navbar-nav">
            <li class="nav-item text-center">
                <a class="nav-link" data-toggle="modal" data-target="#modalAcerca" style="cursor: pointer;">About Us</a>
            </li>

            <li class="nav-item text-center">
                <a class="nav-link" data-toggle="modal" data-target="#modalContacto" style="cursor: pointer;">Contacto</a>
            </li>

            <li class="nav-item text-center">
                <a class="nav-link" href="./admin/index.php">Admin</a>
            </li>
        </ul>
    </nav>

    <div class="modal fade" id="modalAcerca">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">About Us</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <h5>Quienes somos</h5>
                    <p>Empresa 100% Mexicana. Fundada en 2021 por Manuel Álvarez Macías, GPU Heaven
                        se dedica principalmente a la venta y distribuición de GPUs (Graphics Processing Unit)
                        con el fín de proporcionarle a los verdaderos "gamers" una tienda en la cual pueden
                        confiar el 100% de las veces. Contamos con un convenio especial tánto con NVIDIA
                        como con AMD para asegurarles a nuestros clientes la máxima disponibilidad y los mejores
                        precios en todo momento.</p>
                    <h5>Nuestra Misión</h5>
                    <p>Contar con la mejor disponibilidad y los mejores precios para brindarle a nuestros clientes
                        la mejor experiencia de compra en el mercado de las GPUs.</p>
                    <h5>Nuestra Visión</h5>
                    <p>Llegar a ser una empresa líder a nível mundial en él ámbito de los componentes de
                        cómputo, no únicamente GPUs, para brindarles a nuestros clientes un lugar en el que
                        siempre puedan confiar.</p>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="modalContacto">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Contáctanos</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <h5>Correo:</h5>
                    <p>custSupport@gpuh.com.mx</p>
                    <h5>Teléfono:</h5>
                    <p>+52 55 4957 4954</p>
                    <h5>Horario de Servicio</h5>
                    <p>Lunes a Viernes de 8:00 AM a 8:00 PM</p>
                    <p>Fines de semana y días festivos de 10:00 AM a 5:00 PM</p>
                    <h5>¡Déjanos un comentario!</h5>
                    <form action="./php/dejarComentario.php" method="post">
                        <div class="form-group">
                            <textarea class="form-control" rows="5" id="comment" name="comentario"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Dejar Comentario</button>
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

</body>

</html>