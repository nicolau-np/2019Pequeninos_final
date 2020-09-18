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
<title>Listas Nominais</title>

<link rel="stylesheet" href="css/style.default.css" type="text/css" />
<link rel="stylesheet" href="css/bootstrap-fileupload.min.css" type="text/css" />
<link rel="stylesheet" href="css/bootstrap-timepicker.min.css" type="text/css" />

<script type="text/javascript" src="js/jquery-1.5.2.js"></script>
<script type="text/javascript" src="js/permicao.js"></script>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/jquery-migrate-1.1.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.9.2.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/tinymce/jquery.tinymce.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="js/modernizr.min.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
<script type="text/javascript" src="js/wysiwyg.js"></script>

<style>
    .amarelo{
        background-color:#FCB904;
        color:#fff;
    }
    .vermelho{
        background-color: #8a1f11;
        color:#fff;
    }
    .normal{
        background-color:#00FFFFFF;
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
				<li class="dropdown active" id="usuarioAdmin1"><a href=""><span class="iconfa-pencil"></span> Estudantes</a>
                	<ul style="display: block;">
                    	<li><a href="forms.php">Matricular</a></li>
                        <li><a href="wizards.php">Visualizar</a></li>
                        <li class="active"><a href="wysiwyg.php">Listas Nominais</a></li>
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
            <li><a href="forms.php">Estudantes</a> <span class="separator"></span></li>
            <li>Listas Nominais</li>
            
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
                <h5>Estudantes</h5>
                <h1>Listas Nominais</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
            
           
           <form class="form-inline" action="wysiwyg.php" method="GET">
            <label>Curso:</label>
                                <span class="field"><select name="curso" id="selection1" class="input-small">
                                
                                <?php 
                                if(isset($_GET['pesq'])):
                                echo "<option>{$_GET['curso']}</option>";
                                endif;
                                $sel13="select *from tbl_curso";
                                $ex13=$con->prepare($sel13);
                                $ex13->execute();
                                while($ver13=$ex13->fetch(PDO::FETCH_OBJ))
                                {
                                    
                               
                                ?>
                                          <option><?php echo $ver13->curso;?></option>
             <?php  }?>
                                </select></span>
			
			
                                <label>Classe:</label>
                                <span class="field"><select name="classe" id="selection1" class="input-small">
                                
                                <?php 
                                if(isset($_GET['pesq'])):
                                echo "<option>{$_GET['classe']}</option>";
                                endif;
                                $sel1="select *from tbl_classe";
                                $ex1=$con->prepare($sel1);
                                $ex1->execute();
                                while($ver1=$ex1->fetch(PDO::FETCH_OBJ))
                                {
                                    
                               
                                ?>
                                          <option><?php echo $ver1->classe;?></option>
             <?php  }?>
                                </select></span>
                          
                                <label>Turma:</label>
                                <span class="field"><select name="turma" id="selection2" class="input-small">
                                <?php 
                                 if(isset($_GET['pesq'])):
                                echo "<option>{$_GET['turma']}</option>";
                                endif;
                                $sel2="select *from tbl_turma";
                                $ex2=$con->prepare($sel2);
                                $ex2->execute();
                                while($ver2=$ex2->fetch(PDO::FETCH_OBJ))
                                {
                                    
                               
                                ?>
                                    <option><?php echo $ver2->turma; ?></option>
                   <?php  }?>
                                </select></span>
                           
                                <label>Turno:</label>
                                <span class="field"><select name="turno" id="selection3" class="input-small">
                                <?php 
                                 if(isset($_GET['pesq'])):
                                echo "<option>{$_GET['turno']}</option>";
                                endif;
                                $sel3="select *from tbl_turno";
                                $ex3=$con->prepare($sel3);
                                $ex3->execute();
                                while($ver3=$ex3->fetch(PDO::FETCH_OBJ))
                                {
                                    
                               
                                ?>
                                    <option><?php echo $ver3->turno;?></option>
                             <?php  }?>
                                </select></span>
                       
                            <label>Ano Lectivo:</label>
                            <span class="field"><input type="text" name="ano" class="input-small" value="<?php if(isset($_GET['pesq'])):echo $_GET['ano'];else: echo date('Y');endif;?>" required/></span>
                       
                        <button type="submit" name="pesq" class="btn btn-primary">Pesquizar</button>
                         <button type="submit" name="passe" class="btn btn-success">Passes</button>
                         <label>Boletim de Nota:</label>
                         <span class="field"><select class="input-small" name="epoca">
                         <option>Trimestre</option>
                         <option>1</option>
                         <option>2</option>
                         <option>3</option>
                         </select></span>
                         <button type="submit" name="nota" class="btn btn-warning">Imprimir</button>
                         <button type="submit" name="horario" class="btn btn-info">Horario</button>
                         <?php 
                         if($_SESSION['tituloMRX']=="Usuário Normal"):
                             echo'<a href="estudante_academic.php" class="btn btn-primary">Acaddemic</a>';
                         endif;
                         ?>
                         <?php 
                         if(isset($_GET['nota']))
                         {
                            $anoNO=$_GET['ano'];
                            $epocaNO=$_GET['epoca'];
                        $cursoNO=$_GET['curso'];
                        $classeNO=$_GET['classe'];
                        $turmaNO=$_GET['turma'];
                        $turnoNO=$_GET['turno'];
                       			if(($classeNO=="1ª")||($classeNO=="3ª")||($classeNO=="5ª")||($classeNO=="Iniciação")):
						header("location:boletins_notas/ini_5.php?curso=$cursoNO&&classe=$classeNO&&turma=$turmaNO&&turno=$turnoNO&&ano=$anoNO&&epoca=$epocaNO");
						 else:
                                                   header("location:boletins_notas/2_9.php?curso=$cursoNO&&classe=$classeNO&&turma=$turmaNO&&turno=$turnoNO&&ano=$anoNO&&epoca=$epocaNO");
						endif;
                            
                         }
                         if(addslashes(htmlspecialchars(isset($_GET['horario'])))):
                                    $anoNO=$_GET['ano'];
                        $cursoNO=$_GET['curso'];
                        $classeNO=$_GET['classe'];
                        $turmaNO=$_GET['turma'];
                        $turnoNO=$_GET['turno'];
                       			
                       header("location:horario/horario_In_9.php?curso=$cursoNO&&classe=$classeNO&&turma=$turmaNO&&turno=$turnoNO&&ano=$anoNO");
						
                         endif;
                         ?>
                 </form>
                 <br />
                <div class="table-wrapper"><div class="scrollable"><table class="table table-bordered responsive">
                    <colgroup>
                        <col class="con0">
                        <col class="con1">
                        <col class="con0">
                        <col class="con1">
                        
                    </colgroup>
                    <thead>
                        <tr>
                            <th>Nº</th>
                            <th>Nº Proc.</th>
                            <th>Nome Completo</th>
                            <th>Gênero</th>
                    <th>Idade</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    if(isset($_GET['pesq']))
                    {
                        $curso=$_GET['curso'];
                        $classe=$_GET['classe'];
                        $turma=$_GET['turma'];
                        $turno=$_GET['turno'];
                        $ano=$_GET['ano'];
                        
                        
                        
        $select="select *from view_historico where curso=:curso and classe=:classe and turma=:turma and turno=:turno and anolectivo=:ano order by nome ASC";
        $xe=$con->prepare($select);
        $xe->bindParam(":curso",$curso,PDO::PARAM_STR);
        $xe->bindParam(":classe",$classe,PDO::PARAM_STR);
        $xe->bindParam(":turma",$turma,PDO::PARAM_STR);
        $xe->bindParam(":turno",$turno,PDO::PARAM_STR);
        $xe->bindParam(":ano",$ano,PDO::PARAM_STR);
        $xe->execute(); 
        $conta=$xe->rowCount();
        if($conta>0):
        $a=0;
        while($ver=$xe->fetch(PDO::FETCH_OBJ))
        {
$strings=$ver->data_nascimento;
$string=explode("-",$strings);
$idade=date("Y") - $string[0];
          $a++;
          if($ver->aproveitamento=="Transferencia"):
            $cor = "amarelo";
          elseif($ver->aproveitamento=="Desistencia"):
              $cor="vermelho";
          else:
             $cor=""; 
          endif;
            echo"<tr class='".$cor."'>
                            <td>$a</td>
                            <td>{$ver->id_aluno}</td>
                            <td>{$ver->nome}</td>
                            <td>{$ver->genero}</td>
                            <td>{$idade}</td>
                           
                        </tr>";
        }
        echo '<a href="export_nominal.php?curso='.$curso.'&&classe='.$classe.'&&turma='.$turma.'&&turno='.$turno.'&&ano='.$ano.'">Baixar Lista</a>';
        else:
        echo"Nenhum aluno encontrado";
        endif; 
                    }
                    if(isset($_GET['passe']))
                    {
                       $curso=$_GET['curso'];;
                        $classe=$_GET['classe'];
                        $turma=$_GET['turma'];
                        $turno=$_GET['turno'];
                        $ano=$_GET['ano'];
                        header("location:passes.php?curso=$curso&&classe=$classe&&turma=$turma&&turno=$turno&&ano=$ano");   
                    }
                    ?>
                    
                    
                    
                       
                        
                    </tbody>
                </table></div></div>
                
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
