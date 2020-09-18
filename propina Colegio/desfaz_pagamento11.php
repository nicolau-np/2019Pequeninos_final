<?php 
ob_start();
session_start();
if(!isset($_SESSION['nomeS']) && (!isset($_SESSION['senhaS'])))
{
    header("location:index.php?acao=negado");exit;
}
include 'conn2.php';
if(isset($_POST['apagar'])):
$id_pag=$_POST['id_pag'];

    $command="delete from tbl_comp_pais where id_comp_pais=:id";
try
{
 $result=$con2->prepare($command);
 $result->bindParam(":id",$id_pag,PDO::PARAM_STR); 
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
endif;
?>
