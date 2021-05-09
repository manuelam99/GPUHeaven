<!DOCTYPE html>
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
    <title>Pagina de Admin</title>
</head>

<?php

require_once "../php/coneccion.php";

$queryCompras = "SELECT u.username as user, p.nom_producto as producto, t.cantidad as cant, t.precio as prec, t.fecha as fech
                 FROM transacciones t, productos p, usuarios u
                 WHERE t.id_producto = p.id_producto
                 AND t.id_usuario = u.id_usuario;";

$queryProds = "SELECT id_producto, nom_producto, prec_producto, stock_producto, fab_producto, org_producto
               FROM productos;";

$resultQueryCompras = mysqli_query($con, $queryCompras);
$resultQueryProds = mysqli_query($con, $queryProds);

$productos = "";
while ($row = mysqli_fetch_array($resultQueryProds)) {
    $precio = '$' . number_format($row['prec_producto']);
    $productos .= "<tr>";
    $productos .= "<td>{$row['nom_producto']}</td>";
    $productos .= "<td>{$precio}</td>";
    $productos .= "<td>{$row['stock_producto']}</td>";
    $productos .= "<td>{$row['fab_producto']}</td>";
    $productos .= "<td>{$row['org_producto']}</td>";
    $productos .= '<td><a href="./modifProd.php?prod='.$row['id_producto'].'"><button type="button" class="btn btn-warning">Modificar</button></a></td>';
    $productos .= "</tr>";
}

$compras = "";
while ($row = mysqli_fetch_array($resultQueryCompras)) {
    $precio = '$' . number_format($row['prec']);
    $compras .= "<tr>";
    $compras .= "<td>{$row['user']}</td>";
    $compras .= "<td>{$row['producto']}</td>";
    $compras .= "<td>{$row['cant']}</td>";
    $compras .= "<td>{$precio}</td>";
    $compras .= "<td>{$row['fech']}</td>";
    $compras .= "</tr>";
}

mysqli_close($con);
?>

<body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <a class="navbar-brand"><span class="oi oi-monitor text-light mr-1" title="Cart" aria-hidden="true"></span>GPUHA</a>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="../index.php">Ir a Tienda</a>
            </li>
        </ul>
    </nav>
    <ul class="nav nav-tabs justify-content-center my-5">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#prods">Productos</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#compras">Historial de Compras</a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane container active mt-4" id="prods">
            <div class="container" style="max-height: 638px; overflow-y:scroll">
                <table class="table table-striped table-hover table-responsive-md">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Fabricante</th>
                            <th>Origen</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php echo $productos ?>
                    </tbody>
                </table>
            </div>
            <div class="container my-5">
                <a href="./agregProd.php"><button type="button" class="btn btn-primary">Agregar Producto</button></a>
            </div>
        </div>
        <div class="tab-pane container fade mt-4" id="compras">
            <div class="container" style="max-height: 638px; overflow-y:scroll">
                <table class="table table-striped table-hover table-responsive-md">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo $compras ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>