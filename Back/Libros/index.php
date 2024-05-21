<?php
include ("../../Template/header.php");
$db = new ConexionBDPDO();
$conexion = $db->conectar();
$consultasql = $conexion->prepare("select * from libro");
$consultasql->execute();
$listaLibros = $consultasql->fetchAll();
?>

<div class="contenedor-index">
    <div class="div-index1-prestamo">
        <div style="border: 1px solid black; margin: 80px;">
            <div class="card">
                <div class="card-header">
                    <a name="id_libro" class="btn btn-dark" href="crear.php" role="button">Agregar Libro</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive-lg">
                        <table class="table table-light">
                            <thead>
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Autor</th>
                                    <th scope="col">Categoria</th>
                                    <th scope="col">Ubicacion</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($listaLibros as $libro) { ?>
                                    <tr class="">
                                        <td><?php echo $libro["id_libro"]; ?></td>
                                        <td><?php echo $libro["nombre_libro"]; ?></td>
                                        <td><?php echo $libro["nombre_autor"]; ?></td>
                                        <td><?php echo $libro["categoria"]; ?></td>
                                        <td><?php echo $libro["No_estanteria"]; ?></td>
                                        <td><?php if ($libro["estado"] == 1) {
                                            echo "Disponible";
                                        } else {
                                            echo "En prestamo";
                                        }
                                        ; ?></td>
                                        <td>
                                            <a href="editar.php?id_libro=<?php if ($libro["estado"] == 1) {
                                                echo $libro["id_libro"];
                                            } else {
                                        
                                            } ?>" class="btn btn-warning">Editar</a>
                                        </td>
                                        <td>
                                            <a href="eliminar.php?id_libro=<?php if ($libro["estado"] == 1) {
                                                echo $libro["id_libro"];
                                            } else {
                                              
                                            } ?>" class="btn btn-danger">Eliminar</a>
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