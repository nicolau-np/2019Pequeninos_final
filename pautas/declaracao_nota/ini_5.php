<?php
ob_start();
session_start();
include_once '../config/conn.php';
$id=$_SESSION['id_aluno6001'];
$ano=$_GET['ano'];
$efeito=$_GET['efeito'];
$numero=$_GET['numero'];
$classe=$_GET['classe'];


/*codigo php */
$co="select *from view_estudante where id_aluno=:id";
$exe=$con->prepare($co);
$exe->bindParam(":id",$id,PDO::PARAM_STR);
$exe->execute();
$mostra=$exe->fetch(PDO::FETCH_OBJ);


$co300="select *from view_historico where id_pessoa=:id and anolectivo=:ano";
$exe300=$con->prepare($co300);
$exe300->bindParam(":id",$mostra->id_pessoa,PDO::PARAM_STR);
$exe300->bindParam(":ano",$ano,PDO::PARAM_STR);
$exe300->execute();
$mostra300=$exe300->fetch(PDO::FETCH_OBJ);

$strings=$mostra300->data_nascimento;
$string=explode("-",$strings);
if($string[1]==1):
$mes="Janeiro";
elseif($string[1]==2):
$mes="Fevereiro";
elseif($string[1]==3):
$mes="Março";
elseif($string[1]==4):
$mes="Abril";
elseif($string[1]==5):
$mes="Maio";
elseif($string[1]==6):
$mes="Junho";
elseif($string[1]==7):
$mes="Julho";
elseif($string[1]==8):
$mes="Agosto";
elseif($string[1]==9):
$mes="Setembro";
elseif($string[1]==10):
$mes="Outubro";
elseif($string[1]==11):
$mes="Novembro";
elseif($string[1]==12):
$mes="Dezembro";
endif;

$strings2=date("d-m-Y");
$string2=explode("-",$strings2);
if($string2[1]==1):
$mes2="Janeiro";
elseif($string2[1]==2):
$mes2="Fevereiro";
elseif($string2[1]==3):
$mes2="Março";
elseif($string2[1]==4):
$mes2="Abril";
elseif($string2[1]==5):
$mes2="Maio";
elseif($string2[1]==6):
$mes2="Junho";
elseif($string2[1]==7):
$mes2="Julho";
elseif($string2[1]==8):
$mes2="Agosto";
elseif($string2[1]==9):
$mes2="Setembro";
elseif($string2[1]==10):
$mes2="Outubro";
elseif($string2[1]==11):
$mes2="Novembro";
elseif($string2[1]==12):
$mes2="Dezembro";
endif;

$strings3=$mostra300->data_emissao;
$string3=explode("-",$strings3);
if($string3[1]==1):
$mes3="Janeiro";
elseif($string3[1]==2):
$mes3="Fevereiro";
elseif($string3[1]==3):
$mes3="Março";
elseif($string3[1]==4):
$mes3="Abril";
elseif($string3[1]==5):
$mes3="Maio";
elseif($string3[1]==6):
$mes3="Junho";
elseif($string3[1]==7):
$mes3="Julho";
elseif($string3[1]==8):
$mes3="Agosto";
elseif($string3[1]==9):
$mes3="Setembro";
elseif($string3[1]==10):
$mes3="Outubro";
elseif($string3[1]==11):
$mes3="Novembro";
elseif($string3[1]==12):
$mes3="Dezembro";
endif;







$html = '
<style>
.ver{
color:red;
}
</style>

<div style="border: 1mm solid #000088; padding: 1em; font-family:arial;">
<div style="text-align:center;">
<img src="../logo.png" style="height:50px; width:50px;"/>
<br/>
GOVERNO DA PROVÍNCIA DO HUAMBO<br/>
DIRECÇÃO PROVINCIAL DA EDUCAÇÃO, CIÊNCIA E TECNOLOGIA<br/>
COMPLEXO ESCOLAR LAR DOS PEQUENINOS DAS IRMÃS DO SANTÍSSIMO <br/>SALVADOR-HUAMBO<br/><br/><br/><br/><br/>

<span style="font-weight:bold; font-size:25px;">DECLARAÇÃO</span>
</div><br/><br/>';

$html.="<div style='text-align:justify;'>A Armanda Maria Eduardo Directora do Complexo Escolar Lar dos Pequeninos das irmãs do Santíssimo Salvador Certifico que: <span style='color:red;'>".$mostra300->nome."</span>
Filho(a) de ".$mostra300->pai." e de ".$mostra300->mae." Nascido(a) aos ".$string[2]." de ".$mes." de ".$string[0].", natural de ".$mostra300->municipio." Município de, ".$mostra300->municipio." 
província de ".$mostra300->provincia.", portador(a) do B.I nº ".$mostra300->bi." Passado pelo Arquivo de Identificação de ".$mostra300->local_emissao." aos ".$string3[2]." de ".$mes3." de ".$string3[0]."
Concluiu neste Complexo Escolar Lar dos Pequeninos no ano lectivo de ".$ano." a ".$classe." classe, com a seguinte classificação:<br/><br/>
</div>";
/*parte da tabela de notas*/
$html.="<center>
    <table border=1 style='border:1px solid #000;'>
                    
                    <thead  style='border-bottom:1px solid #000;'>
					<tr>

                            <th>DISCIPLINAS</th>
                            <th>QUALIFICAÇÃO</th>
                            <th>COMPORTAMENTO</th>
                 
                        </tr>
  </thead>
  <tbody>";

$sele="select *from view_disciplinas where curso=:curso and classe=:classe";
$runE=$con->prepare($sele);
$runE->bindParam(":curso",$mostra300->curso,PDO::PARAM_STR);
$runE->bindParam(":classe",$mostra300->classe,PDO::PARAM_STR);
$runE->execute();
$ep = 3;
while($viewE=$runE->fetch(PDO::FETCH_OBJ)){
    $cla = "---";
    $co14="select *from view_notas where disciplina=:disciplina and anoLetivo=:ano and id_aluno=:id and epoca=:epoca";
$re14=$con->prepare($co14);
$re14->bindParam(":disciplina",$viewE->nome,PDO::PARAM_STR);
$re14->bindParam(":ano",$ano,PDO::PARAM_STR);
$re14->bindParam(":id",$id,PDO::PARAM_STR);
$re14->bindParam(":epoca",$ep,PDO::PARAM_STR);
$re14->execute();
$viewE2=$re14->fetch(PDO::FETCH_OBJ);
$html.="  <tr>
  <td>".$viewE->nome."</td>";
if(($viewE2->ct>=1)&&($viewE2->ct<=2)):
    $cla = "MAU";
elseif(($viewE2->ct>=3)&&($viewE2->ct<=4)):
    $cla = "MEDÍUQUE";
elseif(($viewE2->ct>=5)&&($viewE2->ct<=6)):
    $cla = "SÚFICE";
elseif(($viewE2->ct>=7)&&($viewE2->ct<=8)):
    $cla = "BOM";
elseif(($viewE2->ct>=9)&&($viewE2->ct<=10)):
    $cla = "MUITO BOM";
else:
    echo '---';
endif;
 $html.=" <td >".$cla."</td>
   
  ";
}
 $html.="<td style='text-align:center;border:0px;'>BOM</td>
         </tr>";  
  $html.="
      </tbody>
  </table></center>";  
/*fim tabela*/
$html.="<div style='text-align:justify;'><br/><br/>Por ser verdade e me ter solicitado, mandei passar a presente declaração que vai por mim
assinada e autenticada com o carimbo a óleo, em uso nesta institução escolar.
<br/><br/></div>
<div style='text-align:center;'>Huambo aos ".$string2[0]." de ".$mes2." de ".$string2[2]."<br/><br/><br/></div>
</div>";

include("../../propina Colegio/mpdf/mpdf.php");

$mpdf=new mPDF(); 

$mpdf->WriteHTML($html);

$mpdf->Output(); 

exit;
?>
