<?php
Class Importar_historico{
    public $ID_PESSOA;
    public $ID_ALUNO;
    public $CON;
    public $PROCESSO;




    public function __construct($con) {
        $this->CON=$con;
    }
    
    
   public function buscaIDs($processo){
       $sql="select *from tbl_aluno where processo=:processo";
       try {
       $run=  $this->CON->prepare($sql);
       $run->bindParam(":processo",$processo,PDO::PARAM_STR);
       $run->execute();
       if($run):
       $view=$run->fetch(PDO::FETCH_OBJ);
       $this->ID_ALUNO=$view->id_aluno;
       $this->ID_PESSOA=$view->id_pessoa;
       $this->PROCESSO=$processo;
       $r=1;
       else:
           $r=0;
       endif;
       
       } catch (PDOException $e) {
           echo $e->getMessage();
       }
       return $r; 
   }
   
   public function salva_Historico($r1,$curso,$id_classe,$turma,$id_turno,$ano) {
       if($r1==0):
           echo 'ja foi cadastrado';
       elseif($r1==1):
     $sql2="insert into tbl_historico_aluno(id_pessoa,id_curso,id_classe,id_turma,id_turno,anolectivo,processo,id_aluno) values(:id_pessoa,:id_curso,:id_classe,:id_turma,:id_turno,:anolectivo,:processo,:id_aluno)";
       try{
           $run2=  $this->CON->prepare($sql2);
           $run2->bindParam(":id_pessoa", $this->ID_PESSOA,PDO::PARAM_STR);
           $run2->bindParam(":id_curso", $curso,PDO::PARAM_STR);
           $run2->bindParam(":id_classe", $id_classe,PDO::PARAM_STR);
           $run2->bindParam(":id_turma",$turma ,PDO::PARAM_STR);
           $run2->bindParam(":id_turno", $id_turno,PDO::PARAM_STR);
           $run2->bindParam(":anolectivo", $ano,PDO::PARAM_STR);
           $run2->bindParam(":processo", $this->PROCESSO,PDO::PARAM_STR);
           $run2->bindParam(":id_aluno", $this->ID_ALUNO,PDO::PARAM_STR);
           $run2->execute();
           if($run2):
               echo '<div class="alert alert-success">Cadastro feito com sucesso</div><br/>';
           else:
               echo 'erro';
           endif;
       } catch (PDOException $e) {
echo $e->getMessage();
       }
       
       
       endif;
       
   }
   
    public function sele($r0,$curso,$id_classe,$turma,$id_turno,$ano) {
       if($r0==0):
           echo 'nao encontrou id';
       elseif($r0==1):
     $sql2="select *from tbl_historico_aluno where id_pessoa=:id_pessoa and id_curso=:id_curso and "
               . "id_classe=:id_classe and id_turma=:id_turma and id_turno=:id_turno and "
               . "anolectivo=:anolectivo and processo=:processo and id_aluno=:id_aluno";
       try{
           $run2=  $this->CON->prepare($sql2);
           $run2->bindParam(":id_pessoa", $this->ID_PESSOA,PDO::PARAM_STR);
           $run2->bindParam(":id_curso", $curso,PDO::PARAM_STR);
           $run2->bindParam(":id_classe", $id_classe,PDO::PARAM_STR);
           $run2->bindParam(":id_turma",$turma ,PDO::PARAM_STR);
           $run2->bindParam(":id_turno", $id_turno,PDO::PARAM_STR);
           $run2->bindParam(":anolectivo", $ano,PDO::PARAM_STR);
           $run2->bindParam(":processo", $this->PROCESSO,PDO::PARAM_STR);
           $run2->bindParam(":id_aluno", $this->ID_ALUNO,PDO::PARAM_STR);
           $run2->execute();
           if($run2 && $run2->rowCount()>0):
               return 0;
           elseif($run2 && $run2->rowCount()<=0):
               return 1;
           endif;
       } catch (PDOException $e) {
echo $e->getMessage();
       }
       
       
       endif;
       
   }
   
}
?>
