<?php
include("config/conn.php");
$id=$_GET['id_horario'];

$re="delete from tbl_horario where id_horario=:id";
$b=$con->prepare($re);
$b->bindParam(":id",$id,PDO::PARAM_STR);
$b->execute();
if(!$b):
echo"erro";
else:
header("location:cria_horario.php");
endif;

?>