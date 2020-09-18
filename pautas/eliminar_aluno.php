<?php
include("validarlogin.php");
include("config/conn.php");

$id_pessoa=$_SESSION['id_pessoa9996'];
$id_aluno=$_SESSION['id_aluno9996'];
$foto=$_SESSION['id_foto9996'];

$sql5="delete from tbl_financeiros_filhos where id_aluno=:id_aluno";

    $result0=$con->prepare($sql5);
    $result0->bindParam(":id_aluno",$id_aluno,PDO::PARAM_STR);
    $result0->execute();

$sql5="delete from tbl_pagamento_declaracao where id_aluno=:id_aluno";

    $result0=$con->prepare($sql5);
    $result0->bindParam(":id_aluno",$id_aluno,PDO::PARAM_STR);
    $result0->execute();
    
    
$sql5="delete from tbl_pagamento_folha where id_aluno=:id_aluno";

    $result0=$con->prepare($sql5);
    $result0->bindParam(":id_aluno",$id_aluno,PDO::PARAM_STR);
    $result0->execute();
    
    $sql5="delete from tb_pagamento_provas where id_aluno=:id_aluno";

    $result0=$con->prepare($sql5);
    $result0->bindParam(":id_aluno",$id_aluno,PDO::PARAM_STR);
    $result0->execute();
    
     $sql5="delete from tb_pagamento_transporte where id_aluno=:id_aluno";

    $result0=$con->prepare($sql5);
    $result0->bindParam(":id_aluno",$id_aluno,PDO::PARAM_STR);
    $result0->execute();
    
    $sql5="delete from venderproduto where pessoa_id=:id_aluno";

    $result0=$con->prepare($sql5);
    $result0->bindParam(":id_aluno",$id_pessoa,PDO::PARAM_STR);
    $result0->execute();
    
     $sql5="delete from tbl_pagamento_estagio where id_aluno=:id_aluno";

    $result0=$con->prepare($sql5);
    $result0->bindParam(":id_aluno",$id_aluno,PDO::PARAM_STR);
    $result0->execute();
    
 
    
    $sql5="delete from tbl_desistidos where id_aluno=:id_aluno";

    $result0=$con->prepare($sql5);
    $result0->bindParam(":id_aluno",$id_aluno,PDO::PARAM_STR);
    $result0->execute();
    
    
    
    $sql5="delete from tbl_transferencia where id_aluno=:id_aluno";

    $result0=$con->prepare($sql5);
    $result0->bindParam(":id_aluno",$id_aluno,PDO::PARAM_STR);
    $result0->execute();
    
    
    $sql5="delete from tbl_pagamento_certificados where id_aluno=:id_aluno";

    $result0=$con->prepare($sql5);
    $result0->bindParam(":id_aluno",$id_aluno,PDO::PARAM_STR);
    $result0->execute();
    
    

$sql5="delete from tbl_multas where id_aluno=:id_aluno";

    $result0=$con->prepare($sql5);
    $result0->bindParam(":id_aluno",$id_aluno,PDO::PARAM_STR);
    $result0->execute();

$sql5="delete from tbl_pagamento where id_aluno=:id_aluno";

    $result0=$con->prepare($sql5);
    $result0->bindParam(":id_aluno",$id_aluno,PDO::PARAM_STR);
    $result0->execute();
    
    $sql5="delete from tbl_inscricao where id_aluno=:id_aluno";

    $result0=$con->prepare($sql5);
    $result0->bindParam(":id_aluno",$id_aluno,PDO::PARAM_STR);
    $result0->execute();

$se001="delete from tbl_avaliacao where id_aluno=:id";
$x001=$con->prepare($se001);
$x001->bindParam(":id",$id_aluno,PDO::PARAM_STR);
$x001->execute();

$se002="delete from tbl_provas where id_aluno=:id";
$x002=$con->prepare($se002);
$x002->bindParam(":id",$id_aluno,PDO::PARAM_STR);
$x002->execute();

$se003="delete from tbl_historico_aluno where id_pessoa=:id";
$x003=$con->prepare($se003);
$x003->bindParam(":id",$id_pessoa,PDO::PARAM_STR);
$x003->execute();

$se00="delete from tbl_faltas where id_aluno=:id";
$x00=$con->prepare($se00);
$x00->bindParam(":id",$id_aluno,PDO::PARAM_STR);
$x00->execute();


$se0="delete from tbl_cla_finais where id_aluno=:id";
$x0=$con->prepare($se0);
$x0->bindParam(":id",$id_aluno,PDO::PARAM_STR);
$x0->execute();

$se="delete from tbl_notas where id_aluno=:id";
$x1=$con->prepare($se);
$x1->bindParam(":id",$id_aluno,PDO::PARAM_STR);
$x1->execute();

$se2="delete from tbl_aluno where id_pessoa=:id";
$x2=$con->prepare($se2);
$x2->bindParam(":id",$id_pessoa,PDO::PARAM_STR);
$x2->execute();

$se3="delete from tbl_pessoa where id_pessoa=:id";
$x3=$con->prepare($se3);
$x3->bindParam(":id",$id_pessoa,PDO::PARAM_STR);
$x3->execute();
if($x3):
if($foto!="none.jpg"):
unlink("foto_alunos/$foto");
endif;

header("location:wizards.php");
else:
echo"erro ao eliminar";
endif;

?>
