<?php 
ob_start();
session_start();
if(!isset($_SESSION['nomeS']) && (!isset($_SESSION['senhaS'])))
{
    header("location:index.php?acao=negado");exit;
}
require_once("conn.php");

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>xml</title>
    </head>
<body>
<?php

/**
 * @author lolkittens
 * @copyright 2016
 */

$classe=$_GET['txt8'];
$turma=$_GET['txt9'];
$turno=$_GET['txt10'];
$ano=$_GET['anoL5'];

header("Content-Type: application/vnd.ms-excel");
header("Content-Type: application/force-download");
header("Content-disposition: attachment; filename=$classe $turma-$turno-$ano.xml");
header("Pragma:no-Cache");    

?>
<table id="">
                            <tr>
							<td>nome</td>
                            <td>curso</td>
                            <td>classe</td>
                            <td>turma</td>
							
							<td>turno</td>
                            <td>ano</td>
                            <td>provincia</td>
                            <td>municipio</td>
							
							<td>data nascimento</td>
							<td>genero</td>
                            <td>bi</td>
                            <td>data emissao</td>
                            <td>local emissao</td>
							
							<td>pai</td>
                            <td>mae</td>
                            <td>telefone</td>
                            <td>processo</td>
							
							<td>foto</td>
                            <td>cardeneta</td>
                            <td>titulo</td>
                           
                          </tr>
        
                            
                            <?php 
                        
                            $er="select *from tbl_aluno where classe=:classe and turma=:turma and turno=:turno and ano_lectivo=:ano order by nome asc";
                            $exe=$con->prepare($er);
                            $exe->bindParam(":classe",$classe,PDO::PARAM_STR);
                            $exe->bindParam(":turma",$turma,PDO::PARAM_STR);
                            $exe->bindParam(":turno",$turno,PDO::PARAM_STR);
                            $exe->bindParam(":ano",$ano,PDO::PARAM_STR);
                            $exe->execute();
                            
                            $a=0;
                            while($mostra=$exe->fetch(PDO::FETCH_OBJ))
                            {
                                $a++;
                            ?>
                            <tr>
                            <td><?php echo $mostra->nome;?></td>
                            <td>1</td>
							 <td><?php echo $mostra->classe;?></td>
							  <td><?php echo $mostra->turma;?></td>
							   <td><?php echo $mostra->turno;?></td>
							    <td><?php echo $mostra->ano_lectivo;?></td>
								 <td><?php echo $mostra->provincia;?></td>
								  <td><?php echo $mostra->municipio;?></td>
								   <td><?php if($mostra->data_nascimento==""): echo"00-00-0000"; else: echo $mostra->data_nascimento; endif;?></td>
								    <td><?php echo $mostra->genero;?></td>
									 <td><?php if($mostra->bi==""): echo"00-00-0000"; else: echo $mostra->bi; endif;?></td>
									  <td><?php if($mostra->data_emissao==""): echo"00-00-0000"; else: echo $mostra->data_emissao; endif;?></td>
									   <td><?php  echo $mostra->local_emissao; ?></td>
									    <td><?php if($mostra->pai==""): echo"no"; else: echo $mostra->pai; endif;?></td>
										 <td><?php if($mostra->mae==""): echo"no"; else: echo $mostra->mae; endif;?></td>
										  <td><?php if($mostra->telefone==""): echo"000000000"; else: echo $mostra->telefone; endif;?></td>
										   <td><?php echo $mostra->processo;?></td>
										    <td>none.jpg</td>
											 <td>nao</td>
											  <td>aluno</td>
											 
									   
                            </tr>
                            <?php }?>

                            
                            </table>
</body>
</html>