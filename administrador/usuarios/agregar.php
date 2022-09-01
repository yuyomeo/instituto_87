<?php include("../template/cabecera.php"); ?>

<?php
    $txtNombre=(isset($_POST["txtNombre"]))?$_POST["txtNombre"]:"";
    $txtClave=(isset($_POST["txtClave"]))?$_POST["txtClave"]:"";
    $txtClave2=(isset($_POST["txtClave2"]))?$_POST["txtClave2"]:"";
    $txtNivel=(isset($_POST["txtNivel"]))?$_POST["txtNivel"]:"";
    $accion=(isset($_POST["accion"]))?$_POST["accion"]:"";

    include("../../config/conexionBD.php");

    switch ($accion) {
        case "Agregar":
            if (($txtNombre=="") || ($txtClave=="") || ($txtClave2=="")) {
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
            else if ($txtClave==$txtClave2) {
                $valido = true;
                $sentenciaSQL=$conexion->prepare("SELECT * FROM usuarios");
                $sentenciaSQL->execute(); 
                $listaUsuarios=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
                foreach($listaUsuarios as $usuario) {
                    if ($usuario['nombre']==$txtNombre) {
                        $valido = false;
                        echo '
                        <script type="text/javascript">
                            $(document).ready(function(){
                                swal({
                                    position: "center",
                                    type: "error",
                                    title: "Este usuario ya existe...",
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
                    $sentenciaSQL=$conexion->prepare("INSERT INTO usuarios (nombre, clave, nivel) VALUES (:nombre, :clave, :nivel);");
                    $sentenciaSQL->bindParam(':nombre', $txtNombre);
                    $salt = uniqid(mt_rand(), true);
                    $hashClave = password_hash($txtClave, PASSWORD_DEFAULT);
                    $sentenciaSQL->bindParam(':clave', $hashClave);
                    if ($txtNivel=="Directivo") {
                        $numNivel=1;
                    }
                    else if ($txtNivel=="Preceptoría") {
                        $numNivel=2;
                    }
                    else {
                        $numNivel=3;    
                    }
                    $sentenciaSQL->bindParam(':nivel', $numNivel);
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
                        setTimeout( function() { window.location.href = "../usuarios.php"; }, 1500 );
                    </script>
                    ';
                }
            }
            else {
                $valido = false;
                        echo '
                        <script type="text/javascript">
                            $(document).ready(function(){
                                swal({
                                    position: "center",
                                    type: "error",
                                    title: "Las contraseñas no coinciden...",
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                            });
                        </script>
                        ';        
            }   
            break;
    }
?>

<br>
<div class="card col-md-5 mx-auto">
    <div class="card-header">
        <h3> Datos del usuario a ingresar </h3>
    </div>
    <div class="card-body">
        <div class="row" justif-content-center>
            <div class="col-md-12">
                <form method="POST">
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="md-form form-group">
                                <label for="txtNombre">Nombre de usuario</label>
                                <input type="text" class="form-control" pattern="*" maxlength="30" name="txtNombre" id="txtNombre">   
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="md-form form-group">
                                <label for="txtClave">Contraseña</label>
                                <input type="password" class="form-control" pattern="*" maxlength="30" name="txtClave" id="txtClave">   
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="md-form form-group">
                                <label for="txtClave2">Repetir contraseña</label>
                                <input type="password" class="form-control" pattern="*" maxlength="30" name="txtClave2" id="txtClave2">   
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="md-form form-group">
                                <label for="txtNivel">Nivel de acceso</label>
                                <select class="form-control col-md-12" name="txtNivel" id="txtNivel">
                                    <option>Directivo</option>
                                    <option>Preceptoría</option>
                                    <option>Alumno</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <br>
                    <button type="button" class="btn btn-primary" onclick="location.href='../usuarios.php'">Volver</button>
                    <button type="submit" name="accion" value="Agregar" class="btn btn-primary float-right">Agregar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include("../template/pie.php"); ?>