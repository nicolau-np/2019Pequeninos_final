<?php
ob_start();
session_start();
if (!isset($_SESSION['nomeMRX'])or(!isset($_SESSION['tituloMRX'])))
{
      echo"<script language='javascript' type='text/javascript'>
    window.location.href='index.php?e=1';
    </script>";
    
  
}

?>