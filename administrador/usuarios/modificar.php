<?php include("../template/cabecera.php"); ?>

<?php
    include("../../config/conexionBD.php");
    
    $oldNombre=(isset($_SESSION["nombreUsuario"]))?$_SESSION["nombreUsuario"]:"";
    $txtNombre=(isset($_POST["txtNombre"]))?$_POST["txtNombre"]:"";
    $txtClave=(isset($_POST["txtClave"]))?$_POST["txtClave"]:"";
    $txtClave1=(isset($_POST["txtClave1"]))?$_POST["txtClave1"]:"";
    $txtClave2=(isset($_POST["txtClave2"]))?$_POST["txtClave2"]:"";
    $accion=(isset($_POST["accion"]))?$_POST["accion"]:"";

    switch ($accion) {
        case "Modificar":
            $sentenciaSQL=$conexion->prepare("SELECT * FROM usuarios WHERE nombre=:nombre");
            $sentenciaSQL->bindParam(':nombre', $oldNombre);
            $sentenciaSQL->execute();
            $dato=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
            $txtNombre=$dato['nombre'];
            $txtClave=$dato['clave'];
        break;
        case "Guardar":
            if ($txtNombre=="") {
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
            } else if (($txtClave1!="") && ($txtClave1!=$txtClave2)) {
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
            } else {
                $valido = true;
                $sentenciaSQL=$conexion->prepare("SELECT * FROM usuarios");
                $sentenciaSQL->execute(); 
                $listaUsuarios=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
                foreach($listaUsuarios as $usuario) {
                    if (($usuario['nombre']==$txtNombre) && ($txtNombre!=$_SESSION['nombreUsuario'])) {
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
                    $sentenciaSQL=$conexion->prepare("UPDATE usuarios SET nombre=:nombre, clave=:clave WHERE nombre=:oldResolucion");
                    $sentenciaSQL->bindParam(':nombre', $txtNombre);
                    if ($txtClave1=="") {
                        $sentenciaSQL->bindParam(':clave', $txtClave);
                    } else {
                        $sentenciaSQL->bindParam(':clave', $txtClave1);
                    }
                    $sentenciaSQL->bindParam(':oldResolucion', $_SESSION['nombreUsuario']);
                    $sentenciaSQL->execute();
                    $_SESSION['nombreUsuario'] = $txtNombre;
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
                        setTimeout( function() { window.location.href = "../usuarios.php"; }, 1500 );
                    </script>
                    ';
                }
            }
        break;
    }
?>

<br>
<div class="card col-md-5 mx-auto">
    <div class="card-header">
        <h3> Datos del usuario a modificar </h3>
    </div>
    <div class="card-body">
        <div class="row" justif-content-center>
            <div class="col-md-12">
                <input type="text" class="form-control" name="oldNombre" value="<?php echo $oldNombre; ?>" id="oldNombre" hidden>  
                <form method="POST">
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="md-form form-group">
                                <label for="txtNombre">Nombre de usuario</label>
                                <input type="text" class="form-control" pattern="*" maxlength="30" name="txtNombre" value="<?php echo $txtNombre; ?>" id="txtNombre">   
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="md-form form-group">
                                <label for="txtClave">Antigua contraseña</label>
                                <input type="password" class="form-control" pattern="*" maxlength="30" name="txtClave" value="<?php echo $txtClave; ?>" id="txtClave" readonly>   
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="md-form form-group">
                                <label for="txtClave1">Nueva contraseña</label>
                                <input type="password" class="form-control" pattern="*" maxlength="30" name="txtClave1" value="" id="txtClave1">   
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="md-form form-group">
                                <label for="txtClave2">Repetir contraseña</label>
                                <input type="password" class="form-control" pattern="*" maxlength="30" name="txtClave2" value="" id="txtClave2">   
                            </div>
                        </div>
                    </div>
                    <br>                            
                    <button type="button" class="btn btn-primary" onclick="location.href='../usuarios.php'">Volver</button>
                    <button type="submit" name="accion" value="Guardar" class="btn btn-primary float-right">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>                             

<?php include("../template/pie.php"); ?>