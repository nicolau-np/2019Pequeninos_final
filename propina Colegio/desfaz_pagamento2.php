<?php
ob_start();
session_start();
if(!isset($_SESSION['nomeS']) && (!isset($_SESSION['senhaS'])))
{
    header("location:index.php?acao=negado");exit;
}
include 'conn2.php';
$id_aluno=$_GET['id'];
$numero_confirmacao=$_GET['ano'];


    $command="delete from tbl_inscricao where id_aluno=:pro and ano=:ano";
try
{
 $result=$con2->prepare($command);
 $result->bindParam(":pro",$id_aluno,PDO::PARAM_STR); 
$result->bindParam(":ano",$numero_confirmacao,PDO::PARAM_STR);
 $result->execute(); 
 echo '<script>
    alert("Pagamento Eliminado com sucesso!");
    window.location.href="count_pupilo2.php";
</script>';
}
catch(PDOException $e)
{
    echo $e;
}



?>
