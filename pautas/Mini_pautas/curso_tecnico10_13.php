<div class="table-wrapper"><div class="scrollable"><table class="table table-bordered responsive">
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
                        <tr>
                        <th colspan="2" class="center">Dados Aluno</th>
                        <th colspan="3" class="center">1º Trimestre</th>
                         <th colspan="3" class="center">2º Trimestre</th>
                          <th colspan="3" class="center">3º Trimestre</th>
                          <th colspan="5" class="center">Resultados Finais</th>
                         </tr>

                            <th>Nº</th>
                            <th>Nome Completo</th>
                            <th>IT1</th>
                            <th>MPP1</th>
                            <th>C1P</th>
                              <th>IT2</th>
                            <th>MPP2</th>
                            <th>C2P</th>
                              <th>IT3</th>
                            <th>MPP3</th>
                            <th>C3P</th>
                            
                            <th>CF</th>
                              <th>PG/CE</th>
                            <th>CA</th>
                            <th>OBSERVAÇÃO</th>                     
                            </tr>
                    </thead>
                    <tbody>
                      <?php 
                     
       
                    $epoca1=1;
                    $epoca2=2;
                    $epoca3=3;
                    
					
					

                    $rtx="select *from view_notas where curso=:curso and classe=:classe and turma=:turma and turno=:turno and anoLetivo=:ano and epoca=:epoca and disciplina=:di order by nome asc";
                    $etx=$con->prepare($rtx);
                    $etx->bindParam(":curso",$curso200,PDO::PARAM_STR);
                     $etx->bindParam(":classe",$classe200,PDO::PARAM_STR);
                      $etx->bindParam(":turma",$turma200,PDO::PARAM_STR);
                     $etx->bindParam(":turno",$turno200,PDO::PARAM_STR);
                      $etx->bindParam(":ano",$anoLectivo,PDO::PARAM_STR);
                     $etx->bindParam(":epoca",$epoca1,PDO::PARAM_STR);
                     $etx->bindParam(":di",$disciplina200,PDO::PARAM_STR);
                    $etx->execute();
                    $a1=0;
                    
                     $rtx2="select *from view_notas where curso=:curso and classe=:classe and turma=:turma and turno=:turno and anoLetivo=:ano and epoca=:epoca and disciplina=:di order by nome asc";
                    $etx2=$con->prepare($rtx2);
                    $etx2->bindParam(":curso",$curso200,PDO::PARAM_STR);
                     $etx2->bindParam(":classe",$classe200,PDO::PARAM_STR);
                      $etx2->bindParam(":turma",$turma200,PDO::PARAM_STR);
                     $etx2->bindParam(":turno",$turno200,PDO::PARAM_STR);
                      $etx2->bindParam(":ano",$anoLectivo,PDO::PARAM_STR);
                     $etx2->bindParam(":epoca",$epoca2,PDO::PARAM_STR);
                     $etx2->bindParam(":di",$disciplina200,PDO::PARAM_STR);
                     $etx2->execute();
                   
                    $rtx3="select *from view_notas where curso=:curso and classe=:classe and turma=:turma and turno=:turno and anoLetivo=:ano and epoca=:epoca and disciplina=:di order by nome asc";
                    $etx3=$con->prepare($rtx3);
                    $etx3->bindParam(":curso",$curso200,PDO::PARAM_STR);
                     $etx3->bindParam(":classe",$classe200,PDO::PARAM_STR);
                      $etx3->bindParam(":turma",$turma200,PDO::PARAM_STR);
                     $etx3->bindParam(":turno",$turno200,PDO::PARAM_STR);
                      $etx3->bindParam(":ano",$anoLectivo,PDO::PARAM_STR);
                     $etx3->bindParam(":epoca",$epoca3,PDO::PARAM_STR);
                     $etx3->bindParam(":di",$disciplina200,PDO::PARAM_STR);
                    $etx3->execute();
                   
                   
                   //clasificativas finais
                   $rtx4="select *from view_clas_finais where curso=:curso and classe=:classe and turma=:turma and turno=:turno and anolectivo=:ano and disciplina=:di order by nome asc";
                    $etx4=$con->prepare($rtx4);
                    $etx4->bindParam(":curso",$curso200,PDO::PARAM_STR);
                     $etx4->bindParam(":classe",$classe200,PDO::PARAM_STR);
                      $etx4->bindParam(":turma",$turma200,PDO::PARAM_STR);
                     $etx4->bindParam(":turno",$turno200,PDO::PARAM_STR);
                      $etx4->bindParam(":ano",$anoLectivo,PDO::PARAM_STR);
                     $etx4->bindParam(":di",$disciplina200,PDO::PARAM_STR);
                    $etx4->execute();
                    
					$cony=$etx->rowCount();
					if($cony==0):
					echo "Mini pauta indisponível!";
                    else:
                    while(($ver_epoca1=$etx->fetch(PDO::FETCH_OBJ))&&($ver_epoca2=$etx2->fetch(PDO::FETCH_OBJ))&&($ver_epoca3=$etx3->fetch(PDO::FETCH_OBJ))&&($ver_clas_finais=$etx4->fetch(PDO::FETCH_OBJ)))
                    {
                     $a1++;   
                   
                    ?>
                        <tr>

                            <td><?php echo $a1;?></td>
                            <td><?php echo $ver_epoca1->nome;?></td>
                            <td class="<?php if($ver_epoca1->mac>=10): echo "azul"; else: echo "vermelho";endif;?>"><?php echo $ver_epoca1->mac;?></td>
                            <td class="<?php if($ver_epoca1->cpp>=10): echo "azul"; else: echo "vermelho";endif;?>"><?php echo $ver_epoca1->cpp;?></td>
                            <td class="<?php if($ver_epoca1->ct>=10): echo "azul"; else: echo "vermelho";endif;?>"><?php echo $ver_epoca1->ct;?></td>
                            <td class="<?php if($ver_epoca2->mac>=10): echo "azul"; else: echo "vermelho";endif;?>"><?php echo $ver_epoca2->mac;?></td>
                            <td class="<?php if($ver_epoca2->cpp>=10): echo "azul"; else: echo "vermelho";endif;?>"><?php echo $ver_epoca2->cpp;?></td>
                            <td class="<?php if($ver_epoca2->ct>=10): echo "azul"; else: echo "vermelho";endif;?>"><?php echo $ver_epoca2->ct;?></td>
                            <td class="<?php if($ver_epoca3->mac>=10): echo "azul"; else: echo "vermelho";endif;?>"><?php echo $ver_epoca3->mac;?></td>
                            <td class="<?php if($ver_epoca3->cpp>=10): echo "azul"; else: echo "vermelho";endif;?>"><?php echo $ver_epoca3->cpp;?></td>
                            <td class="<?php if($ver_epoca3->ct>=10): echo "azul"; else: echo "vermelho";endif;?>"><?php echo $ver_epoca3->ct;?></td>
                            <td class="<?php if($ver_clas_finais->cap>=10): echo "azul"; else: echo "vermelho";endif;?>"><?php echo $ver_clas_finais->cap;?></td>
                            <td class="<?php if($ver_clas_finais->cpe>=10): echo "azul"; else: echo "vermelho";endif;?>"><?php echo $ver_clas_finais->cpe;?></td>
                            <td class="<?php if($ver_clas_finais->cf>=10): echo "azul"; else: echo "vermelho";endif;?>"><?php echo $ver_clas_finais->cf;?></td>
                           <td class="<?php if($ver_clas_finais->observacao=="Transita"): echo "azul"; else: echo "vermelho";endif;?>"><?php echo $ver_clas_finais->observacao;?></td>  
                           
                        </tr>
                        <?php } endif;?>
                       
                        
                    </tbody>
                </table></div></div>
