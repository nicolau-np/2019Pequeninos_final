<?php 
include("config/conn.php");
include("validarlogin.php");
include_once 'classes/Comp_pais.php';
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
<title>Matricular</title>

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
				<li class="dropdown active" id="usuarioAdmin1"><a href=""><span class="iconfa-pencil"></span> Estudantes</a>
                	<ul style="display: block">
                    	<li class="active"><a href="forms.php">Matricular</a></li>
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
            <li>Matricular</li>
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
                <h1>Matricular</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
            
            <div class="widget">
            <h4 class="widgettitle">Formulário de Cadastro</h4>
            <div class="widgetcontent">
            <?php 
            //include("classes/salvar_aluno.php");
            include("classes/salvar_aluno.php");
            if(isset($_POST['bt1']))
            {
               $nome=$_POST['nome'];
               $curso=$_POST['curso'];
               $classe=$_POST['classe'];
               $turma=$_POST['turma'];
               $turno=$_POST['turno'];
               $arquivo=$_FILES['foto']['name'];
               $arquivo_tmp=$_FILES['foto']['tmp_name'];
               $genero=$_POST['genero'];
               $data=$_POST['nascimento'];
               $telefone=$_POST['telefone'];
               $emissao=$_POST['emissao'];
               $local_emissao=$_POST['local_emissao'];
               $bi=$_POST['bi'];
               $ano=$_POST['ano1'];
               $pai=$_POST['pai'];
               $mae=$_POST['mae'];
               $provincia=$_POST['provincia'];
               $municipio=$_POST['municipio'];
               $quota = $_POST['quota'];
               
               
               $obj= new salvar_aluno;
               $objComp = new Comp_pais();
               //$obj->cadastra($nome,$curso,$classe,$turma,$turno,$processo,$genero,$data,$telefone,$emissao,$local_emissao,$bi,$arquivo,$arquivo_tmp,$ano,$pai,$mae,$provincia,$municipio,$con);
                    $obj -> verificacaoDaPessoa($con,$bi);
                    //$obj -> pesquisarIDPessoaBI($con,$bi);
  $resSavedPeaple = $obj -> cadastrarAlunoPessoa($nome,$curso,$classe,$turma,$turno,$genero,$data,$telefone,$emissao,$local_emissao,$bi,$arquivo,$arquivo_tmp,$ano,$pai,$mae,$provincia,$municipio,$con);
        //================ Call function pesquisarIDPessoaBI to pick up Peaple ID
                        $obj -> pesquisarIDPessoaBI($con,$bi);                   
                    $obj -> selectIDAluno($con,$data,$resSavedPeaple,$bi);
                    $obj -> cadastrarAluno($con,$curso,$classe,$turma,$turno,$ano,$bi,$resSavedPeaple);
        ///=============     Call function selectIDAluno again to pick up user ID 
                     $resp66 = $obj -> selectIDAluno($con,$data,$resSavedPeaple,$bi);
                    //echo " ResA: ".$resSavedPeaple;
                    //$obj -> saveNotasANDDisciplinas($nome,$resSavedPeaple,$curso,$classe,$turma,$turno,$genero,$data,$telefone,$emissao,$local_emissao,$bi,$arquivo,$arquivo_tmp,$ano,$pai,$mae,$provincia,$municipio,$con);
                    //$resp66=$obj -> updateAluno($con,$resSavedPeaple,$ano);
                    $resp77=$obj->salvar_meses($resp66, $con,$ano);
                  $obj->edita_historico($resp77, $con, $curso, $classe, $turma, $turno, $ano);
                  
                  //das comparticipacoes
                  $objComp->setCon($con);
                  $objComp->setNome_pai($quota);
                  $objComp->setId_aluno($obj->getIdAluno());
                  
                  $res11 = $objComp->verifica();
                  if($res11 == "yes"):
                      $res12 = $objComp->insereFinanceiro();
                      if($res12=="yes"):
                         echo '<div class="alert alert-success">Cadastrou Financeiro</div>'; 
                      endif;
                      else:
                     $res13 = $objComp->inserePai();
                     if($res13=="yes"):
                         $res14 = $objComp->verifica();
                         if($res14=="yes"):
                             $res15 = $objComp->insereFinanceiro();
                             if($res15=="yes"):
                                echo '<div class="alert alert-success">Cadastrou Financeiro</div>';  
                             endif;
                         endif;
                     endif; 
                  endif;
                 echo '<meta http-equiv="refresh" content="1"/>';
                  
                  
                  
            }
			
            
            	if(isset($_POST['dxml'])){
		include 'classes/Importar_dados.php';
                $obj= new Importar_dados($con);
if(!empty($_FILES['doc']['tmp_name'])){
$arquivo= new DomDocument();
$arquivo->load($_FILES['doc']['tmp_name']);

$linhas=$arquivo->getElementsByTagName("Row");
$primeira_linha=true;

foreach($linhas as $linha){
if($primeira_linha==false){
$nome=$linha->getElementsByTagName("Data")->item(0)->nodeValue;
$curso=$linha->getElementsByTagName("Data")->item(1)->nodeValue;
$classe=$linha->getElementsByTagName("Data")->item(2)->nodeValue;
$turma=$linha->getElementsByTagName("Data")->item(3)->nodeValue;
$turno=$linha->getElementsByTagName("Data")->item(4)->nodeValue;
$ano=$linha->getElementsByTagName("Data")->item(5)->nodeValue;
$provincia=$linha->getElementsByTagName("Data")->item(6)->nodeValue;
$municipio=$linha->getElementsByTagName("Data")->item(7)->nodeValue;
$data_nas=$linha->getElementsByTagName("Data")->item(8)->nodeValue;
$genero=$linha->getElementsByTagName("Data")->item(9)->nodeValue;
$bi=$linha->getElementsByTagName("Data")->item(10)->nodeValue;
$data_emi=$linha->getElementsByTagName("Data")->item(11)->nodeValue;
$local_emi=$linha->getElementsByTagName("Data")->item(12)->nodeValue;
$pai=$linha->getElementsByTagName("Data")->item(13)->nodeValue;
$mae=$linha->getElementsByTagName("Data")->item(14)->nodeValue;
$telefone=$linha->getElementsByTagName("Data")->item(15)->nodeValue;
$processo=$linha->getElementsByTagName("Data")->item(16)->nodeValue;
$fot=$linha->getElementsByTagName("Data")->item(17)->nodeValue;
$cardeneta=$linha->getElementsByTagName("Data")->item(18)->nodeValue;
$titulo=$linha->getElementsByTagName("Data")->item(19)->nodeValue; 
				
//turno
if(($turno=="Manha")||($turno=="Manhã")):
$id_turno=1;
elseif($turno=="Tarde"):
$id_turno=2;
elseif($turno=="Noite"):
$id_turno=3;
endif;
//classe
if($classe=="Iniciação"):
$id_classe=1;
elseif($classe=="1ª"):
$id_classe=2;
elseif($classe=="2ª"):
$id_classe=3;
elseif($classe=="3ª"):
$id_classe=4;
elseif($classe=="4ª"):
$id_classe=5;
elseif($classe=="5ª"):
$id_classe=6;
elseif($classe=="6ª"):
$id_classe=7;
elseif($classe=="7ª"):
$id_classe=8;
elseif($classe=="8ª"):
$id_classe=9;
elseif($classe=="9ª"):
$id_classe=10;
endif;


$r1=$obj->salvar_pessoa($nome,$genero,$data_nas,$bi,$data_emi,$fot,$telefone,$titulo,$pai,$mae,$provincia,$municipio,$processo,$local_emi);
$r2=$obj->busca_IDPESSOA($r1);
$r3=$obj->salvar_aluno($r2, $id_classe, $turma, $id_turno, $curso, $cardeneta, $ano);
$obj->chama_confirmacao($r3);
}
$primeira_linha=false;
}
}
}
                                
if(isset($_POST['dxml2'])){
include 'classes/Importar_historico.php';
$obj= new Importar_historico($con);

if(!empty($_FILES['doc']['tmp_name'])){
$arquivo= new DomDocument();
$arquivo->load($_FILES['doc']['tmp_name']);

$linhas=$arquivo->getElementsByTagName("Row");
$primeira_linha=true;

foreach($linhas as $linha){
if($primeira_linha==false){
$curso=$linha->getElementsByTagName("Data")->item(0)->nodeValue;
$classe=$linha->getElementsByTagName("Data")->item(1)->nodeValue;
$turma=$linha->getElementsByTagName("Data")->item(2)->nodeValue;
$turno=$linha->getElementsByTagName("Data")->item(3)->nodeValue;
$ano=$linha->getElementsByTagName("Data")->item(4)->nodeValue;
$processo=$linha->getElementsByTagName("Data")->item(5)->nodeValue;

//turno
if(($turno=="Manha")||($turno=="Manhã")):
$id_turno=1;
elseif($turno=="Tarde"):
$id_turno=2;
elseif($turno=="Noite"):
$id_turno=3;
endif;
//classe
if($classe=="Iniciação"):
$id_classe=1;
elseif($classe=="1ª"):
$id_classe=2;
elseif($classe=="2ª"):
$id_classe=3;
elseif($classe=="3ª"):
$id_classe=4;
elseif($classe=="4ª"):
$id_classe=5;
elseif($classe=="5ª"):
$id_classe=6;
elseif($classe=="6ª"):
$id_classe=7;
elseif($classe=="7ª"):
$id_classe=8;
elseif($classe=="8ª"):
$id_classe=9;
elseif($classe=="9ª"):
$id_classe=10;
endif;


$r1=$obj->buscaIDs($processo);
$r0=$obj->sele($r1, $curso, $id_classe, $turma, $id_turno, $ano);
$obj->salva_Historico($r0, $curso, $id_classe, $turma, $id_turno, $ano);



}
$primeira_linha=false;
}

}
			
}

if(isset($_POST['dxml3'])){
include 'classes/Importar_pagamento.php';
$obj= new Importar_pagamento($con);

if(!empty($_FILES['doc']['tmp_name'])){
$arquivo= new DomDocument();
$arquivo->load($_FILES['doc']['tmp_name']);

$linhas=$arquivo->getElementsByTagName("Row");
$primeira_linha=true;

foreach($linhas as $linha){
if($primeira_linha==false){
$mes=$linha->getElementsByTagName("Data")->item(0)->nodeValue;
$data_pagamento=$linha->getElementsByTagName("Data")->item(1)->nodeValue;
$ano_lectivo=$linha->getElementsByTagName("Data")->item(2)->nodeValue;
$cliente=$linha->getElementsByTagName("Data")->item(3)->nodeValue;
$valor=$linha->getElementsByTagName("Data")->item(4)->nodeValue;
$valor_total=$linha->getElementsByTagName("Data")->item(5)->nodeValue;
$usuario=$linha->getElementsByTagName("Data")->item(6)->nodeValue;
$pago=$linha->getElementsByTagName("Data")->item(7)->nodeValue;
$nfatura=$linha->getElementsByTagName("Data")->item(8)->nodeValue;
$hora=$linha->getElementsByTagName("Data")->item(9)->nodeValue;
$processo=$linha->getElementsByTagName("Data")->item(10)->nodeValue;



$r1=$obj->buscaIDs($processo);
$r0=$obj->sele($r1, $mes, $data_pagamento, $ano_lectivo, $cliente, $valor, $valor_total, $usuario, $pago, $nfatura, $hora);
$obj->salva_Pagamento($r0, $mes, $data_pagamento, $ano_lectivo, $cliente, $valor,$valor_total,$usuario,$pago,$nfatura,$hora);

}
$primeira_linha=false;
}

}
			
}
if(isset($_POST['dxml4'])){
include 'classes/Importar_Fatura.php';
$obj= new Importar_Fatura($con);

if(!empty($_FILES['doc']['tmp_name'])){
$arquivo= new DomDocument();
$arquivo->load($_FILES['doc']['tmp_name']);

$linhas=$arquivo->getElementsByTagName("Row");
$primeira_linha=true;

foreach($linhas as $linha){
if($primeira_linha==false){
$numero=$linha->getElementsByTagName("Data")->item(0)->nodeValue;
$ano=$linha->getElementsByTagName("Data")->item(1)->nodeValue;

$obj->salvar_fatura($numero,$ano);


}
$primeira_linha=false;
}

}
			
}

if(isset($_POST['dxml5'])){
include 'classes/Importar_Inscricao.php';
$obj= new Importar_Inscricao($con);

if(!empty($_FILES['doc']['tmp_name'])){
$arquivo= new DomDocument();
$arquivo->load($_FILES['doc']['tmp_name']);

$linhas=$arquivo->getElementsByTagName("Row");
$primeira_linha=true;

foreach($linhas as $linha){
if($primeira_linha==false){
    
$processo=$linha->getElementsByTagName("Data")->item(0)->nodeValue;
$valor=$linha->getElementsByTagName("Data")->item(1)->nodeValue;
$data=$linha->getElementsByTagName("Data")->item(2)->nodeValue;
$ano=$linha->getElementsByTagName("Data")->item(3)->nodeValue;

$r1=$obj->buscIDs($processo);
$r0=$obj->sele($r1, $valor, $ano, $data);
$obj->salvar_inscricao($r0, $valor, $ano, $data);


}
$primeira_linha=false;
}

}
			
}


				?>
            
            
                <form class="stdform" action="forms.php" method="post" enctype="multipart/form-data">
                    	
                        <p>
                            <label>Nome Completo:</label>
                            <span class="field"><input type="text" name="nome" class="input-xlarge" placeholder="João Manuel" required=""/></span>
                        </p>
                        
                        
                        
                        <p>
                            <label>Data de Nascimento:</label>
                            <span class="field"><input type="date" name="nascimento" class="input-medium"  required=""/></span>
                        </p>
                        
                        <p>
                        <label for="">Província:</label>
                    <select size="1" name="provincia" id="provincia" onChange="escolha()" class='input-medium'>
                        <option>Selecione...</option>
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
	<option>Selecione...</option>
</select>
                        
                        <p>
                                <label>Genero:</label>
                                <span class="field"><select name="genero" id="selection1" class="input-medium" required="">
                                 <option value="">Selecione...</option>
                                <option>Masculino</option>
                                <option>Femenino</option>
                                </select></span>
                            </p>
                            
                            <p>
                            <label>Nome Pai:</label>
                            <span class="field"><input type="text" name="pai" class="input-medium"  placeholder="Jose" required=""/></span>
                        </p> 
                        
                           <p>
                            <label>Nome Mãe:</label>
                            <span class="field"><input type="text" name="mae" class="input-medium"  placeholder="Joaquina"/></span>
                        </p>
                            <p>
                            <label>Nº Telefone:</label>
                            <span class="field"><input type="number" name="telefone" class="input-medium" pattern="[0-9]{9}" placeholder="946216795"/></span>
                        </p>
                        <p>
                            <label>Nº B.I./Cédula:</label>
                            <span class="field"><input type="text" name="bi" class="input-medium" placeholder="34678722NE046" required=""/></span>
                        </p>
                        <p>
                            <label>Data de Emissão:</label>
                            <span class="field"><input type="date" name="emissao" class="input-medium"/></span>
                        </p>
                        <p>
                            <label>Local de Emissão:</label>
                            <span class="field"><input type="text" name="local_emissao" class="input-medium"  placeholder="Huambo"/></span>
                        </p>
                        <p>
						<label>Curso:</label>
                                                <span class="field"><select name="curso" id="selection1" class="input-medium" required="">
<?php 
$t="select *from tbl_curso";
$a=$con->prepare($t);
$a->execute();
while($ver=$a->fetch(PDO::FETCH_OBJ))
{
?>
<option value="<?php echo $ver->id_curso;?>"><?php echo $ver->curso;?></option>
<?php }?>
</select></span>
						</p>
						
                        <p>
                                <label>Classe:</label>
                                <span class="field"><select name="classe" id="selection1" class="input-medium" required="">
                                <option value="">Selecione...</option>
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
                                <label>Turma:</label>
                                <span class="field"><select name="turma" id="selection2" class="input-medium" required="">
                                <option value="">Selecione...</option>
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
                                <span class="field"><select name="turno" id="selection3" class="input-medium" required="">
                                <option value="">Selecione...</option>
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
			</div></p>
                         <p>
                            <label>Financeiro da Quota dos Pais:</label>
                            <span class="field"><input type="text" class="input-medium" value="" required="" name="quota"/></span>
                        </p>
                        <p>
                            <label>Ano Lectivo:</label>
                            <span class="field"><input type="text" class="input-medium" value="<?php echo date('Y');?>" required="" name="ano1"/></span>
                        </p>
                        
                        
                        <p class="stdformbutton">
                                    <button type="submit" class="btn btn-primary" name="bt1">Salvar Dados</button>
                            </p>
                </form>
				
			
				
				
				<form name="form345" method="POST" enctype="multipart/form-data" action="forms.php">
				<div class="form-inline">
				<div class="fileupload fileupload-new" data-provides="fileupload"><input type="hidden" value="" name="">
				<div class="input-append">
				<div class="uneditable-input span3">
				    <i class="iconfa-file fileupload-exists"></i>
				    <span class="fileupload-preview"></span>
				</div>
				<span class="btn btn-file"><span class="fileupload-new">Ficheiro XML Alunos</span>
				<span class="fileupload-exists">Change</span>
				<input type="file" name="doc" class="input-medium"></span>
				<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remover</a>
				</div>
			
			    </div>
					<input type="submit" class="btn btn-warning" name="dxml" value="Importar Dados Alunos"/>
                                        <input type="submit" class="btn btn-info" name="dxml2" value="Importar Dados Historico"/>
                                        <input type="submit" class="btn btn-success" name="dxml3" value="Importar Dados Propina"/>
					<input type="submit" class="btn btn-default" name="dxml4" value="Importar Dados Faturas"/>
                                        <input type="submit" class="btn btn-primary" name="dxml5" value="Importar Dados Inscrição"/>
			
                                </div>
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

</body>
</html>
