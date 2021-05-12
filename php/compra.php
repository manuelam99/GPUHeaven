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
    
    $sqlInsert = (empty($_POST['compraInd'])) ? $_POST['sqlI'] 
                : "INSERT INTO transacciones (id_producto, id_usuario, cantidad, precio) 
                   VALUES ({$_POST['compraInd'][0]}, {$id_usr}, 1, {$_POST['compraInd'][1]});";
                
    $sqlUpdate = (empty($_POST['compraInd'])) ? $_POST['sqlU'] 
                : "UPDATE productos SET stock_producto = stock_producto - 1
                   WHERE id_producto = {$_POST['compraInd'][0]}";

    $sqlLimpiar = (empty($_POST['compraInd'])) ? "DELETE FROM carrito WHERE id_usuario = ".$id_usr. ";" : "";

    $sqlTodo = $sqlInsert.$sqlUpdate.$sqlLimpiar;

    if (!mysqli_multi_query($con, $sqlTodo)) {      //Insertar transaccion(es)
        die('Error: ' . mysqli_error($con));
    }
    
    $_SESSION['compra'] = true;

    mysqli_close($con);
}

// Redirect to user page
header("location: ./usuario.php");
exit;
