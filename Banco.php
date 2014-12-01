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
        <title>Banco</title>
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
                        {"mData": "id_banco", "bSearchable": false, "bVisible": true},
                        {"mData": "descripcion", "bSearchable": true},
			{"mData": "acciones", "bSearchable": false, "bSortable" : false}
                    ],
                    "bServerSide": true,
                    "sAjaxSource": "controlador/CrBanco.php?opcion=listar",
                    "aoColumnDefs": [
                        {
                            "aTargets": [2],
                            "mData": "acciones",
                            "mRender": function ( data, type, full ) {
                                  return '<button type="button" class="btn btn-info">Modificar</button>&nbsp;<button type="button" class="btn btn-warning">Eliminar</button>';
                            }
                          }
                    ]
                };
				
	        var $tabla_registros     = $("#tabla_bancos");
                var $dt_tabla_registros = $tabla_registros.dataTable(dt_options);
				
	        $('#tabla_bancos tbody').off("click", "**");
				
				
	        $("#tabla_bancos tbody").on("click", "button", function( e ) {
                     var thatAction = $(this).html();
                     var canion = $dt_tabla_registros.api();
                     var data = canion.row($(this).parents('tr')).data();
                            if(thatAction === "Modificar"){
                                    $('#ModificarBancoModal').modal('toggle');
                                    $("#code_banco_modificar").html(data.id_banco);
                                    
                                    $("#InputBancoModificar").val(data.id_banco);
                                    $("#InputDescripcionBancoModificar").val(data.descripcion);
                                    
                            }else if(thatAction === "Eliminar"){
                                if(confirm("Esta seguro que desea eliminar el banco con ID " + data.id_banco)){
                                   eliminarBanco(data.id_banco,$dt_tabla_registros);
                                }
                            }
                });
                
                
	        $("#tabla_bancos tbody").on("click", "tr", function( e ) {
                    if ( $(this).hasClass('selected') ) {
                        $(this).removeClass('selected');
                    }else {
                        $dt_tabla_registros.$('tr.selected').removeClass('selected');
                        $(this).addClass('selected');
                    }
                });
				
		$("#btn_aceptar").click(function(){
                    AgregarBanco($dt_tabla_registros);
                });
                
                $("#btn_aceptar_modificar").click(function(){
                    ModificarBanco($dt_tabla_registros);
                });
                
                $("#Btn_nuevo_banco_modal").click(function(){
                    $("#InputDescripcionBanco").val('');
                    $("#InputAforoBancoNuevo").val('');
                    $('#NuevoBancoModal').modal('toggle');
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
        
        <div id="contenedor_banco">
            
            <div clas="barra_botones">
                <h2>Gestionar Bancos</h2>
                <button type="button" class="btn btn-info" id="Btn_nuevo_banco_modal">
                    <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>
                    &nbsp;Nuevo
                </button>
            </div>
            
            <div style="margin-top:20px;">
                <table cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-condensed" id="tabla_bancos">
                        <thead>
                            <tr>
                                <th>Id Banco</th>
                                <th>Descripcion</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
               </table>
            </div>
            
        </div>
        
        <div class="modal fade" id="NuevoBancoModal" tabindex="-1" role="dialog" aria-labelledby="modal-nuevo-banco-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Nuevo Banco</h4>
                    </div>
                    <div class="modal-body">
                        <!--formulario?-->
                        <form role="form">
                                <div class="form-group">
                                  <label for="InputDescripcionBanco">Descripción</label>
                                  <input type="text" class="form-control" id="InputDescripcionBanco" placeholder="Ingrese descripcion">
                                </div>
                                <div style="text-align: right;">
                                    <span style="display: none;" id="loader_nuevo"><img src="lib_cliente/images/loader.GIF"></span>
                                    <button type="button" class="btn btn-success" id="btn_aceptar">Aceptar</button>
                                    <button type="button" class="btn btn-warning" id="btn_cancelar" onclick="CancelarBancoNuevo();">Cancelar</button>
                                </div>
                         </form>
                        <!--fin formulario-->
                    </div>
                    <div class="modal-footer">
                        
                    </div>
                </div>
            </div>
        </div>
        
        
        <div class="modal fade" id="ModificarBancoModal" tabindex="-1" role="dialog" aria-labelledby="modal-modificar-banco-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Modificar Banco <span id="code_banco_modificar"></span></h4>
                    </div>
                    <div class="modal-body">
                        <!--formulario?-->
                        <form role="form">
                                <div class="form-group">
                                  <label for="InputBancoModificar">Codigo</label>
                                  <input type="text" class="form-control" id="InputBancoModificar" disabled="disabled">
                                </div>
                                <div class="form-group">
                                  <label for="InputDescripcionBancoModificar">Descripción</label>
                                  <input type="text" class="form-control" id="InputDescripcionBancoModificar" placeholder="Ingrese descripción">
                                </div>
                                <div style="text-align: right;">
                                    <span style="display: none;" id="loader_modificar"><img src="lib_cliente/images/loader.GIF"></span>
                                    <button type="button" class="btn btn-success" id="btn_aceptar_modificar">Aceptar</button>
                                    <button type="button" class="btn btn-warning" id="btn_cancelar_modificar" onclick="CancelarBancoModificar();">Cancelar</button>
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