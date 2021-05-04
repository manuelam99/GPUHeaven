<?php
// Initialize the session
session_start();
 
require_once "./coneccion.php";



// Redirect to store page
header("location: ./tienda.php");
exit;
?>