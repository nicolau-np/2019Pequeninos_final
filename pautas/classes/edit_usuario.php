<?php
class edit_usuario{
var $CON;
var $Titulo;
var $ID_user;
var $ID_pessoa;
var $Foto;
var $Foto_nova;
    public function receber_valores($con,$titulo,$id_user89,$id_pessoa89,$foto89) {
        $this->CON=$con;
        $this->Titulo=$titulo;
        $this->ID_user=$id_user89;
        $this->ID_pessoa=$id_pessoa89;
        $this->Foto=$foto89;
        
        $resp=1;
        return $resp;
    }
    
    public function config_perfil($resp1,$arquivo,$arquivo_tmp){
    if($resp1==0):
        echo'nao recebeu valores';
    $resp=0;
    else:
        $resp=1;
     if($this->Foto!=$arquivo):
         $this->Foto_nova=$arquivo;
if($this->Foto!="none.jpg"):
    unlink('fotos_usuarios/'.$this->Foto.'');
endif;
$destino='fotos_usuarios/'.$arquivo;
$arquivo_tmp1=$arquivo_tmp;
move_uploaded_file($arquivo_tmp1,$destino); 
else:
    $this->Foto_nova=  $this->Foto;
endif;
    endif;
    return $resp;
}

public function editar_pessoa($resp2,$nome){
if($resp2==0):
    echo'nao guardou foto';
else:
    try {
        $sql1="update tbl_pessoa set nome=:nome, titulo=:titulo, foto=:foto where id_pessoa=:id_pessoa";
        $run=$this->CON->prepare($sql1);
        $run->bindParam(":nome",$nome,PDO::PARAM_STR);
        $run->bindParam(":titulo",$this->Titulo,PDO::PARAM_STR);
        $run->bindParam(":foto",$this->Foto_nova,PDO::PARAM_STR);
        $run->bindParam(":id_pessoa",$this->ID_pessoa,PDO::PARAM_STR);
        $run->execute();
        if($run){
            $resp=1;
            
        }
        else{
            $resp=0;
        }
    } catch (PDOException $ex) {
      echo $ex->getMessage();  
    }
endif;
return $resp;
}

public function editar_user($resp3,$estado){
  if($resp3==0) :
      echo'nao editou pessoa';
  else:
      try {
        $sql2="update tbl_user set estado=:estado,titulo=:titulo where id_user=:id_user";
  $run2=  $this->CON->prepare($sql2);
  $run2->bindParam(":estado",$estado,PDO::PARAM_STR);
  $run2->bindParam(":titulo",  $this->Titulo,PDO::PARAM_STR);
  $run2->bindParam(":id_user",  $this->ID_user,PDO::PARAM_STR);
  $run2->execute();
  if($run2):
      echo'<div class="alert alert-success">Usuario Editado com sucesso</div>';
   echo '<meta http-equiv="refresh" content="1"/>';
      else:
      echo'nao editou pessoa';
  endif;
      } catch (PDOException $ex) {
         echo $ex->getMessage(); 
      }
      
  endif; 
}

    
    

}


?>

