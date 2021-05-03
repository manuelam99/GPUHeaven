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
        <a class="navbar-brand" href="../index.php">
            <span class="oi oi-monitor text-light mr-1" title="Cart" aria-hidden="true"></span>GPUH
        </a>

        <!-- Links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="../index.php">Inicio</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="./php/tienda.php">Compra</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="./usuario.php">Usuario</a>
            </li>
        </ul>
        <div class="float-right">
            <a href="#"><span class="oi oi-cart text-light" title="Cart" aria-hidden="true"></span></a>
        </div>
    </nav>
    
</body>

</html>