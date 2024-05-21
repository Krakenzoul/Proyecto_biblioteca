<?php include ("../../Template/header.php");

$db = new ConexionBDPDO();
$conexion = $db->conectar();
$consultasql = $conexion->prepare("select * from devoluciones");
$consultasql->execute();
$listaPrestamo = $consultasql->fetchAll();

?>
<center>
    <h1>Tabla Devoluciones</h1>
</center>

<div class="contenedor-index">

    <div class="div-index1-prestamo">
        <div style="border: 1px solid black; margin: 80px;">
            <div class="card">
                <div class="card-header">
                    <a name="id_libro" class="btn btn-dark" href="hacer_prestamo.php" role="button">Generar
                        Prestamo</a>
                </div>
             
                <div class="card-body">
                    <div class="table-responsive-lg">
                        <table class="table table-light">
                            <thead>
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">id_libro</th>
                                    <th scope="col">Nombre libro</th>
                                    <th scope="col">Numero documento</th>
                                    <th scope="col">Nombre Cliente</th>
                                    <th scope="col">Telefono De contacto</th>
                                    <th scope="col">fecha Prestamo</th>
                                    <th scope="col">fecha devolucion</th>
                                    <th scope="col">fecha Real devolucion</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($listaPrestamo as $prestamo) {
                                    $sql = "call traer_datos_prestamo($prestamo[No_prestamo])";
                                    $resultado = $conexion->prepare($sql);
                                    $resultado->execute();
                                    $datos_prestamo=$resultado->fetch();
                                    
                                    $sql = "call nombre_libro($datos_prestamo[id_libro])";
                                    $resultado = $conexion->prepare($sql);
                                    $resultado->execute();
                                    $nombre_libro = $resultado->fetch();
                                    $sql = "call traer_datos_cliente($datos_prestamo[No_documento])";
                                    $resultado = $conexion->prepare($sql);
                                    $resultado->execute();
                                    $nombre_cliente = $resultado->fetch();
                                    ?>
                                    <tr class="">
                                        <td><?php echo $datos_prestamo["No_prestamo"]; ?></td>
                                        <td><?php echo $datos_prestamo["id_libro"]; ?></td>
                                        <td><?php echo $nombre_libro["nombre_libro"] ?></td>
                                        <td><?php echo $datos_prestamo["No_documento"]; ?></td>
                                        <td><?php echo $nombre_cliente["primer_nombre"] . " " . $nombre_cliente["primer_apellido"] ?>
                                        </td>
                                        <td><?php echo $nombre_cliente["telefono"]; ?></td>
                                        <td><?php echo $datos_prestamo["fecha_prestamo"]; ?></td>
                                        <td><?php echo $datos_prestamo["fecha_devolucion"]; ?></td>
                                        <td><?php echo $datos_prestamo["fecha_real_devolucion"]; ?></td>
                                        <td><?php if ($datos_prestamo["estado"] == 1) {
                                            echo "No devuelto";
                                        }
                                        ; ?></td>
                                        <td>
                                            <a href="editar.php?id_libro=<?php echo $prestamo["No_prestamo"] ?>"
                                                class="btn btn-warning">Editar</a>
                                        </td>
                                        <td>
                                            <a href="eliminar.php?No_prestamo=<?php echo $prestamo["No_prestamo"] ?>"
                                                class="btn btn-danger">Eliminar</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="div-index2-prestamo">
        <img src="../../imagen/buho_logo.jpeg" height="300px" alt="buho_logo">
    </div>
</div>
<?php include ("../../Template/footer.php"); ?>