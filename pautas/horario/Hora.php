<?php

class Hora {
    private $resposta;
    private $stmt;
    private $view;
    private $con;
    private $turma;
    private $turno;
    private $ano;
    private $classe;
    private $curso;
    private $sql;
    private $id_turno;
    private $hora_e;
    private $hora_s;
    private $semana;
    
    function getHora_e() {
        return $this->hora_e;
    }

    function getHora_s() {
        return $this->hora_s;
    }

    function getSemana() {
        return $this->semana;
    }

    function setHora_e($hora_e) {
        $this->hora_e = $hora_e;
    }

    function setHora_s($hora_s) {
        $this->hora_s = $hora_s;
    }

    function setSemana($semana) {
        $this->semana = $semana;
    }

    
    function getId_turno() {
        return $this->id_turno;
    }

    function setId_turno($id_turno) {
        $this->id_turno = $id_turno;
    }

        
    function getCon() {
        return $this->con;
    }

    function getTurma() {
        return $this->turma;
    }

    function getTurno() {
        return $this->turno;
    }

    function getAno() {
        return $this->ano;
    }

    function getClasse() {
        return $this->classe;
    }

    function getCurso() {
        return $this->curso;
    }

    function setCon($con) {
        $this->con = $con;
    }

    function setTurma($turma) {
        $this->turma = $turma;
    }

    function setTurno($turno) {
        $this->turno = $turno;
    }

    function setAno($ano) {
        $this->ano = $ano;
    }

    function setClasse($classe) {
        $this->classe = $classe;
    }

    function setCurso($curso) {
        $this->curso = $curso;
    }

        
    public function busca_hora() {
        $this->resposta = null;
        $this->sql = "select *from view_horario where classe = :classe and "
                . "curso = :curso and turma = :turma and turno = :turno and "
                . "anolectivo = :ano and hora_e = :hora_e and hora_s = :hora_s and semana = :semana";
        try{
            $this->stmt = $this->getCon()->prepare($this->sql);
            $this->stmt->bindParam(":classe", $this->getClasse(), PDO::PARAM_STR);
            $this->stmt->bindParam(":curso", $this->getCurso(), PDO::PARAM_STR);
            $this->stmt->bindParam(":turma", $this->getTurma(), PDO::PARAM_STR);
            $this->stmt->bindParam(":turno", $this->getTurno(), PDO::PARAM_STR);
            $this->stmt->bindParam(":ano", $this->getAno(), PDO::PARAM_STR);
            $this->stmt->bindParam(":hora_e", $this->getHora_e(), PDO::PARAM_STR);
            $this->stmt->bindParam(":hora_s", $this->getHora_s(), PDO::PARAM_STR);
            $this->stmt->bindParam(":semana", $this->getSemana(), PDO::PARAM_STR);
            $this->stmt->execute();
            if($this->stmt):
            $this->resposta = $this->stmt;
            endif;
        } catch (PDOException $ex) {
            echo ''.$ex;
        }
        return $this->resposta;
    }
    
    public function _horas(){
        $this->resposta = null;
        $this->sql = "select *from tbl_hora where id_turno = :id_turno";
        try {
            $this->stmt = $this->getCon()->prepare($this->sql);
            $this->stmt->bindParam(":id_turno", $this->getId_turno(), PDO::PARAM_STR);
            $this->stmt->execute();
            if($this->stmt && $this->stmt->rowCount()>0):
            $this->resposta = $this->stmt;
            endif;
        } catch (PDOException $ex) {
            echo ''.$ex;
        }
        return $this->resposta;
    }
    
    public function _tempo($id_hora) {
        $this->resposta = null;
        $this->sql = "select *from tbl_hora where id_hora = :id_hora";
        try {
            $this->stmt = $this->getCon()->prepare($this->sql);
            $this->stmt->bindParam(":id_hora", $id_hora, PDO::PARAM_STR);
            $this->stmt->execute();
            if($this->stmt && $this->stmt->rowCount()>0):
            $this->resposta = $this->stmt;
            endif;
        } catch (PDOException $ex) {
            echo $ex;
        }
        return $this->resposta;
    }
    
}
