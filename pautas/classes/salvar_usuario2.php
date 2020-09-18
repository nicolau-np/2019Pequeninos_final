<?php

class salvar_usuario{
   var $ID_usuario; var $ID_pessoa; var $CON; var $Titulo; var $Foto;
public function receber_valores($con,$titulo){
    $this->CON=$con; 
    $this->Titulo=$titulo;
    $resp=1;
    return $resp;
}
public function verifica_senha($resp1,$palavra1,$palavra2){
    if($resp1==0):
        echo'nao recebeu valores';
    else:
        if($palavra1!=$palavra2):
            $resp=0;
        else:
       $resp=1;
        endif;
    endif;
    
    return $resp;
}

public function verifica_pessoa($resp2,$arquivo,$nome){
    if($resp2==0):
        echo("<div class='alert alert-danger'>Confirmação de Palavra-Passe incorreta!</div>");
$resp=0;
    else:  
    $se="select *from tbl_pessoa where nome=:nome";
     $ex=$this->CON->prepare($se);
     $ex->bindParam(":nome",$nome,PDO::PARAM_STR);
     $ex->execute();
     $contar=$ex->rowCount();
     if($contar>0):
     echo("<div class='alert alert-danger'>Usuário já cadastrado!</div>");
     $resp=0;
     else:
       $resp=1;
     if($arquivo==""):
         $this->Foto="none.jpg";
     else:
         $this->Foto=$arquivo;
     endif;
     endif;
    endif;
    
    return $resp;
}

public function salvar_pessoa($resp3,$nome,$arquivo,$arquivo_tmp,$bi){
    if($resp3==0):
        echo'usuario ja existente ou senha incorrecta';
    else:
        
        try{
         $in="insert into tbl_pessoa(nome,titulo,foto,bi) values(:nome,:titulo,:foto,:bi)";
     $ex1=$this->CON->prepare($in);
     $ex1->bindParam(":nome",$nome,PDO::PARAM_STR);
     $ex1->bindParam(":titulo",  $this->Titulo,PDO::PARAM_STR);
     $ex1->bindParam(":foto",$this->Foto,PDO::PARAM_STR);
     $ex1->bindParam(":bi",$bi,PDO::PARAM_STR);
     $ex1->execute();
     if($ex1):
         $resp=1;
     $destino='fotos_usuarios/'.$arquivo;
$arquivo_tmp1=$arquivo_tmp;
move_uploaded_file($arquivo_tmp1,$destino);
     else:
         $resp=0;
     endif;
        } catch (PDOException $ex) {
echo $ex->getMessage();
        }
      
    endif;
    
    return $resp;
}

public function buscar_IDpessoa($resp4,$nome,$estado){
    if($resp4==0):
        echo'nao salvou pessoa';
    else:
        try{
         $se1="select *from tbl_pessoa where nome=:nome and titulo=:titulo";
     $ex2=$this->CON->prepare($se1);
     $ex2->bindParam(":nome",$nome,PDO::PARAM_STR);
     $ex2->bindParam(":titulo",  $this->Titulo,PDO::PARAM_STR);
     $ex2->execute();
     if($ex2):
        $ver88=$ex2->fetch(PDO::FETCH_OBJ);
        $this->ID_pessoa=$ver88->id_pessoa;
           try{
        $in2="insert into tbl_user(id_pessoa,titulo,estado) values(:id_pessoa,:titulo,:estado)";
     $ex3=$this->CON->prepare($in2);
     $ex3->bindParam(":id_pessoa",  $ver88->id_pessoa,PDO::PARAM_STR);
      $ex3->bindParam(":titulo",$this->Titulo,PDO::PARAM_STR);
     $ex3->bindParam(":estado",$estado,PDO::PARAM_STR);
     $ex3->execute();
     if($ex3):
         $resp=1;
     else:
         $resp=0;
     endif;
        } catch (PDOException $ex) {
echo $ex->getMessage();
        }
        else: 
          $resp=0;    
     endif;
    
        } catch (PDOException $ex) {
echo $ex->getMessage();
        }
       
    endif;
    
    return $resp;
}


public function buscar_IDusuario($resp5){
    if($resp5==0):
        echo'nao inseriu a pessoa';
    else:
        try{
        $se4="select *from tbl_user where id_pessoa=:id";
     $ex4=$this->CON->prepare($se4);
     $ex4->bindParam(":id",  $this->ID_pessoa,PDO::PARAM_STR);
     $ex4->execute();
     if($ex4):
     $ver2=$ex4->fetch(PDO::FETCH_OBJ);
     $this->ID_usuario=$ver2->id_user;
     $resp=1;
     else :
         $resp=0;
     endif;
        } catch (PDOException $ex) {
echo $ex->getMessage();
        }
    
    endif;
    
    return $resp;
}
public function salvar_senha($resp6,$palavra1){
  if($resp6==0):
      echo'nao buscou idusuario';
  else:
      try{
      $palavraMD5=md5($palavra1);
     $in5="insert into tbl_senhas(id_user,senha) values(:id_user,:senha)";
     $ex6=$this->CON->prepare($in5);
     $ex6->bindParam(":id_user",$this->ID_usuario,PDO::PARAM_STR);
     $ex6->bindParam(":senha",$palavraMD5,PDO::PARAM_STR);
     $ex6->execute();
     
     if(!$ex6):
     echo"nao salvou senha";
     else:
          echo("<div class='alert alert-success'>Cadastro feito com sucesso!</div>");
 
     endif;
      } catch (PDOException $ex) {
echo $ex->getMessage();
      }
      
  endif;  
}
        
    
}

?>

