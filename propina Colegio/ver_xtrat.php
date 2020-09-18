<?php
ob_start();
session_start();
include("conn2.php");

$processo=$_POST['txtpro'];
$ano=$_POST['txtano'];
$_SESSION['processo99']=$processo;
$_SESSION['ano99']=$ano;



       echo"<script>
    window.location.href='xt_notur.php';
    </script>   "; 
  

?>