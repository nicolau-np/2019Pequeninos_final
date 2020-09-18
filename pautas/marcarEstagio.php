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
<title>Editar Dados</title>

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
            <li>Editar Dados</li>
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
                <h1>Editar Dados</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
            
            <div class="widget">
            <h4 class="widgettitle">Formulário de Cadastro</h4>
            <div class="widgetcontent">
    <?php 
            include("classes/saveEstagiario.php");
             include("../propina Colegio/numberFactu.php");
            
            $fact = new Factura();
            $fact-> setConnection($con); 
                $fact-> selectFactura();
                $fact-> selectFactura1();


               $id_pessoaAluno=0;   $id_alunoAluno=0; $fotoAluno=0;
        try{       
			if((isset($_GET['id_pessoa'])&&(isset($_GET['id_aluno']))&&(isset($_GET['foto'])))):
                
    			$_SESSION['id_pessoaAluno']=$_GET['id_pessoa'];
    			$_SESSION['id_alunoAluno']=$_GET['id_aluno'];
    			$_SESSION['id_fotoAluno']=$_GET['foto'];
    			$id_pessoaAluno=$_GET['id_pessoa'];
    			$id_alunoAluno=$_GET['id_aluno'];
    			$fotoAluno=$_GET['foto'];
			else:
    			$id_pessoaAluno=$_SESSION['id_pessoaAluno'];
    			$id_alunoAluno=$_SESSION['id_alunoAluno'];
    			$fotoAluno=$_SESSION['id_fotoAluno'];
			endif;
			
			$fosy="select *from view_estudante where id_pessoa=:id_pessoa";
			$efosy=$con->prepare($fosy);
			$efosy->bindParam(":id_pessoa",$id_pessoaAluno,PDO::PARAM_STR);
			$efosy->execute();
			$ver_AlunoE=$efosy->fetch(PDO::FETCH_OBJ);
			
			
			
            if(isset($_POST['bt1']))
            {      
               $obj= new SaveEstagiario();

               $obj-> setConnection($con);
               $obj-> setNumeroFatura($fact-> numberF);
               $obj-> idPessoa= $id_pessoaAluno;
               $obj-> idAluno= $id_alunoAluno;
               $obj-> worker = $_SESSION['tituloMRX'];
               $obj-> nome = addslashes(htmlspecialchars($_POST['nome']));
               $obj-> curso = addslashes(htmlspecialchars($_POST['curso']));
               $obj-> classe = addslashes(htmlspecialchars($_POST['classe']));
               $obj-> turma = addslashes(htmlspecialchars($_POST['turma']));
               $obj-> turno = addslashes(htmlspecialchars($_POST['turno'])); 
               $obj-> bi = addslashes(htmlspecialchars($_POST['bi']));
               $obj-> anoLectivo = addslashes(htmlspecialchars($_POST['ano1']));             
               $obj-> supervisor = addslashes(htmlspecialchars($_POST['supervisor']));
               $obj-> faltas = addslashes(htmlspecialchars($_POST['faltas']));
               $obj-> telefone = addslashes(htmlspecialchars($_POST['telefone']));
               $obj-> tele_supervisor = addslashes(htmlspecialchars($_POST['tele_supervisor']));               
               $obj-> localEstagio = addslashes(htmlspecialchars($_POST['local_estagio']));
               $obj-> dataInicio = addslashes(htmlspecialchars($_POST['dataInicio']));
               $obj-> dataFim = addslashes(htmlspecialchars($_POST['fim_estagio']));
               $obj-> provincia = addslashes(htmlspecialchars($_POST['provincia']));
               $obj-> municipio = addslashes(htmlspecialchars($_POST['municipio']));

               if(!empty($id_pessoaAluno) && !empty($id_alunoAluno)){
                 
                   $obj-> verifyEstagio();
                   $obj-> savingEstagio();
                   $obj-> editarEstagio();
                   $obj-> deletaEstagio();                   
                   $obj-> answers();
                   echo("Save: ".$obj-> save);
                   if($obj-> save ==1){ 

                     include ('mpdf/mpdf.php');
    
    $servidor = "localhost";
    $usuario = "root";
    $senha = "";
    $dbname = "bdpautas_esperanca";
    
    //Criar a conexão
    $conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
    if(!$conn){
        die("Falha na conexao: " . mysqli_connect_error());
    }else{
        //echo "Conexao realizada com sucesso";
    }
    
    $id = "1";
    $result_usuario = "SELECT * FROM tbl_pagamento LIMIT 1000";
    $resultado_usuario = mysqli_query($conn, $result_usuario);  
    $row_usuario = mysqli_fetch_assoc($resultado_usuario);  
    /*Id: ".$row_usuario['id_pagamento']."<br>
                Nome: ".$row_usuario['nome']."<br>
                E-mail: ".$row_usuario['email']."<br>
                Senha: ".$row_usuario['senha']."<br>*/

    $pagina ="<html>
<head><title></title>
<style>
.cabe
{
   font-family:arial; 
   font-size:12px;
   text-align:center;
    }
    .el{
 margin-left:460px;
 margin-top:-80px; 
     font-family:arial;
     border:1px solid #000;
     padding-left:3px;
     padding-top:2px; 
     padding-bottom:2px;
        }
        
        .nm{ 
     font-family:arial;
     border: 1px solid #000;
     background-color:#f5f5f5;
     
        }
        #pi
        {
            padding-top:5px;
            padding-bottom:5px;
         border-bottom: 1px solid #000;
         text-align:center;   
            }
            #sec
            {
         border-right: 1px solid #000;
                }
    .b
    {
        text-align:center;
       
        }
        .desig
        {
            font-weight:bold;
   text-align:center; 
            }
              .design
        {
   text-align:center; 
            }

       #iop
       {
        font-family:arial;
        font-size:12px;
        width:100%;
        border:1px solid #000;
        }
        .table1
        {
           border: 1px solid #000;
           font-family:arial;
           font-size:12px; 
            }
            .cvb
            {
               border-bottom:1px solid #000;
               background-color:#f5f5f5; 
                }
                 .bn
            {
               border-top:1px solid #000;
               background-color:#f5f5f5; 
                }
                .vfg
                {
                  border-bottom:1px solid #000;
                   background-color:#f5f5f5;
                    }
                    .vfk
                {
                  border-right:1px solid #000;
                    }
                    #fafa
                    {
                        border:1px solid #000;
                        font-family:arial;
                        background-color:#f5f5f5;
                        
                        }
                    .fafa1
                    {
                        border-right:1px solid #000;
                        }   
                        .desig
                        {
                           font-family:arial;
                            
                            }
                            .bnmm
                            {
                                border: 1px solid #000;
                                font-family:arial;
                                font-size:12px;
                                }

           
</style>

</head>
<body>
<br/>
<div class='cabe'>
<img src='assets/img/as.jpg' width='50px' height='50px'/><br/>
<strong>REPÚBLICA DE ANGOLA</strong><br/>
<strong>MINISTÉRIO DA EDUCAÇÃO CIÊNCIA E TECNOLOGIA</strong><br/>
<strong>ESCOLA PRIMÁRIA E Iº CÍCLO LAR DOS PEQUENINOS <BR/>DAS IRMÃS DO SANTÍSSIMO SALVADOR-HUAMBO</strong><br/>
</div><br/><br/>
<div class='desig'>LISTA DE PAGAMENTO</div><br/>
<div class='dados_a'>
<table border='0' id='iop'>
<tr>
<td  class='vfg'>Curso</td>
<td  class='vfg'>Classe</td>
<td  class='vfg'>Turma</td>
<td  class='vfg'>Turno</td>

<td  class='vfg'>Ano Lectivo</td>
</tr>
<tr>
<td class='vfk'>{$curso}</td>
<td class='vfk'>{$classe}</td>
<td class='vfk'>{$turma}</td>
<td class='vfk'>{$turno}</td>
<td>$ano</td>

</tr>
</table>
</div>


<br/>
<div class='tb'>";          
    
    $pagina = 
        "<html>
            <body>
                <h1>Informações do Usuário</h1>
                
                <h4>http://www.celke.com.br</h4>
            </body>
        </html>
        ";

//$arquivo = "Cadastro01.pdf";

$mpdf = new mPDF();
$mpdf->WriteHTML($pagina);

$mpdf->Output('I.pdf');

exit();

                   }//End if PDF
                }elseif(empty($id_alunoAluno) || empty($id_pessoaAluno)){echo"<div class='alert alert-success'>Id da pessoa ou aluno em falta</div>";}   
               
            }
			
            
        } catch (PDOException $ex){ $ex->getMessage();  }
	?>
            
            
                <form class="stdform" action="marcarEstagio.php" method="post" enctype="multipart/form-data">
                    	
                        <p>
                            <label>Nome Completo:</label>
                            <span class="field"><input type="text" name="nome" class="input-xlarge" placeholder="João Manuel" required="yes" value="<?php echo $ver_AlunoE->nome;?>"/></span>
                        </p>
                        
                         <p>
                            <label>Nº Proc.:</label>
                            <span class="field"><input type="text" name="processo" class="input-medium" placeholder="1234" required="yes" value="<?php echo $ver_AlunoE->id_aluno;?>" disabled="disabled"/></span>
                        </p>
                        <p>
                            <label>Nº B.I.:</label>
                            <span class="field"><input type="text" name="bi" class="input-medium" readonly="readonly" placeholder="34678722NE046" required="yes" value="<?php echo $ver_AlunoE->bi;?>"/></span>
                        </p>
                        <p>
                            <label>Nº Faltas</label>
                            <span class="field"><input type="number" name="faltas" class="input-medium" placeholder="000...." /></span>
                        </p>
                        <p>
                                <label>Curso:</label>
                                <?php 
                                    $sql22="select *from tbl_curso where curso=:curso";
                                    $run22=$con->prepare($sql22);
                                    $run22->bindParam(":curso",$ver_AlunoE->curso,PDO::PARAM_STR);
                                    $run22->execute();
                                    $view22=$run22->fetch(PDO::FETCH_OBJ);
                                ?>
                                <span class="field"><select name="curso" id="selection1" class="input-medium">
                                <option value="<?php echo $view22->curso;?>"><?php echo $ver_AlunoE->curso;?></option>
                                <?php 
                                    $sel13="select *from tbl_curso";
                                    $ex13=$con->prepare($sel13);
                                    $ex13->execute();
                                    while($ver13=$ex13->fetch(PDO::FETCH_OBJ))
                                    {
                                        
                               
                                ?>
                                          <option value="<?php echo $ver13->curso;?>"><?php echo $ver13->curso;?></option>
                                <?php  }?>
                                </select></span>
                                 </p>
                        
                        
                                <p>
                                <label>Classe:</label>
                                <span class="field"><select name="classe" id="selection1" class="input-medium">
                                <?php
                                    $sql23="select *from tbl_classe where classe=:classe";
                                    $run23=$con->prepare($sql23);
                                    $run23->bindParam(":classe",$ver_AlunoE->classe,PDO::PARAM_STR);
                                    $run23->execute();
                                    $view23=$run23->fetch(PDO::FETCH_OBJ);
                                 
                                ?>
                                <option value="<?php echo $view23->classe;?>"><?php echo $ver_AlunoE->classe;?></option>
                                <?php 
                                    $sel1="select *from tbl_classe";
                                    $ex1=$con->prepare($sel1);
                                    $ex1->execute();
                                    while($ver1=$ex1->fetch(PDO::FETCH_OBJ))
                                    {                                    
                               
                                ?>
                                <option value="<?php echo $ver1->classe;?>"><?php echo $ver1->classe;?></option>
                                <?php  }?>
                                </select></span>
                                </p>
                            
                                <p>
                                <label>Turma:</label
                                <?php  $sql24="select *from tbl_turma where turma=:turma";
                                    $run24=$con->prepare($sql24);
                                    $run24->bindParam(":turma",$ver_AlunoE->turma,PDO::PARAM_STR);
                                    $run24->execute();
                                    $view24=$run24->fetch(PDO::FETCH_OBJ);
                                ?>
                                <span class="field"><select name="turma" id="selection2" class="input-medium">
                                 <option value="<?php echo $view24->turma;?>"><?php echo $ver_AlunoE->turma;?></option>
                                <?php 
                                    $sel2="select *from tbl_turma";
                                    $ex2=$con->prepare($sel2);
                                    $ex2->execute();
                                    while($ver2=$ex2->fetch(PDO::FETCH_OBJ))
                                    {                                        
                               
                                ?>
                                    <option value="<?php echo $ver2->turma;?>"><?php echo $ver2->turma; ?></option>
                                <?php  }?>
                                </select></span>
                                </p>
                                
                                <p>
                                <label>Turno:</label>
                                <?php  
                                    $sql25="select *from tbl_turno where turno=:turno";
                                    $run25=$con->prepare($sql25);
                                    $run25->bindParam(":turno",$ver_AlunoE->turno,PDO::PARAM_STR);
                                    $run25->execute();
                                    $view25=$run25->fetch(PDO::FETCH_OBJ);
                                ?>
                                
                                <span class="field"><select name="turno" id="selection3" class="input-medium">
                                        <option ><?php echo $ver_AlunoE->turno;?></option>
                                <?php 
                                    $sel3="select *from tbl_turno";
                                    $ex3=$con->prepare($sel3);
                                    $ex3->execute();
                                    while($ver3=$ex3->fetch(PDO::FETCH_OBJ))
                                    {
                                    
                               
                                ?>
                                    <option value="<?php echo $ver3->turno;?>"><?php echo $ver3->turno;?></option>
                                <?php  }?>
                                </select></span>
                            </p>
                            
                            <p>
                                <label>Local de Estágio</label>
                                <span class="field"><input type="text" name="local_estagio" class="input-medium" placeholder="Local de Estágio" required/></span>
                            </p>                        
                                    <p>
                                    <label for="">Província:</label>
                                <select size="1" name="provincia" id="provincia" onChange="escolha()" class='input-medium'>
                                	<option><?php echo $ver_AlunoE->provincia;?></option>
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
        	                   <option><?php echo $ver_AlunoE->municipio;?></option>
                            </select>                        
                        
                        <p>
                            <label>Nº Telefone:</label>
                            <span class="field"><input type="number" name="telefone" class="input-medium" placeholder="946216795" required="yes" value="<?php echo $ver_AlunoE->telefone;?>"/></span>
                        </p>
                        <p>
                            <label>Supervisor</label>
                            <span class="field"><input type="text" name="supervisor" class="input-medium" placeholder="Nome do supervisor ou mentor da unidade sanitária" required/></span>
                        </p>
                        <p>
                            <label>Tele.Supervisor</label>
                            <span class="field"><input type="number" name="tele_supervisor" class="input-medium" placeholder="000..." required/></span>
                        </p>
                        <p>
                            <label>Data de Início</label>
                            <span class="field"><input type="date" name="dataInicio" class="input-medium" required/></span>
                        </p>
                        <p>
                            <label>Fim do estágio</label>
                            <span class="field"><input type="date" name="fim_estagio" class="input-medium" required/></span>
                        </p>
                            
                        <p>
                            <label>Ano Lectivo:</label>
                            <span class="field"><input type="text" class="input-medium" value="<?php echo $ver_AlunoE->anolectivo;?>" required="yes" name="ano1"/></span>
                        </p>
                        
                        
                        <p class="stdformbutton">
                                    <button type="submit" class="btn btn-primary" name="bt1">Salvar Dados</button>
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

</body>
</html>
