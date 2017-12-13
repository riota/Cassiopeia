<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Repositorio</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/leftbar.css" rel="stylesheet">
    <link href="css/jquery-te.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
  </head>
  <body>
    <?php require_once ('include/funciones.php'); funciones::verificar_sesión("otra"); ?>
    <div id="wrapper">
      <div class="overlay"></div>
      <nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">
        <ul class="nav sidebar-nav">
          <div class='container-img'>
            <img src='img_profile/<?php echo $_SESSION["IMAGEN"]?>' class='img-responsive img-circle center-block img-user'>
          </div>
            <h5 class='sidebar-text text-center'><?php echo $_SESSION['NOMBRE'];?></h5>
            <form action="include/control.php" method="post">
              <a class='profile-link' href="" data-toggle='modal' data-target='#modal-editarperfil' style='margin-left:20px;'>Editar Perfil</a>
              <a class='profile-link' href="Logout.php">Cerrar Sesion</a>
            </form>
            <li></li>
            <?php
              if($_SESSION['ROL']=='SUPER'){
                echo '<li><a href="explorador.php?dir=RAIZ&id='.$_SESSION['RAIZ'].'">Explorador</a></li>';
              }
              else {
                  echo '<li><a href="explorador.php?dir='.$_SESSION['FACULTAD'].'&id='.$_SESSION['RAIZ'].'">Explorador</a></li>';
              }
              if($_SESSION['ROL']=='SUPER' || $_SESSION['ROL']=='ADMIN'){
                echo '<li><a href="#" data-toggle="modal" data-target="#modal-decision">Administrar Usuarios</a></li>';
              }
            ?>
        </ul>
      </nav>
      <div id="page-content-wrapper">
      <div class="hamburger-bg"></div>
      <button type="button" class="hamburger is-closed" data-toggle="offcanvas">
        <span class="hamb-top"></span>
        <span class="hamb-middle"></span>
        <span class="hamb-bottom"></span>
      </button>
      <div class="container">
        <div class="row">
          <?php
            if($_SESSION['ROL']!='SUPER'){
            echo'<div class="col-sm-4 col-sm-push-8 col-xs-12">
              <div class="panel panel-default">
                <div class="panel-body">
                  <h5 style="margin-bottom:0;">Mis Archivos</h5>
                </div>
                <div class="row">
                  <form id="buscarLupa" action="include/control.php" method="post">
                    <div class="col-xs-10 col-xs-offset-1">
                       <div class="input-group">
                        <input type="text" id="buscaNameFile" name="buscaNameFile" class="form-control" placeholder="Buscar...">
                        <span class="input-group-btn">
                          <button class="btn btn-default" type="submit" id="buscafile" name="buscafile" value="Buscar" onclick="document.getElementById(\'buscarLupa\').submit()">
                            <i class="fa fa-search"></i>
                          </button>
                        </span>
                      </div>
                    </div>
                  </form>
                </div>
                <hr style="margin-bottom: 0px;">
                <div class="scroll">';
                      funciones:: misarchivosrecientes(@$_GET['CADENA']);
                echo '
                </div>
              </div>
            </div>';
            if($_SESSION['ROL']!='SUPER'){
              echo '<div class="col-sm-8 col-sm-pull-4 col-xs-12" style="padding-bottom:50px;">';
            }
            else{
              echo '<div class="col-sm-12 col-xs-12" style="padding-bottom:50px;">';
            }
          }?>
          <h4 class="text-center" style="margin-bottom:0;">Archivos Agregados Recientemente</h4>
          <hr>
          <?php funciones:: archivosrecientes(); ?>
        </div>
      </div>
    </div>
  </div>

  <!--Modal Editar Perfil-->
  <div class="modal fade" id="modal-editarperfil" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-12">
                <form role="form" action="include/control.php" method="post" ENCTYPE='multipart/form-data'>
                  <h2 class="text-center" style="margin-bottom:0px;">Actualizar Datos</h2>
                  <hr class="prettyline">
                  <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                      <label for="nameSignA">Nombre</label>
                      <div class="form-group">
                        <input type="text" name="nameSignA" id="nameSignA" class="form-control input-lg" placeholder="Nombre Completo" tabindex="1" autocomplete="off" required value="<?php echo $_SESSION["NOMBRE"]?>">
                      </div>
                    </div>
                  </div>
                    <div class="row">
                      <div class="col-xs-12 col-sm-6 col-md-6">
                        <label for="cedSignA">Cédula</label>
                        <div class="form-group">
                          <input type="text" name="cedSignA" id="cedSignA" class="form-control input-lg" placeholder="Cédula" tabindex="3" autocomplete="off" required readonly value="<?php echo $_SESSION["CEDULA"]?>">
                        </div>
                      </div>
                    </div>
                  <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                      <label for="passwordSignA">Contraseña</label>
                      <div class="form-group">
                        <input type="password" name="passwordSignA" id="passwordSignA" class="form-control input-lg" placeholder="Contraseña" tabindex="5" required value="<?php echo $_SESSION["PASSWORD"]?>">
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                      <label for="passwordConfirmA">Confirmar Contraseña</label>
                      <div class="form-group">
                        <input type="password" name="passwordConfirmA" id="passwordConfirmA" class="form-control input-lg" placeholder="Confirmar Contraseña" tabindex="6" required value="<?php echo $_SESSION["PASSWORD"]?>">
                      </div>
                    </div>
                  </div>
                  <div class="container-fluid PREV">
                    <div class="row">
                      <div class="col-xs-12 col-md-10 col-sm-8 col-md-offset-1 col-sm-offset-2">
                        <div class="col-xs-6 col-xs-offset-3">
                          <input id="sinImgV" name="sinImgV" type="button" class="btn btn-md btn-danger" value="X">
                          <img src='img_profile/<?php echo $_SESSION["IMAGEN"]?>' class='img-responsive img-circle center-block img-user' id="img_registerV" style="height:175px; padding-top:15px;">
                          <div class="fileUpload btn btn-primary btn-block">
                            <span>Examinar</span>
                            <input id="uploadBtnV" name="uploadBtnV" type="file" class="upload" accept="image/jpeg"/>
                          </div>
                          <input id="uploadFileV" placeholder="Escojer Archivo..." class="form-control" name="uploadFileV" autocomplete="off" readonly value="<?php echo $_SESSION["IMAGEN"]?>"/>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 col-md-offset-3"><input type="submit" value="Actualizar" class="btn btn-success btn-block btn-lg" name="botonActYo" id="botonActYo" tabindex="7">
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--Fin Modal Editar Perfil-->

      <!-- Modal Decision -->
      <div class="modal fade" id="modal-decision">
        <div class="modal-dialog modal-alert" role="document">
          <div class="modal-content">
            <div class="modal-header" style="border: 0;">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title center-block" id="exampleModalLabel">Administrar</h4>
            </div>
            <form action="include/control.php" method="post">
              <div class="modal-body">
                <input type="submit" class="btn btn-primary" name="botonAdmin" value="Usuarios">
                <?php
                  if($_SESSION["ROL"]=="SUPER"){
                    echo '<input type="submit" class="btn btn-primary" name="botonAdmin" value="Archivos">';
                  }
                 ?>
                <input type="submit" class="btn btn-primary" name="botonAdmin" value="Privilegios">
              </div>
            </form>
          </div>
        </div>
        </div>
      <!-- Modal Decision -->

    <footer class="footer">
      <span class="text-muted">Grupo de Ing. Sist. 4 año - 2017</span>
    </footer>

    <script src="js/jquery.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <script src="js/jquery-te.min.js" type="text/javascript"></script>
    <script src="js/lab3.js" type="text/javascript"></script>

  </body>
</html>
