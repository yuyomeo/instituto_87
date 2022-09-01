<?php include("../template/cabecera.php"); ?>

<?php
    $sndDocumento=(isset($_POST["fndDocumento"]))?$_POST["fndDocumento"]:"";
    $txtTipo=(isset($_POST["txtTipo"]))?$_POST["txtTipo"]:"";
    $txtDocumento=(isset($_POST["txtDocumento"]))?$_POST["txtDocumento"]:"";
    $txtNombre=(isset($_POST["txtNombre"]))?$_POST["txtNombre"]:"";
    $txtApellido=(isset($_POST["txtApellido"]))?$_POST["txtApellido"]:"";
    $txtSexo=(isset($_POST["txtSexo"]))?$_POST["txtSexo"]:"";   
    $dateFecha_nacimiento=(isset($_POST["dateFecha_nacimiento"]))?$_POST["dateFecha_nacimiento"]:"";
    $txtNacionalidad=(isset($_POST["txtNacionalidad"]))?$_POST["txtNacionalidad"]:"";
    $txtProvincia=(isset($_POST["txtProvincia"]))?$_POST["txtProvincia"]:"";   
    $txtLocalidad=(isset($_POST["txtLocalidad"]))?$_POST["txtLocalidad"]:"";   
    $txtCodigo_postal=(isset($_POST["txtCodigo_postal"]))?$_POST["txtCodigo_postal"]:"";   
    $txtDomicilio=(isset($_POST["txtDomicilio"]))?$_POST["txtDomicilio"]:"";   
    $txtNumero_domicilio=(isset($_POST["txtNumero_domicilio"]))?$_POST["txtNumero_domicilio"]:"";   
    $txtPiso=(isset($_POST["txtPiso"]))?$_POST["txtPiso"]:"";   
    $txtDepartamento=(isset($_POST["txtDepartamento"]))?$_POST["txtDepartamento"]:"";   
    $txtTelefono=(isset($_POST["txtTelefono"]))?$_POST["txtTelefono"]:"";   
    $txtContacto_emergencia=(isset($_POST["txtContacto_emergencia"]))?$_POST["txtContacto_emergencia"]:"";   
    $txtEmail=(isset($_POST["txtEmail"]))?$_POST["txtEmail"]:"";   
    $txtTitulo_secundario=(isset($_POST["txtTitulo_secundario"]))?$_POST["txtTitulo_secundario"]:"";   
    $accion=(isset($_POST["accion"]))?$_POST["accion"]:"";

    include("../../config/conexionBD.php");

    switch ($accion) {
        case "Eliminar":
            $sentenciaSQL=$conexion->prepare("SELECT * FROM alumnos WHERE documento=:documento");
            $sentenciaSQL->bindParam(':documento', $sndDocumento);
            $sentenciaSQL->execute();
            $dato=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
            $bdDocumento=(isset($dato["documento"]))?$dato["documento"]:"";
            if ($_POST["fndDocumento"]==$bdDocumento) {
                $_SESSION['varTemp'] = $sndDocumento;
                $modificar='enabled';
                $txtTipo=$dato['tipo_documento'];
                $txtDocumento=$dato['documento'];
                $txtNombre=$dato['nombre'];
                $txtApellido=$dato['apellido'];
                $txtSexo=$dato['sexo'];
                $dateFecha_nacimiento=$dato['fecha_nacimiento'];
                $txtNacionalidad=$dato['nacionalidad'];
                $txtCodigo_postal=$dato['codigo_postal'];
                $txtLocalidad=$dato['localidad'];
                $txtProvincia=$dato['provincia'];
                $txtDomicilio=$dato['domicilio'];
                $txtNumero_domicilio=$dato['numero_domicilio'];
                $txtPiso=$dato['piso'];
                $txtDepartamento=$dato['departamento'];
                $txtTelefono=$dato['telefono'];
                $txtContacto_emergencia=$dato['contacto_emergencia'];
                $txtEmail=$dato['email'];
                $txtTitulo_secundario=$dato['titulo_secundario'];
            }
            break;
        case "Borrar":
            $sentenciaSQL=$conexion->prepare("DELETE FROM alumnos WHERE documento=:oldDocumento");
            $sentenciaSQL->bindParam(':oldDocumento', $_SESSION['varTemp']);
            $sentenciaSQL->execute();
            echo '
            <script type="text/javascript">
                $(document).ready(function(){
                    swal({
                        position: "center",
                        type: "success",
                        title: "El Alumno ha sido eliminado",
                        showConfirmButton: false,
                        timer: 1500
                    })
                });
                setTimeout( function() { window.location.href = "../alumnos.php"; }, 1500 );
            </script>
            ';
            break;
    }   
?>

<br>
<div class="card col-md-8 mx-auto">
    <div class="card-header">
        <h3> Eliminar Alumno </h3>
    </div>
    <div class="card-body">
        <div class="row" justif-content-center>
            <div class="col-mx-12">
                <input type="text" class="form-control" name="sndDocumento" value="<?php echo $sndDocumento; ?>" id="sndDocumento" hidden>
                <form method="POST">
                    <div class="form-row">
                        <div class="col-md-9">
                            <div class="md-form form-group">
                                <label for="txtDocumento">Documento</label>
                                <input type="text" class="form-control col-md-3" pattern="*" maxlength="8" name="txtDocumento" value="<?php echo $txtDocumento; ?>" id="txtDocumento">   
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class = "md-form form-group">
                                <label for="txtTipo">Tipo de documento</label>
                                <div class="col-md-10">
                                    <select class="form-control" name="txtTipo" id="txtTipo">
                                    <option>DNI</option>
                                    <option>DU</option>
                                    <option>LC</option>
                                    <option>LE</option>
                                    </select>   
                                </div> 
                            </div>                            
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-9">
                            <div class="md-form form-group">
                                <label for="txtNombre">Nombre del Alumno</label>
                                <input type="text" class="form-control col-md-3" pattern="*" maxlength="25" name="txtNombre" value="<?php echo $txtNombre; ?>" id="txtNombre">   
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-9">
                            <div class="md-form form-group">
                                <label for="txtApellido">Apellido del Alumno</label>
                                <input type="text" class="form-control col-md-3" pattern="*" maxlength="25" name="txtApellido" value="<?php echo $txtApellido; ?>" id="txtApellido">   
                            </div>
                        </div>
                            <div class="form-row">
                                <label for="txtSexo">Sexo</label>
                            <div class="col-md-10">
                                <input type="radio" class="form-check-input" name="txtSexo" id="txtSexo" value="M"> Masculino<br>
                                <input type="radio" class="form-check-input" name="txtSexo" id="txtSexo" value="F"> Femenino<br>
                                <input type="radio" class="form-check-input" name="txtSexo" id="txtSexo" value="O"> Otro<br>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-9">
                            <div class="md-form form-group">
                                <label for="dateFecha_nacimiento">Fecha de Nacimiento</label>
                                <input type="text" inputmode="date" class="form-control col-md-3"  class="form-control col-md-10" name="dateFecha_nacimiento" value="<?php echo $dateFecha_nacimiento; ?>" id="dateFecha_nacimiento">   
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-9">
                            <div class="md-form form-group">
                                <label for="txtNacionalidad" class="col-md-3 col-form-label">Nacionalidad</label>
                                <input type="text" class="form-control col-md-3" pattern="*" maxlength="25" name="txtNacionalidad" value="<?php echo $txtNacionalidad; ?>" id="txtNacionalidad">                            
                        </div> 
                    </div>
                    <div class="form-row">
                        <div class="col-md-9">
                            <div class="md-form form-group">                  
                                <label for="txtProvincia" class="col-md-10 col-form-label">Provincia</label>
                                <input type="text" class="form-control col-md-12" pattern="*" maxlength="25" name="txtProvincia" value="<?php echo $txtProvincia; ?>" id="txtProvincia">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-9">
                            <div class="md-form form-group">
                                <label for="txtLocalidad" class="col-md-9 col-form-label">Localidad</label>
                                <input type="text" class="form-control col-md-12" pattern="*" maxlength="25" name="txtLocalidad" value="<?php echo $txtLocalidad; ?>" id="txtLocalidad">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-10">
                            <div class="md-form form-group">
                                <label for="txtCodigo_postal" class="col-md-10 col-form-label">Codigo postal</label>
                                <input type="text" class="form-control col-md-6" name="txtCodigo_postal" value="<?php echo $txtCodigo_postal; ?>" id="txtCodigo_postal">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-9">
                            <div class="form-group row">
                                <label for="txtDomicilio" class="col-md-10 col-form-label">Domicilio del alumno</label>
                                <input type="text" class="form-control col-md-10" name="txtDomicilio" value="<?php echo $txtDomicilio; ?>" id="txtDomicilio">
                            </div>
                        </div>                   
                    </div>
                    <div class="form-row">
                        <div class="col-md-9">
                            <div class="form-group row">                        
                                <label for="txtNumero_domicilio" class="col-md-10 col-form-label">Numero de Domicilio del alumno</label>
                                <input type="text" class="form-control col-md-10" name="txtNumero_domicilio" value="<?php echo $txtNumero_domicilio; ?>" id="txtNumero_domicilio">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-9">
                            <div class="form-group row">
                                <label for="txtPiso" class="col-md-4 col-form-label">Piso</label>
                                <input type="text" class="form-control col-md-10" name="txtPiso" value="<?php echo $txtPiso; ?>" id="txtPiso">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-9">
                            <div class="form-group row">
                                <label for="txtDepartamento" class="col-md-9 col-form-label">Departamento</label>
                                <input type="text" class="form-control col-md-10" name="txtDepartamento" value="<?php echo $txtDepartamento; ?>" id="txtDepartamento">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-9">
                            <div class="form-group row">
                                <label for="txtTelefono" class="col-md-9 col-form-label">Telefono</label>
                                <input type="text" class="form-control col-md-10" name="txtTelefono" value="<?php echo $txtTelefono; ?>" id="txtTelefono">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-9">
                            <div class="form-group row">
                                <label for="txtContacto_emergencia" class="col-md-9 col-form-label">Telefono de emergencia</label>
                                <input type="text" class="form-control col-md-10" name="txtContacto_emergencia" value="<?php echo $txtContacto_emergencia; ?>" id="txtContacto_emergencia">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-9">
                            <div class="form-group row">
                                <label for="txtEmail" class="col-md-9 col-form-label">Email</label>
                                <input type="text" class="form-control col-md-14" name="txtEmail" value="<?php echo $txtEmail; ?>" id="txtEmail">
                            </div>
                        </div>
                    </div>                      
                    <div class="form-row">
                        <label for="txtTitulo_secundario" class="col-md-9 col-form-label">Titulo secundario</label>                        
                    </div>
                    <div class="col-md-10">
                        <input type="radio" class="form-check-input" name="txtTitulo_secundario" id="txtTitulo_secundario" value="1"> Si<br>
                        <input type="radio" class="form-check-input" name="txtTitulo_secundario" id="txtTitulo_secundario" value="0"> No<br>
                    </div>                      
                    <br> 
                    <div class="col-md-12">                             
                        <button type="button" class="btn btn-primary float-left" onclick="location.href='../alumnos.php'">Volver</button>
                        <button type="submit" name="accion" value="Borrar" class="btn btn-primary float-right">Borrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>                             

<?php include("../template/pie.php"); ?>