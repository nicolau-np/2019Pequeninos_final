<?php
include_once 'conn2.php';
include_once 'classes/Comparticipacao.php';
include_once 'classes/Historico.php';

$objHistorico = new Historico();
$objComp = new Comparticipacao();
$id_aluno = addslashes(htmlspecialchars($_GET['pro']));
$ano1 = addslashes(htmlspecialchars($_GET['ano']));

$objHistorico->setCon($con2);
$objComp->setCon($con2);
$objComp->setId_aluno($id_aluno);
$objComp->setAno_lectivo($ano1);

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
$objHistorico->setAno_lectivo($ano1);
$resHisto = $objHistorico->BuscaHisto();
$viewHisto = $resHisto->fetch(PDO::FETCH_OBJ);
?>
<tr class="vv3">
    <td><?php echo $viewIDsAluno1->id_aluno;?></td>
    <td><?php echo $viewHisto->nome;?></td>
    <td><?php echo $viewHisto->curso;?></td>
    <td><?php echo $viewHisto->classe;?></td>
    <td><?php echo $viewHisto->turma;?></td>
    <td><?php echo $viewHisto->turno;?></td>
    <td><?php echo $viewHisto->anolectivo;?></td>
</tr>
<?php
endwhile;
?>
</table>
</div>
<br />

<form name="form1" action="desfaz_pagamento11.php" method="POST">
    <b>Trimestre pagos:</b><br/>
<select multiple="multiple" size="5" id="id_pag" class="form-control" name="id_pag">
<?php 
$sel20 = "select *from view_comp_pais where id_pai=:id_pai and ano=:ano order by id_comp_pais desc";
$run20 = $con2->prepare($sel20);
$run20->bindParam(":id_pai", $objComp->getId_pai(), PDO::PARAM_STR);
$run20->bindParam(":ano", $ano1, PDO::PARAM_STR);
$run20->execute();
if($run20->rowCount()>0):
    while($view20=$run20->fetch(PDO::FETCH_OBJ)):
    echo"<option value='".$view20->id_comp_pais."'>".$view20->epoca."º Trimestre » ".$view20->data_pagamento."</option>";
    endwhile;
    else:
        echo"Nenhum Trimestre pago";
endif;
?>

</select>
 <br/>
 <br/>
<input type="submit" name="apagar" value="Eliminar Pagamento" class="btn btn-danger"/>
</form>
</div>

<br />



</body>
</html>
