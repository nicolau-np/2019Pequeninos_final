<?php

class Caderneta {
private $con;
private $stmt;
private $sql;
private $view;
private $resposta;


private $id_aluno;
private $curso;
private $classe;
private $turma;
private $turno;
private $epoca;
private $ano;
private $id_disciplina;
private $caderneta;

function getCon() {
    return $this->con;
}

function getId_aluno() {
    return $this->id_aluno;
}

function getCurso() {
    return $this->curso;
}

function getClasse() {
    return $this->classe;
}

function getTurma() {
    return $this->turma;
}

function getTurno() {
    return $this->turno;
}

function getEpoca() {
    return $this->epoca;
}

function getAno() {
    return $this->ano;
}

function getId_disciplina() {
    return $this->id_disciplina;
}

function setCon($con) {
    $this->con = $con;
}

function setId_aluno($id_aluno) {
    $this->id_aluno = $id_aluno;
}

function setCurso($curso) {
    $this->curso = $curso;
}

function setClasse($classe) {
    $this->classe = $classe;
}

function setTurma($turma) {
    $this->turma = $turma;
}

function setTurno($turno) {
    $this->turno = $turno;
}

function setEpoca($epoca) {
    $this->epoca = $epoca;
}

function setAno($ano) {
    $this->ano = $ano;
}

function setId_disciplina($id_disciplina) {
    $this->id_disciplina = $id_disciplina;
}




public function __construct() {
    $this->caderneta = "sim";
}

public function buscaEstudate(){
    $this->resposta = null;
    $this->sql = "select *from view_estudante where curso=:curso and classe=:classe "
            . "and turma=:turma and turno=:turno and cardeneta=:cardeneta and anolectivo=:ano order by nome asc";
    try{
        $this->stmt = $this->getCon()->prepare($this->sql);
        $this->stmt->bindParam(":curso", $this->getCurso(), PDO::PARAM_STR);
        $this->stmt->bindParam(":classe", $this->getClasse(), PDO::PARAM_STR);
        $this->stmt->bindParam(":turma", $this->getTurma(), PDO::PARAM_STR);
        $this->stmt->bindParam(":turno", $this->getTurno(), PDO::PARAM_STR);
        $this->stmt->bindParam(":cardeneta", $this->caderneta, PDO::PARAM_STR);
        $this->stmt->bindParam(":ano", $this->getAno(), PDO::PARAM_STR);
        $this->stmt->execute();
        if($this->stmt):
         $this->resposta = $this->stmt;   
        else:
            echo 'erro';
        endif;
        
    } catch (PDOxception $ex) {
        echo ''.$ex;
    }
    return $this->resposta;
}

    
}
