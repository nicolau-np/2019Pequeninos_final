<?php 

include("config/conn.php");

       
$epoca1=1;
$epoca2=2;
$epoca3=3;

$anoS=$_GET['anolect'];
$curso=$_GET['curso'];
$classe=$_GET['classe'];
$turma=$_GET['turma'];
$turno=$_GET['turno'];

        $_SESSION['curso']=$_GET['curso'];
        $_SESSION['classe']=$_GET['classe'];
        $_SESSION['turma']=$_GET['turma'];
        $_SESSION['turno']=$_GET['turno'];
        $_SESSION['anoTer']=$_GET['anolect'];
       // $_SESSION['disciplina']=$_GET['disciplina'];



?>
<html>
<head><title></title>
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
         <div class="tabs-left">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#lA">1 Geral</a></li>
                                <li class=""><a data-toggle="tab" href="#lB">2 Geral</a></li>
                           
                            </ul>
                            <div class="tab-content">
                              <!-- 1 trimestre-->
                                <div id="lA" class="tab-pane active">
                 
                  <table class="table table-bordered responsive">
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
                        <tr>
                      
                            <th rowspan=2>Nº</th>
                            <th rowspan=2 colspan=3>Nome Completo</th>
                           <?php
                         
                           $res = $objMiniPautas->buscaDisciplinas($curso, $classe, $con);
                            while($viewGG=$res->fetch(PDO::FETCH_OBJ)){
                                ?>
                              <th colspan="3"><?php echo $viewGG->nome;?></th>
                            <?php
                            }?>
                            <th rowspan=2>OBSERVAÇÃO</th>
                        </tr>
					 
                               <?php 
                      $a200 = 1;
                       $conta = $res->rowCount();
                      while($a200<=$conta):
                          $a200++;
                    ?>
                           		 
                            <th>CAP</th>
                            <th>CPE/CE</th>
                            <th>CF</th>
                         <?php endwhile;?>
                        
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
                        $a001 = 0;
                        while($viewG001 = $res001->fetch(PDO::FETCH_OBJ)){
                            $a001++;
                        ?>
                         <tr>
                             <td><?php echo $a001;?></td>
                            <td colspan="3"><?php echo $viewG001->nome;?></td> 
                            <?php 
                              $res4 = $objMiniPautas->buscaDisciplinas($curso, $classe, $con);
			 while($viewGG4=$res4->fetch(PDO::FETCH_OBJ)){
                             $res5 = $objMiniPautas->buscClassFinais($viewGG4->id_di2, $viewG001->id_aluno);
                          $viewGG5 = $res5->fetch(PDO::FETCH_OBJ);
                             ?>
                            
                         <td class="<?php if(($classe=="2ª")||($classe=="4ª")): if($viewGG5->cap>=5): echo "azul"; else: echo"vermelho";  endif; else: if($viewGG5->cap>=10): echo "azul"; else: echo"vermelho";  endif; endif;?>"><?php echo $viewGG5->cap;?></td>
                            <td class="<?php if(($classe=="2ª")||($classe=="4ª")): if($viewGG5->cpe>=5): echo "azul"; else: echo"vermelho";  endif; else: if($viewGG5->cpe>=10): echo "azul"; else: echo"vermelho";  endif; endif;?>"><?php echo $viewGG5->cpe;?></td>
                            <td class="<?php if(($classe=="2ª")||($classe=="4ª")): if($viewGG5->cf>=5): echo "azul"; else: echo"vermelho";  endif; else: if($viewGG5->cf>=10): echo "azul"; else: echo"vermelho";  endif; endif;?>"><?php echo $viewGG5->cf;?></td>
                              
                         <?php }?>  
                            
                          <?php 
                          $res30 = $objMiniPautas->buscaHistorico($con, $viewG001->id_aluno);
                          $ver_class=$res30->fetch(PDO::FETCH_OBJ);

if($ver_class->aproveitamento==""):
    echo'<td style="color:green;">Sem classificação</td>';
elseif($ver_class->aproveitamento=="Não Transita"):
echo'<td style="color:red;">'.$ver_class->aproveitamento.'</td>';
elseif($ver_class->aproveitamento=="Transita"):
    echo'<td style="color:blue;">'.$ver_class->aproveitamento.'</td>';
endif;
                          ?>  
                        
                        </tr> 
                        
                        <?php }?>
                    </tbody>
                </table>
                         
                            <form class="" action="" method="POST" class="form-inline">
                            <input type="submit" name="bt12" value="Exportar" class="btn btn-primary"/>
                            <input type="submit" name="bt2" value="Imprimir" class="btn btn-default"/>
                            </form>      

                                                                                    <?php

                                 if(isset($_POST['bt12'])){

        

    if(($_SESSION['curso']=="Geral")&&(($_SESSION['classe']=="2ª")||($_SESSION['classe']=="4ª")||($_SESSION['classe']=="6ª")||($_SESSION['classe']=="7ª")||($_SESSION['classe']=="8ª")||($_SESSION['classe']=="9ª"))):

        echo "<script>
            window.location.href='exportarPautasfinais/2_9s.php?anoSS=$anoS'
    </script>";

        endif;

          }


                            ?>  
                                </div>
                                 <!-- 2 trimestre-->
                                <div id="lB" class="tab-pane">
                                             
                  <table class="table table-bordered responsive">
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
                        <tr>
                        <th rowspan=2>Nº</th>
                            <th rowspan=2 colspan=3 width=300px>Nome Completo</th>
                               <?php
                       
                           $res2 = $objMiniPautas->buscaDisciplinas($curso, $classe, $con);
                            while($viewGG2=$res2->fetch(PDO::FETCH_OBJ)){
                                ?>
                              <th colspan="12"><?php echo $viewGG2->nome;?></th>
                            <?php
                            }?>
                        </tr>
						<tr>
			
                                                <?php 
                      $a201 = 1;
                       $conta1 = $res2->rowCount();
                      while($a201<=$conta):
                          $a201++;
                    ?>
                                
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
                          
                          <?php endwhile;?>				  
						</tr>
                    </thead>
                   <tbody>
                           <?php 
                            $res002 =$objCaderneta->buscaEstudate();
                            $a002 = 0;
                        while($viewG002 = $res002->fetch(PDO::FETCH_OBJ)){
                            $a002++;?>
                        <tr>
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
                            <td class="<?php if(($classe=="2ª")||($classe=="4ª")): if($ver_edf1->mac>=5): echo "azul"; else: echo"vermelho";  endif; else: if($ver_edf1->mac>=10): echo "azul"; else: echo"vermelho";  endif; endif;?>"><?php echo $ver_edf1->mac;?></td>
                            <td class="<?php if(($classe=="2ª")||($classe=="4ª")): if($ver_edf1->cpp>=5): echo "azul"; else: echo"vermelho";  endif; else: if($ver_edf1->cpp>=10): echo "azul"; else: echo"vermelho";  endif; endif;?>"><?php echo $ver_edf1->cpp;?></td>
                            <td class="<?php if(($classe=="2ª")||($classe=="4ª")): if($ver_edf1->ct>=5): echo "azul"; else: echo"vermelho";  endif; else: if($ver_edf1->ct>=10): echo "azul"; else: echo"vermelho";  endif; endif;?>"><?php echo $ver_edf1->ct;?></td>
                            
                             <!-- 2 trimestre-->
                            <?php 
                            $etedf2 = $objMiniPautas->buscarNotas($epoca2, $viewGG7->id_di2, $viewG002->id_aluno);
                            $ver_edf2 =$etedf2->fetch(PDO::FETCH_OBJ);
                            ?>
                            <td class="<?php if(($classe=="2ª")||($classe=="4ª")): if($ver_edf2->mac>=5): echo "azul"; else: echo"vermelho";  endif; else: if($ver_edf2->mac>=10): echo "azul"; else: echo"vermelho";  endif; endif;?>"><?php echo $ver_edf2->mac;?></td>
                            <td class="<?php if(($classe=="2ª")||($classe=="4ª")): if($ver_edf2->cpp>=5): echo "azul"; else: echo"vermelho";  endif; else: if($ver_edf2->cpp>=10): echo "azul"; else: echo"vermelho";  endif; endif;?>"><?php echo $ver_edf2->cpp;?></td>
                            <td class="<?php if(($classe=="2ª")||($classe=="4ª")): if($ver_edf2->ct>=5): echo "azul"; else: echo"vermelho";  endif; else: if($ver_edf2->ct>=10): echo "azul"; else: echo"vermelho";  endif; endif;?>"><?php echo $ver_edf2->ct;?></td>
                            
                           <!-- 3 trimestre-->
                            <?php 
                            $etedf3 = $objMiniPautas->buscarNotas($epoca3, $viewGG7->id_di2, $viewG002->id_aluno);
                            $ver_edf3 =$etedf3->fetch(PDO::FETCH_OBJ);
                            ?>
                            <td class="<?php if(($classe=="2ª")||($classe=="4ª")): if($ver_edf3->mac>=5): echo "azul"; else: echo"vermelho";  endif; else: if($ver_edf3->mac>=10): echo "azul"; else: echo"vermelho";  endif; endif;?>"><?php echo $ver_edf3->mac;?></td>
                            <td class="<?php if(($classe=="2ª")||($classe=="4ª")): if($ver_edf3->cpp>=5): echo "azul"; else: echo"vermelho";  endif; else: if($ver_edf3->cpp>=10): echo "azul"; else: echo"vermelho";  endif; endif;?>"><?php echo $ver_edf3->cpp;?></td>
                            <td class="<?php if(($classe=="2ª")||($classe=="4ª")): if($ver_edf3->ct>=5): echo "azul"; else: echo"vermelho";  endif; else: if($ver_edf3->ct>=10): echo "azul"; else: echo"vermelho";  endif; endif;?>"><?php echo $ver_edf3->ct;?></td>
                            
                              <!-- final-->
                            <?php 
                            $etedff = $objMiniPautas->buscClassFinais($viewGG7->id_di2, $viewG002->id_aluno);
                            $ver_edff =$etedff->fetch(PDO::FETCH_OBJ);
                            ?>
                            <td class="<?php if(($classe=="2ª")||($classe=="4ª")): if($ver_edff->cap>=5): echo "azul"; else: echo"vermelho";  endif; else: if($ver_edff->cap>=10): echo "azul"; else: echo"vermelho";  endif; endif;?>"><?php echo $ver_edff->cap;?></td>
                            <td class="<?php if(($classe=="2ª")||($classe=="4ª")): if($ver_edff->cpe>=5): echo "azul"; else: echo"vermelho";  endif; else: if($ver_edff->cpe>=10): echo "azul"; else: echo"vermelho";  endif; endif;?>"><?php echo $ver_edff->cpe;?></td>
                            <td class="<?php if(($classe=="2ª")||($classe=="4ª")): if($ver_edff->cf>=5): echo "azul"; else: echo"vermelho";  endif; else: if($ver_edff->cf>=10): echo "azul"; else: echo"vermelho";  endif; endif;?>"><?php echo $ver_edff->cf;?></td>
                            
                         <?php }?>
                            
                        </tr>  
                        <?php }?>
                    </tbody>
                </table>
                
                            <form class="" action="" method="POST" class="form-inline">
                            <input type="submit" name="bt1" value="Exportar" class="btn btn-primary"/>
                            <input type="submit" name="bt2" value="Imprimir" class="btn btn-default"/>
                                                        <?php

                                 if(isset($_POST['bt1'])){

        

    if(($_SESSION['curso']=="Geral")&&(($_SESSION['classe']=="2ª")||($_SESSION['classe']=="4ª")||($_SESSION['classe']=="6ª")||($_SESSION['classe']=="7ª")||($_SESSION['classe']=="8ª")||($_SESSION['classe']=="9ª"))):

        echo "<script>
            window.location.href='exportarPautasfinais/2_9t.php?anoSS=$anoS';
    </script>";

        endif;

          }


                            ?>
                            </form>  
              
                                </div>
      
                                </div>
                                
                            </div><!--tab-content-->
                        </div> 
</body>
</html>
