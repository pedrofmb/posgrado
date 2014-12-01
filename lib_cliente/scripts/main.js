/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function LogearUsuario()
{
    event.preventDefault();
    var usuario = $("#InputUsuario").val();
    var password = $("#InputPassword").val();
    
    if(usuario!="" && password!=""){
        $(".loader").show();
        $("#btn_submit").attr("disabled", true);
        $.post('controlador/CrLogin.php',{
            opcion : "LOGIN",
            usuario : usuario,
            password : password
        },function(data){
            $(".loader").hide();
            $("#btn_submit").attr("disabled", false);
            if(data.resultado == "OK"){
                location.href = "Main.php";
            }
            else{
                alert(data.error);
            }
        },'json');
    }
    else
        alert("Ingrese los datos correctamente.");
}

/* CURSO */

function CancelarCurso(){
    $('#NuevoCursoModal').modal('hide');
}

function AgregarCurso(_data_table){
    
    var InputDescripcionCurso = $("#InputDescripcionCurso").val();
    var SelectCreditos = $("#SelectCreditos").val();
    
    if(InputDescripcionCurso!=""){
       $("#btn_aceptar").attr("disabled", true);
       $("#loader_nuevo").fadeIn();
       
       $.post('controlador/CrCurso.php?opcion=insertar',{
           descripcion : InputDescripcionCurso,
           creditos : SelectCreditos
       },function(data){
            if(data.codigo_curso!='')
                alert("Curso " + data.codigo_curso + " ingresado correctamente.");
            else
                alert("Error al ingresar. Intentelo nuevamente.");
            
            $("#loader_nuevo").hide();
            $("#btn_aceptar").attr("disabled", false);
            $('#NuevoCursoModal').modal('hide');
            _data_table.fnStandingRedraw();
            
       },'json');
    }
    else
        alert("Ingrese la descripcion");
}


function CancelarCursoModificar(){
    $('#ModificarCursoModal').modal('hide');
}

function ModificarCurso(_data_table){
    var InputCursoModificar = $("#InputCursoModificar").val();
    var InputDescripcionCursoModificar = $("#InputDescripcionCursoModificar").val();
    var SelectCreditosModificar = $("#SelectCreditosModificar").val();
    if(InputDescripcionCursoModificar!=""){
        $("#btn_aceptar_modificar").attr("disabled", true);
        $("#loader_modificar").fadeIn();
        
        $.post('controlador/CrCurso.php?opcion=actualizar',{
           codigo : InputCursoModificar,
           descripcion : InputDescripcionCursoModificar,
           creditos : SelectCreditosModificar
       },function(data){
            if(data.valor_estado!=0)
                alert("Curso " + InputDescripcionCursoModificar + " modificado correctamente.");
            else
                alert("Error al ingresar. Intentelo nuevamente.");
            
            $("#loader_modificar").hide();
            $("#btn_aceptar_modificar").attr("disabled", false);
            $('#ModificarCursoModal').modal('hide');
            _data_table.fnStandingRedraw();
            
       },'json');
    }
    else
        alert("Ingrese la descripcion");
}

function eliminarCurso(_codigo_curso,_data_table){
        
        $.post('controlador/CrCurso.php?opcion=eliminar',{
           codigo : _codigo_curso,
       },function(data){
            if(data.valor_estado!=0)
                alert("Curso " + _codigo_curso + " eliminado correctamente.");
            else
                alert("Error al eliminar la fila");
            
            _data_table.fnStandingRedraw();
            
       },'json');
}

/* CURSO */

/* PROGRAMA */

function CancelarPrograma(){
    $('#NuevoProgramaModal').modal('hide');
}

function AgregarPrograma(_data_table){
    var InputDescripcionPrograma = $("#InputDescripcionPrograma").val();
    var SelectFacultadNuevo = $("#SelectFacultadNuevo").val();
    
    if(InputDescripcionPrograma!="" && SelectFacultadNuevo!=0){
       $("#btn_aceptar").attr("disabled", true);
       $("#loader_nuevo").fadeIn();
       
       $.post('controlador/CrPrograma.php?opcion=insertar',{
           nom_programa : InputDescripcionPrograma,
           id_facultad : SelectFacultadNuevo,
       },function(data){
            if(data.codigo_programa!='')
                alert("Programa " + data.codigo_programa + " ingresado correctamente.");
            else
                alert("Error al ingresar. Intentelo nuevamente.");
            
            $("#loader_nuevo").hide();
            $("#btn_aceptar").attr("disabled", false);
            $('#NuevoProgramaModal').modal('hide');
            _data_table.fnStandingRedraw();
            
       },'json');
    }
    else
        alert("Revise los datos ingresados!");
}

function ModificarPrograma(_data_table){
    var InputProgramaModificar = $("#InputProgramaModificar").val();
    var InputDescripcionProgramaModificar = $("#InputDescripcionProgramaModificar").val();
    var SelectFacultadModificar = $("#SelectFacultadModificar").val();
    if(InputDescripcionProgramaModificar!="" && SelectFacultadModificar!=0){
        $("#btn_aceptar_modificar").attr("disabled", true);
        $("#loader_modificar").fadeIn();
        
        $.post('controlador/CrPrograma.php?opcion=actualizar',{
           id_programa : InputProgramaModificar,
           nom_programa : InputDescripcionProgramaModificar,
           id_facultad : SelectFacultadModificar
       },function(data){
            if(data.valor_estado!=0)
                alert("Programa " + InputProgramaModificar + " modificado correctamente.");
            else
                alert("Error al modificar. Intentelo nuevamente.");
            
            $("#loader_modificar").hide();
            $("#btn_aceptar_modificar").attr("disabled", false);
            $('#ModificarProgramaModal').modal('hide');
            _data_table.fnStandingRedraw();
            
       },'json');
    }
    else
        alert("Ingrese la descripcion");
}

function CancelarProgramaModificar(){
    $('#ModificarProgramaModal').modal('hide');
}

function eliminarPrograma(_codigo_programa,_data_table){
        
        $.post('controlador/CrPrograma.php?opcion=eliminar',
        {
           id_programa : _codigo_programa
        },function(data){
            if(data.valor_estado!=0)
                alert("Programa " + _codigo_programa + " eliminado correctamente.");
            else
                alert("Error al eliminar la fila");
            
            _data_table.fnStandingRedraw();
            
       },'json');
}

/* PROGRAMA */

/* Mencion */

function CancelarMencion(){
    $('#NuevoMencionModal').modal('hide');
}

function AgregarMencion(_data_table){
    var InputDescripcionMencion = $("#InputDescripcionMencion").val();
    var SelectProgramaNuevo = $("#SelectProgramaNuevo").val();
    
    if(InputDescripcionMencion!="" && SelectProgramaNuevo!=0){
       $("#btn_aceptar").attr("disabled", true);
       $("#loader_nuevo").fadeIn();
       
       $.post('controlador/CrMencion.php?opcion=insertar',{
           nom_mencion : InputDescripcionMencion,
           id_programa : SelectProgramaNuevo,
       },function(data){
            if(data.codigo_mencion!='')
                alert("Mencion " + data.codigo_mencion + " ingresado correctamente.");
            else
                alert("Error al ingresar. Intentelo nuevamente.");
            
            $("#loader_nuevo").hide();
            $("#btn_aceptar").attr("disabled", false);
            $('#NuevoMencionModal').modal('hide');
            _data_table.fnStandingRedraw();
            
       },'json');
    }
    else
        alert("Revise los datos ingresados!");
}

function ModificarMencion(_data_table){
    var InputMencionModificar = $("#InputMencionModificar").val();
    var InputDescripcionMencionModificar = $("#InputDescripcionMencionModificar").val();
    var SelectProgramaModificar = $("#SelectProgramaModificar").val();
    if(InputDescripcionMencionModificar!="" && SelectProgramaModificar!=0){
        $("#btn_aceptar_modificar").attr("disabled", true);
        $("#loader_modificar").fadeIn();
        
        $.post('controlador/CrMencion.php?opcion=actualizar',{
           id_mencion : InputMencionModificar,
           nom_mencion : InputDescripcionMencionModificar,
           id_programa : SelectProgramaModificar
       },function(data){
            if(data.valor_estado!=0)
                alert("Mencion " + InputMencionModificar + " modificado correctamente.");
            else
                alert("Error al modificar. Intentelo nuevamente.");
            
            $("#loader_modificar").hide();
            $("#btn_aceptar_modificar").attr("disabled", false);
            $('#ModificarMencionModal').modal('hide');
            _data_table.fnStandingRedraw();
            
       },'json');
    }
    else
        alert("Ingrese la descripcion");
}

function CancelarMencionModificar(){
    $('#ModificarMencionModal').modal('hide');
}

function CancelarMencionNuevo(){
    $('#NuevoMencionModal').modal('hide');
}

function eliminarMencion(_codigo_mencion,_data_table){
        
        $.post('controlador/CrMencion.php?opcion=eliminar',
        {
           id_mencion : _codigo_mencion
        },function(data){
            if(data.valor_estado!=0)
                alert("Mencion " + _codigo_mencion + " eliminado correctamente.");
            else
                alert("Error al eliminar la fila");
            
            _data_table.fnStandingRedraw();
            
       },'json');
}

/* Mencion */

/* Aula */

function CancelarAula(){
    $('#NuevoAulaModal').modal('hide');
}

function AgregarAula(_data_table){
    var InputDescripcionAula = $("#InputDescripcionAula").val();
    var InputAforoAulaNuevo = $("#InputAforoAulaNuevo").val();
    
    if(InputDescripcionAula!="" && InputAforoAulaNuevo!=""){
       $("#btn_aceptar").attr("disabled", true);
       $("#loader_nuevo").fadeIn();
       
       $.post('controlador/CrAula.php?opcion=insertar',{
           n_aula : InputDescripcionAula,
           aforo : InputAforoAulaNuevo,
       },function(data){
            if(data.codigo_aula!='')
                alert("Aula " + data.codigo_aula + " ingresado correctamente.");
            else
                alert("Error al ingresar. Intentelo nuevamente.");
            
            $("#loader_nuevo").hide();
            $("#btn_aceptar").attr("disabled", false);
            $('#NuevoAulaModal').modal('hide');
            _data_table.fnStandingRedraw();
            
       },'json');
    }
    else
        alert("Revise los datos ingresados!");
}

function ModificarAula(_data_table){
    var InputAulaModificar = $("#InputAulaModificar").val();
    var InputDescripcionAulaModificar = $("#InputDescripcionAulaModificar").val();
    var InputAforoAulaModificar = $("#InputAforoAulaModificar").val();
    
    if(InputDescripcionAulaModificar!="" && InputAforoAulaModificar!=""){
        $("#btn_aceptar_modificar").attr("disabled", true);
        $("#loader_modificar").fadeIn();
        
        $.post('controlador/CrAula.php?opcion=actualizar',{
           id_aula : InputAulaModificar,
           n_aula : InputDescripcionAulaModificar,
           aforo : InputAforoAulaModificar,
       },function(data){
            if(data.valor_estado!=0)
                alert("Aula " + InputAulaModificar + " modificado correctamente.");
            else
                alert("Error al modificar. Intentelo nuevamente.");
            
            $("#loader_modificar").hide();
            $("#btn_aceptar_modificar").attr("disabled", false);
            $('#ModificarAulaModal').modal('hide');
            _data_table.fnStandingRedraw();
            
       },'json');
    }
    else
        alert("Ingrese la descripcion");
}

function CancelarAulaModificar(){
    $('#ModificarAulaModal').modal('hide');
}

function CancelarAulaNuevo(){
    $('#NuevoAulaModal').modal('hide');
}

function eliminarAula(_codigo_aula,_data_table){
        
        $.post('controlador/CrAula.php?opcion=eliminar',
        {
           id_aula : _codigo_aula
        },function(data){
            if(data.valor_estado!=0)
                alert("Aula " + _codigo_aula + " eliminado correctamente.");
            else
                alert("Error al eliminar la fila");
            
            _data_table.fnStandingRedraw();
            
       },'json');
}

/* Aula */


/* Docente */

function AgregarDocente(_data_table)
{
   var InputDNI = $("#InputDNI").val();
   var InputApellidos = $("#InputApellidos").val();
   var InputNombres = $("#InputNombres").val();
   var InputDireccion = $("#InputDireccion").val();
   var SelectGenero = $("#SelectGenero").val();
   var InputFechaNac = $("#InputFechaNac").val();
   var InputTelefono = $("#InputTelefono").val();
   var SelectEstMencion = $("#SelectEstMencion").val();
   var SelectCiudad = $("#SelectCiudad").val();
   var InputEmail = $("#InputEmail").val();
   
   if(InputDNI!=="" && InputApellidos!=="" && InputNombres!=="" && InputDireccion!=="" && SelectGenero!==0 && 
      InputFechaNac!=="" && InputTelefono!== "" && SelectEstMencion!==0 && SelectCiudad!== 0 && InputEmail!== "")
  {
      $("#btn_aceptar").attr("disabled", true);
      $("#loader_nuevo").fadeIn();
      
      $.post('controlador/CrDocente.php?opcion=insertar',{
           dni : InputDNI,
           apellidos : InputApellidos,
           nombres : InputNombres,
           direccion : InputDireccion,
           id_genero : SelectGenero,
           fecha_nacimiento : InputFechaNac,
           telefono : InputTelefono,
           id_estmencion : SelectEstMencion,
           id_ciudad : SelectCiudad,
           email : InputEmail
       },function(data){
            if(data.id_docente!='')
                alert("Docente " + data.id_docente + "-" + InputNombres + " "+ InputApellidos + " ingresado correctamente.");
            else
                alert("Error al ingresar. Intentelo nuevamente.");
            
            $("#loader_nuevo").hide();
            $("#btn_aceptar").attr("disabled", false);
            $('#NuevoDocenteModal').modal('hide');
            _data_table.fnStandingRedraw();
            
       },'json');
  }
  else
      alert("Revise los campos ingresados.");
}

function CancelarDocenteModificar(){
    $('#ModificarDocenteModal').modal('hide');
}

function CancelarDocenteNuevo(){
    $('#NuevoDocenteModal').modal('hide');
}

function ModificarDocente(_data_table){
    
    var InputCodigoDocenteModif = $("#InputCodigoDocenteModif").val();
    var InputDNIModif = $("#InputDNIModif").val();
    var InputApellidosModif = $("#InputApellidosModif").val();
    var InputNombresModif = $("#InputNombresModif").val();
    var InputDireccionModif = $("#InputDireccionModif").val();
    var SelectGeneroModif = $("#SelectGeneroModif").val();
    var InputFechaNacModif = $("#InputFechaNacModif").val();
    var InputTelefonoModif = $("#InputTelefonoModif").val();
    var SelectEstMencionModif = $("#SelectEstMencionModif").val();
    var SelectCiudadModif = $("#SelectCiudadModif").val();
    var InputEmailModif = $("#InputEmailModif").val();
    
    if(InputDNIModif!=="" && InputApellidosModif!=="" && InputNombresModif!=="" && InputDireccionModif!=="" && SelectGeneroModif!==0 && 
      InputFechaNacModif!=="" && InputTelefonoModif!== "" && SelectEstMencionModif!==0 && SelectCiudadModif!== 0 && InputEmailModif!== "")
  {
      $("#btn_aceptar_modificar").attr("disabled", true);
      $("#loader_modificar").fadeIn();
      
      $.post('controlador/CrDocente.php?opcion=modificar',{
           codigo: InputCodigoDocenteModif,
           dni : InputDNIModif,
           apellidos : InputApellidosModif,
           nombres : InputNombresModif,
           direccion : InputDireccionModif,
           id_genero : SelectGeneroModif,
           fecha_nacimiento : InputFechaNacModif,
           telefono : InputTelefonoModif,
           id_estmencion : SelectEstMencionModif,
           id_ciudad : SelectCiudadModif,
           email : InputEmailModif
       },function(data){
            if(data.valor_estado!=0)
                alert("Docente " + InputCodigoDocenteModif + " modificado correctamente.");
            else
                alert("Error al modificar docente. Intentelo nuevamente.");
            
            $("#loader_modificar").hide();
            $("#btn_aceptar_modificar").attr("disabled", false);
            $('#ModificarDocenteModal').modal('hide');
            _data_table.fnStandingRedraw();
            
       },'json');
  }
  else
      alert("Revise los campos ingresados.");
}


function eliminarDocente(_codigo_docente,_data_table){
        
        $.post('controlador/CrDocente.php?opcion=eliminar',
        {
           codigo_docente : _codigo_docente
        },function(data){
            if(data.valor_estado!=0)
                alert("Docente " + _codigo_docente + " eliminado correctamente.");
            else
                alert("Error al eliminar la fila");
            
            _data_table.fnStandingRedraw();
            
       },'json');
}

/* Docente */

/* Banco */

function CancelarBanco(){
    $('#NuevoBancoModal').modal('hide');
}

function AgregarBanco(_data_table){
    var InputDescripcionBanco = $("#InputDescripcionBanco").val();
    
    if(InputDescripcionBanco!=""){
       $("#btn_aceptar").attr("disabled", true);
       $("#loader_nuevo").fadeIn();
       
       $.post('controlador/CrBanco.php?opcion=insertar',{
           descripcion : InputDescripcionBanco,
       },function(data){
            if(data.codigo_banco!='')
                alert("Banco " + data.codigo_banco + " ingresado correctamente.");
            else
                alert("Error al ingresar. Intentelo nuevamente.");
            
            $("#loader_nuevo").hide();
            $("#btn_aceptar").attr("disabled", false);
            $('#NuevoBancoModal').modal('hide');
            _data_table.fnStandingRedraw();
            
       },'json');
    }
    else
        alert("Revise los datos ingresados!");
}

function ModificarBanco(_data_table){
    var InputBancoModificar = $("#InputBancoModificar").val();
    var InputDescripcionBancoModificar = $("#InputDescripcionBancoModificar").val();
    
    if(InputBancoModificar!="" && InputDescripcionBancoModificar!=""){
        $("#btn_aceptar_modificar").attr("disabled", true);
        $("#loader_modificar").fadeIn();
        
        $.post('controlador/CrBanco.php?opcion=actualizar',{
           id_banco : InputBancoModificar,
           descripcion : InputDescripcionBancoModificar,
       },function(data){
            if(data.valor_estado!=0)
                alert("Banco " + InputBancoModificar + " modificado correctamente.");
            else
                alert("Error al modificar. Intentelo nuevamente.");
            
            $("#loader_modificar").hide();
            $("#btn_aceptar_modificar").attr("disabled", false);
            $('#ModificarBancoModal').modal('hide');
            _data_table.fnStandingRedraw();
            
       },'json');
    }
    else
        alert("Ingrese la descripcion");
}

function CancelarBancoModificar(){
    $('#ModificarBancoModal').modal('hide');
}

function CancelarBancoNuevo(){
    $('#NuevoBancoModal').modal('hide');
}

function eliminarBanco(_codigo_banco,_data_table){
        
        $.post('controlador/CrBanco.php?opcion=eliminar',
        {
           id_banco : _codigo_banco
        },function(data){
            if(data.valor_estado!=0)
                alert("Banco " + _codigo_banco + " eliminado correctamente.");
            else
                alert("Error al eliminar la fila");
            
            _data_table.fnStandingRedraw();
            
       },'json');
}

/* Ciudad */

/* Ciudad */

function AgregarCiudad(_data_table){
    var InputDescripcionCiudad = $("#InputDescripcionCiudad").val();
    
    if(InputDescripcionCiudad!=""){
       $("#btn_aceptar").attr("disabled", true);
       $("#loader_nuevo").fadeIn();
       
       $.post('controlador/CrCiudad.php?opcion=insertar',{
           descripcion : InputDescripcionCiudad,
       },function(data){
            if(data.codigo_ciudad!='')
                alert("Ciudad " + data.codigo_ciudad + " ingresado correctamente.");
            else
                alert("Error al ingresar. Intentelo nuevamente.");
            
            $("#loader_nuevo").hide();
            $("#btn_aceptar").attr("disabled", false);
            $('#NuevoCiudadModal').modal('hide');
            _data_table.fnStandingRedraw();
            
       },'json');
    }
    else
        alert("Revise los datos ingresados!");
}

function ModificarCiudad(_data_table){
    var InputCiudadModificar = $("#InputCiudadModificar").val();
    var InputDescripcionCiudadModificar = $("#InputDescripcionCiudadModificar").val();
    
    if(InputCiudadModificar!="" && InputDescripcionCiudadModificar!=""){
        $("#btn_aceptar_modificar").attr("disabled", true);
        $("#loader_modificar").fadeIn();
        
        $.post('controlador/CrCiudad.php?opcion=actualizar',{
           id_ciudad : InputCiudadModificar,
           descripcion : InputDescripcionCiudadModificar,
       },function(data){
            if(data.valor_estado!=0)
                alert("Ciudad " + InputCiudadModificar + " modificado correctamente.");
            else
                alert("Error al modificar. Intentelo nuevamente.");
            
            $("#loader_modificar").hide();
            $("#btn_aceptar_modificar").attr("disabled", false);
            $('#ModificarCiudadModal').modal('hide');
            _data_table.fnStandingRedraw();
            
       },'json');
    }
    else
        alert("Ingrese la descripcion");
}

function CancelarCiudadNuevo(){
    $('#NuevoCiudadModal').modal('hide');
}

function CancelarCiudadModificar(){
    $('#ModificarCiudadModal').modal('hide');
}

function eliminarCiudad(_codigo_ciudad,_data_table){
        
        $.post('controlador/CrCiudad.php?opcion=eliminar',
        {
           id_ciudad : _codigo_ciudad
        },function(data){
            if(data.valor_estado!=0)
                alert("Ciudad " + _codigo_ciudad + " eliminado correctamente.");
            else
                alert("Error al eliminar la fila");
            
            _data_table.fnStandingRedraw();
            
       },'json');
}

/* Ciudad */