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
    <div class="left" style="float: left;">
    <?php 
    
    echo('<label>Tipo de Prova</label>
          <select name="categoria" id="categoria" class="form-control">
            <option>Prova do Professor</option>
            <option>Prova Final</option>
            <option>Exame de Estágio</option>
            <option>Exame de Recurso</option>
          </select>  
          <br/><br>
      ');
    $disc = $con2-> prepare("SELECT DISTINCT id_di2 FROM tbl_notas WHERE id_aluno=:IDALU");
    $disc-> bindParam(":IDALU",$processo,PDO::PARAM_STR);
    $disc-> execute();
    
    
    
     echo('<b>Disciplina<b><br/>');
    while ($idDis = $disc->fetch(PDO::FETCH_OBJ) ) {    $j=1;
      $id_di2 = $idDis->id_di2;

    $r35=$con2->prepare("SELECT DISTINCT nome FROM tbl_dis2 WHERE id_di2=:IDDIC ORDER BY nome ASC");
    $r35->bindParam(":IDDIC",$id_di2,PDO::PARAM_STR);
    $r35->execute();

    $v36=$r35->fetch(PDO::FETCH_OBJ);
    $cont35=$r35->rowCount();
        $dis = utf8_decode($v36->nome);
         
       ////=====================================
          $r34=$con2->prepare("SELECT * FROM tb_pagamento_provas WHERE id_aluno=:id AND ano_lectivo=:ano AND disciplina=:disci");
          $r34->bindParam(":id",$processo,PDO::PARAM_STR);
          $r34->bindParam(":ano",$ano_Pa,PDO::PARAM_STR);
          $r34->bindParam(":disci",$dis,PDO::PARAM_STR);
          $r34->execute();
          //if($r34->rowCount() ==0){
            echo ('
                 <input type="checkbox" name="disciplina[]" value="'.$id_di2.'" id="tipo"/> '.utf8_encode($dis).'
                  <br/>
            ');
            
         // }


    }   
    $con2 =null;
   echo('
          
    ');

      
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
                        <td><div id="preco"></div> <input type="number" name="preco" value="1000" class="form-control" required/></td>
                    </tr>                    
                    <tr>  
                      <td><input type="submit" value="Concluir" name="sv" class="btn btn-success"></td>
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