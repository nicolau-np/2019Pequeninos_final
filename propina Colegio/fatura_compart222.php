<?php
ob_start();
session_start();
include_once 'conn2.php';
include_once 'classes/Comparticipacao.php';
include_once 'classes/Historico.php';

$id_pai = addslashes(htmlspecialchars($_POST['id_pai']));
$ano_lectivo = addslashes(htmlspecialchars($_POST['anoLetivo']));
$valor = addslashes(htmlspecialchars($_POST['valor']));
$usuario=$_SESSION['nomeS'];
$data = date("d-m-Y");
$hora = date("H:i:s");
$cliente = addslashes(htmlspecialchars($_POST['cliente']));


$pri="select *from tbl_fatura order by id_fatura desc";
$vbi=$con2->prepare($pri);
$vbi->execute();
$cc=$vbi->fetch(PDO::FETCH_OBJ);
if(($cc->ano!=$ano_lectivo)&&($cc->numero>0))
{
$som=1;
$ins="insert into tbl_fatura(numero,ano) values(:numero,:ano)";
$reve=$con2->prepare($ins);
$reve->bindParam(":numero",$som,PDO::PARAM_STR);
$reve->bindParam(":ano",$ano_lectivo,PDO::PARAM_STR);
$reve->execute();
if(!$reve)
{
    echo "erro";
}
else
{
  $numero_fatura=$ano_lectivo."".date("md")."".$som;   
}
   
}
elseif(($cc->ano==$ano_lectivo))
{
$sele="select *from tbl_fatura order by id_fatura desc";
$rvb=$con2->prepare($sele);
$rvb->execute();
$comt=$rvb->fetch(PDO::FETCH_OBJ);
$som=$comt->numero+1;
$ins="insert into tbl_fatura(numero,ano) values(:numero,:ano)";
$reve1=$con2->prepare($ins);
$reve1->bindParam(":numero",$som,PDO::PARAM_STR);
$reve1->bindParam(":ano",$ano_lectivo,PDO::PARAM_STR);
$reve1->execute();
$numero_fatura=$ano_lectivo."".date("md")."".$som;   
}

$a=0;
foreach($_POST['epoca'] as $epocas)
{
    $a++;
}

$total_pagamento=$a*$valor;



$estado="on";
foreach($_POST['epoca'] as $epocas)
{
    $com="select *from  tbl_comp_pais where id_pai=:id and epoca=:epoca and data_pagamento=:data and ano=:ano";
    $ru1=$con2->prepare($com);
    $ru1->bindParam(":id",$id_pai,PDO::PARAM_STR);
    $ru1->bindParam(":epoca",$epocas,PDO::PARAM_STR);
    $ru1->bindParam(":data",$data,PDO::PARAM_STR);
    $ru1->bindParam(":ano",$ano_lectivo,PDO::PARAM_STR);
    $ru1->execute();
    $cont=$ru1->rowCount();
    if($cont>0){
        
    }
    else{
    $com2="insert into tbl_comp_pais (id_pai,epoca,data_pagamento,ano,usuario,cliente,valor) "
            . "values(:id_pai, :epoca, :data_pagamento, :ano, :usuario, :cliente, :valor)";
    $ru2=$con2->prepare($com2);
    $ru2->bindParam(":id_pai",$id_pai,PDO::PARAM_STR);
    $ru2->bindParam(":epoca",$epocas,PDO::PARAM_STR);
    $ru2->bindParam(":data_pagamento",$data,PDO::PARAM_STR);
    $ru2->bindParam(":ano",$ano_lectivo,PDO::PARAM_STR);
    $ru2->bindParam(":usuario",$usuario,PDO::PARAM_STR);
    $ru2->bindParam(":cliente",$cliente,PDO::PARAM_STR);
    $ru2->bindParam(":valor",$valor,PDO::PARAM_STR);
    $ru2->execute();  
    }
}


$objHistorico = new Historico();
$objComp = new Comparticipacao();
$objComp->setCon($con2);
$objComp->setAno_lectivo($ano_lectivo);
$objComp->setId_pai($id_pai);
$objHistorico->setCon($con2);
?>


<?php

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
<B>{$cliente}</B><br/>
<b>HUAMBO-ANGOLA</b>
</div>
<br/>
<br/>
<div class='ely'>
<table border='0' class='nm'>
<tr>
<td colspan='2' id='pi'><b>COMPARTICIPAÇÃO DE ENCARREGADOS</b></td>
</tr>
<tr>
<td id='sec'>Fact. Nº: {$numero_fatura}</td>
<td>Data: {$data} <br/> {$hora}</td>
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
<td  class='vfg'>Ano Lectivo</td>";


        
$html.="</tr>
";

$res2 = $objComp->buscaIDAlunos();
while($viewIDsAluno1 = $res2->fetch(PDO::FETCH_OBJ)):
    
$objHistorico->setId_aluno($viewIDsAluno1->id_aluno);
$objHistorico->setAno_lectivo($ano_lectivo);
$resHisto = $objHistorico->BuscaHisto();

if($resHisto!="no"):
$viewHisto = $resHisto->fetch(PDO::FETCH_OBJ);

$html.="<tr>
<td class='vfk'>{$viewHisto->id_aluno}</td>
<td class='vfk'>{$viewHisto->nome}</td>
<td class='vfk'>{$viewHisto->curso}</td>
<td class='vfk'>{$viewHisto->classe}</td>
<td class='vfk'>{$viewHisto->turma}</td>
<td class='vfk'>{$viewHisto->turno}</td>
<td>{$ano_lectivo}</td>";
$html.="</tr>";
endif;
endwhile;

$html.="</table>
    <br/>
    <table border='0' id='iop'>
    <tr>
    <td>Trimestres Pagos</td>
    <td>Valor Pago</td>
    </tr>
    ";
    foreach($_POST['epoca'] as $epocas){

    $com="select *from tbl_comp_pais where id_pai=:id  and epoca=:epoca and ano=:ano";
    $ru1=$con2->prepare($com);
    $ru1->bindParam(":id",$id_pai,PDO::PARAM_STR);
    $ru1->bindParam(":epoca",$epocas,PDO::PARAM_STR);
    $ru1->bindParam(":ano",$ano_lectivo,PDO::PARAM_STR);
    $ru1->execute();
      $v33=$ru1->fetch(PDO::FETCH_OBJ);
       $a80=1;
    $html.="<tr>
        <td  class='vfg'>{$epocas}º Trimestre</td>
            <td  class='vfg'>{$v33->valor},00</td>
                
           </tr>";
$a80++;
}



$html.="</table>
    <br/>
    <span style='font-weight:bold; font-family:arial; forn-size:13px;'>Total Geral: ".$total_pagamento.",00</span>
</div>
<br/>
";



$html.="

<br/>
<pre>
      Encarregado                                           Secretaria
_______________________                               ______________________
                                                              
----------------------------------------------------------------------------</pre>

";

$html.="<div class='ely'>
<table border='0' class='nm'>
<tr>
<td colspan='2' id='pi'><b>COMPARTICIPAÇÃO DE ENCARREGADOS</b></td>
</tr>
<tr>
<td id='sec'>Fact. Nº: {$numero_fatura}</td>
<td>Data: {$data} <br/> {$hora}</td>
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
<td  class='vfg'>Ano Lectivo</td>";


        
$html.="</tr>
";
$res3 = $objComp->buscaIDAlunos();
while($viewIDsAluno3 = $res3->fetch(PDO::FETCH_OBJ)):
    
$objHistorico->setId_aluno($viewIDsAluno3->id_aluno);
$objHistorico->setAno_lectivo($ano_lectivo);
$resHisto3 = $objHistorico->BuscaHisto();
if($resHisto3!="no"):
$viewHisto3 = $resHisto3->fetch(PDO::FETCH_OBJ);

$html.="<tr>
<td class='vfk'>{$viewHisto3->id_aluno}</td>
<td class='vfk'>{$viewHisto3->nome}</td>
<td class='vfk'>{$viewHisto3->curso}</td>
<td class='vfk'>{$viewHisto3->classe}</td>
<td class='vfk'>{$viewHisto3->turma}</td>
<td class='vfk'>{$viewHisto3->turno}</td>
<td>{$ano_lectivo}</td>";
$html.="</tr>";

endif;
endwhile;

$html.="</table>
    <br/>
    <table border='0' id='iop'>
    <tr>
    <td>Trimestres Pagos</td>
    <td>Valor Pago</td>
    </tr>
    ";
   foreach($_POST['epoca'] as $epocas){

    $com="select *from tbl_comp_pais where id_pai=:id  and epoca=:epoca and ano=:ano";
    $ru1=$con2->prepare($com);
    $ru1->bindParam(":id",$id_pai,PDO::PARAM_STR);
    $ru1->bindParam(":epoca",$epocas,PDO::PARAM_STR);
    $ru1->bindParam(":ano",$ano_lectivo,PDO::PARAM_STR);
    $ru1->execute();
      $v33=$ru1->fetch(PDO::FETCH_OBJ);
       $a80=1;
    $html.="<tr>
        <td  class='vfg'>{$epocas}º Trimestre</td>
            <td  class='vfg'>{$v33->valor},00</td>
                
           </tr>";
$a80++;
}

    $html.="
    </table>
   <br/>
    <span style='font-weight:bold; font-family:arial; forn-size:13px;'>Total Geral: ".$total_pagamento.",00</span> 
</div>
<br/>
";



$html.="

<br/>
<pre>
      Encarregado                                           Secretaria
_______________________                               ______________________
                                                              
----------------------------------------------------------------------------</pre>

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
