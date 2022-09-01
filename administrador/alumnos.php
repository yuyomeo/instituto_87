<?php include("template/cabecera.php"); ?>

<?php
    include("../config/conexionBD.php");
    $sentenciaSQL=$conexion->prepare("SELECT * FROM alumnos");
    $sentenciaSQL->execute(); 
    $listaAlumnos=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
    $_SESSION["varDocumento"] = (isset($_POST["fndDocumento"]))?$_POST["fndDocumento"]:"";
    $accion=(isset($_POST["accion"]))?$_POST["accion"]:"";

    switch ($accion) {
        case "Ver":
            echo '
            <script>
                window.onload = function () {
                    abrirModal();    
                };
                function abrirModal() {
                    $("#verModal").modal("show");
                }
            </script>
            ';
        break;
    }
?>

<div class="card-deck"> 
    <div class="card col-lg-12 mb-4">
        <div class="card-block">
            <h4 class="card-title">Menú de Alumnos</h4>
            <div class="card-body">
                <form method="post">
                    <div class="row">
                        <div class="col-10">
                            <table class="table table-striped table-bordered" style="width: 100%" id="tabla">
                                <thead>
                                    <th>Documento</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                </thead>
                                <tbody>
                                    <?php foreach($listaAlumnos as $alumno) { ?>
                                    <tr>    
                                        <td><?php echo $alumno['documento']; ?></td>
                                        <td><?php echo $alumno['nombre']; ?></td>
                                        <td><?php echo $alumno['apellido']; ?></td>
                                    </tr>
                                    <?php } ?>     
                                </tbody>
                            </table>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label for="fndDocumento"></label>
                                <input type="text" class="form-control" name="fndDocumento" id="fndDocumento" hidden>
                            </div>
                            <div class="btn-toolbar">
                                <button type="button" class="btn btn-primary btn-block mt-3 mb-3" style="width: 100%" onclick="location.href='alumnos/agregar.php'">Agregar</button> 
                                <button type="submit" class="btn btn-primary btn-block mt-3 mb-3" style="width: 100%" name="accion" value="Modificar" id="Modificar" formaction="alumnos/modificar.php" disabled>Modificar</button>
                                <button type="submit" class="btn btn-primary btn-block mt-3 mb-3" style="width: 100%" name="accion" value="Eliminar" id="Eliminar" formaction="alumnos/eliminar.php" disabled>Eliminar</button>
                                <button type="submit" class="btn btn-primary btn-block mt-3 mb-3" style="width: 100%" name="accion" value="Ver" id="Ver" disabled>Ver</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="verModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- cabecera del diálogo -->
            <div class="modal-header">
                <h4 class="modal-title">Alumno</h4>
                <button type="button" class="close cerrarVerModal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <!-- cuerpo del diálogo -->
            <div class="modal-body">
                <?php
                $sentenciaSQL=$conexion->prepare("SELECT * FROM alumnos WHERE documento=:documento");
                $sentenciaSQL->bindParam(':documento', $_SESSION["varDocumento"]);
                $sentenciaSQL->execute();
                $dato=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
                $txtDocumento = $dato['documento'];
                $txtNombre = $dato['nombre'];
                $txtApellido = $dato['apellido'];
                echo $txtDocumento;
                echo "  ";
                echo $txtNombre;
                echo "  ";
                echo $txtApellido;
                ?>
            </div>
            <!-- pie del diálogo -->
            <div class="modal-footer">
                <button type="button" class="btn btn-primary cerrarVerModal">Cerrar</button>
            </div>
        </div>
    </div>
</div>       
        
<script src="<?php echo $url;?>/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo $url;?>/js/jquery-3.5.1.js"></script>
<script src="<?php echo $url;?>/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $url;?>/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo $url;?>/js/popper.min.js"></script>

<script>
    $(document).ready(function () {
        var table = $('#tabla').DataTable({
            "language": {
                "url": "<?php echo $url;?>/json/spanish.json"
            },
            "pageLength": 8,
            "lengthChange": false,
            "pagingType": "full",   
        });
        $('#tabla tbody').on('click', 'tr', function () {
            var pikDocumento = table.row( this ).data()[0];       
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
                document.getElementById("fndDocumento").value = "";
                document.getElementById("Modificar").disabled = true;
                document.getElementById("Eliminar").disabled = true;
                document.getElementById("Ver").disabled = true;
            } else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
                document.getElementById("fndDocumento").value = pikDocumento;
                document.getElementById("Modificar").disabled = false;
                document.getElementById("Eliminar").disabled = false;
                document.getElementById("Ver").disabled = false;
            }
        });       
    });
</script>

<script>
    $(".cerrarVerModal").click(function(){
    $("#verModal").modal("hide")
    });
</script>

<?php include("template/pie.php"); ?>