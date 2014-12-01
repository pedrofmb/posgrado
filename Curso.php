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
        <title>Curso</title>
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
                        {"mData": "id_curso", "bSearchable": false, "bVisible": true},
                        {"mData": "descripcion", "bSearchable": true},
                        {"mData": "creditos", "bSearchable": false},
			{"mData": "acciones", "bSearchable": false}
                    ],
                    "bServerSide": true,
                    "sAjaxSource": "controlador/CrCurso.php?opcion=listar",
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
				
	        var $tabla_registros     = $("#tabla_cursos");
                var $dt_tabla_registros = $tabla_registros.dataTable(dt_options);
				
	        $('#tabla_cursos tbody').off("click", "**");
				
				
	        $("#tabla_cursos tbody").on("click", "button", function( e ) {
                     var thatAction = $(this).html();
                     var canion = $dt_tabla_registros.api();
                     var data = canion.row($(this).parents('tr')).data();
                            if(thatAction === "Modificar"){
                                    $('#ModificarCursoModal').modal('toggle');
                                    $("#code_curso_modificar").html(data.id_curso);
                                    
                                    $("#InputCursoModificar").val(data.id_curso);
                                    $("#InputDescripcionCursoModificar").val(data.descripcion);
                                    $("#SelectCreditosModificar").val(data.creditos);
                                    
                            }else if(thatAction === "Eliminar"){
                                if(confirm("Esta seguro que desea eliminar el curso con ID " + data.id_curso)){
                                   eliminarCurso(data.id_curso,$dt_tabla_registros);
                                }
                            }
                });
                
                
	        $("#tabla_cursos tbody").on("click", "tr", function( e ) {
                    if ( $(this).hasClass('selected') ) {
                        $(this).removeClass('selected');
                    }else {
                        $dt_tabla_registros.$('tr.selected').removeClass('selected');
                        $(this).addClass('selected');
                    }
                });
				
		$("#btn_aceptar").click(function(){
                    AgregarCurso($dt_tabla_registros);
                });
                
                $("#btn_aceptar_modificar").click(function(){
                    ModificarCurso($dt_tabla_registros);
                });
                
                $("#Btn_nuevo_curso_modal").click(function(){
                    $("#InputDescripcionCurso").val('');
                    $("#SelectCreditos").val(3);
                    $('#NuevoCursoModal').modal('toggle');
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
        
        <div id="contenedor_curso">
            
            <div clas="barra_botones">
                <h2>Gestionar Cursos</h2>
                <button type="button" class="btn btn-info" id="Btn_nuevo_curso_modal">
                    <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>
                    &nbsp;Nuevo
                </button>
            </div>
            
            <div style="margin-top:20px;">
                <table cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-condensed" id="tabla_cursos">
                        <thead>
                            <tr>
                                <th>Id Curso</th>
                                <th>Descripci&oacute;n</th>
                                <th>Cr&eacute;ditos</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
               </table>
            </div>
            
        </div>
        
        <div class="modal fade" id="NuevoCursoModal" tabindex="-1" role="dialog" aria-labelledby="modal-nuevo-curso-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Nuevo Curso</h4>
                    </div>
                    <div class="modal-body">
                        <!--formulario?-->
                        <form role="form">
                                <div class="form-group">
                                  <label for="InputDescripcionCurso">Descripción</label>
                                  <input type="text" class="form-control" id="InputDescripcionCurso" placeholder="Ingrese descripción">
                                </div>
                                <div class="form-group">
                                  <label for="SelectCreditos">Créditos</label>
                                  <select class="form-control" id="SelectCreditos">
                                      <option value="2">2</option>
                                      <option value="3" selected="selected">3</option>
                                      <option value="4">4</option>
                                      <option value="5">5</option>
                                  </select>
                                </div>
                                <div style="text-align: right;">
                                    <span style="display: none;" id="loader_nuevo"><img src="lib_cliente/images/loader.GIF"></span>
                                    <button type="button" class="btn btn-success" id="btn_aceptar">Aceptar</button>
                                    <button type="button" class="btn btn-warning" id="btn_cancelar" onclick="CancelarCurso();">Cancelar</button>
                                </div>
                         </form>
                        <!--fin formulario-->
                    </div>
                    <div class="modal-footer">
                        
                    </div>
                </div>
            </div>
        </div>
        
        
        <div class="modal fade" id="ModificarCursoModal" tabindex="-1" role="dialog" aria-labelledby="modal-modificar-curso-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Modificar Curso <span id="code_curso_modificar"></span></h4>
                    </div>
                    <div class="modal-body">
                        <!--formulario?-->
                        <form role="form">
                                <div class="form-group">
                                  <label for="InputCodigoCursoModificar">Codigo</label>
                                  <input type="text" class="form-control" id="InputCursoModificar" disabled="disabled">
                                </div>
                                <div class="form-group">
                                  <label for="InputDescripcionCursoModificar">Descripción</label>
                                  <input type="text" class="form-control" id="InputDescripcionCursoModificar" placeholder="Ingrese descripción">
                                </div>
                                <div class="form-group">
                                  <label for="SelectCreditosModificar">Créditos</label>
                                  <select class="form-control" id="SelectCreditosModificar">
                                      <option value="2">2</option>
                                      <option value="3" selected="selected">3</option>
                                      <option value="4">4</option>
                                      <option value="5">5</option>
                                  </select>
                                </div>
                                <div style="text-align: right;">
                                    <span style="display: none;" id="loader_modificar"><img src="lib_cliente/images/loader.GIF"></span>
                                    <button type="button" class="btn btn-success" id="btn_aceptar_modificar">Aceptar</button>
                                    <button type="button" class="btn btn-warning" id="btn_cancelar_modificar" onclick="CancelarCursoModificar();">Cancelar</button>
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


