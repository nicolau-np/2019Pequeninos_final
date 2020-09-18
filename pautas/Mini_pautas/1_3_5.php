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
                            
                            <td class="<?php if($ver_epoca1->mac<=2): echo "vermelho";else: echo "azul"; endif;?>"><?php if(($ver_epoca1->mac>=1)&&($ver_epoca1->mac<=2)): echo "Mau"; elseif(($ver_epoca1->mac>=3)&&($ver_epoca1->mac<=4)): echo "Medríuque"; elseif(($ver_epoca1->mac>=5)&&($ver_epoca1->mac<=6)): echo "Súfice"; elseif(($ver_epoca1->mac>=7)&&($ver_epoca1->mac<=8)): echo "Bom"; elseif(($ver_epoca1->mac>=9)&&($ver_epoca1->mac<=10)): echo "Muito Bom"; elseif($ver_epoca1->mac=="---"): echo"---"; endif;?></td>
                            <td class="<?php if($ver_epoca1->cpp<=2): echo "vermelho"; else: echo"azul"; endif;?>"><?php if(($ver_epoca1->cpp>=1)&&($ver_epoca1->cpp<=2)): echo "Mau"; elseif(($ver_epoca1->cpp>=3)&&($ver_epoca1->cpp<=4)): echo "Medríuque"; elseif(($ver_epoca1->cpp>=5)&&($ver_epoca1->cpp<=6)): echo "Súfice"; elseif(($ver_epoca1->cpp>=7)&&($ver_epoca1->cpp<=8)): echo "Bom"; elseif(($ver_epoca1->cpp>=9)&&($ver_epoca1->cpp<=10)): echo "Muito Bom"; elseif($ver_epoca1->cpp=="---"): echo"---"; endif;?></td>
                            <td class="<?php if($ver_epoca1->ct<=2): echo "vermelho"; else: echo "azul"; endif;?>"><?php if(($ver_epoca1->ct>=1)&&($ver_epoca1->ct<=2)): echo "Mau"; elseif(($ver_epoca1->ct>=3)&&($ver_epoca1->ct<=4)): echo "Medríuque"; elseif(($ver_epoca1->ct>=5)&&($ver_epoca1->ct<=6)): echo "Súfice"; elseif(($ver_epoca1->ct>=7)&&($ver_epoca1->ct<=8)): echo "Bom"; elseif(($ver_epoca1->ct>=9)&&($ver_epoca1->ct<=10)): echo "Muito Bom"; elseif($ver_epoca1->ct=="---"): echo"---"; endif;?></td>
                            
                             <?php 
                            $busMiniPautas2 = $objMiniPautas->buscarNotas($epoca2,  $v4->id_di2, $ver_es->id_aluno);
                            $ver_epoca2 = $busMiniPautas2->fetch(PDO::FETCH_OBJ);
                            ?>
                            
                            <td class="<?php if($ver_epoca2->mac<=2): echo "vermelho"; else: echo "azul"; endif;?>"><?php if(($ver_epoca2->mac>=1)&&($ver_epoca2->mac<=2)): echo "Mau"; elseif(($ver_epoca2->mac>=3)&&($ver_epoca2->mac<=4)): echo "Medríuque"; elseif(($ver_epoca2->mac>=5)&&($ver_epoca2->mac<=6)): echo "Súfice"; elseif(($ver_epoca2->mac>=7)&&($ver_epoca2->mac<=8)): echo "Bom"; elseif(($ver_epoca2->mac>=9)&&($ver_epoca2->mac<=10)): echo "Muito Bom"; elseif($ver_epoca2->mac=="---"): echo"---"; endif;?></td>
                            <td class="<?php if($ver_epoca2->cpp<=2): echo "vermelho"; else: echo "azul"; endif;?>"><?php if(($ver_epoca2->cpp>=1)&&($ver_epoca2->cpp<=2)): echo "Mau"; elseif(($ver_epoca2->cpp>=3)&&($ver_epoca2->cpp<=4)): echo "Medríuque"; elseif(($ver_epoca2->cpp>=5)&&($ver_epoca2->cpp<=6)): echo "Súfice"; elseif(($ver_epoca2->cpp>=7)&&($ver_epoca2->cpp<=8)): echo "Bom"; elseif(($ver_epoca2->cpp>=9)&&($ver_epoca2->cpp<=10)): echo "Muito Bom"; elseif($ver_epoca2->cpp=="---"): echo"---"; endif;?></td>
                            <td class="<?php if($ver_epoca2->ct<=2): echo "vermelho"; else: echo "azul"; endif;?>"><?php if(($ver_epoca2->ct>=1)&&($ver_epoca2->ct<=2)): echo "Mau"; elseif(($ver_epoca2->ct>=3)&&($ver_epoca2->ct<=4)): echo "Medríuque"; elseif(($ver_epoca2->ct>=5)&&($ver_epoca2->ct<=6)): echo "Súfice"; elseif(($ver_epoca2->ct>=7)&&($ver_epoca2->ct<=8)): echo "Bom"; elseif(($ver_epoca2->ct>=9)&&($ver_epoca2->ct<=10)): echo "Muito Bom"; elseif($ver_epoca2->ct=="---"): echo"---"; endif;?></td>
                            
                            
                             <?php 
                            $busMiniPautas3 = $objMiniPautas->buscarNotas($epoca3,  $v4->id_di2, $ver_es->id_aluno);
                            $ver_epoca3 = $busMiniPautas3->fetch(PDO::FETCH_OBJ);
                            ?>
                            
                           <td class="<?php if($ver_epoca3->mac<=2): echo "vermelho"; else: echo "azul"; endif;?>"><?php if(($ver_epoca3->mac>=1)&&($ver_epoca3->mac<=2)): echo "Mau"; elseif(($ver_epoca3->mac>=3)&&($ver_epoca3->mac<=4)): echo "Medríuque"; elseif(($ver_epoca3->mac>=5)&&($ver_epoca3->mac<=6)): echo "Súfice"; elseif(($ver_epoca3->mac>=7)&&($ver_epoca3->mac<=8)): echo "Bom"; elseif(($ver_epoca3->mac>=9)&&($ver_epoca3->mac<=10)): echo "Muito Bom"; elseif($ver_epoca3->mac=="---"): echo"---"; endif;?></td>
                            <td class="<?php if($ver_epoca3->cpp<=2): echo "vermelho"; else: echo "azul"; endif;?>"><?php if(($ver_epoca3->cpp>=1)&&($ver_epoca3->cpp<=2)): echo "Mau"; elseif(($ver_epoca3->cpp>=3)&&($ver_epoca3->cpp<=4)): echo "Medríuque"; elseif(($ver_epoca3->cpp>=5)&&($ver_epoca3->cpp<=6)): echo "Súfice"; elseif(($ver_epoca3->cpp>=7)&&($ver_epoca3->cpp<=8)): echo "Bom"; elseif(($ver_epoca3->cpp>=9)&&($ver_epoca3->cpp<=10)): echo "Muito Bom"; elseif($ver_epoca3->cpp=="---"): echo"---"; endif;?></td>
                            <td class="<?php if($ver_epoca3->ct<=2): echo "vermelho"; else: echo "azul"; endif;?>"><?php if(($ver_epoca3->ct>=1)&&($ver_epoca3->ct<=2)): echo "Mau"; elseif(($ver_epoca3->ct>=3)&&($ver_epoca3->ct<=4)): echo "Medríuque"; elseif(($ver_epoca3->ct>=5)&&($ver_epoca3->ct<=6)): echo "Súfice"; elseif(($ver_epoca3->ct>=7)&&($ver_epoca3->ct<=8)): echo "Bom"; elseif(($ver_epoca3->ct>=9)&&($ver_epoca3->ct<=10)): echo "Muito Bom"; elseif($ver_epoca3->ct=="---"): echo"---"; endif;?></td>
                            <td style="color: blue;">Transita</td>  
                           
                        </tr>
                        <?php } endif;?>
                       
                        
                    </tbody>
                </table></div></div>
