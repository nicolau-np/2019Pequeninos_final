<?php
include("config/conn.php");
$curso=$_GET['curso'];
$classe=$_GET['classe'];
$turma=$_GET['turma'];
$turno=$_GET['turno'];
$ano=$_GET['ano'];

$se="select *from view_estudante where curso=:curso and classe=:classe and turma=:turma and turno=:turno and anolectivo=:ano";
$x=$con->prepare($se);
$x->bindParam(":curso",$curso,PDO::PARAM_STR);
$x->bindParam(":classe",$classe,PDO::PARAM_STR);
$x->bindParam(":turma",$turma,PDO::PARAM_STR);
$x->bindParam(":turno",$turno,PDO::PARAM_STR);
$x->bindParam(":ano",$ano,PDO::PARAM_STR);
$x->execute();

    

$html="
<html>
<head><title></title>
<style>
.verm
{
    color:red;
    }
    .tb
    {
        border:1px solid #000;
        }
</style>
</head>
<body>
PASSES <BR/>
Classe: $classe $turma $turno $ano
";
while($ver_pa=$x->fetch(PDO::FETCH_OBJ))
{



$html.="
    <table border='0' class='tb'>
    <tr>
    <td colspan='1'></td>
       <td colspan='1' style='text-aling:center;'><img src='images/200px-Coat_of_arms_of_Angola_svg.png' width='50px' height='45px'></td>
  
  <td colspan='4' style='text-align:center; font-size:14px; font-family:arial;'><b>ESCOLA PRIMÁRIA E Iº CÍCLO LAR DOS PEQUENINOS <BR/>DAS IRMÃS DO SANTÍSSIMO SALVADOR-HUAMBO</b></td>

    </tr>
    <tr>
    <td colspan='2'></td>
    <td colspan='4'></td>
    </tr>
       <tr>
    <td colspan='2'></td>
    <td colspan='4'></td>
    </tr>
     <tr>
    <td colspan='3' rowspan='6' style='text-align:center;'><img src='foto_alunos/{$ver_pa->foto}' width='90px' height='100px'></td>
    </tr>
    <tr>
    <td style='font-family:arial; font-size:14px'>Nº Proc.: <span class='verm'>{$ver_pa->id_aluno}</span></td>
    
    </tr>
    <tr>
    <td style='font-family:arial; font-size:14px'>Nome: <span class='verm'>{$ver_pa->nome}</span></td>
    
    </tr>
    <tr>
    <td style='font-family:arial; font-size:14px'>Classe: <span class='verm'>{$ver_pa->classe}</span></td>
    
    </tr>
    <tr>
    <td style='font-family:arial; font-size:14px'>Turma: <span class='verm'>{$ver_pa->turma}</span></td>
    </tr>
    
      <tr>
    <td style='font-family:arial; font-size:14px'>ANO LECTIVO: {$ver_pa->anolectivo}</td>
    </tr>
    
     <tr>
     <td colspan=4></td>
    <td style='text-align:center; font-family:arial; font-size:14px'>Director Pedagógico<br>________________________<br>Nataniel Sombelelo<br></td>
    </tr>
    
    
    </table>
    -------------------------------------------------------------------------------------------------------------------------------------------
    ";

}
$html.="

</body>
</html>";

include("mpdf/mpdf.php");
$mpdf=new mPDF('c','A4'); 
$mpdf->WriteHTML($html);
$mpdf->Output();
exit;
?>