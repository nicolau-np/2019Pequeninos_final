<?php
include("../validarlogin.php");
include("../config/conn.php");

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title></title>
	
	<style>
.table
{
    font-family:"Times New Roman";
    font-size:13px;
    }
	
.vermelho
{
    color:red;
}
.azul
{
    color:blue;
}
.amarelo
{
    color:orangered;
}
.verde
{
    color:green;
}
</style>
	
    </head>
<body>
<?php 
$classe=$_GET['classe'];
$turma=$_GET['turma'];
$turno=$_GET['turno'];
$curso=$_GET['curso'];
$anoS=$_GET['ano'];
$epoca1=$_GET['epoca'];


header("Content-Type: application/vnd.ms-excel");
header("Content-Type: application/force-download");
header("Content-disposition: attachment; filename=$classe $turma-$turno-$anoS-$epoca1.xls");
header("Pragma:no-Cache");    

?>
    <div style="font-family:arial; font-size: 15px; font-weight: bold; text-align: center;">
        
República de Angola<br/>																																							
Governo Provincial Do Huambo<br/>																																						
Ministério Da Educação Ciência e Tecnologia<br/>																																							
<span style="color:#90111A;">ESCOLA PRIMÁRIA E DO I CICLO “LAR DOS PEQUENINOS” DAS IRMÃS DO SANTÍSSIMO SALVADOR</span><br/>
Boletim de Notas<br/>
Curso:<?php echo $curso;?> Classe:<?php echo $classe;?> Turma:<?php echo $turma;?> Periodo:<?php echo $turno;?> Trimestre:<?php echo $epoca1;?> Ano Lectivo:<?php echo $anoS;?>
<br/><br/>
   </div>

<br/>
<?php 

//matematica


$a=0;
$co2="select *from view_historico where curso=:curso and classe=:classe and turma=:turma and turno=:turno and anolectivo=:ano order by nome asc";
$re2=$con->prepare($co2);
$re2->bindParam(":curso",$curso,PDO::PARAM_STR);
$re2->bindParam(":classe",$classe,PDO::PARAM_STR);
$re2->bindParam(":turma",$turma,PDO::PARAM_STR);
$re2->bindParam(":turno",$turno,PDO::PARAM_STR);
$re2->bindParam(":ano",$anoS,PDO::PARAM_STR);
$re2->execute();

while ($ver2=$re2->fetch(PDO::FETCH_OBJ)){
?>
<table border=1>
                    <colgroup>
                      <col class="con0">
                        <col class="con1">
                        <col class="con0">
                        <col class="con1">
                        <col class="con0">
                        <col class="con1">
                        <col class="con0">
                        <col class="con1">
                        <col class="con0">
                        <col class="con1">
                        <col class="con0">
                         <col class="con1">
                         <col class="con0">
                    </colgroup>
                    <thead>
                         <tr class="bnc">
                            <td>Nº Proc.:<?php echo $ver2->id_aluno;?></td>
                            
                            <td>Nome:<?php echo $ver2->nome;?></td>
                      </tr>
                    
                        <tr>
                         <?php
                            $sql="select *from view_disciplinas where curso=:curso and classe=:classe";
                            $run=$con->prepare($sql);
                            $run->bindParam(":curso",$curso,PDO::PARAM_STR);
                            $run->bindParam(":classe",$classe,PDO::PARAM_STR);
                            $run->execute();
                            while($viewGG=$run->fetch(PDO::FETCH_OBJ)){
                                ?>
                            <th style="background-color: #ff0;"><?php echo $viewGG->nome;?></th>
                            <?php
                            }
                           ?>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                  <?php
                            $sql="select *from view_disciplinas where curso=:curso and classe=:classe";
                            $run=$con->prepare($sql);
                            $run->bindParam(":curso",$curso,PDO::PARAM_STR);
                            $run->bindParam(":classe",$classe,PDO::PARAM_STR);
                            $run->execute();
                            while($viewGG=$run->fetch(PDO::FETCH_OBJ)){
$co1="select *from view_notas where id_aluno=:id_aluno and epoca=:epoca and curso=:curso and classe=:classe and turma=:turma and turno=:turno and disciplina=:disciplina and anoLetivo=:ano order by nome asc";
$re1=$con->prepare($co1);
$re1->bindParam(":id_aluno",$ver2->id_aluno,PDO::PARAM_STR);
$re1->bindParam(":epoca",$epoca1,PDO::PARAM_STR);
$re1->bindParam(":curso",$curso,PDO::PARAM_STR);
$re1->bindParam(":classe",$classe,PDO::PARAM_STR);
$re1->bindParam(":turma",$turma,PDO::PARAM_STR);
$re1->bindParam(":turno",$turno,PDO::PARAM_STR);
$re1->bindParam(":disciplina",$viewGG->nome,PDO::PARAM_STR);
$re1->bindParam(":ano",$anoS,PDO::PARAM_STR);
$re1->execute();
$ver1=$re1->fetch(PDO::FETCH_OBJ);
                                ?>
                        <td class="<?php if($ver1->ct<=2): echo "vermelho"; else: echo "azul"; endif;?>"><?php if(($ver1->ct>=1)&&($ver1->ct<=2)): echo "Mau"; elseif(($ver1->ct>=3)&&($ver1->ct<=4)): echo "Medríuque"; elseif(($ver1->ct>=5)&&($ver1->ct<=6)): echo "Súfice"; elseif(($ver1->ct>=7)&&($ver1->ct<=8)): echo "Bom"; elseif(($ver1->ct>=9)&&($ver1->ct<=10)): echo "Muito Bom"; else: echo '---';endif;?></td>
                               <?php }?> 
                    </tr>
                    </tbody>
                    </table>
<?php }?>
<br/>


</body>
</html>
