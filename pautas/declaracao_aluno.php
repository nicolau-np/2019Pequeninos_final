<?php

include("validarlogin.php");
require_once("config/conn.php");
$id=$_SESSION['id_aluno6001'];
$ano=$_GET['ano'];
$efeito=$_GET['efeito'];
$numero=$_GET['numero'];

$co="select *from view_estudante where id_aluno=:id and anolectivo=:ano";
$exe=$con->prepare($co);
$exe->bindParam(":id",$id,PDO::PARAM_STR);
$exe->bindParam(":ano",$ano,PDO::PARAM_STR);
$exe->execute();
$mostra=$exe->fetch(PDO::FETCH_OBJ);


$strings=$mostra->data_nascimento;
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



$html="<html>
<head><title></title>
<style>
.cabe
{
   text-align:center; 
    }
    .b
    {
        text-align:center;
       
        }
        .desig
        {
	font-size:18px;
   text-align:center; 
            }
              .design
        {
   text-align:center; 
            }

   .texto
{
padding-left:29px;
font-size:16px;
}   
</style>

<div class='cabe'>

<img src='logo.png' style='height:50px; width:50px;'/>
<br/><br/>
REPÚBLICA DE ANGOLA<br/><br/>
GOVERNO DA PROVÍNCIA DO HUAMBO<br/><br/>
DIRECÇÃO PROVINCIAL DA EDUCAÇÃO, CIÊNCIA E TECNOLOGIA<br/><br/>
COMPLEXO ESCOLAR LAR DOS PEQUENINOS DAS IRMÃS DO SANTÍSSIMO <br/>SALVADOR-HUAMBO<br/>
</div><br/><br/>

<div class='desig'>DECLARAÇÃO nº<span style='color:red;'> ".$numero."</span> /2018</div><br/><br/>

";


$html.="<div class='texto' style='text-align:justify;'>

Para os devidos efeitos, declara-se que: <span style='color:red;'>".$mostra->nome."</span>, 
filho de ".$mostra->pai." e de ".$mostra->mae.", nascido aos ".$string[2]." de ".$mes." de ".$string[0].", natural de ".$mostra->provincia.".
<br/><br/>
O mesmo encontra-se a frequentar a ".$mostra->classe." Classe nesta Instituição escolar.
<br/><br/>
Esta declaração destina-se exclusivamente para efeito de ".$efeito.".
<br/><br/>
Por ser verdade, e me ter solicitado, mandei passar a presente declaração que por mim assinada e autenticada com o carimbo a óleo em uso nesta instituição.
<br/><br/><br/><br/><br/><br/>

<p align='center'>Huambo, aos ".$string2[0]." de ".$mes2." de ".$string2[2]."
<br/><br/>
<br/>
<br/>
<br/>
A DIRECTORA<br/>
______________________________<br/>
Lic. Armanda Maria Eduardo
</p>
</div>
";

$html.="

";
$html.="

</body>
</html>";

include("../propina Colegio/mpdf/mpdf.php");
$mpdf=new mPDF('c','A4'); 
$mpdf->WriteHTML($html);
$mpdf->Output();
exit;
?>
?>