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
        <title>Mencion</title>
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
                        {"mData": "id_mencion", "bSearchable": false, "bVisible": true},
                        {"mData": "nom_mencion", "bSearchable": true},
                        {"mData": "id_programa", "bSearchable": false, "bVisible" : false},
                        {"mData": "nom_programa", "bSearchable": false},
			{"mData": "acciones", "bSearchable": false}
                    ],
                    "bServerSide": true,
                    "sAjaxSource": "controlador/CrMencion.php?opcion=listar",
                    "aoColumnDefs": [
                        {
                            "aTargets": [4],
                            "mData": "acciones",
                            "mRender": function ( data, type, full ) {
                                  return '<button type="button" class="btn btn-info">Modificar</button>&nbsp;<button type="button" class="btn btn-warning">Eliminar</button>';
                            }
                          }
                    ]
                };
				
	        var $tabla_registros     = $("#tabla_mencion");
                var $dt_tabla_registros = $tabla_registros.dataTable(dt_options);
				
	        $('#tabla_mencion tbody').off("click", "**");
				
				
	        $("#tabla_mencion tbody").on("click", "button", function( e ) {
                     var thatAction = $(this).html();
                     var canion = $dt_tabla_registros.api();
                     var data = canion.row($(this).parents('tr')).data();
                            if(thatAction === "Modificar"){
                                    $('#ModificarMencionModal').modal('toggle');
                                    $("#code_mencion_modificar").html(data.id_mencion);
                                    
                                    $("#InputMencionModificar").val(data.id_mencion);
                                    $("#InputDescripcionMencionModificar").val(data.nom_mencion);
                                    
                                    ListarProgramasCombo('SelectProgramaModificar', data.id_programa);
                                    
                            }else if(thatAction === "Eliminar"){
                                if(confirm("Esta seguro que desea eliminar la mención con ID " + data.id_mencion)){
                                    eliminarMencion(data.id_mencion,$dt_tabla_registros);
                                }
                            }
                });
                
                
	        $("#tabla_mencion tbody").on("click", "tr", function( e ) {
                    if ( $(this).hasClass('selected') ) {
                        $(this).removeClass('selected');
                    }else {
                        $dt_tabla_registros.$('tr.selected').removeClass('selected');
                        $(this).addClass('selected');
                    }
                });
				
		$("#btn_aceptar").click(function(){
                    AgregarMencion($dt_tabla_registros);
                });
                
                $("#btn_aceptar_modificar").click(function(){
                    ModificarMencion($dt_tabla_registros);
                });
                
                $("#Btn_nuevo_mencion_modal").click(function(){
                    $("#InputDescripcionMencion").val('');
                    $('#NuevoMencionModal').modal('toggle');
                    
                    ListarProgramasCombo('SelectProgramaNuevo');
                    $("#SelectProgramaNuevo").val(0);
                    
                });
				
	        function fnGetSelected( oTableLocal ){
                    return oTableLocal.$("tr.selected");
                }
                
                function ListarProgramasCombo(_selector, _id_Programa){
                    
                    $("#"+_selector).html("");
                    $("#"+_selector).append("<option value='0'>Seleccionar</option>");
                    
                    $.get('controlador/CrPrograma.php',{
                        opcion : 'listar_combo'
                    },function(data){
                        var array_programas = data.programas;
                        $.each(array_programas,function(i,v){
                            $("#"+_selector).append("<option value='"+v.id_programa+"'>" +v.nom_programa+ "</option>");
                        });
                        
                        if(_id_Programa!==undefined)
                          $("#SelectProgramaModificar").val(_id_Programa);
                        
                    },'json');
                }
				
	});
	
	
	 
	</script>
        
    </head>
    <body>
        
        <div id="contenedor_menu">
            <?php include_once 'Menu.php'; ?>            
        </div>
        
        <div id="contenedor_mencion">
            
            <div clas="barra_botones">
                <h2>Gestionar Mencion</h2>
                <button type="button" class="btn btn-info" id="Btn_nuevo_mencion_modal">
                    <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>
                    &nbsp;Nuevo
                </button>
            </div>
            
            <div style="margin-top:20px;">
                <table cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-condensed" id="tabla_mencion">
                        <thead>
                            <tr>
                                <th>Id Mencion</th>
                                <th>Descripci&oacute;n</th>
                                <th>Id Programa</th>
                                <th>Programa</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
               </table>
            </div>
            
        </div>
        
        <div class="modal fade" id="NuevoMencionModal" tabindex="-1" role="dialog" aria-labelledby="modal-nuevo-mencion-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Nuevo Mencion</h4>
                    </div>
                    <div class="modal-body">
                        <!--formulario?-->
                        <form role="form">
                                <div class="form-group">
                                  <label for="InputDescripcionMencion">Descripción</label>
                                  <input type="text" class="form-control" id="InputDescripcionMencion" placeholder="Ingrese descripción">
                                </div>
                                <div class="form-group">
                                  <label for="SelectProgramaNuevo">Programa</label>
                                  <select class="form-control" id="SelectProgramaNuevo">
                                      <option value="0">Seleccionar</option>
                                  </select>
                                </div>
                                <div style="text-align: right;">
                                    <span style="display: none;" id="loader_nuevo"><img src="lib_cliente/images/loader.GIF"></span>
                                    <button type="button" class="btn btn-success" id="btn_aceptar">Aceptar</button>
                                    <button type="button" class="btn btn-warning" id="btn_cancelar" onclick="CancelarMencionNuevo();">Cancelar</button>
                                </div>
                         </form>
                        <!--fin formulario-->
                    </div>
                    <div class="modal-footer">
                        
                    </div>
                </div>
            </div>
        </div>
        
        
        <div class="modal fade" id="ModificarMencionModal" tabindex="-1" role="dialog" aria-labelledby="modal-modificar-mencion-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Modificar Mencion <span id="code_mencion_modificar"></span></h4>
                    </div>
                    <div class="modal-body">
                        <!--formulario?-->
                        <form role="form">
                                <div class="form-group">
                                  <label for="InputCodigoMencionModificar">Codigo</label>
                                  <input type="text" class="form-control" id="InputMencionModificar" disabled="disabled">
                                </div>
                                <div class="form-group">
                                  <label for="InputDescripcionMencionModificar">Descripción</label>
                                  <input type="text" class="form-control" id="InputDescripcionMencionModificar" placeholder="Ingrese descripción">
                                </div>
                                <div class="form-group">
                                  <label for="SelectProgramaModificar">Programa</label>
                                  <select class="form-control" id="SelectProgramaModificar">
                                      <option value="0">Select</option>
                                  </select>
                                </div>
                                <div style="text-align: right;">
                                    <span style="display: none;" id="loader_modificar"><img src="lib_cliente/images/loader.GIF"></span>
                                    <button type="button" class="btn btn-success" id="btn_aceptar_modificar">Aceptar</button>
                                    <button type="button" class="btn btn-warning" id="btn_cancelar_modificar" onclick="CancelarMencionModificar();">Cancelar</button>
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