<?php include("../template/cabecera.php"); ?>

<?php
    include("../../config/conexionBD.php");
    $sentenciaSQL=$conexion->prepare("SELECT * FROM materias");
    $sentenciaSQL->execute(); 
    $listaMaterias=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
    $sndResolucion=(isset($_POST["fndResolucion"]))?$_POST["fndResolucion"]:"";
    $txtCodigo=(isset($_POST["txtCodigo"]))?$_POST["txtCodigo"]:"";
    $txtNombreMateria=(isset($_POST["txtNombreMateria"]))?$_POST["txtNombreMateria"]:"";
    $accion=(isset($_POST["accion"]))?$_POST["accion"]:"";

    include("../../config/conexionBD.php");

    switch ($accion) {
        case "Agregar":
            $sentenciaSQL=$conexion->prepare("SELECT * FROM carreras WHERE resolucion=:resolucion");
            $sentenciaSQL->bindParam(':resolucion', $sndResolucion);
            $sentenciaSQL->execute();
            $dato=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
            $bdResolucion=(isset($dato["resolucion"]))?$dato["resolucion"]:"";
            if ($_POST["fndResolucion"]==$bdResolucion) {
                $_SESSION['varResolucion'] = $sndResolucion;
                $txtResolucion=$dato['resolucion'];
                $_SESSION['varNombre']=$dato['nombre'];
                $_SESSION['varCantidad_anios']=$dato['cantidad_anios'];
                $_SESSION['varAnioCursada']=1;
            }
            break;
        case "Anterior":
            if ($_SESSION['varAnioCursada'] > 1) {
                $_SESSION['varAnioCursada']--;
            }    
            break;
        case "Siguiente":
            if ($_SESSION['varAnioCursada'] < $_SESSION['varCantidad_anios']) {
                $_SESSION['varAnioCursada']++;
            }
            break;
        case "Guardar":
            if (($txtCodigo=="") || ($txtNombreMateria=="")) {
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
                $sentenciaSQL=$conexion->prepare("SELECT * FROM materias");
                $sentenciaSQL->execute(); 
                $listaCarreras=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
                foreach($listaMaterias as $materia) {
                    if (($materia['resolucion']==$_SESSION['varResolucion']) && ($materia['codigo']==$txtCodigo) && ($materia['nombre']==$txtNombreMateria)) {
                        $valido = false;
                        echo '
                        <script type="text/javascript">
                            $(document).ready(function(){
                                swal({
                                    position: "center",
                                    type: "error",
                                    title: "Esta materia ya existe en esta carrera...",
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
                    $sentenciaSQL=$conexion->prepare("INSERT INTO materias (resolucion, codigo, nombre, anio) VALUES (:resolucion, :codigo, :nombre, :anio);");
                    $sentenciaSQL->bindParam(':resolucion', $_SESSION['varResolucion']);
                    $sentenciaSQL->bindParam(':codigo', $txtCodigo);
                    $sentenciaSQL->bindParam(':nombre', $txtNombreMateria);
                    $sentenciaSQL->bindParam(':anio', $_SESSION['varAnioCursada']);
                    $sentenciaSQL->execute();
                    header("location:agregar.php");
                }
            }    
            break;       
    }
?>

<div class="card-deck">
    
    <div class="card col-lg-8 mb-4">
        <div class="card-block">
            <h4 class="card-title">Materias de <?php echo $_SESSION['varNombre']; ?></h4>
            <div class="card-body">
                <form method="POST"> 
                    <div class="form-row">
                        <div class="col-md-3">
                            <div class="md-form form-group">
                                <label for="txtCodigo">Código de materia</label>
                                <input type="text" class="form-control col-md-10" pattern="*" maxlength="8" name="txtCodigo" value="<?php echo $txtCodigo; ?>" id="txtCodigo">
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="md-form form-group">
                                <label for="txtNombreMateria">Nombre de materia</label>
                                <input type="text" class="form-control" pattern="*" maxlength="30" name="txtNombreMateria" value="<?php echo $txtNombreMateria; ?>" id="txtNombreMateria">
                            </div>
                        </div>      
                    </div>
                    <button type="submit" name="accion" value="Guardar" class="btn btn-primary float-right">Agregar -></button>
                    <br><br>               
                </form>    
            </div>
        </div>

        <div class="card">
            <div class="card-block">
                <h4 class="card-title">Puede seleccionarla si aparece en el listado</h4>
                <div class="col-12">
                    <table class="table table-striped table-bordered" style="width: 100%" id="tabla1">
                        <thead>
                            <th>Código</th>
                            <th>Nombre</th>
                        </thead>
                        <tbody>
                            <?php
                                $sentenciaSQL=$conexion->prepare("SELECT DISTINCT codigo, nombre FROM materias");
                                $sentenciaSQL->execute(); 
                                $filtro1Materias=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <?php foreach($filtro1Materias as $filtro1) { ?>
                            <tr>
                                <td><?php echo $filtro1['codigo']; ?></td>
                                <td><?php echo $filtro1['nombre']; ?></td>
                            </tr>
                            <?php } ?>     
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <br>
    </div>

    <div class="card col-lg-4 mb-4">
        <div class="card-block">
            <form method="POST">  
                <h4 class="card-title">Materias para el año: <?php echo $_SESSION['varAnioCursada']; ?></h4>
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="md-form form-group">
                            <button type="submit" name="accion" value="Anterior" class="btn btn-primary" id="Anterior">Año anterior</button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="md-form form-group">
                            <button type="submit" name="accion" value="Siguiente" class="btn btn-primary float-right" id="Siguiente">Año siguiente</button>
                        </div>
                    </div>
                </div>
              
                <div class="col-12">
                    <table class="table table-striped table-bordered" style="width: 100%" id="tabla2">
                        <thead>
                            <th>Nombre</th>
                        </thead>
                        <tbody>
                            <?php
                                $sentenciaSQL=$conexion->prepare("SELECT * FROM materias WHERE resolucion=:resolucion AND anio=:anio");
                                $sentenciaSQL->bindParam(':resolucion', $_SESSION['varResolucion']);
                                $sentenciaSQL->bindParam(':anio', $_SESSION['varAnioCursada']);
                                $sentenciaSQL->execute(); 
                                $filtro2Materias=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <?php foreach($filtro2Materias as $filtro2) { ?>
                            <tr>
                                <td><?php echo $filtro2['nombre']; ?></td>
                            </tr>
                            <?php } ?>     
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-primary float-right" onclick="location.href='../materias.php'">Terminar</button>
                    <br><br>
                </div>
            </form>
        </div>
    </div>

</div>
                            
<script src="<?php echo $url;?>/js/jquery-3.5.1.js"></script>
<script src="<?php echo $url;?>/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $url;?>/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo $url;?>/js/popper.min.js"></script>

<script>
    $(document).ready(function () {
        var table1 = $('#tabla1').DataTable({
            "language": {
                "url": "<?php echo $url;?>/json/spanish.json"
            },
            "columnDefs": [{  
                "width": "70%", "targets": 1,
            }], 
            "info": false, 
            "pageLength": 3,
            "lengthChange": false,
            "pagingType": "full",   
        });
        $('#tabla1 tbody').on('click', 'tr', function () {
            var pikCodigo = table1.row( this ).data()[0];
            var pikNombreMateria = table1.row( this ).data()[1];       
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
                document.getElementById("txtCodigo").value = "";
                document.getElementById("txtCodigo").readOnly = false;
                document.getElementById("txtNombreMateria").value = "";
                document.getElementById("txtNombreMateria").readOnly = false;
            } else {
                table1.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
                document.getElementById("txtCodigo").value = pikCodigo;
                document.getElementById("txtCodigo").readOnly = true;
                document.getElementById("txtNombreMateria").value = pikNombreMateria;
                document.getElementById("txtNombreMateria").readOnly = true;
            }
        });
        $('#button').click(function () {
            table1.row('.selected').remove().draw(false);
            console.log( table1.row( this ).data() );
        });    
    });
</script>

<script>
    $(document).ready(function () {
        var table2 = $('#tabla2').DataTable({
            "language": {
                "url": "<?php echo $url;?>/json/spanish.json"
            },
            "searching": false,
            "info": false,
            "pageLength": 7,
            "lengthChange": false,
            "pagingType": "simple",
        });
    });
</script>

<?php include("../template/pie.php"); ?>