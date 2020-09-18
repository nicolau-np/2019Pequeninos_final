<?php

class HistoricoBusca {
private $id_aluno;
private $con;
private $stmt;
private $view;
private $resposta;

function getId_aluno() {
    return $this->id_aluno;
}

function getCon() {
    return $this->con;
}

function setId_aluno($id_aluno) {
    $this->id_aluno = $id_aluno;
}

function setCon($con) {
    $this->con = $con;
}


public function buscaHistorico() {
    $this->resposta = null;
    $this->sql = "select *from view_historico where id_aluno = :id_aluno";
    try {
        $this->stmt = $this->getCon()->prepare($this->sql);
        $this->stmt->bindParam(":id_aluno", $this->getId_aluno(), PDO::PARAM_STR);
        $this->stmt->execute();
        if($this->stmt && $this->stmt->rowCount()>0):
        $this->resposta = $this->stmt;
        endif;
    } catch (PDOException $ex) {
        echo ''.$ex; 
    }
    return $this->resposta;
}
        
}
