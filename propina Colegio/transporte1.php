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

$_SESSION['nomeS'];

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


<form name="form1" action="fatura_transporte.php" method="POST">
    <b>Meses a pagar:</b><br/>
    <?php 
    $r="select * from tb_pagamento_transporte where id_aluno=:id and ano_lectivo=:ano";
    $r34=$con2->prepare($r);
    $r34->bindParam(":id",$processo,PDO::PARAM_STR);
    $r34->bindParam(":ano",$ano_Pa,PDO::PARAM_STR);
    $r34->execute();
    $cont34=$r34->rowCount();
   
         $g34=$cont34+1;
      
   
       $precario=6000;
  $servico="Transporte";
       
    
   $r11="select *from tbl_meses";
    $r35=$con2->prepare($r11);
    $r35->execute();
    $cont35=$r35->rowCount();
    $tra="Transporte";
    
    $numero_meses_falta=$cont35 - $cont34;
    for($a60=$g34; $a60<=$cont35; $a60 ++){

      $r12="select *from tbl_meses where numero_mes=:nu";
    $r36=$con2->prepare($r12);
    $r36->bindParam(":nu",$a60,PDO::PARAM_STR);
    $r36->execute();
    $v36=$r36->fetch(PDO::FETCH_OBJ);
    
    
   echo '<input type="checkbox" name="meses[]" value="'.$v36->numero_mes.'" id="tipo"/> '.utf8_encode($v36->mes).'
          <br/>';      
    

  }

    echo '<div> <label>Local </label></div>';
      $trans0=$con2->prepare("SELECT * FROM tbl_servicos WHERE categoria=:TRANS ORDER BY categoria");
      $trans0->bindParam(":TRANS",$tra,PDO::PARAM_STR);
      $trans0->execute();
      $val0=$trans0->fetchAll(PDO::FETCH_ASSOC);
      foreach ($val0 as $value) {
       
      echo '<input type="radio" name="local" value="'.$value['idServico'].'" id="local"/> '.$value['local'].'
         =><span style="color:red; font-weight: bold;"> '.number_format($value['preco'],2,',','.').' KZs</span><br/>';    
      }   
        
      
    ?>
     <input type="hidden" name="id" id="id" value="<?php echo($processo);    ?>"> 
    <b>Cliente:</b><input type="text" placeholder="Escreve o nome do cliente" name="cliente" class="form-control" required=""/>
    <input type="submit" name="sv" value="Concluir" class="btn btn-success"/>
</form>


</div>

<br />



</body>
</html>