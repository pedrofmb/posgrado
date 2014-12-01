<?php
session_start();
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="es">
    <head>
        <title>Aula</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap -->
        <link href="lib_cliente/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="lib_cliente/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
        
        <script src="lib_cliente/jquery/jquery-1.11.1.min.js"></script>
        <script src="lib_cliente/bootstrap/js/bootstrap.min.js"></script>
        
        <!-- CSS -->
        <link href="lib_cliente/css/main.css" rel="stylesheet">
        <link rel="stylesheet" href="lib_cliente/media/css/jquery.dataTables.min.css" />
        <!-- javascript -->
        <script src="lib_cliente/scripts/main.js"></script>
        <script type="text/javascript" src="lib_cliente/media/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="lib_cliente/scripts/fnStandingRedraw.js"></script>
        
        <script>
	
	$(document).ready(function(){
	
	
	                var dt_options = {
                    "bProcessing": true,
                    "bRetrieve " : true,
                    "bDestroy " : true,
                    "language": { "url": "lib_cliente/scripts/Spanish.json"},
                    "aoColumns": [
                        {"mData": "id_aula", "bSearchable": false, "bVisible": true},
                        {"mData": "n_aula", "bSearchable": true},
                        {"mData": "aforo", "bSearchable": false},
			{"mData": "acciones", "bSearchable": false, "bSortable" : false}
                    ],
                    "bServerSide": true,
                    "sAjaxSource": "controlador/CrAula.php?opcion=listar",
                    "aoColumnDefs": [
                        {
                            "aTargets": [3],
                            "mData": "acciones",
                            "mRender": function ( data, type, full ) {
                                  return '<button type="button" class="btn btn-info">Modificar</button>&nbsp;<button type="button" class="btn btn-warning">Eliminar</button>';
                            }
                          }
                    ]
                };
				
	        var $tabla_registros     = $("#tabla_aulas");
                var $dt_tabla_registros = $tabla_registros.dataTable(dt_options);
				
	        $('#tabla_aulas tbody').off("click", "**");
				
				
	        $("#tabla_aulas tbody").on("click", "button", function( e ) {
                     var thatAction = $(this).html();
                     var canion = $dt_tabla_registros.api();
                     var data = canion.row($(this).parents('tr')).data();
                            if(thatAction === "Modificar"){
                                    $('#ModificarAulaModal').modal('toggle');
                                    $("#code_aula_modificar").html(data.id_aula);
                                    
                                    $("#InputAulaModificar").val(data.id_aula);
                                    $("#InputDescripcionAulaModificar").val(data.n_aula);
                                    $("#InputAforoAulaModificar").val(data.aforo);
                                    
                            }else if(thatAction === "Eliminar"){
                                if(confirm("Esta seguro que desea eliminar el aula con ID " + data.id_aula)){
                                   eliminarAula(data.id_aula,$dt_tabla_registros);
                                }
                            }
                });
                
                
	        $("#tabla_aulas tbody").on("click", "tr", function( e ) {
                    if ( $(this).hasClass('selected') ) {
                        $(this).removeClass('selected');
                    }else {
                        $dt_tabla_registros.$('tr.selected').removeClass('selected');
                        $(this).addClass('selected');
                    }
                });
				
		$("#btn_aceptar").click(function(){
                    AgregarAula($dt_tabla_registros);
                });
                
                $("#btn_aceptar_modificar").click(function(){
                    ModificarAula($dt_tabla_registros);
                });
                
                $("#Btn_nuevo_aula_modal").click(function(){
                    $("#InputDescripcionAula").val('');
                    $("#InputAforoAulaNuevo").val('');
                    $('#NuevoAulaModal').modal('toggle');
                });
				
	        function fnGetSelected( oTableLocal ){
                    return oTableLocal.$("tr.selected");
                }
				
	});
	
	
	 
	</script>
        
    </head>
    <body>
        
        <div id="contenedor_menu">
            <?php include_once 'Menu.php'; ?>            
        </div>
        
        <div id="contenedor_aula">
            
            <div clas="barra_botones">
                <h2>Gestionar Aulas</h2>
                <button type="button" class="btn btn-info" id="Btn_nuevo_aula_modal">
                    <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>
                    &nbsp;Nuevo
                </button>
            </div>
            
            <div style="margin-top:20px;">
                <table cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-condensed" id="tabla_aulas">
                        <thead>
                            <tr>
                                <th>Id Aula</th>
                                <th>Numero de Aula</th>
                                <th>Aforo</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
               </table>
            </div>
            
        </div>
        
        <div class="modal fade" id="NuevoAulaModal" tabindex="-1" role="dialog" aria-labelledby="modal-nuevo-aula-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Nueva Aula</h4>
                    </div>
                    <div class="modal-body">
                        <!--formulario?-->
                        <form role="form">
                                <div class="form-group">
                                  <label for="InputDescripcionAula">Numero de aula</label>
                                  <input type="text" class="form-control" id="InputDescripcionAula" maxlength="5" placeholder="Ingrese número de aula">
                                </div>
                                <div class="form-group">
                                  <label for="InputAforoAulaNuevo">Aforo</label>
                                  <input type="text" class="form-control" id="InputAforoAulaNuevo" placeholder="Ingrese aforo de aula">
                                </div>
                                <div style="text-align: right;">
                                    <span style="display: none;" id="loader_nuevo"><img src="lib_cliente/images/loader.GIF"></span>
                                    <button type="button" class="btn btn-success" id="btn_aceptar">Aceptar</button>
                                    <button type="button" class="btn btn-warning" id="btn_cancelar" onclick="CancelarAulaNuevo();">Cancelar</button>
                                </div>
                         </form>
                        <!--fin formulario-->
                    </div>
                    <div class="modal-footer">
                        
                    </div>
                </div>
            </div>
        </div>
        
        
        <div class="modal fade" id="ModificarAulaModal" tabindex="-1" role="dialog" aria-labelledby="modal-modificar-aula-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Modificar Aula <span id="code_aula_modificar"></span></h4>
                    </div>
                    <div class="modal-body">
                        <!--formulario?-->
                        <form role="form">
                                <div class="form-group">
                                  <label for="InputCodigoAulaModificar">Codigo</label>
                                  <input type="text" class="form-control" id="InputAulaModificar" disabled="disabled">
                                </div>
                                <div class="form-group">
                                  <label for="InputDescripcionAulaModificar">Número de aula</label>
                                  <input type="text" class="form-control" id="InputDescripcionAulaModificar" maxlength="5" placeholder="Ingrese descripción">
                                </div>
                                <div class="form-group">
                                  <label for="InputAforoAulaModificar">Aforo</label>
                                  <input type="text" class="form-control" id="InputAforoAulaModificar" placeholder="Ingrese descripción">
                                </div>
                                <div style="text-align: right;">
                                    <span style="display: none;" id="loader_modificar"><img src="lib_cliente/images/loader.GIF"></span>
                                    <button type="button" class="btn btn-success" id="btn_aceptar_modificar">Aceptar</button>
                                    <button type="button" class="btn btn-warning" id="btn_cancelar_modificar" onclick="CancelarAulaModificar();">Cancelar</button>
                                </div>
                         </form>
                        <!--fin formulario-->
                    </div>
                    <div class="modal-footer">
                        
                    </div>
                </div>
            </div>
        </div>
        
    </body>
</html>