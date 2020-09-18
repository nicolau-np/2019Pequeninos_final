<?php
session_start();
/**
 * @author lolkittens
 * @copyright 2016
 */

require_once("conn2.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8" />
<script src="assets/js/jquery-1.5.2.js" type="text/javascript"></script>
<title>View</title>

</head>

<body>
<table class="table table-striped table-hover table-bordered" id="polo">
<thead>
  <tr>
<th>Proc.</th>
    <th>Nome completo</th>
    <th>Curso</th>
    <th>Classe</th>
      <th>Turma</th>
    <th>Turno</th>
    <?php if($_SESSION['tituloS']=="admin2"): echo "<th>Marcar</th>";endif;?>
  </tr>
  </thead>
<tbody>
 
<?php 
$pagina=(isset($_GET['pagina']))?$_GET['pagina']:1;

$sql="select *from view_estudante";
try{
   $result=$con2->prepare($sql);
   $result->execute(); 
}
catch(PDOException $e)
{
    echo $e;
}
$total=$result->rowCount();
$registros=7;
$numpaginas=ceil($total/$registros);
$inicio=($registros*$pagina)-$registros;

$sql="select *from view_estudante order by nome asc limit $inicio,$registros ";
try{
   $result=$con2->prepare($sql);
   $result->execute(); 
}
catch(PDOException $e)
{
    echo $e;
}
$total=$result->rowCount();
while($ver=$result->fetch(PDO::FETCH_OBJ))
{
	
?>
 <tr>
 <td><?php echo $ver->id_aluno;?></td>
  <td><?php echo $ver->nome;?></td>
 <td><?php echo $ver->curso; ?></td>
<td><?php echo $ver->classe; ?></td>
 <td><?php echo $ver->turma; ?></td>
<td><?php echo $ver->turno; ?></td>
 <?php if($_SESSION['tituloS']=="admin2"): echo '<td><a href="count_pupilo.php?be4800='.$ver->id_aluno.'" class="btn btn-primary btn-xs"><i class="fa fa-check"></i> Marcar</a></td>';endif;?> 
 </tr>
  <?php }?>
  </tbody>
</table>

</body>
</html>
