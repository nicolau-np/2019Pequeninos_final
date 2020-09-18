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
                    $idEsta=$_GET['idEsta'];
                    $classe=$_GET['classe'];
                $epoca1=1;
				$epoca2=2;
				$epoca3=3;
                    
                    $etx=$con->prepare("SELECT * FROM estagiarios WHERE classe=:id");
                    $etx->bindParam(":id",$classe,PDO::PARAM_STR);
                    $etx->execute();
                    $a1=0;
                    $ger="select *from esta where id_aluno=:id";
                    while($ver_epoca1=$etx->fetch(PDO::FETCH_OBJ))
                    {    
                     $a1++;   
                  
                    ?>
                    
                        <tr>
                          <td><img src="foto_alunos/<?php echo $view_1->foto;?>" style="width:40px; height:40px;"  /></td>
                            <td><?php echo $a1;?></td>
                            <td><?php echo $ver_epoca1->nome;?>
			
                        <td><?php if($view_epoca1->estado=="OFF"): echo'bloqueado'; else: echo '<a href="lanca_estagio_tecnico10_13.php?idEsta='.$ver_epoca1->idEsta.'&&nome='.$ver_epoca1->nome.'&&curso='.$ver_epoca1->curso.'&&classe='.$ver_epoca1->classe.'&&turma='.$ver_epoca1->turma.'&&turno='.$ver_epoca1->turno.'" class="btn btn-success">Avaliar</a>';endif;?> </td>
                        
                        </tr>
                        <?php  } ?>
                    </tbody>
                </table>
                      		
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