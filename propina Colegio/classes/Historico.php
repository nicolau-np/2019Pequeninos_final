<?php

class Historico {
private $con;
private $sql;
private $stmt;
private $resposta;
private $id_aluno;
private $ano_lectivo;


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

public function BuscaHisto(){
    $this->resposta = null;
    $this->sql = "select *from view_historico where id_aluno=:id_aluno and anolectivo=:ano";
    try{
        $this->stmt = $this->getCon()->prepare($this->sql);
        $this->stmt->bindParam(":id_aluno", $this->getId_aluno(), PDO::PARAM_STR);
        $this->stmt->bindParam(":ano", $this->getAno_lectivo(), PDO::PARAM_STR);
        $this->stmt->execute();
        if($this->stmt && $this->stmt->rowCount()>0):
        $this->resposta = $this->stmt;
        else:
        $this->resposta = "no";
        endif;
    } catch (PDOException $ex) {
        echo ''.$ex;
    }
    return $this->resposta;
}
}
