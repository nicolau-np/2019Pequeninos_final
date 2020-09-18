<?php

Class Importar_dados{
  public $CON;
  public $PROCESSO;
  public $ID_PESSOA;
  public $ID_ALUNO;
  
    public function __construct($con) {
        $this->CON=$con;
     
    }
    
    public function salvar_pessoa($nome,$genero,$data_nas,$bi,$data_emi,$fot,$telefone,$titulo,$pai,$mae,$provincia,$municipio,$processo,$local_emi){
$ins="insert into tbl_pessoa (nome,genero,data_nascimento,bi,data_emissao,local_emissao,foto,telefone,titulo,pai,mae,provincia,municipio,camp)values(:nome,:genero,:data_nascimento,:bi,:data_emissao,:local_emissao,:foto,:telefone,:titulo,:pai,:mae,:provincia,:municipio,:camp)";
   try{
     $ex1=$this->CON->prepare($ins);
    $ex1->bindParam(":nome",$nome,PDO::PARAM_STR);
    $ex1->bindParam(":genero",$genero,PDO::PARAM_STR);
    $ex1->bindParam(":data_nascimento",$data_nas,PDO::PARAM_STR);
    $ex1->bindParam(":bi",$processo,PDO::PARAM_STR);
    $ex1->bindParam(":data_emissao",$data_emi,PDO::PARAM_STR);
    $ex1->bindParam(":local_emissao",$local_emi,PDO::PARAM_STR);
    $ex1->bindParam(":foto",$fot,PDO::PARAM_STR);
    $ex1->bindParam(":telefone",$telefone,PDO::PARAM_STR);
    $ex1->bindParam(":titulo",$titulo,PDO::PARAM_STR);
    $ex1->bindParam(":pai",$pai,PDO::PARAM_STR);
    $ex1->bindParam(":mae",$mae,PDO::PARAM_STR);
    $ex1->bindParam(":provincia",$provincia,PDO::PARAM_STR);
    $ex1->bindParam(":municipio",$municipio,PDO::PARAM_STR);
    $ex1->bindParam(":camp",$processo,PDO::PARAM_STR);
    $ex1->execute();
    if($ex1):
        $r=1;
        $this->PROCESSO=$processo;
    else:
        $r=0;
    endif;
      
   } catch (PDOException $e) {
echo $e->getMessage();
   }
 return $r;
    }
    
    public function busca_IDPESSOA($r1) {
        if($r1==0):
         echo 'nao cadastrou pessoa';
        
        elseif($r1==1):
               $pes="select *from tbl_pessoa where camp=:camp";
        try{
           $ex2=$this->CON->prepare($pes);
$ex2->bindParam(":camp",  $this->PROCESSO,PDO::PARAM_STR);
$ex2->execute();
$ver=$ex2->fetch(PDO::FETCH_OBJ);
$this->ID_PESSOA=$ver->id_pessoa; 
if($ex2):
    $r=1;
else:
    $r=0;
endif;
        } catch (PDOException $e) {
echo $e->getMessage();
        }  
        endif;
   
        return $r;
    }
    
    public function salvar_aluno($r2,$id_classe,$turma,$id_turno,$curso,$cardeneta,$ano) {
      
        if($r2==0):
            echo 'nao buscou IDpessoa';
        elseif($r2==1):
            $ins2="insert into tbl_aluno (id_pessoa,id_curso,id_classe,id_turma,id_turno,anolectivo,processo,cardeneta)values(:id_pessoa,:id_curso,:id_classe,:id_turma,:id_turno,:anolectivo,:processo,:cardeneta)";
   try{
       $ex3=$this->CON->prepare($ins2);
    $ex3->bindParam(":id_pessoa",$this->ID_PESSOA,PDO::PARAM_STR);
    $ex3->bindParam(":id_curso",$curso,PDO::PARAM_STR);
    $ex3->bindParam(":id_classe",$id_classe,PDO::PARAM_STR);
    $ex3->bindParam(":id_turma",$turma,PDO::PARAM_STR);
    $ex3->bindParam(":id_turno",$id_turno,PDO::PARAM_STR);
    $ex3->bindParam(":anolectivo",$ano,PDO::PARAM_STR);
    $ex3->bindParam(":processo",$this->PROCESSO,PDO::PARAM_STR);
	$ex3->bindParam(":cardeneta",$cardeneta,PDO::PARAM_STR);
    $ex3->execute();
    if($ex3):
        $r=1;
        else: 
          $r=0;  
   endif;
   } catch (PDOException $e) {
echo $e->getMessage();
   }
    
        endif;
        
        return $r;
    }
    
    public function chama_confirmacao($r3) {
        if($r3==0):
            echo 'nao cadastrou aluno';
        else:
            echo '<div class="alert alert-success">Cadastro feito com sucesso</div>';
        endif;
    }
    
    
}
?>