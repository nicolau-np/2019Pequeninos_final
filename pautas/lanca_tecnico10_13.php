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
<script>
    $(document).ready(function(){
        var epoca=$("#epoca").val();
        if((epoca==1)||(epoca==2)||(epoca==3)){
            $(".glo").hide();
           $(".priter").show();
        }
        else if(epoca==4){
           $(".glo").show();
           $(".priter").hide();  
        }
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
                     <li  class="active"><a href="boxes.php">Usuários</a></li>
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
                          $id_aluno=0; $id_dis=0; $epoca=0; $ano800=0;  
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
                            <table class="table table-striped" width="200px">
                                <tr>
                                    <td rowspan='3' width='100px'><img src="foto_alunos/<?php echo $ver->foto;?>" style="width:100px; height:90px;"  /></td>
                            
                                </tr>
                                 <tr>
                                    <td style="font-weight: bold; width: 180px; font-size:15px;">Nome completo:</td>
                                    <td><span style="font-weight: bold; font-size:15px; color:#003399;"><?php echo $ver->nome;?> <br/><br/><?php echo $ver->curso." - ".$ver->classe." ".$ver->turma." ".$ver->turno;?></span></td>
                           
                           
                                </tr>
                             
                            </table>
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
                               
                              echo"<td><span style='font-size:14px; font-weight:bold;'>".$view78->valor."</span><span style='font-size:9px;'> <br/>".$view78->data."<br/><a href='eliminar_avalicao2.php?id_avaliacao=".$view78->id_ava."&&id_aluno=".$view78->id_aluno."&&id_disciplina=".$id_dis."&&ano=".$ano800."&&epoca=".$epoca."&&curso=".$ver->curso."&&classe=".$ver->classe."&&pagina=lanca_tecnico10_13.php'>eliminar</a><span></td>" ;
                          
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
                             if($v71->estado=="ON"): echo"<br/><a href='eliminar_prova2.php?id_prova=".$view80->id_prova."&&id_aluno=".$view80->id_aluno."&&id_disciplina=".$id_dis."&&ano=".$ano800."&&epoca=".$epoca."&&curso=".$ver->curso."&&classe=".$ver->classe."&&pagina=lanca_tecnico10_13.php'>eliminar</a>";
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
                           $sql2="select *from tbl_provas where id_aluno=:id and ano=:ano and id_disciplina=:id_dis and epoca=:epoca";
                           $run2=$con->prepare($sql2);
                           $run2->bindParam(":id",$id_aluno,PDO::PARAM_STR);
                           $run2->bindParam(":ano",$ano800,PDO::PARAM_STR);
                           $run2->bindParam(":id_dis",$id_dis,PDO::PARAM_STR);
                           $run2->bindParam(":epoca",$epoca,PDO::PARAM_STR);
                           $run2->execute();
                           $contarProvas=$run2->rowCount();
                           
                            $sql3="select *from tbl_avaliacao where id_aluno=:id and ano=:ano and id_disciplina=:id_dis and epoca=:epoca";
                           $run3=$con->prepare($sql3);
                           $run3->bindParam(":id",$id_aluno,PDO::PARAM_STR);
                           $run3->bindParam(":ano",$ano800,PDO::PARAM_STR);
                           $run3->bindParam(":id_dis",$id_dis,PDO::PARAM_STR);
                           $run3->bindParam(":epoca",$epoca,PDO::PARAM_STR);
                           $run3->execute();
                           $contarAvaliacao=$run3->rowCount();
                           
                           if(isset($_POST['sav'])){
                               $nota= addslashes( htmlspecialchars($_POST['nota']));
                               $tipo= addslashes( htmlspecialchars($_POST['tipo']));
                                                                                            
                               
                           $sql2="select *from tbl_provas where id_aluno=:id and ano=:ano and id_disciplina=:id_dis and epoca=:epoca";
                           $run2=$con->prepare($sql2);
                           $run2->bindParam(":id",$id_aluno,PDO::PARAM_STR);
                           $run2->bindParam(":ano",$ano800,PDO::PARAM_STR);
                           $run2->bindParam(":id_dis",$id_dis,PDO::PARAM_STR);
                           $run2->bindParam(":epoca",$epoca,PDO::PARAM_STR);
                           $run2->execute();
                           $contarProvas=$run2->rowCount();
                           
                            $sql3="select *from tbl_avaliacao where id_aluno=:id and ano=:ano and id_disciplina=:id_dis and epoca=:epoca";
                           $run3=$con->prepare($sql3);
                           $run3->bindParam(":id",$id_aluno,PDO::PARAM_STR);
                           $run3->bindParam(":ano",$ano800,PDO::PARAM_STR);
                           $run3->bindParam(":id_dis",$id_dis,PDO::PARAM_STR);
                           $run3->bindParam(":epoca",$epoca,PDO::PARAM_STR);
                           $run3->execute();
                           $contarAvaliacao=$run3->rowCount();  
                               
                               
                               
                               $total_ava=$contarAvaliacao+1;
                               $total_pro=$contarProvas+1;
                               $media_provasDB=0;  $IT=0;  $CP=0;  $cf_extenso="?";
                               if($tipo=="Avaliação"):
                                        //so avaliacao
                                        $pglobal=0;
                                        $ava=round($nota);
                                        $resAva=avaliacao($ava,$con);
                                        if($resAva =="OK_ava"){
                                            $IT = selectTBAvaliacoes($con);
                                            $media_provasDB = selectTB_Provas($con);
                                        }
                                        //============================  Calc Average ================================ 
                                                
                                    if(($media_provasDB=="---") && ($IT !="---") && ($IT >0)):
                                           //$CP=(0*0.8)+($IT*0.2);
                                        $CP=0*0.8+$IT*0.2;
                                    elseif(($media_provasDB !="---") && ($IT !="---") && ($IT >0)):
                                      //$CP=($media_provasDB*0.8)+($IT*0.2);
                                       $CP=$media_provasDB*0.8+$IT*0.2;                                 
                                    endif;
                     //================ UPDATING DATA IN tbl_notas TABLE  ====================                   
                                        updateTBNotas($con,$IT,$CP,$media_provasDB);
                                        $CFINAL = pickUpCT($con);
                                        salvarProvaGlobal($con,$CFINAL,$pglobal,$cf_extenso);
                                    echo"<div class='alert alert-success'>Avaliação Feita com sucesso! Nota: ".$ava." IT: ".$IT." MPRova: ".$media_provasDB." CP: ".$CP." IDAluno: ".$id_aluno."</div>";
                                        echo '<meta http-equiv="refresh" content="1"/>';
                                elseif($tipo=="Prova"):
                                   //so prova
                                       $pglobal=0;
                                       $prova=round($nota);
                                       $resProva = inserirProva($prova,$con);
                                       if($resProva =="OK_prov"){
                                           $IT = selectTBAvaliacoes($con);
                                            $media_provasDB = selectTB_Provas($con);
                                        }
                                        //============================  Calc Average ================================ 
                                                
                                    if(($media_provasDB=="---") && ($IT !="---") && ($IT >0)):
                                           //$CP=(0*0.8)+($IT*0.2);
                                        $CP=0*0.8+$IT*0.2;
                                    elseif(($media_provasDB !="---") && ($IT !="---") && ($IT >0)):
                                      //$CP=($media_provasDB*0.8)+($IT*0.2);
                                      $CP=$media_provasDB*0.8+$IT*0.2;                                 
                                    endif;
                     //================ UPDATING DATA IN tbl_notas TABLE  ====================                   
                                        updateTBNotas($con,$IT,$CP,$media_provasDB);
                                        $CFINAL = pickUpCT($con);
                                        salvarProvaGlobal($con,$CFINAL,$pglobal,$cf_extenso);
                                        echo"<div class='alert alert-success'>Prova Feita com sucesso! Nota: ".$prova." IT: ".$IT." MPRova: ".$media_provasDB." CP: ".$CP."IDAluno: ".$id_aluno."</div>";
                                   echo"<div class='alert alert-success'>Feito com sucesso</div>";
                                   echo '<meta http-equiv="refresh" content="1"/>';                                 

                                endif;
                                echo"<div class='alert alert-success'>Cadastrando medias finais Nota: ".$pglobal."</div>";
                               
                           }
                            //================================== FUNCTIONS ==================                        
    function avaliacao($ava,$con){
        $data = date("d-m-Y");
        $ano = $_SESSION['ano'];
        $ava = round($ava);
        $res=0;
                    //============= INSERINDO NOTAS A TABELA DE AVALIACOES CONTÍNUAS  ================== 
        try{
                                $sql3="insert into tbl_avaliacao(id_aluno,id_disciplina,ano,data,valor,epoca) values(:id_aluno,:id_disciplina,:ano,:data,:valor,:epoca)";   
                               $run3=$con->prepare($sql3);
                               $run3->bindParam(":id_aluno",$_SESSION['id_aluno'],PDO::PARAM_STR);
                               $run3->bindParam(":id_disciplina",$_SESSION['id_dis'],PDO::PARAM_STR);
                               $run3->bindParam(":ano",$ano,PDO::PARAM_STR);
                               $run3->bindParam(":data",$data,PDO::PARAM_STR);
                               $run3->bindParam(":valor",$ava,PDO::PARAM_STR);
                               $run3->bindParam(":epoca",$_SESSION['epoca'],PDO::PARAM_STR);
                                
                               if($run3->execute()){  $res="OK_ava";
                                 echo"<div class='alert alert-success'>Avaliação inserida com sucesso!".$ava."</div>";
                               }
         }catch(PDOException $e){ $e ->getMessage();} 
       return $res;
                           
    }//End function
    function selectTBAvaliacoes($con){
          $IT=0;
        //============= CONSULTANDO A SOMA E CALCULANDO A MÉDIA DAS AVALIACOES CONTÍNUAS ==================            
                //$sql5="SELECT SUM(valor) FROM tbl_avaliacao where id_aluno=:id_aluno and id_disciplina=:id_disciplina and ano=:ano and epoca=:epoca";
          try{
                $sql5="SELECT avg(valor) FROM tbl_avaliacao where id_aluno=:id_aluno and id_disciplina=:id_disciplina and ano=:ano and epoca=:epoca";
                               $run5=$con->prepare($sql5);
                               $run5->bindParam(":id_aluno",$_SESSION['id_aluno'],PDO::PARAM_STR);
                               $run5->bindParam(":id_disciplina",$_SESSION['id_dis'],PDO::PARAM_STR);
                               $run5->bindParam(":ano",$_SESSION['ano'],PDO::PARAM_STR);
                               $run5->bindParam(":epoca",$_SESSION['epoca'],PDO::PARAM_STR);
                               $run5->execute();
                               
                               //$somaAvaliacao=$run5->fetchColumn();
                               $result = $run5 -> fetchAll(PDO::FETCH_ASSOC);
                               foreach ($result as $value) {
                                  $IT = round($value["avg(valor)"]);
                               }
              }catch(PDOException $e){ $e ->getMessage();}        
                               //$IT=$somaAvaliacao/$total_ava;
                       //echo " MAC nota:=: ".$IT;        
            return $IT;       
    }//End function 
    function inserirProva($prova,$con){
      $data=date("d-m-Y");
      $prova=round($prova);
      $res=0;
         //============= INSERTING VALUES OF THE EXAMES IN DATABASE   ================== 
           try{
                                  //$sql4="insert into tbl_provas(id_aluno,id_disciplina,ano,data,valor,epoca) values(:id_aluno,:id_disciplina,:ano,:data,:valor,:epoca)";   
                               $run4=$con->prepare("insert into tbl_provas(id_aluno,id_disciplina,ano,data,valor,epoca) values(:id_aluno,:id_disciplina,:ano,:data,:valor,:epoca)");
                               $run4->bindParam(":id_aluno",$_SESSION['id_aluno'],PDO::PARAM_STR);
                               $run4->bindParam(":id_disciplina",$_SESSION['id_dis'],PDO::PARAM_STR);
                               $run4->bindParam(":ano",$_SESSION['ano'],PDO::PARAM_STR);
                               $run4->bindParam(":data",$data,PDO::PARAM_STR);
                               $run4->bindParam(":valor",$prova,PDO::PARAM_STR);
                               $run4->bindParam(":epoca",$_SESSION['epoca'],PDO::PARAM_STR);
                               if($run4->execute()){ $res="OK_prov";
                                 echo"<div class='alert alert-success'>Prova registada com sucesso!".$prova."</div>";
                               } 
        
               }catch(PDOException $e){ $e ->getMessage();} 
        return $res;                       
    }//End function
    function selectTB_NotasMedia1($con){
         //============= CONSULTA AO BANCO DE DADOS PARA A CONTAGEM DE PROVAS FEITAS ==================            
                $media_provasDB=0;   $C1P=0;  
              try{      
                $sql6="SELECT *FROM tbl_notas where id_aluno=:id_aluno and id_di2=:id_disciplina and anoLetivo=:ano and epoca=:epoca";
                               $run6=$con->prepare($sql6);
                               $run6->bindParam(":id_aluno",$_SESSION['id_aluno'],PDO::PARAM_STR);
                               $run6->bindParam(":id_disciplina",$_SESSION['id_dis'],PDO::PARAM_STR);
                               $run6->bindParam(":ano",$_SESSION['ano'],PDO::PARAM_STR);
                               $run6->bindParam(":epoca",$_SESSION['epoca'],PDO::PARAM_STR);
                               $run6->execute();
                               $view6=$run6->fetch(PDO::FETCH_OBJ);
                               $media_provasDB=$view6->cpp;
                              
                }catch(PDOException $e){ $e ->getMessage();}               
            return $media_provasDB;                    
    }//End function
    function selectTB_Provas($con){
          $media_provasDB=0;
          $somaProvas=0;
        //============= GETTING THE SUM VALUES OF EXAMES FROM DATABASE   ================== 
         try{                       
                              // $sql5="SELECT SUM(valor) FROM tbl_provas where id_aluno=:id_aluno and id_disciplina=:id_disciplina and ano=:ano and epoca=:epoca";
            $sql5="SELECT AVG(valor) FROM tbl_provas where id_aluno=:id_aluno and id_disciplina=:id_disciplina and ano=:ano and epoca=:epoca";
            $run5=$con->prepare($sql5);
            $run5->bindParam(":id_aluno",$_SESSION['id_aluno'],PDO::PARAM_STR);
            $run5->bindParam(":id_disciplina",$_SESSION['id_dis'],PDO::PARAM_STR);
            $run5->bindParam(":ano",$_SESSION['ano'],PDO::PARAM_STR);
            $run5->bindParam(":epoca",$_SESSION['epoca'],PDO::PARAM_STR);
            $run5->execute();
                //$somaProvas=$run5->fetchColumn();                               
               //$media_provasDB=$somaProvas/$total_pro;
            $result = $run5 -> fetchAll(PDO::FETCH_ASSOC);
                foreach ($result as $value) {
                        $media_provasDB = $value["AVG(valor)"];
                }

          }catch(PDOException $e){ $e ->getMessage();} 

                if(empty($media_provasDB)){ $media_provasDB =0;}
               echo"<div class='alert alert-success'> IDA= ".$_SESSION['id_aluno']." IDDisci: ".$_SESSION['id_dis']." Ano: ".$_SESSION['ano']." Epoca: ".$_SESSION['epoca']." Media prova= ".$media_provasDB."</div>";
        return $media_provasDB;                       

    }//End function
    function updateTBNotas($con,$IT,$CP,$media_provasDB){
           $res=0;
           //============= FAZENDO O UPDATE DAS NOTAS DO MAC ou IT e CT ou CP  ==================    
           try{                 
                $comaAS="update tbl_notas set  mac=:it,cpp=:mediaProvas, ct=:cp where id_aluno=:id and epoca=:epoca and id_di2=:id_di2 and anoLetivo=:ano"; 
                $excAS=$con->prepare($comaAS);
                $CP=round($CP);
                $excAS->bindParam(":it",$IT,PDO::PARAM_STR);
                $excAS->bindParam(":mediaProvas",$media_provasDB,PDO::PARAM_STR);
                $excAS->bindParam(":cp",$CP,PDO::PARAM_STR);
                $excAS->bindParam(":id",$_SESSION['id_aluno'],PDO::PARAM_STR);
                $excAS->bindParam(":epoca",$_SESSION['epoca'],PDO::PARAM_STR);
                $excAS->bindParam(":id_di2",$_SESSION['id_dis'],PDO::PARAM_STR);
                $excAS->bindParam(":ano",$_SESSION['ano'],PDO::PARAM_STR);
                if($excAS->execute()): $res="Value_updated";
                  echo"<div class='alert alert-success'>Update das Notas feito com sucesso! IT:=: ".$IT." CP: ".$CP."</div>";
                endif;
           }catch(PDOException $e){ $e ->getMessage();}     
           return $res;
    }//End function 
    function pickUpCT($con){$CAP=0; 
                         $co="SELECT AVG(ct) FROM view_notas where anoLetivo=:ano and id_aluno=:id_aluno and id_di2=:di2";
                         $xe=$con->prepare($co);
                         $xe->bindParam(":ano",$_SESSION['ano'],PDO::PARAM_STR);
                         $xe->bindParam(":id_aluno",$_SESSION['id_aluno'],PDO::PARAM_STR);
                         $xe->bindParam(":di2",$_SESSION['id_dis'],PDO::PARAM_STR);
                         $xe->execute();
                         $result = $xe -> fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $value) {
                               $CAP = round($value["AVG(ct)"]);
                            }
                          
                           echo"<div class='alert alert-success'>Cadastrando médias finais Nota: ".$CAP." IDAluno: ".$_SESSION['id_aluno']."</div>";      

                          return $CAP; 
                    }//End function
                    function salvarProvaGlobal($con,$cfinal,$pglobal,$cf_extenso){
                        $obser=0;
                        $pglobal=round($pglobal);  //$cfinal=round($cfinal);
                         //========================  Calculate average =========================== 
                                  $cAnual = ($cfinal*0.6)+($pglobal*0.4);
                                  $cAnual=round($cAnual); 
                                  if($cAnual <=9):
                                  $obser="Nao Transita";
                                  elseif($cAnual >=9.5):
                                  $obser="Transita";
                                  endif;

                                $re="update tbl_cla_finais set cap=:cap, cpe=:cpe, cf=:cf, observacao=:ob, cf_extensao=:cf_extensao where id_aluno=:id and id_di2=:id_di2 and anolectivo=:ano";
                                $r=$con->prepare($re);
                                $r->bindParam(":cap",$cfinal,PDO::PARAM_STR);
                                $r->bindParam(":cpe",$pglobal,PDO::PARAM_STR);
                                $r->bindParam(":cf",$cAnual,PDO::PARAM_STR);
                                $r->bindParam(":ob",$obser,PDO::PARAM_STR);
                                $r->bindParam(":cf_extensao",$cf_extenso,PDO::PARAM_STR);
                                $r->bindParam(":id",$_SESSION['id_aluno'],PDO::PARAM_STR);
                                $r->bindParam(":id_di2",$_SESSION['id_dis'],PDO::PARAM_STR);
                                $r->bindParam(":ano",$_SESSION['ano'],PDO::PARAM_STR);
                                ;
                                if($r->execute()){
                                    echo"<div class='alert alert-success'>C.Final Feito com sucesso CFINAL: ".$cAnual." IDAluno: ".$_SESSION['id_aluno']. " PGlobal: ".$pglobal."</div>";              
                                }else {  echo 'erro'; }
                    }//End function
  
        
                           
                           
                           
                           
                     
                           ?>
                            
                            <form class="" name="g" method="POST" action="lanca_tecnico10_13.php">
                             
                                 <div class="form-inline">
                                    <label>Tipo</label>
                                    <select name="tipo" class="input-medium">
                                        <option>Avaliação</option>
                                         <?php if($contarProvas<2): echo'<option>Prova</option>';endif;?>
                                    </select>
                                    <label>Nota</label>
                                    <input type="text" name="nota" placeholder="valor" class="input-small" required=""/>
                                    <input type="submit" value="Salvar" class="btn btn-primary" name="sav">
                                </div></form>
                            
                        </div>
                         <!-- prova global-->
        <?php
                if(isset($_POST['sav2'])){
                    
                    $PGlobal =addslashes(htmlspecialchars($_POST['cpe']));
                               

                                           /*
                                                elseif($tipo =="Prova Global"):
                                                //============================  Calc Average ================================ 
                                                  $cfinal=0; $caanual=0; $c1p=0;$c2p=0;$c3p=0;
                                                  $cfinal=($c1p+$c2p+$c3p)/3;
                                                  $caanual=(0.6*$cfinal)+(0.4*$pglobal);            
                                                if(($media_provasDB=="---") && ($IT !="---") && ($IT >0)):
                                                       $CP=(0*0.8)+($IT*0.2);
                                                elseif(($media_provasDB !="---") && ($IT !="---") && ($IT >0)):
                                                  $CP=($media_provasDB*0.8)+($IT*0.2);                                
                                                endif;
                                                echo"<div class='alert alert-success'>Cadastrando medias finais Nota: ".$pglobal."</div>";

                                                salvarProvaGlobal($con,$pglobal,$cfinal,$caanual,$obser,$cf_extenso); 
                                                */
                    
                    
                      $CFINAL = pickUpCT($con);
                      $cf_extenso="";

                      if(round($CFINAL)==1):
                          $cf_extenso="Um valor";
                      elseif(round($CFINAL)==2):
                           $cf_extenso="Dois valores";
                       elseif(round($CFINAL)==3):
                           $cf_extenso="Três valores";
                       elseif(round($CFINAL)==4):
                           $cf_extenso="Quatro valores";
                       elseif(round($CFINAL)==5):
                           $cf_extenso="Cinco valores";
                       elseif(round($CFINAL)==6):
                           $cf_extenso="Seis valores";
                       elseif(round($CFINAL)==7):
                           $cf_extenso="Sete valores";
                       elseif(round($CFINAL)==8):
                           $cf_extenso="Oito valores";
                       elseif(round($CFINAL)==9):
                           $cf_extenso="Nove valores";
                       elseif(round($CFINAL)==10):
                           $cf_extenso="Dez valores";
                       elseif(round($CFINAL)==11):
                           $cf_extenso="Onze valores";
                       elseif(round($CFINAL)==12):
                          $cf_extenso="Doze valores";
                        elseif(round($CFINAL)==13):
                          $cf_extenso="Treze valores";
                        elseif(round($CFINAL)==14):
                          $cf_extenso="Catorze valores";
                        elseif(round($CFINAL)==15):
                          $cf_extenso="Quinze valores";
                        elseif(round($CFINAL)==16):
                          $cf_extenso="Dezasseis valores";
                        elseif(round($CFINAL)==17):
                          $cf_extenso="Dezassete valores";
                        elseif(round($CFINAL)==18):
                          $cf_extenso="Dezoito valores";
                        elseif(round($CFINAL)==19):
                          $cf_extenso="Dezanove valores";
                        elseif(round($CFINAL)==20):
                          $cf_extenso="Vinte valores";
                      endif;                   
                     

                        salvarProvaGlobal($con,$CFINAL,$PGlobal,$cf_extenso);
                        
              
                 $sql="select *from view_disciplinas where curso=:curso and classe=:classe";
                            $run=$con->prepare($sql);
                            $run->bindParam(":curso",$ver->curso,PDO::PARAM_STR);
                            $run->bindParam(":classe",$ver->classe,PDO::PARAM_STR);
                            $run->execute();
                            $conta_Dis=$run->rowCount();
            
                                        $ob00="Aluno Novo";
$co3="select *from view_clas_finais where anolectivo=:ano and id_aluno=:id and observacao!=:ob";                            
$re3=$con->prepare($co3);
$re3->bindParam(":ano",$_SESSION['ano'],PDO::PARAM_STR);
$re3->bindParam(":id",$_SESSION['id_aluno'],PDO::PARAM_STR);
$re3->bindParam(":ob",$ob00,PDO::PARAM_STR);
$re3->execute();

$contar_OB=$re3->rowCount();

if($conta_Dis>$contar_OB):
  
elseif($conta_Dis==$contar_OB):
    $obser2="Nao Transita";
$co4="select *from view_clas_finais where anolectivo=:ano and id_aluno=:id and observacao=:ob";                            
$re4=$con->prepare($co4);
$re4->bindParam(":ano",$_SESSION['ano'],PDO::PARAM_STR);
$re4->bindParam(":id",$_SESSION['id_aluno'],PDO::PARAM_STR);
$re4->bindParam(":ob",$obser2,PDO::PARAM_STR);
$re4->execute();
$contar_OB2=$re4->rowCount();
if($contar_OB2>=3):
   $obsercacao_finalH="Não Transita";
elseif($contar_OB2<=2):
     $obsercacao_finalH="Transita";
endif;
$se03="update tbl_historico_aluno set aproveitamento=:apro where id_aluno=:id_aluno and anolectivo=:ano";
                            $r03=$con->prepare($se03);
                            $r03->bindParam(":apro",$obsercacao_finalH,PDO::PARAM_STR);
                             $r03->bindParam(":id_aluno",$_SESSION['id_aluno'],PDO::PARAM_STR);
                              $r03->bindParam(":ano",$_SESSION['ano'],PDO::PARAM_STR);
                            $r03->execute();

endif;
            }
                           
                           
    ?>
                        <div class="glo">
                            <form class="" name="go" method="POST" action="lanca_tecnico10_13.php">
                                <fieldset>
                                    <legend style="font-size: 13px;">Prova Global</legend>
                                    <hr/>
                                <div class="form-inline">
                                    <label>Prova Global:</label>
                                    <input type="text" name="cpe" placeholder="Prova Global" required=""/>
                                    <input type="hidden" name="tipo" value="Prova Global">
                             
                                </div>
                                    <input type="submit" value="Salvar" class="btn btn-primary" name="sav2"></fieldset>
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


