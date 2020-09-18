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

<form name="form1" action="fatura_transferencia.php" method="POST">

    <b>Modo:</b><select name="modo" class="form-control" required="">
        <option value="">Selecione...</option>
       <option value="Normal">Normal =><span style="color:red; font-weight: bold;"> 1000,00</span></option>
       <option value="Urgente">Urgente =><span style="color:red; font-weight: bold;"> 1500,00</span></option>
  </select> 
    <input type="hidden" name="id" value="<?php echo $processo;?>"/>
    <b>Cliente:</b><input type="text" placeholder="Escreve o nome do cliente" name="cliente" class="form-control" required=""/>
    <b>Trimestre</b><select name="epoca" class="form-control" required="">
        <option value="">Selecione...</option>
        <option value="1">1 Trimestre</option>
        <option value="2">2 Trimestre</option>
        <option value="3">3 Trimestre</option>
    </select>
    <input type="submit" name="sv" value="Concluir" class="btn btn-success"/>
</form>
</div>

<br />



</body>
</html>
