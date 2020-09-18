<?php 
include("config/conn.php");
include("validarlogin.php");
        $anoLectivo=date("Y");
        $contar000=0;
        if($_SESSION['tituloMRX']=="Professor Normal"):
        $pasta="fotos_professores";
        elseif($_SESSION['tituloMRX']=="Professor Director"):
        $pasta="fotos_professores";

        $sed000="select *from view_director where id_pessoa=:id and anolectivo=:ano";
        $x000=$con->prepare($sed000);
        $x000->bindParam(":id",$_SESSION['id_pessoaMRX'],PDO::PARAM_STR);
        $x000->bindParam(":ano",$anoLectivo,PDO::PARAM_STR);
        $x000->execute();
        $contar000=$x000->rowCount();
        $ver000=$x000->fetch(PDO::FETCH_OBJ);

        elseif(($_SESSION['tituloMRX']=="Usuário Normal")||($_SESSION['tituloMRX']=="Administrador")):
        $pasta="fotos_usuarios";
        endif;
              $exibe="sim";
            $hora="select *from view_horario where id_pessoa=:id and anolectivo=:ano and exibe=:exibe";
            $ex190=$con->prepare($hora);
            $ex190->bindParam(":id",$_SESSION['id_pessoaMRX'],PDO::PARAM_STR);
            $ex190->bindParam(":ano",$anoLectivo,PDO::PARAM_STR);
        	$ex190->bindParam(":exibe",$exibe,PDO::PARAM_STR);
            $ex190->execute();
            $conta_hora=$ex190->rowCount();
            
             $hora2="select *from view_horario where id_pessoa=:id and anolectivo=:ano and exibe=:exibe";
            $ex112=$con->prepare($hora2);
            $ex112->bindParam(":id",$_SESSION['id_pessoaMRX'],PDO::PARAM_STR);
            $ex112->bindParam(":ano",$anoLectivo,PDO::PARAM_STR);
        	$ex112->bindParam(":exibe",$exibe,PDO::PARAM_STR);
            $ex112->execute();
            $conta_hora2=$ex112->rowCount();
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Lançamento de Notas</title>
<link rel="stylesheet" href="css/style.default.css" type="text/css" />
<script type="text/javascript" src="js/jquery-1.5.2.js"></script>
<script type="text/javascript" src="js/permicao.js"></script>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/jquery-migrate-1.1.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.9.2.min.js"></script>
<script type="text/javascript" src="js/modernizr.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.bxSlider.min.js"></script>
<script type="text/javascript" src="js/jquery.slimscroll.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
<script>
    $(document).ready(function(){
        var epoca=$("#epoca").val();
        if((epoca==1)||(epoca==2)||(epoca==3)){
            $(".glo").hide();
           $(".priter").show();
        }
        else if(epoca==4){
           $(".glo").show();
           $(".priter").hide();  
        }
    });
    </script>
</head>

<body>
<input type="hidden" value="<?php echo $_SESSION['tituloMRX'];?>" name="titulo" id="titulo"/>
<div class="mainwrapper">
    
    <div class="header">
        <div class="logo">
            <a href="dashboard.php"><img src="images/logo.png" alt="" /></a>
        </div>
        <div class="headerinner">
            <ul class="headmenu">
                          <li class="odd" id="directorProfessor4">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <span class="count"><?php 
						$d=date("N");

if($d==1){
$dias="Segunda";

}
elseif($d==2){
$dias="Terça";

}
elseif($d==3){
$dias="Quarta";

}

elseif($d==4){
$dias="Quinta";

}
elseif($d==5){
$dias="Sexta";


}
else{
$dias=0;
}
echo $dias."-Feira";				
						
						?></span>
                        <span class="iconfa-pencil iconfa-3x"></span>
                        <span class="headmenu-label">Livro de Ponto</span>
                    </a> 
					<ul class="dropdown-menu">
                        <li class="nav-header">Turmas</li>
						<?php 
						$s="select *from view_horario where id_pessoa=:id and semana=:s and anolectivo=:a";
						$r=$con->prepare($s);
						$r->bindParam(":id",$_SESSION['id_pessoaMRX'],PDO::PARAM_STR);
						$r->bindParam(":s",$dias,PDO::PARAM_STR);
						$r->bindParam(":a",$anoLectivo,PDO::PARAM_STR);
						$r->execute();
						while($v=$r->fetch(PDO::FETCH_OBJ)){
						?>
                        <li><a href="livro_ponto.php?id_professor=<?php echo $v->id_professor;?>&&classe=<?php echo $v->classe;?>&&turma=<?php echo $v->turma;?>&&turno=<?php echo $v->turno;?>&&id_disciplina=<?php echo $v->id_di2;?>&&ano=<?php echo $v->anolectivo;?>&&disciplina=<?php echo $v->nome;?>"><span class="icon-list"></span> <?php echo $v->classe ." ".$v->turma." ".$v->turno;?> <strong><?php echo $v->nome;?></strong> <small class="muted"> <?php echo $v->hora_e."-".$v->hora_s;?></small></a></li>
                        <?php }?>
                        <li class="viewmore"><a href="#">Ver todas</a></li>
                    </ul>
					
                </li>
                <li class="odd" id="usuarioAdmin6">
                    <a href="estatisticas.php">
                    <span class="count">::::</span>
                    <span class="iconfa-bar-chart iconfa-3x"></span>
                    <span class="headmenu-label">Estatísticas</span>
                    </a>
                   
                </li>
       
                <li class="odd" id="usuarioAdmin5">
                    <a href="justicar_falta.php">
                    <span class="count">::::</span>
                    <span class="iconfa-hand-up iconfa-3x"></span>
                    <span class="headmenu-label">J. Faltas Aluno</span>
                    </a>
                   
                </li>
                
                   <li class="odd" id="usuarioAdmin7">
                    <a href="m_faltas_professor.php">
                    <span class="count">::::</span>
                    <span class="iconfa-calendar iconfa-3x"></span>
                    <span class="headmenu-label">M. Faltas Professor</span>
                    </a>
                   
                </li>
                
                  <li class="odd" id="usuarioAdmin8">
                    <a href="mapa_efetividade.php">
                    <span class="count">::::</span>
                    <span class="iconfa-file iconfa-3x"></span>
                    <span class="headmenu-label">Mapa de Efetividade</span>
                    </a>
                   
                </li>
                <li class="odd" id="usuarioAdmin9">
                    <a href="pautas_alunos.php">
                    <span class="count">::::</span>
                    <span class="iconfa-chevron-down iconfa-3x"></span>
                    <span class="headmenu-label">Pautas</span>
                    </a>
                   
                </li>
                <li class="odd" id="usuarioAdmin10">
                    <a href="directores_turma.php">
                    <span class="count">::::</span>
                    <span class="iconfa-user iconfa-3x"></span>
                    <span class="headmenu-label">Directores</span>
                    </a>
                   
                </li>
                
				<li class="odd" id="director67">
                    <a href='criar_cardeneta.php?curso=<?php echo $ver000->curso;?>&&classe=<?php echo $ver000->classe;?>&&turma=<?php echo $ver000->turma;?>&&turno=<?php echo $ver000->turno;?>&&ano=<?php echo $ver000->anolectivo;?>'>
                    <span class="count"><?php if(($contar000>0)&&($_SESSION['tituloMRX']=="Professor Director")): echo $ver000->classe."".$ver000->turma." ".$ver000->turno; endif;?></span>
                    <span class="iconfa-briefcase iconfa-3x"></span>
                    <span class="headmenu-label">Criar Caderneta</span>
                    </a>
                   
                </li>
                <li class="odd" id="directorProfessor5">
                    <a href='minhas_faltas.php'>
                    <span class="count">::::</span>
                    <span class="iconfa-building iconfa-3x"></span>
                    <span class="headmenu-label">Minhas Faltas</span>
                    </a>
                   
                </li>
                <li class="right">
                    <div class="userloggedinfo">
                        <img src="<?php echo $pasta."/".$_SESSION['fotoMRX'];?>" style="height:85px; width: 100px;" alt="" />
                        <div class="userinfo">
                            <h5><?php echo $_SESSION['nomeMRX'];?> <small>- &copy;<?php echo date("Y")?></small></h5>
                            <ul>
                                <li><a href="editprofile.php">Editar Perfil</a></li>
                                <li><a href="">Configurações da Conta</a></li>
                                <li><a href="logout.php">Terminar Sessão</a></li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul><!--headmenu-->




        </div>
    </div>
    
    <div class="leftpanel">
        
        <div class="leftmenu">        
            <ul class="nav nav-tabs nav-stacked">
            	<li class="nav-header">Barra Lateral</li>
                <li><a href="dashboard.php"><span class="iconfa-home"></span> Início</a></li>
               <li id="director1" class="dropdown"><a href=""><span class="iconfa-hand-up"></span> Pautas :: <?php if(($contar000>0)&&($_SESSION['tituloMRX']=="Professor Director")): echo $ver000->classe."".$ver000->turma." ".$ver000->turno; endif;?></a>
                	<ul>
                <li ><a href="<?php if(($contar000>0)&&($_SESSION['tituloMRX']=="Professor Director")):echo'buttons.php?curso='.$ver000->curso.'&&classe='.$ver000->classe.'&&turma='.$ver000->turma.'&&turno='.$ver000->turno.''; else: echo'#'; endif;?>"></span> Notas</a></li>
                <li><a href="<?php if(($contar000>0)&&($_SESSION['tituloMRX']=="Professor Director")):echo'pauta_faltas.php?curso='.$ver000->curso.'&&classe='.$ver000->classe.'&&turma='.$ver000->turma.'&&turno='.$ver000->turno.''; else: echo'#'; endif;?>">Faltas</a></li>
                </ul>
                </li>
                <li class="dropdown" id="usuarioAdmin1"><a href=""><span class="iconfa-pencil"></span> Estudantes</a>
                	<ul>
                    	<li><a href="forms.php">Matricular</a></li>
                        <li><a href="wizards.php">Visualizar</a></li>
                        <li><a href="wysiwyg.php">Listas Nominais</a></li>
                    </ul>
                </li>
                <li class="dropdown" id="directorProfessor1"><a href=""><span class="iconfa-briefcase"></span> Caderneta</a>
                	<ul>
                     <?php 
                    if($conta_hora2==0):
                    echo "<li><a href='#'>Nenhuma turma encontrada</a></li>";
                    else:
                    while($ver_hora112=$ex112->fetch(PDO::FETCH_OBJ))
                    {
                     echo"<li><a href='bootstrap.php?curso={$ver_hora112->id_curso}&&classe={$ver_hora112->id_classe}&&turma={$ver_hora112->id_turma}&&turno={$ver_hora112->id_turno}&&disciplina={$ver_hora112->id_di2}'>{$ver_hora112->classe}{$ver_hora112->turma} {$ver_hora112->turno} {$ver_hora112->nome}</a></li>";   
                    }
                    
                    endif;
                    ?>
                    </ul>
                </li>
                <li class="dropdown" id="Admin1"><a href=""><span class="iconfa-th-list"></span> Usuários</a>
                	<ul>
                    	<li><a href="table-static.php">Novo</a></li>
                        <li class=""><a href="table-dynamic.php">Visualizar</a></li>
                    </ul>
                </li>
                
                 <li class="dropdown" id="usuarioAdmin2"><a href=""><span class="iconfa-calendar"></span> Professores</a>
                	<ul>
                    	<li><a href="charts.php">Novo</a></li>
                        <li class=""><a href="messages.php">Visualizar</a></li>
                    </ul>
                </li>
                
               
                <li class="dropdown" id="directorProfessor2"><a href=""><span class="iconfa-book"></span> Mini Pautas</a>
                	<ul>
                      <?php 
                    if($conta_hora==0):
                    echo "<li><a href='#'>Nenhuma turma encontrada</a></li>";
                    else:
                    while($ver_hora=$ex190->fetch(PDO::FETCH_OBJ))
                    {
                     echo"<li><a href='discussion.php?curso={$ver_hora->curso}&&classe={$ver_hora->classe}&&turma={$ver_hora->turma}&&turno={$ver_hora->turno}&&disciplina={$ver_hora->nome}'>{$ver_hora->classe}{$ver_hora->turma} {$ver_hora->turno} {$ver_hora->nome}</a></li>";   
                    }
                    
                    endif;
                    ?>
                    </ul>
                </li>
                <li class="dropdown active" id="Admin2"><a href=""><span class="iconfa-th-list"></span> Configurações</a>
                	<ul style="display: block;">
                	<li><a href="calendar.php">Sistema</a></li>
                     <li  class="active"><a href="boxes.php">Usuários</a></li>
                     </ul>
                </li>
                <li><a href="media.php"><span class="iconfa-picture"></span> Sobre Sistema</a></li>
            </ul>
        </div><!--leftmenu-->

    </div><!-- leftpanel -->
    
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="dashboard.php"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="#">Cardeneta</a> <span class="separator"></span></li>
            <li>Lançamentos</li>
            
           <li class="right">
                    <a href="" data-toggle="dropdown" class="dropdown-toggle"><i class="icon-tint"></i>Cor do Tema</a>
                    <ul class="dropdown-menu pull-right skin-color">
                        <li><a href="default">Default</a></li>
                        <li><a href="navyblue">Azul Marinho</a></li>
                        <li><a href="palegreen">Verde Pálido</a></li>
                        <li><a href="red">Vermelho</a></li>
                        <li><a href="green">Verde</a></li>
                        <li><a href="brown">Castanho</a></li>
                    </ul>
            </li>
        </ul>
        
        <div class="pageheader">
            <form action="results.html" method="post" class="searchbar">
                <input type="text" name="keyword" placeholder="To search type and hit enter..." />
            </form>
            <div class="pageicon"><span class="iconfa-briefcase"></span></div>
            <div class="pagetitle">
                <h5>Caderneta</h5>
                <h1>Lançamentos</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
                <div class="row">
                    <div class="span10">
                        <?php
                          $id_aluno=0; $id_dis=0; $epoca=0; $ano800=0;  
                        if(isset($_GET['idEsta'])){
                         
                         $idEsta=$_GET['idEsta'];
                         
                         $_SESSION['idestagio']=$_GET['idEsta'];
                            
                        }
                        elseif(!isset($_GET['idEsta']))
                        {
                         //$id_aluno=$_SESSION['id_aluno'];
                         $idEsta=$_SESSION['idestagio'];
                         //$id_dis=$_SESSION['id_dis'];
                         //$epoca=$_SESSION['epoca'];
                         //$ano800=$_SESSION['ano'];  
                        }
                        
                         
                        ?>
                        <input type="hidden" name="epoca" id="epoca" value="<?php echo $epoca;?>"/>
                        <?php 
                       
                        $run=$con->prepare("SELECT * FROM estagiarios WHERE idEsta=:id");
                        $run->bindParam(":id",$_SESSION['idestagio'],PDO::PARAM_STR);
                        $run->execute();
                        $ver=$run->fetch(PDO::FETCH_OBJ);
                        ?>
                         <div class="dados_aluno">
                            <table class="table table-striped" width="200px">
                                <tr>
                                    <td rowspan='3' width='100px'><img src="foto_alunos/<?php //echo $ver->foto;?>" style="width:100px; height:90px;"  /></td>
                            
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; width: 180px;">Nome completo:</td>
                                    <td><?php echo $ver->nome;?></td>
                           
                                </tr>
                             
                            </table>
                        </div>
                        <div class="av">
                              
                            <table class="table table-bordered">
                                <tr>
                                    <?php
                                
                                    ?>
                                    
                                </tr>
                                 <tr>
                                    <th>Provas</th>
                                  <?php
                                  
                           $run78=$con->prepare("SELECT * FROM notas_stag INNER JOIN estagiarios ON estagio_id=idEsta WHERE estagio_id=:ID");
                           $run78->bindParam(":ID",$idEsta,PDO::PARAM_STR);
                           $run78->execute();
                                   while ($view78=$run78->fetch(PDO::FETCH_OBJ)){
                               
                              echo"<td>".$view78->notas."</td>" ;
                           }
                                  ?>
                                </tr>
                            </table>
                        </div>
                        
                                <div class="pv">
                            <table class="table table-bordered">
                                <tr>
                                    <?php
                                  
                                    ?>
                                    
                                </tr>
                                 <tr>
                                    <th>Média das Provas</th>
                                  <?php
                                 $classe1="11ª";  $classe2="12ª"; $classe3="13ª";
                /*======================== SELECT PROVAS DA 11 CLASSE =======================*/                  
                           $run1=$con->prepare("SELECT * FROM historico_notas_estag INNER JOIN estagiarios ON estagio_id=idEsta WHERE estagio_id=:ID");
                           //$run1->bindParam(":CLASSE",$classe1,PDO::PARAM_STR);
                           $run1->bindParam(":ID",$idEsta,PDO::PARAM_STR);
                           $run1->execute();
                                   while ($view80=$run1->fetch(PDO::FETCH_OBJ)){
                               
                              echo"<td>".$view80->media."</td>" ;
                           }
                                  ?>
                                </tr>
                            </table>
                        </div>
                        
                        
                        
                        
                        <!-- primeiro a tetrceiro trimestre-->
                        <div class="priter">
                          <?php 
                           /*======================== SELECT PROVAS DA 11 CLASSE =======================*/                  
                           $run1=$con->prepare("SELECT * FROM notas_stag INNER JOIN estagiarios ON estagio_id=idEsta WHERE classe=:CLASSE AND estagio_id=:ID");
                           $run1->bindParam(":CLASSE",$classe1,PDO::PARAM_STR);
                           $run1->bindParam(":ID",$idEsta,PDO::PARAM_STR);
                           $run1->execute();
                           $contarProvas=$run1->rowCount();
                           
                            /*======================== SELECT PROVAS DA 12 CLASSE =======================*/                  
                           $run2=$con->prepare("SELECT * FROM notas_stag INNER JOIN estagiarios ON estagio_id=idEsta WHERE classe=:CLASSE AND estagio_id=:ID");
                           $run2->bindParam(":CLASSE",$classe2,PDO::PARAM_STR);
                           $run2->bindParam(":ID",$idEsta,PDO::PARAM_STR);
                           $run2->execute();
                           $contarAvaliacao=$run2->rowCount();
                           /*======================== SELECT PROVAS DA 13 CLASSE =======================*/                  
                           $run3=$con->prepare("SELECT * FROM notas_stag INNER JOIN estagiarios ON estagio_id=idEsta WHERE classe=:CLASSE AND estagio_id=:ID");
                           $run3->bindParam(":CLASSE",$classe3,PDO::PARAM_STR);
                           $run3->bindParam(":ID",$idEsta,PDO::PARAM_STR);
                           $run3->execute();
                           
                           if(isset($_POST['sav'])){
                               $prova= addslashes( htmlspecialchars($_POST['nota']));
                               $tipo= addslashes( htmlspecialchars($_POST['tipo']));
                               $anolectivo = addslashes( htmlspecialchars($_POST['anolectivo']));
                                                                                            
                               
                           
                               if($tipo=="Prova"):
                                       inserirProva($idEsta,$prova,$anolectivo,$con);
                                       $media = selectProvas($con,$idEsta,$anolectivo);
                                       $count = countProvas($con,$idEsta,$anolectivo);
                                       $mediaEsta = selectHistProvas($con,$idEsta,$anolectivo);
                                       inserirHistoricoProva($idEsta,$prova,$media,$count,$anolectivo,$con); 
                                       inserirMediasEsta($idEsta,$mediaEsta,$anolectivo,$con);         
                                        echo "MEDIA:: ".$mediaEsta;
                                   echo '<meta http-equiv="refresh" content="1"/>';                                 

                                endif;
                                
                           }
                            //================================== FUNCTIONS ==================                        
   
    
    function inserirProva($idEsta,$prova,$anolectivo,$con){
      //$data=date("d-m-Y");
      $prova=round($prova);
      $res=0;
         //============= INSERTING VALUES OF THE EXAMES IN DATABASE   ================== 
           try{
                               $run4=$con->prepare("INSERT INTO notas_stag (estagio_id,notas,anoLectivo,dataReg) VALUES(:IDESTA,:NOTA,:ANO,NOW())");
                               $run4->bindParam(":IDESTA",$idEsta,PDO::PARAM_STR);
                               $run4->bindParam(":NOTA",$prova,PDO::PARAM_STR);  
                               $run4->bindParam(":ANO",$anolectivo,PDO::PARAM_STR);                              
                               if($run4->execute()){ 
                                 echo"<div class='alert alert-success'>Prova do estágio registada com sucesso!".$prova."</div>";
                               } 
        
               }catch(PDOException $e){ $e ->getMessage();} 
        return $res;                       
    }//End function
    function inserirMediasEsta($idEsta,$mediaEsta,$anolectivo,$con){
      //$data=date("d-m-Y");
      $mediaEsta=round($mediaEsta);
      $res=0;
         //============= INSERTING VALUES OF THE EXAMES IN DATABASE   ================== 
           try{
                               $run4=$con->prepare("INSERT INTO mediasestagio (historicoesta_id,media,anoLectivo) VALUES(:IDESTA,:NOTA,:ANO)");
                               $run4->bindParam(":IDESTA",$idEsta,PDO::PARAM_STR);
                               $run4->bindParam(":NOTA",$mediaEsta,PDO::PARAM_STR);  
                               $run4->bindParam(":ANO",$anolectivo,PDO::PARAM_STR);                              
                               if($run4->execute()){ 
                                 echo"<div class='alert alert-success'>Média do estágio registada com sucesso!".$anolectivo."</div>";
                               } 
        
               }catch(PDOException $e){ $e ->getMessage();} 
        return $res;                       
    }//End function
    function selectProvas($con,$idEsta,$anolectivo){
         //============= CONSULTA AO BANCO DE DADOS PARA A CONTAGEM DE PROVAS FEITAS ==================            
                $media=0;  
              try{  
                               $run6=$con->prepare("SELECT AVG(notas) FROM notas_stag where estagio_id=:ID AND anolectivo=:ANO");
                               $run6->bindParam(":ID",$idEsta,PDO::PARAM_STR);
                                $run6->bindParam(":ANO",$anolectivo,PDO::PARAM_STR);
                               if($run6->execute()){
                                 if($run6->rowCount() >0){ 
                                    $rs=$run6->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($rs as $value) {
                                                $media = $value["AVG(notas)"];
                                        }
                                 }
                               }
                               
                              
                }catch(PDOException $e){ $e ->getMessage();}               
            return $media;                    
    }//End function
    function selectHistProvas($con,$idEsta,$anolectivo){
         //============= CONSULTA AO BANCO DE DADOS PARA A CONTAGEM DE PROVAS FEITAS ==================            
                $media=0;  
              try{  
                               $run6=$con->prepare("SELECT AVG(media) FROM historico_notas_estag where estagio_id=:ID");
                               $run6->bindParam(":ID",$idEsta,PDO::PARAM_STR);
                               if($run6->execute()){
                                 if($run6->rowCount() >0){ 
                                    $rs=$run6->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($rs as $value) {
                                                $media = $value["AVG(media)"];
                                        }
                                 }
                               }
                               
                              
                }catch(PDOException $e){ $e ->getMessage();}               
            return $media;                    
    }//End function
    function countProvas($con,$idEsta,$anolectivo){
         //============= CONSULTA AO BANCO DE DADOS PARA A CONTAGEM DE PROVAS FEITAS ==================            
                $media=0;  
              try{  
                               $run6=$con->prepare("SELECT COUNT(notas) FROM notas_stag where estagio_id=:ID AND anoLectivo=:ANO");
                               $run6->bindParam(":ID",$idEsta,PDO::PARAM_STR);
                               $run6->bindParam(":ANO",$anolectivo,PDO::PARAM_STR);
                               if($run6->execute()){
                                 if($run6->rowCount() >0){ 
                                    $rs=$run6->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($rs as $value) {
                                                $media = $value["COUNT(notas)"];
                                        }
                                 }
                               }
                               
                              
                }catch(PDOException $e){ $e ->getMessage();}               
            return $media;                    
    }//End function

    function inserirHistoricoProva($idEsta,$prova,$media,$count,$anolectivo,$con){
      $data=date("d-m-Y");
      $prova=round($prova);
      $res=0;
         //============= INSERTING VALUES OF THE EXAMES IN DATABASE   ================== 
           try{
                              $ano=date('Y');

                            if($count ==1){
                               echo"<div class='alert alert-success'>Conta ".$count." ID: ".$idEsta."</div>";
                               $run4=$con->prepare("INSERT INTO historico_notas_estag (estagio_id,nota1,media,anolectivo,dataReg) VALUES(:IDESTA,:NOTA1,:MEDIA,:ANO,NOW())");
                               $run4->bindParam(":IDESTA",$idEsta,PDO::PARAM_STR);
                               $run4->bindParam(":NOTA1",$prova,PDO::PARAM_STR);  
                               $run4->bindParam(":MEDIA",$media,PDO::PARAM_STR);   
                               $run4->bindParam(":ANO",$anolectivo,PDO::PARAM_STR);                                                 
                               if($run4->execute()){ 
                                 echo"<div class='alert alert-success'>Histórico da Prova do estágio registada com sucesso!".$prova."</div>";
                               }
                            }else if($count ==2){
                                echo"<div class='alert alert-success'>Conta ".$count." ID: ".$idEsta."</div>";
                                $run4=$con->prepare("UPDATE historico_notas_estag SET nota2=:NOTA2,media=:MEDIA WHERE estagio_id=:IDESTA");
                               $run4->bindParam(":IDESTA",$idEsta,PDO::PARAM_STR);
                               $run4->bindParam(":NOTA2",$prova,PDO::PARAM_STR);  
                               $run4->bindParam(":MEDIA",$media,PDO::PARAM_STR); 
                                                       
                               if($run4->execute()){ 
                                 echo"<div class='alert alert-success'>Prova do estágio actualizada com sucesso!".$prova."</div>";
                               }
                            }else if($count ==3){
                                echo"<div class='alert alert-success'>Conta ".$count." ID: ".$idEsta."</div>";
                                $run4=$con->prepare("UPDATE historico_notas_estag SET nota3=:NOTA3,media=:MEDIA WHERE estagio_id=:IDESTA");
                               $run4->bindParam(":IDESTA",$idEsta,PDO::PARAM_STR);
                               $run4->bindParam(":NOTA3",$prova,PDO::PARAM_STR);  
                               $run4->bindParam(":MEDIA",$media,PDO::PARAM_STR);  
                                                           
                               if($run4->execute()){ 
                                 echo"<div class='alert alert-success'>Prova do estágio actualizada com sucesso!".$prova."</div>";
                               }
                            }else if($count ==4){
                                echo"<div class='alert alert-success'>Conta ".$count." ID: ".$idEsta."</div>";
                                $run4=$con->prepare("UPDATE historico_notas_estag SET nota4=:NOTA4,media=:MEDIA WHERE estagio_id=:IDESTA");
                               $run4->bindParam(":IDESTA",$idEsta,PDO::PARAM_STR);
                               $run4->bindParam(":NOTA4",$prova,PDO::PARAM_STR);  
                               $run4->bindParam(":MEDIA",$media,PDO::PARAM_STR); 
                                                             
                               if($run4->execute()){ 
                                 echo"<div class='alert alert-success'>Prova do estágio actualizada com sucesso!".$prova."</div>";
                               }
                            }         
        
               }catch(PDOException $e){ $e ->getMessage();} 
        return $res;                       
    }//End function
    
    
                     
                           ?>
                            
                            <form class="" name="g" method="POST" action="lanca_estagio_tecnico10_13.php">
                                <fieldset>
                                    
                                    <hr/>
                                 <div class="form-inline">
                                    <label>Tipo</label>
                                    <select name="tipo" class="input-medium">
                                        <option>Prova</option>
                                         <?php if($contarProvas<0): echo'<option>Prova</option>';endif;?>
                                    </select>
                                    <label>Nota</label>
                                    <input type="text" name="nota" placeholder="valor" class="input-small" required=""/>
                                    <label>Ano Lectivo </label>
                                    <input type="text" name="anolectivo" id="anolectivo" class="input-small" value="2018">
                                    <input type="submit" value="Salvar" class="btn btn-primary" name="sav">
                                </div></form>
                            
                        </div>
           
                        
                    </div>
                    
                </div> 
         
       
              <div class="footer">
                    <div class="footer-left">
                        <span>&copy; <?php echo date("Y");?>. CADERNETA-electrônica. Todos os Direitos Reservados.</span>
                    </div>
                    <div class="footer-right">
                        <span>Designed by: <a href="http://okuvandja.com/">CADERNETA-electrônica</a></span>
                    </div>
                </div><!--footer-->
                
            </div><!--maincontentinner-->
        </div><!--maincontent-->
        
    </div><!--rightpanel-->
    
</div><!--mainwrapper-->

</body>
</html>


