<?php require 'basedatos.php';
  class funciones{
    function __construct(){}
    public static function iniciar_sesión($cedula, $password){
      try {
        @$boton = $_POST["botonLogin"];
        if($boton){
          if (!isset($_SESSION)){
            session_start();
            $comando= "SELECT * FROM usuarios WHERE CEDULA=? AND PASSWORD=?";
            $sentencia=basedatos::obtenerInstancia()->obtenerConexion()->prepare($comando);
            $sentencia->execute(array($cedula, $password));
            $registro = $sentencia->fetch(PDO::FETCH_NUM);
            if(!$registro){
              echo"<script language=JavaScript>
              alert('Usuario o clave errónea');
              window.location='../index.php';
              </script>";
            }
            else{
              if ($registro[5]=="INACTIVO") {
                echo"<script language=JavaScript>
                alert('Lo sentimos su cuenta está inactiva');
                window.location='../index.php';
                </script>";
              }
              else {
                $_SESSION['CEDULA'] = $registro[1];
                $_SESSION['NOMBRE'] = $registro[2];
                $_SESSION['IMAGEN'] = $registro[6];
                $_SESSION['FACULTAD'] = $registro[3];
                $_SESSION['ROL'] = $registro[4];
                $_SESSION['PASSWORD'] = $registro[7];
                $_SESSION['FOLDER'] = $registro[8];
                $_SESSION['LOGIN']= true;
                switch ($registro[3]) {
                  case '':
                    $_SESSION['RAIZ']=1;
                  break;
                  case 'ING. DE SISTEMAS COMPUTACIONALES':
                    $_SESSION['RAIZ']=2;
                  break;
                  case 'ING. CIVIL':
                    $_SESSION['RAIZ']=3;
                  break;
                  case 'ING. MECANICA':
                    $_SESSION['RAIZ']=4;
                  break;
                  case 'ING. ELECTRICA':
                    $_SESSION['RAIZ']=5;
                  break;
                  case 'ING. INDUSTRIAL':
                    $_SESSION['RAIZ']=6;
                  break;
                  default:
                    $_SESSION['RAIZ']=7;
                    break;
                }
                header('Location: ../menu.php');
              }
            }
          }
          else {
            echo"<script language=JavaScript>
            alert('Ya existe una sesión abierta');
            window.location='../index.php';
            </script>";
          }
        }
      } catch (Exception $e) {
        echo $e;
      }
    }

    public static function cerrar_sesión(){
      try {
        session_start();
        if(@$_SESSION["LOGIN"]){
          session_destroy();
          echo "
          <script language=JavaScript>
          alert('Sesión cerrada correctamente');
          window.location='../index.php';
          </script>";
        }
      } catch (Exception $e) {
        echo $e;
      }
    }

    public static function verificar_sesión($pagina){
      session_start();
      if(!@$_SESSION["LOGIN"] && $pagina=="otra"){
        echo "
        <script language=JavaScript>
        alert('No ha iniciado sesión');
        window.location='index.php';
        </script>";
      }
      else{

      }
      if(@$_SESSION["LOGIN"] && $pagina=="index"){
        header('Location: menu.php');
      }
    }

    public static function explorador($idcarpeta,$dir){
      try{
        $FACULTAD = $_SESSION['FACULTAD'];
        if($idcarpeta==0){
          $idcarpeta = $_SESSION["RAIZ"];
        }
        $conn=basedatos::obtenerInstancia()->obtenerConexion();
        if($_SESSION['ROL']=="SUPER"){
          $comando="SELECT * FROM carpetas WHERE ID_PADRE = '$idcarpeta' ORDER BY NOMBRE";
        }
        else {
          $comando="SELECT * FROM carpetas WHERE FACULTAD='$FACULTAD' AND ID_PADRE = '$idcarpeta' ORDER BY NOMBRE";
        }
        $sentencia=basedatos::obtenerInstancia()->obtenerConexion()->prepare($comando);
        $sentencia->execute();
        while ($registro = $sentencia->fetch(PDO::FETCH_NUM)) {
          $idsub=$registro[0];
          $nombre=$registro[1];
          $carpetaSiguiente = $nombre;
          echo '<a class="list-group-item" href="explorador.php?dir='.$dir."/".$carpetaSiguiente.'&id='.$idsub.'"><i class="fa fa-folder-open fa-fw" aria-hidden="true"></i>'.$nombre.'
          </a>';
        };
        $conn=basedatos::obtenerInstancia()->obtenerConexion();
        if($_SESSION['ROL']=="SUPER"){
          $comando="SELECT * FROM archivos WHERE ID_CARPETA = '$idcarpeta' ORDER BY NOMBRE";
        }
        else {
          $comando="SELECT * FROM archivos WHERE FACULTAD='$FACULTAD' AND ID_CARPETA = '$idcarpeta' ORDER BY NOMBRE";
        }
        $sentencia=basedatos::obtenerInstancia()->obtenerConexion()->prepare($comando);
        $sentencia->execute();
        while ($registro = $sentencia->fetch(PDO::FETCH_NUM)) {
          if($registro[11]== "PUBLICO" || $registro[8] == $_SESSION['CEDULA']  || $_SESSION['ROL']=="SUPER"){
            $idsub= $registro[0];
            $original= $registro[2];
            $nombre= $registro[1];
            $fechacrea= $registro[5];
            $contenido = $registro[4];
            $url = $registro[10];
            $estado = $registro[11];
            if ($original=="TEXTO"){
              echo'<a href="" data-toggle="modal" data-target="#modal-crear" class="list-group-item">';
              if ($estado == "PRIVADO") {
                echo '<i class="fa fa-lock fa-fw" aria-hidden="true"></i>';
              }
              else{
                echo '<i class="fa fa-file-text-o fa-fw" aria-hidden="true"></i>';
              }
              echo $nombre;
              echo'<div class="hidden-sm hidden-xs" style="float:right;">'.$fechacrea.'</div>
              </a>';
            }
            else{
              echo'<a href="" data-url="RAIZ/'.$url.'/'.$nombre.'" id="aIdFile" data-toggle="modal" data-id="'.$idsub.'" data-target="#modal-decisionFile" class="list-group-item aIdFile"><i class="fa fa-file-text-o fa-fw" aria-hidden="true"></i> '.$nombre.'
                <div class="hidden-sm hidden-xs" style="float:right;">'.$fechacrea.'</div>
              </a>';
            }
          }
        }
      }catch(PDOException $e){
        echo $e;
      }
    }

    public static function cargarDocumento($name,$contenido,$id_carpeta,$url,$estado){
      try{
        session_start();
        date_default_timezone_set('America/Panama');
        $fecha = date('d/m/Y');
        $conn=basedatos::obtenerInstancia()->obtenerConexion();
        $comando="INSERT INTO archivos VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
        $sentencia=basedatos::obtenerInstancia()->obtenerConexion()->prepare($comando);
        $sentencia->execute(array("",$name,"TEXTO","",$contenido, $fecha,'',$id_carpeta,$_SESSION["CEDULA"],$_SESSION["FACULTAD"],$url,$estado));
        return $conn->lastInsertId();
      }catch(PDOException $e){
        echo $e;
      }
    }

    public static function cargarArchivo($name,$id_carpeta,$size,$url,$estado){
      try{
        date_default_timezone_set('America/Panama');
        $fecha = date('d/m/Y');
        $conn=basedatos::obtenerInstancia()->obtenerConexion();
        $comando="INSERT INTO archivos VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
        $sentencia=basedatos::obtenerInstancia()->obtenerConexion()->prepare($comando);
        $sentencia->execute(array("",$name,"ARCHIVO",$size,"", $fecha,'',$id_carpeta,$_SESSION["CEDULA"],$_SESSION["FACULTAD"],$url,$estado));
        return $conn->lastInsertId();
      }catch(PDOException $e){
        echo $e;
      }
    }

    public static function registrarUsuario($ced,$nom,$pass,$fac,$img){
      try{
        $conn=basedatos::obtenerInstancia()->obtenerConexion();
        $comando="SELECT * FROM usuarios WHERE CEDULA='$ced'";
        $sentencia=basedatos::obtenerInstancia()->obtenerConexion()->prepare($comando);
        $sentencia->execute();
        if (!$registro = $sentencia->fetch(PDO::FETCH_NUM)) {
          if (@$_FILES['uploadBtn']['name']) {
            $aux=$_FILES['uploadBtn']['name'];
            @$extension=strtolower(array_pop(explode(".",$aux)));
            @$newname= $ced.".".$extension;
            move_uploaded_file($_FILES['uploadBtn']['tmp_name'],"../img_profile/".$newname);
          }
          else{
            @$newname= "profile.jpg";
          }
          if ($_SESSION["ROL"]=="SUPER"){
            $conn=basedatos::obtenerInstancia()->obtenerConexion();
            $comando="INSERT INTO usuarios VALUES(?,?,?,?,?,?,?,?,?)";
            $sentencia=basedatos::obtenerInstancia()->obtenerConexion()->prepare($comando);
            $sentencia->execute(array("",$ced,$nom,$fac,"ADMIN","ACTIVO",$newname,$pass,"SI"));
            return $conn->lastInsertId();
          }
          else {
            if ($_SESSION["ROL"]=="ADMIN"){
              $conn=basedatos::obtenerInstancia()->obtenerConexion();
              $comando="INSERT INTO usuarios VALUES(?,?,?,?,?,?,?,?,?)";
              $sentencia=basedatos::obtenerInstancia()->obtenerConexion()->prepare($comando);
              $sentencia->execute(array("",$ced,$nom,$fac,"USER","ACTIVO",$newname,$pass,"NO"));
              return $conn->lastInsertId();
            }
          }
        }
        else {
          return 0;
        }

      }catch(PDOException $e){
        echo $e;
      }
    }

    public static function crearCarpeta($name,$id_padre,$url){
      try{
        session_start();
        $conn=basedatos::obtenerInstancia()->obtenerConexion();
        $comando="INSERT INTO carpetas VALUES(?,?,?,?,?)";
        $sentencia=basedatos::obtenerInstancia()->obtenerConexion()->prepare($comando);
        $sentencia->execute(array("",$name, $_SESSION["FACULTAD"],$id_padre, $url));
        return $conn->lastInsertId();
      }catch(PDOException $e){
        echo $e;
      }
    }

    public static function buscarCarpetaId($id_padre){
      try{
        $conn=basedatos::obtenerInstancia()->obtenerConexion();
        $comando="SELECT ID_PADRE FROM carpetas WHERE ID='$id_padre'";
        $sentencia=basedatos::obtenerInstancia()->obtenerConexion()->prepare($comando);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_NUM);
        return $registro[0];
      }catch(PDOException $e){
        echo $e;
      }
    }

    public static function verificarNombreCarpetas($id_padre,$nombre){
      try{
        $conn=basedatos::obtenerInstancia()->obtenerConexion();
        $comando="SELECT ID FROM carpetas WHERE ID_PADRE='$id_padre' AND NOMBRE='$nombre'";
        $sentencia=basedatos::obtenerInstancia()->obtenerConexion()->prepare($comando);
        $sentencia->execute();
        if($sentencia->fetch(PDO::FETCH_NUM)){
          return 1;
        }
        else{
          return 0;
        }

      }catch(PDOException $e){
        echo $e;
      }
    }

    public static function verificarNombreArchivos($id_padre,$nombre){
      try{
        $conn=basedatos::obtenerInstancia()->obtenerConexion();
        $comando="SELECT ID FROM archivos WHERE ID_CARPETA='$id_padre' AND NOMBRE='$nombre'";
        $sentencia=basedatos::obtenerInstancia()->obtenerConexion()->prepare($comando);
        $sentencia->execute();
        if($sentencia->fetch(PDO::FETCH_NUM)){
          return 1;
        }
        else{
          return 0;
        }

      }catch(PDOException $e){
        echo $e;
      }
    }

    public static function archivosrecientes(){
      $conn=basedatos::obtenerInstancia()->obtenerConexion();
      $comando="SELECT * FROM archivos";
      $sentencia=basedatos::obtenerInstancia()->obtenerConexion()->prepare($comando);
      $sentencia->execute();
      $cont=0;
      while(($registro = $sentencia->fetch(PDO::FETCH_NUM)) && ($cont<10)){
        $cont++;
        $comando1="SELECT * FROM usuarios WHERE CEDULA = '$registro[8]'";
        $sentencia1=basedatos::obtenerInstancia()->obtenerConexion()->prepare($comando1);
        $sentencia1->execute();
        $registro1 = $sentencia1->fetch(PDO::FETCH_NUM);
        if($registro[11]== "PUBLICO" || $registro[8] == $_SESSION['CEDULA']){
          if($registro[9]==$_SESSION["FACULTAD"] || $_SESSION["ROL"]=="SUPER"){
            if($registro[2]=="TEXTO"){
              echo '
              <div class="recent-files">
                  <img src="img_profile/'.$registro1[6].'" height="32" width="32" class="img-rounded"> <strong>'.$registro1[2].'</strong> subio un archivo <a><strong>'.$registro[1].'</strong></a>

                </div>';
            }
            else{
              echo '
              <div class="recent-files">
                  <img src="img_profile/'.$registro1[6].'" height="32" width="32" class="img-rounded"> <strong>'.$registro1[2].'</strong> subio un archivo <a href="RAIZ/'.$registro[10].'/'.$registro[1].'"><strong>'.$registro[1].'</strong></a>
                  
                </div>';
            }
          }
        }
      }
    }

    public static function misarchivosrecientes($CADENA){
      if (!$CADENA){
        $comando="SELECT * FROM archivos WHERE AUTOR = '".$_SESSION['CEDULA']."'";
      }
      else{
        $comando="SELECT * FROM archivos WHERE AUTOR = '".$_SESSION['CEDULA']."' AND NOMBRE LIKE '%".$CADENA."%'";
      }
      $conn=basedatos::obtenerInstancia()->obtenerConexion();
      $sentencia=basedatos::obtenerInstancia()->obtenerConexion()->prepare($comando);
      $sentencia->execute();
      while($registro = $sentencia->fetch(PDO::FETCH_NUM)){
        if($registro[2]=="TEXTO"){
          if($registro[11]=="PUBLICO"){
            echo '
            <a class="list-group-item reciente" ><i class="fa fa-book" aria-hidden="true"></i> '.$registro[1].'</a>';
          }
          else {
            echo '<a class="list-group-item reciente" ><i class="fa fa-lock" aria-hidden="true"></i> '.$registro[1].'</a>';
          }
        }
        else{
          if($registro[11]=="PUBLICO"){
            echo '
            <a href="RAIZ/'.$registro[10].'/'.$registro[1].'" class="list-group-item reciente" ><i class="fa fa-book" aria-hidden="true"></i> '.$registro[1].'</a>';
          }
          else {
            echo '
            <a href="RAIZ/'.$registro[10].'/'.$registro[1].'" class="list-group-item reciente" ><i class="fa fa-lock" aria-hidden="true"></i> '.$registro[1].'</a>';
          }
        }
      }
    }

    public static function buscarusuarios(){
      $band=0;
      $conn=basedatos::obtenerInstancia()->obtenerConexion();
      $comando="SELECT * FROM usuarios";
      $sentencia=basedatos::obtenerInstancia()->obtenerConexion()->prepare($comando);
      $sentencia->execute();
      while($registro = $sentencia->fetch(PDO::FETCH_NUM)){
        if($registro[4]!="SUPER" && $registro[1]!=$_SESSION["CEDULA"]){
          if($_SESSION["ROL"]=="SUPER"){
            $band=1;
            echo '
            <tr>
              <td align="center">
                 <button class="btn btn-default editUser" data-toggle="modal" data-target="#modal-editUser" title="Editar"><em class="fa fa-pencil"></em></button>
              </td>
              <td>'.$registro[1].'</td>
              <td>'.$registro[2].'</td>
              <td>'.$registro[3].'</td>
              <td>'.$registro[4].'</td>
              <td hidden>'.$registro[6].'</td>
              <td hidden>'.$registro[7].'</td>
            </tr>';
          }
          else {
            if($registro[3]==$_SESSION["FACULTAD"] && $registro[4]!="ADMIN"){
              $band=1;
              echo '
              <tr>
                <td align="center">
                   <a class="btn btn-default editUser" data-toggle="modal" data-target="#modal-editUser" title="Editar"><em class="fa fa-pencil"></em></a>
                </td>
                <td>'.$registro[1].'</td>
                <td>'.$registro[2].'</td>
                <td>'.$registro[3].'</td>
                <td>'.$registro[4].'</td>
                <td hidden>'.$registro[6].'</td>
                <td hidden>'.$registro[7].'</td>
              </tr>';
            }
          }
        }
      }
      if($band==0){
        echo'<td colspan="5" style="vertical-align:middle;" align="center">NO EXISTEN USUARIOS</td>';
      }
    }

    public static function buscarTiposArchivos(){
      $band=0;
      $conn=basedatos::obtenerInstancia()->obtenerConexion();
      $comando="SELECT * FROM tipos_archivos";
      $sentencia=basedatos::obtenerInstancia()->obtenerConexion()->prepare($comando);
      $sentencia->execute();
      $cont=0;
      while($registro = $sentencia->fetch(PDO::FETCH_NUM)){
        $band=1;
        $cont++;
        echo '
        <tr>
          <td align="center">
            <button class="btn btn-default edittype" title="Editar" data-toggle="modal" data-target="#modal-edittype" type="button" value="'.$cont.'"><em class="fa fa-pencil"></em></button>
            <a style="margin: auto;" class="btn btn-danger deleteType" data-toggle="modal" data-target="#modal-deletetype"  title="Eliminar" ><em class="fa fa-trash"></em></a>
          </td>
          <td hidden class="idtype">'.$registro[0].'</td>
          <td class="nametype">'.$registro[1].'</td>
          <td class="sizetype">'.$registro[2].'</td>
        </tr>';
      }
      if($band==0){
        echo '
        <tr>
        <td colspan="3" style="vertical-align:middle;" align="center">NO HAY REGISTROS</td>
        </tr>';
      }
    }

    public static function buscarPrivilegios(){
      $band=0;
      $conn=basedatos::obtenerInstancia()->obtenerConexion();
      if($_SESSION["ROL"]=="SUPER"){
        $comando="SELECT * FROM usuarios";
      }
      else{
        $comando="SELECT * FROM usuarios WHERE FACULTAD='".$_SESSION['FACULTAD']."'";
      }
      $sentencia=basedatos::obtenerInstancia()->obtenerConexion()->prepare($comando);
      $sentencia->execute();
      $cont=0;
      while($registro = $sentencia->fetch(PDO::FETCH_NUM)){
        if($registro[4]!="SUPER" && $registro[1]!=$_SESSION["CEDULA"]){
          $cont++;
          $band=1;
          $ced = $registro[1];
          echo '
            <tr>

              <td style="vertical-align:middle;" align="center">'.$registro[1].'</td>
              <td style="vertical-align:middle;" align="center">'.$registro[2].'</td>
              <td style="vertical-align:middle;" align="center">'.$registro[3].'</td>
              <td style="vertical-align:middle;" align="center">'.$registro[4].'</td>
              <td>
                <div class="alinear">
                  <div class="material-switch pull-right" name="actividad">';
                  if ($registro[5]=="ACTIVO"){
                    echo '<input id="actividad" name="actividad" type="checkbox" checked onclick="document.getElementById(\'cambio\').submit()"/>';
                  }
                  else {
                    echo '<input id="actividad" name="actividad" type="checkbox" onclick="document.getElementById(\'cambio\').submit()"/>';
                  }
                  echo '
                  <label for="actividad" class="label-success"></label>
                  </div>
                </div>
              </td>';
              if($_SESSION['ROL']=='SUPER'){
                echo '
                <td>
                  <div class="alinear">
                    <div class="material-switch pull-right" name="admin">';
                    if ($registro[4]=="ADMIN"){
                      echo '<input id="admin" name="admin" type="checkbox" checked onclick="document.getElementById(\'cambio\').submit()"/>';
                    }
                    else {
                      echo '<input id="admin" type="checkbox" name="admin" onclick="document.getElementById(\'cambio\').submit()"/>';
                    }
                    echo '
                    <label for="admin" class="label-success"></label>
                    </div>
                  </div>
                </td>';
              }
              echo'
              <td>
                <div class="alinear">
                  <div class="material-switch pull-right" name="folder">';
                    if ($registro[8]=="SI"){
                      echo '<input id="folder" type="checkbox" checked name="folder" onclick="document.getElementById(\'cambio\').submit()"/>';
                    }
                    else {
                      echo '<input id="folder" type="checkbox" name="folder" onclick="document.getElementById(\'cambio\').submit()"/>';
                    }
                    echo'
                    <label for="folder" class="label-success"></label>
                  </div>
                </div>
              </td>

            </tr>';
        }
      }
      if($band==0){
        echo'<td colspan="7" style="vertical-align:middle;" align="center">NO EXISTEN USUARIOS</td>';
      }
    }

    public static function actualizarme($ced,$nom,$pass,$img){
      try{
        if (@$_FILES['uploadBtnV']['name']){
          $aux=$_FILES['uploadBtnV']['name'];
          @$extension=strtolower(array_pop(explode(".",$aux)));
          @$newname= $ced.".".$extension;
          move_uploaded_file($_FILES['uploadBtnV']['tmp_name'],"../img_profile/".$newname);
        }
        else{
          @$newname= $img;
        }
        $conn=basedatos::obtenerInstancia()->obtenerConexion();
        $comando="UPDATE usuarios SET NOMBRE='$nom', PASSWORD = '$pass', IMAGEN = '$newname' WHERE CEDULA = '$ced'";
        $sentencia=basedatos::obtenerInstancia()->obtenerConexion()->prepare($comando);
        $sentencia->execute();
        $_SESSION['NOMBRE'] = $nom;
        $_SESSION['IMAGEN'] = $newname;
        $_SESSION['PASSWORD'] = $pass;
        return 1;
      }catch(PDOException $e){
        echo $e;
        return 0;
      }
    }

    public static function actualizarUsuario($ced,$nom,$fac,$pass,$img){
      try{
        if (@$_FILES['uploadBtnAV']['name']){
          $aux=$_FILES['uploadBtnAV']['name'];
          @$extension=strtolower(array_pop(explode(".",$aux)));
          @$newname= $ced.".".$extension;
          move_uploaded_file($_FILES['uploadBtnAV']['tmp_name'],"../img_profile/".$newname);
        }
        else{
          @$newname= $img;
        }
        $conn=basedatos::obtenerInstancia()->obtenerConexion();
        $comando="UPDATE usuarios SET NOMBRE='$nom', FACULTAD='$fac', PASSWORD = '$pass', IMAGEN = '$newname' WHERE CEDULA = '$ced'";
        $sentencia=basedatos::obtenerInstancia()->obtenerConexion()->prepare($comando);
        $sentencia->execute();
        return 1;
      }catch(PDOException $e){
        echo $e;
        return 0;
      }
    }

    public static function nuevoTipo($ext,$size){
      try{
        $conn=basedatos::obtenerInstancia()->obtenerConexion();
        $comando="INSERT INTO tipos_archivos VALUES(?,?,?)";
        $sentencia=basedatos::obtenerInstancia()->obtenerConexion()->prepare($comando);
        $sentencia->execute(array("",$ext,$size));
        return $conn->lastInsertId();
      }catch(PDOException $e){
        echo $e;
      }
    }

    public static function verificarTipoArchivo($type){
      try{
        $conn=basedatos::obtenerInstancia()->obtenerConexion();
        $comando="SELECT tipo FROM tipos_archivos";
        $sentencia=basedatos::obtenerInstancia()->obtenerConexion()->prepare($comando);
        $sentencia->execute();
        while($registro=$sentencia->fetch(PDO::FETCH_NUM)){
          if($registro[0]==$type){
            return 1;
          }
        }
        return 0;
      }catch(PDOException $e){
        echo $e;
      }
    }

    public static function verificarSizeArchivo($size){
      try{
        $conn=basedatos::obtenerInstancia()->obtenerConexion();
        $comando="SELECT size FROM tipos_archivos";
        $sentencia=basedatos::obtenerInstancia()->obtenerConexion()->prepare($comando);
        $sentencia->execute();
        while($registro=$sentencia->fetch(PDO::FETCH_NUM)){
          if($registro[0]<$size){
            return 1;
          }
        }
        return 0;
      }catch(PDOException $e){
        echo $e;
      }
    }

    public static function actualizarTipo($id,$ext,$size){
      try{
        $conn=basedatos::obtenerInstancia()->obtenerConexion();
        $comando="UPDATE tipos_archivos SET TIPO='$ext', SIZE='$size' WHERE ID = '$id'";
        $sentencia=basedatos::obtenerInstancia()->obtenerConexion()->prepare($comando);
        $sentencia->execute();
        return 1;
      }catch(PDOException $e){
        echo $e;
        return 0;
      }
    }

    public static function EliminarTipo($id){
      try{
        $conn=basedatos::obtenerInstancia()->obtenerConexion();
        $comando="DELETE FROM tipos_archivos WHERE ID = '$id'";
        $sentencia=basedatos::obtenerInstancia()->obtenerConexion()->prepare($comando);
        $sentencia->execute();
        return 1;
      }catch(PDOException $e){
        echo $e;
        return 0;
      }
    }

    public static function actualizarAdminUser($ced){
      try{
        $conn=basedatos::obtenerInstancia()->obtenerConexion();
        $comando="SELECT ROL FROM USUARIOS WHERE CEDULA = '$ced'";
        $sentencia=basedatos::obtenerInstancia()->obtenerConexion()->prepare($comando);
        $sentencia->execute();
        $registro=$sentencia->fetch(PDO::FETCH_NUM);
        $valor = $registro[0];
        if ($valor == "ADMIN") {
          $comando="UPDATE USUARIOS SET ROL='USER' WHERE CEDULA = '$ced'";
        }
        else {
          $comando="UPDATE USUARIOS SET ROL='ADMIN' WHERE CEDULA = '$ced'";
        }
        $sentencia=basedatos::obtenerInstancia()->obtenerConexion()->prepare($comando);
        $sentencia->execute();
        return 1;
      }catch(PDOException $e){
        echo $e;
        return 0;
      }
    }

    public static function actualizarFolderUser($ced){
      try{
        $conn=basedatos::obtenerInstancia()->obtenerConexion();
        $comando="SELECT ADM_FOLDER FROM USUARIOS WHERE CEDULA = '$ced'";
        $sentencia=basedatos::obtenerInstancia()->obtenerConexion()->prepare($comando);
        $sentencia->execute();
        $registro=$sentencia->fetch(PDO::FETCH_NUM);
        $valor = $registro[0];
        if ($valor == "SI") {
          $comando="UPDATE USUARIOS SET ADM_FOLDER='NO' WHERE CEDULA = '$ced'";
        }
        else {
          $comando="UPDATE USUARIOS SET ADM_FOLDER='SI' WHERE CEDULA = '$ced'";
        }
        $sentencia=basedatos::obtenerInstancia()->obtenerConexion()->prepare($comando);
        $sentencia->execute();
        return 1;
      }catch(PDOException $e){
        echo $e;
        return 0;
      }
    }

    public static function actualizarActividadUser($ced){
      try{
        $conn=basedatos::obtenerInstancia()->obtenerConexion();
        $comando="SELECT ESTADO FROM USUARIOS WHERE CEDULA = '$ced'";
        $sentencia=basedatos::obtenerInstancia()->obtenerConexion()->prepare($comando);
        $sentencia->execute();
        $registro=$sentencia->fetch(PDO::FETCH_NUM);
        $valor = $registro[0];
        if ($valor == "ACTIVO") {
          $comando="UPDATE USUARIOS SET ESTADO='INACTIVO' WHERE CEDULA = '$ced'";
        }
        else {
          $comando="UPDATE USUARIOS SET ESTADO='ACTIVO' WHERE CEDULA = '$ced'";
        }
        $sentencia=basedatos::obtenerInstancia()->obtenerConexion()->prepare($comando);
        $sentencia->execute();
        return 1;
      }catch(PDOException $e){
        echo $e;
        return 0;
      }
    }

    public static function EliminarFile($id){
      try{
        session_start();
        $conn=basedatos::obtenerInstancia()->obtenerConexion();
        $comando="SELECT AUTOR FROM archivos WHERE ID = '$id'";
        $sentencia=basedatos::obtenerInstancia()->obtenerConexion()->prepare($comando);
        $sentencia->execute();
        $registro=$sentencia->fetch(PDO::FETCH_NUM);
        if($_SESSION["CEDULA"]==$registro[0]){
          $conn=basedatos::obtenerInstancia()->obtenerConexion();
          $comando="DELETE FROM archivos WHERE ID = '$id'";
          $sentencia=basedatos::obtenerInstancia()->obtenerConexion()->prepare($comando);
          $sentencia->execute();
          return 1;
        }
        else{
          return 0;
        }

      }catch(PDOException $e){
        echo $e;
        return 0;
      }
    }

    public static function DescargarFile($id){
      try{
        $conn=basedatos::obtenerInstancia()->obtenerConexion();
        $comando="SELECT URL FROM archivos WHERE ID = '$id'";
        $sentencia=basedatos::obtenerInstancia()->obtenerConexion()->prepare($comando);
        $sentencia->execute();
        $registro=$sentencia->fetch(PDO::FETCH_NUM);
        return $registro[0];

      }catch(PDOException $e){
        echo $e;
        return 0;
      }
    }

    public static function NombreFile($id){
      try{
        $conn=basedatos::obtenerInstancia()->obtenerConexion();
        $comando="SELECT NOMBRE FROM archivos WHERE ID = '$id'";
        $sentencia=basedatos::obtenerInstancia()->obtenerConexion()->prepare($comando);
        $sentencia->execute();
        $registro=$sentencia->fetch(PDO::FETCH_NUM);
        return $registro[0];

      }catch(PDOException $e){
        echo $e;
        return 0;
      }
    }



  }
 ?>
