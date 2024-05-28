<?php
include ("../../Template/header.php");
include_once "../../Conection/ConectBD.php";
$bd = new ConexionBDPDO();
$conect = $bd->conectar();
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
                                <label for="" class="form-label">Número de documento</label>
                                <input type="text" class="form-control" name="no_documento" aria-describedby="helpId"
                                    placeholder="Número de documento" required />
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Primer nombre</label>
                                <input type="text" class="form-control" name="primer_nombre" aria-describedby="helpId"
                                    placeholder="Primer nombre" required />
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">segundo nombre</label>
                                <input type="text" class="form-control" name="segundo_nombre" aria-describedby="helpId"
                                    placeholder="Segundo Nombre" />
                            </div>

                            <div class="mb-3">
                                <label for="" class="form-label">Primer Apellido</label>
                                <input type="text" class="form-control" name="primer_apellido" id="categoria"
                                    aria-describedby="helpId" placeholder="Primer Apellido" requiered />
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Segundo Apellido</label>
                                <input type="text" class="form-control" name="segundo_apellido"
                                    aria-describedby="helpId" placeholder="Segundo Apellido" required />
                            </div>

                            <div class="mb-3">
                                <label for="" class="form-label">Telefono</label>
                                <input type="text" class="form-control" name="telefono" aria-describedby="helpId"
                                    placeholder="Número De Telefono" required />
                            </div>

                            <div class="form-group"><button class="btn btn-success">Guardar información del
                                    clientes</button>
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
include ("cliente.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevoCliente = new Cliente();
    $nuevoCliente->setCedula($_POST['no_documento']);
    $No_documento = $nuevoCliente->getCedula();

    $call_procedure = "call traer_datos_cliente('$No_documento')";
    $resultados = $conect->prepare($call_procedure);
    $resultados->execute();
    $informacion_persona = $resultados->fetch();
    $resultados->closeCursor();
    if ($informacion_persona === false) {

        $nuevoCliente->setPrimer_nombre($_POST['primer_nombre']);
        $nuevoCliente->setSegundo_nombre($_POST['segundo_nombre']);
        $nuevoCliente->setPrimer_apellido($_POST['primer_apellido']);
        $nuevoCliente->setSegundo_apellido($_POST['segundo_apellido']);
        $nuevoCliente->setTelefono($_POST['telefono']);

        $primer_n = $nuevoCliente->getPrimer_nombre();
        $segundo_n = $nuevoCliente->getSegundo_nombre();
        $prime_a = $nuevoCliente->getPrimer_apellido();
        $segundo_a = $nuevoCliente->getSegundo_apellido();
        $telefono = $nuevoCliente->getTelefono();

        $call_procedure = "call agregar_cliente('$No_documento','$primer_n','$segundo_n','$prime_a','$segundo_a','$telefono')";
        $sentenciasql = $conect->prepare($call_procedure);
        $sentenciasql->execute();
        header("Location: Index.php");
    } else {
        echo "<div class='alert alert-warning' role='alert'>";
        echo "El número de documento o el telefono ya están registrados, por favor ingresar datos validos";
        echo "</div>";

    }
}

?>

<?php include ("../../Template/footer.php") ?>