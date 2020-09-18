<?php
include("config/conn.php");
include 'validarlogin.php';
$id_aluno=$_GET['id_aluno'];
$ano=$_SESSION['anovb'];
$curso=$_GET['curso'];
$cardeneta="sim";
$classe=$_GET['classe'];

//pesquiza id curso
$selCur="select *from tbl_curso where curso=:curso";
$reCur=$con->prepare($selCur);
$reCur->bindParam(":curso",$curso,PDO::PARAM_STR);
$reCur->execute();
$verCur=$reCur->fetch(PDO::FETCH_OBJ);
$ID_CURSO=$verCur->id_curso;

//pesquiza id classe
$selCla="select *from tbl_classe where classe=:classe";
$reCla=$con->prepare($selCla);
$reCla->bindParam(":classe",$classe,PDO::PARAM_STR);
$reCla->execute();
$verCla=$reCla->fetch(PDO::FETCH_OBJ);
$ID_CLASSE=$verCla->id_classe;




$trimestre1=1;
    $trimestre2=2;
    $trimestre3=3;
   $tracos="---"; 
$sd="select *from tbl_notas where id_aluno=:id and anoLetivo=:ano";
$sdb=$con->prepare($sd);
$sdb->bindParam(":id",$id_aluno,PDO::PARAM_STR);
$sdb->bindParam(":ano",$ano,PDO::PARAM_STR);
$sdb->execute();
$cont5590=$sdb->rowCount();
if($cont5590==0):
$sql="select *from tbl_disciplinas where id_classe=:id_classe and id_curso=:id_curso";
$run=$con->prepare($sql);
$run->bindParam(":id_classe",$ID_CLASSE,PDO::PARAM_STR);
$run->bindParam(":id_curso",$ID_CURSO,PDO::PARAM_STR);
$run->execute();
$cont5591=$run->rowCount();
$observacao="Aluno Novo";
/*cadastra o aluno na tabela notas com as disciplinas q foram selecionadas*/
while ($view=$run->fetch(PDO::FETCH_OBJ)){
   //1 trimestre

 $ins4="insert into tbl_notas (id_aluno,id_di2,epoca,anoLetivo,mac,cpp,ct)values(:id_aluno,:id_dis2,:epoca,:anoLetivo,:mac,:cpp,:ct)";
    $ex7=$con->prepare($ins4);
    $ex7->bindParam(":id_aluno",$id_aluno,PDO::PARAM_STR);
    $ex7->bindParam(":id_dis2",$view->id_di2,PDO::PARAM_STR);
    $ex7->bindParam(":epoca",$trimestre1,PDO::PARAM_STR);
    $ex7->bindParam(":anoLetivo",$ano,PDO::PARAM_STR);
    $ex7->bindParam(":mac",$tracos,PDO::PARAM_STR);
    $ex7->bindParam(":cpp",$tracos,PDO::PARAM_STR);
    $ex7->bindParam(":ct",$tracos,PDO::PARAM_STR);
    $ex7->execute(); 
    
    //2 trimestre
    
     $ex7=$con->prepare($ins4);
    $ex7->bindParam(":id_aluno",$id_aluno,PDO::PARAM_STR);
    $ex7->bindParam(":id_dis2",$view->id_di2,PDO::PARAM_STR);
    $ex7->bindParam(":epoca",$trimestre2,PDO::PARAM_STR);
    $ex7->bindParam(":anoLetivo",$ano,PDO::PARAM_STR);
    $ex7->bindParam(":mac",$tracos,PDO::PARAM_STR);
    $ex7->bindParam(":cpp",$tracos,PDO::PARAM_STR);
    $ex7->bindParam(":ct",$tracos,PDO::PARAM_STR);
    $ex7->execute(); 
    
     //3 trimestre
    
     $ex7=$con->prepare($ins4);
    $ex7->bindParam(":id_aluno",$id_aluno,PDO::PARAM_STR);
    $ex7->bindParam(":id_dis2",$view->id_di2,PDO::PARAM_STR);
    $ex7->bindParam(":epoca",$trimestre3,PDO::PARAM_STR);
    $ex7->bindParam(":anoLetivo",$ano,PDO::PARAM_STR);
    $ex7->bindParam(":mac",$tracos,PDO::PARAM_STR);
    $ex7->bindParam(":cpp",$tracos,PDO::PARAM_STR);
    $ex7->bindParam(":ct",$tracos,PDO::PARAM_STR);
    $ex7->execute(); 
    
    
    
    //tabela de classificao final
    $df55="insert into tbl_cla_finais(id_aluno,id_di2,anolectivo,cap,cpe,cf,observacao)values(:id_aluno,:id_di2,:ano,:cap,:cpe,:cf,:observacao)";
    $df=$con->prepare($df55);
    $df->bindParam(":id_aluno",$id_aluno,PDO::PARAM_STR);
    $df->bindParam(":id_di2",$view->id_di2,PDO::PARAM_STR);
    $df->bindParam(":ano",$ano,PDO::PARAM_STR);
    $df->bindParam(":cap",$tracos,PDO::PARAM_STR);
    $df->bindParam(":cpe",$tracos,PDO::PARAM_STR);
    $df->bindParam(":cf",$tracos,PDO::PARAM_STR);
    $df->bindParam(":observacao",$observacao,PDO::PARAM_STR);
    $df->execute(); 
}
if($df):
            $sql2="update tbl_aluno set cardeneta=:cardeneta where id_aluno=:id_aluno and anolectivo=:ano";
            $run2=$con->prepare($sql2);
            $run2->bindParam(":cardeneta",$cardeneta,PDO::PARAM_STR);
             $run2->bindParam(":id_aluno",$id_aluno,PDO::PARAM_STR);
             $run2->bindParam(":ano",$ano,PDO::PARAM_STR);
            $run2->execute();
            if($run2):
             echo "
	<script>
	window.alert('Cardeneta Criada com sucesso!');
	window.location.href='criar_cardeneta.php';
	</script>
	";   
            endif;
	
	endif;


else:
   echo "
	<script>
	window.alert('Cardeneta ja foi criada');
	window.location.href='criar_cardeneta.php';
	</script>
	"; 
endif;

    


	
	


?>