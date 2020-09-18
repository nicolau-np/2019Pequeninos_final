<?php 
class actualizar_professor{

public function professor($nome,$agente,$data,$telefone,$bi,$data_emissao,$local_emissao,$genero,$titulo,$arquivo,$arquivo_tmp,$pai,$mae,$provincia,$municipio,$id_pessoaE,$fotoE, $categoria_estudo,$con){
$palavra1=$telefone;
$sele="select *from tbl_professor where nAgente=:agente";
     $ex=$con->prepare($sele);
     $ex->bindParam(":agente",$agente,PDO::PARAM_STR);
     $ex->execute(); 
$vex=$ex->fetch(PDO::FETCH_OBJ);
    $contar=$ex->rowCount();
    if(($contar>0)&&($id_pessoaE!=$vex->id_pessoa)):
     print("<div class='alert alert-danger'>Numero de agente ja existente!</div>");
     else:
	 //busca id-professor
	 $covE="select *from view_professor where id_pessoa=:id_pessoa";
			$EcovE=$con->prepare($covE);
			$EcovE->bindParam(":id_pessoa",$id_pessoaE,PDO::PARAM_STR);
			$EcovE->execute();
			$verE=$EcovE->fetch(PDO::FETCH_OBJ);
			
	if($arquivo==""):
    $foto=$fotoE;
    else:
    $foto=$arquivo;
    if($foto!="none.jpg"):
        //apagar antiga foto
	unlik("fotos_professores/$fotoE");
    endif;
//mover a foto nova para a pasta
$destino='fotos_professores/'.$arquivo;
$arquivo_tmp1=$arquivo_tmp;
move_uploaded_file($arquivo_tmp1,$destino);
    endif;
	
	//actualiza aqui
$ins="update tbl_pessoa set nome=:nome,genero=:genero,data_nascimento=:data_nascimento,bi=:bi,data_emissao=:data_emissao,local_emissao=:local_emissao,foto=:foto,telefone=:telefone,titulo=:titulo,pai=:pai,mae=:mae,provincia=:provincia,municipio=:municipio where id_pessoa=:id_pessoa";
   
    $ex1=$con->prepare($ins);
    $ex1->bindParam(":nome",$nome,PDO::PARAM_STR);
    $ex1->bindParam(":genero",$genero,PDO::PARAM_STR);
    $ex1->bindParam(":data_nascimento",$data,PDO::PARAM_STR);
    $ex1->bindParam(":bi",$bi,PDO::PARAM_STR);
    $ex1->bindParam(":data_emissao",$data_emissao,PDO::PARAM_STR);
    $ex1->bindParam(":local_emissao",$local_emissao,PDO::PARAM_STR);
    $ex1->bindParam(":foto",$foto,PDO::PARAM_STR);
    $ex1->bindParam(":telefone",$telefone,PDO::PARAM_STR);
    $ex1->bindParam(":titulo",$titulo,PDO::PARAM_STR);
    $ex1->bindParam(":pai",$pai,PDO::PARAM_STR);
    $ex1->bindParam(":mae",$mae,PDO::PARAM_STR);
    $ex1->bindParam(":provincia",$provincia,PDO::PARAM_STR);
    $ex1->bindParam(":municipio",$municipio,PDO::PARAM_STR);
	$ex1->bindParam(":id_pessoa",$id_pessoaE,PDO::PARAM_STR);
    $ex1->execute();		
if(!$ex1):
echo "erro ao actualizar pessoa";
else:

//actualiza no professores
$ins2="update tbl_professor set nAgente=:agente,titulo=:titulo,categoria_estudo=:cat where id_pessoa=:id_pessoa";
   
    $ex3=$con->prepare($ins2);
    $ex3->bindParam(":agente",$agente,PDO::PARAM_STR);
     $ex3->bindParam(":titulo",$titulo,PDO::PARAM_STR);
	 $ex3->bindParam(":id_pessoa",$id_pessoaE,PDO::PARAM_STR);
          $ex3->bindParam(":cat",$categoria_estudo,PDO::PARAM_STR);
    $ex3->execute(); 
   if(!$ex3):
echo"erro ao actualizar professor";
else:
//actualizar no usuario
$estado="ON";
 $in5="update tbl_user set titulo=:titulo,estado=:estado where id_pessoa=:id_pessoa";
     $ex5=$con->prepare($in5);
     $ex5->bindParam(":titulo",$titulo,PDO::PARAM_STR);
     $ex5->bindParam(":estado",$estado,PDO::PARAM_STR);
	 $ex5->bindParam(":id_pessoa",$id_pessoaE,PDO::PARAM_STR);
     $ex5->execute();
     if(!$ex5):
     echo"erro";
     else:
     
	 //eliminar director
     $in9="delete from tbl_diretores where id_professor=:id_professor and anolectivo=:anolectivo";
     $ex10=$con->prepare($in9);
     $ex10->bindParam(":id_professor",$verE->id_professor,PDO::PARAM_STR);
     $ex10->bindParam(":anolectivo",$ano,PDO::PARAM_STR);
     $ex10->execute();
	 if(!$ex10):
     echo"erro";
     else:
     echo("<div class='alert alert-success'>Dados Actualizados com sucesso!</div>");
     
	 endif;
	 
	
endif;
endif;
endif;
endif;
}

public function director($nome,$agente,$data,$telefone,$bi,$data_emissao,$local_emissao,$genero,$titulo,$curso,$classe,$turma,$turno,$ano,$arquivo,$arquivo_tmp,$pai,$mae,$provincia,$municipio,$id_pessoaE,$fotoE,$categoria_estudo,$con){
$palavra1=$telefone;
$sele="select *from tbl_professor where nAgente=:agente";
     $ex=$con->prepare($sele);
     $ex->bindParam(":agente",$agente,PDO::PARAM_STR);
     $ex->execute(); 
$vex=$ex->fetch(PDO::FETCH_OBJ);
    $contar=$ex->rowCount();
    if(($contar>0)&&($id_pessoaE!=$vex->id_pessoa)):
     print("<div class='alert alert-danger'>Numero de agente ja existente!</div>");
     else:
	 //busca id-professor
	 $covE="select *from view_professor where id_pessoa=:id_pessoa";
			$EcovE=$con->prepare($covE);
			$EcovE->bindParam(":id_pessoa",$id_pessoaE,PDO::PARAM_STR);
			$EcovE->execute();
			$verE=$EcovE->fetch(PDO::FETCH_OBJ);
		if($arquivo==""):
    $foto=$fotoE;
    else:
    $foto=$arquivo;
	//apagar antiga foto
	unlik("fotos_professores/$fotoE");
	//mover a foto nova para a pasta
$destino='fotos_professores/'.$arquivo;
$arquivo_tmp1=$arquivo_tmp;
move_uploaded_file($arquivo_tmp1,$destino);
    endif;
	
	//actualiza aqui
$ins="update tbl_pessoa set nome=:nome,genero=:genero,data_nascimento=:data_nascimento,bi=:bi,data_emissao=:data_emissao,local_emissao=:local_emissao,foto=:foto,telefone=:telefone,titulo=:titulo,pai=:pai,mae=:mae,provincia=:provincia,municipio=:municipio where id_pessoa=:id_pessoa";
   
    $ex1=$con->prepare($ins);
    $ex1->bindParam(":nome",$nome,PDO::PARAM_STR);
    $ex1->bindParam(":genero",$genero,PDO::PARAM_STR);
    $ex1->bindParam(":data_nascimento",$data,PDO::PARAM_STR);
    $ex1->bindParam(":bi",$bi,PDO::PARAM_STR);
    $ex1->bindParam(":data_emissao",$data_emissao,PDO::PARAM_STR);
    $ex1->bindParam(":local_emissao",$local_emissao,PDO::PARAM_STR);
    $ex1->bindParam(":foto",$foto,PDO::PARAM_STR);
    $ex1->bindParam(":telefone",$telefone,PDO::PARAM_STR);
    $ex1->bindParam(":titulo",$titulo,PDO::PARAM_STR);
    $ex1->bindParam(":pai",$pai,PDO::PARAM_STR);
    $ex1->bindParam(":mae",$mae,PDO::PARAM_STR);
    $ex1->bindParam(":provincia",$provincia,PDO::PARAM_STR);
    $ex1->bindParam(":municipio",$municipio,PDO::PARAM_STR);
	$ex1->bindParam(":id_pessoa",$id_pessoaE,PDO::PARAM_STR);
    $ex1->execute();		
if(!$ex1):
echo "erro ao actualizar pessoa";
else:

//actualiza no professores
$ins2="update tbl_professor set nAgente=:agente,titulo=:titulo, categoria_estudo=:cat where id_pessoa=:id_pessoa";
   
    $ex3=$con->prepare($ins2);
    $ex3->bindParam(":agente",$agente,PDO::PARAM_STR);
     $ex3->bindParam(":titulo",$titulo,PDO::PARAM_STR);
	 $ex3->bindParam(":id_pessoa",$id_pessoaE,PDO::PARAM_STR);
         $ex3->bindParam(":cat",$categoria_estudo,PDO::PARAM_STR);
    $ex3->execute(); 
   if(!$ex3):
echo"erro ao actualizar professor";
else:
//actualizar no usuario
$estado="ON";
 $in5="update tbl_user set titulo=:titulo,estado=:estado where id_pessoa=:id_pessoa";
     $ex5=$con->prepare($in5);
     $ex5->bindParam(":titulo",$titulo,PDO::PARAM_STR);
     $ex5->bindParam(":estado",$estado,PDO::PARAM_STR);
	 $ex5->bindParam(":id_pessoa",$id_pessoaE,PDO::PARAM_STR);
     $ex5->execute();
     if(!$ex5):
     echo"erro";
     else:
     
	 //eliminar director
     $in9="delete from tbl_diretores where id_professor=:id_professor and anolectivo=:anolectivo";
     $ex10=$con->prepare($in9);
     $ex10->bindParam(":id_professor",$verE->id_professor,PDO::PARAM_STR);
     $ex10->bindParam(":anolectivo",$ano,PDO::PARAM_STR);
     $ex10->execute();
	 
	 //cadastrar director
     $in9="insert into tbl_diretores(id_professor,id_curso,id_classe,id_turma,id_turno,anolectivo)values(:id_professor,:id_curso,:id_classe,:id_turma,:id_turno,:anolectivo)";
     $ex10=$con->prepare($in9);
     $ex10->bindParam(":id_professor",$verE->id_professor,PDO::PARAM_STR);
     $ex10->bindParam(":id_curso",$curso,PDO::PARAM_STR);
     $ex10->bindParam(":id_classe",$classe,PDO::PARAM_STR);
     $ex10->bindParam(":id_turma",$turma,PDO::PARAM_STR);
     $ex10->bindParam(":id_turno",$turno,PDO::PARAM_STR);
     $ex10->bindParam(":anolectivo",$ano,PDO::PARAM_STR);
     $ex10->execute();
	 
	 
	 if(!$ex10):
     echo"erro";
     else:
     echo("<div class='alert alert-success'>Dados Actualizados com sucesso!</div>");
     
	 endif;
	 
	
endif;
endif;
endif;
endif;
}


}
?>
