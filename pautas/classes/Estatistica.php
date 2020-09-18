<?php

class Estatistica {
private $tipo;
private $epoca;
private $con;
private $stmt;
private $sql;
private $resposta;
private $genero;
private $aproveitamento;
private $aproveitamento2;

private $aproveitamento3;
private $aproveitamento4;
private $aproveitamento5;

function getTipo() {
    return $this->tipo;
}

function getEpoca() {
    return $this->epoca;
}

function getCon() {
    return $this->con;
}

function setTipo($tipo) {
    $this->tipo = $tipo;
}

function setEpoca($epoca) {
    $this->epoca = $epoca;
}

function setCon($con) {
    $this->con = $con;
}


function __construct() {
    $this->genero = "Femenino";
    $this->aproveitamento = "Desistencia";
    $this->aproveitamento2 = "Transferencia";
     $this->aproveitamento3 = "";
    $this->aproveitamento4 = "Não Transita";
     $this->aproveitamento5 = "Transita";
    
}

public function buscaDisciplinas() {
    $this->resposta = null;
    $this->sql = "select *from tbl_classe where tipoEsta = :tipoEsta";
    try {
        $this->stmt = $this->getCon()->prepare($this->sql);
        $this->stmt->bindParam(":tipoEsta", $this->getTipo(), PDO::PARAM_STR);
        $this->stmt->execute();
        if($this->stmt):
        $this->resposta = $this->stmt;
        endif;
    } catch (PDOException $ex) {
        echo ''.$ex;
    }
    return $this->resposta;
}

public function matriculadosMF($classe, $ano) {
    $this->resposta = null;
    $this->sql = "select *from view_historico where classe = :classe "
            . "and anolectivo = :ano";
    try {
        $this->stmt = $this->getCon()->prepare($this->sql);
        $this->stmt->bindParam(":classe", $classe, PDO::PARAM_STR);
        $this->stmt->bindParam(":ano", $ano, PDO::PARAM_STR);
        $this->stmt->execute();
        if($this->stmt):
        $this->resposta = $this->stmt;
        endif;
    } catch (PDOException $ex) {
        echo ''.$ex;
    }
    return $this->resposta;
}

public function matriculadosF($classe, $ano) {
    $this->resposta = null;
    $this->sql = "select *from view_historico where classe = :classe and "
            . "anolectivo = :ano and genero = :genero";
    try {
        $this->stmt = $this->getCon()->prepare($this->sql);
        $this->stmt->bindParam(":classe", $classe, PDO::PARAM_STR);
        $this->stmt->bindParam(":ano", $ano, PDO::PARAM_STR);
        $this->stmt->bindParam(":genero", $this->genero, PDO::PARAM_STR);
        $this->stmt->execute();
        if($this->stmt):
        $this->resposta = $this->stmt;
        endif;
    } catch (PDOException $ex) {
        echo ''.$ex;
    }
    return $this->resposta;
}


public function desitidosMF($classe, $ano) {
    $this->resposta = null;
    $this->sql = "select *from view_historico where classe = :classe and "
            . "anolectivo = :ano and (aproveitamento=:aproveitamento or aproveitamento=:aproveitamento2)";
    try {
        $this->stmt = $this->getCon()->prepare($this->sql);
        $this->stmt->bindParam(":classe", $classe, PDO::PARAM_STR);
        $this->stmt->bindParam(":ano", $ano, PDO::PARAM_STR);
        $this->stmt->bindParam(":aproveitamento", $this->aproveitamento, PDO::PARAM_STR);
        $this->stmt->bindParam(":aproveitamento2", $this->aproveitamento2, PDO::PARAM_STR);
        $this->stmt->execute();
        if($this->stmt):
        $this->resposta = $this->stmt;
        endif;
    } catch (PDOException $ex) {
        echo ''.$ex;
    }
    return $this->resposta;
}


public function desitidosF($classe, $ano) {
    $this->resposta = null;
    $this->sql = "select *from view_historico where classe = :classe and anolectivo = :ano "
            . "and genero = :genero and (aproveitamento=:aproveitamento or aproveitamento=:aproveitamento2)";
    try {
        $this->stmt = $this->getCon()->prepare($this->sql);
        $this->stmt->bindParam(":classe", $classe, PDO::PARAM_STR);
        $this->stmt->bindParam(":ano", $ano, PDO::PARAM_STR);
        $this->stmt->bindParam(":genero", $this->genero, PDO::PARAM_STR);
        $this->stmt->bindParam(":aproveitamento", $this->aproveitamento, PDO::PARAM_STR);
        $this->stmt->bindParam(":aproveitamento2", $this->aproveitamento2, PDO::PARAM_STR);
        $this->stmt->execute();
        if($this->stmt):
        $this->resposta = $this->stmt;
        endif;
    } catch (PDOException $ex) {
        echo ''.$ex;
    }
    return $this->resposta;
}



public function transitaMF($classe, $ano) {
    $this->resposta = null;
    $this->sql = "select *from view_historico where classe = :classe and "
            . "anolectivo = :ano and aproveitamento=:aproveitamento";
    try {
        $this->stmt = $this->getCon()->prepare($this->sql);
        $this->stmt->bindParam(":classe", $classe, PDO::PARAM_STR);
        $this->stmt->bindParam(":ano", $ano, PDO::PARAM_STR);
        $this->stmt->bindParam(":aproveitamento", $this->aproveitamento5, PDO::PARAM_STR);
        $this->stmt->execute();
        if($this->stmt):
        $this->resposta = $this->stmt;
        endif;
    } catch (PDOException $ex) {
        echo ''.$ex;
    }
    return $this->resposta;
}


public function transitaF($classe, $ano) {
    $this->resposta = null;
    $this->sql = "select *from view_historico where classe = :classe and anolectivo = :ano "
            . "and genero = :genero and aproveitamento=:aproveitamento";
    try {
        $this->stmt = $this->getCon()->prepare($this->sql);
        $this->stmt->bindParam(":classe", $classe, PDO::PARAM_STR);
        $this->stmt->bindParam(":ano", $ano, PDO::PARAM_STR);
        $this->stmt->bindParam(":genero", $this->genero, PDO::PARAM_STR);
        $this->stmt->bindParam(":aproveitamento", $this->aproveitamento5, PDO::PARAM_STR);
        $this->stmt->execute();
        if($this->stmt):
        $this->resposta = $this->stmt;
        endif;
    } catch (PDOException $ex) {
        echo ''.$ex;
    }
    return $this->resposta;
}


public function NaotransitaMF($classe, $ano) {
    $this->resposta = null;
    $this->sql = "select *from view_historico where classe = :classe and "
            . "anolectivo = :ano and aproveitamento=:aproveitamento";
    try {
        $this->stmt = $this->getCon()->prepare($this->sql);
        $this->stmt->bindParam(":classe", $classe, PDO::PARAM_STR);
        $this->stmt->bindParam(":ano", $ano, PDO::PARAM_STR);
        $this->stmt->bindParam(":aproveitamento", $this->aproveitamento4, PDO::PARAM_STR);
        $this->stmt->execute();
        if($this->stmt):
        $this->resposta = $this->stmt;
        endif;
    } catch (PDOException $ex) {
        echo ''.$ex;
    }
    return $this->resposta;
}


public function NaotransitaF($classe, $ano) {
    $this->resposta = null;
    $this->sql = "select *from view_historico where classe = :classe and anolectivo = :ano "
            . "and genero = :genero and aproveitamento=:aproveitamento";
    try {
        $this->stmt = $this->getCon()->prepare($this->sql);
        $this->stmt->bindParam(":classe", $classe, PDO::PARAM_STR);
        $this->stmt->bindParam(":ano", $ano, PDO::PARAM_STR);
        $this->stmt->bindParam(":genero", $this->genero, PDO::PARAM_STR);
        $this->stmt->bindParam(":aproveitamento", $this->aproveitamento4, PDO::PARAM_STR);
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
