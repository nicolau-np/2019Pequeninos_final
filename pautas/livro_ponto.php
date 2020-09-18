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
<title>Livro de Ponto</title>
<link rel="stylesheet" href="css/style.default.css" type="text/css" />

<link rel="stylesheet" href="css/responsive-tables.css"/>
<script type="text/javascript" src="js/jquery-1.5.2.js"></script>
<script type="text/javascript" src="js/permicao.js"></script>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/jquery-migrate-1.1.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.9.2.min.js"></script>
<script type="text/javascript" src="js/modernizr.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="js/jquery.uniform.min.js"></script>
<script type="text/javascript" src="js/flot/jquery.flot.min.js"></script>
<script type="text/javascript" src="js/flot/jquery.flot.resize.min.js"></script>
<script type="text/javascript" src="js/responsive-tables.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/excanvas.min.js"></script><![endif]-->
<style>
#legenda{
    margin-left: -20%;

    width: 100%;
   opacity: 0.7;
   background-color: #4B89A0;
}
</style>
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
                                <li><a href="#">Configurações da Conta</a></li>
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
                
                <li id="usuarioAdmin1" class="dropdown"><a href=""><span class="iconfa-pencil"></span> Estudantes</a>
                	<ul>
                    	<li><a href="forms.php">Matricular</a></li>
                        <li><a href="wizards.php">Visualizar</a></li>
                        <li><a href="wysiwyg.php">Listas Nominais</a></li>
                    </ul>
                </li>
                <li id="directorProfessor1" class="dropdown"><a href=""><span class="iconfa-briefcase"></span> Caderneta</a>
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
            
                
                <li id="Admin1" class="dropdown"><a href=""><span class="iconfa-th-list"></span> Usuários</a>
                	<ul>
                    	<li><a href="table-static.php">Novo</a></li>
                        <li class=""><a href="table-dynamic.php">Visualizar</a></li>
                    </ul>
                </li>
                
                 <li id="usuarioAdmin2" class="dropdown"><a href=""><span class="iconfa-calendar"></span> Professores</a>
                	<ul>
                    	<li><a href="charts.php">Novo</a></li>
                        <li class=""><a href="messages.php">Visualizar</a></li>
                    </ul>
                </li>
                
               
                <li id="directorProfessor2" class="dropdown"><a href=""><span class="iconfa-book"></span> Mini Pautas</a>
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
                <li id="Admin2" class="dropdown"><a href=""><span class="iconfa-th-list"></span> Configurações</a>
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
            <li>Livro de Ponto</li>
			
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
            <div class="pageicon"><span class="iconfa-pencil"></span></div>
            <div class="pagetitle">
			<?php 
			if(isset($_GET['id_professor'])):
			//gets
			$id_professor60=$_GET['id_professor'];
			$classe60=$_GET['classe'];
			$turma60=$_GET['turma'];
			$turno60=$_GET['turno'];
			$ano60=$_GET['ano'];
			$id_disciplina60=$_GET['id_disciplina'];
			$disciplina60=$_GET['disciplina'];
			//sessions
			$_SESSION['id_professor60']=$_GET['id_professor'];
			$_SESSION['classe60']=$_GET['classe'];
			$_SESSION['turma60']=$_GET['turma'];
			$_SESSION['turno60']=$_GET['turno'];
			$_SESSION['ano60']=$_GET['ano'];
			$_SESSION['id_disciplina60']=$_GET['id_disciplina'];
			$_SESSION['disciplina60']=$_GET['disciplina'];
			
else:
			$id_professor60=$_SESSION['id_professor60'];
			$classe60=$_SESSION['classe60'];
			$turma60=$_SESSION['turma60'];
			$turno60=$_SESSION['turno60'];
			$ano60=$_SESSION['ano60'];
			$id_disciplina60=$_SESSION['id_disciplina60'];
			$disciplina60=$_SESSION['disciplina60'];
			
			endif;
			
			?>
			
			
			
                <h5><?php echo $classe60." ".$turma60." ".$turno60."-".$disciplina60;?> </h5>
                <h1>Livro de Ponto</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
                <div class="row-fluid">
<?php 
if(isset($_POST['bt60']))
{
$tipo=$_POST['tipo'];
$data=date("d-m-Y");
$hora=date("H:i");  
$ano60=date("Y");
$estado="activo";
if(!isset($_POST['id']))
{
echo "<div class='alert alert-warning'>Deve selecionar estudante para fazer a marcação</div>";
}
else
{
$a=0;
foreach($_POST['id'] as $ids)
{
$a++;

$in="insert into tbl_faltas (id_di2,id_aluno,id_professor,data,hora,estado,tipo,ano,disciplina)values(:id_di2,:id_aluno,:id_professor,:data,:hora,:estado,:tipo,:ano,:disciplina)";
$ex61=$con->prepare($in);
$ex61->bindParam(":id_di2",$id_disciplina60,PDO::PARAM_STR);
$ex61->bindParam(":id_aluno",$ids,PDO::PARAM_STR);
$ex61->bindParam(":id_professor",$id_professor60,PDO::PARAM_STR);
$ex61->bindParam(":data",$data,PDO::PARAM_STR);
$ex61->bindParam(":hora",$hora,PDO::PARAM_STR);
$ex61->bindParam(":estado",$estado,PDO::PARAM_STR);
$ex61->bindParam(":tipo",$tipo,PDO::PARAM_STR);
$ex61->bindParam(":ano",$ano60,PDO::PARAM_STR);
$ex61->bindParam(":disciplina",$disciplina60,PDO::PARAM_STR);
$ex61->execute();


$select90="select *from tbl_faltas where id_aluno=:id and id_di2=:dis and estado=:esta and ano=:ano";
$ex90=$con->prepare($select90);
$ex90->bindParam(":id",$ids,PDO::PARAM_STR);
$ex90->bindParam(":dis",$id_disciplina60,PDO::PARAM_STR);
$ex90->bindParam(":esta",$estado,PDO::PARAM_STR);
$ex90->bindParam(":ano",$ano60,PDO::PARAM_STR);
$ex90->execute();
$cont=$ex90->rowCount();
if($cont==1):
$total=1;
elseif($cont>1):
$total=$cont;
endif;

$up="update view_clas_finais set total_faltas=:total where id_aluno=:id and id_di2=:dis and anolectivo=:ano";
$ex91=$con->prepare($up);
$ex91->bindParam(":total",$total,PDO::PARAM_STR);
$ex91->bindParam(":id",$ids,PDO::PARAM_STR);
$ex91->bindParam(":dis",$id_disciplina60,PDO::PARAM_STR);
$ex91->bindParam(":ano",$ano60,PDO::PARAM_STR);
$ex91->execute();

}
if($ex91)
{
echo "<div class='alert alert-success'>$a aluno(s) marcado(s) falta de $tipo</div>";
  echo '<meta http-equiv="refresh" content="1"/>';
}
}					
		
}

?>
					
					<form action="livro_ponto.php" method="POST" class="" name="f1">
                  <table class='table table-striped' style="width:60%">
				  <thead>
				  <tr>
				  <th>-</th>
				  <th>Nº</th>
				  <th>Foto</th>
				  <th>Nome completo</th>
				  <th>Genero</th>
				  </tr>
				  </thead>
				  <tbody>
				  <?php 
				  $s60="select *from view_estudante where classe=:classe and turma=:turma and turno=:turno and anolectivo=:ano order by nome asc";
				  $ex60=$con->prepare($s60);
				  $ex60->bindParam(":classe",$classe60,PDO::PARAM_STR);
				  $ex60->bindParam(":turma",$turma60,PDO::PARAM_STR);
				  $ex60->bindParam(":turno",$turno60,PDO::PARAM_STR);
				  $ex60->bindParam(":ano",$ano60,PDO::PARAM_STR);
				  $ex60->execute();
				  $a=0;
				  while($v60=$ex60->fetch(PDO::FETCH_OBJ)){
				  $a++;
				  ?>
				  <tr>
				  <td>
				  <input type="checkbox" name="id[]" value="<?php echo $v60->id_aluno;?>"/> <?php echo $v60->id_aluno;?>
				  
				  </td>
				   <td><?php echo $a;?></td>
				    <td><img src='foto_alunos/<?php echo $v60->foto;?>' style='width:60px; height:50px'></td>
					 <td><?php echo $v60->nome;?></td>
					  <td><?php echo $v60->genero;?></td>
				  </tr>
				  <?php }?>
				  </tbody>
				  </table>
				  Tipo de Falta:<select name='tipo' class='input-medium'>
				  <option>Comparencia</option>
			<option>Indisciplina</option>
				  </select>
				  <input type='submit' name='bt60' value='Marcar' class='btn btn-primary'/>
                   </form> 
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

</body>
</html>

