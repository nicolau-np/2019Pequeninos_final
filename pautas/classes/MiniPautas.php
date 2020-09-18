<?php

class MiniPautas {

private $con;
private $stmt;
private $sql;
private $view;
private $resposta;
private $ano;

function getCon() {
    return $this->con;
}

function getAno() {
    return $this->ano;
}

function setCon($con) {
    $this->con = $con;
}

function setAno($ano) {
    $this->ano = $ano;
}

public function buscaDisciplinas($curso, $classe, $con) {
    $this->resposta = null;
    $this->sql = "select *from view_disciplinas where curso=:curso and classe=:classe";
    try{
        $this->stmt = $con->prepare($this->sql);
        $this->stmt->bindParam(":curso", $curso, PDO::PARAM_STR);
        $this->stmt->bindParam(":classe", $classe, PDO::PARAM_STR);
        $this->stmt->execute();
        $this->resposta = $this->stmt;
        $con = null;
    } catch (PDOException $ex) {
        echo ''.$ex;
    }
    return $this->resposta;
}

public function buscarNotas($epoca, $id_disciplina, $id_aluno){
    $this->resposta = null;
    $this->sql = "select *from tbl_notas where epoca=:epoca and id_di2=:id_di2 "
            . "and anoLetivo=:ano and id_aluno=:id_aluno";
    try{
        $this->stmt=$this->getCon()->prepare($this->sql);
        $this->stmt->bindParam(":epoca", $epoca, PDO::PARAM_STR);
        $this->stmt->bindParam(":id_di2", $id_disciplina, PDO::PARAM_STR);
        $this->stmt->bindParam(":ano", $this->getAno(), PDO::PARAM_STR);
        $this->stmt->bindParam(":id_aluno", $id_aluno, PDO::PARAM_STR);
        $this->stmt->execute();
        if($this->stmt):
        $this->resposta = $this->stmt; 
        endif;
    } catch (PDOException $ex) {
        echo ''.$ex;
    }
    return $this->resposta;
}

public function buscClassFinais($id_disciplina, $id_aluno){
    $this->resposta = null;
    $this->sql = "select *from tbl_cla_finais where id_aluno=:id_aluno and anolectivo=:ano and id_di2=:di";
    try{
        $this->stmt = $this->getCon()->prepare($this->sql);
        $this->stmt->bindParam(":id_aluno", $id_aluno, PDO::PARAM_STR);
        $this->stmt->bindParam(":ano", $this->getAno(), PDO::PARAM_STR);
        $this->stmt->bindParam(":di", $id_disciplina, PDO::PARAM_STR);
        $this->stmt->execute();
        if($this->stmt):
        $this->resposta = $this->stmt;
        endif;
    } catch (PDOException $ex) {
        echo ''.$ex;
    }
    return $this->resposta;
}



public function buscaHistorico($con, $id_aluno) {
    $this->resposta = null;
    $this->sql = "select *from view_historico where id_aluno = :id_aluno and anolectivo=:ano";
    try {
        $this->stmt = $con->prepare($this->sql);
        $this->stmt->bindParam(":id_aluno", $id_aluno, PDO::PARAM_STR);
        $this->stmt->bindParam(":ano", $this->getAno(), PDO::PARAM_STR);
        $this->stmt->execute();
        if($this->stmt && $this->stmt->rowCount()>0):
        $this->resposta = $this->stmt;
        endif;
        $con = null;
    } catch (PDOException $ex) {
        echo ''.$ex; 
    }
    return $this->resposta;
}


}
