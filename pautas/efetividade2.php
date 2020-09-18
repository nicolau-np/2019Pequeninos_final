<?php

include("validarlogin.php");
require_once("config/conn.php");
$ano=  addslashes(htmlspecialchars($_GET['ano']));
$mes= addslashes(htmlspecialchars($_GET['mes']));

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
     color: #002a80;
    }
    .b
    {
        text-align:center;
       color: #002a80;
        }
        .desig
        {
	font-size:18px;
   text-align:center; 
   color: #002a80;
            }
              .design
        {
   text-align:center; 
   color: #002a80;
            }

   .texto
{
padding-left:29px;
font-size:16px;
color: #002a80;
} 

   .ft1
{
text-align:center; 
font-size:15px; 
border-top:0px;
font-family:arial;
color: #002a80;
border: 1px solid #002a80;
} 
   .ft2
{
text-align:center; 
font-size:12px; 
border-top:0px;
font-family:arial;
color: #002a80;
border: 1px solid #002a80;
}

   .ft3
{
text-align:left; 
font-size:14px; 
border-top:0px;
font-family:arial;
color: #002a80;
border: 1px solid #002a80;
}

.tabLO{
margin-left:40px;
margin-right:40px;
margin-bottom:40px;
}

</style>
<link rel='stylesheet' href='css/style.default.css' type='text/css' />
<link rel='stylesheet' href='css/responsive-tables.css'/>
</head>
<body>
<div class='cabe'>
<br/>
<img src='logo.png' style='height:50px; width:50px;'/>
<br/><br/>
<span style='font-family:arial;'>
República de Angola<br/>
Governo da província do Huambo<br/></span>
<span style='font-family:arial; font-weight:bold; font-style: italic;'>
Direcção Provincial de Educação, Ciências e Tecnologia<br/>
ESCOLA PRIMÁRIA E I CICLO LAR DOS PEQUENINOS IRMÃS DO SANTÍSSIMO SALVADOR </span><br/><span style='font-family:arial; font-weight:bold; text-decoration: underline;'>HUAMBO</span>
<br/></span>
</div><br/>
<span style='font-family:arial; font-weight:bold; font-size:13px; color: #002a80;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O.D</span>
<br/>

<div class='desig'>
<span style='text-decoration:underline;'><br/><br/>MAPA DE EFECTIVIDADE DOS TRABALHADORES, REFERENTE AO MÊS DE ".strtoupper($mes)." ".$ano."
</span></div><br/><br/>

";
$html.="<div class='tabLO'>";
$html.="<table style='width:100%; border: 1px solid #002a80;' class ='table table-bordered'>";
 $html.="
  
<tbody>
<tr>
        <td class='ft1' style='text-align:center;' rowspan=2><br/><br/><br/><br/><b>Nº</b></td>
        <td class='ft1' style='text-align:center;' rowspan=2><br/><br/><br/><br/><b>Nº de agente</b></td>
        <td class='ft1' style='text-align:center;' rowspan=2><br/><br/><br/><br/><b>Nome completo</b></td>
        <td class='ft1' style='text-align:center;' rowspan=2><br/><br/><br/><br/><b>Categoria</b></td>
        <td style='border-top:1px solid #fff; text-align:center; font-size:12px; font-family:arial; color: #002a80;
 border-right: 1px solid #002a80; border-bottom: 0px solid #002a80;'></td>        
        <td colspan=4 class='ft1'></td>
        <td class='ft1' style='text-align:center;' colspan=10><b>Doenças</b></td>
        </tr>";



$html.="
    <tr text-rotate='90'>
    <td  style='border-top:1px solid #fff; text-align:center; font-size:12px; font-family:arial; color: #002a80;
 border-right: 1px solid #002a80; border-bottom: 1px solid #002a80;'>Alínea a</td>
    <td class='ft2' >Alínea a</td>
    <td class='ft2'>Art.º 16 Alinea B</td>
    <td class='ft2'>Arti º15 nº 2</td>
    <td class='ft2'>Arti. 15 Nº 3</td>
    <td class='ft2'>Licença de Doença</td>
    <td class='ft2'>Licença de parto</td>
    <td class='ft2'>Licença de nasc. Do filho</td>
    <td class='ft2'>Licença de Casado</td>
    <td class='ft2'>Licença p/parto</td>
    <td class='ft2'>Licença disciplinar</td>
    <td class='ft2'>Licença registada</td>
<td class='ft2'>Licença Limitada</td>
<td class='ft2'>Total de Faltas a descontar</td>
<td class='ft2'>Dias de Efectividade</td>
    
    </tr>
       "; 

$html.="
      <tr>
      <td class='ft2'>1</td>
      <td class='ft2'>2</td>
      <td class='ft2'>3</td>
      <td class='ft2'>4</td>
      <td class='ft2'>5</td>
      <td class='ft2'>6</td>
      <td class='ft2'>7</td>
      <td class='ft2'>8</td>
      <td class='ft2'>9</td>
      <td class='ft2'>10</td>
      <td class='ft2'>11</td>
      <td class='ft2'>12</td>
      <td class='ft2'>13</td>
      <td class='ft2'>14</td>
      <td class='ft2'>15</td>
      <td class='ft2'>16</td>
      <td class='ft2'>17</td>
      <td class='ft2'>18</td>
      <td class='ft2'>19</td>
     
      </tr>
        ";

 $sql="select *from view_professor order by nome asc";
 $run22=$con->prepare($sql);
 $run22->execute();
 $a=0;
 
 $soma_Faltas = "";
$cont22 = "";
$estado="ativo";
 while ($view=$run22->fetch(PDO::FETCH_OBJ)){
     $a++;

$html.="
      <tr>
      <td class='ft3'>".$a.".</td>
      <td class='ft3'>".$view->nAgente."</td>
      <td class='ft3'>".$view->nome."</td>
      <td class='ft3'>".$view->categoria_estudo."</td>
      <td class='ft3'></td>
      <td class='ft3'></td>
      <td class='ft3'></td>
      <td class='ft3'></td>
      <td class='ft3'></td>
      <td class='ft3'></td>
      <td class='ft3'></td>
      <td class='ft3'></td>
      <td class='ft3'></td>
      <td class='ft3'></td>
      <td class='ft3'></td>
      <td class='ft3'></td>
      <td class='ft3'></td>
      <td class='ft3'></td>";



$sql2 = "select *from view_faltas_prof where id_professor=:id_professor and ano=:ano and mes=:mes and estado=:estado order by nome asc";
$run2 = $con->prepare($sql2);
$run2->bindParam(":id_professor", $view->id_professor, PDO::PARAM_STR);
$run2->bindParam(":ano", $ano, PDO::PARAM_STR);
$run2->bindParam(":mes", $mes, PDO::PARAM_STR);
$run2->bindParam(":estado", $estado, PDO::PARAM_STR);
$run2->execute();
$cont22 = $run2->rowCount();

if($cont22>22):
  $soma_Faltas = $cont22-22;  
elseif($cont22<22):
    $soma_Faltas = 22-$cont22;
endif;


      $html.="<td class='ft3'>".$soma_Faltas."</td>";
     
      $html.="</tr>
        ";

 }

        $html.=" <tbody>"
                . "</table></div>";

$html.="<div class='texto'>


<div style='text-align:center;'>
<span style='font-family:arial; font-weight:bold; font-style: italic;'>Huambo aos ".$string2[0]." de ".$mes2." de ".$string2[2]."<br/><br/><br/></span>
<br/>
A DIRECTORA<br/>
______________________________<br/>
 LIC. ARMANDA MARIA EDUARDO
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
