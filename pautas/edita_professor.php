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
<title>Editar Professor</title>

<link rel="stylesheet" href="css/style.default.css" type="text/css" />
<link rel="stylesheet" href="css/bootstrap-fileupload.min.css" type="text/css" />
<link rel="stylesheet" href="css/bootstrap-timepicker.min.css" type="text/css" />
<script type="text/javascript" src="js/jquery-1.5.2.js"></script>
<script type="text/javascript" src="js/permicao.js"></script>
<script type="text/javascript" src="js/municipio.js"></script>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/jquery-migrate-1.1.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.9.2.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/bootstrap-fileupload.min.js"></script>
<script type="text/javascript" src="js/bootstrap-timepicker.min.js"></script>
<script type="text/javascript" src="js/jquery.uniform.min.js"></script>
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/jquery.tagsinput.min.js"></script>
<script type="text/javascript" src="js/jquery.autogrow-textarea.js"></script>
<script type="text/javascript" src="js/charCount.js"></script>
<script type="text/javascript" src="js/colorpicker.js"></script>
<script type="text/javascript" src="js/ui.spinner.min.js"></script>
<script type="text/javascript" src="js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="js/modernizr.min.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
<script type="text/javascript" src="js/forms.js"></script>

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
                    	<li class="active"><a href="charts.php">Novo</a></li>
                        <li><a href="messages.php">Visualizar</a></li>
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
            <li><a href="charts.php">Professores</a> <span class="separator"></span></li>
            <li>Editar</li>
            
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
                <h1>Editar</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
                
                               <div class="widget">
            <h4 class="widgettitle">Editar Dados</h4>
            <div class="widgetcontent">
            <?php 
			if(isset($_GET['id_pessoa'])):
			$id_pessoaE=$_GET['id_pessoa'];
			$id_userE=$_GET['id_user'];
			$fotoE=$_GET['foto'];
			
			$_SESSION['id_pessoaE']=$_GET['id_pessoa'];
			$_SESSION['id_userE']=$_GET['id_user'];
			$_SESSION['fotoE']=$_GET['foto'];
			else:
			$id_pessoaE=$_SESSION['id_pessoaE'];
			$id_userE=$_SESSION['id_userE'];
			$fotoE=$_SESSION['fotoE'];
			endif;
			
			$covE="select *from view_professor where id_pessoa=:id_pessoa";
			$EcovE=$con->prepare($covE);
			$EcovE->bindParam(":id_pessoa",$id_pessoaE,PDO::PARAM_STR);
			$EcovE->execute();
			$verE=$EcovE->fetch(PDO::FETCH_OBJ);
			
			
			
			if($verE->titulo=="Professor Director"):
                $data=date("Y");
			$covE2="select *from view_director where id_professor=:id and anolectivo=:ano";
			$EcovE2=$con->prepare($covE2);
			$EcovE2->bindParam(":id",$verE->id_professor,PDO::PARAM_STR);
			$EcovE2->bindParam(":ano",$data,PDO::PARAM_STR);
			$EcovE2->execute();
			$verE2=$EcovE2->fetch(PDO::FETCH_OBJ);
			
			//busca id da classe
			$seClasse="select *from tbl_classe where classe=:classe";
			$eClasse=$con->prepare($seClasse);
			$eClasse->bindParam(":classe",$verE2->classe,PDO::PARAM_STR);
			$eClasse->execute();
			$vClasse=$eClasse->fetch(PDO::FETCH_OBJ);
		
			$seCurso="select *from tbl_curso where curso=:curso";
			$eCurso=$con->prepare($seCurso);
			$eCurso->bindParam(":curso",$verE2->curso,PDO::PARAM_STR);
			$eCurso->execute();
			$vCurso=$eCurso->fetch(PDO::FETCH_OBJ);
		
			endif;
			
			
			
			
            if(isset($_POST['bt1']))
            {
              include("classes/actualizar_professor.php");
              $nome=$_POST['nome'];
              $agente=$_POST['agente'];
              $data=$_POST['nascimento'];
              $telefone=$_POST['telefone'];
              $bi=$_POST['bi'];
              $data_emissao=$_POST['emissao'];
              $local_emissao=$_POST['local_emissao'];
              $genero=$_POST['genero'];
              $titulo=$_POST['estado'];
              $curso=$_POST['curso'];
              $classe=$_POST['classe'];
              $turma=$_POST['turma'];
              $turno=$_POST['turno'];
              $ano=$_POST['ano1'];
              $arquivo=$_FILES['foto']['name'];
              $arquivo_tmp=$_FILES['foto']['tmp_name'];
               $pai=$_POST['pai'];
               $mae=$_POST['mae'];
               $provincia=$_POST['provincia'];
               $municipio=$_POST['municipio'];
                  $categoria_estudo=$_POST['categoria_estudo'];
			  
              
              $obj= new actualizar_professor;
              if($titulo=="Professor Normal"):
              $obj->professor($nome,$agente,$data,$telefone,$bi,$data_emissao,$local_emissao,$genero,$titulo,$arquivo,$arquivo_tmp,$pai,$mae,$provincia,$municipio,$id_pessoaE,$fotoE, $categoria_estudo,$con);  
              else:
              //ver se ja existe essa turma
              $sele="select *from tbl_diretores where id_curso=:curso and id_classe=:classe and id_turma=:turma and id_turno=:turno and anolectivo=:ano";
              $s5=$con->prepare($sele);
              $s5->bindParam(":curso",$curso,PDO::PARAM_STR);
               $s5->bindParam(":classe",$classe,PDO::PARAM_STR);
                $s5->bindParam(":turma",$turma,PDO::PARAM_STR);
                 $s5->bindParam(":turno",$turno,PDO::PARAM_STR);
                   $s5->bindParam(":ano",$ano,PDO::PARAM_STR);
              $s5->execute();
			  $vs5=$s5->fetch(PDO::FETCH_OBJ);
              $conta1=$s5->rowCount();
              if(($conta1>0)&&($verE->id_professor!=$vs5->id_professor)):
              echo("<div class='alert alert-danger'>Ja existe director de turma para esta turma!</div>");
              else:
              $obj->director($nome,$agente,$data,$telefone,$bi,$data_emissao,$local_emissao,$genero,$titulo,$curso,$classe,$turma,$turno,$ano,$arquivo,$arquivo_tmp,$pai,$mae,$provincia,$municipio,$id_pessoaE,$fotoE, $categoria_estudo,$con);  
              endif;
              
              
              endif;
              
            }
            ?>
                <form class="stdform" action="edita_professor.php" method="post" enctype="multipart/form-data">
                    	
                        <p>
                            <label>Nome de Completo:</label>
                            <span class="field"><input type="text" name="nome" class="input-xlarge" placeholder="João Manuel" value="<?php echo $verE->nome;?>" required/></span>
                        </p>
                        
                         <p>
                            <label>Nº Agente:</label>
                            <span class="field"><input type="text" name="agente" class="input-medium" placeholder="1234" value="<?php echo $verE->nAgente;?>" required/></span>
                        </p>
                        <p>
                            <label>Data de Nascimento:</label>
                            <span class="field"><input type="date" name="nascimento" class="input-medium"  value="<?php echo $verE->data_nascimento;?>" required/></span>
                        </p>
                        
                        <p>
                        <label for="">Província:</label>
                    <select size="1" name="provincia" id="provincia" onChange="escolha()" class='input-medium'>
	<option><?php echo $verE->provincia;?></option>
	<option value="Namibe">Namibe</option>
	<option value="Huíla">Huíla</option>
    <option value="Bié">Bié</option>
	<option value="Moxico">Moxico</option>
    <option value="Luanda">Luanda</option>
	<option value="Benguela">Benguela</option>
    <option value="Cuando Cubango">Cuando Cubango</option>
	<option value="Lunda Sul">Lunda Sul</option>
    <option value="Malanje">Malanje</option>
	<option value="Uíge">Uíge</option>
    <option value="Zaire">Zaire</option>
	<option value="Cunene">Cunene</option>
    <option value="Cuanza Sul">Cuanza Sul</option>
	<option value="Lunda Norte">Lunda Norte</option>
    <option value="Cuanza Norte">Cuanza Norte</option>
	<option value="Lunda Sul">Lunda Sul</option>
    <option value="Huambo">Huambo</option>
<option value="Bengo">Bengo</option>
<option value="Cabinda">Cabinda</option>
</select>
                        </p>
                        
                        <label for="">Município:</label>
                  <select size="1" name="municipio" id="municipio" class='input-medium'>
	<option><?php echo $verE->municipio;?></option>
</select>
                        
                        <p>
                              <p>
                            <label>Nome Pai:</label>
                            <span class="field"><input type="text" name="pai" class="input-medium"  placeholder="Jose" value="<?php echo $verE->pai;?>"/></span>
                        </p> 
                        
                           <p>
                            <label>Nome Mãe:</label>
                            <span class="field"><input type="text" name="mae" class="input-medium"  placeholder="Joaquina" value="<?php echo $verE->mae;?>"/></span>
                        </p>
                        
                        <p>
                            <label>Nº Telefone:</label>
                            <span class="field"><input type="text" name="telefone" class="input-medium" placeholder="946216795" required="" value="<?php echo $verE->telefone;?>"/></span>
                        </p>
                        <p>
                            <label>Nº B.I.:</label>
                            <span class="field"><input type="text" name="bi" class="input-medium" placeholder="34678722NE046" value="<?php echo $verE->bi;?>" required/></span>
                        </p>
                        <p>
                            <label>Data de Emissão:</label>
                            <span class="field"><input type="date" name="emissao" class="input-medium" value="<?php echo $verE->data_emissao;?>"/></span>
                        </p>
                        <p>
                            <label>Local de Emissão:</label>
                            <span class="field"><input type="text" name="local_emissao" class="input-medium"  value="<?php echo $verE->local_emissao;?>" placeholder="Huambo"/></span>
                        </p>
                        
                        
                        <p>
                                <label>Genero:</label>
                                <span class="field"><select name="genero" id="selection1" class="input-medium" required="">
								<option><?php echo $verE->genero;?></option>
                                <option>Masculino</option>
                                <option>Femenino</option>
                                </select></span>
                            </p>
                            <p>
                                <label>Categoria:</label>
                                <span class="field"><select name="categoria_estudo" id="selection59" class="input-medium" required="">
                                <option><?php echo $verE->categoria_estudo;?></option>
                                        <option>PEPD 5ºE</option>
                                 <option>PEPD 6ºE</option>
                                 <option>PICESD 5ºE</option>
                                <option>PICESD 6ºE</option>
                                <option>PIICESD 6ºE</option>
                                <option>PIICESD 7ºE</option>
                                <option>PIICESD 8ºE</option>
                                 <option>PEPAUX 6ºE</option>
                                </select></span>
                            </p>
                            
                            <p>
                                <label>Título:</label>
                                <span class="field"><select name="estado" id="selection59" class="input-medium" required="">
								<option><?php echo $verE->titulo;?></option>
                                <option>Professor Normal</option>
                                <option>Professor Director</option>
                                </select></span>
                            </p>
                            		<p class="aas">
                                <label>Curso:</label>
                                <span class="field"><select name="curso" id="selection60" class="input-medium">
								<?php 
								if($verE->titulo=="Professor Director"):
								echo "<option value='".$vCurso->id_curso."'>".$verE2->curso."</option>";
								endif;
								?>
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
                           <p class="aas">
                                <label>Classe:</label>
                                <span class="field"><select name="classe" id="selection60" class="input-medium">
								
                                <?php 
								if($verE->titulo=="Professor Director"):
								echo "<option value='".$vClasse->id_classe."'>".$verE2->classe."</option>";
								endif;
								
								
								
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
                            
                            <p class="aas">
                                <label>Turma:</label>
                                <span class="field"><select name="turma" id="selection61" class="input-medium">
                                <?php 
								if($verE->titulo=="Professor Director"):
								echo "<option value='".$verE2->turma."'>".$verE2->turma."</option>";
								endif;
								
								
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
                            
                            <p class="aas">
                                <label>Turno:</label>
                                <span class="field"><select name="turno" id="selection62" class="input-medium">
                                <?php 
						if($verE->titulo=="Professor Director"):
						
						if($verE2->turno=="Manha"):
						$turnoE=1;
						elseif($verE2->turno=="Tarde"):
						$turnoE=2;
						else:
						$turnoE=3;
						endif;
						
								echo "<option value='".$turnoE."'>".$verE2->turno."</option>";
								endif;
								
								
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
                            
                    <p class="aas">
                     <label>Ano Lectivo:</label>
                            <span class="field"><input type="text" class="input-medium" value="<?php echo date('Y');?>" required name="ano1"/></span>
                    </p>
                        
                      <p>
			    <div class="par">
			    <label>Foto:</label>
			    <div class="fileupload fileupload-new" data-provides="fileupload"><input type="hidden" value="" name="">
				<div class="input-append">
				<div class="uneditable-input span3">
				    <i class="iconfa-file fileupload-exists"></i>
				    <span class="fileupload-preview"></span>
				</div>
				<span class="btn btn-file"><span class="fileupload-new">Select file</span>
				<span class="fileupload-exists">Change</span>
				<input type="file" name="foto"></span>
				<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
				</div>
			    </div>
			</div>
			</p>
                        
                        <p class="stdformbutton">
                                    <button class="btn btn-primary" name="bt1">Salvar Dados</button>
                            </p>
                </form>
            </div><!--widgetcontent-->
            </div><!--widget-->  
                
                
                
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

<script type="text/javascript" src="js/elimina.js"></script>
</body>
</html>

