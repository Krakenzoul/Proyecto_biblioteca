<?php
include ("../../Template/header.php");
?>

<div class=contenedor-index>
    <div class=div-index1-prestamo>
        <div style='border: 1px solid black; margin: 80px;'>
            <div class='card'>
                <div class='card-header'>Agregar Libro</div>
                <div class='card-body'>
                    <div class='table-responsive-md'>
                        <form method='post'>
                            <div class="mb-3">
                                <label for="" class="form-label">Nombre Del Autor</label>
                                <input type="text" class="form-control" name="nombre_autor" id="nombre_autor"
                                    aria-describedby="helpId" placeholder="Nombre Del Autor" required />
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Titulo Del libro</label>
                                <input type="text" class="form-control" name="nombre_libro" id="nombre_libro"
                                    aria-describedby="helpId" placeholder="Titulo Del libro" required />
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Categoria</label>
                                <input type="text" class="form-control" name="categoria" id="categoria"
                                    aria-describedby="helpId" placeholder="Categoria" required />
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Número estanteria</label>
                                <input type="number" class="form-control" name="no_estanteria" id="no_estanteria"
                                    aria-describedby="helpId" placeholder="Número estanteria" required />
                            </div>
                            <div class="form-group"><button class="btn btn-success">Guardar Registro</button>
                                <a class="btn btn-info" href="Index.php">Volver</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class=div-index2-prestamo>
        <img src=../../imagen/buho_logo.jpeg height=300px alt=buho_logo>
    </div>
</div>

<?php
include ("libro.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevolibro = new Libro();
    $bd = new ConexionBDPDO();
    $conect = $bd->conectar();
    $nuevolibro->setnombre_Titulo($_POST['nombre_libro']);
    $nuevolibro->setCategoria($_POST['categoria']);
    $nuevolibro->setnombre_Autor($_POST['nombre_autor']);
    $nuevolibro->setNo_estanteria($_POST['no_estanteria']);

    $no_estanteria = $nuevolibro->getNo_estanteria();
    $categoria = $nuevolibro->getCategoria();
    $nombre_titulo = $nuevolibro->getnombre_Titulo();
    $nombre_autor = $nuevolibro->getnombre_Autor();

    $call_procedure="call agregar_libro('$no_estanteria','$nombre_autor','$nombre_titulo','$categoria')";
    $sentenciasql=$conect->prepare($call_procedure);
    $sentenciasql->execute();
    header("Location: Index.php");
}

?>

<?php include ("../../Template/footer.php") ?>