<?php
include ("../../Template/header.php");
include ("../../Conection/ConectBD.php");
include ("../Libros/libro.php");

$db = new ConexionBDPDO();
$conexion = $db->conectar();
$consultasql = "SELECT * FROM movimientos_libro WHERE 1=1";
$valores = [];
$prestamoro = new Libro();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prestamoro->setnombre_Autor($_POST['nombre_autor']);
    $prestamoro->setnombre_Titulo($_POST['nombre_libro']);
    $prestamoro->setCategoria($_POST['genero']);
    $prestamoro->setEstado($_POST['estado']);

    $nombre_autor = $prestamoro->getnombre_Autor();
    $nombre_libro = $prestamoro->getnombre_Titulo();
    $categoria = $prestamoro->getCategoria();
    $estado = $prestamoro->getEstado();

    if (!empty($nombre_autor)) {
        $consultasql .= ' AND nombre_autor LIKE :nombre_autor';
        $valores[':nombre_autor'] = '%' . $nombre_autor . '%';
    }
    if (!empty($nombre_libro)) {
        $consultasql .= ' AND nombre_libro LIKE :nombre_libro';
        $valores[':nombre_libro'] = '%' . $nombre_libro . '%';
    }
    if (!empty($categoria)) {
        $consultasql .= ' AND categoria LIKE :categoria';
        $valores[':categoria'] = '%' . $categoria . '%';
    }
    if (!empty($estado)) {
        $consultasql .= ' AND estado = :estado';
        $valores[':estado'] = $estado;
    }
}
?>

<div class="contenedor-index">
    <div class="div-index1-prestamo">
        <div style="border: 1px solid black; margin: 80px;">
            <div class="card">

                <div class="card-header" style="display:flex;">
                    <a name="id_libro" class="btn btn-dark" href="crear.php" role="button">Agregar Libro</a>
                    <form method="POST">
                        <div class="row">
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Nombre Autor" name="nombre_autor">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Genero" name="genero">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Nombre libro" name="nombre_libro">
                            </div>
                            <div class="col">
                                <select id="inputState" name="estado" class="form-select">
                                    <option selected value="">Estado</option>
                                    <option value="0">En prestamo</option>
                                    <option value="1">Disponible</option>
                                </select>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-dark">Buscar</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive-lg">
                        <table class="table table-light">
                            <thead>
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Nombre Del libro</th>
                                    <th scope="col">Número de documento del empleado</th>
                                    <th scope="col">Empleado Responsable</th>
                                    <th scope="col">Tipo de movimiento</th>
                                    <th scope="col">Fecha De la acción</th>
                                    <th scope="col">Detalles</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stm = $conexion->prepare($consultasql);
                                $stm->execute($valores);
                                $listaMovimientos = $stm->fetchAll();
                                $stm->closeCursor();

                                foreach ($listaMovimientos as $prestamo) { 
                                    
                                    $sql = "call nombre_libro($prestamo[id_libro])";
                                    $resultado = $conexion->prepare($sql);
                                    $resultado->execute();
                                    $nombre_libro = $resultado->fetch();
                             

                                    $sql = "call traer_datos_empleado($prestamo[No_documento])";
                                    $resultado = $conexion->prepare($sql);
                                    $resultado->execute();
                                    $datos_empleado = $resultado->fetch();
                                    $resultado->closeCursor();
                                    ?>
                                    <tr>
                                        <td><?php echo $prestamo["No_movimiento"]; ?></td>
                                        <td><?php echo isset($nombre_libro["nombre_libro"]) ? $nombre_libro["nombre_libro"] : 'No disponible'; ?></td>
                                        <td><?php echo $datos_empleado["No_documento"]; ?></td>
                                        <td><?php echo $datos_empleado["primer_nombre"]." ".$datos_empleado["primer_apellido"]; ?></td>
                                        <td><?php echo $prestamo["tipo_movimiento"]; ?></td>
                                        <td><?php echo $prestamo["fecha_movimiento"] ?></td>
                                        <td><?php echo $prestamo["detalles"] ?></td>
                                        <td>
                                            <a href="editar.php?No_movimiento=<?php echo $prestamo["No_movimiento"] ?>" class="btn btn-warning">Editar</a>
                                        </td>
                                        <td>
                                            <a href="eliminar.php?No_movimiento=<?php echo $prestamo["No_movimiento"]; ?>"
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
        <img src="../../../imagen/buho_logo.jpeg" height="300px" alt="buho_logo">
    </div>
</div>
<?php include ("../../Template/footer.php"); ?>