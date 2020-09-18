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
$ano_Pa=$_GET['ano'];
$processo=$_GET['pro'];
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
    window.location.href='count_pupilo.php?n=e';
    </script>";
    exit();
   }
   else
   {
	   
	$ver=$result->fetch(PDO::FETCH_OBJ); 
	
	$fV6="select *from view_historico where id_aluno=:processo and anolectivo=:ano";
$eV6=$con2->prepare($fV6);
$eV6->bindParam(":processo",$processo,PDO::PARAM_STR);
$eV6->bindParam(":ano",$ano_Pa,PDO::PARAM_STR);
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
<td class="d">Curso:</td><td class="e"> <?php echo $verV6->curso;?></td>
</tr>
<tr>
<td class="d">Classe:</td><td class="e"> <?php echo $verV6->classe;?></td>
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
$df->bindParam(":ano",$ano_Pa,PDO::PARAM_STR);
$df->execute();
$comta=$df->rowCount();
if($comta>0)
{
 echo"<strong>Pagamento já Feito</strong>
 
 <br/>
 <a href='faz4.php?id=$processo&&anoL=$ano_Pa&&processo=$processo' class='btn btn-success'>Ver Fatura</a>
 ";  
 
}
else
{
?>
  <div class='meses_nao_pagos'>
<form name='fom4' method='POST' action='faz3.php' class='form-inline'>
<br />
<br />
Valor: <select size='1' name='cb_valor' id='cb_valor' class='form-control'>
	<option value='2000'>2000 AKz</option>
        <option value='2500'>2500 AKz</option>
        <option value='3000'>3000 AKz</option>
</select>

Cliente: <input type='text' class='form-control' id='txt_cliente' name='txt_cliente' placeholder='Nome do cliente'/>
<input type='hidden' id='processo' name='processo' value='<?php echo $processo;?>'/>
<input type='hidden' id='txt_id' name='txt_id' value='<?php echo $processo;?>'/>
<input type='hidden' id='txt_ano' name='txt_ano' value='<?php echo $ano_Pa;?>'/>
<input type='submit' value='Pagar' class='btn btn-success' id='bt_pagar' name='bt_pagar'/>

</form>

</div>
   
  <?php 
}
?>

<br />



</body>
</html>


