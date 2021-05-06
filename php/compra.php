<?php
// Initialize the session
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ./login.php");
    exit;
}

$id_usr = $_SESSION["id"];

require_once "./coneccion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $sqlInsert = $_POST['sqlI'];
    $sqlUpdate = $_POST['sqlU'];
    $sqlLimpiar = "DELETE FROM carrito WHERE id_usuario = ".$id_usr. ";";

    $sqlTodo = $sqlInsert.$sqlUpdate.$sqlLimpiar;

    if (!mysqli_multi_query($con, $sqlTodo)) {      //Insertar transaccion(es)
        die('Error: ' . mysqli_error($con));
    }
    
    mysqli_close($con);
}

// Redirect to user page
header("location: ./usuario.php");
exit;
