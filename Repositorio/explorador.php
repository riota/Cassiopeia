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
  <link href="css/Style.css" rel="stylesheet">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
  <?php require_once ('include/funciones.php'); funciones::verificar_sesión('otra'); ?>
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
        <li><a href="menu.php">Menú</a></li>
        <?php
          if ($_SESSION['ROL']!='SUPER') {
            echo '
           <li><a href="#" data-toggle="modal" data-target="#modal-crear">Nuevo Documento</a></li>
           <li><a href="#" data-toggle="modal" data-target="#modal-cargar">Subir Archivo</a></li>';
            if ($_SESSION['FOLDER']=='SI') {
              echo'<li><a href="#" data-toggle="modal" data-target="#modal-carpeta">Crear Carpeta</a></li>';
            }
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
        <h1 class="text-center">
          <?php
            if (strpos($_GET['dir'],"/")>0){
              echo substr(strrchr($_GET['dir'], '/'),1);
            }
            else{
              echo $_GET['dir'];
            }
          ?>
        </h1>
        <div class="row">
          <div class="col-xs-12 col-md-10 col-md-offset-1">
            <ol class="breadcrumb">
              <?php
                if(isset($_GET['dir'])){
                  $bread = $_GET['dir'];
                  $breadArray = explode('/', $bread);
                  foreach ($breadArray as $breadcrumb) {
                    echo"<li class='breadcrumb-item' style='color: green'>".$breadcrumb."</li>";
                  }
                }
              ?>
            </ol>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-10 col-md-6 col-md-offset-3 col-xs-offset-1">
          <div class="row">
            <div class="list-group">
              <div class="list-group-item link">Archivo
                <div class="hidden-sm hidden-xs" style="float:right;">Fecha de subida
                </div>
              </div>
              <?php require_once ('include/funciones.php');
                function reverse_strrchr($haystack, $needle, $trail) {
                  return strrpos($haystack, $needle) ? substr($haystack, 0, strrpos($haystack, $needle) + $trail) : false;
                }
                $idany = $_GET['id'];
                if (substr($_GET['dir'], strrpos($_GET['dir'], '/')) != $_SESSION["FACULTAD"] && substr($_GET['dir'], strrpos($_GET['dir'], '/')) != "RAIZ" ) {
                  $atras = reverse_strrchr($bread,"/",0);
                  $idant = funciones::buscarCarpetaId($idany);
                 echo '<a class="list-group-item" href="explorador.php?dir='.$atras.'&id='.$idant.'"><i class="fa fa-level-up fa-fw" aria-hidden="true"></i> ...
                 </a>';
                }
                funciones::explorador($idany,$bread);
               ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Decision File-->
  <div class="modal fade" id="modal-decisionFile">
    <div class="modal-dialog modal-alert" role="document">
      <div class="modal-content">
        <div class="modal-header" style="border: 0;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title center-block" id="exampleModalLabel">Archivos</h4>
        </div>
        <form action='<?php echo "include/control.php?dir=".$_GET["dir"]."&id=".$_GET["id"];?>' method="post">
          <div class="modal-body">
            <input type="hidden" id="idFileDecision" name="idFileDecision">
            <input type="submit" class="btn btn-primary" name="botonEliminarFile" value="Eliminar">
            <a href="" id="DescargarAFile" class="btn btn-primary" name="botonDescargarFile">Descargar</a>
          </div>
        </form>
      </div>
    </div>
    </div>
  <!-- Modal Decision File-->

  <!-- Modal Cargar -->
  <div class="modal fade" id="modal-cargar" role="dialog"> <!--data-backdrop="static" data-keyboard="false-->
    <div class="modal-dialog">
      <div class="modal-content">
        <h1 class="modal-header">Subir Archivo</h1>
        <form role="form" action='<?php echo "include/control.php?dir=".$_GET["dir"]."&id=".$_GET["id"];?>' method="post" ENCTYPE='multipart/form-data'>
          <div class="modal-body">
            <div class="form-group">
              <div class="container-fluid PREV">
                <div class="row">
                  <div class="col-xs-12 col-md-12 col-sm-12">
                    <div class="col-xs-2 col-md-2 col-sm-2 col-md-offset-1">
                      <label for="fileState">Público</label>
                      <div class="material-switch">
                        <input type="checkbox" id="fileState" name="fileState">
                        <label for="fileState" class="label-success"></label>
                      </div>
                    </div>
                    <div class="col-xs-8 col-md-8 col-sm-8">
                      <div class="input-group">
                        <input type="text" class="form-control image-preview-filename input-lg" readonly="readonly" style="background-color:transparent;" data-placement="top" id="uploadFile" name="uploadFile">
                        <span class="input-group-btn" >
                          <button type="button" class="btn btn-default image-preview-clear input-lg" style="display:none;" data-toggle="tooltip" title="Eliminar" id="sinImg" name="sinImg">
                            <span class="glyphicon glyphicon-remove"></span>
                          </button>
                          <div class="btn btn-default image-preview-input input-lg red-tooltip" data-toggle="tooltip" title="Agregar imagen">
                              <span class="glyphicon glyphicon-folder-open" style="padding-right:5px;"></span>

                              <input type="file" name="archivo" id="archivo" required />
                          </div>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <br>
              <input name="cargar" id="cargar" class="btn btn-block btn-lg btn-black" type="submit" value="Subir">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Modal Cargar -->

  <!-- Modal Textos -->
  <div class="modal fade" id="modal-crear" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <h1 class="modal-header">Nuevo documento</h1>
        <div class="modal-body">
          <form action='<?php echo "include/control.php?dir=".$_GET["dir"]."&id=".$_GET["id"];?>' method="post">
            <div class="row">
              <div class="col-md-4">
                <label for="namefile">Nombre Archivo</label>
                <div class="form-group form-inline">
                  <input type="text" id="namefile" name="namefile" class="form-control" autofocus required autocomplete="off">
                </div>
              </div>
              <div class="col-md-4">
                <label for="StateNewDoc">Archivo Público</label>
                <div class="material-switch col-md-offset-2">
                  <input type="checkbox" id="StateNewDoc" name="StateNewDoc">
                  <label for="StateNewDoc" class="label-success"></label>
                </div>
              </div>
            </div>
            <label for="editor">Editor</label>
            <div class="form-group">
              <textarea id="editor" name="editor" class="form-control" rows="10" cols="10" required>
                <?php if (@$_GET["texto"]) echo $_GET["texto"]; ?>
              </textarea>
            </div>
            <br><button class="btn btn-success" type="submit" value="savefile" name="savefile">Guardar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal Textos -->

  <!-- Modal Carpeta -->
  <div class="modal fade" id="modal-carpeta" role="dialog"> <!--data-backdrop="static" data-keyboard="false-->
    <div class="modal-dialog">
      <div class="modal-content">
        <h1 class="modal-header">Nueva Carpeta</h1>
        <form role="form" action='<?php echo "include/control.php?dir=".$_GET["dir"]."&id=".$_GET["id"];?>' method="post">
          <div class="modal-body">
            <label for="carpeta">Nombre de la Carpeta</label>
            <div class="form-group">
              <input type="text" style="text-transform:uppercase;" id="carpeta" name="carpeta" class="form-control" autofocus required autocomplete="off"><br>
              <input name="newfolder" id="newfolder" class="btn btn-block btn-lg btn-black" type="submit" value="Crear Carpeta">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Modal Carpeta -->

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

  <footer class="footer">
    <span class="text-muted">Grupo de Ing. Sist. 4 año - 2017</span>
  </footer>

<script src="js/jquery.min.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js" type="text/javascript"></script>
<script src="js/jquery-te.min.js" type="text/javascript"></script>
<script src="js/lab3.js" type="text/javascript"></script>

</body>
</html>
