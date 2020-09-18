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
                     <li  class="active"><a href="boxes.php">Turmas</a></li>
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
            <?php 
                        if(isset($_GET['id_aluno'])){
                         $id_aluno=$_GET['id_aluno'];
                        $id_dis=$_GET['id_dis'];
                        $epoca=$_GET['epoca'];
                        $ano800=$_GET['ano'];
                         $_SESSION['id_aluno']=$_GET['id_aluno'];
                         $_SESSION['id_dis']=$_GET['id_dis'];
                         $_SESSION['epoca']=$_GET['epoca'];
                         $_SESSION['ano']=$_GET['ano'];   
                        }
                        else
                        {
                         $id_aluno=$_SESSION['id_aluno'];
                         $id_dis=$_SESSION['id_dis'];
                         $epoca=$_SESSION['epoca'];
                         $ano800=$_SESSION['ano'];  
                        }
                        
                         $sql70="select *from tbl_dis2 where id_di2=:di";
                        $ru70=$con->prepare($sql70);
                        $ru70->bindParam(":di",  $id_dis,  PDO::PARAM_STR);
                        $ru70->execute();
                        $v70=$ru70->fetch(PDO::FETCH_OBJ);
                        
                        $Ep=5;
                        $sql71="select *from tbl_trancar where epocas=:epoca";
                        $run71=$con->prepare($sql71);
                        $run71->bindParam(":epoca",  $Ep, PDO::PARAM_STR);
                        $run71->execute();
                        $v71=$run71->fetch(PDO::FETCH_OBJ);
                         
                        ?>
            <div class="pagetitle">
                <h5>Caderneta</h5>
                <h1><?php if(($epoca==4)): echo "Prova Global" ;  else:echo $epoca."º Trimestre - ".$v70->nome; endif;?></h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
                <div class="row">
                    <div class="span10">
                        
                        <input type="hidden" name="epoca" id="epoca" value="<?php echo $epoca;?>"/>
                        <?php 
                        $sql="select *from view_estudante where id_aluno=:id";
                        $run=$con->prepare($sql);
                        $run->bindParam(":id",$id_aluno,PDO::PARAM_STR);
                        $run->execute();
                        $ver=$run->fetch(PDO::FETCH_OBJ);
                        ?>
                        <div class="dados_aluno">
                            <table class="table table-striped">
                                <tr>
                                    <td rowspan='3' width='100px'><img src="foto_alunos/<?php echo $ver->foto;?>" style="width:100px; height:90px;"  /></td>
                                </tr>
                                <tr>
                                     <td style="font-weight: bold; width: 180px; font-size:15px;">Nome completo:</td>
                                    <td><span style="font-weight: bold; font-size:15px; color:#003399;"><?php echo $ver->nome;?> <br/><br/><?php echo $ver->curso." - ".$ver->classe." ".$ver->turma." ".$ver->turno;?></span></td>
                           
                                </tr>
                                
                                   
                            </table>
                        </div>
                        <div class="classificacoes" style="font-weight: bold; width: 100%; font-size:14px; border: solid;">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        (1 - 2) <span style="color:#990000">MAU</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (3 - 4) <span style="color:#003399">MEDÍUQUE</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (5 - 6) <span style="color:#003399">SÚFICE</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (7 - 8) <span style="color:#003399">BOM</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (9 - 10) <span style="color:#003399">MUITO BOM</span>
                        
                        </div>
                                <div class="av">
                            <table class="table table-bordered">
                                <tr>
                                    <?php
                                  $sql77="select *from tbl_avaliacao where id_aluno=:id and ano=:ano and id_disciplina=:id_dis and epoca=:epoca";
                           $run77=$con->prepare($sql77);
                           $run77->bindParam(":id",$id_aluno,PDO::PARAM_STR);
                           $run77->bindParam(":ano",$ano800,PDO::PARAM_STR);
                           $run77->bindParam(":id_dis",$id_dis,PDO::PARAM_STR);
                           $run77->bindParam(":epoca",$epoca,PDO::PARAM_STR);
                           $run77->execute();
                           $a1=0;
                           while ($view77=$run77->fetch(PDO::FETCH_OBJ)){
                              $a1=$a1+1; 
                              echo"<th>Av ".$a1."</th>" ;
                           }
                                    ?>
                                    
                                </tr>
                                 <tr>
                                  <?php
                                  $sql78="select *from tbl_avaliacao where id_aluno=:id and ano=:ano and id_disciplina=:id_dis and epoca=:epoca";
                           $run78=$con->prepare($sql78);
                           $run78->bindParam(":id",$id_aluno,PDO::PARAM_STR);
                           $run78->bindParam(":ano",$ano800,PDO::PARAM_STR);
                           $run78->bindParam(":id_dis",$id_dis,PDO::PARAM_STR);
                           $run78->bindParam(":epoca",$epoca,PDO::PARAM_STR);
                           $run78->execute();
                                   while ($view78=$run78->fetch(PDO::FETCH_OBJ)){
                               
                              echo"<td><span style='font-size:14px; font-weight:bold;'>".$view78->valor."</span><span style='font-size:9px;'> <br/>".$view78->data."<br/><a href='eliminar_avalicao.php?id_avaliacao=".$view78->id_ava."&&id_aluno=".$view78->id_aluno."&&id_disciplina=".$id_dis."&&ano=".$ano800."&&epoca=".$epoca."&&curso=".$ver->curso."&&classe=".$ver->classe."&&pagina=lanca6_9.php'>eliminar</a><span></td>" ;
                           }
                                  ?>
                                </tr>
                            </table>
                        </div>
                        
                                <div class="pv">
                            <table class="table table-bordered">
                                <tr>
                                    <?php
                                  $sql79="select *from tbl_provas where id_aluno=:id and ano=:ano and id_disciplina=:id_dis and epoca=:epoca";
                           $run79=$con->prepare($sql79);
                           $run79->bindParam(":id",$id_aluno,PDO::PARAM_STR);
                           $run79->bindParam(":ano",$ano800,PDO::PARAM_STR);
                           $run79->bindParam(":id_dis",$id_dis,PDO::PARAM_STR);
                           $run79->bindParam(":epoca",$epoca,PDO::PARAM_STR);
                           $run79->execute();
                           $a2=0;
                           while ($view79=$run79->fetch(PDO::FETCH_OBJ)){
                              $a2=$a2+1; 
                              echo"<th>Prova ".$a2."</th>" ;
                           }
                                    ?>
                                    
                                </tr>
                                 <tr>
                                  <?php
                                  $sql80="select *from tbl_provas where id_aluno=:id and ano=:ano and id_disciplina=:id_dis and epoca=:epoca";
                           $run80=$con->prepare($sql80);
                           $run80->bindParam(":id",$id_aluno,PDO::PARAM_STR);
                           $run80->bindParam(":ano",$ano800,PDO::PARAM_STR);
                           $run80->bindParam(":id_dis",$id_dis,PDO::PARAM_STR);
                           $run80->bindParam(":epoca",$epoca,PDO::PARAM_STR);
                           $run80->execute();
                                   while ($view80=$run80->fetch(PDO::FETCH_OBJ)){
                               
                             echo"<td><span style='font-size:14px; font-weight:bold;'>".$view80->valor."</span><span style='font-size:9px;'> <br/>".$view80->data."" ;
                          if($v71->estado=="ON"): echo"<br/><a href='eliminar_prova.php?id_prova=".$view80->id_prova."&&id_aluno=".$view80->id_aluno."&&id_disciplina=".$id_dis."&&ano=".$ano800."&&epoca=".$epoca."&&curso=".$ver->curso."&&classe=".$ver->classe."&&pagina=lanca6_9.php'>eliminar</a>";
                          endif;
                          echo '</span></td>';
                             
                             
                                   }
                                  ?>
                                </tr>
                            </table>
                        </div>
                        
                        
                        
                        
                        <!-- primeiro a tetrceiro trimestre-->
                        <div class="priter">
                           
                          <?php
                          include_once 'classes/LancPROVA.php';
                                      include_once 'classes/LancAVALIACAO.php';
                                      include_once 'classes/LancFINAIS.php';
                                      include_once 'classes/Conversao.php';
                                      include_once 'classes/Calculos.php';
                                      include_once 'classes/ClassDisciplinas.php';
                                      include_once 'classes/ConseqFINAIS.php';
                                      
                                      /**Instanciar**/
                                      $ObjConseFINAIS = new ConseqFINAIS();
                                      $ObjectLancAVALIACAO = new LancAVALIACAO();
                                      $ObjectCalculos = new Calculos();
                                      $ObjectConversao = new Conversao();
                                      $ObjectClassDisciplinas = new ClassDisciplinas();
                                      $ObjectLancFINAIS = new LancFINAIS();
                                      $ObjectLancPROVAS = new LancPROVA();
                                      /**Fim de instancia*/
                                      $ObjConseFINAIS->setCon($con);
                                      $ObjectCalculos->setCon($con);
                                      $quantProCOND = $ObjectCalculos->quantidadeProvas($id_aluno, $id_dis, $epoca, $ano800);
                           

                          
                          
                          
 if(isset($_POST['sav'])):

     
  $data = date("d-m-Y");
                    $nota=addslashes(htmlspecialchars($_POST['nota']));
                    $tipo=addslashes(htmlspecialchars($_POST['tipo']));
                    if($nota>10):
                        echo"<div class='alert alert-danger'>Nota não suportada para esta classe</div>";
                    else: 
                //codigo para lancamento
                     if($tipo == "Avaliação"):
                                   //lanca Avaliacao
                                   $ObjectLancAVALIACAO->setCon($con);
                                   $result1 = $ObjectLancAVALIACAO->inserirAVALIACAO($id_aluno, $id_dis, $epoca, $ano800, $data, $nota);
                                   if($result1 == "yes"):
                                       /**buscar somatorios, quantidades e fazer calculos*/
                                      // $ObjectCalculos->setCon($con);
                                       $quantAVA = $ObjectCalculos->quantAvaliacoes($id_aluno, $id_dis, $epoca, $ano800);
                                       $quantPRO = $ObjectCalculos->quantidadeProvas($id_aluno, $id_dis, $epoca, $ano800);
                                       $somaAVA = $ObjectCalculos->somatorioAvaliacoe($id_aluno, $id_dis, $epoca, $ano800);
                                       $somaPRO = $ObjectCalculos->somatorioProvas($id_aluno, $id_dis, $epoca, $ano800);
                                       $MAC = $ObjectCalculos->retornaMac($somaAVA, $quantAVA);
                                       $CPP = $ObjectCalculos->retornaCPP($somaPRO, $quantPRO);
                                       $CT = $ObjectCalculos->retornaCT($MAC, $CPP);
                                       /** fim ponto a cima*/
                                       
                                       /**fazer update de mac, cpp, ct*/
                                       $result2 = $ObjectCalculos->FazerUpdates(round($MAC), round($CPP), round($CT), $id_aluno, $id_dis, $epoca, $ano800);
                                       if($result2 == "yes"):
                                        $ObjectLancFINAIS->setCon($con);
                                       $result3 = $ObjectLancFINAIS->buscaSomaCTs($id_aluno, $ano800, $id_dis);
                                       if($result3 == "yes"):
                                           $ObjectLancFINAIS->buscaFINAISCapCpeCF($id_aluno, $ano800, $id_dis);
                                           $CAP = $ObjectCalculos->retornaCAP($ObjectLancFINAIS->getCt1(), $ObjectLancFINAIS->getCt2(), $ObjectLancFINAIS->getCt3());
                                           $CF = $ObjectCalculos->retornaCF($CAP, $ObjectLancFINAIS->getCpe());
                                           $ObjectConversao->setComprensao(round($CF));
                                           $CF_EXTENSO = $ObjectConversao->Converte();
                                           $OBSERVACAO = $ObjectClassDisciplinas->retornaCla6_9(round($CF));
                                           /**update em cap e cf e observacao*/
                                           $result4 = $ObjectLancFINAIS->updateFinal(round($CAP), round($CF), $OBSERVACAO, $CF_EXTENSO, $id_aluno, $id_dis, $ano800);
                                           if($result4 == "yes"):
                                               echo '<div class = "alert alert-success">Lançamento feito com sucesso!</div>';
                                           endif;
                                           
                                       endif;
                                       endif;
                                       
                                       
                                       
                                   endif; 
                                   
                                   
                               elseif($tipo == "Prova"):
                                   //lanca Prova
                                   $ObjectLancPROVAS->setCon($con);
                                   $result1 = $ObjectLancPROVAS->inserirProva($id_aluno, $id_dis, $epoca, $ano800, $data, $nota);
                                   if($result1 == "yes"):
                                       /**buscar somatorios, quantidades e fazer calculos*/
                                      // $ObjectCalculos->setCon($con);
                                       $quantAVA = $ObjectCalculos->quantAvaliacoes($id_aluno, $id_dis, $epoca, $ano800);
                                       $quantPRO = $ObjectCalculos->quantidadeProvas($id_aluno, $id_dis, $epoca, $ano800);
                                       $somaAVA = $ObjectCalculos->somatorioAvaliacoe($id_aluno, $id_dis, $epoca, $ano800);
                                       $somaPRO = $ObjectCalculos->somatorioProvas($id_aluno, $id_dis, $epoca, $ano800);
                                       $MAC = $ObjectCalculos->retornaMac($somaAVA, $quantAVA);
                                       $CPP = $ObjectCalculos->retornaCPP($somaPRO, $quantPRO);
                                       $CT = $ObjectCalculos->retornaCT($MAC, $CPP);
                                       /** fim ponto a cima*/
                                       
                                       /**fazer update de mac, cpp, ct*/
                                       $result2 = $ObjectCalculos->FazerUpdates(round($MAC), round($CPP), round($CT), $id_aluno, $id_dis, $epoca, $ano800);
                                       if($result2 == "yes"):
                                        $ObjectLancFINAIS->setCon($con);
                                       $result3 = $ObjectLancFINAIS->buscaSomaCTs($id_aluno, $ano800, $id_dis);
                                       if($result3 == "yes"):
                                           $ObjectLancFINAIS->buscaFINAISCapCpeCF($id_aluno, $ano800, $id_dis);
                                           $CAP = $ObjectCalculos->retornaCAP($ObjectLancFINAIS->getCt1(), $ObjectLancFINAIS->getCt2(), $ObjectLancFINAIS->getCt3());
                                           $CF = $ObjectCalculos->retornaCF($CAP, $ObjectLancFINAIS->getCpe());
                                           $ObjectConversao->setComprensao(round($CF));
                                           $CF_EXTENSO = $ObjectConversao->Converte();
                                           $OBSERVACAO = $ObjectClassDisciplinas->retornaCla2_4(round($CF));
                                           /**update em cap e cf e observacao*/
                                           $result4 = $ObjectLancFINAIS->updateFinal(round($CAP), round($CF), $OBSERVACAO, $CF_EXTENSO, $id_aluno, $id_dis, $ano800);
                                           if($result4 == "yes"):
                                               echo '<div class = "alert alert-success">Lançamento feito com sucesso!</div>';
                                           endif;
                                           
                                       endif;
                                       endif;
                                       
                                       
                                       
                                   endif; 
                               endif;
                               
                               $ObjConseFINAIS->buscarQuantDisciplinas($ver->curso, $ver->classe);
                               $contEstado = $ObjConseFINAIS->verificarESTADO($ano800, $id_aluno);
                               if($ObjConseFINAIS->getQuantDisciplinas() == $contEstado):
                               $obsercacao_finalH="Transita";
                               $result5 = $ObjConseFINAIS->atualizaHistorico($obsercacao_finalH, $id_aluno, $ano800);
                               endif;
                               
                           echo '<meta http-equiv="refresh" content="1"/>';
                       
     
     
endif;
endif;    
    
    
    ?>
                            
                            <form class="" name="g" method="POST" action="lanca1_5.php">
                              <div class="form-inline">
                                    <label>Tipo</label>
                                    <select name="tipo" class="input-medium" required="">
                                        <option value="Avaliação">Avaliação</option>
                                        <?php if($quantProCOND<1): echo'<option value="Prova">Prova</option>';endif;?>
                                    </select>
                                    <label>Nota</label>
                                    <input type="text" name="nota" placeholder="valor" class="input-small" required=""/>
                             
                                    
                                   <input type="submit" value="Salvar" class="btn btn-primary" name="sav">
                                </div>   
                            </form>
                            
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




