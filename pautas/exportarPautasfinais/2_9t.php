<?php 

include("../validarlogin.php");
include("../config/conn.php");
include_once '../classes/MiniPautas.php';
include_once '../classes/Caderneta.php';

$objCaderneta = new Caderneta();
$objMiniPautas = new MiniPautas();
$objCaderneta->setCon($con);
$objMiniPautas->setCon($con);

        $curso=$_SESSION['curso'];
        $classe=$_SESSION['classe'];
        $turma=$_SESSION['turma'];
        $turno=$_SESSION['turno'];
         $anoS=$_GET['anoSS'];


        $epoca1=1;
        $epoca2=2;
        $epoca3=3;

header("Content-Type: application/vnd.ms-excel");
header("Content-Type: application/force-download");
header("Content-disposition: attachment; filename=$curso-$classe-$turma-$turno-$anoS.xls");
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
<span style="color:#90111A;">COMPLEXO ESCOLAR “LAR DOS PEQUENINOS” DAS IRMÃS DO SANTÍSSIMO SALVADOR</span><br/>																																							
PAUTA  DA  <?php echo $classe;?> CLASSE,  Turma: <span style="color:#90111A;"><?php echo $classe.".".$turma;?></span>,   PERÍODO: <?php echo $turno;?>,   ANO LECTIVO <?php echo $anoS;?><br/>	
<br/><br/>
   </div>
         <div class="tabs-left">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#lA"><!--1 Geral--></a></li>
                                <li class=""><a data-toggle="tab" href="#lB"><!--2 Geral--></a></li>
                           
                            </ul>
                            <div class="tab-content">
                              <!-- 1 trimestre-->
                                
                                 <!-- 2 trimestre-->
                                <div id="lB" class="tab-pane">
                                             
                  <table class="table table-bordered responsive" style="border:1px solid #000;">
                    <colgroup>
                      <col class="con0">
                        <col class="con1">
                        <col class="con0">
                        <col class="con1">
                        <col class="con0">
                        <col class="con1">
                        <col class="con0">
                        <col class="con1">
                        <col class="con0">
                        <col class="con1">
                        <col class="con0">
                        <col class="con1">
                        <col class="con0">
                    </colgroup>
                    <thead>
                        <tr style="border:1px solid #000;">
                        <th rowspan=2>Nº</th>
                    <th rowspan=2 colspan=3>Nome Completo</th>
                       <?php
                       
                           $res2 = $objMiniPautas->buscaDisciplinas($curso, $classe, $con);
                            while($viewGG2=$res2->fetch(PDO::FETCH_OBJ)){
                                ?>
                              <th colspan="12"><?php echo $viewGG2->nome;?></th>
                            <?php
                            }?>
                        </tr>
						<tr style="border:1px solid #000;">
						   <?php 
                      $a201 = 1;
                       $conta = $res2->rowCount();
                      while($a201<=$conta):
                          $a201++;
                    ?>
                                                <th style="background-color:#ff0;">MAC</th>
						<th style="background-color:#ff0;">CPP</th>
						<th>CT1</th>
						<th style="background-color:#ff0;">MAC</th>
						<th style="background-color:#ff0;">CPP</th>
						<th>CT2</th>
						<th style="background-color:#ff0;">MAC</th>
						<th style="background-color:#ff0;">CPP</th>
						<th>CT3</th>
                                                <th>CAP</th>
						<th style="background-color:#ff0;">CPE/CE</th>
						<th>CF</th>
                            <?php
                    endwhile;
                           ?>
						
						  
						</tr>
                    </thead>
                    <tbody>
                  <?php 
                        
                        $objCaderneta->setCurso($curso);
                        $objCaderneta->setClasse($classe);
                        $objCaderneta->setTurma($turma);
                        $objCaderneta->setTurno($turno);
                        $objCaderneta->setAno($anoS);
                        $objMiniPautas->setAno($anoS);
                        $res001 =$objCaderneta->buscaEstudate();
                        $a002 = 0;
                        while($viewG002 = $res001->fetch(PDO::FETCH_OBJ)){
                            $a002++;
                        ?>
                        <tr style="border:1px solid #000;">
                      <td><?php echo $a002;?></td>
                            <td colspan="3"><?php echo $viewG002->nome;?></td>  
                              <?php 
                              $res7 = $objMiniPautas->buscaDisciplinas($curso, $classe, $con);
			 while($viewGG7=$res7->fetch(PDO::FETCH_OBJ)){
                          ?>
                            <!-- 1 trimestre-->
                            <?php 
                            $etedf1 = $objMiniPautas->buscarNotas($epoca1, $viewGG7->id_di2, $viewG002->id_aluno);
                            $ver_edf1 =$etedf1->fetch(PDO::FETCH_OBJ);
                            ?>
                            
                           <td style="background-color:#ff0;" class="<?php if(($classe=="2ª")||($classe=="4ª")): if($ver_edf1->mac>=5): echo "azul"; else: echo"vermelho";  endif; else: if($ver_edf1->mac>=10): echo "azul"; else: echo"vermelho";  endif; endif;?>"><?php echo $ver_edf1->mac;?></td>
                            <td style="background-color:#ff0;" class="<?php if(($classe=="2ª")||($classe=="4ª")): if($ver_edf1->cpp>=5): echo "azul"; else: echo"vermelho";  endif; else: if($ver_edf1->cpp>=10): echo "azul"; else: echo"vermelho";  endif; endif;?>"><?php echo $ver_edf1->cpp;?></td>
                            <td class="<?php if(($classe=="2ª")||($classe=="4ª")): if($ver_edf1->ct>=5): echo "azul"; else: echo"vermelho";  endif; else: if($ver_edf1->ct>=10): echo "azul"; else: echo"vermelho";  endif; endif;?>"><?php echo $ver_edf1->ct;?></td>
                            
                              <!-- 2 trimestre-->
                            <?php 
                            $etedf2 = $objMiniPautas->buscarNotas($epoca2, $viewGG7->id_di2, $viewG002->id_aluno);
                            $ver_edf2 =$etedf2->fetch(PDO::FETCH_OBJ);
                            ?>
                            
                            <td style="background-color:#ff0;" class="<?php if(($classe=="2ª")||($classe=="4ª")): if($ver_edf2->mac>=5): echo "azul"; else: echo"vermelho";  endif; else: if($ver_edf2->mac>=10): echo "azul"; else: echo"vermelho";  endif; endif;?>"><?php echo $ver_edf2->mac;?></td>
                            <td style="background-color:#ff0;" class="<?php if(($classe=="2ª")||($classe=="4ª")): if($ver_edf2->cpp>=5): echo "azul"; else: echo"vermelho";  endif; else: if($ver_edf2->cpp>=10): echo "azul"; else: echo"vermelho";  endif; endif;?>"><?php echo $ver_edf2->cpp;?></td>
                            <td class="<?php if(($classe=="2ª")||($classe=="4ª")): if($ver_edf2->ct>=5): echo "azul"; else: echo"vermelho";  endif; else: if($ver_edf2->ct>=10): echo "azul"; else: echo"vermelho";  endif; endif;?>"><?php echo $ver_edf2->ct;?></td>
                            
                            <!-- 3 trimestre-->
                            <?php 
                            $etedf3 = $objMiniPautas->buscarNotas($epoca3, $viewGG7->id_di2, $viewG002->id_aluno);
                            $ver_edf3 =$etedf3->fetch(PDO::FETCH_OBJ);
                            ?>
                            
                            <td style="background-color:#ff0;" class="<?php if(($classe=="2ª")||($classe=="4ª")): if($ver_edf3->mac>=5): echo "azul"; else: echo"vermelho";  endif; else: if($ver_edf3->mac>=10): echo "azul"; else: echo"vermelho";  endif; endif;?>"><?php echo $ver_edf3->mac;?></td>
                            <td style="background-color:#ff0;" class="<?php if(($classe=="2ª")||($classe=="4ª")): if($ver_edf3->cpp>=5): echo "azul"; else: echo"vermelho";  endif; else: if($ver_edf3->cpp>=10): echo "azul"; else: echo"vermelho";  endif; endif;?>"><?php echo $ver_edf3->cpp;?></td>
                            <td class="<?php if(($classe=="2ª")||($classe=="4ª")): if($ver_edf3->ct>=5): echo "azul"; else: echo"vermelho";  endif; else: if($ver_edf3->ct>=10): echo "azul"; else: echo"vermelho";  endif; endif;?>"><?php echo $ver_edf3->ct;?></td>
                            
                             <!-- final-->
                            <?php 
                            $etedff = $objMiniPautas->buscClassFinais($viewGG7->id_di2, $viewG002->id_aluno);
                            $ver_edff =$etedff->fetch(PDO::FETCH_OBJ);
                            ?>
                            
                            <td class="<?php if(($classe=="2ª")||($classe=="4ª")): if($ver_edff->cap>=5): echo "azul"; else: echo"vermelho";  endif; else: if($ver_edff->cap>=10): echo "azul"; else: echo"vermelho";  endif; endif;?>"><?php echo $ver_edff->cap;?></td>
                            <td style="background-color:#ff0;" class="<?php if(($classe=="2ª")||($classe=="4ª")): if($ver_edff->cpe>=5): echo "azul"; else: echo"vermelho";  endif; else: if($ver_edff->cpe>=10): echo "azul"; else: echo"vermelho";  endif; endif;?>"><?php echo $ver_edff->cpe;?></td>
                            <td class="<?php if(($classe=="2ª")||($classe=="4ª")): if($ver_edff->cf>=5): echo "azul"; else: echo"vermelho";  endif; else: if($ver_edff->cf>=10): echo "azul"; else: echo"vermelho";  endif; endif;?>"><?php echo $ver_edff->cf;?></td>
                            
                              <?php } ?>  
                          
                        </tr>
<?php }?>
                    </tbody>
                </table>
                
                           
              
                                </div>
      
                                </div>
                                
                            </div><!--tab-content-->
                        </div> 
</body>
</html>
