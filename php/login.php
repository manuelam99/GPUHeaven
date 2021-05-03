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
    <div class="container">
        <div class="row">
            <form action="#" class="needs-validation col-sm-12 col-md-6 my-auto" novalidate>
                <h2>Login</h2>
                <div class="form-group">
                    <label for="uname">Usuario:</label>
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
                <button type="submit" class="btn btn-primary">Ingresar</button>
            </form>

            <form action="#" class="needs-validation col-sm-12 col-md-6 my-5" novalidate>
                <h2>¿No tienes cuenta? ¡Crea una!</h2>
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