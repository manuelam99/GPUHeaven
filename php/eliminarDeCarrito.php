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

    if($_POST['cant'] > 1){
        $sqlDelete = "UPDATE carrito
                      SET cantidad_producto = cantidad_producto - 1
                      WHERE id_usuario = {$id_usr}
                      AND id_producto = {$_POST['elim']};";
    }else{
        $sqlDelete = "DELETE FROM carrito 
                      WHERE id_producto = {$_POST['elim']}
                      AND id_usuario = {$id_usr};";
    }
                

    if (!mysqli_query($con, $sqlDelete)) {      //Eliminar de carrito
        die('Error: ' . mysqli_error($con));
    }
    
    mysqli_close($con);
}

// Redirect to carrito page
header("location: ./carrito.php");
exit;
