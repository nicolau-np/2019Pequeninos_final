<?php 
include("validarlogin.php");
include("config/conn.php");
if(isset($_GET['id_pessoa'])):
$id_pessoa=$_GET['id_pessoa'];
$id_professor=$_GET['id_user'];

$_SESSION['id_pessoa']=$_GET['id_pessoa'];
$_SESSION['id_professor']=$_GET['id_user'];
else:
$id_pessoa=$_SESSION['id_pessoa'];
$id_professor=$_SESSION['id_professor'];
endif;

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
    
    $anoLectivo=date('Y');
    $estag=$con->prepare("SELECT DISTINCT classe,curso FROM estagiarios  WHERE classe IN ('11ª','12ª','13ª') AND anoLectivo=:ANOLECT");
    $estag->bindParam(":ANOLECT",$anoLectivo,PDO::PARAM_STR);    
    $estag->execute();
    $conta_estag=$estag->rowCount();

    $estag1=$con->prepare("SELECT idEsta,nome,curso,classe,turma,turno FROM estagiarios WHERE classe IN ('11ª','12ª','13ª') AND anoLectivo=:ANOLECT");
    $estag1->bindParam(":ANOLECT",$anoLectivo,PDO::PARAM_STR);    
    $estag1->execute();

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Horario</title>
<link rel="stylesheet" href="css/style.default.css" type="text/css" />
<link rel="stylesheet" href="css/responsive-tables.css"/>

<script type="text/javascript" src="js/jquery-1.5.2.js"></script>
<script type="text/javascript" src="js/permicao.js"></script>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/jquery-migrate-1.1.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.9.2.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.uniform.min.js"></script>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="js/modernizr.min.js"></script>
<script type="text/javascript" src="js/responsive-tables.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        
        //carregar Horas
           var turno=$("#selection9").val();
           
           $.ajax({
		type:"GET",
		url:"busc_horas.php",
        data:"turno="+turno,
		dataType:"html",	
		success: function(dados){
	$(".exibe_horas").text('')
	.append(dados);},});
        //fim carregar horas
        
        
        // dynamic table
        jQuery('#dyntable').dataTable({
            "sPaginationType": "full_numbers",
            "aaSortingFixed": [[0,'asc']],
            "fnDrawCallback": function(oSettings) {
                jQuery.uniform.update();
            }
        });
        
        jQuery('#dyntable2').dataTable( {
            "bScrollInfinite": true,
            "bScrollCollapse": true,
            "sScrollY": "300px"
        });
        
        $("#selection25").change(function(){
           var curso=$("#selection24").val();
           var classe=$("#selection25").val();
           if(curso!=0){
               $.ajax({
		type:"GET",
		url:"busc_disciplinas.php",
        data:"curso="+curso+"&classe="+classe,
		dataType:"html",	
		success: function(dados){
	$("#exibe_di").text('')
	.append(dados);},});
           }
           
        });
        
             $("#selection24").change(function(){
           var curso=$("#selection24").val();
           var classe=$("#selection25").val();
           if(classe!=0){
                  $.ajax({
		type:"GET",
		url:"busc_disciplinas.php",
        data:"curso="+curso+"&classe="+classe,
		dataType:"html",	
		success: function(dados){
	$("#exibe_di").text('')
	.append(dados);},});
           }
          
        });
        
         $("#selection9").change(function(){
           var turno=$("#selection9").val();
           
                  $.ajax({
		type:"GET",
		url:"busc_horas.php",
        data:"turno="+turno,
		dataType:"html",	
		success: function(dados){
	$(".exibe_horas").text('')
	.append(dados);},});
           
          
        });
        
        
        
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
                
                 <li class="dropdown active" id="usuarioAdmin2"><a href=""><span class="iconfa-calendar"></span> Professores</a>
                	<ul style="display: block;">
                    	<li><a href="charts.php">Novo</a></li>
                        <li  class="active"><a href="messages.php">Visualizar</a></li>
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
                 
                <li class="dropdown" id="Admin2"><a href=""><span class="iconfa-th-list"></span> Configurações</a>
                	<ul>
                	<li><a href="calendar.php">Sistema</a></li>
                     <li><a href="boxes.php">Turmas</a></li>
                     </ul>
                </li>
                <li><a href="media.php"><span class="iconfa-picture"></span> Sobre Sistema</a></li>
            </ul>
        </div><!--leftmenu-->
        
    </div><!-- leftpanel -->
    
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="dashboard.php"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="messages.php">Professores</a> <span class="separator"></span></li>
            <li>Horário</li>
            
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
            <div class="pageicon"><span class="iconfa-calendar"></span></div>
            <div class="pagetitle">
                <h5>Professores</h5>
                <h1>Horário</h1>
            </div>
        </div><!--pageheader-->
        <?php 
        $se="select *from view_professor where id_professor=:pro";
        $x=$con->prepare($se);
        $x->bindParam(":pro",$id_professor,PDO::PARAM_STR);
        $x->execute();
        $vr=$x->fetch(PDO::FETCH_OBJ);
        ?>
        <div class="maincontent">
            <div class="maincontentinner">
     <div class="widget">
     
            <h4 class="widgettitle">Cadastrar Horário</h4>
            <div class="widgetcontent">
            <?php
            include_once 'horario/Hora.php';
            include_once 'classes/salvar_horario.php';
            if(addslashes(htmlspecialchars(isset($_POST['bt1'])))){
                
             $objHora = new Hora();  
             $objHora->setCon($con);
             
             
             $id_hora = addslashes(htmlspecialchars($_POST['id_hora']));
             $curso = addslashes(htmlspecialchars($_POST['curso']));
             $classe = addslashes(htmlspecialchars($_POST['classe']));
             $turma = addslashes(htmlspecialchars($_POST['turma']));
             $turno = addslashes(htmlspecialchars($_POST['turno']));
             $ano = addslashes(htmlspecialchars($_POST['ano1']));
             $disciplina = addslashes(htmlspecialchars($_POST['disciplina']));
            $sala = addslashes(htmlspecialchars($_POST['sala']));
            $semana = addslashes(htmlspecialchars($_POST['semana']));
            $codigo=$classe."".$turma."".$turno."".$disciplina."".$semana;
            
            $resT = $objHora->_tempo($id_hora);
            $viewT = $resT->fetch(PDO::FETCH_OBJ);
             $hora_e = $viewT->hora_e;
             $hora_s = $viewT->hora_s;
            
            
            $objHorario = new salvar_horario();
            $objHorario->setCon($con);
            $objHorario->setAno($ano);
            $objHorario->setCodigo($codigo);
            $objHorario->setHora_e($hora_e);
            $objHorario->setHora_s($hora_s);
            $objHorario->setId_classe($classe);
            $objHorario->setId_curso($curso);
            $objHorario->setId_disciplina($disciplina);
            $objHorario->setId_professor($id_professor);
            $objHorario->setId_turma($turma);
            $objHorario->setId_turno($turno);
            $objHorario->setSala($sala);
            $objHorario->setSemana($semana);
            
            $res = $objHorario->verificaHorario();
            if($res == "no"):
                echo '<div class = "alert alert-danger">Ja cadastrou este horario</div>';
            elseif($res == "yes"):
                $res1 = $objHorario->verDisponibilidadeProf();
                if($res1 == "no"):
                   echo '<div class = "alert alert-danger">Professor sem disponibilidade nesta hora</div>';  
                elseif($res1 == "yes"):
                $res2 = $objHorario->verDisponibilidadeSala();
                if($res2 == "no"):
                  echo '<div class = "alert alert-danger">Sala ja oucupada nesta hora</div>';
                elseif($res2 == "yes"):
                    $res3 = $objHorario->verProfVSdisciplinas();
                    if($res3 == "no"):
                        echo '<div class = "alert alert-danger">Para esta turma ja tem um professor nesta disciplina</div>';
                    elseif($res3 == "yes"):
                        $res4 = $objHorario->Exibicao();
                        if($res4 == "yes"):
                            $res5 = $objHorario->salva();
                        if($res4 == "yes"):
                           echo '<div class = "alert alert-success">Cadastro Feito com sucesso</div>'; 
                        endif;
                        endif;
                    endif;
                endif;
                endif;
            endif;
            
          
        
                
         
            }
            
            ?>
                <form class="stdform" action="cria_horario.php" method="post">
                    	
                        <p>
                            <label>Nome do Profesor:</label>
                            <span class="field"><input type="text" name="nome" class="input-xlarge" placeholder="" value="<?php echo $vr->nome;?>" disabled=""/></span>
                            
                        </p>
                        <p>
                                <label>Curso:</label>
                                
                                <span class="field"><select name="curso" id="selection24" class="input-medium" required="">
                                        <option value="">Selecione</option>
                                <?php 
                                $sel13="select *from tbl_curso";
                                $ex13=$con->prepare($sel13);
                                $ex13->execute();
                                while($ver13=$ex13->fetch(PDO::FETCH_OBJ))
                                {
                                    
                               
                                ?>
                                          <option value="<?php echo $ver13->id_curso;?>"><?php echo $ver13->curso;?></option>
             <?php  }?>
                                </select></span>
                            </p>
                            
                            
                        <p>
                                <label>Classe:</label>
                                <span class="field"><select name="classe" id="selection25" class="input-medium" required="">
                                        <option value="">Selecione</option>
                                <?php 
                                $sel1="select *from tbl_classe";
                                $ex1=$con->prepare($sel1);
                                $ex1->execute();
                                while($ver1=$ex1->fetch(PDO::FETCH_OBJ))
                                {
                                    
                               
                                ?>
                                          <option value="<?php echo $ver1->id_classe;?>"><?php echo $ver1->classe;?></option>
             <?php  }?>
                                </select></span>
                            </p>
                            
                             <p>
                         <label>Disciplina:</label>
                         <span class="field" id="exibe_di"><select name="disciplina" id="selection1" class="input-medium" required="">
                                
                                          <option value="">Selecione</option>
             
                                </select></span>
                        </p>
                            
                            <p>
                                <label>Turma:</label>
                                <span class="field"><select name="turma" id="selection2" class="input-medium" required="">
                                        <option value="">Selecione</option>
                                <?php 
                                $sel2="select *from tbl_turma";
                                $ex2=$con->prepare($sel2);
                                $ex2->execute();
                                while($ver2=$ex2->fetch(PDO::FETCH_OBJ))
                                {
                                    
                               
                                ?>
                                    <option value="<?php echo $ver2->id_turma;?>"><?php echo $ver2->turma; ?></option>
                   <?php  }?>
                                </select></span>
                            </p>
                            
                            <p>
                                <label>Turno:</label>
                                <span class="field"><select name="turno" id="selection9" class="input-medium" required="">
                                <option value="">Selecione</option>
                                <?php 
                                $sel3="select *from tbl_turno";
                                $ex3=$con->prepare($sel3);
                                $ex3->execute();
                                while($ver3=$ex3->fetch(PDO::FETCH_OBJ))
                                {
                                    
                               
                                ?>
                                    <option value="<?php echo $ver3->id_turno;?>"><?php echo $ver3->turno;?></option>
                             <?php  }?>
                                </select></span>
                            </p>
                            <div class="exibe_horas">
                            <p>
                            <label>Hora E/S:</label>
                            <span id="id_hora">
                                <select name="id_hora" required="">
                                    <option value=""></option>
                                </select>
                            </span>
                      </p>
                        </div>
                            <p>
                                <label>Sala:</label>
                                <span class="field"><select name="sala" id="selection3" class="input-medium" required="">
                                    <option value="">Selecione</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                    <option>6</option>
                                    <option>7</option>
                                    <option>8</option>
                                    <option>9</option>
                                    <option>10</option>
                                    <option>11</option>
                                    <option>12</option>
                                    <option>13</option>
                                    <option>14</option>
                                    <option>15</option>
                                    <option>16</option>
                                    <option>ANEXA 1</option>
                                    <option>ANEXA 2</option>
                                    <option>ANEXA 3</option>
                                    <option>ANEXA 4</option>
                                    <option>SALÃO 1</option>
                                    <option>SALÃO 2</option>
                                    <option>SALÃO 3</option>
                                    <option>SALÃO 4</option>
                            
                                </select></span>
                            </p>
                            
                            <p>
                                <label>Dia Semana:</label>
                                <span class="field"><select name="semana" id="selection3" class="input-medium" required="">
                                        <option value="">Selecione</option>
                                    <option>Segunda</option>
                            <option>Terça</option>
                             <option>Quarta</option>
                              <option>Quinta</option>
                               <option>Sexta</option>
                                </select></span>
                            </p>
             
                        <p>
                            <label>Ano Lectivo:</label>
                            <span class="field"><input type="text" class="input-medium" value="<?php echo date('Y');?>" required name="ano1"/></span>
                        </p>
                        
                        
                        <p class="stdformbutton">
                                    <button type="submit" class="btn btn-primary" name="bt1">Salvar Dados</button>
                            </p>
     
                </form>
            </div><!--widgetcontent-->
            </div>
     
     
     <!-- horarios cadastrados-->
     <br />
     
    <h4 class="widgettitle">Horários Cadastrados</h4>  
   <div class="table-wrapper"><table class="table table-bordered responsive">
                    <thead>
                        <tr>
                            <th>Rendering engine</th>
                            <th>Dia Semana</th>
                            <th>Disciplina</th>
                            <th>Classe</th>
                            <th>Turma</th>
                            <th>Turno</th>
                            <th>Sala</th>
                            <th>Hora Entrada</th>
                            <th>Hora Saida</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $anoLe=date("Y");
                    $se34="select *from view_horario where id_professor=:id and anolectivo=:ano";
                    $x34=$con->prepare($se34);
                    $x34->bindParam(":id",$id_professor,PDO::PARAM_STR);
                    $x34->bindParam(":ano",$anoLe,PDO::PARAM_STR);
                    $x34->execute();
                    $contar34=$x34->rowCount();
                    if($contar34==0):
                    echo"Nenhum horário encontrado";
                    else:
                    while($vt=$x34->fetch(PDO::FETCH_OBJ))
                    {
                        echo"
                        <tr>
                            <td>Trident</td>
							<td>{$vt->semana}</td>
                            <td>{$vt->nome}</td>
                            <td>{$vt->classe}</td>
                            <td>{$vt->turma}</td>
                            <td>{$vt->turno}</td>
                            <td>{$vt->sala}</td>
                            <td>{$vt->hora_e}</td>
                            <td>{$vt->hora_s}</td>
                            <td><a href='eliminar_horario.php?id_horario={$vt->id_horario}' class='btn btn-danger' style='color: #FFF;'>Eliminar</a></td>
                        </tr>
                        ";
                    }
                    endif;
                    ?>
                        
         
                    </tbody>
                </table>
                <br />
                <a href="impri_hora.php?id_prof=<?php echo $id_professor;?>&&nome=<?php echo $vr->nome;?>" class="btn btn-default">Imprimir Horário</a>
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

