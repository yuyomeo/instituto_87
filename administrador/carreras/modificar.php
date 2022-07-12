<?php include("../template/cabecera.php"); ?>

<?php
    $url="http://".$_SERVER["HTTP_HOST"]."/instituto_87";
    $modificar='disabled';
    $fndResolucion=(isset($_POST["fndResolucion"]))?$_POST["fndResolucion"]:"";
    $txtResolucion=(isset($_POST["txtResolucion"]))?$_POST["txtResolucion"]:"";
    $txtNombre=(isset($_POST["txtNombre"]))?$_POST["txtNombre"]:"";
    $txtCantidad_anios=(isset($_POST["txtCantidad_anios"]))?$_POST["txtCantidad_anios"]:"";
    $txtTipo=(isset($_POST["txtTipo"]))?$_POST["txtTipo"]:"";
    $txtAnio_inicio=(isset($_POST["txtAnio_inicio"]))?$_POST["txtAnio_inicio"]:"";
    $accion=(isset($_POST["accion"]))?$_POST["accion"]:"";

    include("../../config/conexionBD.php");

    switch ($accion) {
        case "Buscar":
            if ($fndResolucion=="") {
                echo "<script> alert('Faltan datos...'); </script>";
            }    
            else {
                $sentenciaSQL=$conexion->prepare("SELECT * FROM carreras WHERE resolucion=:resolucion");
                $sentenciaSQL->bindParam(':resolucion', $fndResolucion);
                $sentenciaSQL->execute();
                $dato=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
                $bdResolucion=(isset($dato["resolucion"]))?$dato["resolucion"]:"";
                if ($_POST["fndResolucion"]==$bdResolucion) {
                    $_SESSION['varTemp'] = $_POST["fndResolucion"];
                    $modificar='enabled';
                    $txtResolucion=$dato['resolucion'];
                    $txtNombre=$dato['nombre'];
                    $txtCantidad_anios=$dato['cantidad_anios'];
                    $txtTipo=$dato['tipo'];
                    $txtAnio_inicio=$dato['anio_inicio'];
                }
                else {
                    $mensaje = "Error: resolución no encontrada.";
                }
            }    
            break;
            case "Modificar":
                if (($txtResolucion=="") || ($txtNombre=="") || ($txtCantidad_anios=="") || ($txtAnio_inicio=="")) {
                    echo "<script> alert('Faltan datos...'); </script>";
                }    
                else {
                    $sentenciaSQL=$conexion->prepare("UPDATE carreras SET resolucion=:resolucion, nombre=:nombre, cantidad_anios=:cantidad_anios, tipo=:tipo, anio_inicio=:anio_inicio WHERE resolucion=:oldResolucion");
                    $sentenciaSQL->bindParam(':resolucion', $txtResolucion);
                    $sentenciaSQL->bindParam(':nombre', $txtNombre);
                    $sentenciaSQL->bindParam(':cantidad_anios', $txtCantidad_anios);
                    $sentenciaSQL->bindParam(':tipo', $txtTipo);
                    $sentenciaSQL->bindParam(':anio_inicio', $txtAnio_inicio);
                    $sentenciaSQL->bindParam(':oldResolucion', $_SESSION['varTemp']);
                    $sentenciaSQL->execute();           
                }    
                break;
    }
?>

<div class="card">
    <div class="card-header">
        Resolución de la carrera a modificar
    </div>
    <div class="card-body pb-4">
        <div class="row" justif-content-center>
            <div class="col-md-12">
                <form method="POST">               
                    <div class="form-group row">
                        <label for="fndResolucion" class="col-md-2 col-form-label">Número de resolución</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="fndResolucion" id="fndResolucion" placeholder="Ingrese la resolución de la carrera">
                        </div>
                        <div class="col-md-1">
                            <button type="submit" name="accion" value="Buscar" class="btn btn-primary">Buscar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>    
</div>
<div class="card">
    <div class="card-header">
        Datos de la carrera a modificar
    </div>
    <div class="card-body py-2">
        <div class="row" justif-content-center>
            <div class="col-md-12">
                <form method="POST">
                    <fieldset <?php echo $modificar;?>>               
                    <div class="form-group row">
                        <label for="txtResolucion" class="col-md-2 col-form-label">Número de resolución</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="txtResolucion" value="<?php echo $txtResolucion; ?>" id="txtResolucion" placeholder="Ingrese la resolución de la carrera">
                        </div>
                    </div>        
                    <div class="form-group row">
                        <label for="txtNombre" class="col-md-2 col-form-label">Nombre de la carrera</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="txtNombre" value="<?php echo $txtNombre; ?>" id="txtNombre" placeholder="Ingrese el nombre de la carrera">
                        </div>
                    </div>                    
                    <div class="form-group row">
                        <label for="txtCantidad_anios" class="col-md-2 col-form-label">Cantidad de años</label>
                        <div class="col-md-10">
                            <input type="number" class="form-control" name="txtCantidad_anios" value="<?php echo $txtCantidad_anios; ?>" id="txtCantidad_anios" placeholder="Ingrese cuántos años tiene la carrera">
                        </div>
                    </div>                    
                    <div class = "form-group row">
                        <label for="txtTipo" class="col-md-2 col-form-label">Tipo de carrera</label>
                        <div class="col-md-10">
                            <select class="form-control" name="txtTipo" value="<?php echo $txtTipo; ?>"id="txtTipo" selected>
                                <option value="P" <?php echo $txtTipo=='P'?'selected':'' ;?>>Profesorado</option>
                                <option value="T" <?php echo $txtTipo=='T'?'selected':'' ;?>>Tecnicatura</option>
                            </select>   
                        </div> 
                    </div>                   
                    <div class="form-group row">
                        <label for="txtAnio_inicio" class="col-md-2 col-form-label">Año de inicio</label>
                        <div class="col-md-10">
                            <input type="number" class="form-control" name="txtAnio_inicio" value="<?php echo $txtAnio_inicio; ?>" id="txtAnio_inicio" placeholder="Ingrese año de inicio de la carrera">
                        </div>
                    </div>
                    <br/>
                    <button type="submit" name="accion" value="Modificar" class="btn btn-primary">Modificar</button>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
  
<?php include("../template/pie.php"); ?>