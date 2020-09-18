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
<title>Sistema</title>
<link rel="stylesheet" href="css/style.default.css" type="text/css" />

<script type="text/javascript" src="js/jquery-1.5.2.js"></script>
<script type="text/javascript" src="js/permicao.js"></script>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/jquery-migrate-1.1.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.9.2.min.js"></script>
<script type="text/javascript" src="js/modernizr.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/fullcalendar.min.js"></script>
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
                	<li class="active"><a href="calendar.php">Sistema</a></li>
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
            <li><a href="calendar.php">Configurações</a> <span class="separator"></span></li>
            <li>Sistema</li>
            
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
            <div class="pageicon"><span class="iconfa-th-list"></span></div>
            <div class="pagetitle">
                <h5>Configurações</h5>
                <h1>Sistema</h1>
            </div>            
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
                <div class="row">
                    <div class="span10">
                        
                        <form class="" method="post" action="calendar.php">
                            <?php
                            if(isset($_POST['by']))
{
$nome=$_POST['nome'];
$sql="select *from tbl_dis2 where nome=:nome";
$run=$con->prepare($sql);
$run->bindParam(":nome",$nome,PDO::PARAM_STR);
$run->execute();
$cont=$run->rowCount();

if($cont>0):
     echo"<div class='alert alert-danger'>Já cadastrou esta Disciplina</div>"; 
    
   elseif($cont==0):
  $c="insert into tbl_dis2(nome) values(:nome)";
$r=$con->prepare($c);
$r->bindParam(":nome",$nome,PDO::PARAM_STR);
$r->execute();
if($r)
{
	echo"<div class='alert alert-success'>Cadastro Feito com sucesso</div>";
} 
endif;

}
?>
                            <div class="form-inline">
                                <fieldset>
                                    <legend style="font-size:12px;">Cadastro de Disciplinas da Instituição</legend>
                               
                                    <input name="nome" type="text" required="" placeholder="Nome da Disciplina"/>
                            <input type="submit" name="by" value="salvar" class="btn btn-primary"/> 
                                </fieldset>
                            </div>
</form>
                        <hr/>
						
						                        <form class="" method="post" action="calendar.php">
                            <?php
                            if(isset($_POST['by3']))
{
$nome=$_POST['nome_curso'];
$valor1=$_POST['valor_propina'];
$valor3=$_POST['valor_multa'];
$tipo_ensino = addslashes(htmlspecialchars($_POST['tipo_ensino']));

$valor2=($valor1*$valor3)/100;

$sql="select *from tbl_curso where curso=:nome";
$run=$con->prepare($sql);
$run->bindParam(":nome",$nome,PDO::PARAM_STR);
$run->execute();
$cont=$run->rowCount();

if($cont>0):
     echo"<div class='alert alert-danger'>Já cadastrou este Curso</div>"; 
    
   elseif($cont==0):
  $c="insert into tbl_curso(curso,valor_pagamento,valor_multa, percentagem_multa,tipo_ensino) values(:nome,:valor1,:valor2,:valor3,:tipo_ensino)";
$r=$con->prepare($c);
$r->bindParam(":nome",$nome,PDO::PARAM_STR);
$r->bindParam(":valor1",$valor1,PDO::PARAM_STR);
$r->bindParam(":valor2",$valor2,PDO::PARAM_STR);
$r->bindParam(":valor3",$valor3,PDO::PARAM_STR);
$r->bindParam(":tipo_ensino", $tipo_ensino, PDO::PARAM_STR);
$r->execute();
if($r)
{
	echo"<div class='alert alert-success'>Cadastro Feito com sucesso</div>";
} 
endif;

}
?>
                            <div class="form-inline">
                                <fieldset>
                                    <legend style="font-size:12px;">Cadastro de Cursos</legend>
                                    <select name="tipo_ensino">
                                        <option value="0">Tipo de Ensino</option>
                                        <option>Ensino Fundamental</option>
                                        <option>Ensino Secundário</option>
                                        <option>Ensino Técnico Profissional</option>
                                    </select>
                                    <input name="nome_curso" type="text" required="" placeholder="Nome do Curso"/>
                                    <input name="valor_propina" type="number" required="" placeholder="Valor da propina" class="input-medium" required=""/>
                                    <input name="valor_multa" type="number" required="" placeholder="Percentagem da Multa" class="input-medium" required=""/>
                                    
                                    <input type="submit" name="by3" value="salvar" class="btn btn-warning"/> 
                                </fieldset>
                            </div>
</form>
<hr/>					
						
<?php 
if(isset($_POST['by6']))
{
$disciplina=$_POST['disciplina'];
$classe=$_POST['classe'];
$curso=$_POST['curso'];

$rt="select *from tbl_disciplinas where id_di2=:dis and id_classe=:cla and id_curso=:id_curso";
$cv=$con->prepare($rt);
$cv->bindParam(":dis",$disciplina,PDO::PARAM_STR);
$cv->bindParam(":cla",$classe,PDO::PARAM_STR);
$cv->bindParam(":id_curso",$curso,PDO::PARAM_STR);
$cv->execute();	
$contar=$cv->rowCount();
if($contar>0)
{
	echo "<div class='alert alert-danger'>Já foi cadastrada esta disciplina neste Curso e nesta Classe</div>";
}
else
{
$in="insert into tbl_disciplinas (id_curso,id_di2,id_classe) values(:id_curso,:id_di2,:id_classe)";
$tin=$con->prepare($in);
$tin->bindParam(":id_curso",$curso,PDO::PARAM_STR);
$tin->bindParam(":id_di2",$disciplina,PDO::PARAM_STR);
$tin->bindParam(":id_classe",$classe,PDO::PARAM_STR);
$tin->execute();
if($tin)
{
echo"<div class='alert alert-success'>Cadastro feito com sucesso</div>";	
}
else
{
	echo "<div class='alert alert-danger'>erro</div>";
}
}

}
?>
                        <form action="calendar.php" method="post">
                             <fieldset>
                                    <legend style="font-size:12px;">Cadastro as Disciplinas nas Classes</legend>
                                    <div class="form-inline">
									
<select name="curso">
<?php 
$t="select *from tbl_curso";
$a=$con->prepare($t);
$a->execute();
while($ver=$a->fetch(PDO::FETCH_OBJ))
{
?>
<option value="<?php echo $ver->id_curso;?>"><?php echo $ver->curso;?></option>
<?php }?>
</select>

<select name="disciplina">
<?php 

$t="select *from tbl_dis2";
$a=$con->prepare($t);
$a->execute();
while($ver=$a->fetch(PDO::FETCH_OBJ))
{
?>
<option value="<?php echo $ver->id_di2;?>"><?php echo $ver->nome;?></option>
<?php }?>
</select>

<select name="classe">
<?php 

$t2="select *from tbl_classe";
$a2=$con->prepare($t2);
$a2->execute();
while($ver2=$a2->fetch(PDO::FETCH_OBJ))
{
?>
<option value="<?php echo $ver2->id_classe;?>"><?php echo $ver2->classe;?></option>
<?php }?>
</select> <input type="submit" name="by6" value="salvar" class="btn btn-success"/>
</div>


   </fieldset>
</form>
         <hr/>
         <?php
         $estado1="ON";
         $estado2="OFF";
         $tipo="caderneta";
         
                 
         if(isset($_POST['by7'])):
             $epoca=$_POST['epoca'];
             $sql24="update tbl_trancar set estado=:estado where epocas=:epoca and tipo=:tipo";
             $run24=$con->prepare($sql24);
             $run24->bindParam(":estado",$estado2,PDO::PARAM_STR);
             $run24->bindParam(":epoca",$epoca,PDO::PARAM_STR);
              $run24->bindParam(":tipo",$tipo,PDO::PARAM_STR);
              $run24->execute();
              if($run24):
                  echo"<div class='alert alert-success'>Bloqueio feito com sucesso!</div>";
              endif;
         endif;
         
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
         <form action="calendar.php" method="POST">
             <fieldset>
                 <legend style="font-size:12px;">Bloqueio de Lançamento de Notas</legend>
                 <select name="epoca" style="width: 150px;">
<option value="1">1º Trimestre</option>
<option value="2">2º Trimestre</option>
<option value="3">3º Trimestre</option>
<option value="4">Prova Global</option>
<option value="5">Eliminar Provas</option>
</select> <input type="submit" name="by7" value="Bloquear" class="btn btn-danger"/>
<input type="submit" name="by8" value="Desbloquear" class="btn btn-primary"/>
             </fieldset>
</form>
         <table class="table table-bordered">
             <tr>
                 <th>1º Trimestre</th>
                 <th>2º Trimestre</th>
                 <th>3º Trimestre</th>
                 <th>Prova Global</th>
                 <th>Eliminar Provas</th>
             </tr>
             
                 <tr>
                 <?php
                 
                 $sql23="select *from tbl_trancar where tipo=:tipo order by id_trancar asc";
                 $run23=$con->prepare($sql23);
                 $run23->bindParam(":tipo",$tipo,PDO::PARAM_STR);
                 $run23->execute();
                  
                 while ($view23=$run23->fetch(PDO::FETCH_OBJ)){
          ?>

                
                 <td><?php echo $view23->estado;?></td>
                 
                 <?php      
                 }?>
                 </tr> 
                 
               
            
         </table>
                
         <a href="condReprovacao.php"><span style="font-size:14px; font-weight:bold;">+ config.</span> </a>
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
