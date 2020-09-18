<!DOCTYPE html>
<html>
<head>
<title></title>
<script src="assets/js/jquery-1.5.2.js"></script>
<script>
$(document).ready(function(e){

});
</script>

<style>
#lb1{
    width:8%;
}
.d
{
    font-weight: bold;
    font-size: 13px;
}
.e
{
    font-size: 13px;
}
.meses_nao_pagos{
   font-size: 13px; 
}
</style>
</head>
<body>
<?php
require_once("conn2.php");
/**
 * @author lolkittens
 * @copyright 2016
 */

$processo=$_GET['pro'];
$ano=$_GET['ano'];
$co3="select *from view_estudante where id_aluno=:processo";
try
{
   $result=$con2->prepare($co3);
   $result->bindParam(":processo",$processo,PDO::PARAM_STR);
   $result->execute();
   $contar=$result->rowCount();
   if($contar==0)
   {
    echo"<script>
    window.location.href='count_pupilo2.php?n=e';
    </script>";
    exit();
   }
   else
   {
   $ver=$result->fetch(PDO::FETCH_OBJ); 
    $fV6="select *from view_historico where id_aluno=:processo and anolectivo=:ano";
$eV6=$con2->prepare($fV6);
$eV6->bindParam(":processo",$processo,PDO::PARAM_STR);
$eV6->bindParam(":ano",$ano,PDO::PARAM_STR);
$eV6->execute();
$contV6=$eV6->rowCount();
if($contV6==0):

else:
$verV6=$eV6->fetch(PDO::FETCH_OBJ);
endif;
   }
    
}
catch(PDOException $e)
{
    echo $e;
}

?>

<div class="perfil">
<table border=0>
<tr>
<td rowspan="6" width='104px'><?php echo "<img src='../pautas/foto_alunos/".$ver->foto."' width=100px height=100px>";?></td></tr>
<tr>
<td class="d">Nome: </td><td class="e"><?php echo $ver->nome;?></td>
</tr>
<tr>
<td class="d">Curso:</td><td class="e"><?php echo $verV6->curso;?></td>
</tr>
<tr>
<td class="d">Classe:</td><td class="e"><?php echo $verV6->classe;?></td>
</tr>
<tr>
<td class="d">Turma:</td><td class="e"><?php echo $verV6->turma;?></td>
</tr>
<tr>
<td class="d">Turno:</td><td class="e"><?php echo $verV6->turno;?></td>
</tr>
</table>
</div>
<br />
<?php 

$de="select *from tbl_inscricao where id_aluno=:pro and ano=:ano";
$df=$con2->prepare($de);
$df->bindParam(":pro",$processo,PDO::PARAM_STR); 
$df->bindParam(":ano",$ano,PDO::PARAM_STR);
$df->execute();
$comta=$df->rowCount();
if($comta>0)
{
 echo"<strong>Pagamento já Feito</strong>
 
 <br/>
 <a href='desfaz_pagamento2.php?id=$processo&&ano=$ano' class='btn btn-warning'>Eliminar Pagamento</a>
 ";  
 
}
else
{
?>
Ainda não Pago
   
  <?php 
}
?>

<br />



</body>
</html>

