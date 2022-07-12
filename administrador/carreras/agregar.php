<?php include("../template/cabecera.php"); ?>

<?php
    $url="http://".$_SERVER["HTTP_HOST"]."/instituto_87";
    $txtResolucion=(isset($_POST["txtResolucion"]))?$_POST["txtResolucion"]:"";
    $txtNombre=(isset($_POST["txtNombre"]))?$_POST["txtNombre"]:"";
    $txtCantidad_anios=(isset($_POST["txtCantidad_anios"]))?$_POST["txtCantidad_anios"]:"";
    $txtTipo=(isset($_POST["txtTipo"]))?$_POST["txtTipo"]:"";
    $txtAnio_inicio=(isset($_POST["txtAnio_inicio"]))?$_POST["txtAnio_inicio"]:"";
    $accion=(isset($_POST["accion"]))?$_POST["accion"]:"";

    include("../../config/conexionBD.php");

    switch ($accion) {
        case "Agregar":
            if (($txtResolucion=="") || ($txtNombre=="") || ($txtCantidad_anios=="") || ($txtAnio_inicio=="")) {
                echo "<script> alert('Faltan datos...'); </script>";
            }    
            else {
                $sentenciaSQL=$conexion->prepare("INSERT INTO carreras (resolucion, nombre, cantidad_anios, tipo, anio_inicio) VALUES (:resolucion, :nombre, :cantidad_anios, :tipo, :anio_inicio);");
                $sentenciaSQL->bindParam(':resolucion', $txtResolucion);
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
            }    
            break;
    }
?>

    <div class="card">
        <div class="card-header">
            Datos de la carrera a ingresar
        </div>
        <div class="card-body">
            <div class="row" justif-content-center>
                <div class="col-md-12">
                    <form method="POST">
                        <br/>
                        <div class="form-group row">
                            <label for="txtResolucion" class="col-md-2 col-form-label">Número de resolución</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" name="txtResolucion" id="txtResolucion" placeholder="Ingrese la resolución de la carrera">
                            </div>
                        </div>
                        <br/>
                        <div class="form-group row">
                            <label for="txtNombre" class="col-md-2 col-form-label">Nombre de la carrera</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" name="txtNombre" id="txtNombre" placeholder="Ingrese el nombre de la carrera">
                            </div>
                        </div>
                        <br/>
                        <div class="form-group row">
                            <label for="txtCantidad_anios" class="col-md-2 col-form-label">Cantidad de años</label>
                            <div class="col-md-10">
                                <input type="number" class="form-control" name="txtCantidad_anios" id="txtCantidad_anios" placeholder="Ingrese cuántos años tiene la carrera">
                            </div>
                        </div>
                        <br/>
                        <div class = "form-group row">
                            <label for="txtTipo" class="col-md-2 col-form-label">Tipo de carrera</label>
                            <div class="col-md-10">
                                <select class="form-control" name="txtTipo" id="txtTipo">
                                    <option>Profesorado</option>
                                    <option>Tecnicatura</option>
                                </select>   
                            </div> 
                        </div>
                        <br/>
                        <div class="form-group row">
                            <label for="txtAnio_inicio" class="col-md-2 col-form-label">Año de inicio</label>
                            <div class="col-md-10">
                                <input type="number" class="form-control" name="txtAnio_inicio" id="txtAnio_inicio" placeholder="Ingrese año de inicio de la carrera">
                            </div>
                        </div>
                        <br/>
                        <button type="submit" name="accion" value="Agregar" class="btn btn-primary">Agregar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php include("../template/pie.php"); ?>