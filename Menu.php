<?php
  if(!isset($_SESSION['user']))
      header('Location: index.php');
?>

    <nav class="navbar navbar-default" role="navigation">
                  <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                      </button>
                      <a class="navbar-brand" href="#"><?php echo $_SESSION['user']->id_usuario. ": " .$_SESSION['user']->nombres ?></a>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                      <ul class="nav navbar-nav">
<!--                        <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
                        <li><a href="#">Link</a></li>-->
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Mantenimiento <span class="caret"></span></a>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="Curso.php">Curso</a></li>
                            <li><a href="Programa.php">Programa</a></li>
                            <li><a href="Mencion.php">Mención</a></li>
                            <li><a href="#">Plan estudios</a></li>
                            <li><a href="Aula.php">Aula</a></li>
                            <li><a href="Docente.php">Docente</a></li>
                            <li><a href="Banco.php">Banco</a></li>
                            <li><a href="Ciudad.php">Ciudad</a></li>
                          </ul>
                        </li>
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Registrar <span class="caret"></span></a>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Pagos</a></li>
                            <li><a href="#">Matricula</a></li>
                            <li><a href="#">Asistencia</a></li>
                            <li><a href="#">Notas</a></li>
                          </ul>
                        </li>
                      </ul>
                        
                      <ul class="nav navbar-nav navbar-right">
<!--                        <li><a href="#">Link</a></li>-->
                        <form class="navbar-form navbar-left" role="search">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Search">
                            </div>
                            <button type="submit" class="btn btn-default">Submit</button>
                            <button type="submit" class="btn btn-default">Salir</button>
                        </form>
                      </ul>
                    </div><!-- /.navbar-collapse -->
                  </div><!-- /.container-fluid -->
                </nav>