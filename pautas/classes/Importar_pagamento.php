<?php
Class Importar_pagamento{
    public $ID_ALUNO;
    public $CON;




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
       $r=1;
       else:
           $r=0;
       endif;
       
       } catch (PDOException $e) {
           echo $e->getMessage();
       }
       return $r; 
   }
   
   public function salva_Pagamento($r1, $mes, $data_pagamento, $ano_lectivo, $cliente, $valor,$valor_total,$usuario,$pago,$nfatura,$hora) {
       if($r1==0):
           echo 'ja cadastrou';
       elseif($r1==1):
     $sql2="insert into tbl_pagamento(mes,data_pagamento,ano_lectivo,cliente,valor,valor_total,usuario,pago,nfatura,hora,id_aluno) values(:mes,:data_pagamento,:ano_lectivo,:cliente,:valor,:valor_total,:usuario,:pago,:nfatura,:hora,:id_aluno)";
       try{
           $run2=  $this->CON->prepare($sql2);
           $run2->bindParam(":mes", $mes,PDO::PARAM_STR);
           $run2->bindParam(":data_pagamento", $data_pagamento,PDO::PARAM_STR);
           $run2->bindParam(":ano_lectivo", $ano_lectivo,PDO::PARAM_STR);
           $run2->bindParam(":cliente",$cliente ,PDO::PARAM_STR);
           $run2->bindParam(":valor", $valor,PDO::PARAM_STR);
           $run2->bindParam(":valor_total", $valor_total,PDO::PARAM_STR);
           $run2->bindParam(":usuario", $usuario,PDO::PARAM_STR);
           $run2->bindParam(":pago", $pago,PDO::PARAM_STR);
           $run2->bindParam(":nfatura", $nfatura,PDO::PARAM_STR);
           $run2->bindParam(":hora", $hora,PDO::PARAM_STR);
           $run2->bindParam(":id_aluno", $this->ID_ALUNO,PDO::PARAM_STR);
           $run2->execute();
           if($run2):
               echo '<div class="alert alert-info">Cadastro feito com sucesso</div><br/>';
           else:
               echo 'erro';
           endif;
       } catch (PDOException $e) {
echo $e->getMessage();
       }
       
       
       endif;
       
   }
   
   public function sele($r1, $mes, $data_pagamento, $ano_lectivo, $cliente, $valor,$valor_total,$usuario,$pago,$nfatura,$hora) {
       if($r1==0):
           echo 'nao encontrou id';
       elseif($r1==1):
     $sql2="select *from tbl_pagamento where mes=:mes and data_pagamento=:data_pagamento and ano_lectivo=:ano_lectivo "
               . "and cliente=:cliente and valor=:valor and valor_total=:valor_total and usuario=:usuario "
               . "and pago=:pago and nfatura=:nfatura and hora=:hora and id_aluno=:id_aluno";
       try{
           $run2=  $this->CON->prepare($sql2);
           $run2->bindParam(":mes", $mes,PDO::PARAM_STR);
           $run2->bindParam(":data_pagamento", $data_pagamento,PDO::PARAM_STR);
           $run2->bindParam(":ano_lectivo", $ano_lectivo,PDO::PARAM_STR);
           $run2->bindParam(":cliente",$cliente ,PDO::PARAM_STR);
           $run2->bindParam(":valor", $valor,PDO::PARAM_STR);
           $run2->bindParam(":valor_total", $valor_total,PDO::PARAM_STR);
           $run2->bindParam(":usuario", $usuario,PDO::PARAM_STR);
           $run2->bindParam(":pago", $pago,PDO::PARAM_STR);
           $run2->bindParam(":nfatura", $nfatura,PDO::PARAM_STR);
           $run2->bindParam(":hora", $hora,PDO::PARAM_STR);
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
