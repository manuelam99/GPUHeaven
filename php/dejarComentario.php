<?php
// Initialize the session
session_start();

$user = "Anónimo";

require_once "./coneccion.php";

if (isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === true) {
    $id_usr = $_SESSION["id"];
    $queryUser = "SELECT username FROM usuarios WHERE id_usuario = '" . $id_usr . "';";
    $resultQueryUser = mysqli_query($con, $queryUser);
    $user = mysqli_fetch_array($resultQueryUser)[0];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $sqlInsert = "INSERT INTO comentarios (usuario, comentario)
                  VALUES ('{$user}', '{$_POST['comentario']}');";

    if (!mysqli_query($con, $sqlInsert)) {      //Insertar comentarios
        die('Error: ' . mysqli_error($con));
    }

}

mysqli_close($con);
// Redirect to user page
header("location: ../index.php");
exit;
