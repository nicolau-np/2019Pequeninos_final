<?php
ob_start();
session_start();
include("validarlogin.php");
require_once("config/conn.php");
$id_aluno=$_GET['id_aluno'];
$id_pessoa=$_GET['id_pessoa'];




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

</div>
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