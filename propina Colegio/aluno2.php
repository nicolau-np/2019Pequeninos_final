<!DOCTYPE html>
<html>
<head>
<title></title>
<script src="assets/js/jquery-1.5.2.js"></script>
<script>
$(document).ready(function(e){
 
 
 $("#ves").click(function(){
    var m=$("#ves").val();
    var id=$("#id").val();
	var anoLE=$("#anoLE").val();
       

$.ajax({
		type:"GET",
		url:"aluno3.php",
        data:"mes="+m+" &id="+id+"&anoL="+anoLE,
		dataType:"html",	
		success: function(dados){
	$(".det").text('')
	.append(dados);},});
    
});
});
 

</script>

<style>
#cb_valor{
    width:10%;
}
#data{
    width:15%;
}
#usuario{
    width:20%;
}
#txt_cliente{
    width:20%;
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
.det{
   font-size: 13px; 
}
#ves{
   font-size: 13px;  
}
</style>
</head>
<body>
<?php
session_start();
require_once("conn2.php");
/**
 * @author lolkittens
 * @copyright 2016
 */
$anol=$_GET['ano'];
$processo=$_GET['pro'];
$_SESSION['processo34']=$_GET['pro'];
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
$eV6->bindParam(":ano",$anol,PDO::PARAM_STR);
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
<table>
<tr>
<td rowspan="7" width='104px'><?php echo "<img src='../pautas/foto_alunos/".$ver->foto."' width=100px height=100px>";?></td></tr>
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
<div class="a"><b>Pago</b></div>
<form name="fom4" method="POST" class="form-inline">
<input type="hidden" id="id" value="<?php echo $processo;?>"/>
<select multiple="multiple" size="12" id="ves" class="form-control">
<?php 

$pago="sim";
$co4="select *from tbl_pagamento where id_aluno=:id and pago=:pago and ano_lectivo=:an";

   $result=$con2->prepare($co4);
   $result->bindParam(":id",$processo,PDO::PARAM_STR);
   $result->bindParam(":pago",$pago,PDO::PARAM_STR);
   $result->bindParam(":an",$anol,PDO::PARAM_STR);
   $result->execute();
$conv2=$result->rowCount();
if($conv2==0)
{
  echo("nenhum encontardo");
}
else
{
    while($rt=$result->fetch(PDO::FETCH_OBJ)){
?>

<div class="meses_pagos">

	<option value="<?php echo $rt->mes;?>"><?php echo $rt->mes;?></option><?php }}?>
</select>
</div>
<br />
<br />
<input type="hidden" name="anoLE" value="<?php echo $anol;?>" id="anoLE"/>
<div class="det">
Valor: <input type="text" name="cb_valor" id="cb_valor" class="form-control" placeholder="Valor"/>
Cliente: <input type="text" class="form-control" id="txt_cliente" name="txt_cliente" placeholder="Nome do cliente"/>
Data Registo: <input type="text" name='data' id="data" class="form-control" placeholder="Data"/>
Usuario: <input type="text" name='usuario' id="usuario" class="form-control" placeholder="Usuario"/><br/><br/>
Talão nº <input type="text" name="boletim" id="boletim" class="form-control" placeholder="Nº de Boletim" required/>
Forma de Pagamento: <input type="text" name="forma_pagamento" id="forma_pagamento" class="form-control" placeholder="Forma de Pagamento" required/>
Banco: <input type="text" name="banco" id="banco" class="form-control" placeholder="Banco" required/><br/><br/>
Data do Talão: <input type="text" name="data_borderom" id="banco" class="form-control" placeholder="Data do Talão" required/>
</form>
</div>





</body>
</html>
