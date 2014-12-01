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
        <title>Programa</title>
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
                        {"mData": "id_programa", "bSearchable": false, "bVisible": true},
                        {"mData": "nom_programa", "bSearchable": true},
                        {"mData": "id_facultad", "bSearchable": false, "bVisible" : false},
                        {"mData": "nom_facultad", "bSearchable": false},
			{"mData": "acciones", "bSearchable": false}
                    ],
                    "bServerSide": true,
                    "sAjaxSource": "controlador/CrPrograma.php?opcion=listar",
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
				
	        var $tabla_registros     = $("#tabla_programa");
                var $dt_tabla_registros = $tabla_registros.dataTable(dt_options);
				
	        $('#tabla_programa tbody').off("click", "**");
				
				
	        $("#tabla_programa tbody").on("click", "button", function( e ) {
                     var thatAction = $(this).html();
                     var canion = $dt_tabla_registros.api();
                     var data = canion.row($(this).parents('tr')).data();
                            if(thatAction === "Modificar"){
                                    $('#ModificarProgramaModal').modal('toggle');
                                    $("#code_programa_modificar").html(data.id_programa);
                                    
                                    $("#InputProgramaModificar").val(data.id_programa);
                                    $("#InputDescripcionProgramaModificar").val(data.nom_programa);
                                    
                                    ListarFacultadesCombo('SelectFacultadModificar', data.id_facultad);
                                    
                            }else if(thatAction === "Eliminar"){
                                if(confirm("Esta seguro que desea eliminar el programa con ID " + data.id_programa)){
                                    eliminarPrograma(data.id_programa,$dt_tabla_registros);
                                }
                            }
                });
                
                
	        $("#tabla_programa tbody").on("click", "tr", function( e ) {
                    if ( $(this).hasClass('selected') ) {
                        $(this).removeClass('selected');
                    }else {
                        $dt_tabla_registros.$('tr.selected').removeClass('selected');
                        $(this).addClass('selected');
                    }
                });
				
		$("#btn_aceptar").click(function(){
                    AgregarPrograma($dt_tabla_registros);
                });
                
                $("#btn_aceptar_modificar").click(function(){
                    ModificarPrograma($dt_tabla_registros);
                });
                
                $("#Btn_nuevo_programa_modal").click(function(){
                    $("#InputDescripcionPrograma").val('');
                    $('#NuevoProgramaModal').modal('toggle');
                    
                    ListarFacultadesCombo('SelectFacultadNuevo');
                    $("#SelectFacultadNuevo").val(0);
                    
                });
				
	        function fnGetSelected( oTableLocal ){
                    return oTableLocal.$("tr.selected");
                }
                
                function ListarFacultadesCombo(_selector, _id_facultad){
                    
                    $("#"+_selector).html("");
                    $("#"+_selector).append("<option value='0'>Seleccionar</option>");
                    
                    $.get('controlador/CrFacultad.php',{
                        opcion : 'listar_combo'
                    },function(data){
                        var array_facultades = data.facultades;
                        $.each(array_facultades,function(i,v){
                            $("#"+_selector).append("<option value='"+v.id_facultad+"'>" +v.nom_facultad+ "</option>");
                        });
                        
                        if(_id_facultad!==undefined)
                          $("#SelectFacultadModificar").val(_id_facultad);
                        
                    },'json');
                }
				
	});
	
	
	 
	</script>
        
    </head>
    <body>
        
        <div id="contenedor_menu">
            <?php include_once 'Menu.php'; ?>            
        </div>
        
        <div id="contenedor_programa">
            
            <div clas="barra_botones">
                <h2>Gestionar Programas</h2>
                <button type="button" class="btn btn-info" id="Btn_nuevo_programa_modal">
                    <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>
                    &nbsp;Nuevo
                </button>
            </div>
            
            <div style="margin-top:20px;">
                <table cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-condensed" id="tabla_programa">
                        <thead>
                            <tr>
                                <th>Id Programa</th>
                                <th>Descripci&oacute;n</th>
                                <th>Id Facultad</th>
                                <th>Facultad</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
               </table>
            </div>
            
        </div>
        
        <div class="modal fade" id="NuevoProgramaModal" tabindex="-1" role="dialog" aria-labelledby="modal-nuevo-programa-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Nuevo Programa</h4>
                    </div>
                    <div class="modal-body">
                        <!--formulario?-->
                        <form role="form">
                                <div class="form-group">
                                  <label for="InputDescripcionPrograma">Descripción</label>
                                  <input type="text" class="form-control" id="InputDescripcionPrograma" placeholder="Ingrese descripción">
                                </div>
                                <div class="form-group">
                                  <label for="SelectFacultadNuevo">Facultad</label>
                                  <select class="form-control" id="SelectFacultadNuevo">
                                      <option value="0">Seleccionar</option>
                                  </select>
                                </div>
                                <div style="text-align: right;">
                                    <span style="display: none;" id="loader_nuevo"><img src="lib_cliente/images/loader.GIF"></span>
                                    <button type="button" class="btn btn-success" id="btn_aceptar">Aceptar</button>
                                    <button type="button" class="btn btn-warning" id="btn_cancelar" onclick="CancelarPrograma();">Cancelar</button>
                                </div>
                         </form>
                        <!--fin formulario-->
                    </div>
                    <div class="modal-footer">
                        
                    </div>
                </div>
            </div>
        </div>
        
        
        <div class="modal fade" id="ModificarProgramaModal" tabindex="-1" role="dialog" aria-labelledby="modal-modificar-programa-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Modificar Programa <span id="code_programa_modificar"></span></h4>
                    </div>
                    <div class="modal-body">
                        <!--formulario?-->
                        <form role="form">
                                <div class="form-group">
                                  <label for="InputCodigoProgramaModificar">Codigo</label>
                                  <input type="text" class="form-control" id="InputProgramaModificar" disabled="disabled">
                                </div>
                                <div class="form-group">
                                  <label for="InputDescripcionProgramaModificar">Descripción</label>
                                  <input type="text" class="form-control" id="InputDescripcionProgramaModificar" placeholder="Ingrese descripción">
                                </div>
                                <div class="form-group">
                                  <label for="SelectFacultadModificar">Facultad</label>
                                  <select class="form-control" id="SelectFacultadModificar">
                                      <option value="0">Select</option>
                                  </select>
                                </div>
                                <div style="text-align: right;">
                                    <span style="display: none;" id="loader_modificar"><img src="lib_cliente/images/loader.GIF"></span>
                                    <button type="button" class="btn btn-success" id="btn_aceptar_modificar">Aceptar</button>
                                    <button type="button" class="btn btn-warning" id="btn_cancelar_modificar" onclick="CancelarProgramaModificar();">Cancelar</button>
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