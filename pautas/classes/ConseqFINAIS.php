<?php

class ConseqFINAIS {
    private $con;
    private $stmt;
    private $quantDisciplinas;
    private $obs;
    private $obs2;
    private $resposta;

    
    function getCon() {
        return $this->con;
    }

    function setCon($con) {
        $this->con = $con;
    }
    
    function getQuantDisciplinas() {
        return $this->quantDisciplinas;
    }

        
    function __construct() {
        $this->obs = "Aluno Novo";
        $this->obs2 ="Nao Transita";
    }

    public function buscarQuantDisciplinas($curso, $classe){
        $this->sql = "select *from view_disciplinas where curso=:curso and classe=:classe";
        try {
            $this->stmt = $this->getCon()->prepare($this->sql);
            $this->stmt->bindParam(":curso", $curso, PDO::PARAM_STR);
            $this->stmt->bindParam(":classe", $classe, PDO::PARAM_STR);
            $this->stmt->execute();
            if($this->stmt):
            $this->quantDisciplinas = $this->stmt->rowCount();  
            endif;
        } catch (PDOException $ex) {
            echo ''.$ex;  
        } 
    }
    
    public function verificarESTADO($ano, $id_aluno){
        $this->resposta = null;
        $this->sql = "select *from view_clas_finais where anolectivo=:ano and "
                . "id_aluno=:id and observacao!=:ob";
        try {
            $this->stmt = $this->getCon()->prepare($this->sql);
            $this->stmt->bindParam(":ano", $ano, PDO::PARAM_STR);
            $this->stmt->bindParam(":id", $id_aluno, PDO::PARAM_STR);
            $this->stmt->bindParam(":ob", $this->obs, PDO::PARAM_STR);
            $this->stmt->execute();
            if($this->stmt):
            $this->resposta = $this->stmt->rowCount();
            endif;
        } catch (PDOException $ex) {
            echo ''.$ex;  
        }
        return $this->resposta;
    }
    
    public function verificarTRANSITAR($ano, $id_aluno) {
        $this->resposta = null;
        $this->sql = "select *from view_clas_finais where anolectivo=:ano and "
                . "id_aluno=:id and observacao=:ob";   
        try{
            $this->stmt = $this->getCon()->prepare($this->sql);
            $this->stmt->bindParam(":ano", $ano, PDO::PARAM_STR);
            $this->stmt->bindParam(":id", $id_aluno, PDO::PARAM_STR);
            $this->stmt->bindParam(":ob", $this->obs2, PDO::PARAM_STR);
            $this->stmt->execute();
            if($this->stmt):
            $this->resposta = $this->stmt->rowCount();
            endif;
        } catch (PDOException $ex) {
            echo ''.$ex;
        }
      
        return $this->resposta;
    }
    
    public function atualizaHistorico($estado, $id_aluno, $ano){
        $this->resposta = null;
        $this->sql = "update tbl_historico_aluno set aproveitamento=:apro where"
                . " id_aluno=:id_aluno and anolectivo=:ano";
        try{
            $this->stmt = $this->getCon()->prepare($this->sql);
            $this->stmt->bindParam(":apro", $estado, PDO::PARAM_STR);
            $this->stmt->bindParam(":id_aluno", $id_aluno, PDO::PARAM_STR);
            $this->stmt->bindParam(":ano", $ano, PDO::PARAM_STR);
            $this->stmt->execute();
            if($this->stmt):
            $this->resposta = "yes";
            endif;
        } catch (PDOException $ex) {
            echo ''.$ex;

        }
        return $this->resposta;
                
    }

}
