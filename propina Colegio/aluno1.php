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
$ano_Pa=$_GET['ano'];
$turno2="Manhã";
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
$r1="select *from tbl_curso where curso=:curso";
$r=$con2->prepare($r1);
$r->bindParam(":curso",$verV6->curso,PDO::PARAM_STR);
$r->execute();
$view_valores=$r->fetch(PDO::FETCH_OBJ);

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
<td rowspan="7" width='104px'><img src="../pautas/foto_alunos/<?php echo $ver->foto;?>" width="100px" height="100px"></td></tr>
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

<div class="a"><b>Trimestres a Pagar</b></div>
<?php 
$pago="nao";
$co4="select *from tbl_pagamento where id_aluno=:id and pago=:pago and ano_lectivo=:ano";

   $result=$con2->prepare($co4);
   $result->bindParam(":id",$processo,PDO::PARAM_STR);
   $result->bindParam(":pago",$pago,PDO::PARAM_STR);
   $result->bindParam(":ano",$ano_Pa,PDO::PARAM_STR);
   $result->execute();
   $conv=$result->rowCount();
if($conv==0)
{
  echo("nenhum encontardo"); 
}
else
{
    $est="on";
 while($rt=$result->fetch(PDO::FETCH_OBJ)){
     $se1="select *from tbl_multas where id_aluno=:id and ano_lectivo=:ano and mes_multa=:mes and estado=:estado";
     $exe=$con2->prepare($se1);
     $exe->bindParam(":id",$processo,  PDO::PARAM_STR);
     $exe->bindParam(":ano",$ano_Pa,  PDO::PARAM_STR);
     $exe->bindParam(":mes", $rt->mes, PDO::PARAM_STR);
     $exe->bindParam(":estado", $est, PDO::PARAM_STR);
     $exe->execute();
     $cont22=$exe->rowCount();
  
?>

<div class="meses_nao_pagos">
<form name="fom4" method="POST" action="faz.php" class="form-inline">
<input type="checkbox" name="mes[]" value="<?php echo $rt->mes;?>" id="mes"/> <?php echo $rt->mes;?>  <?php if($cont22>0): echo' <span style="color:red">Multa=>'.$view_valores->valor_multa.'</span>';endif;?><?php }}?>
<br />
<br />
Valor: <select size="1" name="cb_valor" id="cb_valor" class="form-control">
    <option value="<?php echo $view_valores->valor_pagamento;?>"><?php echo $view_valores->valor_pagamento;?>  AKz</option>
        <option value="2500">2500  AKz</option>
        <option value="3000">3000  AKz</option>
</select>
<input type="hidden" name="valor_multa" value="<?php echo $view_valores->valor_multa;?>"/>
Talão nº <input type="number" name="boletim" id="boletim" class="form-control" placeholder="00000">
Forma de Pagamento: <select class="form-control" name="formapagamento" id="formapagamento">
   <option>Em dinheiro</option>
  <option>Depósito bancário</option>
  <option>Tranferencia</option>
  <option>TPA</option>
  <option>Multi-Banco</option> 
</select><br><br>
Banco: <select class="form-control" name="banco" id="banco">
  <option>BNA</option>
  <option>BNI</option>
  <option>BFA</option>
  <option>BPC</option>
  <option>BIC</option>
  <option>BANC</option>
  <option>BAI</option>
  <option>Standard Bank</option> 
  <option>Millenium Angola</option>
  <option>Caixa Angola</option>
  <option>Banco Sol</option>
</select> 
Data do Talão: <input type="date" name="datapagamento" id="datapagamento" class="form-control">
Cliente: <input type="text" class="form-control" id="txt_cliente" name="txt_cliente" placeholder="Nome do cliente" required=""/>
<input type="hidden" id="txt_id" name="processo" value="<?php echo $processo;?>"/>
<input type="hidden" id="txt_id" name="txt_id" value="<?php echo $processo;?>"/>
<input type="hidden" id="txt_ano" name="txt_ano" value="<?php echo $_GET['ano'];?>"/>
<input type="submit" value="Pagar" class="btn btn-success" id="bt_pagar" name="bt_pagar"/>

</form>

</div>

<br />



</body>
</html>


