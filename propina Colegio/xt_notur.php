<?php
ob_start();
session_start();
require_once("conn2.php");

$processo=$_SESSION['processo99'];
$ano=$_SESSION['ano99'];

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
<div class='cabe'>
<img src='assets/img/as.jpg' width='50px' height='50px'/><br/>
<strong>REPÚBLICA DE ANGOLA</strong><br/>
<strong>MINISTÉRIO DA EDUCAÇÃO CIÊNCIA E TECNOLOGIA</strong><br/>
<strong>ESCOLA PRIMÁRIA E Iº CÍCLO LAR DOS PEQUENINOS <BR/>DAS IRMÃS DO SANTÍSSIMO SALVADOR-HUAMBO</strong><br/>

</div><br/><br/>

<div class='desig'>EXTRATO</div><br/><br/>
<div class='tb'>
";

$co="select *from view_historico where id_aluno=:processo and anolectivo=:ano";
try
{
  $result=$con2->prepare($co);
  $result->bindParam(":processo",$processo,PDO::PARAM_STR);
    $result->bindParam(":ano",$ano,PDO::PARAM_STR);
  $result->execute();  
  $mostra=$result->fetch(PDO::FETCH_OBJ);
}
catch(PDOException $e)
{
    echo $e;
}
$html.="
<div class='dados_a'>
<table border='0' id='iop'>
<tr>
<td  class='vfg'>Nº Processo</td>
<td  class='vfg'>Nome Completo</td>
<td  class='vfg'>Curso</td>
<td  class='vfg'>Classe</td>
<td  class='vfg'>Turma</td>
<td  class='vfg'>Turno</td>
<td  class='vfg'>Ano Lectivo</td>
</tr>
<tr>
<td class='vfk'>{$mostra->id_aluno}</td>
<td class='vfk'>{$mostra->nome}</td>
    <td class='vfk'>{$mostra->curso}</td>
<td class='vfk'>{$mostra->classe}</td>
<td class='vfk'>{$mostra->turma}</td>
<td class='vfk'>{$mostra->turno}</td>
<td>$ano</td>

</tr>
</table>
</div>

<br/>


<table border='0' width='500' class='bnmm'>
<tr>
<th class='vfg'>Trimestre</th>
<th class='vfg'>Propina</th>
<th class='vfg'>Multa</th>
<th class='vfg'>Data do pagamento</th>
</tr>
";

$command="select *from ver where id_aluno=:processo and ano_lectivo=:ano";
$result=$con2->prepare($command);
 $result->bindParam(":processo",$processo,PDO::PARAM_STR);
  $result->bindParam(":ano",$ano,PDO::PARAM_STR);
  $result->execute();  
while($most=$result->fetch(PDO::FETCH_OBJ))
{
    $se1="select *from tbl_multas where id_aluno=:id and ano_lectivo=:ano and mes_multa=:mes";
     $exe1=$con2->prepare($se1);
     $exe1->bindParam(":id",$processo,  PDO::PARAM_STR);
     $exe1->bindParam(":ano",$ano,  PDO::PARAM_STR);
     $exe1->bindParam(":mes", $most->mes, PDO::PARAM_STR);
     $exe1->execute();
     $cont22=$exe1->rowCount();
     $view_M=$exe1->fetch(PDO::FETCH_OBJ);
     if($cont22>0):
         $va=$view_M->valor_pago;
     else:
         $va=0;
     endif;
    $html.="
    <tr>
    <td class='fafa1'>{$most->mes}º Trimestre</td>
    <td class='fafa1'>{$most->valor},00</td>
    <td class='fafa1'>{$va},00</td>
    <td>{$most->data_pagamento}</td>
    </tr>
    ";
}



$html.="
</table>";

$co="SELECT SUM(valor) FROM tbl_pagamento where id_aluno=:ida and ano_lectivo=:ano";
$exe=$con2->prepare($co);
$exe->bindParam(":ida",$processo,PDO::PARAM_STR);
$exe->bindParam(":ano",$ano,PDO::PARAM_STR);
$exe->execute();
$propinaS=$exe->fetchColumn();

$se2="SELECT SUM(valor_pago) FROM tbl_multas where id_aluno=:id and ano_lectivo=:ano";
$run2=$con2->prepare($se2);
$run2->bindParam(":id",$processo,  PDO::PARAM_STR);
$run2->bindParam(":ano",$ano,  PDO::PARAM_STR);
$run2->execute();
$soma=$run2->fetchColumn();

$html.="
<span style='font-family:arial; weight:bold;'>Total Geral: ".($propinaS + $soma).",00</span>    
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<pre>
                               Secretaria
                      __________________________
</pre>
</body>
</html>";

include("mpdf/mpdf.php");
$mpdf=new mPDF('c','A4'); 
$mpdf->WriteHTML($html);
$mpdf->Output();
exit;

?>