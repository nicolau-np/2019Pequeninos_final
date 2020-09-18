<?php
ob_start();
session_start();
require_once("conn2.php");
$ano=$_POST['txt_ano'];
$hora=date("H:i:s");
$id=$_POST['txt_id'];
$processo=$_POST['processo'];
$cliente=$_POST['txt_cliente'];
$valor=$_POST['cb_valor'];
$n_boletim=$_POST['boletim'];
$forma_pagamento=$_POST['formapagamento'];
$banco=$_POST['banco'];
$data_pagamento_banco=$_POST['datapagamento'];
$valor_multa=$_POST['valor_multa'];


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
foreach($_POST['mes'] as $num)
{
    $a++;
}


$total_mes=$a;
$total=($_POST['cb_valor']*$total_mes);
$totalGeral=($_POST['cb_valor']*$total_mes);

$data=date('d-m-Y');
$usuario=$_SESSION['nomeS'];
$mu="nao";

$estado2="off";
foreach($_POST['mes'] as $num)
{
    $pago="sim";
    $command="update tbl_pagamento set pago=:pago,cliente=:cliente,data_pagamento=:data,usuario=:usuario,valor=:valor,valor_total=:total, nfatura=:fatura, hora=:hora, n_boletim=:n_boletim, forma_pagamento=:forma_pagamento, banco=:banco, data_pagamento_banco=:data_pagamento_banco where id_aluno=:id and mes=:num and ano_lectivo=:an";
try
{
 $result=$con2->prepare($command);
 $result->bindParam(":pago",$pago,PDO::PARAM_STR);
 $result->bindParam(":cliente",$cliente,PDO::PARAM_STR);
 $result->bindParam(":data",$data,PDO::PARAM_STR);
 $result->bindParam(":usuario",$usuario,PDO::PARAM_STR);
 $result->bindParam(":valor",$valor,PDO::PARAM_STR);
 $result->bindParam(":total",$total,PDO::PARAM_STR);
 $result->bindParam(":fatura",$numero_fatura,PDO::PARAM_STR);
 $result->bindParam(":hora",$hora,PDO::PARAM_STR);
 
 $result->bindParam(":n_boletim",$n_boletim,PDO::PARAM_STR);
 $result->bindParam(":forma_pagamento",$forma_pagamento,PDO::PARAM_STR);
 $result->bindParam(":banco",$banco,PDO::PARAM_STR);
 $result->bindParam(":data_pagamento_banco",$data_pagamento_banco,PDO::PARAM_STR);
 
 $result->bindParam(":id",$id,PDO::PARAM_STR);
 $result->bindParam(":num",$num,PDO::PARAM_STR);
  $result->bindParam(":an",$ano,PDO::PARAM_STR);
 $result->execute(); 
}
catch(PDOException $e)
{
    echo $e->getMessage();
}

}

foreach ($_POST['mes'] as $mes22){
    try {
        
 
     $up2="update tbl_multas set estado=:estado,valor_pago=:valor, data_pagamento=:data, hora=:hora where id_aluno=:id and ano_lectivo=:ano and mes_multa=:mes";
$run=$con2->prepare($up2);
$run->bindParam(":estado",$estado2,PDO::PARAM_STR);
$run->bindParam(":valor",$valor_multa,PDO::PARAM_STR);
$run->bindParam(":data",$data,PDO::PARAM_STR);
$run->bindParam(":hora",$hora,PDO::PARAM_STR);
$run->bindParam(":id",$id,  PDO::PARAM_STR);
$run->bindParam(":ano",$ano,  PDO::PARAM_STR);
$run->bindParam(":mes",$mes22,  PDO::PARAM_STR);
$run->execute();
   } catch (PDOException $e) {
       echo $e->getMessage();
    }

}


$col="select *from view_historico where id_aluno=:pro and anolectivo=:ano";
try
{
    $result=$con2->prepare($col);
    $result->bindParam(":pro",$processo,PDO::PARAM_STR);
	$result->bindParam(":ano",$ano,PDO::PARAM_STR);
    $result->execute();
 $vt=$result->fetch(PDO::FETCH_OBJ);
 $periodo=$vt->turno;

    $est="Mes";
   
 
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
<td colspan='2' id='pi'><b>PAGAMENTO DE COMPARTICIPAÇÃO</b></td>
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
<th class='cvb'>Trimestre</th>
<th class='cvb'>Propina</th>
<th class='cvb'>Multa</th>
</tr>";

foreach($_POST['mes'] as $num)
{
    $com="select *from tbl_pagamento where id_aluno=:ida and mes=:m and ano_lectivo=:an";
    $exe=$con2->prepare($com);
    $exe->bindParam(":ida",$id,PDO::PARAM_STR);
    $exe->bindParam(":m",$num,PDO::PARAM_STR);
    $exe->bindParam(":an",$ano,PDO::PARAM_STR);
    $exe->execute();
    
   while($bt=$exe->fetch(PDO::FETCH_OBJ)) {
        $se1="select *from tbl_multas where id_aluno=:id and ano_lectivo=:ano and mes_multa=:mes";
     $exe1=$con2->prepare($se1);
     $exe1->bindParam(":id",$id,  PDO::PARAM_STR);
     $exe1->bindParam(":ano",$ano,  PDO::PARAM_STR);
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
}
$html.="
<tr>
<th class='bn'>Total</th>
<td class='bn'>$total,00</td>";

 $se2="SELECT SUM(valor_pago) FROM tbl_multas where id_aluno=:id and ano_lectivo=:ano and data_pagamento=:data and hora=:hora";
$run2=$con2->prepare($se2);
$run2->bindParam(":id",$id,  PDO::PARAM_STR);
$run2->bindParam(":ano",$ano,  PDO::PARAM_STR);
$run2->bindParam(":data",$data,  PDO::PARAM_STR);
$run2->bindParam(":hora",$hora,  PDO::PARAM_STR);
$run2->execute();
$soma=$run2->fetchColumn();


$html.="<td class='bn'>$soma,00</td>
</tr>
</table>
<span style='font-family:arial; weight:bold;'>Total Geral: ".($total + $soma).",00</span>
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
<th class='cvb'>Trimestre</th>
<th class='cvb'>Propina</th>
<th class='cvb'>Multa</th>
</tr>";

foreach($_POST['mes'] as $num)
{
    $com="select *from tbl_pagamento where id_aluno=:ida and mes=:m and ano_lectivo=:an";
    $exe=$con2->prepare($com);
    $exe->bindParam(":ida",$id,PDO::PARAM_STR);
    $exe->bindParam(":m",$num,PDO::PARAM_STR);
    $exe->bindParam(":an",$ano,PDO::PARAM_STR);
    $exe->execute();
    
   while($bt=$exe->fetch(PDO::FETCH_OBJ)) {
     $se1="select *from tbl_multas where id_aluno=:id and ano_lectivo=:ano and mes_multa=:mes";
     $exe1=$con2->prepare($se1);
     $exe1->bindParam(":id",$id,  PDO::PARAM_STR);
     $exe1->bindParam(":ano",$ano,  PDO::PARAM_STR);
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
}
$html.="
<tr>
<th class='bn'>Total</th>
<td class='bn'>$total,00</td>";

    
$se2="SELECT SUM(valor_pago) FROM tbl_multas where id_aluno=:id and ano_lectivo=:ano and data_pagamento=:data and hora=:hora";
$run2=$con2->prepare($se2);
$run2->bindParam(":id",$id,  PDO::PARAM_STR);
$run2->bindParam(":ano",$ano,  PDO::PARAM_STR);
$run2->bindParam(":data",$data,  PDO::PARAM_STR);
$run2->bindParam(":hora",$hora,  PDO::PARAM_STR);
$run2->execute();
$soma=$run2->fetchColumn();

$html.="
<td class='bn'>$soma,00</td>
</tr>
</table>
<span style='font-family:arial; weight:bold;'>Total Geral: ".($total + $soma).",00</span>
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
