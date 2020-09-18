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
<title>Justificar Faltas</title>
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
            <li>Justificar Faltas</li>
			
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
            <div class="pageicon"><span class="iconfa-hand-up"></span></div>
            <div class="pagetitle">
                <h5>pesquize o estudante </h5>
                <h1>Justificar Faltas</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
                <div class="row-fluid">
                    <form class="form-inline" action="justicar_falta.php" method="GET">
                    <label>Processo:</label>
                    <span class="field"><input type='text' placeholder='Processo' name='processo' value='<?php if(isset($_GET['pesq'])): echo $_GET['processo']; endif;?>' class='input-small'></span>
                      <label>Disciplina:</label>
                   <span class="field"><select name="disciplina" id="selection1" class="input-medium">
                                
                                <?php 
                                if(isset($_GET['pesq'])):
                                echo "<option>{$_GET['disciplina']}</option>";
                                endif;
                                $sel1="select *from tbl_dis2";
                                $ex1=$con->prepare($sel1);
                                $ex1->execute();
                                while($ver1=$ex1->fetch(PDO::FETCH_OBJ))
                                {
                                    
                               
                                ?>
                                          <option value='<?php echo $ver1->id_di2;?>'><?php echo $ver1->nome;?></option>
             <?php  }?>
                                </select></span>
                       <label>Ano Lectivo:</label>
                            <span class="field"><input type="text" name="ano" class="input-small" value="<?php if(isset($_GET['pesq'])):echo $_GET['ano'];else: echo date('Y');endif;?>" required/></span>
                       
                        <button type="submit" name="pesq" class="btn btn-primary">Pesquizar</button>  
						
					<?php 
					if(isset($_GET['btjus']))
					{
					$est="off";
					if(!isset($_GET['id_faltas']))
					{
					echo "<div class='alert alert-warning'>Deve selecionar as faltas para justificar</div>";
					}
					else{
					$est88="activo";
					$est881="off";
					foreach($_GET['id_faltas'] as $ids)
					{
					$up="update tbl_faltas set estado=:estado where id_falta=:ids";
					$ex71=$con->prepare($up);
					$ex71->bindParam(":estado",$est,PDO::PARAM_STR);
					$ex71->bindParam(":ids",$ids,PDO::PARAM_STR);
					$ex71->execute();
		}
		
		$select90="select *from view_faltas where id_aluno=:processo and id_di2=:dis and estado=:esta and ano=:ano";
$ex90=$con->prepare($select90);
$ex90->bindParam(":processo",$_SESSION['pro88'],PDO::PARAM_STR);
$ex90->bindParam(":dis",$_SESSION['dis88'],PDO::PARAM_STR);
$ex90->bindParam(":esta",$est88,PDO::PARAM_STR);
$ex90->bindParam(":ano",$_SESSION['ano88'],PDO::PARAM_STR);
$ex90->execute();
$contActivas=$ex90->rowCount();


		$select901="select *from view_faltas where id_aluno=:processo and id_di2=:dis and estado=:esta and ano=:ano";
$ex901=$con->prepare($select901);
$ex901->bindParam(":processo",$_SESSION['pro88'],PDO::PARAM_STR);
$ex901->bindParam(":dis",$_SESSION['dis88'],PDO::PARAM_STR);
$ex901->bindParam(":esta",$est881,PDO::PARAM_STR);
$ex901->bindParam(":ano",$_SESSION['ano88'],PDO::PARAM_STR);
$ex901->execute();
$contInActivas=$ex901->rowCount();



	$up2="update view_clas_finais set total_faltas=:total, faltas_justificadas=:jus where id_aluno=:id_a and id_di2=:dis and anolectivo=:ano";
					$ex72=$con->prepare($up2);
					$ex72->bindParam(":total",$contActivas,PDO::PARAM_STR);
					$ex72->bindParam(":jus",$contInActivas,PDO::PARAM_STR);
					$ex72->bindParam(":id_a",$_SESSION['pro88'],PDO::PARAM_STR);
					$ex72->bindParam(":dis",$_SESSION['dis88'],PDO::PARAM_STR);
					$ex72->bindParam(":ano",$_SESSION['ano88'],PDO::PARAM_STR);
					$ex72->execute();	
		
		
					if($ex72)
					{
					echo"<div class='alert alert-success'>Faltas Justificadas com sucesso</div>";
					}
					}
					
					
					}
					?>
			<br/>		
			<table class='table table-striped' width='70%'>
			<thead>
			<tr>
                            <th>--</th>
                            <th>Nome</th>
                            <th>Tipo</th>
							<th>Data</th>
							<th>Hora</th>
					
                           
                        </tr>
			</thead>
			
			<tbody>
						
<?php 
if(isset($_GET['pesq']))
                    {
                        $curso="Geral";
                        $processo=$_GET['processo'];
                        $id_disciplina=$_GET['disciplina'];
                        $ano=$_GET['ano'];
                        $estado="activo";
			$_SESSION['pro88']=$processo;
                        $_SESSION['dis88']=$id_disciplina;
                         $_SESSION['ano88']=$ano;
        $select70="select *from view_faltas where id_aluno=:processo and id_di2=:disciplina and estado=:estado and ano=:ano";
        $xe70=$con->prepare($select70);
        $xe70->bindParam(":processo",$processo,PDO::PARAM_STR);
        $xe70->bindParam(":disciplina",$id_disciplina,PDO::PARAM_STR);
		$xe70->bindParam(":estado",$estado,PDO::PARAM_STR);
        $xe70->bindParam(":ano",$ano,PDO::PARAM_STR);
        $xe70->execute(); 
        $conta=$xe70->rowCount();
        if($conta>0):
   
        while($ver70=$xe70->fetch(PDO::FETCH_OBJ))
        {
         
            echo"
			
			<tr>
                            <td><input type='checkbox' name='id_faltas[]' value='{$ver70->id_falta}'></td>
                            <td>{$ver70->nome}</td>
                            <td>{$ver70->tipo}</td>
							<td>{$ver70->data}</td>
							<td>{$ver70->hora}</td>
					
                           
                        </tr>";
        }
		
		
		
        else:
        echo"<br/>Nenhuma falta encontrada";
        endif; 
		}
		?>
</tbody>
</table>

<br/>
					<input class='btn btn-primary' type='submit' value='Justificar' name='btjus'/>	
					
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

