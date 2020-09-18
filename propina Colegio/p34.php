<?php
ob_start();
session_start();
require_once("conn2.php");
$curso=$_POST['curso'];
$classe=$_POST['classe'];
$turma=$_POST['turma'];
$turno=$_POST['turno'];
$ano=$_POST['anoS'];

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
<div class='desig'>LISTA DE PAGAMENTO DE FOLHA DE PROVA</div><br/>
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


$html.="<table border=0 width='700' class='bnmm'>
<tr>
<th class='vfg'>Nº</th>
<th class='vfg' width='200px'>Nome completo</th>
<th class='vfg'>Gênero</th>
<th class='vfg'>1º Trimestre</th>
<th class='vfg'>2º Trimestre</th>
<th class='vfg'>3º Triemestre</th>

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
  $a=0;
while($rt=$result->fetch(PDO::FETCH_OBJ))
{
 $a++; 
 $html.="
<tr>
<td class='vfk'>$a</td>
<td class='vfk'>{$rt->nome}</td>
<td class='vfk'>{$rt->genero}</td>
    ";
$command2="select *from view_pagamento_folhas where id_aluno=:id and tipo_prova=:mes and ano_lectivo=:an";
try{
  $result2=$con2->prepare($command2);
   $result2->bindParam(":id",$rt->id_aluno,PDO::PARAM_STR);
     $result2->bindParam(":mes",$mes1,PDO::PARAM_STR);
          $result2->bindParam(":an",$ano,PDO::PARAM_STR);
  $result2->execute(); 
  $cont2=$result2->rowCount();
  if($cont2==0):
      $estado="nao pago";
  elseif($cont2==1):
      $estado="pago";
  endif;
   
} catch (PDOException $e) {
echo $e->getMessage();
}
 
$html.="<td class='vfk'>{$estado}</td>";

$command3="select *from view_pagamento_folhas where id_aluno=:id and tipo_prova=:mes and ano_lectivo=:an";
try{
    $result3=$con2->prepare($command3);
   $result3->bindParam(":id",$rt->id_aluno,PDO::PARAM_STR);
     $result3->bindParam(":mes",$mes2,PDO::PARAM_STR);
          $result3->bindParam(":an",$ano,PDO::PARAM_STR);
  $result3->execute(); 
  $cont3=$result3->rowCount();
 if($cont3==0):
      $estado3="nao pago";
  elseif($cont3==1):
      $estado3="pago";
  endif;
} catch (PDOException $e) {
echo $e->getMessage();
}
 
$html.="<td class='vfk'>{$estado3}</td>";

$command4="select *from view_pagamento_folhas where id_aluno=:id and tipo_prova=:mes and ano_lectivo=:an";
try{
    $result4=$con2->prepare($command4);
   $result4->bindParam(":id",$rt->id_aluno,PDO::PARAM_STR);
     $result4->bindParam(":mes",$mes3,PDO::PARAM_STR);
          $result4->bindParam(":an",$ano,PDO::PARAM_STR);
  $result4->execute(); 
   $cont4=$result4->rowCount();
 if($cont4==0):
      $estado4="nao pago";
  elseif($cont4==1):
      $estado4="pago";
  endif;
} catch (PDOException $e) {
echo $e->getMessage();
}
 
  
$html.="<td>{$estado4}</td>";



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