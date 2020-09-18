<style>
    .vermelho{
        color:#990000;
    }
    .azul{
        color:#0044cc;
    }
    </style>
<?php 
 include 'config/conn.php';
 
 $curso="Geral";
 $classe="9ª";
 $turma=2;
 $turno="Tarde";
 $anoS=2018;
         
 ?>

                  <table border="1">
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
                            <th>Nome Completo</th>
                            <?php
                            $sql="select *from view_disciplinas where curso=:curso and classe=:classe";
                            $run=$con->prepare($sql);
                            $run->bindParam(":curso",$curso,PDO::PARAM_STR);
                            $run->bindParam(":classe",$classe,PDO::PARAM_STR);
                            $run->execute();
                            while($viewGG=$run->fetch(PDO::FETCH_OBJ)){
                                ?>
                            <th><?php echo $viewGG->nome;?></th>
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
                            <td>--</td>
                            <td><?php echo $a;?></td>
                            <td><?php echo $viewGH->nome;?></td>
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
                            <td class="<?php if($ver1->cf>=10): echo "azul"; else: echo"vermelho"; endif;?>"><?php echo $ver1->cf;?></td>
                              <?php }?>  
                        </tr>
<?php }?>
 </tbody>
 </table>