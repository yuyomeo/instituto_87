<?php include("../template/cabecera.php"); ?>

<?php
    $url="http://".$_SERVER["HTTP_HOST"]."/instituto_87";
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
        case "Agregar":
            if (($txtDocumento=="") || ($txtNombre=="")) {
                echo "<script> alert('Faltan datos...'); </script>";
            }    
            else {
                $sentenciaSQL=$conexion->prepare("INSERT INTO alumnos (documento, tipo_documento, apellido, nombre, sexo, fecha_nacimiento, nacionalidad, provincia, localidad, codigo_postal, domicilio, numero_domicilio, piso, departamento, telefono, contacto_emergencia, email, titulo_secundario) VALUES (:documento, :tipo, :apellido, :nombre, :sexo, :fecha_nacimiento, :nacionalidad, :provincia, :localidad, :codigo_postal, :domicilio, :numero_domicilio, :piso, :departamento, :telefono, :contacto_emergencia, :email, :titulo_secundario);");
                $sentenciaSQL->bindParam(':documento', $txtDocumento);
                $sentenciaSQL->bindParam(':tipo', $txtTipo);
                $sentenciaSQL->bindParam(':nombre', $txtNombre);
                $sentenciaSQL->bindParam(':apellido', $txtApellido);
                $sentenciaSQL->bindParam(':sexo', $txtSexo);
                $sentenciaSQL->bindParam(':fecha_nacimiento', $dateFecha_nacimiento);
                $sentenciaSQL->bindParam(':nacionalidad', $txtNacionalidad);
                $sentenciaSQL->bindParam(':provincia', $txtProvincia);
                $sentenciaSQL->bindParam(':localidad', $txtLocalidad);
                $sentenciaSQL->bindParam(':codigo_postal', $txtCodigo_postal);
                $sentenciaSQL->bindParam(':domicilio', $txtDomicilio);
                $sentenciaSQL->bindParam(':numero_domicilio', $txtNumero_domicilio);
                $sentenciaSQL->bindParam(':piso', $txtPiso);
                $sentenciaSQL->bindParam(':departamento', $txtDepartamento);
                $sentenciaSQL->bindParam(':telefono', $txtTelefono);
                $sentenciaSQL->bindParam(':contacto_emergencia', $txtContacto_emergencia);
                $sentenciaSQL->bindParam(':email', $txtEmail);
                $sentenciaSQL->bindParam(':titulo_secundario', $txtTitulo_secundario);

                
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
                    <div class="form-group row">
                        <label for="txtApellido" class="col-md-2 col-form-label">Apellido del alumno</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="txtApellido" id="txtApellido" placeholder="Apellido del alumno">
                        </div>
                    </div>
                    <br/>
                    <div class="form-group row">
                        <label for="txtSexo" class="col-md-2 col-form-label">Sexo</label>
                        <div class="col-md-10">
                            <input type="radio" class="form-check-input" name="txtSexo" id="txtSexo" value="M"> Masculino<br>
                            <input type="radio" class="form-check-input" name="txtSexo" id="txtSexo" value="F"> Femenino<br>
                            <input type="radio" class="form-check-input" name="txtSexo" id="txtSexo" value="O"> Otro<br>
                        </div>
                    </div>
                    <br/>
                    <div class="form-group row">
                        <label for="dateFecha_nacimiento" class="col-md-2 col-form-label">Fecha de nacimiento</label>
                        <div class="col-md-10">
                            <input type="date" class="" name="dateFecha_nacimiento" id="dateFecha_nacimiento" placeholder="Fecha de nacimiento">
                        </div>
                    </div>
                    <br/>
                    <div class="form-group row">
                        <label for="txtNacionalidad" class="col-md-2 col-form-label">Nacionalidad</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="txtNacionalidad" id="txtNacionalidad" placeholder="Nacionalidad">
                        </div>
                    </div>
                    <br/>
                    <div class="form-group row">
                        <label for="txtProvincia" class="col-md-2 col-form-label">Provincia</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="txtProvincia" id="txtProvincia" placeholder="Provincia">
                        </div>
                    </div>
                    <br/>
                    <div class="form-group row">
                        <label for="txtLocalidad" class="col-md-2 col-form-label">Localidad</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="txtLocalidad" id="txtLocalidad" placeholder="Localidad">
                        </div>
                    </div>
                    <br/>
                    <div class="form-group row">
                        <label for="txtCodigo_postal" class="col-md-2 col-form-label">Codigo postal</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="txtCodigo_postal" id="txtCodigo_postal" placeholder="Codigo postal">
                        </div>
                    </div>
                    <br/>
                    <div class="form-group row">
                        <label for="txtDomicilio" class="col-md-2 col-form-label">Domicilio del alumno</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="txtDomicilio" id="txtDomicilio" placeholder="Domicilio del alumno">
                        </div>
                    </div>
                    <br/>
                    <div class="form-group row">
                        <label for="txtNumero_domicilio" class="col-md-2 col-form-label">Numero de Domicilio del alumno</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="txtNumero_domicilio" id="txtNumero_domicilio" placeholder="Numero de Domicilio del alumno">
                        </div>
                    </div>
                    <br/>                    
                    <div class="form-group row">
                        <label for="txtPiso" class="col-md-2 col-form-label">Piso</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="txtPiso" id="txtPiso" placeholder="Piso">
                        </div>
                    </div>
                    <br/>
                    <div class="form-group row">
                        <label for="txtDepartamento" class="col-md-2 col-form-label">Departamento</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="txtDepartamento" id="txtDepartamento" placeholder="Departamento">
                        </div>
                    </div>
                    <br/>
                    <div class="form-group row">
                        <label for="txtTelefono" class="col-md-2 col-form-label">Telefono</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="txtTelefono" id="txtTelefono" placeholder="Telefono">
                        </div>
                    </div>
                    <br/>
                    <div class="form-group row">
                        <label for="txtContacto_emergencia" class="col-md-2 col-form-label">Telefono de emergencia</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="txtContacto_emergencia" id="txtContacto_emergencia" placeholder="Telefono de emergencia">
                        </div>
                    </div>
                    <br/>
                    <div class="form-group row">
                        <label for="txtEmail" class="col-md-2 col-form-label">Email</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="txtEmail" id="txtEmail" placeholder="Email">
                        </div>
                    </div>
                    <br/>   
                    <div class="form-group row">
                        <label for="txtTitulo_secundario" class="col-md-2 col-form-label">Titulo secundario</label>
                        <div class="col-md-10">
                            <input type="radio" class="form-check-input" name="txtTitulo_secundario" id="txtTitulo_secundario" value="1"> Si<br>
                            <input type="radio" class="form-check-input" name="txtTitulo_secundario" id="txtTitulo_secundario" value="0"> No<br>
                        </div>
                    </div>
                    <br/>
                    <button type="button" class="btn btn-primary" onclick="location.href='../alumnos.php'">Volver</button>
                    <button type="submit" name="accion" value="Agregar" class="btn btn-primary float-right">Agregar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php include("../template/pie.php"); ?>