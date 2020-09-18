<?php 
include("config/conn.php");
include("validarlogin.php");
include_once 'classes/Caderneta.php';
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
<title>Caderneta</title>
<link rel="stylesheet" href="css/style.default.css" type="text/css" />
<script type="text/javascript" src="js/jquery-1.5.2.js"></script>
<script type="text/javascript" src="js/permicao.js"></script>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/jquery-migrate-1.1.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.9.2.min.js"></script>
<script type="text/javascript" src="js/modernizr.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
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
                <li class="dropdown active" id="directorProfessor1"><a href=""><span class="iconfa-briefcase"></span> Caderneta</a>
                	<ul style="display: block;">
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
        <?php 
        if(isset($_GET['classe'])):
        $id_curso200=$_GET['curso'];
        $id_classe200=$_GET['classe'];
        $id_turma200=$_GET['turma'];
        $id_turno200=$_GET['turno'];
        $id_disciplina200=$_GET['disciplina'];
        $_SESSION['curso']=$_GET['curso'];
        $_SESSION['classe']=$_GET['classe'];
        $_SESSION['turma']=$_GET['turma'];
        $_SESSION['turno']=$_GET['turno'];
        $_SESSION['disciplina']=$_GET['disciplina'];
        else:
        $id_curso200=$_SESSION['curso'];
        $id_classe200=$_SESSION['classe'];
        $id_turma200=$_SESSION['turma'];
        $id_turno200=$_SESSION['turno'];
        $id_disciplina200=$_SESSION['disciplina'];
        endif;
        
        $do0="select *from tbl_curso where id_curso=:id";
        $r0=$con->prepare($do0);
        $r0->bindParam(":id",$id_curso200,PDO::PARAM_STR);
        $r0->execute();
        $v0=$r0->fetch(PDO::FETCH_OBJ);
        
        $do="select *from tbl_classe where id_classe=:id";
        $r=$con->prepare($do);
        $r->bindParam(":id",$id_classe200,PDO::PARAM_STR);
        $r->execute();
        $v1=$r->fetch(PDO::FETCH_OBJ);
        
        $do2="select *from tbl_turma where id_turma=:id";
        $r2=$con->prepare($do2);
        $r2->bindParam(":id",$id_turma200,PDO::PARAM_STR);
        $r2->execute();
        $v2=$r2->fetch(PDO::FETCH_OBJ);
        
        $do3="select *from tbl_turno where id_turno=:id";
        $r3=$con->prepare($do3);
        $r3->bindParam(":id",$id_turno200,PDO::PARAM_STR);
        $r3->execute();
        $v3=$r3->fetch(PDO::FETCH_OBJ);
        
         $do4="select *from tbl_dis2 where id_di2=:id";
        $r4=$con->prepare($do4);
        $r4->bindParam(":id",$id_disciplina200,PDO::PARAM_STR);
        $r4->execute();
        $v4=$r4->fetch(PDO::FETCH_OBJ);
        
        ?>
        <ul class="breadcrumbs">
            <li><a href="dashboard.php"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="dashboard.php">Cardeneta</a> <span class="separator"></span></li>
            <li><?php echo $v1->classe."".$v2->turma." ".$v3->turno;?></li>
            
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
                <h5>Cardeneta</h5>
                <h1><?php echo $v1->classe." ".$v2->turma." ".$v3->turno." - ".$v4->nome;?></h1>
            </div>            
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
                <div class="row-fluid">
				<?php 
				
				if((isset($_GET['classe']))&&(isset($_GET['curso']))&&(isset($_GET['disciplina'])))
				{
				$cursoV5=$_GET['curso'];
				$classeV5=$_GET['classe'];
				$turmaV5=$_GET['turma'];
				$turnoV5=$_GET['turno'];
				$disciplinaV5=$_GET['disciplina'];
				$_SESSION['classeV5']=$_GET['classe'];
				$_SESSION['cursoV5']=$_GET['curso'];
				$_SESSION['turmaV5']=$_GET['turma'];
				$_SESSION['turnoV5']=$_GET['turno'];
				$_SESSION['disciplinaV5']=$_GET['disciplina'];
				}
				else{
				$classeV5=$_SESSION['classeV5'];
				$cursoV5=$_SESSION['cursoV5'];
				$turmaV5=$_SESSION['turmaV5'];
				$turnoV5=$_SESSION['turnoV5'];
				$disciplinaV5=$_SESSION['disciplinaV5'];
				}
				$cV5="select *from tbl_classe where id_classe=:id_classe";
				$eV5=$con->prepare($cV5);
				$eV5->bindParam(":id_classe",$classeV5,PDO::PARAM_STR);
				$eV5->execute();
				$verV5=$eV5->fetch(PDO::FETCH_OBJ);
				
				$cV6="select *from tbl_curso where id_curso=:id_curso";
				$eV6=$con->prepare($cV6);
				$eV6->bindParam(":id_curso",$cursoV5,PDO::PARAM_STR);
				$eV6->execute();
				$verV6=$eV6->fetch(PDO::FETCH_OBJ);
				
           if($verV6->tipo_ensino == "Ensino Fundamental"):
              if(($verV5->classe=="1ª")||($verV5->classe=="3ª")||($verV5->classe=="5ª")||($verV5->classe=="Iniciação")):
                include("cardenetas/1_3_5.php");
              elseif(($verV5->classe=="7ª")||($verV5->classe=="8ª")):
                 include("cardenetas/7_8.php");
              elseif(($verV5->classe=="2ª")||($verV5->classe=="4ª")):
                  include("cardenetas/2_4.php");
              elseif(($verV5->classe=="9ª")||($verV5->classe=="6ª")):
                 include("cardenetas/6_9.php");  
              endif;
           else:
           //outros tipos de ensino    
           endif;
				
	?>
				
</div><!--row-fluid-->
                
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
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
    <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
        <h3 id="myModalLabel">Modal Heading</h3>
    </div>
    <div class="modal-body">
        <h4>Text in a modal</h4>
        <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem.</p>
        <p>Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.</p>
    </div>
    <div class="modal-footer">
        <button data-dismiss="modal" class="btn">Close</button>
        <button class="btn btn-primary">Save changes</button>
    </div>
</div><!--#myModal-->

<script type="text/javascript">
    jQuery(document).ready(function(){
                                    
        //Replaces data-rel attribute to rel.
        //We use data-rel because of w3c validation issue
        jQuery('a[data-rel]').each(function() {
            jQuery(this).attr('rel', jQuery(this).data('rel'));
        });
        
        // tooltip sample
	if(jQuery('.tooltipsample').length > 0)
		jQuery('.tooltipsample').tooltip({selector: "a[rel=tooltip]"});
		
	jQuery('.popoversample').popover({selector: 'a[rel=popover]', trigger: 'hover'});
        
    });
</script>

</body>
</html>

