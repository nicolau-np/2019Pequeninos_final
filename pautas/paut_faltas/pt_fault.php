<?php 

$epoca1=1;
$epoca2=2;
$epoca3=3;
$anoS=date("Y");
$curso=$_GET['curso'];
$classe=$_GET['classe'];
$turma=$_GET['turma'];
$turno=$_GET['turno'];

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
</style>
</head>
<body>
         <div class="tabs-left">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#lA"></a></li>
                                
                            </ul>
                            <div class="tab-content">
                              <!-- 1 trimestre-->
                                <div id="lA" class="tab-pane active">
                 
                
                                    <table class="table table-bordered table-responsive">
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
                        <th>- - -</th>
                            <th>Nº</th>
                            <th colspan="3">Nome Completo</th>
                             <?php
                         
                           $res = $objMiniPautas->buscaDisciplinas($curso, $classe, $con);
                            while($viewGG=$res->fetch(PDO::FETCH_OBJ)){
                                ?>
                            <th><?php echo $viewGG->nome;?></th>
                            <?php
                            }?>
                            <th>Total de Faltas</th>
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
                            <td>--</td>
                            <td><?php echo $a001;?></td>
                            <td colspan="3"><?php echo $viewG001->nome;?></td> 
                            <?php
                         $contafaltas = 0;
                           $res2 = $objMiniPautas->buscaDisciplinas($curso, $classe, $con);
                            while($viewGG2=$res2->fetch(PDO::FETCH_OBJ)){
                                $res5 = $objMiniPautas->buscClassFinais($viewGG2->id_di2, $viewG001->id_aluno);
                                $viewGG5 = $res5->fetch(PDO::FETCH_OBJ);
                                $contafaltas = $contafaltas + $viewGG5->total_faltas;

                                ?>
                          <td class="<?php if($viewGG5->total_faltas<=2):echo "azul"; else: echo "vermelho";endif;?>"><?php echo $viewGG5->total_faltas; ?></td>
                            
                            <?php
                            }?>
                          <td><?php echo $contafaltas;?></td>
                        </tr>
<?php }?> 
                    </tbody>
                </table>     
                                    
                         <br/>
                            <form class="" method="POST" class="form-inline">
                            <input type="submit" name="bt1" value="Exportar" class="btn btn-primary"/>
                            <input type="submit" name="bt2" value="Imprimir" class="btn btn-default"/>
                            </form>        
                                </div>
                          
                                
                            </div><!--tab-content-->
                        </div> 
</body>
</html>
