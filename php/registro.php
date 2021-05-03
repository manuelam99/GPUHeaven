<!DOCTYPE html>
<?php
// Start the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: ../index.php");
    exit;
}

// Include config file
require_once "./coneccion.php";

// Define variables and initialize with empty values
$username = $password = $confirm_password = $correo = $fecha = $tarjeta = $direcc = $nombre = "";
$username_err = $nombre_err = $password_err = $confirm_password_err = $correo_err = $fecha_err = $tarjeta_err = $direcc_err = "";
$reg_error = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(test_input($_POST["uname"]))){
        $username_err = "Favor de ingresar usuario";
    }else{
        // Prepare a select statement
        $sql = "SELECT id_usuario FROM usuarios WHERE username = ?";
        
        if($stmt = mysqli_prepare($con, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = test_input($_POST["uname"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "Usuario ya existe";
                } else{
                    $username = test_input($_POST["uname"]);
                }
            }else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(test_input($_POST["pswd"]))){
        $password_err = "Favor de ingresar contraseña";     
    }elseif(strlen(test_input($_POST["pswd"])) < 6){
        $password_err = "Favor de ingresar contraseña de al menos 6 caracteres";
    } else{
        $password = test_input($_POST["pswd"]);
    }
    
    // Validate confirm password
    if(empty(test_input($_POST["pswd2"]))){
        $confirm_password_err = "Favor de confirmar contraseña";
    }else{
        $confirm_password = test_input($_POST["pswd2"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Contraseñas no son iguales";
        }
    }

    if(!preg_match("/^[a-zA-Z ]*$/",$_POST["name"])){
        $nombre_err = "Solo se permiten letras y espacios en blanco";
    }else{
        $nombre = test_input($_POST["name"]);
    }

    //Validar correo
    if(empty(test_input($_POST["correo"]))){
        $correo_err = "Favor de ingresar correo";
    }else{
        $correo = test_input($_POST["correo"]);
    }

    //Validar fecha
    if(empty(test_input($_POST["fecha"]))){
        $fecha_err = "Favor de ingresar fecha de nacimiento";
    }else{
        $fecha = test_input($_POST["fecha"]);
    }

    //Validar tarjeta
    if(empty(test_input($_POST["tarjeta"]))){
        $tarjeta_err = "Favor de ingresar tarjeta";
    }else{
        $tarjeta = test_input($_POST["tarjeta"]);
    }

    //Validar direccion
    if(empty(test_input($_POST["direc"]))){
        $direcc_err = "Favor de ingresar dirección";
    }else{
        $direcc = test_input($_POST["direc"]);
    }

    $bandera = empty($username_err) && empty($password_err) && empty($confirm_password_err) 
                && empty($correo_err) && empty($fecha_err) && empty($tarjeta_err) 
                && empty($direcc_err);
    
    // Check input errors before inserting in database
    if($bandera){
        
        // Prepare an insert statement
        $sql = "INSERT INTO usuarios (username, nom_usuario, email_usuario, pass_usuario, fecha_nac, tarj_usuario, direc_usuario) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($con, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssss", $param_username, $param_nombre, $param_correo, $param_password, 
                                                                $param_fecha, $param_tarj, $param_direcc);
            
            // Set parameters
            $param_username = $username;
            $param_nombre = $nombre;
            $param_correo = $correo;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_fecha = $fecha;
            $param_tarj = $tarjeta;
            $param_direcc = $direcc;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: ./login.php");
            } else{
                $reg_error = "Hubo un error en el registro";
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
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
    <link href="../open-iconic-master/open-iconic-master/font/css/open-iconic-bootstrap.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="../css/main.css">
    <title>GPU Heaven</title>
</head>

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
                <a class="nav-link " href="./usuario.php">Usuario</a>
            </li>
        </ul>
        <div class="nav navbar-nav">
            <a href="./carrito.php"><span class="oi oi-cart text-light" title="Cart" aria-hidden="true"></span></a>
        </div>
    </nav>
    <div class="container d-flex justify-content-center">
        <div class="row w-75 my-5">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="needs-validation col my-auto" method="post" novalidate>
                <h2>Registrate</h2>
                <div class="form-group">
                    <label for="uname">Username:</label>
                    <input type="text" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" id="uname" placeholder="Ingresar Usuario" name="uname" value="<?php echo $username; ?>" required>
                    <div class="invalid-feedback"><?php echo $username_err; ?></div>
                </div>
                <div class="form-group">
                    <label for="pwd">Contraseña:</label>
                    <input type="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" id="pwd" placeholder="Ingresar Contraseña" name="pswd" value="<?php echo $password; ?>" required>
                    <div class="invalid-feedback"><?php echo $password_err; ?></div>
                </div>
                <div class="form-group">
                    <label for="pwd2">Confirmar Contraseña:</label>
                    <input type="password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" id="pwd2" placeholder="Ingresar Contraseña" name="pswd2" value="<?php echo $confirm_password; ?>" required>
                    <div class="invalid-feedback"><?php echo $confirm_password_err; ?></div>
                </div>
                <div class="form-group">
                    <label for="uname">Nombre:</label>
                    <input type="text" class="form-control <?php echo (!empty($nombre_err)) ? 'is-invalid' : ''; ?>" id="name" placeholder="Ingresar Nombre" name="name" value="<?php echo $nombre; ?>">
                    <div class="invalid-feedback"><?php echo $nombre_err; ?></div>
                </div>
                <div class="form-group">
                    <label for="correo">Correo:</label>
                    <input type="email" class="form-control <?php echo (!empty($correo_err)) ? 'is-invalid' : ''; ?>" id="correo" placeholder="Ingresar Correo" name="correo" value="<?php echo $correo; ?>" required>
                    <div class="invalid-feedback"><?php echo $correo_err; ?></div>
                </div>
                <div class="form-group">
                    <label for="fecha">Fecha de Nacimiento:</label>
                    <input type="date" class="form-control <?php echo (!empty($fecha_err)) ? 'is-invalid' : ''; ?>" id="fecha" name="fecha" value="<?php echo $fecha; ?>" required>
                    <div class="invalid-feedback"><?php echo $fecha_err; ?></div>
                </div>
                <div class="form-group">
                    <label for="tarjeta">Tarjeta:</label>
                    <input type="text" class="form-control <?php echo (!empty($tarjeta_err)) ? 'is-invalid' : ''; ?>" id="tarjeta" placeholder="Ingresar Tarjeta" name="tarjeta" value="<?php echo $tarjeta; ?>" required>
                    <div class="invalid-feedback"><?php echo $tarjeta_err; ?></div>
                </div>
                <div class="form-group">
                    <label for="direc">Dirección:</label>
                    <input type="text" class="form-control <?php echo (!empty($direcc_err)) ? 'is-invalid' : ''; ?>" id="direc" placeholder="Ingresar Dirección" name="direc" value="<?php echo $direcc; ?>" required>
                    <div class="invalid-feedback"><?php echo $direcc_err; ?></div>
                </div>
                <button type="submit" class="btn btn-primary">Crear Cuenta</button>
                <span>¿Ya tienes cuenta?<a href="./login.php">Ingresa</a></span>
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