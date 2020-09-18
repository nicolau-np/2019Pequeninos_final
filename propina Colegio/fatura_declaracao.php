<?php
ob_start();
session_start();
require_once("conn2.php");
$modo=$_POST['modo'];
$cliente=$_POST['cliente'];
$hora=date("H:i:s");
$ano=date("Y");
$data=date("d-m-Y");
$id_aluno=$_POST['id'];
$usuario=$_SESSION['nomeS'];
$string2=explode("-",$data);

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

$pri="select *from tbl_fatura order by id_fatura desc";
$vbi=$con2->prepare($pri);
$vbi->execute();
$cc=$vbi->fetch(PDO::FETCH_OBJ);
if(($cc->ano!=$ano)&&($cc->numero>0))
{
$som=1;
$ins="insert into tbl_fatura(numero,ano) values(:numero,:ano)";
$reve=$con2->prepare($ins);
$reve->bindParam(":numero",$som,PDO::PARAM_STR);
$reve->bindParam(":ano",$ano,PDO::PARAM_STR);
$reve->execute();
if(!$reve)
{
    echo "erro";
}
else
{
  $numero_fatura=$ano."".date("md")."".$som;   
}
   
}
elseif(($cc->ano==$ano))
{
$sele="select *from tbl_fatura order by id_fatura desc";
$rvb=$con2->prepare($sele);
$rvb->execute();
$comt=$rvb->fetch(PDO::FETCH_OBJ);
$som=$comt->numero+1;
$ins="insert into tbl_fatura(numero,ano) values(:numero,:ano)";
$reve1=$con2->prepare($ins);
$reve1->bindParam(":numero",$som,PDO::PARAM_STR);
$reve1->bindParam(":ano",$ano,PDO::PARAM_STR);
$reve1->execute();
$numero_fatura=$ano."".date("md")."".$som;   
}

$a=0;
foreach($_POST['tipo'] as $num)
{
    $a++;
}
if($modo=="Normal"){
  $valor=1000;  
}
else{
    $valor=1500;
}

$total_pagamento=$a*$valor;


$estado="on";
foreach($_POST['tipo'] as $num)
{
    $com="select *from tbl_pagamento_declaracao where id_aluno=:id and modo=:modo and tipo=:tipo and hora=:hora and data_pagamento=:data";
    $ru1=$con2->prepare($com);
    $ru1->bindParam(":id",$id_aluno,PDO::PARAM_STR);
    $ru1->bindParam(":modo",$modo,PDO::PARAM_STR);
    $ru1->bindParam(":tipo",$num,PDO::PARAM_STR);
    $ru1->bindParam(":hora",$hora,PDO::PARAM_STR);
    $ru1->bindParam(":data",$data,PDO::PARAM_STR);
    $ru1->execute();
    $cont=$ru1->rowCount();
    if($cont>0){
        
    }
    else{
        $com2="insert into tbl_pagamento_declaracao (id_aluno,modo,tipo,hora,data_pagamento,mes_pagamento,ano_lectivo,valor_pago,cliente,usuario,n_fatura,estado) values(:id,:modo,:tipo,:hora,:data,:mes_pagamento,:ano_lectivo,:valor_pago,:cliente,:usuario,:n_fatura,:estado)";
    $ru2=$con2->prepare($com2);
    $ru2->bindParam(":id",$id_aluno,PDO::PARAM_STR);
    $ru2->bindParam(":modo",$modo,PDO::PARAM_STR);
    $ru2->bindParam(":tipo",$num,PDO::PARAM_STR);
    $ru2->bindParam(":hora",$hora,PDO::PARAM_STR);
    $ru2->bindParam(":data",$data,PDO::PARAM_STR);
    $ru2->bindParam(":mes_pagamento",$mes2,PDO::PARAM_STR);
    $ru2->bindParam(":ano_lectivo",$ano,PDO::PARAM_STR);
    $ru2->bindParam(":valor_pago",$valor,PDO::PARAM_STR);
    $ru2->bindParam(":cliente",$cliente,PDO::PARAM_STR);
    $ru2->bindParam(":usuario",$usuario,PDO::PARAM_STR);
    $ru2->bindParam(":n_fatura",$numero_fatura,PDO::PARAM_STR);
    $ru2->bindParam(":estado",$estado,PDO::PARAM_STR);
    $ru2->execute();  
    }
}
$col="select *from view_historico where id_aluno=:pro and anolectivo=:ano";
try
{
    $result=$con2->prepare($col);
    $result->bindParam(":pro",$id_aluno,PDO::PARAM_STR);
	$result->bindParam(":ano",$ano,PDO::PARAM_STR);
    $result->execute();
 $vt=$result->fetch(PDO::FETCH_OBJ);

}
catch(PDOException $e)
{
    echo $e;
}




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
<td colspan='2' id='pi'><b>PAGAMENTO DE DECLARAÇÃO</b></td>
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
<td  class='vfg'>Ano Lectivo</td>
</tr>
<tr>
<td class='vfk'>{$vt->id_aluno}</td>
<td class='vfk'>{$vt->nome}</td>
<td class='vfk'>{$vt->curso}</td>
<td class='vfk'>{$vt->classe}</td>
<td class='vfk'>{$vt->turma}</td>
<td class='vfk'>{$vt->turno}</td>
<td>{$ano}</td>
</tr>
</table>
</div>
<br/>
";


$html.="<table class='table1' id='vb' width='500'>
<tr>
<th class='cvb'>Tipo</th>
<th class='cvb'>Modo</th>
<th class='cvb'>Valor Pago</th>

</tr>";

foreach($_POST['tipo'] as $num)
{
    $com="select *from tbl_pagamento_declaracao where id_aluno=:ida and tipo=:m and ano_lectivo=:an and hora=:hora";
    $exe=$con2->prepare($com);
    $exe->bindParam(":ida",$id_aluno,PDO::PARAM_STR);
    $exe->bindParam(":m",$num,PDO::PARAM_STR);
    $exe->bindParam(":an",$ano,PDO::PARAM_STR);
    $exe->bindParam(":hora",$hora,PDO::PARAM_STR);
    $exe->execute();
    
   while($bt=$exe->fetch(PDO::FETCH_OBJ)) {
        
$html.="
<tr>
<td>{$bt->tipo}</td>
<td>{$bt->modo}</td>
<td>{$bt->valor_pago},00</td>

</tr>
";
  }
}
$html.="
<tr>
<th class='bn'>Total</th>
<td class='bn'>----</td>";

$se2="SELECT SUM(valor_pago) FROM tbl_pagamento_declaracao where id_aluno=:id and ano_lectivo=:ano and data_pagamento=:data and hora=:hora";
$run2=$con2->prepare($se2);
$run2->bindParam(":id",$id_aluno,  PDO::PARAM_STR);
$run2->bindParam(":ano",$ano,  PDO::PARAM_STR);
$run2->bindParam(":data",$data,  PDO::PARAM_STR);
$run2->bindParam(":hora",$hora,  PDO::PARAM_STR);
$run2->execute();
$soma=$run2->fetchColumn();


$html.="<td class='bn'>$soma,00</td>
</tr>
</table>

<br/>
<pre>
      Encarregado                                           Secretaria
_______________________                               ______________________
                                                              
----------------------------------------------------------------------------</pre>

";

$html.="<div class='ely'>
<table border='0' class='nm'>
<tr>
<td colspan='2' id='pi'><b>PAGAMENTO DE DECLARAÇÃO</b></td>
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
<td  class='vfg'>Ano Lectivo</td>
</tr>
<tr>
<td class='vfk'>{$vt->id_aluno}</td>
<td class='vfk'>{$vt->nome}</td>
<td class='vfk'>{$vt->curso}</td>
<td class='vfk'>{$vt->classe}</td>
<td class='vfk'>{$vt->turma}</td>
<td class='vfk'>{$vt->turno}</td>
<td>{$ano}</td>
</tr>
</table>
</div>
<br/>
";


$html.="<table class='table1' id='vb' width='500'>
<tr>
<th class='cvb'>Tipo</th>
<th class='cvb'>Modo</th>
<th class='cvb'>Valor Pago</th>
</tr>";

foreach($_POST['tipo'] as $num)
{
        $com="select *from tbl_pagamento_declaracao where id_aluno=:ida and tipo=:m and ano_lectivo=:an and hora=:hora";
    $exe=$con2->prepare($com);
    $exe->bindParam(":ida",$id_aluno,PDO::PARAM_STR);
    $exe->bindParam(":m",$num,PDO::PARAM_STR);
    $exe->bindParam(":an",$ano,PDO::PARAM_STR);
    $exe->bindParam(":hora",$hora,PDO::PARAM_STR);
    $exe->execute();
    
   while($bt=$exe->fetch(PDO::FETCH_OBJ)) {
          
$html.="
<tr>
<tr>
<td>{$bt->tipo}</td>
<td>{$bt->modo}</td>
<td>{$bt->valor_pago},00</td>
</tr>
";
  }
}
$html.="
<tr>
<th class='bn'>Total</th>
<td class='bn'>----</td>";

$se2="SELECT SUM(valor_pago) FROM tbl_pagamento_declaracao where id_aluno=:id and ano_lectivo=:ano and data_pagamento=:data and hora=:hora";
$run2=$con2->prepare($se2);
$run2->bindParam(":id",$id_aluno,  PDO::PARAM_STR);
$run2->bindParam(":ano",$ano,  PDO::PARAM_STR);
$run2->bindParam(":data",$data,  PDO::PARAM_STR);
$run2->bindParam(":hora",$hora,  PDO::PARAM_STR);
$run2->execute();
$soma=$run2->fetchColumn();
$html.="<td class='bn'>$soma,00</td>
</table>
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
