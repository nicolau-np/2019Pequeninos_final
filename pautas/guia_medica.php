<?php
ob_start();
session_start();
include("validarlogin.php");
require_once("config/conn.php");
$id=$_GET['id_user'];


$co="select *from view_professor where id_professor=:id";
$exe=$con->prepare($co);
$exe->bindParam(":id",$id,PDO::PARAM_STR);
$exe->execute();
$mostra=$exe->fetch(PDO::FETCH_OBJ);


$html="<html>
<head><title></title>
<style>
.cabe
{
   font-weight:bold;
   text-align:center; 
    }
    .b
    {
        text-align:center;
       
        }
        .desig
        {
            font-weight:bold;
   text-align:center; 
            }
              .design
        {
   text-align:center; 
            }

           
</style>

</head>
<body>
<div class='cabe'>
<img src='logo.png' style='height:50px; width:50px;'/>
<br/><br/>
REPÚBLICA DE ANGOLA<br/>
GOVERNO DA PROVÍNCIA DO HUAMBO<br/>
DIRECÇÃO PROVINCIAL DA EDUCAÇÃO CIÊNCIA E TECNOLOGIA<br/>
<strong>ESCOLA PRIMÁRIA E Iº CÍCLO LAR DOS PEQUENINOS <BR/>DAS IRMÃS DO SANTÍSSIMO SALVADOR-HUAMBO</strong><br/>
</div><br/><br/>

<div class='desig'>GUIA MEDICA Nº ".date('d/m/Y')."</div><br/><br/>

";
$html.="Vai apresentar-se à consulta externa, do Hospital Regional do Huambo.<br/>
        Nome do Beneficiário(a) ".$mostra->nome.
        "<br/>Categoria: ".$mostra->categoria_estudo.
        "<br/><br/>
        <div class='desig'><b>ELEMENTOS REFERENTES AO BENEFICIÁRIO</b></div>" ;
$strings=$mostra->data_nascimento;
$string=explode("-",$strings);
$idade=date("Y") - $string[0];
$html.="<div class='texto'>
<br/>
<b>Filiação</b><br/>
Pai: ".$mostra->pai."<br/>
Mãe: ".$mostra->mae."<br/>
<br/>
<b>Naturalidade</b><br/>
Município: ".$mostra->municipio."<br/>
Província: ".$mostra->provincia."<br/>
Idade: ".$idade." Anos<br/>  
Gênero: ".$mostra->genero."<br/>
<br/>
<p align='center'>
A DIRECTORA<br/>
________________________________<br/>
Lic. Armanda Maria Eduardo<br/><br/>
</p>
.........................................................................................................................................................................................<br/><br/>
PRESCRIÇÃO MÉDICA: ____________________________________________________________________________________________<br/>
____________________________________________________________________________________________<br/>
____________________________________________________________________________________________<br/>
____________________________________________________________________________________________<br/>
____________________________________________________________________________________________<br/>
____________________________________________________________________________________________<br/>
____________________________________________________________________________________________<br/>
Aos ______/_______________/20______.<br/><br/><br/>
<p align='center'>
O MÉDICO<br/>
_______________________
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
