<?php 
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
                            <th>OBSERVAÇÃO</th>
                     
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
                        <tr>

                            <td><?php echo $a1;?></td>
                            <td><?php echo $ver_es->nome;?></td>
                            
                            <?php 
                            $busMiniPautas1 = $objMiniPautas->buscarNotas($epoca1,  $v4->id_di2, $ver_es->id_aluno);
                            $ver_epoca1 = $busMiniPautas1->fetch(PDO::FETCH_OBJ);
                            ?>
                            
                            <td class="<?php if($ver_epoca1->mac>=10): echo "azul"; else: echo "vermelho";endif;?>"><?php echo $ver_epoca1->mac;?></td>
                            <td class="<?php if($ver_epoca1->cpp>=10): echo "azul"; else: echo "vermelho";endif;?>"><?php echo $ver_epoca1->cpp;?></td>
                            <td class="<?php if($ver_epoca1->ct>=10): echo "azul"; else: echo "vermelho";endif;?>"><?php echo $ver_epoca1->ct;?></td>
                            
                             <?php 
                            $busMiniPautas2 = $objMiniPautas->buscarNotas($epoca2,  $v4->id_di2, $ver_es->id_aluno);
                            $ver_epoca2 = $busMiniPautas2->fetch(PDO::FETCH_OBJ);
                            ?>
                            
                            <td class="<?php if($ver_epoca2->mac>=10): echo "azul"; else: echo "vermelho";endif;?>"><?php echo $ver_epoca2->mac;?></td>
                            <td class="<?php if($ver_epoca2->cpp>=10): echo "azul"; else: echo "vermelho";endif;?>"><?php echo $ver_epoca2->cpp;?></td>
                            <td class="<?php if($ver_epoca2->ct>=10): echo "azul"; else: echo "vermelho";endif;?>"><?php echo $ver_epoca2->ct;?></td>
                            
                              <?php 
                            $busMiniPautas3 = $objMiniPautas->buscarNotas($epoca3,  $v4->id_di2, $ver_es->id_aluno);
                            $ver_epoca3 = $busMiniPautas3->fetch(PDO::FETCH_OBJ);
                            ?>
                            
                            <td class="<?php if($ver_epoca3->mac>=10): echo "azul"; else: echo "vermelho";endif;?>"><?php echo $ver_epoca3->mac;?></td>
                            <td class="<?php if($ver_epoca3->cpp>=10): echo "azul"; else: echo "vermelho";endif;?>"><?php echo $ver_epoca3->cpp;?></td>
                            <td class="<?php if($ver_epoca3->ct>=10): echo "azul"; else: echo "vermelho";endif;?>"><?php echo $ver_epoca3->ct;?></td>
                            
                            
                              <?php 
                            $busMiniPautasF = $objMiniPautas->buscClassFinais($v4->id_di2, $ver_es->id_aluno);
                            $ver_clas_finais = $busMiniPautasF->fetch(PDO::FETCH_OBJ);
                            ?>
                            
                            <td class="<?php if($ver_clas_finais->cap>=10): echo "azul"; else: echo "vermelho";endif;?>"><?php echo $ver_clas_finais->cap;?></td>
                            <td class="<?php if($ver_clas_finais->cpe>=10): echo "azul"; else: echo "vermelho";endif;?>"><?php echo $ver_clas_finais->cpe;?></td>
                            <td class="<?php if($ver_clas_finais->cf>=10): echo "azul"; else: echo "vermelho";endif;?>"><?php echo $ver_clas_finais->cf;?></td>
                           <td class="<?php if($ver_clas_finais->observacao=="Transita"): echo "azul"; else: echo "vermelho";endif;?>"><?php echo $ver_clas_finais->observacao;?></td>  
                           
                        </tr>
                        <?php } endif;?>
                       
                        
                    </tbody>
                </table></div></div>
