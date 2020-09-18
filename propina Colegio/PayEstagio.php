<?php
  
  session_start();


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
</style>
</head>
<body>
<?php
require_once("conn2.php");
/**
 * @author lolkittens
 * @copyright 2016
 */

$nome=$_SESSION['nomeS'];
$titulo=$_SESSION['tituloS'];
$processo = $_SESSION['processo444'];
//$processo=$_GET['pro'];
$ano_Pa=$_GET['ano'];
$turno2="Manhã";
$idPessoa=0;
$idAluno=0;

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
  
  $_SESSION['idaluno'] = $ver->id_aluno;
  $_SESSION['idpessoa'] = $ver->id_pessoa;

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
<?php
    
    

    
  
?>

<form action="bridgePayExame.php"   method="POST">
    <div class="left" style="">
    <?php 
    $categoria="Estagio";
    
     echo('<b>Pagamento de Estágio<b><br/>');
    

    $r35=$con2->prepare("SELECT * FROM tbl_servicos INNER JOIN tbl_precos ON id_preco = idPreco WHERE categoria=:CATE");
    $r35->bindParam(":CATE",$categoria,PDO::PARAM_STR);
    if($r35->execute()){
      if($cont35=$r35->rowCount()){

    $v36=$r35->fetch(PDO::FETCH_OBJ);
  

    }   }
   
?>
</div>
<div class="rigth">
    
    <table>
                  <thead>
                     <tr>
                       <th>Cliente</th>
                       <th>Talão Nº</th>
                       <th>Data do Depósito</th>
                       <th>Ano Lectivo</th>
                       <th>Preço</th>
                     </tr>
                  </thead>
                  <tbody> 
                    <tr>                  
                      <td><input type="text" name="cliente" id="cliente" placeholder="Nome do Cliente" required class="form-control"></td>
                      <td><input type="number" name="numerotalao" id="numerotalao" placeholder="Talão de depósito nº " required class="form-control"></td>
                       <td><input type="date" name="dataDeposito" id="dataDeposito" required class="form-control"></td>
                       <td><input type="number" name="anoLectivo" id="anoLectivo" value="2018" required placeholder="Ano lectivo" class="form-control"></td>                    
                        <?php  //echo('<button> <a href="fatura_uniforme1.php?accao=save" target="blanck" >Save</a></button>'); ?>
                        <td><div id="preco"></div> <input type="number" name="preco" value="<?php echo($v36->preco)?>" class="form-control" required/></td>
                    </tr>                    
                    <tr>  
                      <td><input type="submit" value="Concluir" name="payEstagio" class="btn btn-success"></td>
                    </tr>
                  </tbody> 
                </table>
 </div>   
</form>

<br />



</body>
</html>
<?php



?>