<?php
ob_start();
session_start();
require_once("conn2.php");
$curso=$_POST['curso'];
$classe=$_POST['classe'];
$turma=$_POST['turma'];
$turno=$_POST['turno'];
$ano=$_POST['anoS'];

	$mes1="1 Trimestre";
	$mes2="2 Trimestre";
	$mes3="3 Trimestre";





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
<br/>
<div class='cabe'>
<img src='assets/img/as.jpg' width='50px' height='50px'/><br/>
<strong>REPÚBLICA DE ANGOLA</strong><br/>
<strong>MINISTÉRIO DA EDUCAÇÃO CIÊNCIA E TECNOLOGIA</strong><br/>
<strong>ESCOLA PRIMÁRIA E Iº CÍCLO LAR DOS PEQUENINOS <BR/>DAS IRMÃS DO SANTÍSSIMO SALVADOR-HUAMBO</strong><br/>
</div><br/><br/>
<div class='desig'>LISTA DE PAGAMENTO</div><br/>
<div class='dados_a'>
<table border='0' id='iop'>
<tr>
<td  class='vfg'>Curso</td>
<td  class='vfg'>Classe</td>
<td  class='vfg'>Turma</td>
<td  class='vfg'>Turno</td>

<td  class='vfg'>Ano Lectivo</td>
</tr>
<tr>
<td class='vfk'>{$curso}</td>
<td class='vfk'>{$classe}</td>
<td class='vfk'>{$turma}</td>
<td class='vfk'>{$turno}</td>
<td>$ano</td>

</tr>
</table>
</div>


<br/>
<div class='tb'>";


$html.="<table border=0 width='500' class='bnmm'>
<tr>
<th class='vfg'>Nº</th>
<th class='vfg' width='200px'>Nome completo</th>
<th class='vfg'>Gênero</th>
<th class='vfg'>1º Trimestre</th>
<th class='vfg'>2º Trimestre</th>
<th class='vfg'>3º Trimestre</th>

</tr>
";
$command="select *from view_estudante where curso=:curso and classe=:classe and turma=:turma and turno=:turno and anolectivo=:an order by nome asc";

 $result=$con2->prepare($command);
   $result->bindParam(":curso",$curso,PDO::PARAM_STR);
    $result->bindParam(":classe",$classe,PDO::PARAM_STR);
   $result->bindParam(":turma",$turma,PDO::PARAM_STR);
   $result->bindParam(":turno",$turno,PDO::PARAM_STR);
          $result->bindParam(":an",$ano,PDO::PARAM_STR);
  $result->execute();  
while($rt=$result->fetch(PDO::FETCH_OBJ))
{
 $a++; 
 $html.="
<tr>
<td class='vfk'>$a</td>
<td class='vfk'>{$rt->nome}</td>
<td class='vfk'>{$rt->genero}</td>
    ";
$command2="select *from ver where id_aluno=:id and mes=:mes and ano_lectivo=:an";

 $result2=$con2->prepare($command2);
   $result2->bindParam(":id",$rt->id_aluno,PDO::PARAM_STR);
     $result2->bindParam(":mes",$mes1,PDO::PARAM_STR);
          $result2->bindParam(":an",$ano,PDO::PARAM_STR);
  $result2->execute(); 
  $view23=$result2->fetch(PDO::FETCH_OBJ);
$html.="<td class='vfk'>{$view23->pago}</td>";

$command3="select *from ver where id_aluno=:id and mes=:mes and ano_lectivo=:an";

 $result3=$con2->prepare($command3);
   $result3->bindParam(":id",$rt->id_aluno,PDO::PARAM_STR);
     $result3->bindParam(":mes",$mes2,PDO::PARAM_STR);
          $result3->bindParam(":an",$ano,PDO::PARAM_STR);
  $result3->execute(); 
  $view24=$result3->fetch(PDO::FETCH_OBJ);
$html.="<td class='vfk'>{$view24->pago}</td>";

$command4="select *from ver where id_aluno=:id and mes=:mes and ano_lectivo=:an";

 $result4=$con2->prepare($command4);
   $result4->bindParam(":id",$rt->id_aluno,PDO::PARAM_STR);
     $result4->bindParam(":mes",$mes3,PDO::PARAM_STR);
          $result4->bindParam(":an",$ano,PDO::PARAM_STR);
  $result4->execute(); 
  $view25=$result4->fetch(PDO::FETCH_OBJ);
$html.="<td>{$view25->pago}</td>";

 $html.="</tr>";
}

$html.="
    
</table>
</body>
</html>";

include("mpdf/mpdf.php");
$mpdf=new mPDF('c','A4'); 
$mpdf->WriteHTML($html);
$mpdf->Output();
exit;

?>
