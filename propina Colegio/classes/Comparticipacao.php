<?php


class Comparticipacao {
private $con;
private $sql;
private $stmt;
private $resposta;
private $id_aluno;
private $ano_lectivo;
private $id_pai;
private $nome_pai;
private $view;


function getNome_pai() {
    return $this->nome_pai;
}

function getId_pai() {
    return $this->id_pai;
}
function setId_pai($id_pai) {
    $this->id_pai = $id_pai;
}


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

public function buscaIDpai() {
    $this->resposta = null;
    $this->sql = "select *from view_financeiros where id_aluno=:id";
    try{
        $this->stmt = $this->getCon()->prepare($this->sql);
        $this->stmt->bindParam(":id", $this->getId_aluno(), PDO::PARAM_STR);
        $this->stmt->execute();
        $this->view = $this->stmt->fetch(PDO::FETCH_OBJ);
        if($this->stmt && $this->stmt->rowCount()>0):
        $this->id_pai = $this->view->id_pai;
        $this->nome_pai = $this->view->nome_pai;
        endif;
    } catch (PDOException $ex) {
        echo ''.$ex;
    }
    return $this->resposta;
}


public function buscaIDAlunos() {
    $this->resposta = null;
    $this->sql = "select *from view_financeiros where id_pai=:id";
    try{
        $this->stmt = $this->getCon()->prepare($this->sql);
        $this->stmt->bindParam(":id", $this->getId_pai(), PDO::PARAM_STR);
        $this->stmt->execute();
        if($this->stmt && $this->stmt->rowCount()>0):
        $this->resposta = $this->stmt;
        endif;
    } catch (PDOException $ex) {
        echo ''.$ex;
    }
    return $this->resposta;
}

public function verPagamento(){
    $this->resposta = null;
    $this->sql = 'select *from view_comp_pais where id_pai=:id and ano=:ano';
    try{
        $this->stmt = $this->getCon()->prepare($this->sql);
        $this->stmt->bindParam(":id", $this->getId_pai(), PDO::PARAM_STR);
        $this->stmt->bindParam(":ano", $this->getAno_lectivo(), PDO::PARAM_STR);
        $this->stmt->execute();
        if($this->stmt):
        $this->resposta = $this->stmt;   
        endif;
    } catch (PDOException $ex) {
        echo ''.$ex;
    }
    return $this->resposta;
}

public function verquantPag(){
    $this->resposta = null;
    $this->sql = 'select *from tb_folha';
    try{
        $this->stmt = $this->getCon()->prepare($this->sql);
        $this->stmt->execute();
        if($this->stmt):
        $this->resposta = $this->stmt;   
        endif;
    } catch (PDOException $ex) {
        echo ''.$ex;
    }
    return $this->resposta; 
}




}
