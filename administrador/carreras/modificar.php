<?php include("../template/cabecera.php"); ?>

<?php
    $sndResolucion=(isset($_POST["fndResolucion"]))?$_POST["fndResolucion"]:"";
    $txtResolucion=(isset($_POST["txtResolucion"]))?$_POST["txtResolucion"]:"";
    $txtCodigo=(isset($_POST["txtCodigo"]))?$_POST["txtCodigo"]:"";
    $txtNombre=(isset($_POST["txtNombre"]))?$_POST["txtNombre"]:"";
    $txtCantidad_anios=(isset($_POST["txtCantidad_anios"]))?$_POST["txtCantidad_anios"]:"";
    $txtTipo=(isset($_POST["txtTipo"]))?$_POST["txtTipo"]:"";
    $txtAnio_inicio=(isset($_POST["txtAnio_inicio"]))?$_POST["txtAnio_inicio"]:"";
    $accion=(isset($_POST["accion"]))?$_POST["accion"]:"";

    include("../../config/conexionBD.php");

    switch ($accion) {
        case "Modificar":
            $sentenciaSQL=$conexion->prepare("SELECT * FROM carreras WHERE resolucion=:resolucion");
            $sentenciaSQL->bindParam(':resolucion', $sndResolucion);
            $sentenciaSQL->execute();
            $dato=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
            $bdResolucion=(isset($dato["resolucion"]))?$dato["resolucion"]:"";
            if ($_POST["fndResolucion"]==$bdResolucion) {
                $_SESSION['varTemp'] = $sndResolucion;
                $txtResolucion=$dato['resolucion'];
                $txtCodigo=$dato['codigo'];
                $txtNombre=$dato['nombre'];
                $txtCantidad_anios=$dato['cantidad_anios'];
                $txtTipo=$dato['tipo'];
                $txtAnio_inicio=$dato['anio_inicio'];
            }
            break;
        case "Guardar":
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
                $valido = true;
                $sentenciaSQL=$conexion->prepare("SELECT * FROM carreras");
                $sentenciaSQL->execute(); 
                $listaCarreras=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
                foreach($listaCarreras as $carrera) {
                    if (($carrera['resolucion']==$txtResolucion) && ($txtResolucion!= $_SESSION['varTemp'])) {
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
                    $sentenciaSQL=$conexion->prepare("UPDATE carreras SET resolucion=:resolucion, codigo=:codigo, nombre=:nombre, cantidad_anios=:cantidad_anios, tipo=:tipo, anio_inicio=:anio_inicio WHERE resolucion=:oldResolucion");
                    $sentenciaSQL->bindParam(':resolucion', $txtResolucion);
                    $sentenciaSQL->bindParam(':codigo', $txtCodigo);
                    $sentenciaSQL->bindParam(':nombre', $txtNombre);
                    $sentenciaSQL->bindParam(':cantidad_anios', $txtCantidad_anios);
                    $sentenciaSQL->bindParam(':tipo', $txtTipo);
                    $sentenciaSQL->bindParam(':anio_inicio', $txtAnio_inicio);
                    $sentenciaSQL->bindParam(':oldResolucion', $_SESSION['varTemp']);
                    $sentenciaSQL->execute();
                    echo '
                    <script type="text/javascript">
                        $(document).ready(function(){
                            swal({
                                position: "center",
                                type: "success",
                                title: "Los datos fueron guardados",
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
    }
?>

<br>
<div class="card col-md-8 mx-auto">
    <div class="card-header">
        <h3> Datos de la carrera a modificar </h3>
    </div>
    <div class="card-body">
        <div class="row" justif-content-center>
            <div class="col-md-12">
                <input type="text" class="form-control" name="sndResolucion" value="<?php echo $sndResolucion; ?>" id="sndResolucion" hidden>
                <form method="POST">
                    <div class="form-row">
                        <div class="col-md-9">
                            <div class="md-form form-group">
                                <label for="txtResolucion">Número de resolución</label>
                                <input type="text" class="form-control col-md-3" pattern="*" maxlength="8" name="txtResolucion" value="<?php echo $txtResolucion; ?>" id="txtResolucion">   
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="md-form form-group">
                                <label class="float-right" for="txtCodigo">Código de resolución</label>
                                <input type="text" class="form-control col-md-10 float-right" pattern="*" maxlength="8" name="txtCodigo" value="<?php echo $txtCodigo; ?>" id="txtCodigo">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="md-form form-group">
                                <label for="txtNombre">Nombre de la carrera</label>
                                <input type="text" class="form-control" pattern="*" maxlength="60" name="txtNombre" value="<?php echo $txtNombre; ?>" id="txtNombre">   
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-9">
                            <div class="md-form form-group">
                                <label for="txtCantidad_anios">Cantidad de años</label>
                                <input type="text" inputmode="numeric" class="form-control col-md-3" pattern="\d*" maxlength="1" class="form-control col-md-4" name="txtCantidad_anios" value="<?php echo $txtCantidad_anios; ?>" id="txtCantidad_anios">   
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="md-form form-group">
                                <label class="float-right" for="txtTipo">Tipo de carrera</label>
                                <select class="form-control col-md-10 float-right" name="txtTipo" value="<?php echo $txtTipo; ?>" id="txtTipo">
                                    <option value="P" <?php echo $txtTipo=='P'?'selected':'' ;?>>Profesorado</option>
                                    <option value="T" <?php echo $txtTipo=='T'?'selected':'' ;?>>Tecnicatura</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-9">
                            <div class="md-form form-group">
                                <label for="txtAnio_inicio">Año de inicio</label>
                                <input type="text" inputmode="numeric" class="form-control col-md-3" pattern="\d*" maxlength="4" class="form-control col-md-4" name="txtAnio_inicio" value="<?php echo $txtAnio_inicio; ?>" id="txtAnio_inicio">   
                            </div>
                        </div>
                    </div>
                    <br>                            
                    <button type="button" class="btn btn-primary" onclick="location.href='../carreras.php'">Volver</button>
                    <button type="submit" name="accion" value="Guardar" class="btn btn-primary float-right">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>                             

<?php include("../template/pie.php"); ?>