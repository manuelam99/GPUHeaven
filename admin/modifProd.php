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
    <title>Pagina de Admin</title>
</head>

<?php

require_once "../php/coneccion.php";

$queryProd = "SELECT *
              FROM productos
              WHERE id_producto = {$_GET['prod']};";

$resultQueryProd = mysqli_query($con, $queryProd);

$producto = mysqli_fetch_row($resultQueryProd);

$nombreProd = $producto[1];
$descProd = $producto[2];
$fotosProd = $producto[3];
$precProd = $producto[4];
$stockProd = $producto[5];
$fabProd = $producto[6];
$orgProd = $producto[7];
$nombreProdErr = $descProdErr = $fotosProdErr = $precProdErr = $stockProdErr = $fabProdErr = $orgProdErr = "";
$reg_error = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
        <a class="navbar-brand"><span class="oi oi-monitor text-light mr-1" title="Cart" aria-hidden="true"></span>GPUHA</a>
    </nav>
    <div class="container d-flex justify-content-center">
        <div class="row w-75 my-5">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="needs-validation col my-auto" method="post" novalidate>
                <h2>Modificar Producto</h2>
                <div class="form-group">
                    <label for="nom">Nombre:</label>
                    <input type="text" class="form-control <?php echo (!empty($nombreProdErr)) ? 'is-invalid' : ''; ?>" id="uname" name="nom" value="<?php echo $nombreProd; ?>" required>
                    <div class="invalid-feedback"><?php echo $nombreProdErr; ?></div>
                </div>
                <div class="form-group">
                    <label for="desc">Descripción:</label>
                    <textarea type="textarea" class="form-control <?php echo (!empty($descProdErr)) ? 'is-invalid' : ''; ?>" id="pwd" name="desc" required><?php echo $descProd; ?></textarea>
                    <div class="invalid-feedback"><?php echo $descProdErr; ?></div>
                </div>
                <div class="form-group">
                    <label for="fotos">Ruta Fotos:</label>
                    <input type="text" class="form-control <?php echo (!empty($fotosProdErr)) ? 'is-invalid' : ''; ?>" id="pwd2" name="fotos" value="<?php echo $fotosProd; ?>" required>
                    <div class="invalid-feedback"><?php echo $fotosProdErr; ?></div>
                </div>
                <div class="form-group">
                    <label for="prec">Precio:</label>
                    <input type="number" class="form-control <?php echo (!empty($precProdErr)) ? 'is-invalid' : ''; ?>" id="name" name="prec" value="<?php echo $precProd; ?>" required>
                    <div class="invalid-feedback"><?php echo $precProdErr; ?></div>
                </div>
                <div class="form-group">
                    <label for="stock">Stock:</label>
                    <input type="number" class="form-control <?php echo (!empty($stockProdErr)) ? 'is-invalid' : ''; ?>" id="correo" name="stock" value="<?php echo $stockProd; ?>" required>
                    <div class="invalid-feedback"><?php echo $stockProdErr; ?></div>
                </div>
                <div class="form-group">
                    <label for="fab">Fabricante:</label>
                    <select class="form-control <?php echo (!empty($fabProdErr)) ? 'is-invalid' : ''; ?>" required>
                        <option selected value="NVIDIA">NVIDIA</option>
                        <option value="AMD">AMD</option>
                    </select>
                    <div class="invalid-feedback"><?php echo $fabProdErr; ?></div>
                </div>
                <div class="form-group">
                    <label for="org">Origen:</label>
                    <input type="text" class="form-control <?php echo (!empty($orgProdErr)) ? 'is-invalid' : ''; ?>" id="tarjeta" name="org" value="<?php echo $orgProd; ?>" required>
                    <div class="invalid-feedback"><?php echo $orgProdErr; ?></div>
                </div>
                <button type="submit" class="btn btn-success">Guardar Cambios</button>
                <?php
                if (!empty($reg_error)) {
                    echo '<div class="alert alert-danger alert-dismissible fade show my-3">';
                    echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                    echo  $reg_error;
                    echo '</div>';
                }
                ?>
            </form>
        </div>
    </div>
</body>

</html>