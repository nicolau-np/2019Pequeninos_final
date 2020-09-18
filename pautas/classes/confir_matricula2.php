<?php 

class confirm_matricula{
    
var $ID_Pessoa; var $ID_Aluno; var $Foto; var $Titulo; var $Foto_nova;

public function recebe_valores($id_alunoAluno,$id_pessoaAluno,$fotoAluno,$titulo){
    $this->ID_Pessoa=$id_pessoaAluno;
    $this->ID_Aluno=$id_alunoAluno;
    $this->Foto=$fotoAluno;
    $this->Titulo=$titulo;
    $resp=1;
    return $resp;
}

public function verifica_ano($resp1,$ano,$ano_antigo,$arquivo,$arquivo_tmp){
   if($resp1==1):
     if(($ano==$ano_antigo)||($ano<$ano_antigo)):
    echo"<div class='alert alert-danger'>Já está confirmado para este ano!</div>";
$resp=0;
else:
    $resp=1;

if($arquivo==""):
   $this->Foto_nova=  $this->Foto;
else:
    $this->Foto_nova=$arquivo;
if($this->Foto!="none.jpg"):
    unlink('foto_alunos/'.$this->Foto.'');

$destino='foto_alunos/'.$arquivo;
$arquivo_tmp1=$arquivo_tmp;
move_uploaded_file($arquivo_tmp1,$destino); 
endif;
endif;


endif;
       
       
   endif;
   
   return $resp;
}

public function edita_pessoa($resp2,$con,$nome,$genero,$data,$bi,$emissao,$local_emissao,$telefone,$titulo,$pai,$mae,$provincia,$municipio){
    if($resp2==0):
        echo"nao sera possivel confirmar para o mesmo ano";
    else:
   try{
        $ins="update tbl_pessoa set nome=:nome,genero=:genero,data_nascimento=:data_nascimento,bi=:bi,data_emissao=:data_emissao,local_emissao=:local_emissao,foto=:foto,telefone=:telefone,titulo=:titulo,pai=:pai,mae=:mae,provincia=:provincia,municipio=:municipio where id_pessoa=:id_pessoa";
   
    $ex1=$con->prepare($ins);
    $ex1->bindParam(":nome",$nome,PDO::PARAM_STR);
    $ex1->bindParam(":genero",$genero,PDO::PARAM_STR);
    $ex1->bindParam(":data_nascimento",$data,PDO::PARAM_STR);
    $ex1->bindParam(":bi",$bi,PDO::PARAM_STR);
    $ex1->bindParam(":data_emissao",$emissao,PDO::PARAM_STR);
    $ex1->bindParam(":local_emissao",$local_emissao,PDO::PARAM_STR);
    $ex1->bindParam(":foto",  $this->Foto_nova,PDO::PARAM_STR);
    $ex1->bindParam(":telefone",$telefone,PDO::PARAM_STR);
    $ex1->bindParam(":titulo",$titulo,PDO::PARAM_STR);
    $ex1->bindParam(":pai",$pai,PDO::PARAM_STR);
    $ex1->bindParam(":mae",$mae,PDO::PARAM_STR);
    $ex1->bindParam(":provincia",$provincia,PDO::PARAM_STR);
    $ex1->bindParam(":municipio",$municipio,PDO::PARAM_STR);
    $ex1->bindParam(":id_pessoa",  $this->ID_Pessoa,PDO::PARAM_STR);
    $ex1->execute();
    if($ex1):
        $resp=1;
    else:
        $resp=0;
    endif;
   } catch (PDOException $ex) {
echo $ex->getMessage();
   }
        
    endif;
    return $resp;
}

public function editar_aluno($resp4,$con,$curso,$classe,$turma,$turno,$ano){
    if($resp4==0):
        echo'nao cadastrou as disciplinas';
    else:
        $cardeneta="nao";
        try {
           $ins2="update tbl_aluno set id_curso=:id_curso,id_classe=:id_classe,id_turma=:id_turma,id_turno=:id_turno,cardeneta=:cardeneta, anolectivo=:anolectivo where id_aluno=:id_aluno";
 $ex3=$con->prepare($ins2);
    $ex3->bindParam(":id_curso",$curso,PDO::PARAM_STR);
    $ex3->bindParam(":id_classe",$classe,PDO::PARAM_STR);
    $ex3->bindParam(":id_turma",$turma,PDO::PARAM_STR);
    $ex3->bindParam(":id_turno",$turno,PDO::PARAM_STR);
   $ex3->bindParam(":cardeneta",$cardeneta,PDO::PARAM_STR);
   $ex3->bindParam(":anolectivo",$ano,PDO::PARAM_STR);
   $ex3->bindParam(":id_aluno",  $this->ID_Aluno,PDO::PARAM_STR);
    $ex3->execute(); 
    if($ex3):
        $resp=1;
    else:
        $resp=0;
    endif;
        } catch (PDOException $ex) {
           echo $ex->getMessage();
        }

    endif;
    
    return $resp;
}

public function edita_historico($resp5,$con,$curso,$classe,$turma,$turno,$ano){
    if($resp5==0):
        echo'nao editou o aluno';
    else:
      try{
       $ins2="insert into tbl_historico_aluno (id_pessoa,id_curso,id_classe,id_turma,id_turno,anolectivo,id_aluno)values(:id_pessoa,:id_curso,:id_classe,:id_turma,:id_turno,:anolectivo,:id_aluno)";
   
    $ex3=$con->prepare($ins2);
    $ex3->bindParam(":id_pessoa",$this->ID_Pessoa,PDO::PARAM_STR);
    $ex3->bindParam(":id_curso",$curso,PDO::PARAM_STR);
    $ex3->bindParam(":id_classe",$classe,PDO::PARAM_STR);
    $ex3->bindParam(":id_turma",$turma,PDO::PARAM_STR);
    $ex3->bindParam(":id_turno",$turno,PDO::PARAM_STR);
    $ex3->bindParam(":anolectivo",$ano,PDO::PARAM_STR);
    $ex3->bindParam(":id_aluno",  $this->ID_Aluno,PDO::PARAM_STR);
    $ex3->execute();  
    if($ex3):
        $resp=1;
    else:
        $resp=0;
    endif;
    } catch (PDOException $ex) {
echo $ex->getMessage();
    }    
    endif;
  
    
    return $resp;
}

public function salvar_meses($resp6,$con,$ano){
    if($resp6==0):
        echo'nao editou o historico';
    else:
        $sql3="select *from tb_folha";
              
                $resul3=$con->prepare($sql3);
                $resul3->execute(); 
                $pago="nao";
                
                
                while($mostra5=$resul3->fetch(PDO::FETCH_OBJ))
                {
                    $mes=$mostra5->tipo_prova." Trimestre";
                    $sql="insert into tbl_pagamento (id_aluno,mes,ano_lectivo,pago)values(:id_aluno,:mes,:ano_lectivo,:pago)";
               
                        $result=$con->prepare($sql);
                        $result->bindParam(":id_aluno",  $this->ID_Aluno,PDO::PARAM_STR);
                        $result->bindParam(":mes",$mes,PDO::PARAM_STR);
                        $result->bindParam(":ano_lectivo",$ano,PDO::PARAM_STR);
                        $result->bindParam(":pago",$pago,PDO::PARAM_STR);
                        
                        $result->execute();
                   
                    
                } 
                if($result):
                    echo"<div class='alert alert-success'>Confirmação feita com sucesso!</div>";
                 echo '<meta http-equiv="refresh" content="1"/>';
                
                else:
                    echo'nao salvou os meses';
                endif;
    endif;
}
        
}


?>
