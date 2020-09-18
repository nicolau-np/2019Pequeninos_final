<?php
include 'config/conn.php';
include 'validarlogin.php';
include 'classes/Eliminar_avaliacao.php';
$ano=$_GET['ano'];
$id_disciplina=$_GET['id_disciplina'];
$id_avaliacao=$_GET['id_avaliacao'];
$id_aluno=$_GET['id_aluno'];
$epoca=$_GET['epoca'];
$curso=$_GET['curso'];
$classe=$_GET['classe'];
$pagina=$_GET['pagina'];



$obj= new Eliminar_avaliacao($con,$ano,$id_aluno,$id_avaliacao,$id_disciplina,$epoca,$curso,$classe,$pagina);
$r1=$obj->eliminar_ava();
$r2=$obj->buscar_valores_MAC_CT($r1);
$r3=$obj->buscar_valores_finais($r2);
$obj->update_cla($r3);
?>

