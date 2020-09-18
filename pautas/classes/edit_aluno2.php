<?php 

class edit_aluno{
    var $ID_aluno; var $ID_pessoa; var $FOTO_aluno; var $FOTO_nova; var $ID_classe; var $ID_curso; var $respDelete=0;
var $CardExitente;
    public function receber_valores($id_pessoaAluno,$id_alunoAluno,$fotoAluno){
    $this-> ID_pessoa=$id_pessoaAluno;
    $this-> ID_aluno=$id_alunoAluno;
    $this-> FOTO_aluno=$fotoAluno;

    $resp=1;
    return $resp;
}

public function config_perfil($resp1,$arquivo,$arquivo_tmp){
    if($resp1==0):
        echo'nao recebeu valores';
    $resp=0;
    else:
        $resp=1;
    if($arquivo==""):
   $this->FOTO_nova=  $this->FOTO_aluno;
else:
    $this->FOTO_nova=$arquivo;
if($this->FOTO_aluno!="none.jpg"):
    unlink('foto_alunos/'.$this->FOTO_aluno.'');

$destino='foto_alunos/'.$arquivo;
$arquivo_tmp1=$arquivo_tmp;
move_uploaded_file($arquivo_tmp1,$destino); 
endif;
endif;
    
    
   
    endif;
    return $resp;
}

public function edita_pessoa($resp2,$con,$nome,$genero,$data,$bi,$emissao,$local_emissao,$telefone,$pai,$mae,$provincia,$municipio,$arquivo){
     $resp=0; $titulo="aluno"; 

   try{
        if($resp2==0):
            echo"nao sera possivel confirmar para o mesmo ano";
        elseif(($resp2!=0) && ($this-> ID_pessoa >0)):
            if($arquivo==""):
                $ft=  $this->FOTO_aluno;
            else:
                $ft=$arquivo;
            endif;
            $ins="update tbl_pessoa set nome=:nome,genero=:genero,data_nascimento=:data_nascimento,bi=:bi,data_emissao=:data_emissao,local_emissao=:local_emissao,foto=:foto,telefone=:telefone,titulo=:titulo,pai=:pai,mae=:mae,provincia=:provincia,municipio=:municipio where id_pessoa=:id_pessoa";
       
            $ex1=$con->prepare($ins);
            $ex1->bindParam(":nome",$nome,PDO::PARAM_STR);
            $ex1->bindParam(":genero",$genero,PDO::PARAM_STR);
            $ex1->bindParam(":data_nascimento",$data,PDO::PARAM_STR);
            $ex1->bindParam(":bi",$bi,PDO::PARAM_STR);
            $ex1->bindParam(":data_emissao",$emissao,PDO::PARAM_STR);
            $ex1->bindParam(":local_emissao",$local_emissao,PDO::PARAM_STR);
            $ex1->bindParam(":foto",$ft,PDO::PARAM_STR);
            $ex1->bindParam(":telefone",$telefone,PDO::PARAM_STR);
            $ex1->bindParam(":titulo",$titulo,PDO::PARAM_STR);
            $ex1->bindParam(":pai",$pai,PDO::PARAM_STR);
            $ex1->bindParam(":mae",$mae,PDO::PARAM_STR);
            $ex1->bindParam(":provincia",$provincia,PDO::PARAM_STR);
            $ex1->bindParam(":municipio",$municipio,PDO::PARAM_STR);
            $ex1->bindParam(":id_pessoa",  $this->ID_pessoa,PDO::PARAM_STR);
            
            if($ex1->execute()):
                echo"<div class='alert alert-success'>Peaple updated successfull</div>";
                $resp=1;
            else:
                echo"<div class='alert alert-success'>Error during create update peaple!</div>";
                $resp=0;
            endif;
        endif;
   } catch (PDOException $ex) {  echo $ex->getMessage();   }
        
    
    return $resp;
}
public function busca_IDs($resp3,$con,$ano){
    $resp=0;
    if($resp3==0):
        echo 'nao editou pessoa';
    else:
       try {
      $sel77="select *from tbl_aluno where id_aluno=:id and anolectivo=:ano";
    $run=$con->prepare($sel77);
    $run->bindParam(":id",  $this->ID_aluno,PDO::PARAM_STR);
    $run->bindParam(":ano",$ano,PDO::PARAM_STR);
    $run->execute();
    if($run):
        $resp=1;
    
    $view=$run->fetch(PDO::FETCH_OBJ);
    $this->CardExitente = $view->cardeneta;
   $this->ID_curso=$view->id_curso;
   $this->ID_classe=$view->id_classe;
    else:
   $resp=0;
    endif;
     
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        
    } 
    endif;
    
    return $resp;
}

public function deleta_notas($resp4,$con,$ano,$classe,$curso){
    $resp=0;  $r=0;
    try{
        if($resp4==0):
            echo 'nao localizou os IDs';
        else:
            if(($classe!=$this->ID_classe)||($curso!=$this->ID_curso)):            
                echo " Classe anti: ".$this->ID_classe." Classe nova: ".$classe." IDCurso: ".$this->ID_curso." Curso novo: ".$curso;
                $se0="delete from tbl_cla_finais where id_aluno=:id and anolectivo=:ano";
                $x0=$con->prepare($se0);
                $x0->bindParam(":id",  $this->ID_aluno,PDO::PARAM_STR);
                $x0->bindParam(":ano",$ano,PDO::PARAM_STR);
                   

                $se="delete from tbl_notas where id_aluno=:id and anoLetivo=:ano";
                $x1=$con->prepare($se);
                $x1->bindParam(":id",  $this->ID_aluno,PDO::PARAM_STR);
                $x1->bindParam(":ano",$ano,PDO::PARAM_STR);
               
                
                $se="delete from tbl_avaliacao where id_aluno=:id and ano=:ano";
                $x2=$con->prepare($se);
                $x2->bindParam(":id",  $this->ID_aluno,PDO::PARAM_STR);
                $x2->bindParam(":ano",$ano,PDO::PARAM_STR);
                
                $se="delete from tbl_provas where id_aluno=:id and ano=:ano";
                $x3=$con->prepare($se);
                $x3->bindParam(":id",  $this->ID_aluno,PDO::PARAM_STR);
                $x3->bindParam(":ano",$ano,PDO::PARAM_STR);
                //$x1->execute(); 
                if(($x0->execute()) && ($x1->execute()) &&($x2->execute())&&($x2->execute()) ):
                    $resp=1;
                    echo"<div class='alert alert-success'>C.Final, TBLNotas, TBLAvaliação e TBLProvas Deleted successfull!</div>";
                    $this-> respDelete=3;
                else:
                    $resp=0;
                endif; 
            elseif(($classe==$this->ID_classe) && ($curso==$this->ID_curso)): 
                $this-> respDelete=1;   
            endif;
        endif;
    } catch (PDOException $e) {    echo $e->getMessage();   }    

   return $this->respDelete; 
}//End function

public function edita_aluno($con,$curso,$classe,$turma,$turno,$ano){
    $resp=0;

    //try{
        if($this-> respDelete ==0):            
            echo"<div class='alert alert-success'>Não salvou disciplina! IDA: ".$this->ID_aluno."</div>";
        elseif($this->respDelete !=0):
            if($this->respDelete == 3):
             $cardeneta="nao"; 
             elseif ($this->respDelete == 1) :
             $cardeneta = $this->CardExitente; 
            endif;
               
            $ins2="update tbl_aluno set id_curso=:id_curso,id_classe=:id_classe,id_turma=:id_turma,id_turno=:id_turno,cardeneta=:cardeneta where anolectivo=:anolectivo and id_aluno=:id_aluno";
            $ex3=$con->prepare($ins2);
            $ex3->bindParam(":id_curso",$curso,PDO::PARAM_STR);
            $ex3->bindParam(":id_classe",$classe,PDO::PARAM_STR);
            $ex3->bindParam(":id_turma",$turma,PDO::PARAM_STR);
            $ex3->bindParam(":id_turno",$turno,PDO::PARAM_STR);
            $ex3->bindParam(":cardeneta",$cardeneta,PDO::PARAM_STR);
            $ex3->bindParam(":anolectivo",$ano,PDO::PARAM_STR);
            $ex3->bindParam(":id_aluno",  $this->ID_aluno,PDO::PARAM_STR);
            
            if($ex3->execute()):
                echo"<div class='alert alert-success'>T.BAluno updated successfull! ID.Classe nova: ".$classe."</div>";
                $resp=1;
            else:
                $resp=0;
            endif;
        endif;
        
    //} catch (PDOException $ex){  echo $ex->getMessage();   }
    
    return $resp;   
}//End function
public function edita_historico($resp6,$con,$curso,$classe,$turma,$turno,$ano){
   // try {
        if($resp6==0):
            echo'nao editou aluno';
        else:
           
              $ins2="update tbl_historico_aluno set id_curso=:id_curso,id_classe=:id_classe,id_turma=:id_turma,id_turno=:id_turno where id_pessoa=:id_pessoa and anolectivo=:anolectivo";
        $ex3=$con->prepare($ins2);
        $ex3->bindParam(":id_curso",$curso,PDO::PARAM_STR);
        $ex3->bindParam(":id_classe",$classe,PDO::PARAM_STR);
        $ex3->bindParam(":id_turma",$turma,PDO::PARAM_STR);
        $ex3->bindParam(":id_turno",$turno,PDO::PARAM_STR);
        $ex3->bindParam(":id_pessoa",  $this->ID_pessoa,PDO::PARAM_STR);
        $ex3->bindParam(":anolectivo",$ano,PDO::PARAM_STR);
            if($ex3->execute()):
                 echo"<div class='alert alert-success'>Dados modificados com sucesso!</div>";
                 //echo '<meta http-equiv="refresh" content="1"/>';           
            else:
                echo 'nao editou historico';
            endif;
        endif;
    //} catch (PDOException $ex){ echo $ex->getMessage();  }
    
}//End function
    



}


?>
