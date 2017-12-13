<?php
  session_start();
  session_unset();

  echo "<script language=javascript>
  alert('Sesion cerrada con exito')
  window.location='index.php';
  </script>";
 ?>
