<?php
ob_start();
session_start();
require_once("conn2.php");
$processo=$_SESSION['processo34'];
$anoLE=$_GET['anoLE'];
$id=$_GET['id'];
$hora=$_GET['hora'];
$data=$_GET['data'];
$nfatura=$_GET['nfatura'];

$cliente="select *from tbl_pagamento where id_aluno=:id and nfatura=:n and ano_lectivo=:ano";
$ft=$con2->prepare($cliente);
$ft->bindParam(":id",$id,PDO::PARAM_STR);
$ft->bindParam(":n",$nfatura,PDO::PARAM_STR);
$ft->bindParam(":ano",$anoLE,PDO::PARAM_STR);
$ft->execute();
$ver=$ft->fetch(PDO::FETCH_OBJ);


$aluno="select *from view_historico where id_aluno=:pro and anolectivo=:ano";
$fte=$con2->prepare($aluno);
$fte->bindParam(":pro",$processo,PDO::PARAM_STR);
$fte->bindParam(":ano",$anoLE,PDO::PARAM_STR);
$fte->execute();
$vt=$fte->fetch(PDO::FETCH_OBJ);

$periodo=$vt->turno;
 
    $est="Mes";

$html="<html>
<head><title></title>
<style>
.cabe
{
   font-family:arial; 
   font-size:12px;
    }
    .el{
 margin-left:460px;
 margin-top:-80px; 
     font-family:arial;
     border:1px solid #000;
     padding-left:3px;
     padding-top:2px; 
     padding-bottom:2px;
     font-size:12px;
        }
        
        .nm{ 
     font-family:arial;
     border: 1px solid #000;
     background-color:#f5f5f5;
     font-size:12px;
     
        }
        #pi
        {
            padding-top:5px;
            padding-bottom:5px;
         border-bottom: 1px solid #000;
         text-align:center;
         font-size:12px;   
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
   font-size:12px;
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
        font-size:12px;
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
                        font-size:12px;
                        
                        }
                    #fafa1
                    {
                        border-right:1px solid #000;
                        }
</style>

</head>
<body>
<div class='cabe'>
<br/>
<strong>ESCOLA PRIMÁRIA E Iº CÍCLO LAR DOS PEQUENINOS <BR/>DAS IRMÃS DO SANTÍSSIMO SALVADOR-HUAMBO</strong><br/>
NIF: 5121019874<br/>
</div>
<div class='el'>
Exmo. Sr.<br/>
<B>{$ver->cliente}</B><br/>
<b>HUAMBO-ANGOLA</b>
</div>
<br/>
<br/>
<div class='ely'>
<table border='0' class='nm'>
<tr>
<td colspan='2' id='pi'><b>PAGAMENTO DE COMPARTICIPAÇÃO</b></td>
</tr>
<tr>
<td id='sec'>Fact. Nº: {$nfatura}</td>
<td>Data: {$ver->data_pagamento} <br/> {$ver->hora}</td>
</tr>
</table>
</div>
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
<td class='vfk'>{$vt->id_aluno}</td>
<td class='vfk'>{$vt->nome}</td>
    <td class='vfk'>{$vt->curso}</td>
<td class='vfk'>{$vt->classe}</td>
<td class='vfk'>{$vt->turma}</td>
<td class='vfk'>{$vt->turno}</td>
<td>{$anoLE}</td>
</tr>
</table>
</div>
<br/>
";

$html.="<table class='table1' id='vb' width='400'>
<tr>
<th class='cvb'>Trimestre</th>
<th class='cvb'>Propina</th>
<th class='cvb'>Multa</th>
</tr>";

    $tabela="select *from tbl_pagamento where id_aluno=:ida and nfatura=:fatura";
    $exe=$con2->prepare($tabela);
    $exe->bindParam(":ida",$id,PDO::PARAM_STR);
    $exe->bindParam(":fatura",$nfatura,PDO::PARAM_STR);
    $exe->execute();
    
   while($bt=$exe->fetch(PDO::FETCH_OBJ)) {
       $se1="select *from tbl_multas where id_aluno=:id and ano_lectivo=:ano and mes_multa=:mes";
     $exe1=$con2->prepare($se1);
     $exe1->bindParam(":id",$id,  PDO::PARAM_STR);
     $exe1->bindParam(":ano",$anoLE,  PDO::PARAM_STR);
     $exe1->bindParam(":mes", $bt->mes, PDO::PARAM_STR);
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
<td>{$bt->mes}</td>
<td>{$bt->valor},00</td>
<td>{$va},00</td>
</tr>
";
}

$co="SELECT SUM(valor) FROM tbl_pagamento where id_aluno=:ida and nfatura=:fatura";
$exe=$con2->prepare($co);
$exe->bindParam(":ida",$id,PDO::PARAM_STR);
$exe->bindParam(":fatura",$nfatura,PDO::PARAM_STR);
$exe->execute();
$propinaS=$exe->fetchColumn();

$se2="SELECT SUM(valor_pago) FROM tbl_multas where id_aluno=:id and ano_lectivo=:ano and data_pagamento=:data and hora=:hora";
$run2=$con2->prepare($se2);
$run2->bindParam(":id",$id,  PDO::PARAM_STR);
$run2->bindParam(":ano",$anoLE,  PDO::PARAM_STR);
$run2->bindParam(":data",$data,  PDO::PARAM_STR);
$run2->bindParam(":hora",$hora,  PDO::PARAM_STR);
$run2->execute();
$soma=$run2->fetchColumn();


$html.="
<tr>
<th class='bn'>Total</th>
<td class='bn'>$propinaS,00</td>
<td class='bn'>$soma,00</td>
</tr>
</table>
<span style='font-family:arial; weight:bold;'>Total Geral: ".($propinaS + $soma).",00</span>
<br/>
<pre>
      Encarregado                                           Secretaria
_______________________                               ______________________
 
----------------------------------------------------------------------------</pre>
";



$html.="<div class='ely'>
<table border='0' class='nm'>
<tr>
<td colspan='2' id='pi'><b>PAGAMENTO DE COMPARTICIPAÇÃO</b></td>
</tr>
<tr>
<td id='sec'>Fact. Nº: {$nfatura}</td>
<td>Data: {$ver->data_pagamento} <br/> {$ver->hora}</td>
</tr>
</table>
</div>
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
<td class='vfk'>{$vt->id_aluno}</td>
<td class='vfk'>{$vt->nome}</td>
<td class='vfk'>{$vt->curso}</td>
<td class='vfk'>{$vt->classe}</td>
<td class='vfk'>{$vt->turma}</td>
<td class='vfk'>{$vt->turno}</td>
<td>{$anoLE}</td>
</tr>
</table>
</div>
<br/>
";

$html.="<table class='table1' id='vb' width='400'>
<tr>
<th class='cvb'>Trimestre</th>
<th class='cvb'>Propina</th>
<th class='cvb'>Multa</th>
</tr>";

    $tabela="select *from tbl_pagamento where id_aluno=:ida and nfatura=:fatura";
    $exe=$con2->prepare($tabela);
    $exe->bindParam(":ida",$id,PDO::PARAM_STR);
    $exe->bindParam(":fatura",$nfatura,PDO::PARAM_STR);
    $exe->execute();
    
   while($bt=$exe->fetch(PDO::FETCH_OBJ)) {
              $se1="select *from tbl_multas where id_aluno=:id and ano_lectivo=:ano and mes_multa=:mes";
     $exe1=$con2->prepare($se1);
     $exe1->bindParam(":id",$id,  PDO::PARAM_STR);
     $exe1->bindParam(":ano",$anoLE,  PDO::PARAM_STR);
     $exe1->bindParam(":mes", $bt->mes, PDO::PARAM_STR);
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
<td>{$bt->mes}</td>
<td>{$bt->valor},00</td>
<td>{$va},00</td>
</tr>
";
}

$co="SELECT SUM(valor) FROM tbl_pagamento where id_aluno=:ida and nfatura=:fatura";
$exe=$con2->prepare($co);
$exe->bindParam(":ida",$id,PDO::PARAM_STR);
$exe->bindParam(":fatura",$nfatura,PDO::PARAM_STR);
$exe->execute();
$propinaS=$exe->fetchColumn();

$se2="SELECT SUM(valor_pago) FROM tbl_multas where id_aluno=:id and ano_lectivo=:ano and data_pagamento=:data and hora=:hora";
$run2=$con2->prepare($se2);
$run2->bindParam(":id",$id,  PDO::PARAM_STR);
$run2->bindParam(":ano",$anoLE,  PDO::PARAM_STR);
$run2->bindParam(":data",$data,  PDO::PARAM_STR);
$run2->bindParam(":hora",$hora,  PDO::PARAM_STR);
$run2->execute();
$soma=$run2->fetchColumn();

$html.="
<tr>
<th class='bn'>Total</th>
<td class='bn'>$propinaS,00</td>
<td class='bn'>$soma,00</td>
</tr>
</table>
<span style='font-family:arial; weight:bold;'>Total Geral: ".($propinaS + $soma).",00</span>
<br/>
<pre>
      Encarregado                                           Secretaria
_______________________                               ______________________
 </pre>

";





$html.="

</body>
</html>";

include("mpdf/mpdf.php");
$mpdf=new mPDF('c','A4'); 
$mpdf->WriteHTML($html);
$mpdf->Output();
exit;
?>
