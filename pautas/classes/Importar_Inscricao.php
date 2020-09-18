<?php
class Importar_Inscricao {
public $ID_ALUNO; 
public $CON;
public $HORA;
public $PAGO;

public function __construct($con) {
    $this->CON=$con;
    $this->HORA=date("H:i:s");
    $this->PAGO="pago";
}
public function buscIDs($processo) {
    $sql="select *from tbl_aluno where processo=:pro";
    try{
        $run=  $this->CON->prepare($sql);
        $run->bindParam(":pro",$processo,PDO::PARAM_STR);
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


public function salvar_inscricao($r1,$valor,$ano,$data) {
    if($r1==0):
        echo 'ja cadastrou';
    elseif($r1==1):
        $sql2="insert into tbl_inscricao (id_aluno,estado,hora,data,valor,ano) values (:id_aluno,:estado,:hora,:data,:valor,:ano)";
        try {
            $run=  $this->CON->prepare($sql2);
            $run->bindParam(":id_aluno",  $this->ID_ALUNO,PDO::PARAM_STR);
            $run->bindParam(":estado",  $this->PAGO,PDO::PARAM_STR);
            $run->bindParam(":hora",  $this->HORA,PDO::PARAM_STR);
            $run->bindParam(":data",  $data,PDO::PARAM_STR);
            $run->bindParam(":valor",  $valor,PDO::PARAM_STR);
            $run->bindParam(":ano",  $ano,PDO::PARAM_STR);
            $run->execute();
            if($run):
                echo '<div class="alert alert-warning">Cadastro feito com sucesso</div><br/>';
            endif;
        } catch (PDOException $e) {
          echo $e->getMessage();  
        }   
    endif;
}

public function sele($r1,$valor,$ano,$data) {
    if($r1==0):
        echo 'nao buscou ID';
    elseif($r1==1):
        $sql2="select *from tbl_inscricao where id_aluno=:id_aluno and estado=:estado"
            . " and hora=:hora and data=:data and valor=:valor and ano=:ano";
        try {
            $run=  $this->CON->prepare($sql2);
            $run->bindParam(":id_aluno",  $this->ID_ALUNO,PDO::PARAM_STR);
            $run->bindParam(":estado",  $this->PAGO,PDO::PARAM_STR);
            $run->bindParam(":hora",  $this->HORA,PDO::PARAM_STR);
            $run->bindParam(":data",  $data,PDO::PARAM_STR);
            $run->bindParam(":valor",  $valor,PDO::PARAM_STR);
            $run->bindParam(":ano",  $ano,PDO::PARAM_STR);
            $run->execute();
            if($run && $run->rowCount()>0):
                return 0;
            elseif($run && $run->rowCount()<=0):
                return 1;
            endif;
        } catch (PDOException $e) {
          echo $e->getMessage();  
        }   
    endif;
}

}
?>
