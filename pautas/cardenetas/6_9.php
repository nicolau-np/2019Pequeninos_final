<?php
$objCaderneta = new Caderneta();
$objCaderneta->setCon($con);
$objCaderneta->setAno($anoLectivo);
$objCaderneta->setClasse($v1->classe);
$objCaderneta->setCurso($v0->curso);
$objCaderneta->setTurma($v2->turma);
$objCaderneta->setTurno($v3->turno);


$epoca1=1;
$epoca2=2;
$epoca3=3;
$t1=1;
$t2=2;
$t3=3;
$t4=4;
$tipo="caderneta";

$sql23="select *from tbl_trancar where tipo=:tipo and epocas=:epoca";
                 $run23=$con->prepare($sql23);
                 $run23->bindParam(":tipo",$tipo,PDO::PARAM_STR);
                 $run23->bindParam(":epoca",$t1,PDO::PARAM_STR);
                 $run23->execute();
                 $view_epoca1=$run23->fetch(PDO::FETCH_OBJ);
                 
                 
                 $sql24="select *from tbl_trancar where tipo=:tipo and epocas=:epoca";
                 $run24=$con->prepare($sql24);
                 $run24->bindParam(":tipo",$tipo,PDO::PARAM_STR);
                 $run24->bindParam(":epoca",$t2,PDO::PARAM_STR);
                 $run24->execute();
                 $view_epoca2=$run24->fetch(PDO::FETCH_OBJ);
                 
                   $sql25="select *from tbl_trancar where tipo=:tipo and epocas=:epoca";
                 $run25=$con->prepare($sql25);
                 $run25->bindParam(":tipo",$tipo,PDO::PARAM_STR);
                 $run25->bindParam(":epoca",$t3,PDO::PARAM_STR);
                 $run25->execute();
                 $view_epoca3=$run25->fetch(PDO::FETCH_OBJ);
                 
                   $sql26="select *from tbl_trancar where tipo=:tipo and epocas=:epoca";
                 $run26=$con->prepare($sql26);
                 $run26->bindParam(":tipo",$tipo,PDO::PARAM_STR);
                 $run26->bindParam(":epoca",$t4,PDO::PARAM_STR);
                 $run26->execute();
                 $view_epoca4=$run26->fetch(PDO::FETCH_OBJ);
                 
                 
                 
?>

<div class="tabs-left">
                            <ul class="nav nav-tabs">
                                <li class="<?php if(isset($_POST['epoca1'])): echo "active"; elseif(!isset($_POST['epoca1'])): echo ""; endif;?>"><a data-toggle="tab" href="#lA">1º Trimestre</a></li>
                                <li class="<?php if(isset($_POST['epoca2'])): echo "active"; elseif(!isset($_POST['epoca2'])): echo ""; endif;?>"><a data-toggle="tab" href="#lB">2º Trimestre</a></li>
                                <li class="<?php if(isset($_POST['epoca3'])): echo "active"; elseif(!isset($_POST['epoca3'])): echo ""; endif;?>"><a data-toggle="tab" href="#lC">3º Trimestre</a></li>
								<li class="<?php if(isset($_POST['epoca4'])): echo "active"; elseif(!isset($_POST['epoca4'])): echo ""; endif;?>"><a data-toggle="tab" href="#lD">CE</a></li>
                            </ul>
                            <div class="tab-content">
                              <!-- 1 trimestre-->
                                <div id="lA" class="<?php if(isset($_POST['epoca1'])): echo "tab-pane active"; elseif(!isset($_POST['epoca1'])): echo "tab-pane"; endif;?>">
                                  
								 <div class="vbt1">
							 
								 </div> 
                   
                                
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
                    </colgroup>
                    <thead>
                        <tr>
                        <th>Foto</th>
                            <th>Nº</th>
                            <th>Nome Completo</th>
			<th>Editar</th>
					
                            
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                
                $a1=0;
                $resEstudantes1 = $objCaderneta->buscaEstudate();
                    while($ver_epoca1=$resEstudantes1->fetch(PDO::FETCH_OBJ))
                    {
             $a1++;
                    ?>
                    
                        <tr>
                            <td><img src="foto_alunos/<?php echo $ver_epoca1->foto;?>" style="width:40px; height:40px;"/></td>
                            <td><?php echo $a1;?></td>
                            <td><?php echo $ver_epoca1->nome;?>
			
                         <td><?php if($view_epoca1->estado=="OFF"): echo'bloqueado'; else: echo '<a href="lanca6_9.php?id_aluno='.$ver_epoca1->id_aluno.'&&id_dis='.$id_disciplina200.'&&epoca='.$epoca1.'&&ano='.$anoLectivo.'" class="btn btn-success">Avaliar</a>';endif;?> </td>
                        </tr>
                        <?php  } ?>
                    </tbody>
                </table>
               <br/>
			  
                                    
                                </div>
                                 <!-- 2 trimestre-->
                                <div id="lB" class="<?php if(isset($_POST['epoca2'])): echo "tab-pane active"; elseif(!isset($_GET['epoca2'])): echo "tab-pane"; endif;?>" >
                    
					<div class="vbt2">
					
						
					</div>                   
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
                    </colgroup>
                    <thead>
                        <tr>
                       <th>Foto</th>
                            <th>Nº</th>
                            <th>Nome Completo</th>
			<th>Editar</th>
						
                            
                        </tr>
                    </thead>
                    <tbody>
                            <?php 
                
              $a2=0;
              $resEstudantes2 = $objCaderneta->buscaEstudate();
                    while($ver_epoca2=$resEstudantes2->fetch(PDO::FETCH_OBJ))
                    {
             $a2++;
                    ?>
                    
                               <tr>
                         <td><img src="foto_alunos/<?php echo $ver_epoca2->foto;?>" style="width:40px; height:40px;"  /></td>
                            <td><?php echo $a2;?></td>
                            <td><?php echo $ver_epoca2->nome;?>
			
                        <td><?php if($view_epoca2->estado=="OFF"): echo'bloqueado'; else: echo '<a href="lanca6_9.php?id_aluno='.$ver_epoca2->id_aluno.'&&id_dis='.$id_disciplina200.'&&epoca='.$epoca2.'&&ano='.$anoLectivo.'" class="btn btn-success">Avaliar</a>';endif;?> </td>
                        </tr>
                        <?php  } ?>
                    </tbody>
                </table>
			
              
                                </div>
                                <!-- 3 trimestre-->
                                <div id="lC" class="<?php if(isset($_POST['epoca3'])): echo "tab-pane active"; elseif(!isset($_POST['epoca3'])): echo "tab-pane"; endif;?>">
                               
                                 <div class="vbt3">
											 
								 </div> 
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
                    </colgroup>
                    <thead>
                        <tr>
                       <th>Foto</th>
                            <th>Nº</th>
                            <th>Nome Completo</th>
							<th>Editar</th>
						
                        </tr>
                    </thead>
                    <tbody>
                       <?php 
                 
                   $a3=0;
              $resEstudantes3 = $objCaderneta->buscaEstudate();
                    while($ver_epoca3=$resEstudantes3->fetch(PDO::FETCH_OBJ))
                    {
             $a3++;
                    ?>
                    
                <tr>
                          <td><img src="foto_alunos/<?php echo $ver_epoca3->foto;?>" style="width:40px; height:40px;"  /></td>
                            <td><?php echo $a3;?></td>
                            <td><?php echo $ver_epoca3->nome;?>
			
                         <td><?php if($view_epoca3->estado=="OFF"): echo'bloqueado'; else: echo '<a href="lanca6_9.php?id_aluno='.$ver_epoca3->id_aluno.'&&id_dis='.$id_disciplina200.'&&epoca='.$epoca3.'&&ano='.$anoLectivo.'" class="btn btn-success">Avaliar</a>';endif;?> </td>
                         </tr>
                        <?php  } ?>
                        
                    </tbody>
                </table>
		
                                </div>
								
								                                <!-- cpe-->
                                <div id="lD" class="<?php if(isset($_POST['epoca4'])): echo "tab-pane active"; elseif(!isset($_POST['epoca4'])): echo "tab-pane"; endif;?>">
                                
                                 <div class="vbt3">
								 
								 
								 </div> 
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
                    </colgroup>
                    <thead>
                        <tr>
                     <th>Foto</th>
                            <th>Nº</th>
                            <th>Nome Completo</th>
                            
			<th>Editar</th>
						
                        </tr>
                    </thead>
                    <tbody>
                       <?php 
                 
                      $a4=0;
              $resEstudantes4 = $objCaderneta->buscaEstudate();
                    while($ver_epoca4=$resEstudantes4->fetch(PDO::FETCH_OBJ))
                    {
             $a4++;
                    ?>
                    
                <tr>
                      <td><img src="foto_alunos/<?php echo $ver_epoca4->foto;?>" style="width:40px; height:40px;"  /></td>
                            <td><?php echo $a4;?></td>
                            <td><?php echo $ver_epoca4->nome;?>
			 <td><?php if($view_epoca4->estado=="OFF"): echo'bloqueado'; else: echo '<a href="lanca6_9.php?id_aluno='.$ver_epoca4->id_aluno.'&&id_dis='.$id_disciplina200.'&&epoca=4&&ano='.$anoLectivo.'" class="btn btn-success">Avaliar</a>';endif;?> </td>
                         
                        </tr>
                        <?php  } ?>
                        
                    </tbody>
                </table>
		
                                </div>
								
                            </div><!--tab-content-->
                        </div> 
