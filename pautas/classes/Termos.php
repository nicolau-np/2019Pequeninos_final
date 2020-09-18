<?php

class Termos {
private $con;
private $sql;
private $stmt;
private $id_aluno;
private $ano_lectivo;
private $resposta;

function getCon() {
    return $this->con;
}

function getId_aluno() {
    return $this->id_aluno;
}

function getAno_lectivo() {
    return $this->ano_lectivo;
}

function setCon($con) {
    $this->con = $con;
}

function setId_aluno($id_aluno) {
    $this->id_aluno = $id_aluno;
}

function setAno_lectivo($ano_lectivo) {
    $this->ano_lectivo = $ano_lectivo;
}



    public function buscaHist(){
        $this->resposta = null;
        $this->sql="select *from view_historico where id_aluno=:id and anolectivo=:ano";
        try{
            $this->stmt=  $this->getCon()->prepare($this->sql);
            $this->stmt->bindParam(":id", $this->getId_aluno(), PDO::PARAM_STR);
            $this->stmt->bindParam(":ano", $this->getAno_lectivo(), PDO::PARAM_STR);
            $this->stmt->execute();
            if($this->stmt && $this->stmt->rowCount()>0):
            $this->resposta = $this->stmt;
            endif;
                    
        } catch (PDOException $ex) {
            echo ''.$ex;
        }
        return $this->resposta;
    }
    
    public function buscaDisciplinas($curso, $classe){
        $this->resposta = null;
        $this->sql = "select *from view_disciplinas where curso=:curso and classe=:classe";
        try {
            $this->stmt = $this->getCon()->prepare($this->sql);
            $this->stmt->bindParam(":curso", $curso, PDO::PARAM_STR);
            $this->stmt->bindParam(":classe", $classe, PDO::PARAM_STR);
            $this->stmt->execute();
            if($this->stmt && $this->stmt->rowCount()>0):
            $this->resposta = $this->stmt;
            endif;
        } catch (PDOException $ex) {
            echo ''.$ex;
        }
        return $this->resposta;
    }
    
    public function buscaNotas($disciplina, $epoca) {
        $this->resposta = null;
        $this->sql = "select *from view_notas where id_aluno=:id and anoLetivo=:ano "
                . "and disciplina=:disciplina and epoca=:epoca";
        try {
            $this->stmt = $this->getCon()->prepare($this->sql);
            $this->stmt->bindParam(":id", $this->getId_aluno(), PDO::PARAM_STR);
            $this->stmt->bindParam(":ano", $this->getAno_lectivo(), PDO::PARAM_STR);
            $this->stmt->bindParam(":disciplina", $disciplina, PDO::PARAM_STR);
            $this->stmt->bindParam(":epoca", $epoca, PDO::PARAM_STR);
            $this->stmt->execute();
            if($this->stmt && $this->stmt->rowCount()>0):
            $this->resposta = $this->stmt;
            endif;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }

        return $this->resposta;
    }
    
    public function buscaClaFinais($disciplina) {
        $this->resposta = null;
        $this->sql = "select *from view_clas_finais where id_aluno=:id and disciplina=:disciplina and anolectivo=:ano";
        try{
            $this->stmt = $this->getCon()->prepare($this->sql);
            $this->stmt->bindParam(":id", $this->getId_aluno(), PDO::PARAM_STR);
            $this->stmt->bindParam(":disciplina", $disciplina, PDO::PARAM_STR);
            $this->stmt->bindParam(":ano", $this->getAno_lectivo(), PDO::PARAM_STR);
            $this->stmt->execute();
            if($this->stmt && $this->stmt->rowCount()>0):
            $this->resposta = $this->stmt;
            endif;
        } catch (PDOException $ex) {
            echo $ex->getMessage();

        }
        return $this->resposta;
        
    }
            
}
