<?php
$t1=1;
$t2=2;
$t3=3;
$t4=4;
$IT1=0;
$IT2=0;
$IT3=0;
$Pglobal=0;
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
								<li class="<?php if(isset($_POST['epoca4'])): echo "active"; elseif(!isset($_POST['epoca4'])): echo ""; endif;?>"><a data-toggle="tab" href="#lD">P.Global</a></li>
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
							<th>Avaliar Aluno</th>
							
					
                            
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                $epoca1=1;
				$epoca2=2;
				$epoca3=3;
                    $rtx="select *from view_notas where curso=:curso and classe=:classe and turma=:turma and turno=:turno and anoLetivo=:ano and epoca=:epoca and id_di2=:disciplina order by nome asc";
                    $etx=$con->prepare($rtx);
                    $etx->bindParam(":curso",$v0->curso,PDO::PARAM_STR);
                     $etx->bindParam(":classe",$v1->classe,PDO::PARAM_STR);
                      $etx->bindParam(":turma",$v2->turma,PDO::PARAM_STR);
                     $etx->bindParam(":turno",$v3->turno,PDO::PARAM_STR);
                      $etx->bindParam(":ano",$anoLectivo,PDO::PARAM_STR);
					     $etx->bindParam(":epoca",$epoca1,PDO::PARAM_STR);
                      $etx->bindParam(":disciplina",$id_disciplina200,PDO::PARAM_STR);
                    $etx->execute();
                    $a1=0;
                    $ger="select *from view_estudante where id_aluno=:id";
                    while($ver_epoca1=$etx->fetch(PDO::FETCH_OBJ))
                    {    $IT1=$ver_epoca1->ct;
                        //enablePeriod1($con,$IT1);
                     $a1++;   
                    $ex=$con->prepare($ger);
                 $ex->bindParam(":id",$ver_epoca1->id_aluno,PDO::PARAM_STR);
                 $ex->execute();
                 $view_1=$ex->fetch(PDO::FETCH_OBJ);
                    ?>
                    
                        <tr>
                          <td><img src="foto_alunos/<?php echo $view_1->foto;?>" style="width:40px; height:40px;"  /></td>
                            <td><?php echo $a1;?></td>
                            <td><?php echo $ver_epoca1->nome;?>
			
                        <td><?php if($view_epoca1->estado=="OFF"): echo'bloqueado'; else: echo '<a href="lanca_tecnico10_13.php?id_aluno='.$ver_epoca1->id_aluno.'&&id_dis='.$id_disciplina200.'&&epoca='.$epoca1.'&&ano='.$anoLectivo.'" class="btn btn-success">Avaliar</a>';endif;?> </td>
                        
                        </tr>
                        <?php  } ?>
                    </tbody>
                </table>
                             
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
							<th>Avaliar Aluno</th>
							
                            
                        </tr>
                    </thead>
                    <tbody>
                            <?php 
                
                    $rtx2="select *from view_notas where curso=:curso and classe=:classe and turma=:turma and turno=:turno and anoLetivo=:ano and epoca=:epoca and id_di2=:disciplina order by nome asc";
                    $etx2=$con->prepare($rtx2);
                    $etx2->bindParam(":curso",$v0->curso,PDO::PARAM_STR);
                     $etx2->bindParam(":classe",$v1->classe,PDO::PARAM_STR);
                      $etx2->bindParam(":turma",$v2->turma,PDO::PARAM_STR);
                     $etx2->bindParam(":turno",$v3->turno,PDO::PARAM_STR);
                      $etx2->bindParam(":ano",$anoLectivo,PDO::PARAM_STR);
					     $etx2->bindParam(":epoca",$epoca2,PDO::PARAM_STR);
                      $etx2->bindParam(":disciplina",$id_disciplina200,PDO::PARAM_STR);
                    $etx2->execute();
                    $a2=0;
                    while($ver_epoca2=$etx2->fetch(PDO::FETCH_OBJ))
                    {  $IT2 = $ver_epoca2->ct;
                        //enablePeriod2($con,$IT2);
                     $a2++;   
                   $ex2=$con->prepare($ger);
                 $ex2->bindParam(":id",$ver_epoca2->id_aluno,PDO::PARAM_STR);
                 $ex2->execute();
                 $view_2=$ex2->fetch(PDO::FETCH_OBJ);
                    ?>
                    
                               <tr>
                        <td><img src="foto_alunos/<?php echo $view_2->foto;?>" style="width:40px; height:40px;"  /></td>
                            <td><?php echo $a2;?></td>
                            <td><?php echo $ver_epoca2->nome;?>
			
                       <td><?php if($view_epoca2->estado=="OFF"): echo'bloqueado'; else: echo '<a href="lanca_tecnico10_13.php?id_aluno='.$ver_epoca2->id_aluno.'&&id_dis='.$id_disciplina200.'&&epoca='.$epoca2.'&&ano='.$anoLectivo.'" class="btn btn-success">Avaliar</a>';endif;?> </td>
                         
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
							<th>Avaliar Aluno</th>
							
                        </tr>
                    </thead>
                    <tbody>
                       <?php 
                 
                
                    $rtx3="select *from view_notas where curso=:curso and classe=:classe and turma=:turma and turno=:turno and anoLetivo=:ano and epoca=:epoca and id_di2=:disciplina order by nome asc";
                    $etx3=$con->prepare($rtx3);
                    $etx3->bindParam(":curso",$v0->curso,PDO::PARAM_STR);
                     $etx3->bindParam(":classe",$v1->classe,PDO::PARAM_STR);
                      $etx3->bindParam(":turma",$v2->turma,PDO::PARAM_STR);
                     $etx3->bindParam(":turno",$v3->turno,PDO::PARAM_STR);
                      $etx3->bindParam(":ano",$anoLectivo,PDO::PARAM_STR);
					     $etx3->bindParam(":epoca",$epoca3,PDO::PARAM_STR);
                      $etx3->bindParam(":disciplina",$id_disciplina200,PDO::PARAM_STR);
                    $etx3->execute();
                    $a3=0;
                    while($ver_epoca3=$etx3->fetch(PDO::FETCH_OBJ))
                    {   $IT3 = $ver_epoca3->ct;
                       // enablePeriod3($con,$IT3);
                     $a3++;   
                   $ex3=$con->prepare($ger);
                 $ex3->bindParam(":id",$ver_epoca3->id_aluno,PDO::PARAM_STR);
                 $ex3->execute();
                 $view_3=$ex3->fetch(PDO::FETCH_OBJ);
                    ?>
                    
                <tr>
                 <td><img src="foto_alunos/<?php echo $view_3->foto;?>" style="width:40px; height:40px;"  /></td>
                            <td><?php echo $a3;?></td>
                            <td><?php echo $ver_epoca3->nome;?>
			
                       <td><?php if($view_epoca3->estado=="OFF"): echo'bloqueado'; else: echo '<a href="lanca_tecnico10_13.php?id_aluno='.$ver_epoca3->id_aluno.'&&id_dis='.$id_disciplina200.'&&epoca='.$epoca3.'&&ano='.$anoLectivo.'" class="btn btn-success">Avaliar</a>';endif;?> </td>
                         
                        </tr>
                        <?php  } ?>
                        
                    </tbody>
                </table>
		
                                </div>
								
								                                <!-- 3 trimestre-->
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
                 
                
                    $rtx4="select *from view_clas_finais where curso=:curso and classe=:classe and turma=:turma and turno=:turno and anolectivo=:ano and id_di2=:disciplina order by nome asc";
                    $etx4=$con->prepare($rtx4);
                    $etx4->bindParam(":curso",$v0->curso,PDO::PARAM_STR);
                     $etx4->bindParam(":classe",$v1->classe,PDO::PARAM_STR);
                      $etx4->bindParam(":turma",$v2->turma,PDO::PARAM_STR);
                     $etx4->bindParam(":turno",$v3->turno,PDO::PARAM_STR);
                      $etx4->bindParam(":ano",$anoLectivo,PDO::PARAM_STR);
                      $etx4->bindParam(":disciplina",$id_disciplina200,PDO::PARAM_STR);
                    $etx4->execute();
                    $a4=0;
                    while($ver_epoca4=$etx4->fetch(PDO::FETCH_OBJ))
                    {  $Pglobal = $ver_epoca4->cpe;
                        //enablePGlobal($con,$Pglobal);
                     $a4++;   
                   $ex4=$con->prepare($ger);
                 $ex4->bindParam(":id",$ver_epoca4->id_aluno,PDO::PARAM_STR);
                 $ex4->execute();
                 $view_4=$ex4->fetch(PDO::FETCH_OBJ);
                    ?>
                    
                <tr>
                   <td><img src="foto_alunos/<?php echo $view_4->foto;?>" style="width:40px; height:40px;"/></td>
                            <td><?php echo $a4;?></td>
                            <td><?php echo $ver_epoca4->nome;?>
			
                       <td><?php if($view_epoca4->estado=="OFF"): echo'bloqueado'; else: echo '<a href="lanca_tecnico10_13.php?id_aluno='.$ver_epoca4->id_aluno.'&&id_dis='.$id_disciplina200.'&&epoca=4&&ano='.$anoLectivo.'" class="btn btn-success">Avaliar</a>';endif;?> </td>
                         
                        </tr>
                        <?php  } ?>
                        
                    </tbody>
                </table>
		
                                </div>
								
                            </div><!--tab-content-->
                        </div> 
       <!--- ÁREA DE BLOQUEIO DOS TRIMESTRES EM CASO DE TEREM JÁ OS ITs PREENCHIDOS OU PROVA GLOBAL FEITAS  --> 
       
    <?php
         $estado1="ON";
         
         
        function enablePeriod1($con,$IT1){
                $estado2="OFF";
                $tipo="caderneta";
             // echo " IT1: ".$IT1;      
             if(($IT1 > 0) || ($IT1 !="---")):
                 $epoca="1";
                 $sql24="update tbl_trancar set estado=:estado where epocas=:epoca and tipo=:tipo";
                 $run24=$con->prepare($sql24);
                 $run24->bindParam(":estado",$estado2,PDO::PARAM_STR);
                 $run24->bindParam(":epoca",$epoca,PDO::PARAM_STR);
                  $run24->bindParam(":tipo",$tipo,PDO::PARAM_STR);
                  $run24->execute();
                  if($run24):
                     // echo"<div class='alert alert-success'>Bloqueio feito com sucesso!</div>";
                  endif;
             endif;
        } //End Function
         function enablePeriod2($con,$IT2){
                $estado2="OFF";
                $tipo="caderneta";
                 
             if(($IT2 > 0) && ($IT2 !="---")):
                 $epoca="2";
                 $sql24="update tbl_trancar set estado=:estado where epocas=:epoca and tipo=:tipo";
                 $run24=$con->prepare($sql24);
                 $run24->bindParam(":estado",$estado2,PDO::PARAM_STR);
                 $run24->bindParam(":epoca",$epoca,PDO::PARAM_STR);
                  $run24->bindParam(":tipo",$tipo,PDO::PARAM_STR);
                  $run24->execute();
                  if($run24):
                     // echo"<div class='alert alert-success'>Bloqueio feito com sucesso!</div>";
                  endif;
             endif;
        } //End Function
         function enablePeriod3($con,$IT3){
                $estado2="OFF";
                $tipo="caderneta";
                    
             if(($IT3 > 0) || ($IT3 !="---")):
                 $epoca="3";
                 $sql24="update tbl_trancar set estado=:estado where epocas=:epoca and tipo=:tipo";
                 $run24=$con->prepare($sql24);
                 $run24->bindParam(":estado",$estado2,PDO::PARAM_STR);
                 $run24->bindParam(":epoca",$epoca,PDO::PARAM_STR);
                  $run24->bindParam(":tipo",$tipo,PDO::PARAM_STR);
                  $run24->execute();
                  if($run24):
                      //echo"<div class='alert alert-success'>Bloqueio feito com sucesso!</div>";
                  endif;
             endif;
        } //End Function
        function enablePGlobal($con,$Pglobal){
             $estado2="OFF";
                $tipo="caderneta";
              echo " IT3: ".$Pglobal;      
             if(($Pglobal > 0) || ($Pglobal !="---")):
                 $epoca="4";
                 $sql24="update tbl_trancar set estado=:estado where epocas=:epoca and tipo=:tipo";
                 $run24=$con->prepare($sql24);
                 $run24->bindParam(":estado",$estado2,PDO::PARAM_STR);
                 $run24->bindParam(":epoca",$epoca,PDO::PARAM_STR);
                  $run24->bindParam(":tipo",$tipo,PDO::PARAM_STR);
                  $run24->execute();
                  if($run24):
                     // echo"<div class='alert alert-success'>Bloqueio feito com sucesso!</div>";
                  endif;
             endif;
        }

            if(isset($_POST['by8'])):
             $epoca=$_POST['epoca'];
             $sql24="update tbl_trancar set estado=:estado where epocas=:epoca and tipo=:tipo";
             $run24=$con->prepare($sql24);
             $run24->bindParam(":estado",$estado1,PDO::PARAM_STR);
             $run24->bindParam(":epoca",$epoca,PDO::PARAM_STR);
              $run24->bindParam(":tipo",$tipo,PDO::PARAM_STR);
              $run24->execute();
              if($run24):
                  echo"<div class='alert alert-success'>Desbloqueio feito com sucesso!</div>";
              endif;
         endif;
    ?>               