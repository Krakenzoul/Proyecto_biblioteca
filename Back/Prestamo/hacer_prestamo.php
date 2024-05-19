<?php
   include ("../../Template/header.php");
   
   include ("prestamo.php");
   date_default_timezone_set('America/Mexico_City');
   
   $objdb = new ConexionBDPDO();
   $conexion = $objdb->conectar();
   $prestamo = new Prestamo();
   $informacion_libro = 0;
   $informacion_persona=0;
   $id_libro = 0;
   $nombre_columna = "";
   $verificar=0;
   $prestamo->setFecha(date('Y-m-d',time()));
   // Calcular la fecha 15 días después
   $prestamo->setFecha_devolucion(date("Y-m-d", strtotime($prestamo->getFecha() . ' + 15 days')));
   $fecha=$prestamo->getFecha();
   $fecha_devolucion=$prestamo->getFecha_devolucion();
   $_SESSION['libro'] = 0;
   ?>
<div>
<div class="container text-center">
   <h1>Información Del Prestamo</h1>
    <?php echo $fecha?>;
   <div class="row align-items-start">
      <div class="col">
         <div class='card'>
            <div class='card-header'>
               <h4>Información Del libro</h4>
            </div>
            <div class='card-body'>
               <div class='table-responsive-md'>
                  
                  <form method='post'>
                     <div class="mb-3">
                        <label for="" class="form-label">Id del libro</label>
                        <input type="text"  class="form-control" name="id_libro" id="id_libro"
                           aria-describedby="helpId" placeholder="Numero de identificación del Libro"
                           required />
                        <br> <button class="btn btn-success" name="boton_buscar_libro">Buscar Informacion
                        Libro</button>
                     </div>
                  </form>
                  <?php
                
                     if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        session_start();
                         //Esto hará la busqueda de los datos del libro solo con el id, verificara si existe o no el libro
                         if (isset($_POST['boton_buscar_libro'])) {
                             $prestamo->setId_libro($_POST['id_libro']);
                             $id_libro = $prestamo->getId_libro();
                             $_SESSION['libro']=$id_libro;
                             $sentenciasql = ("call nombre_libro($id_libro)");
                             $resultado = $conexion->prepare($sentenciasql);
                             $resultado->execute();
                             $informacion_libro = $resultado->fetch();
                             $verificar=1;
                             if (!$informacion_libro) {
                                 echo "<div class='alert alert-danger' role='alert'>";
                                 echo "el numero de Id no se encuentra registrado, ingrese un número valido";
                                 echo "</div>";
                             }
                             $resultado->closeCursor();
                         }
                     }
                     
                     ?>
                  <?php echo $prestamo->getId_libro() ?>
                  <div class="mb-3">
                     <label for="" class="form-label">Nombre Del Autor</label>
                     <input type="text" value="<?php $nombre_columna = "nombre_autor";
                        mostrar_datos($informacion_libro, $nombre_columna) ?>" class="form-control"
                        name="nombre_autor" id="nombre_autor" aria-describedby="helpId"
                        placeholder="Nombre Del Autor" <?php estado_input($informacion_libro) ?> />
                  </div>
                  <div class="mb-3">
                     <label for="" class="form-label">Titulo Del libro</label>
                     <input type="text" value="<?php $nombre_columna = "nombre_libro";
                        mostrar_datos($informacion_libro, $nombre_columna) ?>" class="form-control"
                        name="nombre_libro" id="nombre_libro" aria-describedby="helpId"
                        placeholder="Titulo Del libro" <?php estado_input($informacion_libro) ?> />
                  </div>
                  <div class="mb-3">
                     <label for="" class="form-label">Categoria</label>
                     <input type="text" value="<?php $nombre_columna = "categoria";
                        mostrar_datos($informacion_libro, $nombre_columna) ?>" class="form-control"
                        name="categoria" id="categoria" aria-describedby="helpId" placeholder="Categoria"
                        <?php estado_input($informacion_libro)?> />
                  </div>
                  <div class="mb-3">
                     <label for="" class="form-label">Número estanteria</label>
                     <input type="number" value="<?php $nombre_columna = "No_estanteria";
                        mostrar_datos($informacion_libro, $nombre_columna) ?>" class="form-control"
                        name="no_estanteria" id="no_estanteria" aria-describedby="helpId"
                        placeholder="Número estanteria" <?php estado_input($informacion_libro) ?> />
                  </div>
                  <div class="mb-3">
                     <label for="" class="form-label">Estado</label>
                     <input type="text" value="<?php if (!$informacion_libro) {
                        } else {
                            if ($informacion_libro["estado"] == 1) {
                                echo "Disponible";
                            } else {
                                echo "En prestamo";
                            }
                        } ?>" class="form-control" name="no_estanteria" id="no_estanteria"
                        aria-describedby="helpId" placeholder="Estado" <?php estado_input($informacion_libro); ?> />
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col">
         <div class='card'>
            <div class='card-header'>
               <h4>Información Del Ciente</h4>
            </div>
            <div class='card-body'>
               <div class='table-responsive-md'>
                  <form method="POST">
                     <div class="mb-3">
                        <label for="" class="form-label">Número De Documento</label>
                        <input type="number" class="form-control" name="no_documento" id="no_documento"
                           aria-describedby="helpId" placeholder="Número Cedula"  required />
                     </div>
                     <div class="mb-3">
                        <label for="" class="form-label">Primer Nombre</label>
                        <input type="text" class="form-control" name="primer_nombre" id="primer_nombre"
                           aria-describedby="helpId" placeholder="Nombre Del Autor" required enabled />
                     </div>
                     <div class="mb-3">
                        <label for="" class="form-label">Segundo Nombre</label>
                        <input type="text" class="form-control" name="segundo_nombre" id="segundo_nombre"
                           aria-describedby="helpId" placeholder="Titulo Del libro" />
                     </div>
                     <div class="mb-3">
                        <label for="" class="form-label">Primer Apellido</label>
                        <input type="text" class="form-control" name="primer_apellido" id="primer_apellido"
                           aria-describedby="helpId" placeholder="Primer Apellido" required />
                     </div>
                     <div class="mb-3">
                        <label for="" class="form-label">Segundo Apellido</label>
                        <input type="text" class="form-control" name="segundo_apellido"
                           id="segundo_apellido" aria-describedby="helpId" placeholder="Segundo apellido"
                           required />
                     </div>
                     <div class="mb-3">
                        <label for="" class="form-label">Número Telefónico</label>
                        <input type="number" class="form-control" name="telefono" id="telefono"
                           aria-describedby="helpId" placeholder="Número De Teléfono" required />
                     </div>
                </div>
                <div class="form-group">
                  
                 <button class="btn btn-success" name="generar_prestamo" <?php
                if($verificar === 0)
                  {echo"disabled";}
                  else{echo "enable";} ?> >Generar Prestamo</button>
                <a class="btn btn-info" href="Index.php" >Volver</a>
                 </div>
                 </form>
             </div>
                        
            <?php 
           
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST['generar_prestamo'])) {
                 
                    $prestamo->setCedula($_POST['no_documento']);
                    $no_documento=$prestamo->getCedula();    
                    $sentenciassql = ("call traer_datos_cliente($no_documento)");
                    $resultados = $conexion->prepare($sentenciassql);
                    $resultados->execute();
                    $informacion_persona = $resultados->fetch();
                    $id_libro=$_SESSION['libro'];
                   
                        if(!$informacion_persona){//no hay ningun cliente con esta cedula por lo tanto se registra el cliente

                            $prestamo->setPrimer_nombre($_POST['primer_nombre']);
                            $prestamo->setSegundo_nombre($_POST['segundo_nombre']);
                            $prestamo->setPrimer_apellido($_POST['primer_apellido']);
                            $prestamo->setSegundo_apellido($_POST['segundo_apellido']);
                            $prestamo->setTelefono($_POST['telefono']);
                              
                            $telefono=$prestamo->getTelefono();
                            $primer_n=$prestamo->getPrimer_nombre();
                            $segundo_n=$prestamo->getSegundo_nombre();
                            $prime_a=$prestamo->getPrimer_apellido();
                            $segundo_a=$prestamo->getSegundo_apellido();

                            
                            $sentenciassql=("call agregar_cliente($no_documento,$primer_n,$segundo_n,$prime_a,$segundo_a,$telefono)");
                            $resultados=$conexion->prepare($sentenciassql);
   
                            $resultados->execute(); 
                            
                            $sentenciassql=("call agregar_prestamo($id_libro,$no_documento,$fecha,$fecha_devolucion)");
                            $resultado=$conexion->prepare($sentenciassql);
                            $resultado->execute();
                        }else{//al parecer si hay un cliente, entonces solo se ejecuta agregar
                            echo "<script>console.log('no hay nadie registrado así que añade el cliente y el prestamo ');</script>";
                            $sentenciassql=("call agregar_prestamo($id_libro,$no_documento,$fecha,$fecha_devolucion)");
                            $resultados=$conexion->prepare($sentenciassql);
                            $resultados->execute();
                            
                        }
                    }
                }
            
            ?>
         </div>
      </div>
   </div>
</div>
</html>

    <?php
    include ("../../Template/footer.php");
    function estado_input($informacion_libro)
    {
        if (!$informacion_libro) {
            echo "enable";
        } else {
            echo "disabled";
        }
    }
    function mostrar_datos($informacion_libro, $info)
    {
        if (!$informacion_libro) {
        } else {
            echo $informacion_libro["$info"];
        }
    }
    ?>