<?php
include("validarlogin.php");

$_SESSION['id_aluno9996']=$_GET['id_aluno'];
$_SESSION['id_pessoa9996']=$_GET['id_pessoa'];
$_SESSION['id_foto9996']=$_GET['foto'];


if(isset($_SESSION['id_aluno9996'])):
 echo "<script>
teste=confirm('Tem certeza que deseja eliminar todos historicos do estudante Aluno?');
if (teste==1){
window.location.href='eliminar_aluno.php';
}else{
window.location.href='wizards.php';
}
</script>"; 
else:
    echo 'erro';
endif;



?>




