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
    <link href="css/style.css" rel="stylesheet">
    <link href="css/bootstrap-imgupload.css" rel="stylesheet">
    <link href="css/mdb.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
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
            <li><a href="menu.php">Menú</a></li>
            <li><a href="<?php echo'explorador.php?dir='.$_SESSION['FACULTAD'].'&id='.$_SESSION['RAIZ'];?>">Explorador</a></li>
            <?php
              if($_SESSION['ROL']=="SUPER" || $_SESSION['ROL']=="ADMIN"){
                echo "<li><a href='#' data-toggle='modal' data-target='#modal-decision'>Administrar Usuarios</a></li>";
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
          <div class="container">
            <div class="row">
              <div class="col-md-10 col-md-offset-1">
                  <div class="panel panel-default panel-table">
                    <div class="panel-heading">
                      <div class="row">
                        <div class="col col-xs-6">
                          <h3 class="panel-title">Privilegios</h3>
                        </div>
                      </div>
                    </div>
                    <div class="panel-body">
                      <table class="table table-striped table-bordered table-list" id="mytable">
                        <thead>
                          <tr>
                            <th WIDTH="15%" style="vertical-align:middle;"><div align="center" >Cédula</div></th>
                            <th WIDTH="20%" style="vertical-align:middle;"><div align="center" >Nombre</div></th>
                            <th WIDTH="25%" style="vertical-align:middle;"><div align="center" >Facultad</div></th>
                            <th WIDTH="10%" style="vertical-align:middle;"><div align="center" >Rol</div></th>
                            <th WIDTH="10%" style="vertical-align:middle;"><div align="center" >Actividad</div></th>
                            <?php
                              if($_SESSION['ROL']=='SUPER'){
                                echo '<th WIDTH="10%" style="vertical-align:middle;"><div align="center" >Administrador</div></th>';
                              }
                            ?>
                            <th WIDTH="10%" style="vertical-align:middle;"><div align="center">Carpeta</div></th>
                          </tr>
                        </thead>
                        <tbody>
                          <form id="cambio" action="include/control.php" method="post">
                            <?php funciones:: buscarPrivilegios(); ?>
                            <input type="hidden" name="cedPriv" id="cedPriv">
                            <input type="hidden" name="Priv" id="Priv">
                          </form>
                        </tbody>
                      </table>
                    </div>
                </div>
              </div>
            </div>
         </div>

         <!--Modal Registro-->
         <div class="modal fade" id="modal-registro" role="dialog">
           <div class="modal-dialog">
             <div class="modal-content">
               <div class="modal-body">
                 <div class="container-fluid">
                   <div class="row">
                     <div class="col-sm-12">
       	              <form role="form" action="include/control.php" method="post" ENCTYPE='multipart/form-data'>
     		                <h2 class="text-center" style="margin-bottom:0px;">REGISTRAR</h2>
                         <hr class="prettyline">
     		                <div class="row">
     			                <div class="col-xs-12 col-sm-12 col-md-12">
     				                <div class="form-group">
                               <input type="text" name="nameSign" id="nameSign" class="form-control input-lg" placeholder="Nombre Completo" tabindex="1" autocomplete="off" required>
     				                </div>
     			                </div>
     		                </div>
       		                <div class="row">
       			                <div class="col-xs-12 col-sm-6 col-md-4">
       				                <div class="form-group">
       			                    <input type="text" name="cedSign" id="cedSign" class="form-control input-lg" placeholder="Cédula" tabindex="3" autocomplete="off" required>
       		                    </div>
       			                </div>
                             <?php
                               if($_SESSION['ROL']=="SUPER"){
           			                echo'
                                 <div class="col-xs-12 col-sm-6 col-md-8">
                                   <div class="input-group input-group-lg"style="z-index:"0";>
                                     <input type="text" class="form-control" id="FacR" name="FacR" required>
                                     <div class="input-group-btn">
                                       <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                                       <ul class="dropdown-menu pull-right" role="menu" id="Fac">
                                         <li><a>ING. DE SISTEMAS COMPUTACIONALES</a></li>
                                         <li><a>ING. CIVIL</a></li>
                                         <li><a>ING. ELECTRICA</a></li>
                                         <li><a>ING. MECANICA</a></li>
                                         <li><a>ING. INDUSTRIAL</a></li>
                                         <li><a>CIENCIAS Y TECNOLOGIA</a></li>
                                       </ul>
                                     </div>
                                   </div>
           				              </div>';
                               }
                             ?>
       		                </div>
       			            <div class="row">
       				            <div class="col-xs-12 col-sm-6 col-md-6">
       					            <div class="form-group">
       						            <input type="password" name="passwordSign" id="passwordSign" class="form-control input-lg" placeholder="Contraseña" tabindex="5" required>
       					            </div>
       				            </div>
       				            <div class="col-xs-12 col-sm-6 col-md-6">
       					            <div class="form-group">
       						            <input type="password" name="passwordConfirm" id="passwordConfirm" class="form-control input-lg" placeholder="Confirmar Contraseña" tabindex="6" required>
       					            </div>
       				            </div>
       			            </div>
                         <div class="container-fluid PREV">
                           <div class="row">
                             <div class="col-xs-12 col-md-10 col-sm-8 col-md-offset-1 col-sm-offset-2">
                               <div class="input-group image-preview">
                                 <input type="text" class="form-control image-preview-filename input-lg" readonly="readonly" style="background-color:transparent;" data-placement="top" id="uploadFile" name="uploadFile">
                                 <span class="input-group-btn">
                                   <button type="button" class="btn btn-default image-preview-clear input-lg" style="display:none;" data-toggle="tooltip" title="Eliminar" id="sinImg" name="sinImg">
                                     <span class="glyphicon glyphicon-remove"></span>
                                   </button>
                                   <div class="btn btn-default image-preview-input input-lg red-tooltip" data-toggle="tooltip" title="Agregar imagen">
                                       <span class="glyphicon glyphicon-folder-open" style="padding-right:5px;"></span>
                                       <span class="image-preview-input-title"></span>
                                       <input type="file" accept="image/png, image/jpeg, image/gif" name="uploadBtn" id="uploadBtn"/>
                                   </div>
                                 </span>
                               </div>
                             </div>
                           </div>
                         </div>
           			        <div class="row">
           				        <div class="col-md-6 col-md-offset-3"><input type="submit" value="Registrar" class="btn btn-primary btn-block btn-lg" name="botonRegA" id="botonRegA" tabindex="7" disabled>
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
         <!--Fin Modal Registro-->

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
    <script>
      $('[data-toggle="tooltip"]').tooltip();
    </script>
  </body>
</html>
