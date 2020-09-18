<?php
ob_start();
session_start();
if(!isset($_SESSION['nomeS']) && (!isset($_SESSION['senhaS'])))
{
    header("location:index.php?acao=negado");exit;
}
include 'conn2.php';

$numero_fatura=0;
$mes_pag2=0;
$ano2=0;
$hora=0;
$cliente=0;
$valor=0;
$total=0;
$data=0;
$usuario=0;
$id=$_GET['id_pagamento'];
$mes_se=$_GET['mes'];
$ano=$_GET['ano'];
$data2="";
$hora2="";
$valor_multa=0;
$processo=$_GET['id_aluno'];


 $pago="nao";
    $command="update tbl_pagamento set pago=:pago,cliente=:cliente,data_pagamento=:data,usuario=:usuario,valor=:valor,valor_total=:total, nfatura=:fatura, hora=:hora where id_pagamento=:id";
try
{
 $result=$con2->prepare($command);
 $result->bindParam(":pago",$pago,PDO::PARAM_STR);
 $result->bindParam(":cliente",$cliente,PDO::PARAM_STR);
 $result->bindParam(":data",$data,PDO::PARAM_STR);
 $result->bindParam(":usuario",$usuario,PDO::PARAM_STR);
 $result->bindParam(":valor",$valor,PDO::PARAM_STR);
 $result->bindParam(":total",$total,PDO::PARAM_STR);
 $result->bindParam(":fatura",$numero_fatura,PDO::PARAM_STR);
 $result->bindParam(":hora",$hora,PDO::PARAM_STR);
 $result->bindParam(":id",$id,PDO::PARAM_STR);

 $result->execute();
 
 $estado="on";
 
 $up2="update tbl_multas set estado=:estado,valor_pago=:valor, data_pagamento=:data, hora=:hora where id_aluno=:id and ano_lectivo=:ano and mes_multa=:mes";
$run=$con2->prepare($up2);
$run->bindParam(":estado",$estado,PDO::PARAM_STR);
$run->bindParam(":valor",$valor_multa,PDO::PARAM_STR);
$run->bindParam(":data",$data2,PDO::PARAM_STR);
$run->bindParam(":hora",$hora2,PDO::PARAM_STR);
$run->bindParam(":id",$processo,  PDO::PARAM_STR);
$run->bindParam(":ano",$ano,  PDO::PARAM_STR);
$run->bindParam(":mes",$mes_se,  PDO::PARAM_STR);
$run->execute();
 
 
 
 echo '<script>
    alert("Pagamento Eliminado com sucesso!");
    window.location.href="count_pupilo2.php";
</script>';
}
catch(PDOException $e)
{
    echo $e;
}



?>