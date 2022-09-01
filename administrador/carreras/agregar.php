<!-- Incluimos la cabecera general (usuarios, carreras, materias...) -->
<?php include("../template/cabecera.php"); ?>

<?php
    // Pasamos las variables de los inputs recibidas del Post a variables PHP
    $txtResolucion=(isset($_POST["txtResolucion"]))?$_POST["txtResolucion"]:"";
    $txtCodigo=(isset($_POST["txtCodigo"]))?$_POST["txtCodigo"]:"";
    $txtNombre=(isset($_POST["txtNombre"]))?$_POST["txtNombre"]:"";
    $txtCantidad_anios=(isset($_POST["txtCantidad_anios"]))?$_POST["txtCantidad_anios"]:"";
    $txtTipo=(isset($_POST["txtTipo"]))?$_POST["txtTipo"]:"";
    $txtAnio_inicio=(isset($_POST["txtAnio_inicio"]))?$_POST["txtAnio_inicio"]:"";
    $accion=(isset($_POST["accion"]))?$_POST["accion"]:"";

    // Abrimos la conexion con la base de datos
    include("../../config/conexionBD.php");

    // Dependiendo de las acciones que tengamos en cada página realizamos el Case para cada situación
    switch ($accion) {
        case "Agregar_y_volver":
            // Si alguno de los campos necesarios están vacíos mostramos mensaje de error
            if (($txtResolucion=="") || ($txtCodigo=="") || ($txtNombre=="") || ($txtCantidad_anios=="") || ($txtAnio_inicio=="")) {
                echo '
                <script type="text/javascript">
                    $(document).ready(function(){
                        swal({
                            position: "center",
                            type: "error",
                            title: "Faltan datos...",
                            showConfirmButton: false,
                            timer: 1500
                        })
                    });
                </script>
                ';
            }    
            else {
                // Buscamos que la carrera a ingresar no exista anteriormente
                $valido = true;
                $sentenciaSQL=$conexion->prepare("SELECT * FROM carreras");
                $sentenciaSQL->execute(); 
                $listaCarreras=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
                foreach($listaCarreras as $carrera) {
                    if ($carrera['resolucion']==$txtResolucion) {
                        $valido = false;
                        echo '
                        <script type="text/javascript">
                            $(document).ready(function(){
                                swal({
                                    position: "center",
                                    type: "error",
                                    title: "Esta carrera ya existe...",
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                            });
                        </script>
                        ';
                        break;
                    }
                }
                if ($valido) {
                    // Pasamos los contenidos de las variables PHP como parámetro a la sentencia SQL
                    // Al ejecutar la sentencia guardamos en la base de datos la nueva carrera
                    $sentenciaSQL=$conexion->prepare("INSERT INTO carreras (resolucion, codigo, nombre, cantidad_anios, tipo, anio_inicio) VALUES (:resolucion, :codigo, :nombre, :cantidad_anios, :tipo, :anio_inicio);");
                    $sentenciaSQL->bindParam(':resolucion', $txtResolucion);
                    $sentenciaSQL->bindParam(':codigo', $txtCodigo);
                    $sentenciaSQL->bindParam(':nombre', $txtNombre);
                    $sentenciaSQL->bindParam(':cantidad_anios', $txtCantidad_anios);
                    if ($txtTipo=="Profesorado") {
                        $chrTipo='P';
                    }
                    else {
                        $chrTipo='T';
                    }
                    $sentenciaSQL->bindParam(':tipo', $chrTipo);
                    $sentenciaSQL->bindParam(':anio_inicio', $txtAnio_inicio);
                    $sentenciaSQL->execute();
                    echo '
                    <script type="text/javascript">
                        $(document).ready(function(){
                            swal({
                                position: "center",
                                type: "success",
                                title: "Los datos fueron agregados",
                                showConfirmButton: false,
                                timer: 1500
                            })
                        });
                        setTimeout( function() { window.location.href = "../carreras.php"; }, 1500 );
                    </script>
                    ';
                }
            }    
            break;

        case "Agregar_y_materias":
            // Si alguno de los campos necesarios están vacíos mostramos mensaje de error
            if (($txtResolucion=="") || ($txtCodigo=="") || ($txtNombre=="") || ($txtCantidad_anios=="") || ($txtAnio_inicio=="")) {
                echo '
                <script type="text/javascript">
                    $(document).ready(function(){
                        swal({
                            position: "center",
                            type: "error",
                            title: "Faltan datos...",
                            showConfirmButton: false,
                            timer: 1500
                        })
                    });
                </script>
                ';
            }    
            else {
                // Buscamos que la carrera a ingresar no exista anteriormente
                $valido = true;
                $sentenciaSQL=$conexion->prepare("SELECT * FROM carreras");
                $sentenciaSQL->execute(); 
                $listaCarreras=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
                foreach($listaCarreras as $carrera) {
                    if ($carrera['resolucion']==$txtResolucion) {
                        $valido = false;
                        echo '
                        <script type="text/javascript">
                            $(document).ready(function(){
                                swal({
                                    position: "center",
                                    type: "error",
                                    title: "Esta carrera ya existe...",
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                            });
                        </script>
                        ';
                        break;
                    }
                }
                if ($valido) {
                    // Pasamos los contenidos de las variables PHP como parámetro a la sentencia SQL
                    // Al ejecutar la sentencia guardamos en la base de datos la nueva carrera
                    $sentenciaSQL=$conexion->prepare("INSERT INTO carreras (resolucion, codigo, nombre, cantidad_anios, tipo, anio_inicio) VALUES (:resolucion, :codigo, :nombre, :cantidad_anios, :tipo, :anio_inicio);");
                    $sentenciaSQL->bindParam(':resolucion', $txtResolucion);
                    $sentenciaSQL->bindParam(':codigo', $txtCodigo);
                    $sentenciaSQL->bindParam(':nombre', $txtNombre);
                    $sentenciaSQL->bindParam(':cantidad_anios', $txtCantidad_anios);
                    if ($txtTipo=="Profesorado") {
                        $chrTipo='P';
                    }
                    else {
                        $chrTipo='T';
                    }
                    $sentenciaSQL->bindParam(':tipo', $chrTipo);
                    $sentenciaSQL->bindParam(':anio_inicio', $txtAnio_inicio);
                    $sentenciaSQL->execute();
                    echo '
                    <script type="text/javascript">
                        $(document).ready(function(){
                            swal({
                                position: "center",
                                type: "success",
                                title: "Los datos fueron agregados",
                                showConfirmButton: false,
                                timer: 1500
                            })
                        });
                        setTimeout( function() { window.location.href = "../materias/editar.php?fndResolucion='; echo $txtResolucion; echo '&accion=Editar"}, 1500 );
                    </script>
                    ';
                }
            }    
            break;
    }
?>

<!-- Cuadros, inputs y botones que se muestran en pantalla -->
<br>
<div class="card col-md-8 mx-auto">
    <div class="card-header">
        <h3> Datos de la carrera a ingresar </h3>
    </div>
    <div class="card-body">
        <div class="row" justif-content-center>
            <div class="col-md-12">
                <form method="POST">
                    <div class="form-row">
                        <div class="col-md-9">
                            <div class="md-form form-group">
                                <label for="txtResolucion">Número de resolución</label>
                                <input type="text" class="form-control col-md-3" pattern="*" maxlength="8" name="txtResolucion" id="txtResolucion">   
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="md-form form-group">
                                <label class="float-right" for="txtCodigo">Código de resolución</label>
                                <input type="text" class="form-control col-md-10 float-right" pattern="*" maxlength="8" name="txtCodigo" id="txtCodigo">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="md-form form-group">
                                <label for="txtNombre">Nombre de la carrera</label>
                                <input type="text" class="form-control" pattern="*" maxlength="60" name="txtNombre" id="txtNombre">   
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-9">
                            <div class="md-form form-group">
                                <label for="txtCantidad_anios">Cantidad de años</label>
                                <input type="text" inputmode="numeric" class="form-control col-md-3" pattern="\d*" maxlength="1" class="form-control col-md-4" name="txtCantidad_anios" id="txtCantidad_anios">   
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="md-form form-group">
                                <label class="float-right" for="txtTipo">Tipo de carrera</label>
                                <select class="form-control col-md-10 float-right" name="txtTipo" id="txtTipo">
                                    <option>Profesorado</option>
                                    <option>Tecnicatura</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-9">
                            <div class="md-form form-group">
                                <label for="txtAnio_inicio">Año de inicio</label>
                                <input type="text" inputmode="numeric" class="form-control col-md-3" pattern="\d*" maxlength="4" class="form-control col-md-4" name="txtAnio_inicio" id="txtAnio_inicio">   
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <button type="button" class="btn btn-primary" onclick="location.href='../carreras.php'">VOLVER</button>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" name="accion" value="Agregar_y_volver" class="btn btn-primary">AGREGAR</button>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" name="accion" value="Agregar_y_materias" class="btn btn-primary float-right">AGREGAR Y CARGAR MATERIAS</button>
                        </div>    
                    </div>                  
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Cerramos el formato que abrimos en la cabecera -->
<?php include("../template/pie.php"); ?>