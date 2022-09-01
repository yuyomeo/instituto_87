<!-- Incluimos la cabecera general (usuarios, carreras, materias...) -->
<?php include("template/cabecera.php"); ?>

<?php
    // Abrimos la conexion con la base de datos y leemos toda la tabla carreras
    include("../config/conexionBD.php");
    $sentenciaSQL=$conexion->prepare("SELECT * FROM carreras");
    $sentenciaSQL->execute(); 
    $listaCarreras=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    // Pasamos las variables de los inputs recibidas del Post a variables PHP
    $fndResolucion=(isset($_POST["fndResolucion"]))?$_POST["fndResolucion"]:"";
    $accion=(isset($_POST["accion"]))?$_POST["accion"]:"";
?>

<!-- Cuadros, tablas y botones que se muestran en pantalla -->
<div class="card-deck"> 
    <div class="card col-lg-12 mb-4">
        <div class="card-block">
            <h4 class="card-title">Menú de Carreras</h4>
            <div class="card-body">
                <!-- Todo lo que esté en este formulario será enviado en el método Post (inputs y botones submit) -->
                <form action="" method="POST">
                    <div class="row">
                        <div class="col-10">
                            <table class="table table-striped table-bordered" style="width: 100%" id="tabla">
                                <thead>
                                    <th>Resolución</th>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                </thead>
                                <tbody>
                                    <?php foreach($listaCarreras as $carrera) { ?>
                                    <tr>    
                                        <td><?php echo $carrera['resolucion']; ?></td>
                                        <td><?php echo $carrera['codigo']; ?></td>
                                        <td><?php echo $carrera['nombre']; ?></td>
                                    </tr>
                                    <?php } ?>     
                                </tbody>
                            </table>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label for="fndResolucion"></label>
                                <input type="text" class="form-control" name="fndResolucion" id="fndResolucion" hidden>
                            </div>
                            <div class="btn-toolbar">
                                <button type="button" class="btn btn-primary btn-block mt-3 mb-3" style="width: 100%" onclick="location.href='carreras/agregar.php'">Agregar Carrera</button> 
                                <button type="submit" class="btn btn-primary btn-block mt-3 mb-3" style="width: 100%" name="accion" value="Modificar" id="Modificar" formaction="carreras/modificar.php" disabled>Modificar Carrera</button>
                                <button type="submit" class="btn btn-primary btn-block mt-3 mb-3" style="width: 100%" name="accion" value="Eliminar" id="Eliminar" formaction="carreras/eliminar.php" disabled>Eliminar Carrera</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Usamos diferentes componentes javascript (usamos librerías) -->
<script src="<?php echo $url;?>/js/jquery-3.5.1.js"></script>
<script src="<?php echo $url;?>/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $url;?>/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo $url;?>/js/popper.min.js"></script>

<!-- Con este script le decimos a una tabla común que sea un datatable y que se comporte como nosotros queramos
Además de que hacer cuando se pulsa en una fila (como cambiar propiedades de los inputs o botones) -->
<script>
    $(document).ready(function () {
        var table = $('#tabla').DataTable({
            "language": {
                "url": "<?php echo $url;?>/json/spanish.json"
            },
            "columnDefs": [{  
                "width": "70%", "targets": 2,
            }], 
            "pageLength": 8,
            "lengthChange": false,
            "pagingType": "full",   
        });
        $('#tabla tbody').on('click', 'tr', function () {
            var pikResolucion = table.row( this ).data()[0];       
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
                document.getElementById("fndResolucion").value = "";
                document.getElementById("Modificar").disabled = true;
                document.getElementById("Eliminar").disabled = true;
            } else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
                document.getElementById("fndResolucion").value = pikResolucion;
                document.getElementById("Modificar").disabled = false;
                document.getElementById("Eliminar").disabled = false;
            }
        });
    });
</script>

<!-- Cerramos el formato que abrimos en la cabecera -->
<?php include("template/pie.php"); ?>