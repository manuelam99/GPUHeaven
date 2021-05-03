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
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["uname"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id_usuario FROM usuarios WHERE username = ?";
        
        if($stmt = mysqli_prepare($con, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["uname"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "Usuario ya existe";
                } else{
                    $username = trim($_POST["uname"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["pswd"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["pswd"])) < 6){
        $password_err = "Favor de ingresar contraseña de al menos 6 caracteres";
    } else{
        $password = trim($_POST["pswd"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["pswd2"]))){
        $confirm_password_err = "Favor de confirmar contraseña";
    }else{
        $confirm_password = trim($_POST["pswd2"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Contraseñas no son iguales";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO usuarios (username, pass_usuario) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($con, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: ./login.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
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
            <a href="#"><span class="oi oi-cart text-light" title="Cart" aria-hidden="true"></span></a>
        </div>
    </nav>
    <div class="container d-flex justify-content-center">
        <div class="row w-75 my-5">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="needs-validation col my-auto" method="post" novalidate>
                <h2>Registrate</h2>
                <div class="form-group">
                    <label for="uname">Username:</label>
                    <input type="text" class="form-control" id="uname" placeholder="Ingresar Usuario" name="uname" required>
                    <div class="valid-feedback">Valido.</div>
                    <div class="invalid-feedback">Favor de ingresar usuario.</div>
                </div>
                <div class="form-group">
                    <label for="pwd">Contraseña:</label>
                    <input type="password" class="form-control" id="pwd" placeholder="Ingresar Contraseña" name="pswd" required>
                    <div class="valid-feedback">Valida.</div>
                    <div class="invalid-feedback">Favor de ingresar contraseña.</div>
                </div>
                <div class="form-group">
                    <label for="pwd2">Confirmar Contraseña:</label>
                    <input type="password" class="form-control" id="pwd2" placeholder="Ingresar Contraseña" name="pswd2" required>
                    <div class="valid-feedback">Valida.</div>
                    <div class="invalid-feedback">Favor de ingresar contraseña.</div>
                </div>
                <div class="form-group">
                    <label for="uname">Nombre:</label>
                    <input type="text" class="form-control" id="name" placeholder="Ingresar Nombre" name="name" required>
                    <div class="valid-feedback">Valido.</div>
                    <div class="invalid-feedback">Favor de ingresar Nombre.</div>
                </div>
                <div class="form-group">
                    <label for="correo">Correo:</label>
                    <input type="email" class="form-control" id="correo" placeholder="Ingresar Correo" name="correo" required>
                    <div class="valid-feedback">Valido.</div>
                    <div class="invalid-feedback">Favor de ingresar Correo.</div>
                </div>
                <div class="form-group">
                    <label for="fecha">Fecha de Nacimiento:</label>
                    <input type="date" class="form-control" id="fecha" name="fecha" required>
                    <div class="valid-feedback">Valida.</div>
                    <div class="invalid-feedback">Favor de ingresar Fecha.</div>
                </div>
                <div class="form-group">
                    <label for="tarjeta">Tarjeta:</label>
                    <input type="text" class="form-control" id="tarjeta" placeholder="Ingresar Tarjeta" name="tarjeta" required>
                    <div class="valid-feedback">Valida.</div>
                    <div class="invalid-feedback">Favor de ingresar Tarjeta.</div>
                </div>
                <div class="form-group">
                    <label for="direc">Dirección:</label>
                    <input type="text" class="form-control" id="direc" placeholder="Ingresar Dirección" name="direc" required>
                    <div class="valid-feedback">Valida.</div>
                    <div class="invalid-feedback">Favor de ingresar Direccion.</div>
                </div>
                <button type="submit" class="btn btn-primary">Crear Cuenta</button>
                <span>¿Ya tienes cuenta?<a href="./login.php">Ingresa</a></span>
            </form>
        </div>

    </div>


    <script>
        // Disable form submissions if there are invalid fields
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Get the forms we want to add validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
</body>

</html>