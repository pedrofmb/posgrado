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
        <title>Docente</title>
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
                        {"mData": "id_docente", "bSearchable": false, "bVisible": true},
                        {"mData": "dni", "bSearchable": true},
                        {"mData": "apellidos", "bSearchable": false},
                        {"mData": "nombres", "bSearchable": false},
                        {"mData": "direccion", "bSearchable": false},
                        {"mData": "id_genero", "bSearchable": false},
                        {"mData": "genero", "bSearchable": false},
                        {"mData": "f_nac", "bSearchable": false},
                        {"mData": "telefono", "bSearchable": false},
                        {"mData": "id_estmencion", "bSearchable": false},
                        {"mData": "em_descripcion", "bSearchable": false},
                        {"mData": "id_ciudad", "bSearchable": false},
                        {"mData": "ciudad_descripcion", "bSearchable": false},
			{"mData": "accion_modificar", "bSearchable": false, "bSortable" : false},
                        {"mData": "accion_eliminar", "bSearchable": false, "bSortable" : false}
                    ],
                    "bServerSide": true,
                    "sAjaxSource": "controlador/CrDocente.php?opcion=listar",
                    "aoColumnDefs": [
                        {
                            "aTargets": [13],
                            "mData": "accion_modificar",
                            "mRender": function ( data, type, full ) {
                                  return '<button type="button" class="btn btn-info">Modificar</button>';
                            }
                        },
                        {
                            "aTargets": [14],
                            "mData": "accion_eliminar",
                            "mRender": function ( data, type, full ) {
                                  return '<button type="button" class="btn btn-warning">Eliminar</button>';
                            }
                        }
                    ]
                };
				
	        var $tabla_registros     = $("#tabla_docentes");
                var $dt_tabla_registros = $tabla_registros.dataTable(dt_options);
				
	        $('#tabla_docentes tbody').off("click", "**");
				
				
	        $("#tabla_docentes tbody").on("click", "button", function( e ) {
                                    var thatAction = $(this).html();
                                    var canion = $dt_tabla_registros.api();
                                    var data = canion.row($(this).parents('tr')).data();
                                           if(thatAction === "Modificar"){
                                                   
                                                   $("#code_docente_modificar").html(data.id_docente);

                                                   $("#InputCodigoDocenteModif").val(data.id_docente);
                                                   $("#InputDNIModif").val(data.dni);
                                                   $("#InputApellidosModif").val(data.apellidos);
                                                   $("#InputNombresModif").val(data.nombres);
                                                   $("#InputDireccionModif").val(data.direccion);
                                                   $("#InputFechaNacModif").val(data.f_nac);
                                                   $("#InputTelefonoModif").val(data.telefono);
                                                   $("#InputEmailModif").val(data.email);

                                                   ListarComboGenero('SelectGeneroModif', data.id_genero);
                                                   ListarComboEstMencion('SelectEstMencionModif',data.id_estmencion);
                                                   ListarComboCiudades('SelectCiudadModif',data.id_ciudad);
                                                   
                                                   $('#ModificarDocenteModal').modal('toggle');
                                                   $('#ModificarDocenteModal').on('shown.bs.modal', function (e) {
                                                       $("#InputDNIModif").focus();   
                                                     });

                                           }else if(thatAction === "Eliminar"){
                                               if(confirm("Esta seguro que desea eliminar este docente con ID " + data.id_docente)){
                                                  eliminarDocente(data.id_docente,$dt_tabla_registros);
                                               }
                                           }
                });
                
                
	        $("#tabla_docentes tbody").on("click", "tr", function( e ) {
                    if ( $(this).hasClass('selected') ) {
                        $(this).removeClass('selected');
                    }else {
                        $dt_tabla_registros.$('tr.selected').removeClass('selected');
                        $(this).addClass('selected');
                    }
                });
				
		$("#btn_aceptar").click(function(){
                    AgregarDocente($dt_tabla_registros);
                });
                
                $("#btn_aceptar_modificar").click(function(){
                    ModificarDocente($dt_tabla_registros);
                });
                
                $("#Btn_nuevo_docente_modal").click(function(){
                    
                    var inputs_arrays = $("#NuevoDocenteModal input");
                    $.each(inputs_arrays,function(i,v){
                       $("#"+v.id).val('');
                    });
                    ListarComboGenero('SelectGenero', 0);
                    ListarComboEstMencion('SelectEstMencion',0);
                    ListarComboCiudades('SelectCiudad',0);
                    
                    $('#NuevoDocenteModal').modal('toggle');
                    $('#NuevoDocenteModal').on('shown.bs.modal', function (e) {
                        $("#InputDNI").focus();   
                    });
                });
				
	        function fnGetSelected( oTableLocal ){
                    return oTableLocal.$("tr.selected");
                }
                
                function ListarComboGenero(_selector, _value_selectable){
                    //SelectGenero
                    $.get('controlador/CrGenero.php',{
                        opcion : 'listar_combo'
                    },function(data){
                        $("#"+_selector).html("");
                        var array_generos = data.generos;
                        $("#"+_selector).append("<option value='0'>Seleccionar</option>");
                        
                        $.each(array_generos,function(i,v){
                            $("#"+_selector).append("<option value='"+v.id_genero+"'>"+v.genero+"</option>");
                        });
                        $("#"+_selector).val(_value_selectable);
                    },'json');
                }
                
                function ListarComboEstMencion(_selector, _value_selectable){
                    $.get('controlador/CrEstMencion.php',{
                        opcion : 'listar_combo'
                    },function(data){
                        $("#"+_selector).html("");
                        var array_est_mencion = data.est_menciones;
                        $("#"+_selector).append("<option value='0'>Seleccionar</option>");
                        
                        $.each(array_est_mencion,function(i,v){
                            $("#"+_selector).append("<option value='"+v.id_estmencion+"'>"+v.descripcion+"</option>");
                        });
                        $("#"+_selector).val(_value_selectable);
                    },'json');
                }
                
                function ListarComboCiudades(_selector, _value_selectable){
                    $.get('controlador/CrCiudad.php',{
                        opcion : 'listar_combo'
                    },function(data){
                        $("#"+_selector).html("");
                        var array_ciudades = data.ciudades;
                        $("#"+_selector).append("<option value='0'>Seleccionar</option>");
                        
                        $.each(array_ciudades,function(i,v){
                            $("#"+_selector).append("<option value='"+v.id_ciudad+"'>"+v.descripcion+"</option>");
                        });
                        $("#"+_selector).val(_value_selectable);
                    },'json');
                }
				
	});
	
	
	 
	</script>
        
    </head>
    <body>
        
        <div id="contenedor_menu">
            <?php include_once 'Menu.php'; ?>            
        </div>
        
        <div id="contenedor_docente">
            
            <div clas="barra_botones">
                <h2>Gestionar Docentes</h2>
                <button type="button" class="btn btn-info" id="Btn_nuevo_docente_modal">
                    <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>
                    &nbsp;Nuevo
                </button>
            </div>
            
            <div style="margin-top:20px;">
                <table cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-condensed" id="tabla_docentes">
                        <thead>
                            <tr>
                                <th>Id Docente</th>
                                <th>DNI</th>
                                <th>Apellidos</th>
                                <th>Nombres</th>
                                <th>Dirección</th>
                                <th>Id Genero</th>
                                <th>Genero</th>
                                <th>Fecha Nacimiento</th>
                                <th>Teléfono</th>
                                <th>Id Est Mención</th>
                                <th>Est Mención</th>
                                <th>Id Ciudad</th>
                                <th>Ciudad</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
               </table>
            </div>
            
        </div>
        
        <div class="modal fade" id="NuevoDocenteModal" tabindex="-1" role="dialog" aria-labelledby="modal-nuevo-docente-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Nuevo Docente</h4>
                    </div>
                    <div class="modal-body">
                        <!--formulario?-->
                        <form role="form">
                                <div class="form-group">
                                  <label for="InputDNI">DNI</label>
                                  <input type="number" class="form-control" id="InputDNI" placeholder="Ingrese DNI">
                                </div>
                                <div class="form-group">
                                  <label for="InputApellidos">Apellidos</label>
                                  <input type="text" class="form-control" id="InputApellidos" placeholder="Ingrese apellidos">
                                </div>
                                <div class="form-group">
                                  <label for="InputNombres">Nombres</label>
                                  <input type="text" class="form-control" id="InputNombres" placeholder="Ingrese nombres">
                                </div>
                                <div class="form-group">
                                  <label for="InputDireccion">Dirección</label>
                                  <input type="text" class="form-control" id="InputDireccion" placeholder="Ingrese dirección">
                                </div>
                                <div class="form-group">
                                  <label for="SelectGenero">Genero</label>
                                  <select class="form-control" id="SelectGenero">
                                      <option value="0">Seleccionar</option>
                                  </select>
                                </div>
                                <div class="form-group">
                                  <label for="InputFechaNac">Fecha Nacimiento</label>
                                  <input type="date" class="form-control" id="InputFechaNac" placeholder="Ingrese fecha de nacimiento">
                                </div>
                                <div class="form-group">
                                  <label for="InputTelefono">Telefóno</label>
                                  <input type="text" class="form-control" id="InputTelefono" placeholder="Ingrese telefóno">
                                </div>
                                <div class="form-group">
                                  <label for="SelectEstMencion">Est Mencion</label>
                                  <select class="form-control" id="SelectEstMencion">
                                      <option value="0">Seleccionar</option>
                                  </select>
                                </div>
                                <div class="form-group">
                                  <label for="SelectCiudad">Ciudad</label>
                                  <select class="form-control" id="SelectCiudad">
                                      <option value="0">Seleccionar</option>
                                  </select>
                                </div>
                                <div class="form-group">
                                  <label for="InputEmail">Email</label>
                                  <input type="email" class="form-control" id="InputEmail" placeholder="Ingrese Email">
                                </div>
                         </form>
                        <!--fin formulario-->
                    </div>
                    <div class="modal-footer">
                        <div style="text-align: right;">
                                    <span style="display: none;" id="loader_nuevo"><img src="lib_cliente/images/loader.GIF"></span>
                                    <button type="button" class="btn btn-success" id="btn_aceptar">Aceptar</button>
                                    <button type="button" class="btn btn-warning" id="btn_cancelar" onclick="CancelarDocenteNuevo();">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        <div class="modal fade" id="ModificarDocenteModal" tabindex="-1" role="dialog" aria-labelledby="modal-modificar-aula-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Modificar Docente <span id="code_docente_modificar"></span></h4>
                    </div>
                    <div class="modal-body">
                        <!--formulario?-->
                        <form role="form">
                                <div class="form-group">
                                  <label for="InputCodigoDocenteModif">Código</label>
                                  <input type="text" class="form-control" id="InputCodigoDocenteModif" disabled="disabled">
                                </div>
                                <div class="form-group">
                                  <label for="InputDNIModif">DNI</label>
                                  <input type="number" class="form-control" id="InputDNIModif" placeholder="Ingrese DNI">
                                </div>
                                <div class="form-group">
                                  <label for="InputApellidosModif">Apellidos</label>
                                  <input type="text" class="form-control" id="InputApellidosModif" placeholder="Ingrese apellidos">
                                </div>
                                <div class="form-group">
                                  <label for="InputNombresModif">Nombres</label>
                                  <input type="text" class="form-control" id="InputNombresModif" placeholder="Ingrese nombres">
                                </div>
                                <div class="form-group">
                                  <label for="InputDireccionModif">Dirección</label>
                                  <input type="text" class="form-control" id="InputDireccionModif" placeholder="Ingrese dirección">
                                </div>
                                <div class="form-group">
                                  <label for="SelectGeneroModif">Genero</label>
                                  <select class="form-control" id="SelectGeneroModif">
                                      <option value="0">Seleccionar</option>
                                  </select>
                                </div>
                                <div class="form-group">
                                  <label for="InputFechaNacModif">Fecha Nacimiento</label>
                                  <input type="date" class="form-control" id="InputFechaNacModif" placeholder="Ingrese fecha de nacimiento">
                                </div>
                                <div class="form-group">
                                  <label for="InputTelefonoModif">Telefóno</label>
                                  <input type="text" class="form-control" id="InputTelefonoModif" placeholder="Ingrese telefóno">
                                </div>
                                <div class="form-group">
                                  <label for="SelectEstMencionModif">Est Mencion</label>
                                  <select class="form-control" id="SelectEstMencionModif">
                                      <option value="0">Seleccionar</option>
                                  </select>
                                </div>
                                <div class="form-group">
                                  <label for="SelectCiudadModif">Ciudad</label>
                                  <select class="form-control" id="SelectCiudadModif">
                                      <option value="0">Seleccionar</option>
                                  </select>
                                </div>
                                <div class="form-group">
                                  <label for="InputEmailModif">Email</label>
                                  <input type="email" class="form-control" id="InputEmailModif" placeholder="Ingrese Email">
                                </div>
                         </form>
                        <!--fin formulario-->
                    </div>
                    <div class="modal-footer">
                        <div style="text-align: right;">
                                    <span style="display: none;" id="loader_modificar"><img src="lib_cliente/images/loader.GIF"></span>
                                    <button type="button" class="btn btn-success" id="btn_aceptar_modificar">Aceptar</button>
                                    <button type="button" class="btn btn-warning" id="btn_cancelar_modificar" onclick="CancelarDocenteModificar();">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </body>
</html>