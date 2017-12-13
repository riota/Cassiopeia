<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Repositorio</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Cabin:700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/leftbar.css" rel="stylesheet">
    <link href="css/jquery-te.css" rel="stylesheet">
    <link href="css/Style.css" rel="stylesheet">
  </head>
  <body class='index'>
    <?php require_once ('include/funciones.php'); funciones::verificar_sesión("index"); ?>
    <div id="wrapper">
      <div class="overlay"></div>
      <!-- Sidebar -->
      <nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">
        <ul class="nav sidebar-nav">
          <div class="sidebar-container">
            <div class="row">
              <h1 class="text-center sidebar-login">Login</h1>
              <form action="include/control.php" role="form" method=post>
                <div class="col-xs-11 col-xs-offset-1">
                  <div class="form-group">
                    <input class="form-control" id="cedulaLogin" placeholder="Cédula" name="cedulaLogin" type="text" autocomplete="off">
                  </div>
                </div>
                <div class="col-xs-11 col-xs-offset-1">
                  <div class="form-group">
                    <input class="form-control" id="passwordLogin" placeholder="Password" name="passwordLogin" type="password">
                  </div>
                </div>
                  <div class="col-xs-10 col-xs-offset-7">
                    <input name="botonLogin" class="btn btn-md btn-style" type="submit" value="Login">
                  </div>
              </form>
            </div>
          </div>
        </ul>
    </nav>
      <!-- Fin del Sidebar -->
    <div id="page-content-wrapper" style="padding-top:0;">
      <div class="hamburger-bg"></div>
        <button type="button" class="hamburger is-closed" data-toggle="offcanvas">
          <span class="hamb-top"></span>
          <span class="hamb-middle"></span>
          <span class="hamb-bottom"></span>
        </button>
        <div class="container">
          <div class="row vertical-center">
            <div class="col-md-6 col-xs-12">
              <div class="img-container">
                <img id="computer" src="css/img/computer-still.png" class="img-responsive center-block">
              </div>
            </div>
            <div class="col-md-6 col-xs-12">
              <h1 class='brand-title'>un poderoso administrador de contenido</h1>
              <div class='brand-desc'>
                  <strong style="font-weight: bold;">CASSIOPEIA</strong> es una plataforma de administracion de archivos, elaborada en PHP utilizando el framework de Bootstrap, desarrollada por el grupo de cuarto año de Ingenieria en Sistemas Computacionales del Centro Regional de Azuero.
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <footer class="footer">
            <span class="text-muted">Grupo de Ing. Sist. 4 año - 2017</span>
    </footer>

    <script src="js/jquery.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <script src="js/jquery-te.min.js" type="text/javascript"></script>
    <script src="js/personal.js" type="text/javascript"></script>

  </body>
</html>
