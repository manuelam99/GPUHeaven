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
    <link type="text/css" rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <title>Pagina de Admin</title>
</head>

<?php

require_once "../php/coneccion.php";

$nombreProd = "";
$descProd = "";
$fotosProd = "";
$precProd = "";
$stockProd = "";
$fabProd = "";
$orgProd = "";
$nombreProdErr = $descProdErr = $fotosProdErr = $precProdErr = $stockProdErr = $fabProdErr = $orgProdErr = "";
$reg_error = "";
$archivosErr = "";


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

    $bandera = empty($nombreProdErr) && empty($descProdErr) && empty($precProdErr) &&
        empty($stockProdErr) && empty($fabProdErr) && empty($orgProdErr) &&
        empty($fotosProdErr);

    if ($bandera) {

        //https://www.w3schools.com/php/php_file_upload.asp

        //The name of the directory that we need to create.
        $directoryName = '../images/' . $fotosProd;

        //Check if the directory already exists.
        if (!is_dir($directoryName)) {
            //Directory does not exist, so lets create it.
            mkdir($directoryName, 0755, true);
        }

        $target_dir = $directoryName;

        $countfiles = count($_FILES['archivos']['name']);

        for ($i = 0; $i < $countfiles; $i++) {

            $target_file = $target_dir . '/' . basename($_FILES["archivos"]["name"][$i]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if image file is a actual image or fake image
            if (isset($_POST["submit"])) {
                $check = getimagesize($_FILES["archivos"]["tmp_name"][$i]);
                if ($check !== false) {
                    //echo "File is an image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                } else {
                    $archivosErr .= "El archivo {$_FILES["archivos"]["name"][$i]} no es imagen";
                    $uploadOk = 0;
                }
            }

            // Check if file already exists
            if (file_exists($target_file)) {
                $archivosErr .= "El archivo {$_FILES["archivos"]["name"][$i]} ya existe";
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES["archivos"]["size"][$i] > 500000) {
                $archivosErr .= "El archivo {$_FILES["archivos"]["name"][$i]} es demasiado grande";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if (
                $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif"
            ) {
                $archivosErr .= "{$_FILES["archivos"]["name"][$i]}, solo se permiten formatos JPG, JPEG, PNG y GIF";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                $archivosErr .= "El archivo {$_FILES["archivos"]["name"][$i]} no se subio adecuadamente";
                // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["archivos"]["tmp_name"][$i], $target_file)) {
                    //echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
                } else {
                    $archivosErr .= "Hubo un error al subir el archivo {$_FILES["archivos"]["name"][$i]}";
                }
            }
        }

        if (empty($archivosErr)) {

            $insert = "INSERT INTO productos (nom_producto, desc_producto, fotos_producto, prec_producto, stock_producto, fab_producto, org_producto)
                   VALUES (?,?,?,?,?,?,?);";

            if ($stmt = mysqli_prepare($con, $insert)) {
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
                    $reg_error = "Hubo un error en el Insert";
                    //echo "Oops! Something went wrong. Please try again later.";
                }

                // Close statement
                mysqli_stmt_close($stmt);
            }
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
        <a class="navbar-brand"><i class="fas fa-desktop mr-1"></i>GPUHA</a>
    </nav>
    <div class="container d-flex justify-content-center">
        <div class="row w-75 my-5">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="needs-validation col my-auto" method="post" novalidate enctype="multipart/form-data">
                <h2>Agregar Producto</h2>
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
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">images/</span>
                        </div>
                        <input type="text" class="form-control <?php echo (!empty($fotosProdErr)) ? 'is-invalid' : ''; ?>" id="pwd2" name="fotos" value="<?php echo $fotosProd; ?>" required>
                        <div class="invalid-feedback"><?php echo $fotosProdErr; ?></div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="archivos">Fotos:</label>
                    <input type="file" class="form-control-file border <?php echo (!empty($archivosErr)) ? 'is-invalid' : ''; ?>" id="pwd2" name="archivos[]" multiple>
                    <div class="invalid-feedback"><?php echo $archivosErr; ?></div>
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
                        <option value="NVIDIA" selected>NVIDIA</option>
                        <option value="AMD">AMD</option>
                    </select>
                    <div class="invalid-feedback"><?php echo $fabProdErr; ?></div>
                </div>
                <div class="form-group">
                    <label for="org">Origen:</label>
                    <input type="text" class="form-control <?php echo (!empty($orgProdErr)) ? 'is-invalid' : ''; ?>" id="tarjeta" name="org" value="<?php echo $orgProd; ?>" required>
                    <div class="invalid-feedback"><?php echo $orgProdErr; ?></div>
                </div>
                <button type="submit" name="submit" value="1" class="btn btn-success">Agregar</button>
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