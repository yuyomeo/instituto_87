<?php include("../template/cabecera.php"); ?>

<?php
    $url="http://".$_SERVER["HTTP_HOST"]."/instituto_87";
    $txtTipo=(isset($_POST["txtTipo"]))?$_POST["txtTipo"]:"";
    $txtDocumento=(isset($_POST["txtDocumento"]))?$_POST["txtDocumento"]:"";
    $txtNombre=(isset($_POST["txtNombre"]))?$_POST["txtNombre"]:"";
    $accion=(isset($_POST["accion"]))?$_POST["accion"]:"";

    include("../../config/conexionBD.php");

    switch ($accion) {
        case "Agregar":
            if (($txtDocumento=="") || ($txtNombre=="")) {
                echo "<script> alert('Faltan datos...'); </script>";
            }    
            else {
                $sentenciaSQL=$conexion->prepare("INSERT INTO alumnos (documento, tipo_documento, apellido, nombre, sexo, fecha_nacimiento, nacionalidad, provincia, localidad, codigo_postal, domicilio, numero_domicilio, piso, departamento, telefono, contacto_emergencia, email, titulo_secundario) VALUES (:documento, :tipo, 'PASTORINO', :nombre, 'M', '1975-05-23', 'ARGENTINA', 'BUENOS AIRES', 'AYACUCHO', 'B7150', 'PASTEUR', '550', NULL, NULL, '2494661097', NULL, 'javierfpastorino@gmail.com', '1');");
                $sentenciaSQL->bindParam(':documento', $txtDocumento);
                $sentenciaSQL->bindParam(':tipo', $txtTipo);
                $sentenciaSQL->bindParam(':nombre', $txtNombre);
                $sentenciaSQL->execute();
            }    
            break;
    }
?>

    <div class="card">
        <div class="card-header">
            Datos del alumno
        </div>
        <div class="card-body">
            <div class="row" justif-content-center>
                <div class="col-md-12">
                    <form method="POST">
                    <div class = "form-group row">
                        <label for="txtTipo" class="col-md-2 col-form-label">Tipo de documento</label>
                        <div class="col-md-10">
                            <select class="form-control" name="txtTipo" id="txtTipo">
                                <option>DNI</option>
                                <option>DU</option>
                                <option>LC</option>
                                <option>LE</option>
                            </select>   
                        </div> 
                    </div>
                    <br/>
                    <div class="form-group row">
                        <label for="txtDocumento" class="col-md-2 col-form-label">Número de documento</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="txtDocumento" id="txtDocumento" placeholder="Número de documento">
                        </div>
                    </div>
                    <br/>
                    <div class="form-group row">
                        <label for="txtNombre" class="col-md-2 col-form-label">Nombre del alumno</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="txtNombre" id="txtNombre" placeholder="Nombre del alumno">
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