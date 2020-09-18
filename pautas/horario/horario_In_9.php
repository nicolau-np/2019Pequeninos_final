<?php
ob_start();
session_start();
include_once '../config/conn.php';
include_once 'Hora.php';

$anoNO = addslashes(htmlspecialchars($_GET['ano']));
$cursoNO = addslashes(htmlspecialchars($_GET['curso']));
$classeNO = addslashes(htmlspecialchars($_GET['classe']));
$turmaNO = addslashes(htmlspecialchars($_GET['turma']));
$turnoNO = addslashes(htmlspecialchars($_GET['turno']));

if($turnoNO == "Manha"):
    $id_turno = 1;
elseif($turnoNO == "Tarde"):
    $id_turno = 2;
elseif($turnoNO == "Noite"):
    $id_turno = 3;
endif;

$objHora = new Hora();


$html = '
    <!DOCTYPE html>
<html>
<head><title>Horario</title>
<link rel="stylesheet" href="../css/style.default.css" type="text/css" />
<link rel="stylesheet" href="../css/responsive-tables.css"/>
    <style>
.ver{
color:red;
}
</style>
</head>
<body>
<div style="font-family:arial;">
<div style="text-align:center;">
<img src="../logo.png" style="height:50px; width:50px;"/>
<br/>
GOVERNO DA PROVÍNCIA DO HUAMBO<br/>
DIRECÇÃO PROVINCIAL DA EDUCAÇÃO, CIÊNCIA E TECNOLOGIA<br/>
COMPLEXO ESCOLAR LAR DOS PEQUENINOS DAS IRMÃS DO SANTÍSSIMO <br/>SALVADOR-HUAMBO<br/><br/><br/><br/><br/>

<span style="font-weight:bold; font-size:25px;">HORARIO</span>
</div><br/><br/>
Curso: '.$cursoNO.' Classe: '.$classeNO.' Turma: '.$turmaNO.' Turno: '.$turnoNO.'
 <br/><br/><br/><br/>
<table class="table table-bordered responsive">
                    <thead>
                        <tr>
                            <th>Hora Entrada</th>
                            <th>Hora Saida</th>
                            <th>Segunda</th>
                            <th>Terça</th>
                            <th>Quarta</th>
                            <th>Quinta</th>
                            <th>Sexta</th>
                       </tr>
                    </thead>
                    <tbody>
';
$objHora->setCon($con);
$objHora->setAno($anoNO);
$objHora->setClasse($classeNO);
$objHora->setCurso($cursoNO);
$objHora->setTurma($turmaNO);
$objHora->setTurno($turnoNO);
$objHora->setId_turno($id_turno);

$res = $objHora->_horas();

while($view = $res->fetch(PDO::FETCH_OBJ)):
    
$html.="<tr>
    <td>".$view->hora_e."</td>
    <td>".$view->hora_s."</td>";

$semana = "Segunda";
$objHora->setHora_e($view->hora_e);
$objHora->setHora_s($view->hora_s);
$objHora->setSemana($semana);
$resSeg = $objHora->busca_hora();
$viewSeg = $resSeg->fetch(PDO::FETCH_OBJ);
if($resSeg->rowCount()<=0):
   $estado = "---";
else:
    $estado = $viewSeg->nome;
endif;
$html.="    
    <td>".$estado."</td>";

$semana2 = "Terça";
$objHora->setHora_e($view->hora_e);
$objHora->setHora_s($view->hora_s);
$objHora->setSemana($semana2);
$resTer = $objHora->busca_hora();
$viewTer = $resTer->fetch(PDO::FETCH_OBJ);
if($resTer->rowCount()<=0):
    $estado2 = "---";
else:
    $estado2 = $viewTer->nome;
endif;
$html.="<td>".$estado2."</td>";

$semana3 = "Quarta";
$objHora->setHora_e($view->hora_e);
$objHora->setHora_s($view->hora_s);
$objHora->setSemana($semana3);
$resQua = $objHora->busca_hora();
$viewQua = $resQua->fetch(PDO::FETCH_OBJ);
if($resQua->rowCount()<=0):
    $estado3 = "---";
else:
    $estado3 = $viewQua->nome;
endif;
$html.="<td>".$estado3."</td>";


$semana4 = "Quinta";
$objHora->setHora_e($view->hora_e);
$objHora->setHora_s($view->hora_s);
$objHora->setSemana($semana4);
$resQui = $objHora->busca_hora();
$viewQui = $resQui->fetch(PDO::FETCH_OBJ);
if($resQui->rowCount()<=0):
    $estado4 = "---";
else:
    $estado4 = $viewQui->nome;
endif;
$html.="<td>".$estado4."</td>";


$semana5 = "Sexta";
$objHora->setHora_e($view->hora_e);
$objHora->setHora_s($view->hora_s);
$objHora->setSemana($semana5);
$resSex = $objHora->busca_hora();
$viewSex = $resSex->fetch(PDO::FETCH_OBJ);
if($resSex->rowCount()<=0):
    $estado5 = "---";
else:
    $estado5 = $viewSex->nome;
endif;
$html.="<td>".$estado5."</td>";





$html.="
</tr>";
endwhile;

$html.="
                    </tbody>
                    </table>
</body>
</html>";

include("../../propina Colegio/mpdf/mpdf.php");

$mpdf=new mPDF(); 

$mpdf->WriteHTML($html);

$mpdf->Output(); 

exit;
                        

