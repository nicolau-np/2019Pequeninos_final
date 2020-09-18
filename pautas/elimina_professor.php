<?php
include("validarlogin.php");
include("config/conn.php");

$id_pessoa=$_GET['id_pessoa'];
$id_professor=$_GET['id_user'];
$foto=$_GET['foto'];
$titulo=$_GET['titulo'];

$sele="select *from tbl_user where id_pessoa=:id";
$je=$con->prepare($sele);
$je->bindParam(":id",$id_pessoa,PDO::PARAM_STR);
$je->execute();
$vf=$je->fetch(PDO::FETCH_OBJ);



$se="delete from tbl_senhas where id_user=:id";
$x1=$con->prepare($se);
$x1->bindParam(":id",$vf->id_user,PDO::PARAM_STR);
$x1->execute();

$se2="delete from tbl_user where id_pessoa=:id";
$x2=$con->prepare($se2);
$x2->bindParam(":id",$id_pessoa,PDO::PARAM_STR);
$x2->execute();

$se4="delete from tbl_falta_prof where id_professor=:id";
$x4=$con->prepare($se4);
$x4->bindParam(":id",$id_professor,PDO::PARAM_STR);
$x4->execute();

$se3="delete from tbl_horario where id_professor=:id";
$x3=$con->prepare($se3);
$x3->bindParam(":id",$id_professor,PDO::PARAM_STR);
$x3->execute();

if($titulo=="Professor Director"):
$se6="delete from tbl_diretores where id_professor=:id";
$x6=$con->prepare($se6);
$x6->bindParam(":id",$id_professor,PDO::PARAM_STR);
$x6->execute();
endif;

$se4="delete from tbl_professor where id_professor=:id";
$x4=$con->prepare($se4);
$x4->bindParam(":id",$id_professor,PDO::PARAM_STR);
$x4->execute();

$se4="delete from tbl_aluno where id_pessoa=:id";
$x4=$con->prepare($se4);
$x4->bindParam(":id",$id_pessoa,PDO::PARAM_STR);
$x4->execute();

$se5="delete from tbl_pessoa where id_pessoa=:id";
$x5=$con->prepare($se5);
$x5->bindParam(":id",$id_pessoa,PDO::PARAM_STR);
$x5->execute();





if($x5):
if($foto!="none.jpg"):
unlink("fotos_professores/$foto");
endif;

header("location:messages.php");
else:
echo"erro ao eliminar";
endif;

?>