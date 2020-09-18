<?php
include("config/conn.php");
$nome=$_GET['nome'];
$id_professor=$_GET['id_prof'];
$ano=date("Y");
$html="
<!DOCTYPE html>
<html>
<head><title>Horario</title>
<link rel='stylesheet' href='css/style.default.css' type='text/css' />
<link rel='stylesheet' href='css/responsive-tables.css'/>
</head>
<body>
<div style='text-align:center;'>
<img src='images/200px-Coat_of_arms_of_Angola_svg.png' style='height:50px; width:40px;'><br/><br/>
<b>ESCOLA PRIMÁRIA E Iº CÍCLO LAR DOS PEQUENINOS <BR/>DAS IRMÃS DO SANTÍSSIMO SALVADOR-HUAMBO</b></div>
";





$html.="<br/>
<br/>
<div style='text-align:center;'>HORÁRIO ESCOLAR: <b>{$nome}</b> </div><br/>
<span>ANO LECTIVO: <b>{$ano}</b></span><br/><br/><br/>
<table class='table table-bordered responsive'>
                    <thead>
                        <tr>
						<th>Dia Semana</th>
                            <th>Disciplina</th>
                            <th>Classe</th>
                            <th>Turma</th>
                            <th>Turno</th>
                            <th>Sala</th>
                            <th>Hora Entrada</th>
                            <th>Hora Saida</th>
                        </tr>
                    </thead>
                    <tbody>
                    ";
                    
                 
                    $se34="select *from view_horario where id_professor=:id and anolectivo=:ano";
                    $x34=$con->prepare($se34);
                    $x34->bindParam(":id",$id_professor,PDO::PARAM_STR);
                    $x34->bindParam(":ano",$ano,PDO::PARAM_STR);
                    $x34->execute();
                    $contar34=$x34->rowCount();
                    if($contar34==0):
                    echo"Nenhum horário encontrado";
                    else:
                    while($vt=$x34->fetch(PDO::FETCH_OBJ))
                    {
                        $html.="
                        <tr>
						<td>{$vt->semana}</td>
                            <td>{$vt->nome}</td>
                            <td>{$vt->classe}</td>
                            <td>{$vt->turma}</td>
                            <td>{$vt->turno}</td>
                            <td>{$vt->sala}</td>
                            <td>{$vt->hora_e}</td>
                            <td>{$vt->hora_s}</td>
                           
                        </tr>
                        ";
                    }
                    endif;
                    
                    
                    
                    
$html.="
                    </tbody>
                    </table>
</body>
</html>";

include("../propina Colegio/mpdf/mpdf.php");
$mpdf=new mPDF('c','A4'); 
$mpdf->WriteHTML($html);
$mpdf->Output();
exit;
?>