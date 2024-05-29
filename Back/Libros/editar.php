<?php
include ("../../Template/header.php");
include ("../../Conection/ConectBD.php");
$objdb = new ConexionBDPDO();
$conexion = $objdb->conectar();
$id_libro = $_GET["id_libro"];
if ($id_libro > 0) {
    $sentenciasql = ("call nombre_libro($id_libro)");
    $resultado = $conexion->prepare($sentenciasql);
    $resultado->execute();
    $informacion_libro = $resultado->fetch();
    $resultado->closeCursor();

    $sql = "SELECT * FROM estanteria";
    $resultado_e = $conexion->prepare($sql);
    $resultado_e->execute();
    $estanterias = $resultado_e->fetchAll();
    $resultado_e->closeCursor();

    $sql = "SELECT * FROM empleado";
    $resultado_em = $conexion->prepare($sql);
    $resultado_em->execute();
    $empleados = $resultado_em->fetchAll();
    $resultado_em->closeCursor();
    if (!$informacion_libro) {
        exit("el libro no existe.........");
    }

    ?>


    <div class=contenesdor-index>
        <div class=div-index1-prestamo>
            <div style='border: 1px solid black; margin: 80px;'>
                <div class='card'>
                    <div class='card-header'>Editar información del Libro</div>
                    <div class='card-body'>
                        <div class='table-responsive-md'>
                            <form method='post'>
                                <div class="mb-3">
                                    <label for="" class="form-label">Nombre Del Autor</label>
                                    <input type="text" value="<?php echo $informacion_libro["nombre_autor"] ?>"
                                        class="form-control" name="nombre_autor" id="nombre_autor" aria-describedby="helpId"
                                        placeholder="Nombre Del Autor" required />
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Titulo Del libro</label>
                                    <input type="text" value="<?php echo $informacion_libro["nombre_libro"] ?>"
                                        class="form-control" name="nombre_libro" id="nombre_libro" aria-describedby="helpId"
                                        placeholder="Titulo Del libro" required />
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Categoria</label>
                                    <input type="text" value="<?php echo $informacion_libro["categoria"] ?>"
                                        class="form-control" name="categoria" id="categoria" aria-describedby="helpId"
                                        placeholder="Categoria" required />
                                </div>
                                <div class="mb-3">

                                    <label for="" class="form-label" required>Número estanteria: Número de la Estanteria
                                        actual: <?php echo $informacion_libro["No_estanteria"] ?></label>
                                    <select id="inputState" name="no_estanteria" class="form-select" required>
                                        <option selected value="">Selecciona una estanteria</option>
                                        <?php foreach ($estanterias as $categoria): ?>
                                            <option value="<?php echo $categoria['No_estanteria']; ?>">
                                                <?php echo "(" . $categoria['No_estanteria'] . ")" . $categoria['categoria']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label" required>Empleado Encargado</label>
                                    <select id="inputState" name="no_empleado" class="form-select" required>
                                        <option selected value="">Selecciona una estanteria</option>
                                        <?php foreach ($empleados as $empleado): ?>
                                            <option value="<?php echo $empleado['No_documento']; ?>">
                                                <?php echo "(" . $empleado['primer_nombre'] . " " . $empleado['primer_apellido']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Descripción</label>
                                    <input type="text" class="form-control" name="descripcion" id="categoria"
                                        aria-describedby="helpId"
                                        placeholder="¿Por qué se hace el cambio de la información?" size="30" minlength="5"
                                        required />
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
        $conexion = $objdb->conectar();
        $nuevolibro = new Libro();
        include ("../verificacion.php");
        $nuevolibro->setnombre_Titulo($_POST['nombre_libro']);
        $nuevolibro->setCategoria($_POST['categoria']);
        $nuevolibro->setnombre_Autor($_POST['nombre_autor']);
        $nuevolibro->setNo_estanteria($_POST['no_estanteria']);
        $no_estanteria = $nuevolibro->getNo_estanteria();
        $categoria = $nuevolibro->getCategoria();
        $nombre_titulo = $nuevolibro->getnombre_Titulo();
        $nombre_autor = $nuevolibro->getnombre_Autor();
        try {
            $campos = array($nombre_autor, $categoria);
            $errores = array();
            foreach ($campos as $campo) {
                if (verifica_valores_especiales($campo) || verifica_valores_numeros($campo)) {
                    $errores[] = "El campo contiene caracteres no válidos: " . $campo;
                }

            }

            if (!empty($errores)) {
                echo "<div class='alert alert-warning' role='alert'>";
                echo "Se encontraron errores en los siguientes campos:<br>";
                foreach ($errores as $error) {
                    echo "- " . $error . "<br>";
                }
                echo "</div>";
            } else {

                $sentenciasql = $conexion->prepare("UPDATE libro set No_estanteria=?,nombre_autor=?,nombre_libro=?,categoria=? where id_libro=?");
                $modificar_registro = $sentenciasql->execute([$no_estanteria, $nombre_autor, $nombre_titulo, $categoria, $id_libro]);

                $no_empleado = $_POST['no_empleado'];
                $tipo = "edicion";
                $descripcion = $_POST['descripcion'];

                $call_procedure = "call agregar_movimiento('$id_libro','$no_empleado','$tipo','$descripcion')";
                $sentenciasql = $conexion->prepare($call_procedure);
                $sentenciasql->execute();
                header("Location: Index.php");

            }
        } catch (PDOException $e) {

            echo "<div class='alert alert-warning' role='alert'>";
            echo "Hubo un error, por favor, vuelva a ingresar los datos: " . $e->getMessage();
            echo "</div>";
        }
    }

} else {
    header("Location: Index.php");

}
?>

<?php include ("../../Template/footer.php") ?>