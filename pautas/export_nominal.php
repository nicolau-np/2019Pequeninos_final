<?php 
ob_start();
session_start();
include("validarlogin.php");
require_once("config/conn.php");


?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>d</title>
    <style>
    .amarelo{
        background-color:#FCB904;
        color:#fff;
    }
    .vermelho{
        background-color: #8a1f11;
        color:#fff;
    }
    .normal{
        background-color:#00FFFFFF;
    }
</style>
    </head>
<body>
<?php

/**
 * @author lolkittens
 * @copyright 2016
 */
$curso=$_GET['curso'];
$classe=$_GET['classe'];
$turma=$_GET['turma'];
$turno=$_GET['turno'];
$ano=$_GET['ano'];

header("Content-Type: application/vnd.ms-excel");
header("Content-Type: application/force-download");
header("Content-disposition: attachment; filename=$curso-$classe $turma-$turno-$ano.xls");
header("Pragma:no-Cache");    

?>
    <div style="font-family:arial; font-size: 15px; font-weight: bold; text-align: center;">
        
República de Angola<br/>																																							
Governo Provincial Do Huambo<br/>																																						
Ministério Da Educação Ciência e Tecnologia<br/>																																							
<span style="color:#90111A;">ESCOLA PRIMÁRIA E DO I CICLO “LAR DOS PEQUENINOS” DAS IRMÃS DO SANTÍSSIMO SALVADOR</span><br/>
LISTA NOMINAL DOS ALUNOS<br/>
<b>Curso:</b> <?php echo $curso;?> <b>Classe:</b> <?php echo $classe;?>   <b>Turma:</b> <?php echo $turma;?>   <b>Periodo:</b> <?php echo $turno;?>   <b>Ano Lectivo:</b> <?php echo $ano;?> 
<br/><br/>
   </div>

<br />
<pre>

</pre>
<table border='1' id="xt" width="50%">
    <tr style="background-color: #ff0;">
 			<th>Proc.</th>
                        <th>Nº</th>
                            <th>Nome completo</th>
                            <th>Genero</th>
                            <th>Idade</th>
                          </tr>
        
                            
                            <?php 
                        
        $select="select *from view_historico where curso=:curso and classe=:classe and turma=:turma and turno=:turno and anolectivo=:ano order by nome ASC";
        $xe=$con->prepare($select);
        $xe->bindParam(":curso",$curso,PDO::PARAM_STR);
        $xe->bindParam(":classe",$classe,PDO::PARAM_STR);
        $xe->bindParam(":turma",$turma,PDO::PARAM_STR);
        $xe->bindParam(":turno",$turno,PDO::PARAM_STR);
        $xe->bindParam(":ano",$ano,PDO::PARAM_STR);
        $xe->execute(); 
        $conta=$xe->rowCount();
        if($conta>0):
        $a=0;
        while($ver=$xe->fetch(PDO::FETCH_OBJ))
        {
            $a++;
$strings=$ver->data_nascimento;
$string=explode("-",$strings);
$idade=date("Y") - $string[0];
if($ver->genero=="Masculino"):
    $g="M";
else:
    $g="F";
endif;
       if($ver->aproveitamento=="Transferencia"):
            $cor = "amarelo";
          elseif($ver->aproveitamento=="Desistencia"):
              $cor="vermelho";
          else:
             $cor=""; 
          endif;
            echo"<tr class='".$cor."'>
                            <td>{$ver->id_aluno}</td>
                            <td>{$a}</td>
                            <td>{$ver->nome}</td>
                            <td>{$g}</td>
                            <td>{$idade}</td>
                           
                        </tr>";
        }
    endif;
        ?>

                            
 </table>
</body>
</html>
