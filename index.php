<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="es">
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap -->
        <link href="lib_cliente/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="lib_cliente/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
        
        <script src="lib_cliente/jquery/jquery-1.11.1.min.js"></script>
        
        <!-- CSS -->
        <link href="lib_cliente/css/main.css" rel="stylesheet">
        
        <!-- javascript -->
        <script src="lib_cliente/scripts/main.js"></script>
        
    </head>
    <body>
        
        <div id="contenedor_login">
            <form role="form">
                <div class="form-group">
                  <label for="InputUsuario">Usuario</label>
                  <input type="text" class="form-control" id="InputUsuario" placeholder="Ingrese usuario">
                </div>
                <div class="form-group">
                  <label for="InputPassword">Password</label>
                  <input type="password" class="form-control" id="InputPassword" placeholder="Password">
                </div>
                
                <div class="checkbox">
                  <label>
                    <input type="checkbox"> Recordame
                  </label>
                </div>
                <div style="text-align: right;">
                    <button type="submit" class="btn btn-info" id="btn_submit" onclick="LogearUsuario();">Submit</button>
                </div>
                <!--br style="clear: both;" /-->
          </form>
            <div class="loader"><img src="lib_cliente/images/loader.gif" /></div>
        </div>
    </body>
</html>
