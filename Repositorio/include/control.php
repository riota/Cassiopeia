<?php require_once 'funciones.php';
  @$botonLogin = $_POST["botonLogin"];
  if(@$botonLogin){
    $cedula = $_POST["cedulaLogin"];
    $password = $_POST["passwordLogin"];
    funciones::iniciar_sesión($cedula,$password);
  }

  @$botonL = $_POST["Logout"];
  if(@$botonL){
    funciones::cerrar_sesión();
  }

  @$botonSaveFile = $_POST["savefile"];
  if(@$botonSaveFile){
    $nombre = $_POST["namefile"];
    $editor = $_POST["editor"];
    if(@$_POST["StateNewDoc"] == true) $estado = "PUBLICO"; else $estado = "PRIVADO";
    $turl = $_GET['dir'];
    $tid = $_GET['id'];
    if (funciones::verificarNombreArchivos($tid,$nombre)==0){
      if(funciones::cargarDocumento($nombre, $editor,$tid,$turl,$estado)>0){
        echo"<script language=JavaScript>
        alert('Documento Creado');
        window.location='../explorador.php?id=".$tid."&dir=".$turl."';
        </script>";
      }
    }
    else{
      echo"<script language=JavaScript>
      alert('Este nombre ya existe');
      window.location='../explorador.php?id=".$tid."&dir=".$turl."&texto=".$editor."';
      </script>";
    }
  }

  @$botonReg = $_POST["botonReg"];
  @$botonRegA = $_POST["botonRegA"];
  if(@$botonReg || @$botonRegA){
    session_start();
    $cedula = $_POST["cedSign"];
    $nombre = $_POST["nameSign"];
    $password = $_POST["passwordSign"];
    if($_SESSION['ROL']=="SUPER"){
      $facultad = $_POST["FacR"];
    }
    else {
      $facultad = $_SESSION['FACULTAD'];
    }
    @$imagen = $_POST["uploadFile"];
    if(funciones::registrarUsuario($cedula, $nombre, $password, $facultad, $imagen)>0){
      if(@$botonReg){
        echo"<script language=JavaScript>
        alert('Usuario Registrado');
        window.location='../menu.php';
        </script>";
      }
      else {
        echo"<script language=JavaScript>
        alert('Usuario Registrado');
        window.location='../admin_user.php';
        </script>";
      }
    }
    else{
      echo"<script language=JavaScript>
      alert('La cédula ya existe');
      window.location='../admin_user.php';
      </script>";
    }
  }

  @$botonActYo = $_POST["botonActYo"];
  if(@$botonActYo){
    session_start();
    $cedula = $_POST["cedSignA"];
    $nombre = $_POST["nameSignA"];
    $password = $_POST["passwordSignA"];
    @$imagen = $_POST["uploadFileV"];
    if(funciones::actualizarme($cedula, $nombre, $password, $imagen)>0){
      echo"<script language=JavaScript>
      alert('Información Actualizada');
      window.location='../menu.php';
      </script>";
    }
  }

  @$botonActYoB = $_POST["botonActYoB"];
  if(@$botonActYoB){
    session_start();
    $cedula = $_POST["cedSignB"];
    $nombre = $_POST["nameSignB"];
    if($_SESSION['ROL']=="SUPER"){
      $facultad = $_POST["FacRB"];
    }
    else{
      $facultad = $_SESSION['FACULTAD'];
    }
    $password = $_POST["passwordSignB"];
    @$imagen = $_POST["uploadFileAV"];
    if(funciones::actualizarUsuario($cedula, $nombre, $facultad, $password, $imagen)>0){
      echo"<script language=JavaScript>
      alert('Información Actualizada');
      window.location='../admin_user.php';
      </script>";
    }
  }

  @$botonbusca = $_POST["buscafile"];
  if(@$botonbusca){
    $nombre = $_POST["buscaNameFile"];
    if($nombre){
      header("Location: ../menu.php?CADENA=".$nombre);
    }
    else {
      header("Location: ../menu.php");
    }
  }

  @$botonNewFolder = $_POST["newfolder"];
  if(@$botonNewFolder){
    $next = strtoupper($_POST["carpeta"]);
    $turl = $_GET['dir'];
    $tid = $_GET['id'];
    if(funciones::verificarNombreCarpetas($tid,$next)==0){
      mkdir("../raiz/".$turl."/".$next);
      if(funciones::crearCarpeta($next,$tid,$turl)>0){
        echo"<script language=JavaScript>
        alert('CARPETA CREADA');
        window.location='../explorador.php?id=".$tid."&dir=".$turl."';
        </script>";
      }
    }
    else {
      echo"<script language=JavaScript>
      alert('Ya existe esta carpeta');
      window.location='../explorador.php?id=".$tid."&dir=".$turl."';
      </script>";
    }
  }

  @$botonCargar = $_POST["cargar"];
  if(@$botonCargar){
    $estado = "PRIVADO";
    $turl = $_GET['dir'];
    $tid = $_GET['id'];
    if(@$_POST["fileState"] == true) $estado = "PUBLICO"; else $estado = "PRIVADO";
    if (funciones::verificarSizeArchivo($_FILES['archivo']['size'])==1) {
      $mensaje="No se puede subir archivos con pesos mayores a 2MB, verifique su planeación";
    }
    else {
      if(@$_FILES['archivo']['tmp_name']!="" && $_FILES['archivo']['error']==0) {
        session_start();
        $namefile=$_FILES['archivo']['name'];
        @$extension=strtolower(array_pop(explode(".",$namefile)));
        if(funciones::verificarTipoArchivo($extension)){
          if (funciones:: verificarNombreArchivos($tid,$namefile)==0){
            move_uploaded_file($_FILES['archivo']['tmp_name'],"../RAIZ/".$turl."/".$namefile);
            if(funciones::cargarArchivo($namefile,$tid,$_FILES['archivo']['size'],$turl,$estado)>0){
              $mensaje="El archivo se cargó exitosamente";
            }
          }
          else{
            $mensaje="El archivo ya existe en esta carpeta";
          }
        }
        else {
          $mensaje="El archivo que intenta subir no esta permitido";
        }
      }
    }
    if (@$mensaje) {
      echo"<script language=JavaScript>
      alert('$mensaje');
      window.location='../explorador.php?id=".$tid."&dir=".$turl."';
      </script>";
    }
  }

  @$botonAdmin = $_POST["botonAdmin"];
  if(@$botonAdmin){
    if($botonAdmin == "Usuarios"){
      header('Location: ../admin_user.php');
    }
    if($botonAdmin == "Archivos"){
      header('Location: ../admin_files.php');
    }
    if($botonAdmin == "Privilegios"){
      header('Location: ../admin_priv.php');
    }
  }

  @$botonNewType = $_POST["regNewType"];
  if(@$botonNewType){
    session_start();
    $extension = $_POST["extension"];
    $fileSize = $_POST["filesize"];
    $fileSize = $fileSize * 1048576;
    if(funciones::nuevoTipo($extension,$fileSize)>0){
      echo"<script language=JavaScript>
      window.location='../admin_files.php';
      </script>";
    }
  }

  @$botonEditType = $_POST["regEditType"];
  if(@$botonEditType){
    session_start();
    $id = $_POST["idEdit"];
    $extension = $_POST["extensionEdit"];
    $fileSize = $_POST["filesizeEdit"];
    $fileSize = $fileSize * 1048576;
    if(funciones::actualizarTipo($id,$extension,$fileSize)>0){
      echo"<script language=JavaScript>
      window.location='../admin_files.php';
      </script>";
    }
  }

  @$botonDelete = $_POST["btnDelete"];
  if(@$botonDelete){
    $id = $_POST["deleteId"];
    if(funciones::EliminarTipo($id)>0){
      echo"<script language=JavaScript>
      window.location='../admin_files.php';
      </script>";
    }
  }

  @$privilegios = $_POST["Priv"];
  if(@$privilegios){
    $band = 0;
    $cedula = $_POST["cedPriv"];
    if(@$privilegios == "admin"){
      if(funciones::actualizarAdminUser($cedula)>0) $band=1;
    }
    else{
      if (@$privilegios == "folder"){
        if (funciones::actualizarFolderUser($cedula)>0) $band=1;
      }
      else {
        if(funciones::actualizarActividadUser($cedula)>0) $band=1;
      }
    }
    if($band==1){
      echo"<script language=JavaScript>
      window.location='../admin_priv.php';
      </script>";
    }
  }

  @$botonEliminarFile= $_POST["botonEliminarFile"];
  if(@$botonEliminarFile){
    $turl = $_GET['dir'];
    $tid = $_GET['id'];
    $id = $_POST["idFileDecision"];
    if(funciones::EliminarFile($id)>0){
      echo"<script language=JavaScript>
      alert('Archivo Eliminado');
      window.location='../explorador.php?id=".$tid."&dir=".$turl."';
      </script>";
    }
    else {
      echo"<script language=JavaScript>
      alert('Usted no es dueño de este archivo. No puede eliminarlo');
      window.location='../explorador.php?id=".$tid."&dir=".$turl."';
      </script>";
    }
  }

  @$botonDescargarFile= $_POST["botonDescargarFile"];
  if(@$botonDescargarFile){
    $turl = $_GET['dir'];
    $tid = $_GET['id'];
    $id = $_POST["idFileDecision"];
    $link = funciones::DescargarFile($id);
    $name = funciones::NombreFile($id);
      echo"<script language=JavaScript>
      window.open='RAIZ/".$link."/".$name."';
      window.location='../explorador.php?id=".$tid."&dir=".$turl."';
      </script>";
  }

 ?>
