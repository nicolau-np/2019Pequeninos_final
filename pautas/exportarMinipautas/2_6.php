<?php
include("../validarlogin.php");
include("../config/conn.php");
include_once '../classes/Caderneta.php';
include_once '../classes/MiniPautas.php';

        $curso200=$_SESSION['curso'];
        $classe200=$_SESSION['classe'];
        $turma200=$_SESSION['turma'];
        $turno200=$_SESSION['turno'];
        $disciplina200=$_SESSION['disciplina'];
        $anoLectivo=date("Y");

header("Content-Type: application/vnd.ms-excel");
header("Content-Type: application/force-download");
header("Content-disposition: attachment; filename=$disciplina200-$curso200-$classe200-$turma200-$turno200-$anoLectivo.xls");
header("Pragma:no-Cache");


?>
<html>
<head><title></title>
<meta charset="utf-8" />
<style>
.azul{
    color:blue;
}
.vermelho{
    color:red;
}
.verde{
    color:green;
font-weight:bold;
font-size:14px;
}
</style>
</head>
<body>
    
<div style="font-family:arial; font-size: 15px; font-weight: bold; text-align: center;">
República de Angola<br/>																																							
Governo Provincial Do Huambo<br/>																																						
Ministério Da Educação Ciência e Tecnologia<br/>																																							
<span style="color:#90111A;">ESCOLA PRIMÁRIA E DO I CICLO “LAR DOS PEQUENINOS” DAS IRMÃS DO SANTÍSSIMO SALVADOR</span><br/>	
MINI-PAUTA DE AVALIAÇÃO ANUAL<br/>
DISCIPLINA: <?php echo $disciplina200;?>  CLASSE: <?php echo $classe200;?>  TURMA: <span style="color:#90111A;"><?php echo $classe200.".".$turma200;?></span> PERÍODO: <?php echo $turno200;?>,   ANO LECTIVO <?php echo $anoLectivo;?><br/>
<br/><br/>
   </div>
<?php 
        
        $do4="select *from tbl_dis2 where nome=:nome";
        $r4=$con->prepare($do4);
        $r4->bindParam(":nome",$disciplina200,PDO::PARAM_STR);
        $r4->execute();
        $v4=$r4->fetch(PDO::FETCH_OBJ);
        
$epoca1=1;
$epoca2=2;
$epoca3=3;

$objMiniPautas = new MiniPautas();
$objCaderneta = new Caderneta();
$objCaderneta->setCon($con);
$objCaderneta->setAno($anoLectivo);
$objCaderneta->setClasse($classe200);
$objCaderneta->setCurso($curso200);
$objCaderneta->setTurma($turma200);
$objCaderneta->setTurno($turno200);

$objMiniPautas->setCon($con);
$objMiniPautas->setAno($anoLectivo);

$busEstudante = $objCaderneta->buscaEstudate();
?>
<div class="table-wrapper"><div class="scrollable"><table class="table table-bordered responsive" style="border:1px solid #000;">
                    <colgroup>
                    <col class="con1">
                        <col class="con0">
                        <col class="con1">
                        <col class="con0">
                        <col class="con1">
                         <col class="con1">
                        <col class="con0">
                        <col class="con1">
                        <col class="con0">
                        <col class="con1">
                        
                    </colgroup>
                    <thead>
                        <tr style="border:1px solid #000; background-color: #ff0;">
                        <th colspan="3" class="center">Dados Aluno</th>
                        <th colspan="3" class="center">1º Trimestre</th>
                         <th colspan="3" class="center">2º Trimestre</th>
                          <th colspan="3" class="center">3º Trimestre</th>
                          <th colspan="5" class="center">Resultados Finais</th>
                         </tr>
                         <tr style="border:1px solid #000; background-color: #ff0;">
                            <th>Nº</th>
                            <th>Nome Completo</th>
                            <th>Gênero</th>
                            <th>MAC</th>
                            <th>CPP</th>
                            <th>CT1</th>
                              <th>MAC</th>
                            <th>CPP</th>
                            <th>CT2</th>
                              <th>MAC</th>
                            <th>CPP</th>
                            <th>CT3</th>
                            
                            <th>CAP</th>
                              <th>CPE/CE</th>
                            <th>CF</th>
                            <th colspan="2">OBSERVAÇÃO</th>
                     
                            </tr>
                    </thead>
                    <tbody>
                     <?php 
                     
       
               $a1=0; 
               if($busEstudante->rowCount()==0):
		echo "Mini pauta indisponível!";
                    else:
                    while(($ver_es=$busEstudante->fetch(PDO::FETCH_OBJ)))
                    {
                     $a1++;   
                   
                    ?>
                        <tr style="border:1px solid #000;">

                            <td><?php echo $a1;?></td>
                             <td><?php echo $ver_es->nome;?></td>
                            <td><?php echo $ver_es->genero;?></td>
                            
                            <?php 
                            $busMiniPautas1 = $objMiniPautas->buscarNotas($epoca1,  $v4->id_di2, $ver_es->id_aluno);
                            $ver_epoca1 = $busMiniPautas1->fetch(PDO::FETCH_OBJ);
                            ?>
                            
                            <td class="<?php if($ver_epoca1->mac>=5): echo "azul"; else: echo "vermelho";endif;?>"><?php echo $ver_epoca1->mac;?></td>
                            <td class="<?php if($ver_epoca1->cpp>=5): echo "azul"; else: echo "vermelho";endif;?>"><?php echo $ver_epoca1->cpp;?></td>
                            <td class="<?php if($ver_epoca1->ct>=5): echo "azul"; else: echo "vermelho";endif;?>"><?php echo $ver_epoca1->ct;?></td>
                            
                            <?php 
                            $busMiniPautas2 = $objMiniPautas->buscarNotas($epoca2,  $v4->id_di2, $ver_es->id_aluno);
                            $ver_epoca2 = $busMiniPautas2->fetch(PDO::FETCH_OBJ);
                            ?>
                            
                            <td class="<?php if($ver_epoca2->mac>=5): echo "azul"; else: echo "vermelho";endif;?>"><?php echo $ver_epoca2->mac;?></td>
                            <td class="<?php if($ver_epoca2->cpp>=5): echo "azul"; else: echo "vermelho";endif;?>"><?php echo $ver_epoca2->cpp;?></td>
                            <td class="<?php if($ver_epoca2->ct>=5): echo "azul"; else: echo "vermelho";endif;?>"><?php echo $ver_epoca2->ct;?></td>
                            
                              <?php 
                            $busMiniPautas3 = $objMiniPautas->buscarNotas($epoca3,  $v4->id_di2, $ver_es->id_aluno);
                            $ver_epoca3 = $busMiniPautas3->fetch(PDO::FETCH_OBJ);
                            ?>
                            
                            <td class="<?php if($ver_epoca3->mac>=5): echo "azul"; else: echo "vermelho";endif;?>"><?php echo $ver_epoca3->mac;?></td>
                            <td class="<?php if($ver_epoca3->cpp>=5): echo "azul"; else: echo "vermelho";endif;?>"><?php echo $ver_epoca3->cpp;?></td>
                            <td class="<?php if($ver_epoca3->ct>=5): echo "azul"; else: echo "vermelho";endif;?>"><?php echo $ver_epoca3->ct;?></td>
                            
                              <?php 
                            $busMiniPautasF = $objMiniPautas->buscClassFinais($v4->id_di2, $ver_es->id_aluno);
                            $ver_clas_finais = $busMiniPautasF->fetch(PDO::FETCH_OBJ);
                            ?>
                            
                            <td class="<?php if($ver_clas_finais->cap>=5): echo "azul"; else: echo "vermelho";endif;?>"><?php echo $ver_clas_finais->cap;?></td>
                            <td class="<?php if($ver_clas_finais->cpe>=5): echo "azul"; else: echo "vermelho";endif;?>"><?php echo $ver_clas_finais->cpe;?></td>
                            <td class="<?php if($ver_clas_finais->cf>=5): echo "azul"; else: echo "vermelho";endif;?>"><?php echo $ver_clas_finais->cf;?></td>
                           <td colspan="2" class="<?php if($ver_clas_finais->observacao=="Transita"): echo "azul"; else: echo "vermelho";endif;?>"><?php echo $ver_clas_finais->observacao;?></td>  
                           
                        </tr>
                        <?php } endif;?>
                       
                        
                    </tbody>
                </table></div></div>
    </body>
</html>
