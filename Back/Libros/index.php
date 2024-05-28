<?php
include("../../Template/header.php");
include ("../../Conection/ConectBD.php");
include ("libro.php");

$db = new ConexionBDPDO();
$conexion = $db->conectar();
$consultasql = "SELECT * FROM libro WHERE 1=1";
$valores = [];
$libro = new Libro();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $libro->setnombre_Autor($_POST['nombre_autor']);
    $libro->setnombre_Titulo($_POST['nombre_libro']);
    $libro->setCategoria($_POST['genero']);
    $libro->setEstado($_POST['estado']);

    $nombre_autor = $libro->getnombre_Autor();
    $nombre_libro = $libro->getnombre_Titulo();
    $categoria = $libro->getCategoria();
    $estado = $libro->getEstado();

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
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Autor</th>
                                    <th scope="col">Categoria</th>
                                    <th scope="col">Ubicacion</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stm = $conexion->prepare($consultasql);
                                $stm->execute($valores);
                                $listaLibros = $stm->fetchAll();

                                foreach ($listaLibros as $lib) { ?>
                                    <tr>
                                        <td><?php echo $lib["id_libro"]; ?></td>
                                        <td><?php echo $lib["nombre_libro"]; ?></td>
                                        <td><?php echo $lib["nombre_autor"]; ?></td>
                                        <td><?php echo $lib["categoria"]; ?></td>
                                        <td><?php echo $lib["No_estanteria"]; ?></td>
                                        <td><?php echo $lib["estado"] == 1 ? "Disponible" : "En prestamo"; ?></td>
                                        <td>
                                            <a href="editar.php?id_libro=<?php if ($lib["estado"] == 1) {
                                                echo $lib["id_libro"];
                                            } else {
                                        
                                            } ?>" class="btn btn-warning">Editar</a>
                                        </td>
                                        <td>
                                            <a href="eliminar.php?id_libro=<?php echo $lib["estado"] == 1 ? $lib["id_libro"] : ''; ?>" class="btn btn-danger">Eliminar</a>
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
        <img src="../../../imagen/buho_logo.jpeg" height="300px" alt="buho_logo">
    </div>
</div>
<?php include ("../../Template/footer.php"); ?>