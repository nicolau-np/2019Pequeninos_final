<?php 
ob_start();
session_start();
if(!isset($_SESSION['nomeS']) && (!isset($_SESSION['senhaS'])))
{
    header("location:index.php?acao=negado");exit;
}
include 'conn2.php';
if(isset($_POST['apagar'])):
    $id_pag=$_POST['ves'];
$id_aluno=$_POST['id_aluno'];
$ano=$_POST['anoLE'];

    $command="delete from tbl_transferencia where id_transferencia=:pro";
try
{
 $result=$con2->prepare($command);
 $result->bindParam(":pro",$id_pag,PDO::PARAM_STR); 
 $result->execute(); 
 
 
  $obse=" ";
                                   $se03="update tbl_historico_aluno set aproveitamento=:apro where id_aluno=:id_aluno and anolectivo=:ano";
                            $r03=$con2->prepare($se03);
                            $r03->bindParam(":apro",$obse,PDO::PARAM_STR);
                             $r03->bindParam(":id_aluno",$id_aluno,PDO::PARAM_STR);
                              $r03->bindParam(":ano",$ano,PDO::PARAM_STR);
                            $r03->execute();
 
 
 echo '<script>
    alert("Pagamento Eliminado com sucesso!");
    window.location.href="count_pupilo2.php";
</script>';
}
catch(PDOException $e)
{
    echo $e;
}
endif;
?>