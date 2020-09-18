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





?>
<html>
<head><title></title>
<style>
.vermelho
{
    color:red;
}
.azul
{
    color:blue;
}
.amarelo
{
    color:orangered;
}
.verde
{
    color:green;
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
                              
                                <li class="active"><a data-toggle="tab" href="#lA"><!--1 G--></a></li>
                            </ul>
                            <div class="tab-content">
                              <!-- 1 trimestre-->
                                <div id="lA" class="tab-pane active">
                 
                  <table class="table table-bordered responsive">
              
                                <div id="lA" class="tab-pane">
                                             
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
              <th rowspan="2">Nº</th>
                            <th rowspan="2" colspan="3">Nome Completo</th>
                            <?php
                         
                           $res = $objMiniPautas->buscaDisciplinas($curso, $classe, $con);
                            while($viewGG=$res->fetch(PDO::FETCH_OBJ)){
                                ?>
                              <th colspan="9"><?php echo $viewGG->nome;?></th>
                            <?php
                            }?>
                            <th></th>
                       </tr>
            <tr style="border:1px solid #000;">
                            <?php 
                      $a200 = 1;
                       $conta = $res->rowCount();
                      while($a200<=$conta):
                          $a200++;
                    ?>
            <th style="background-color:#ff0;">MAC</th>
            <th style="background-color: #ff0;">CPP</th>
            <th>CT1</th>
            <th style="background-color: #ff0;">MAC</th>
            <th style="background-color:#ff0;">CPP</th>
            <th>CT2</th>
            <th style="background-color:#ff0;">MAC</th>
            <th style="background-color:#ff0;">CPP</th>
            <th>CT3</th>
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
                        $a001 = 0;
                        while($viewG001 = $res001->fetch(PDO::FETCH_OBJ)){
                            $a001++;
                        ?>
                        <tr style="border:1px solid #000;">
                      <td><?php echo $a001;?></td>
                            <td colspan="3"><?php echo $viewG001->nome;?></td> 
                            <?php 
                              $res7 = $objMiniPautas->buscaDisciplinas($curso, $classe, $con);
			 while($viewGG7=$res7->fetch(PDO::FETCH_OBJ)){
                          ?>
                           
                            <!-- 1 trimestre-->
                            <?php 
                            $etedf1 = $objMiniPautas->buscarNotas($epoca1, $viewGG7->id_di2, $viewG001->id_aluno);
                            $ver_edf1 =$etedf1->fetch(PDO::FETCH_OBJ);
                            ?>
                            
                            <td style="background-color:#ff0;" class="<?php if($ver_edf1->mac<=2): echo "vermelho"; else: echo "azul"; endif;?>"><?php if(($ver_edf1->mac>=1)&&($ver_edf1->mac<=2)): echo "Mau"; elseif(($ver_edf1->mac>=3)&&($ver_edf1->mac<=4)): echo "Medríuque"; elseif(($ver_edf1->mac>=5)&&($ver_edf1->mac<=6)): echo "Súfice"; elseif(($ver_edf1->mac>=7)&&($ver_edf1->mac<=8)): echo "Bom"; elseif(($ver_edf1->mac>=9)&&($ver_edf1->mac<=10)): echo "Muito Bom"; else: echo '---';endif;?></td>
                            <td style="background-color:#ff0;" class="<?php if($ver_edf1->cpp<=2): echo "vermelho"; else: echo "azul"; endif;?>"><?php if(($ver_edf1->cpp>=1)&&($ver_edf1->cpp<=2)): echo "Mau"; elseif(($ver_edf1->cpp>=3)&&($ver_edf1->cpp<=4)): echo "Medríuque"; elseif(($ver_edf1->cpp>=5)&&($ver_edf1->cpp<=6)): echo "Súfice"; elseif(($ver_edf1->cpp>=7)&&($ver_edf1->cpp<=8)): echo "Bom"; elseif(($ver_edf1->cpp>=9)&&($ver_edf1->cpp<=10)): echo "Muito Bom"; else: echo '---';endif;?></td>
                            <td class="<?php if($ver_edf1->ct<=2): echo "vermelho"; else: echo "azul"; endif;?>"><?php if(($ver_edf1->ct>=1)&&($ver_edf1->ct<=2)): echo "Mau"; elseif(($ver_edf1->ct>=3)&&($ver_edf1->ct<=4)): echo "Medríuque"; elseif(($ver_edf1->ct>=5)&&($ver_edf1->ct<=6)): echo "Súfice"; elseif(($ver_edf1->ct>=7)&&($ver_edf1->ct<=8)): echo "Bom"; elseif(($ver_edf1->ct>=9)&&($ver_edf1->ct<=10)): echo "Muito Bom"; else: echo '---';endif;?></td>
                            
                             <!-- 2 trimestre-->
                            <?php 
                            $etedf2 = $objMiniPautas->buscarNotas($epoca2, $viewGG7->id_di2, $viewG001->id_aluno);
                            $ver_edf2 =$etedf2->fetch(PDO::FETCH_OBJ);
                            ?>
                             
                             <td style="background-color:#ff0;" class="<?php if($ver_edf2->mac<=2): echo "vermelho"; else: echo "azul"; endif;?>"><?php if(($ver_edf2->mac>=1)&&($ver_edf2->mac<=2)): echo "Mau"; elseif(($ver_edf2->mac>=3)&&($ver_edf2->mac<=4)): echo "Medríuque"; elseif(($ver_edf2->mac>=5)&&($ver_edf2->mac<=6)): echo "Súfice"; elseif(($ver_edf2->mac>=7)&&($ver_edf2->mac<=8)): echo "Bom"; elseif(($ver_edf2->mac>=9)&&($ver_edf2->mac<=10)): echo "Muito Bom"; else: echo '---';endif;?></td>
                            <td style="background-color:#ff0;" class="<?php if($ver_edf2->cpp<=2): echo "vermelho"; else: echo "azul"; endif;?>"><?php if(($ver_edf2->cpp>=1)&&($ver_edf2->cpp<=2)): echo "Mau"; elseif(($ver_edf2->cpp>=3)&&($ver_edf2->cpp<=4)): echo "Medríuque"; elseif(($ver_edf2->cpp>=5)&&($ver_edf2->cpp<=6)): echo "Súfice"; elseif(($ver_edf2->cpp>=7)&&($ver_edf2->cpp<=8)): echo "Bom"; elseif(($ver_edf2->cpp>=9)&&($ver_edf2->cpp<=10)): echo "Muito Bom"; else: echo '---';endif;?></td>
                            <td class="<?php if($ver_edf2->ct<=2): echo "vermelho"; else: echo "azul"; endif;?>"><?php if(($ver_edf2->ct>=1)&&($ver_edf2->ct<=2)): echo "Mau"; elseif(($ver_edf2->ct>=3)&&($ver_edf2->ct<=4)): echo "Medríuque"; elseif(($ver_edf2->ct>=5)&&($ver_edf2->ct<=6)): echo "Súfice"; elseif(($ver_edf2->ct>=7)&&($ver_edf2->ct<=8)): echo "Bom"; elseif(($ver_edf2->ct>=9)&&($ver_edf2->ct<=10)): echo "Muito Bom"; else: echo '---';endif;?></td>
                            
                               <!-- 3 trimestre-->
                            <?php 
                            $etedf3 = $objMiniPautas->buscarNotas($epoca3, $viewGG7->id_di2, $viewG001->id_aluno);
                            $ver_edf3 =$etedf3->fetch(PDO::FETCH_OBJ);
                            ?>
                            
                             <td style="background-color:#ff0;" class="<?php if($ver_edf3->mac<=2): echo "vermelho"; else: echo "azul"; endif;?>"><?php if(($ver_edf3->mac>=1)&&($ver_edf3->mac<=2)): echo "Mau"; elseif(($ver_edf3->mac>=3)&&($ver_edf3->mac<=4)): echo "Medríuque"; elseif(($ver_edf3->mac>=5)&&($ver_edf3->mac<=6)): echo "Súfice"; elseif(($ver_edf3->mac>=7)&&($ver_edf3->mac<=8)): echo "Bom"; elseif(($ver_edf3->mac>=9)&&($ver_edf3->mac<=10)): echo "Muito Bom"; else: echo '---';endif;?></td>
                            <td style="background-color:#ff0;" class="<?php if($ver_edf3->cpp<=2): echo "vermelho"; else: echo "azul"; endif;?>"><?php if(($ver_edf3->cpp>=1)&&($ver_edf3->cpp<=2)): echo "Mau"; elseif(($ver_edf3->cpp>=3)&&($ver_edf3->cpp<=4)): echo "Medríuque"; elseif(($ver_edf3->cpp>=5)&&($ver_edf3->cpp<=6)): echo "Súfice"; elseif(($ver_edf3->cpp>=7)&&($ver_edf3->cpp<=8)): echo "Bom"; elseif(($ver_edf3->cpp>=9)&&($ver_edf3->cpp<=10)): echo "Muito Bom"; else: echo '---';endif;?></td>
                            <td class="<?php if($ver_edf3->ct<=2): echo "vermelho"; else: echo "azul"; endif;?>"><?php if(($ver_edf3->ct>=1)&&($ver_edf3->ct<=2)): echo "Mau"; elseif(($ver_edf3->ct>=3)&&($ver_edf3->ct<=4)): echo "Medríuque"; elseif(($ver_edf3->ct>=5)&&($ver_edf3->ct<=6)): echo "Súfice"; elseif(($ver_edf3->ct>=7)&&($ver_edf3->ct<=8)): echo "Bom"; elseif(($ver_edf3->ct>=9)&&($ver_edf3->ct<=10)): echo "Muito Bom"; else: echo '---';endif;?></td>
                            
                              <?php }?> 

                        </tr>
<?php }?>
     </tbody>
                </table>
                
              
                                </div>

                                
                            </div><!--tab-content-->
                        </div> 
</body>
</html>
