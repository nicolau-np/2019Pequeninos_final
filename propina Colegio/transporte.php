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
     $tra="Transporte";
    $r="select * from tb_pagamento_transporte where id_aluno=:id and ano_lectivo=:ano";
    $r34=$con2->prepare($r);
    $r34->bindParam(":id",$processo,PDO::PARAM_STR);
    $r34->bindParam(":ano",$ano_Pa,PDO::PARAM_STR);

    $mes=$con2->prepare("select *from tbl_meses order by numero_mes");  
          $mes->execute();
         
    $mesesNPA = array();
    $nuMesNP = array();
    if($mes->execute()){     
      if($mes->rowCount() >0){
          $i=0;
          foreach ($mes as $value) {

            $r34=$con2->prepare("select * from tb_pagamento_transporte where id_aluno=:id and ano_lectivo=:ano and numero_mes=:numemes");
            $r34->bindParam(":id",$processo,PDO::PARAM_STR);
            $r34->bindParam(":ano",$ano_Pa,PDO::PARAM_STR);
            $r34->bindParam(":numemes",$value['numero_mes'],PDO::PARAM_STR);  
            $r34->execute();
            $v = $r34->fetch(PDO::FETCH_OBJ);
            if($r34->rowCount() ==0){
             
              $mesesNPA[] = $value['mes'];
              $nuMesNP[] = $value['numero_mes'];
               echo '<input type="checkbox" name="meses[]" value="'.$value['numero_mes'].'" id="tipo"/> '.utf8_encode($value['mes']).'
          <br/>';
            }
             
          } 
          
      }    
    }  

  

    echo '<div> <label>Local </label></div>';
      $trans0=$con2->prepare("SELECT * FROM tbl_servicos INNER JOIN tbl_precos ON id_preco=idPreco WHERE categoria=:TRANS ORDER BY categoria");
      $trans0->bindParam(":TRANS",$tra,PDO::PARAM_STR);
      $trans0->execute();
      $val0=$trans0->fetchAll(PDO::FETCH_ASSOC);
      foreach ($val0 as $value) {
       
      echo '<input type="radio" name="local" value="'.$value['idServico'].'" id="local"/> '.$value['local'].'
         =><span style="color:red; font-weight: bold;"> '.number_format($value['preco'],2,',','.').' KZs</span><br/>
            <input type="hidden" name="preco" value="'.$value['preco'].'" id="preco"/>
         ';    
      }   
        
      
    ?>
     

    <table>
      <thead>
        <tr>
          <th>Cliente</th>
          <th>Talão Nº</th>
          <th>Data do Depósito</th>
          <th>Ano Lectivo</th>
        </tr>
      </thead>
      <tbody> 
        <tr>       
        <input type="hidden" name="id" id="id" value="<?php echo($processo); ?>" class="form-control">           
          <td><input type="text" name="cliente" id="cliente" placeholder="Nome do Cliente" required class="form-control"></td>
          <td><input type="number" name="numerotalao" id="numerotalao" placeholder="Talão de depósito nº " required class="form-control"></td>
          <td><input type="date" name="dataDeposito" id="dataDeposito" required class="form-control"></td>
          <td><input type="number" name="anoLectivo" id="anoLectivo" value="2018" required placeholder="Ano lectivo" class="form-control"></td>                    
        </tr>                    
        <tr>  
          <td><input type="submit" value="Concluir" name="sv" class="btn btn-success"></td>
        </tr>
      </tbody> 
    </table>

</form>


</div>

<br />



</body>
</html>