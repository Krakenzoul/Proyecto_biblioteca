<?php include ("../../Template/header.php");
include ("../../Conection/ConectBD.php");
$db = new ConexionBDPDO();
$conexion = $db->conectar();
$consultasql = $conexion->prepare("select * from cliente");
$consultasql->execute();
$lista_cliente = $consultasql->fetchAll();
$no_documento = 0;
?>
<center>
    <h1>Clientes</h1>
</center>

<div class="contenedor-index">

    <div class="div-index1-prestamo">
        <div style="border: 1px solid black; margin: 80px;">
            <div class="card">
                <div class="card-header">
                    <a name="id_libro" class="btn btn-dark" href="aniadir_cliente.php" role="button">Añadir Cliente</a>
                </div>

                <div class="card-body">
                    <div class="table-responsive-lg">
                        <table class="table table-light">
                            <thead>
                                <tr>
                                    <th scope="col">Numero De Documento</th>
                                    <th scope="col">Primer Nombre</th>
                                    <th scope="col">Segundo Nombre</th>
                                    <th scope="col">Primer Apellido</th>
                                    <th scope="col">Segundo Apellido</th>
                                    <th scope="col">Telefono De contacto</th>
                                    <th scope="col">Cantidad de Prestamos</th>

                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody <?php foreach ($lista_cliente as $cliente) {
                                $no_documento = $cliente["No_documento"];
                                $consultasql = $conexion->prepare("SELECT COUNT(*) AS total FROM prestamo WHERE No_documento = ?");
                                $consultasql->execute([$no_documento]);
                                $cantidad_prestamos = $consultasql->fetch();
                                ?> <tr class="">
                                    <td><?php echo $no_documento ?></td>
                                    <td><?php echo $cliente["primer_nombre"]; ?></td>
                                    <td><?php echo $cliente["segundo_nombre"] ?></td>
                                    <td><?php echo $cliente["primer_apellido"]; ?></td>
                                    <td><?php echo $cliente["segundo_apellido"] ?></td>
                                    <td><?php echo $cliente["telefono"]; ?></td>
                                    <td><?php echo $cantidad_prestamos["total"]; ?></td>
                                        <td>
                                        <a href="editar.php?No_documento=<?php echo $no_documento ?>" class="btn btn-warning">Editar</a>
                                        </td>
                                        <td>
                                        <a href="eliminar.php?No_documento=<?php echo $cliente["No_documento"] ?>"
                                            class="btn btn-danger">Eliminar</a>
                                    </td>

                                    </tr>
                                <?php }
                            ?>
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