<?php
ob_start();
session_start();
$id=$_GET['be'];
$ano=date("Y");

$_SESSION['id']=$id;


echo "<script>
teste=confirm('Tem certeza que deseja eliminar Aluno?');
if (teste==1){
window.location.href='eliminar.php';
}else{
window.location.href='view_teacher.php';
}
</script>";

?>