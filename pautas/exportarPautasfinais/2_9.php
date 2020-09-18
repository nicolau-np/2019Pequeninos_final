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
        //$disciplina=$_SESSION['disciplina'];
        $anoS=$_GET['anoSS'];


        $epoca1=1;
        $epoca2=2;
        $epoca3=3;

header("Content-Type: application/vnd.ms-excel");
header("Content-Type: application/force-download");
header("Content-disposition: attachment; filename=$curso-$classe-$turma-$turno-$anoS.xls");
header("Pragma:no-Cache");







/*$epoca1=1;
$epoca2=2;
$epoca3=3;
$anoS=date("Y");
$curso=$_GET['curso'];
$classe=$_GET['classe'];
$turma=$_GET['turma'];
$turno=$_GET['turno'];*/

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

         <div class="tabs-left">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#lA"><!--1 Geral--></a></li>
                                <li class=""><a data-toggle="tab" href="#lB"><!--2 Geral--></a></li>
                           
                            </ul>
                            <div class="tab-content">
                              <!-- 1 trimestre-->
                                <div id="lA" class="tab-pane active">
                 
                  <table class="table table-bordered responsive" border="1">
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
if(isset($_POST['bt12'])){
header("Content-Type: application/vnd.ms-excel");
header("Content-Type: application/force-download");
header("Content-disposition: attachment; filename=$curso-$classe-$turma-$turno-$anoS.xls");
header("Pragma:no-Cache");

                            $sql="select *from view_disciplinas where curso=:curso and classe=:classe";
                            $run=$con->prepare($sql);
                            $run->bindParam(":curso",$curso,PDO::PARAM_STR);
                            $run->bindParam(":classe",$classe,PDO::PARAM_STR);
                            $run->execute();
                            while($viewGG=$run->fetch(PDO::FETCH_OBJ)){
                                ?>
                              <th colspan="3"><?php echo $viewGG->nome;?></th>
                            <?php
                            }?>
                            <th rowspan=2>OBSERVAÇÃO</th>
                        </tr>
				<?php
                            $sql2="select *from view_disciplinas where curso=:curso and classe=:classe";
                            $run2=$con->prepare($sql2);
                            $run2->bindParam(":curso",$curso,PDO::PARAM_STR);
                            $run2->bindParam(":classe",$classe,PDO::PARAM_STR);
                            $run2->execute();
                            while($viewGG2=$run2->fetch(PDO::FETCH_OBJ)){
                                ?>		 
                            <th>CAP</th>
                            <th>CPE/CE</th>
                            <th>CF</th>
                           <?php
                            }
                           ?>
                        </tr>
						
                    </thead>
                    <tbody>
                     
                            <?php
                        $co0="select * from view_estudante where curso=:curso and classe=:classe and turma=:turma and turno=:turno and anolectivo=:ano order by nome asc ";
$re0=$con->prepare($co0);
$re0->bindParam(":curso",$curso,PDO::PARAM_STR);
$re0->bindParam(":classe",$classe,PDO::PARAM_STR);
$re0->bindParam(":turma",$turma,PDO::PARAM_STR);
$re0->bindParam(":turno",$turno,PDO::PARAM_STR);
$re0->bindParam(":ano",$anoS,PDO::PARAM_STR);
$re0->execute();
$a=0;
while($viewGH=$re0->fetch(PDO::FETCH_OBJ)){
    $a++;
                        ?>
                        <tr>
                          
                            <td><?php echo $a;?></td>
                            <td colspan="3"><?php echo $viewGH->nome;?></td>
                             <?php
                            $sql="select *from view_disciplinas where curso=:curso and classe=:classe";
                            $run=$con->prepare($sql);
                            $run->bindParam(":curso",$curso,PDO::PARAM_STR);
                            $run->bindParam(":classe",$classe,PDO::PARAM_STR);
                            $run->execute();
                            while($viewGG=$run->fetch(PDO::FETCH_OBJ)){
$co1="select *from view_clas_finais where disciplina=:disciplina and anolectivo=:ano and id_aluno=:id";
$re1=$con->prepare($co1);
$re1->bindParam(":disciplina",$viewGG->nome,PDO::PARAM_STR);
$re1->bindParam(":ano",$anoS,PDO::PARAM_STR);
$re1->bindParam(":id",$viewGH->id_aluno,PDO::PARAM_STR);
$re1->execute();
$ver1=$re1->fetch(PDO::FETCH_OBJ);
                                ?>
                            <td class="<?php if(($classe=="2ª")||($classe=="4ª")): if($ver1->cap>=5): echo "azul"; else: echo"vermelho";  endif; else: if($ver1->cap>=10): echo "azul"; else: echo"vermelho";  endif; endif;?>"><?php echo $ver1->cap;?></td>
                            <td class="<?php if(($classe=="2ª")||($classe=="4ª")): if($ver1->cpe>=5): echo "azul"; else: echo"vermelho";  endif; else: if($ver1->cpe>=10): echo "azul"; else: echo"vermelho";  endif; endif;?>"><?php echo $ver1->cpe;?></td>
                            <td class="<?php if(($classe=="2ª")||($classe=="4ª")): if($ver1->cf>=5): echo "azul"; else: echo"vermelho";  endif; else: if($ver1->cf>=10): echo "azul"; else: echo"vermelho";  endif; endif;?>"><?php echo $ver1->cf;?></td>
                              <?php }?>
                            

                        </tr>
<?php } } else{ ?>
                       
                    </tbody>
                </table>
                         
                            <!--<form class="" method="POST" class="form-inline">
                            <input type="submit" name="bt1" value="Exportar" class="btn btn-primary"/>
                            <input type="submit" name="bt2" value="Imprimir" class="btn btn-default"/>
                            </form>    -->   

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
                        <th rowspan=2></th>
                            <th rowspan=2 colspan=3 width=300px></th>
                             <?php
                            $sql="select *from view_disciplinas where curso=:curso and classe=:classe";
                            $run=$con->prepare($sql);
                            $run->bindParam(":curso",$curso,PDO::PARAM_STR);
                            $run->bindParam(":classe",$classe,PDO::PARAM_STR);
                            $run->execute();
                            while($viewGG=$run->fetch(PDO::FETCH_OBJ)){
                                ?>
                            <th colspan="12"><?php echo utf8_decode($viewGG->nome);?></th>
                            <?php
                            }
                           ?>
                        </tr>
						<tr>
						  <?php
                            $sql2="select *from view_disciplinas where curso=:curso and classe=:classe";
                            $run2=$con->prepare($sql2);
                            $run2->bindParam(":curso",$curso,PDO::PARAM_STR);
                            $run2->bindParam(":classe",$classe,PDO::PARAM_STR);
                            $run2->execute();
                            while($viewGG2=$run2->fetch(PDO::FETCH_OBJ)){
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
                            <?php
                            }
                           ?>
						
						  
						</tr>
                    </thead>
                    <tbody>
                    <?php 
//matematica
 $epoca1=1;
 $epoca2=2;
 $epoca3=3;



$co0="select * from view_estudante where curso=:curso and classe=:classe and turma=:turma and turno=:turno and anolectivo=:ano order by nome asc ";
$re0=$con->prepare($co0);
$re0->bindParam(":curso",$curso,PDO::PARAM_STR);
$re0->bindParam(":classe",$classe,PDO::PARAM_STR);
$re0->bindParam(":turma",$turma,PDO::PARAM_STR);
$re0->bindParam(":turno",$turno,PDO::PARAM_STR);
$re0->bindParam(":ano",$anoS,PDO::PARAM_STR);
$re0->execute();
$a2=0;
while($viewGH=$re0->fetch(PDO::FETCH_OBJ)){
    $a2++;
                        ?>
                        <tr>
                      
                            <td><?php echo $a2;?></td>
                            <td colspan="3"><?php echo utf8_decode($viewGH->nome);?></td>
                             <?php
                            $sql="select *from view_disciplinas where curso=:curso and classe=:classe";
                            $run=$con->prepare($sql);
                            $run->bindParam(":curso",$curso,PDO::PARAM_STR);
                            $run->bindParam(":classe",$classe,PDO::PARAM_STR);
                            $run->execute();
                            while($viewGG=$run->fetch(PDO::FETCH_OBJ)){

                                 $rtedf1="select *from view_notas where  anoLetivo=:ano and epoca=:epoca and disciplina=:di and id_aluno=:id";
                    $etedf1=$con->prepare($rtedf1);
                      $etedf1->bindParam(":ano",$anoS,PDO::PARAM_STR);
                     $etedf1->bindParam(":epoca",$epoca1,PDO::PARAM_STR);
                     $etedf1->bindParam(":di",$viewGG->nome,PDO::PARAM_STR);
                     $etedf1->bindParam(":id",$viewGH->id_aluno,PDO::PARAM_STR);
                    $etedf1->execute();
                    $ver_edf1 =$etedf1->fetch(PDO::FETCH_OBJ);
                   
                    
                     $rtedf2="select *from view_notas where anoLetivo=:ano and epoca=:epoca and disciplina=:di and id_aluno=:id";
                    $etedf2=$con->prepare($rtedf2);
                      $etedf2->bindParam(":ano",$anoS,PDO::PARAM_STR);
                     $etedf2->bindParam(":epoca",$epoca2,PDO::PARAM_STR);
                     $etedf2->bindParam(":di",$viewGG->nome,PDO::PARAM_STR);
                     $etedf2->bindParam(":id",$viewGH->id_aluno,PDO::PARAM_STR);
                     $etedf2->execute();
                     $ver_edf2 =$etedf2->fetch(PDO::FETCH_OBJ);
                   
                    $rtedf3="select *from view_notas where  anoLetivo=:ano and epoca=:epoca and disciplina=:di and id_aluno=:id";
                    $etedf3=$con->prepare($rtedf3);
                      $etedf3->bindParam(":ano",$anoS,PDO::PARAM_STR);
                     $etedf3->bindParam(":epoca",$epoca3,PDO::PARAM_STR);
                     $etedf3->bindParam(":di",$viewGG->nome,PDO::PARAM_STR);
                     $etedf3->bindParam(":id",$viewGH->id_aluno,PDO::PARAM_STR);
                    $etedf3->execute();
                    $ver_edf3 =$etedf3->fetch(PDO::FETCH_OBJ);
                    
                    $rtedff="select *from view_clas_finais where id_aluno=:id_aluno and disciplina=:disciplina and anolectivo=:ano order by nome asc";
					$etedff=$con->prepare($rtedff);
					$etedff->bindParam(":id_aluno",$viewGH->id_aluno,PDO::PARAM_STR);

					$etedff->bindParam(":disciplina",$viewGG->nome,PDO::PARAM_STR);
					$etedff->bindParam(":ano",$anoS,PDO::PARAM_STR);
					$etedff->execute();
                                       $ver_edff =$etedff->fetch(PDO::FETCH_OBJ); 
					
                    ?>
                           <td class="<?php if(($classe=="2ª")||($classe=="4ª")): if($ver_edf1->mac>=5): echo "azul"; else: echo"vermelho";  endif; else: if($ver_edf1->mac>=10): echo "azul"; else: echo"vermelho";  endif; endif;?>"><?php echo $ver_edf1->mac;?></td>
                            <td class="<?php if(($classe=="2ª")||($classe=="4ª")): if($ver_edf1->cpp>=5): echo "azul"; else: echo"vermelho";  endif; else: if($ver_edf1->cpp>=10): echo "azul"; else: echo"vermelho";  endif; endif;?>"><?php echo $ver_edf1->cpp;?></td>
                            <td class="<?php if(($classe=="2ª")||($classe=="4ª")): if($ver_edf1->ct>=5): echo "azul"; else: echo"vermelho";  endif; else: if($ver_edf1->ct>=10): echo "azul"; else: echo"vermelho";  endif; endif;?>"><?php echo $ver_edf1->ct;?></td>
                            
                             <td class="<?php if(($classe=="2ª")||($classe=="4ª")): if($ver_edf2->mac>=5): echo "azul"; else: echo"vermelho";  endif; else: if($ver_edf2->mac>=10): echo "azul"; else: echo"vermelho";  endif; endif;?>"><?php echo $ver_edf2->mac;?></td>
                            <td class="<?php if(($classe=="2ª")||($classe=="4ª")): if($ver_edf2->cpp>=5): echo "azul"; else: echo"vermelho";  endif; else: if($ver_edf2->cpp>=10): echo "azul"; else: echo"vermelho";  endif; endif;?>"><?php echo $ver_edf2->cpp;?></td>
                            <td class="<?php if(($classe=="2ª")||($classe=="4ª")): if($ver_edf2->ct>=5): echo "azul"; else: echo"vermelho";  endif; else: if($ver_edf2->ct>=10): echo "azul"; else: echo"vermelho";  endif; endif;?>"><?php echo $ver_edf2->ct;?></td>
                            
                            <td class="<?php if(($classe=="2ª")||($classe=="4ª")): if($ver_edf3->mac>=5): echo "azul"; else: echo"vermelho";  endif; else: if($ver_edf3->mac>=10): echo "azul"; else: echo"vermelho";  endif; endif;?>"><?php echo $ver_edf3->mac;?></td>
                            <td class="<?php if(($classe=="2ª")||($classe=="4ª")): if($ver_edf3->cpp>=5): echo "azul"; else: echo"vermelho";  endif; else: if($ver_edf3->cpp>=10): echo "azul"; else: echo"vermelho";  endif; endif;?>"><?php echo $ver_edf3->cpp;?></td>
                            <td class="<?php if(($classe=="2ª")||($classe=="4ª")): if($ver_edf3->ct>=5): echo "azul"; else: echo"vermelho";  endif; else: if($ver_edf3->ct>=10): echo "azul"; else: echo"vermelho";  endif; endif;?>"><?php echo $ver_edf3->ct;?></td>
                            
                            <td class="<?php if(($classe=="2ª")||($classe=="4ª")): if($ver_edff->cap>=5): echo "azul"; else: echo"vermelho";  endif; else: if($ver_edff->cap>=10): echo "azul"; else: echo"vermelho";  endif; endif;?>"><?php echo $ver_edff->cap;?></td>
                            <td class="<?php if(($classe=="2ª")||($classe=="4ª")): if($ver_edff->cpe>=5): echo "azul"; else: echo"vermelho";  endif; else: if($ver_edff->cpe>=10): echo "azul"; else: echo"vermelho";  endif; endif;?>"><?php echo $ver_edff->cpe;?></td>
                            <td class="<?php if(($classe=="2ª")||($classe=="4ª")): if($ver_edff->cf>=5): echo "azul"; else: echo"vermelho";  endif; else: if($ver_edff->cf>=10): echo "azul"; else: echo"vermelho";  endif; endif;?>"><?php echo $ver_edff->cf;?></td>
                            
                              <?php } }?>  
                          
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
