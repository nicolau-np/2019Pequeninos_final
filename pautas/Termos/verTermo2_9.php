<?php
include_once '../config/conn.php';
include_once '../classes/Termos.php';
$epoca1 = 1;
$epoca2 = 2;
$epoca3 = 3;
$objTermos = new Termos();
$id_aluno = addslashes(htmlspecialchars($_GET['id_aluno']));
$ano_lectivo = addslashes(htmlspecialchars($_GET['ano_lectivo']));

$objTermos->setCon($con);
$objTermos->setAno_lectivo($ano_lectivo);
$objTermos->setId_aluno($id_aluno);
$res1 = $objTermos->buscaHist();
$viewHisto = $res1->fetch(PDO::FETCH_OBJ);
?>
<html>
<head><title>Termo 2_9</title>
    <style>
        .vermelho{
            color:red;
            
        }
        .azul{
            color:blue;
        }
    </style>

</head>
<body>
    <br/>
    Nome Completo: <?php echo $viewHisto->nome;?><br/>
    Curso: <?php echo $viewHisto->curso;?><br/>
    Classe: <?php echo $viewHisto->classe;?> <br/>
    Turma: <?php echo $viewHisto->turma;?><br/>
    Turno: <?php echo $viewHisto->turno;?><br/>
    Ano Lectivo: <?php echo $viewHisto->anolectivo;?><br/>
    
    <br/><br/>
<table border="1">
    <tr>
        <th rowspan="2">DISCIPLINA</th>  
        <th colspan="3">I TRIMESTRE</th>
        <th colspan="3">II TRIMESTRE</th>
        <th colspan="3">III TRIMESTRE</th>
        <th>CAP</th>
        <th>CPE</th>
        <th>CF</th>
         <th>REC</th>
        <th>RUBRICA DO DIRECTOR</th>
        <th>OBS</th>
    </tr>
    <tr>
       <th>MAC</th>
        <th>CPP</th>
        <th>CT1</th>
        
         <th>MAC</th>
        <th>CPP</th>
        <th>CT2</th>
        
         <th>MAC</th>
        <th>CPP</th>
        <th>CT3</th> 
        
          <th></th>
        <th></th>
        <th></th> 
        
          <th></th>
        <th></th>
        <th></th> 
        
    </tr>

    <?php 
    $res2 = $objTermos->buscaDisciplinas($viewHisto->curso, $viewHisto->classe);
    while($viewDis = $res2->fetch(PDO::FETCH_OBJ)):
    ?>
<tr>
    <td><?php echo $viewDis->nome;?></td> 
    <?php 
    $resNot1 = $objTermos->buscaNotas($viewDis->nome, $epoca1);
    $viewNot1 = $resNot1->fetch(PDO::FETCH_OBJ);
    ?>
    <td class="<?php if(($viewHisto->classe=="2ª")||($viewHisto->classe=="4ª")): if($viewNot1->mac>=5): echo "azul"; else: echo"vermelho"; endif; else: if($viewNot1->mac>=10): echo "azul"; else: echo"vermelho"; endif; endif;?>"><?php echo $viewNot1->mac;?></td> 
    <td class="<?php if(($viewHisto->classe=="2ª")||($viewHisto->classe=="4ª")): if($viewNot1->cpp>=5): echo "azul"; else: echo"vermelho"; endif; else: if($viewNot1->cpp>=10): echo "azul"; else: echo"vermelho"; endif; endif;?>"><?php echo $viewNot1->cpp;?></td> 
    <td class="<?php if(($viewHisto->classe=="2ª")||($viewHisto->classe=="4ª")): if($viewNot1->ct>=5): echo "azul"; else: echo"vermelho"; endif; else: if($viewNot1->ct>=10): echo "azul"; else: echo"vermelho"; endif; endif;?>"><?php echo $viewNot1->ct;?></td> 
    
    
     <?php 
    $resNot2 = $objTermos->buscaNotas($viewDis->nome, $epoca2);
    $viewNot2 = $resNot2->fetch(PDO::FETCH_OBJ);
    ?>
    <td class="<?php if(($viewHisto->classe=="2ª")||($viewHisto->classe=="4ª")): if($viewNot2->mac>=5): echo "azul"; else: echo"vermelho"; endif; else: if($viewNot2->mac>=10): echo "azul"; else: echo"vermelho"; endif; endif;?>"><?php echo $viewNot2->mac;?></td> 
    <td class="<?php if(($viewHisto->classe=="2ª")||($viewHisto->classe=="4ª")): if($viewNot2->cpp>=5): echo "azul"; else: echo"vermelho"; endif; else: if($viewNot2->cpp>=10): echo "azul"; else: echo"vermelho"; endif; endif;?>"><?php echo $viewNot2->cpp;?></td> 
    <td class="<?php if(($viewHisto->classe=="2ª")||($viewHisto->classe=="4ª")): if($viewNot2->ct>=5): echo "azul"; else: echo"vermelho"; endif; else: if($viewNot2->ct>=10): echo "azul"; else: echo"vermelho"; endif; endif;?>"><?php echo $viewNot2->ct;?></td>  
    
     <?php 
    $resNot3 = $objTermos->buscaNotas($viewDis->nome, $epoca3);
    $viewNot3 = $resNot3->fetch(PDO::FETCH_OBJ);
    ?>
    <td class="<?php if(($viewHisto->classe=="2ª")||($viewHisto->classe=="4ª")): if($viewNot3->mac>=5): echo "azul"; else: echo"vermelho"; endif; else: if($viewNot3->mac>=10): echo "azul"; else: echo"vermelho"; endif; endif;?>"><?php echo $viewNot3->mac;?></td> 
    <td class="<?php if(($viewHisto->classe=="2ª")||($viewHisto->classe=="4ª")): if($viewNot3->cpp>=5): echo "azul"; else: echo"vermelho"; endif; else: if($viewNot3->cpp>=10): echo "azul"; else: echo"vermelho"; endif; endif;?>"><?php echo $viewNot3->cpp;?></td> 
    <td class="<?php if(($viewHisto->classe=="2ª")||($viewHisto->classe=="4ª")): if($viewNot3->ct>=5): echo "azul"; else: echo"vermelho"; endif; else: if($viewNot3->ct>=10): echo "azul"; else: echo"vermelho"; endif; endif;?>"><?php echo $viewNot3->ct;?></td>  
    
   <?php 
    $resNotF = $objTermos->buscaClaFinais($viewDis->nome);
    $viewNotF = $resNotF->fetch(PDO::FETCH_OBJ);
    ?>
    <td class="<?php if(($viewHisto->classe=="2ª")||($viewHisto->classe=="4ª")): if($viewNotF->cap>=5): echo "azul"; else: echo"vermelho"; endif; else: if($viewNotF->cap>=10): echo "azul"; else: echo"vermelho"; endif; endif;?>"><?php echo $viewNotF->cap;?></td> 
    <td class="<?php if(($viewHisto->classe=="2ª")||($viewHisto->classe=="4ª")): if($viewNotF->cpe>=5): echo "azul"; else: echo"vermelho"; endif; else: if($viewNotF->cpe>=10): echo "azul"; else: echo"vermelho"; endif; endif;?>"><?php echo $viewNotF->cpe;?></td> 
    <td class="<?php if(($viewHisto->classe=="2ª")||($viewHisto->classe=="4ª")): if($viewNotF->cf>=5): echo "azul"; else: echo"vermelho"; endif; else: if($viewNotF->cf>=10): echo "azul"; else: echo"vermelho"; endif; endif;?>"><?php echo $viewNotF->cf;?></td>  
    
    <td></td> 
    <td></td> 
    <td></td>
</tr>
  <?php endwhile;?>  
</table>

</body>
</html>
