<?php

class BuscCursoClasse {
private $sql;
private $stmt;
private $cont;
private $view;
private $con;
private $resposta;

function getCon() {
    return $this->con;
}

function setCon($con) {
    $this->con = $con;
}

public function buscarCursos(){
    $this->resposta = null;
    $this->sql = "select *from tbl_curso";
    try{
        $this->stmt = $this->getCon()->prepare($this->sql);
        $this->stmt->execute();
        if(($this->stmt) && ($this->stmt->rowCount() > 0)):
        $this->resposta = $this->stmt;  
        endif;
    } catch (PDOException $ex) {
        echo ''.$ex;
    }
    return $this->resposta;
}

public function buscarClasses(){
    $this->resposta = null;
    $this->sql = "select *from tbl_classe";
    try{
        $this->stmt = $this->getCon()->prepare($this->sql);
        $this->stmt->execute();
        if(($this->stmt) && ($this->stmt->rowCount() > 0)):
        $this->resposta = $this->stmt;  
        endif;
    } catch (PDOException $ex) {
        echo ''.$ex;
    }
    return $this->resposta;  
  
}

}
