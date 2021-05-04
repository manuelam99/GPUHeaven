<?php
// Initialize the session
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ./login.php");
    exit;
}

$id_usr = $_SESSION["id"];
$band = true;

require_once "./coneccion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_prod = $_POST['prod'];

    // Prepare a select statement
    $sql = "SELECT id_usuario, id_producto FROM carrito WHERE id_usuario = ? AND id_producto = ?";

    if ($stmt = mysqli_prepare($con, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ii", $param_userID, $param_prodID);

        // Set parameters
        $param_userID = $id_usr;
        $param_prodID = $id_prod;

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            /* store result */
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) == 1) {
                $band = false;
                $update = "UPDATE carrito 
                           SET cantidad_producto = cantidad_producto + 1 
                           WHERE id_usuario = '".$id_usr."' AND id_producto = '".$id_prod."';";
                if (!mysqli_query($con,$update)){
                    die('Error: ' . mysqli_error($con));
                }
                header("location: ./tienda.php");
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    if ($band) {
        // Prepare an insert statement
        $sql = "INSERT INTO carrito (id_usuario, id_producto, cantidad_producto) VALUES (?, ?, 1)";

        if ($stmt = mysqli_prepare($con, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param(
                $stmt,
                "ii",
                $param_userID,
                $param_prodID,
            );

            // Set parameters
            $param_userID = $id_usr;
            $param_prodID = $id_prod;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to store page
                header("location: ./tienda.php");
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    mysqli_close($con);
}

// Redirect to store page
header("location: ./tienda.php");
exit;
