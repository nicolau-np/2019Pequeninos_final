
<?php
$epoca = addslashes(htmlspecialchars($_POST['cb_timestre']));
$ano = addslashes(htmlspecialchars($_POST['txt_ano']));
include("validarlogin.php");
require_once("config/conn.php");
include_once 'classes/Estatistica.php';
$tipoEsta="";
$objEstatistica = new Estatistica();
$objEstatistica->setCon($con);

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

   .ft1
{
text-align:center; 
font-size:15px; 
border-top:0px;

} 
</style>

</head>
<body>
<div class='cabe' style='font-family:arial; font-size:12px;'>

<img src='logo.png' style='height:50px; width:50px;'/>
<br/>
REPÚBLICA DE ANGOLA<br/>
GOVERNO DA PROVÍNCIA DO HUAMBO<br/>
DIRECÇÃO PROVINCIAL DA EDUCAÇÃO, CIÊNCIA E TECNOLOGIA<br/>
Gabinete de Estudos, Planeamento e Estatística<br/>
FICHA DE ESTATÍSTICA TRIMESTRE<br/>
</div><br/>

";

$html.="
    <table border=1 style='font-family:arial; font-size:12px;' width='100%'>
    <tr>
<td colspan=3>ESCOLA: COMPLEXO ESCOLAR DAS IRMÃS DO SANTÍSSIMO SALVADOR LAR DOS PEQUENINOS</td> 
<td colspan=2></td>
<td>COMUNA: CAPANGO</td>
</tr>
<tr>

<td>NÚMERO DE PROFESSORES QUE LECCIONAM:</td> 
<td></td>
<td></td>
<td colspan=2></td>
<td>MUNICÍPIO: HUAMBO</td>
</tr>

<tr>
<td colspan=2>NÚMERO TOTAL DE SALAS DE AULAS DEFINITIVAS:</td> 
<td colspan=3>14</td>
<td>PROVÍNCIA: HUAMBO</td>
</tr>

</table>
<span style='align:center; font-weight:bold;font-family:arial; font-size:12px;'>".$epoca."º TRIMESTRE</span><br/><br/>
        ";

$html.="<table border=1 style='font-family:arial; font-size:12px;' width='100%'>";
$html.="<tr>
    <td>CLASSES</td>
    <td colspan=2>MATRICULADOS</td>
    <td colspan=2>DESISTIDOS</td>
    <td colspan=2>CHEGADOS AO FIM</td>
    <td colspan=2>APROVADOS</td>
    <td colspan=2>REPROVADOS</td>
    </tr>
        ";
$html.="<tr>
    <td>ALUNOS</td>
    <td>MF</td>
    <td>F</td>
    <td>MF</td>
    <td>F</td>
    <td>MF</td>
    <td>F</td>
    <td>MF</td>
    <td>F</td>
    <td>MF</td>
    <td>F</td>
    </tr>
        ";
$somaNTraF1=0;
$somaNTraMF1=0;
$somaTraF1=0;
$somaTraMF1=0;
$somaChegFimF1=0;
$somaChegFimMF1=0;
$tipoEsta1 = 1;
$objEstatistica->setTipo($tipoEsta1);
$res1 = $objEstatistica->buscaDisciplinas();
while ($view1 = $res1->fetch(PDO::FETCH_OBJ)):
    
$html.="<tr>
    <td>".$view1->classe."</td>";

$res1MatrMF1 = $objEstatistica->matriculadosMF($view1->classe, $ano);
$contMatMF1 = $res1MatrMF1->rowCount();
$html.="<td>".$contMatMF1."</td>";
$somaMatMF1 = $somaMatMF1 + $contMatMF1;

$res1MatF1 = $objEstatistica->matriculadosF($view1->classe, $ano);
$contMatF1 = $res1MatF1->rowCount();
$html.="<td>".$contMatF1."</td>";
$somaMatF1 = $somaMatF1 + $contMatF1;
 
$res1DesMF1 = $objEstatistica->desitidosMF($view1->classe, $ano);
$contDesMF1 = $res1DesMF1->rowCount();
$html.="<td>".$contDesMF1."</td>";
$somaDesMF1 = $somaDesMF1 + $contDesMF1;

$res1DesF1 = $objEstatistica->desitidosF($view1->classe, $ano);
$contDesF1 = $res1DesF1->rowCount();
$html.="<td>".$contDesF1."</td>";
$somaDesF1 = $somaDesF1 + $contDesF1;


$contChegFimFM1 = $contMatMF1-$contDesMF1;
$somaChegFimMF1 = $somaChegFimMF1 + $contChegFimFM1;

$contChegFimF1 = $contMatF1-$contDesF1;
$somaChegFimF1 = $somaChegFimF1 + $contChegFimF1;



$html.="
     <td>".$contChegFimFM1."</td>
    <td>".$contChegFimF1."</td>";

$res1TraMF1 = $objEstatistica->transitaMF($view1->classe, $ano);
$contTraMF1 = $res1TraMF1->rowCount();
$html.="<td>".$contTraMF1."</td>";
$somaTraMF1 = $somaTraMF1 + $contTraMF1;

$res1TraF1 = $objEstatistica->transitaF($view1->classe, $ano);
$contTraF1 = $res1TraF1->rowCount();
$html.="<td>".$contTraF1."</td>";
$somaTraF1 = $somaTraF1 + $contTraF1;


$res1NTraMF1 = $objEstatistica->NaotransitaMF($view1->classe, $ano);
$contNTraMF1 = $res1NTraMF1->rowCount();
$html.="<td>".$contNTraMF1."</td>";
$somaNTraMF1 = $somaNTraMF1 + $contNTraMF1;

$res1NTraF1 = $objEstatistica->NaotransitaF($view1->classe, $ano);
$contNTraF1 = $res1NTraF1->rowCount();
$html.="<td>".$contNTraF1."</td>";
$somaNTraF1 = $somaNTraF1 + $contNTraF1;

endwhile;


$html.="<tr style='background:#0092ef;'>
    <td>SOMA</td>
    <td>".$somaMatMF1."</td>
    <td>".$somaMatF1."</td>
    <td>".$somaDesMF1."</td>
    <td>".$somaDesF1."</td>
    <td>".$somaChegFimMF1."</td>
    <td>".$somaChegFimF1."</td>
    <td>".$somaTraMF1."</td>
    <td>".$somaTraF1."</td>
    <td>".$somaNTraMF1."</td>
    <td>".$somaNTraF1."</td>
    </tr>
        ";
$somaNTraF2=0;
$somaNTraMF2=0;
$somaTraMF2=0;
$somaTraF2=0;
$somaChegFimF2=0;
$somaChegFimMF2=0;
$somaDesF2 = 0;
$tipoEsta2 = 2;
$objEstatistica->setTipo($tipoEsta2);
$res2 = $objEstatistica->buscaDisciplinas();
while ($view2 = $res2->fetch(PDO::FETCH_OBJ)):
$html.="<tr>
    <td>".$view2->classe."</td>";
       
$res1MatrMF2 = $objEstatistica->matriculadosMF($view2->classe, $ano);
$contMatMF2 = $res1MatrMF2->rowCount();
$html.="<td>".$contMatMF2."</td>";
$somaMatMF2 = $somaMatMF2 + $contMatMF2;

$res1MatF2 = $objEstatistica->matriculadosF($view2->classe, $ano);
$contMatF2 = $res1MatF2->rowCount();
$html.="<td>".$contMatF2."</td>";
$somaMatF2 = $somaMatF2 + $contMatF2;

$res1DesMF2 = $objEstatistica->desitidosMF($view2->classe, $ano);
$contDesMF2 = $res1DesMF2->rowCount();
$html.="<td>".$contDesMF2."</td>";
$somaDesMF2 = $somaDesMF2 + $contDesMF2;

$resDesF2 = $objEstatistica->desitidosF($view2->classe, $ano);
$contDesF2 = $resDesF2->rowCount();
$html.="<td>".$contDesF2."</td>";
$somaDesF2 = $somaDesF2 + $contDesF2;

$contChegFimFM2 = $contMatMF2-$contDesMF2;
$somaChegFimMF2 = $somaChegFimMF2 + $contChegFimFM2;

$contChegFimF2 = $contMatF2-$contDesF2;
$somaChegFimF2 = $somaChegFimF2 + $contChegFimF2;

$html.="
   
    <td>".$contChegFimFM2."</td>
    <td>".$contChegFimF2."</td>";

$res1TraMF2 = $objEstatistica->transitaMF($view2->classe, $ano);
$contTraMF2 = $res1TraMF2->rowCount();
$html.="<td>".$contTraMF2."</td>";
$somaTraMF2 = $somaTraMF2 + $contTraMF2;

$res1TraF2 = $objEstatistica->transitaF($view2->classe, $ano);
$contTraF2 = $res1TraF2->rowCount();
$html.="<td>".$contTraF2."</td>";
$somaTraF2 = $somaTraF2 + $contTraF2;


$res1NTraMF2 = $objEstatistica->NaotransitaMF($view2->classe, $ano);
$contNTraMF2 = $res1NTraMF2->rowCount();
$html.="<td>".$contNTraMF2."</td>";
$somaNTraMF2 = $somaNTraMF2 + $contNTraMF2;

$res1NTraF2 = $objEstatistica->NaotransitaF($view2->classe, $ano);
$contNTraF2 = $res1NTraF2->rowCount();
$html.="<td>".$contNTraF2."</td>";
$somaNTraF2 = $somaNTraF2 + $contNTraF2;

endwhile;

$html.="<tr style='background:#0092ef;'>
    <td>SOMA</td>
    <td>".$somaMatMF2."</td>
    <td>".$somaMatF2."</td>
    <td>".$somaDesMF2."</td>
    <td>".$somaDesF2."</td>
    <td>".$somaChegFimMF2."</td>
    <td>".$somaChegFimF2."</td>
    <td>".$somaTraMF2."</td>
    <td>".$somaTraF2."</td>
    <td>".$somaNTraMF2."</td>
    <td>".$somaNTraF2."</td>
    </tr>
        ";
$html.="<tr>
    <td>TOTAL</td>
    <td>".($somaMatMF1+$somaMatMF2)."</td>
    <td>".($somaMatF1+$somaMatF2)."</td>
    <td>".($somaDesMF1+$somaDesMF2)."</td>
    <td>".($somaDesF1+$somaDesF2)."</td>
    <td>".($somaChegFimMF1+$somaChegFimMF2)."</td>
    <td>".($somaChegFimF1+$somaChegFimF2)."</td>
    <td>".($somaTraMF1+$somaTraMF2)."</td>
    <td>".($somaTraF1+$somaTraF2)."</td>
      <td>".($somaNTraMF1+$somaNTraMF2)."</td>
    <td>".($somaNTraF1+$somaNTraF2)."</td>
    </tr>
        ";



$html.="</table>";


$html.="<div class='texto' style='font-family:arial; font-size:12px;'>
<br/>

<div style='text-align:center;'>Huambo aos ".$string2[0]." de ".$mes2." de ".$string2[2]."<br/><br/>

A DIRECTORA<br/>
______________________________<br/>
Lic. Armanda Maria Eduardo
</p></div>
</div>
";

$html.="

";
$html.="

</body>
</html>";

include("../propina Colegio/mpdf/mpdf.php");

$mpdf=new mPDF('c','A4-L'); 

$mpdf->WriteHTML($html);

$mpdf->Output(); 

exit;?>
