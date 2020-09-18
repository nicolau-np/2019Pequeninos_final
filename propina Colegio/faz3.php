<?php
ob_start();
session_start();
require_once("conn2.php");

$processo=$_POST['processo'];
$data=date("d-m-Y");
$ano=$_POST['txt_ano'];
$hora=date("H:i:s");
$id=$_POST['txt_id'];
$cliente=$_POST['txt_cliente'];
$valor=$_POST['cb_valor'];
$estado="pago";


$pri="select *from tbl_inscricao where id_aluno=:pro and ano=:ano";
$vbi=$con2->prepare($pri);
$vbi->bindParam(":pro",$id,PDO::PARAM_STR);
$vbi->bindParam(":ano",$ano,PDO::PARAM_STR);
$vbi->execute();
$cc=$vbi->rowCount();
if($cc==0)
{

$ins="insert into tbl_inscricao(id_aluno,ano,valor,estado,data,hora) values(:id_aluno,:ano,:valor,:estado,:data,:hora)";
$reve=$con2->prepare($ins);
$reve->bindParam(":id_aluno",$id,PDO::PARAM_STR);
$reve->bindParam(":ano",$ano,PDO::PARAM_STR);
$reve->bindParam(":valor",$valor,PDO::PARAM_STR);
$reve->bindParam(":estado",$estado,PDO::PARAM_STR);
$reve->bindParam(":data",$data,PDO::PARAM_STR);
$reve->bindParam(":hora",$hora,PDO::PARAM_STR);
$reve->execute();
}
else
{
  
}



$col="select *from view_estudante where id_aluno=:id";

    $result01=$con2->prepare($col);
    $result01->bindParam(":id",$id,PDO::PARAM_STR);
    $result01->execute();
 $vto=$result01->fetch(PDO::FETCH_OBJ);   

$nome=$vto->nome;
$processo=$vto->id_aluno;
$turma=$vto->turma;
$curso=$vto->curso;
$turno=$vto->turno;
$classe=$vto->classe;
$ano_le=$vto->ano_lectivo;



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
NIF: 5121019874<br/><br/><br/>
</div>
<div class='el'>
<b>HUAMBO-ANGOLA</b>
</div>
<br/>
<br/>
<div class='ely'>
<table border='0' class='nm'>
<tr>
<td colspan='2' id='pi'><b>PAGAMENTO DE MATRÍCULA/ RECONFIRMAÇÃO</b></td>
</tr>
<tr>
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
<td class='vfk'>{$processo}</td>
<td class='vfk'>{$nome}</td>
<td class='vfk'>{$curso}</td>
<td class='vfk'>{$classe}</td>
<td class='vfk'>{$turma}</td>
<td class='vfk'>{$turno}</td>
<td>{$ano}</td>
</tr>

</table>
</div>
<br/>
";


$html.="<table class='table1' id='vb' width='200'>
<tr>
<th class='cvb'>Valor</th>
</tr>";


    $com="select *from tbl_inscricao where id_aluno=:ida and ano=:an";
    $exe=$con2->prepare($com);
    $exe->bindParam(":ida",$id,PDO::PARAM_STR);
    $exe->bindParam(":an",$ano,PDO::PARAM_STR);
    $exe->execute();
    
$bt=$exe->fetch(PDO::FETCH_OBJ);
        
$html.="
<tr>
<td>{$bt->valor},00</td>
</tr>
";
  

$html.="

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
<td colspan='2' id='pi'><b>PAGAMENTO DE MATRÍCULA/ RECONFIRMAÇÃO</b></td>
</tr>
<tr>
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
<td class='vfk'>{$processo}</td>
<td class='vfk'>{$nome}</td>
<td class='vfk'>{$curso}</td>
<td class='vfk'>{$classe}</td>
<td class='vfk'>{$turma}</td>
<td class='vfk'>{$turno}</td>
<td>{$ano}</td>
</tr>
</table>
</div>
<br/>
";


$html.="<table class='table1' id='vb' width='200'>
<tr>
<th class='cvb'>Valor</th>
</tr>";


    $com="select *from tbl_inscricao where id_aluno=:ida and ano=:an";
    $exe=$con2->prepare($com);
    $exe->bindParam(":ida",$id,PDO::PARAM_STR);
    $exe->bindParam(":an",$ano,PDO::PARAM_STR);
    $exe->execute();
    
$bt=$exe->fetch(PDO::FETCH_OBJ);
        
$html.="
<tr>
<td>{$bt->valor},00</td>
</tr>
";
  

$html.="

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
