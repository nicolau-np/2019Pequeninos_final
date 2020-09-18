<?php
include("validarlogin.php");
include("config/conn.php");

$id_pessoa=$_GET['id_pessoa'];
$id_user=$_GET['id_user'];
$foto=$_GET['foto'];


$se="delete from tbl_senhas where id_user=:id";
$x1=$con->prepare($se);
$x1->bindParam(":id",$id_user,PDO::PARAM_STR);
$x1->execute();

$se2="delete from tbl_user where id_pessoa=:id";
$x2=$con->prepare($se2);
$x2->bindParam(":id",$id_pessoa,PDO::PARAM_STR);
$x2->execute();

$se3="delete from tbl_pessoa where id_pessoa=:id";
$x3=$con->prepare($se3);
$x3->bindParam(":id",$id_pessoa,PDO::PARAM_STR);
$x3->execute();
if($x3):
if($foto!="none.jpg"):
unlink("fotos_usuarios/$foto");
endif;

header("location:table-dynamic.php");
else:
echo"erro ao eliminar";
endif;
?>