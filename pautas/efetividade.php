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
<div class='cabe'>

<img src='logo.png' style='height:50px; width:50px;'/>
<br/><br/>
REPÚBLICA DE ANGOLA<br/>
GOVERNO DA PROVÍNCIA DO HUAMBO<br/>
DIRECÇÃO PROVINCIAL DA EDUCAÇÃO, CIÊNCIA E TECNOLOGIA<br/>
COMPLEXO ESCOLAR LAR DOS PEQUENINOS DAS IRMÃS DO SANTÍSSIMO <br/>SALVADOR-HUAMBO<br/>
</div><br/><br/>

<div class='desig'>MAPA DE EFECTIVIDADE DOS TRABALHADORES REFERENTE AO MÊS DE ".strtoupper($mes)." ".$ano."</div><br/><br/>

";
$html.="<table border=1 style='width:100%'>";
 $html.="
  

<tr>
        <td class='ft1' rowspan=2>Nº</td>
        <td class='ft1' rowspan=2>Nº DE AGENTE</td>
        <td class='ft1' rowspan=2>NOME COMPLETO</td>
        <td class='ft1' rowspan=2>CATEGORIA</td>
        <td colspan=31>DIAS DE EFECTIVIDADE</td>
        </tr>";
 $html.="
     <tr>
     
     <td>1</td>
     <td>2</td>
     <td>3</td>
     <td>4</td>
     <td>5</td>
     <td>6</td>
     <td>7</td>
     <td>8</td>
     <td>9</td>
     <td>10</td>
     <td>11</td>
     <td>12</td>
     <td>13</td>
     <td>14</td>
     <td>15</td>
     
    <td>16</td>
     <td>17</td>
     <td>18</td>
     <td>19</td>
     <td>20</td>
     <td>21</td>
     <td>22</td>
     <td>23</td>
     <td>24</td>
     <td>25</td>
     <td>26</td>
     <td>27</td>
     <td>28</td>
     <td>29</td>
     <td>30</td>
     <td>31</td>
     </tr>
         ";
 $sql="select *from view_professor order by nome asc";
 $run22=$con->prepare($sql);
 $run22->execute();
 $a=0;
$estado="ativo";
 while ($view=$run22->fetch(PDO::FETCH_OBJ)){
     $a++;
 $html.="
     <tr>
     <td>".$a."</td>
     <td>".$view->nAgente."</td>
     <td>".$view->nome."</td>
     <td>".$view->categoria_estudo."</td>";
for($a2=1;$a2<=31; $a2++){
    $r="select *from view_faltas_prof where id_professor=:id_prof and ano=:ano and dia=:dia and mes=:mes and estado=:estado order by nome asc";
    $r2=$con->prepare($r);
    $r2->bindParam(":id_prof",$view->id_professor,  PDO::PARAM_STR);
    $r2->bindParam(":ano",$ano,  PDO::PARAM_STR);
    $r2->bindParam(":dia",$a2,  PDO::PARAM_STR);
    $r2->bindParam(":mes",$mes,  PDO::PARAM_STR);
    $r2->bindParam(":estado",$estado,  PDO::PARAM_STR);
    $r2->execute();
    $cont=$r2->rowCount();
    if($cont>0):
        $cont2=$cont;
        else :
           $cont2="---"; 
        endif;
 $html.="<td style='color:red; font-weight:bold;'>{$cont2}</td>";
 }
 $html.="
</tr>
 ";}
 
 
        $html.="</table>";

$html.="<div class='texto'>


<br/><br/>
<br/>
<div style='text-align:center;'>Huambo aos ".$string2[0]." de ".$mes2." de ".$string2[2]."<br/><br/><br/>
<br/>
<br/>
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
