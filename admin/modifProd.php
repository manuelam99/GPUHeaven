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

$id = $producto[0];
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

    if (!preg_match("/^[0-9a-zA-Z ]*$/", $_POST["nom"])) {
        $nombreProdErr = "Solo se permiten letras, numeros y espacios en blanco";
    } elseif (empty($_POST["nom"])) {
        $nombreProdErr = "Favor de ingresar nombre";
    } else {
        $nombreProd = $_POST['nom'];
    }

    if (empty(test_input($_POST["desc"]))) {
        $descProdErr = "Favor de ingresar descripcion";
    } else {
        $descProd = test_input($_POST["desc"]);
    }

    if (empty(test_input($_POST["fotos"]))) {
        $fotosProdErr = "Favor de ingresar ruta a carpeta de fotos";
    } else {
        $fotosProd = test_input($_POST["fotos"]);
    }

    if (empty($_POST["prec"]) or $_POST["prec"] < 0) {
        $precProdErr = "Favor de ingresar valor mayor o igual a 0";
    } else {
        $precProd = $_POST["prec"];
    }

    if (empty($_POST["stock"]) || $_POST["stock"] < 0) {
        $stockProdErr = "Favor de ingresar valor mayor o igual a 0";
    } else {
        $stockProd = $_POST["stock"];
    }

    if (empty(test_input($_POST["fab"]))) {
        $fabProdErr = "Favor de ingresar fabricante";
    } else {
        $fabProd = test_input($_POST["fab"]);
    }

    if (empty(test_input($_POST["org"]))) {
        $orgProdErr = "Favor de ingresar origen";
    } else {
        $orgProd = test_input($_POST["org"]);
    }

    $id = $_POST['id_prod'];

    $bandera = empty($nombreProdErr) && empty($descProdErr) && empty($precProdErr) &&
        empty($stockProdErr) && empty($fabProdErr) && empty($orgProdErr) &&
        empty($fotosProdErr);

    if ($bandera) {
        $update = "UPDATE productos
                   SET nom_producto=?, desc_producto=?, fotos_producto=?, 
                   prec_producto=?, stock_producto=?, fab_producto=?, org_producto=?
                   WHERE id_producto = {$id};";

        if ($stmt = mysqli_prepare($con, $update)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param(
                $stmt,
                "sssdiss",
                $paramNombre,
                $paramDesc,
                $paramFotos,
                $paramPrec,
                $paramStock,
                $paramFab,
                $paramOrg
            );

            // Set parameters
            $paramNombre = $nombreProd;
            $paramDesc = $descProd;
            $paramFotos = $fotosProd;
            $paramPrec = $precProd;
            $paramStock = $stockProd;
            $paramFab = $fabProd;
            $paramOrg = $orgProd;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to admin page
                header("location: ./index.php");
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
                    <select name="fab" class="form-control <?php echo (!empty($fabProdErr)) ? 'is-invalid' : ''; ?>" required>
                        <option value="NVIDIA" <?php echo ($fabProd == "NVIDIA") ? "selected" : "" ?>>NVIDIA</option>
                        <option value="AMD" <?php echo ($fabProd == "AMD") ? "selected" : "" ?>>AMD</option>
                    </select>
                    <div class="invalid-feedback"><?php echo $fabProdErr; ?></div>
                </div>
                <div class="form-group">
                    <label for="org">Origen:</label>
                    <input type="text" class="form-control <?php echo (!empty($orgProdErr)) ? 'is-invalid' : ''; ?>" id="tarjeta" name="org" value="<?php echo $orgProd; ?>" required>
                    <div class="invalid-feedback"><?php echo $orgProdErr; ?></div>
                </div>
                <input type="hidden" name="id_prod" value="<?php echo $id ?>">
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