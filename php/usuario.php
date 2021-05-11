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

$name = $uname = $correo = $fecha = $tarj = $direcc = "";
$correoErr = $fechaErr = $tarjErr = $direccErr = "";

require_once "./coneccion.php";

$id_usr = $_SESSION["id"];

$query = "SELECT username, nom_usuario, email_usuario, fecha_nac, tarj_usuario, direc_usuario 
                                    FROM usuarios WHERE id_usuario = '" . $id_usr . "';";

$queryCarrito = "SELECT id_usuario from carrito WHERE id_usuario = '" . $id_usr . "';";

$queryCompras = "SELECT p.nom_producto AS pNombre, t.cantidad AS cantidad, t.precio AS precio, t.fecha AS fecha
                 FROM productos p, transacciones t 
                 WHERE t.id_producto = p.id_producto 
                 AND t.id_usuario = " . $id_usr . ";";


$resultQueryCarrito = mysqli_query($con, $queryCarrito);
$articulos = mysqli_num_rows($resultQueryCarrito);

$result = mysqli_query($con, $query);
$usuario = mysqli_fetch_row($result);

$name = $usuario[1];
$uname = $usuario[0];
$correo = $usuario[2];
$fecha = $usuario[3];
$tarj = $usuario[4];
$direcc = $usuario[5];

$resultQueryCompras = mysqli_query($con, $queryCompras);

$compras = "";
while ($row = mysqli_fetch_array($resultQueryCompras)) {
    $precio = '$' . number_format($row['precio']);
    $compras .= "<tr>";
    $compras .= "<td>{$row['pNombre']}</td>";
    $compras .= "<td>{$row['cantidad']}</td>";
    $compras .= "<td>{$precio}</td>";
    $compras .= "<td>{$row['fecha']}</td>";
    $compras .= "</tr>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(test_input($_POST["correo"]))) {
        $correoErr = "Favor de ingresar correo";
    } else {
        $correo = test_input($_POST["correo"]);
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $correoErr = "Favor de introducir correo valido";
        }
    }

    if (empty(test_input($_POST["fecha"]))) {
        $fechaErr = "Favor de ingresar fecha";
    } else {
        $fecha = test_input($_POST["fecha"]);
    }

    if (empty(test_input($_POST["tarj"]))) {
        $tarjErr = "Favor de ingresar tarjeta";
    } else {
        $tarj = test_input($_POST["tarj"]);
        if (!preg_match("/^[0-9]*$/", $tarj)) {
            $tarjErr = "Solo se permiten numeros";
        }
    }

    if (empty(test_input($_POST["direc"]))) {
        $direccErr = "Favor de ingresar direccion";
    } else {
        $direcc = test_input($_POST["direc"]);
    }

    $band = empty($correoErr) && empty($fechaErr) && empty($tarjErr) && empty($direccErr);

    if ($band) {
        $update = "UPDATE usuarios
                   SET email_usuario = ?, fecha_nac = ?, tarj_usuario = ?, direc_usuario = ?
                   WHERE id_usuario = {$id_usr};";

        if ($stmt = mysqli_prepare($con, $update)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param(
                $stmt,
                "ssss",
                $param_correo,
                $param_fecha,
                $param_tarj,
                $param_direc,
            );

            // Set parameters
            $param_correo = $correo;
            $param_fecha = $fecha;
            $param_tarj = $tarj;
            $param_direc = $direcc;
           

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to login page
                header("location: ./usuario.php");
            } else {
                $reg_error = "Hubo un error en el update";
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
}

mysqli_close($con);

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
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

    <div class="container mt-3">
        <h2>Nombre: <?php echo (empty($name)) ? "Anónimo" : htmlspecialchars($name); ?></h2>
        <h3>Username: <?php echo $uname ?></h3>
        <a href="./logout.php"><button type="button" class="btn btn-danger">Logout</button></a>
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
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="needs-validation col my-auto" method="post" novalidate>

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Correo</span>
                            </div>
                            <input type="email" name="correo" id="correo" class="form-control" value="<?php echo $correo ?>" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Fecha</span>
                            </div>
                            <input type="date" name="fecha" id="fecha" class="form-control" value="<?php echo $fecha ?>" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Tarjeta</span>
                            </div>
                            <input type="text" name="tarj" id="tarj" class="form-control" value="<?php echo $tarj ?>" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Dirección</span>
                            </div>
                            <input type="text" name="direc" id="direc" class="form-control" value="<?php echo $direcc ?>" disabled>
                        </div>
                    </div>

                    <button class="btn btn-warning" id="modif">Modificar</button>
                    <button class="btn btn-success" type="submit" id="save" disabled>Guardar Cambios</button>
                </form>
            </div>
            <div class="tab-pane container fade mt-4" id="compras">
                <div class="container" style="max-height: 638px; overflow-y:scroll">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php echo $compras ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/clicks.js"></script>
</body>

</html>