<?php
include_once 'conn2.php';
include_once 'classes/Comparticipacao.php';
include_once 'classes/Historico.php';

$objHistorico = new Historico();
$objComp = new Comparticipacao();
$id_aluno = addslashes(htmlspecialchars($_GET['pro']));
$ano = addslashes(htmlspecialchars($_GET['ano']));

$objHistorico->setCon($con2);
$objComp->setCon($con2);
$objComp->setId_aluno($id_aluno);
$objComp->setAno_lectivo($ano);

$res = $objComp->buscaIDpai();

?>

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
.vv{
    font-family:arial;
    font-size:15px;
    font-weight:bold;
    padding-left: 5px;
    background-color: #8574CC;
    color:#fff;
}
.vv2{
    font-family:arial;
    font-size:13px;
    font-weight:bold;
    padding-left: 5px;
    background-color: #4380B8;
    color:#fff;
    border-top:1px dashed #fff;
}
.vv3{
    font-family:arial;
    font-size:13px;
    font-weight:bold;
    padding-left: 5px;
    background-color: #202020;
    color:#fff;
    border-top:1px solid #fff;
}

</style>
</head>
<body>

<div class="perfil">
<b>Nome do Encarregado: </b><?php echo $objComp->getNome_pai();?><br/><br/>
<table border=1 width="100%">
    <tr class="vv">
        <td colspan="7">Beneficiados</td>
    </tr>
<tr class="vv2">
    <td>Processo</td>
    <td>Nome Estudante</td>
    <td>Curso</td>
    <td>Classe</td>
    <td>Turma</td>
    <td>Turno</td>
    <td>Ano Lectivo</td>
</tr>
<?php 
$res2 = $objComp->buscaIDAlunos();
while($viewIDsAluno1 = $res2->fetch(PDO::FETCH_OBJ)):
    
$objHistorico->setId_aluno($viewIDsAluno1->id_aluno);
$objHistorico->setAno_lectivo($ano);
$resHisto = $objHistorico->BuscaHisto();
if($resHisto!="no"):
  $viewHisto = $resHisto->fetch(PDO::FETCH_OBJ);  
endif;

?>
<tr class="vv3">
    <td><?php if($resHisto!="no"): echo $viewHisto->id_aluno; endif;?></td>
    <td><?php if($resHisto!="no"): echo $viewHisto->nome; endif;?></td>
    <td><?php if($resHisto!="no"): echo $viewHisto->curso; endif;?></td>
    <td><?php if($resHisto!="no"): echo $viewHisto->classe; endif;?></td>
    <td><?php if($resHisto!="no"): echo $viewHisto->turma; endif;?></td>
    <td><?php if($resHisto!="no"): echo $viewHisto->turno; endif;?></td>
    <td><?php if($resHisto!="no"): echo $viewHisto->anolectivo; endif;?></td>
</tr>
<?php
endwhile;
?>
</table>
</div>
<br />

<form name="form1" action="fatura_compart222.php" method="POST">
    <b>Trimestre por pagar:</b><br/>
    <?php 
   $res11 = $objComp->verPagamento();
   $conta_Pago = $res11->rowCount();
   $res12 = $objComp->verquantPag();
   $conta_quantPag = $res12->rowCount();
   $g34=$conta_Pago+1;
   $cont_Pargar = $conta_quantPag - $conta_Pago;
   
 for($a60=$g34; $a60<=$conta_quantPag; $a60 ++){
        
   echo '<input type="checkbox" name="epoca[]" value="'.$a60.'" id="tipo"/> '.$a60.'º Trimestre<br/>';  
 }
?>

 <br/>
 <input type="hidden" name="id_pai" value="<?php echo $objComp->getId_pai();?>"/>
 <input type="hidden" name="anoLetivo" value="<?php echo $ano;?>"/>
 <b>Valor:</b><select name="valor" class="form-control">
     <option value="500">500,00</option>
 </select>
    <b>Cliente:</b><input type="text" placeholder="Escreve o nome do cliente" name="cliente" class="form-control" required=""/>
    <input type="submit" name="sv" value="Concluir" class="btn btn-success"/>
</form>
</div>

<br />



</body>
</html>
