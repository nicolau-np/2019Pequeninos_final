<?php
ob_start();
session_start();
require_once("conn2.php");
$curso=$_GET['curso'];
$classe=$_GET['classe'];
$turma=$_GET['turma'];
$turno=$_GET['turno'];
$ano=$_GET['anoS'];

	$mes1=1;
	$mes2=2;
	$mes3=3;
  




$html="<html>
<head><title></title>
<style>
.cabe
{
   font-family:arial; 
   font-size:12px;
   text-align:center;
    }
    .el{
 margin-left:460px;
 margin-top:-80px; 
     font-family:arial;
     border:1px solid #000;
     padding-left:3px;
     padding-top:2px; 
     padding-bottom:2px;
        }
        
        .nm{ 
     font-family:arial;
     border: 1px solid #000;
     background-color:#f5f5f5;
     
        }
        #pi
        {
            padding-top:5px;
            padding-bottom:5px;
         border-bottom: 1px solid #000;
         text-align:center;   
            }
            #sec
            {
         border-right: 1px solid #000;
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

       #iop
       {
        font-family:arial;
        font-size:12px;
        width:100%;
        border:1px solid #000;
        }
        .table1
        {
           border: 1px solid #000;
           font-family:arial;
           font-size:12px; 
            }
            .cvb
            {
               border-bottom:1px solid #000;
               background-color:#f5f5f5; 
                }
                 .bn
            {
               border-top:1px solid #000;
               background-color:#f5f5f5; 
                }
                .vfg
                {
                  border-bottom:1px solid #000;
                   background-color:#f5f5f5;
                    }
                    
  .vfg1
                {
                  border-top:1px solid #000;
                   background-color:#f5f5f5;
                   font-size: 13px;
                   font-family:arial;
                   font-weight:bold;
                    }
                    .vfk
                {
                  border-right:1px solid #000;
                    }
                    #fafa
                    {
                        border:1px solid #000;
                        font-family:arial;
                        background-color:#f5f5f5;
                        
                        }
                    .fafa1
                    {
                        border-right:1px solid #000;
                        }   
                        .desig
                        {
                           font-family:arial;
                            
                            }
                            .bnmm
                            {
                                border: 1px solid #000;
                                font-family:arial;
                                font-size:12px;
                                }

           
</style>

</head>
<body>
<br/>
<div class='cabe'>
<img src='assets/img/as.jpg' width='50px' height='50px'/><br/>
<strong>REPÚBLICA DE ANGOLA</strong><br/>
<strong>MINISTÉRIO DA EDUCAÇÃO CIÊNCIA E TECNOLOGIA</strong><br/>
<strong>ESCOLA PRIMÁRIA E Iº CÍCLO LAR DOS PEQUENINOS <BR/>DAS IRMÃS DO SANTÍSSIMO SALVADOR-HUAMBO</strong><br/>
</div><br/><br/>
<div class='desig'>LISTA QUOTA DE PAIS - ".$ano."</div><br/>



<br/>
<div class='tb'>";


$html.="<table border=0 width='700' class='bnmm'>
<tr>
<th class='vfg'>Nº</th>
<th class='vfg' width='200px'>Nome do encarregado</th>
<th class='vfg'>1º Trimestre</th>
<th class='vfg'>2º Trimestre</th>
<th class='vfg'>3º Triemestre</th>

</tr>
";
$command1="SELECT DISTINCT nome_pai FROM view_financeiros order by nome_pai asc";
$result1=$con2->prepare($command1);
$result1->execute();  
  $a=0;
while($rt1=$result1->fetch(PDO::FETCH_OBJ)){
 $a++; 
 $html.="
<tr>
<td class='vfk'>$a</td>
<td class='vfk'>{$rt1->nome_pai}</td>
";

$epoca1Selete = "select *from view_comp_pais where nome_pai = :nome_pai and ano = :ano and epoca = :epoca";
$execuE1 = $con2->prepare($epoca1Selete);
$execuE1->bindParam(":nome_pai", $rt1->nome_pai, PDO::PARAM_STR);
$execuE1->bindParam(":ano", $ano, PDO::PARAM_STR);
$execuE1->bindParam(":epoca", $mes1, PDO::PARAM_STR);
$execuE1->execute();
$contE1 = $execuE1->rowCount();
$viewE1 = $execuE1->fetch(PDO::FETCH_OBJ);
if($contE1 == 0):
    $exibeE1 = "---";
else:
    $exibeE1 = $viewE1->valor.",00";
endif;


$execuE2 = $con2->prepare($epoca1Selete);
$execuE2->bindParam(":nome_pai", $rt1->nome_pai, PDO::PARAM_STR);
$execuE2->bindParam(":ano", $ano, PDO::PARAM_STR);
$execuE2->bindParam(":epoca", $mes2, PDO::PARAM_STR);
$execuE2->execute();
$contE2 = $execuE2->rowCount();
$viewE2 = $execuE2->fetch(PDO::FETCH_OBJ);
if($contE2 == 0):
    $exibeE2 = "---";
else:
    $exibeE2 = $viewE2->valor.",00";
endif;


$execuE3 = $con2->prepare($epoca1Selete);
$execuE3->bindParam(":nome_pai", $rt1->nome_pai, PDO::PARAM_STR);
$execuE3->bindParam(":ano", $ano, PDO::PARAM_STR);
$execuE3->bindParam(":epoca", $mes3, PDO::PARAM_STR);
$execuE3->execute();
$contE3 = $execuE3->rowCount();
$viewE3 = $execuE3->fetch(PDO::FETCH_OBJ);
if($contE3 == 0):
    $exibeE3 = "---";
else:
    $exibeE3 = $viewE3->valor.",00";
endif;


$html.="
<td class='vfk'>".$exibeE1."</td>
<td class='vfk'>".$exibeE2."</td>
<td class=''>".$exibeE3."</td>
";


 $html.="</tr>";
 
 
}

$sele11 = "select sum(valor) from view_comp_pais where ano = :ano and epoca = :epoca";
$exibe11 = $con2->prepare($sele11);
$exibe11->bindParam(":ano", $ano, PDO::PARAM_STR);
$exibe11->bindParam(":epoca", $mes1, PDO::PARAM_STR);
$exibe11->execute();
$soma1 = $exibe11->fetchColumn();


$exibe12 = $con2->prepare($sele11);
$exibe12->bindParam(":ano", $ano, PDO::PARAM_STR);
$exibe12->bindParam(":epoca", $mes2, PDO::PARAM_STR);
$exibe12->execute();
$soma2 = $exibe12->fetchColumn();

$exibe13 = $con2->prepare($sele11);
$exibe13->bindParam(":ano", $ano, PDO::PARAM_STR);
$exibe13->bindParam(":epoca", $mes3, PDO::PARAM_STR);
$exibe13->execute();
$soma3 = $exibe13->fetchColumn();


$html.="
<tr>
<td colspan=2 class='vfg1'>TOTAIS</td>
<td class='vfg1'>".$soma1.",00</td>
<td class='vfg1'>".$soma2.",00</td>
<td class='vfg1'>".$soma3.",00</td>
</tr>
</table>
<br/>
<span class='vfg1'>TOTAL GERAL:  ".($soma1 + $soma2 + $soma3).",00</span>
</body>
</html>";

include("mpdf/mpdf.php");
$mpdf=new mPDF('c','A4'); 
$mpdf->WriteHTML($html);
$mpdf->Output();
exit;

?>
