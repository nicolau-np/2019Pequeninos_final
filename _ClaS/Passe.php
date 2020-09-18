<?php


class Passe {
private $passe_antiga;
private $passe_nova;
private $passe_nova2;
private $MD5passe;
private $MD5passeNova;
private $resposta;
private $SQL;
private $stmt;
private $cont;
private $con;
private $ID_pessoa;
private $ID_user;
private $view;

function getPasse_antiga() {return $this->passe_antiga;}

function getPasse_nova() { return $this->passe_nova;}

function getPasse_nova2() {return $this->passe_nova2;}

function setPasse_antiga($passe_antiga) {$this->passe_antiga = $passe_antiga;}

function setPasse_nova($passe_nova) {$this->passe_nova = $passe_nova;}

function setPasse_nova2($passe_nova2) {$this->passe_nova2 = $passe_nova2;}

function getCon() {return $this->con;}

function setCon($con) {$this->con = $con;}

function getID_pessoa() { return $this->ID_pessoa;}

function setID_pessoa($ID_pessoa) {$this->ID_pessoa = $ID_pessoa;}


public function Ver_passeantiga(){
     $this->resposta = null;
     $this->MD5passe=md5($this->passe_antiga);
     $this->SQL = "select *from view_logar where id_pessoa=:id_pessoa and senha=:senha";
    try{
   $this->stmt = $this->con->prepare($this->SQL);
   $this->stmt->bindParam(":id_pessoa", $this->ID_pessoa, PDO::PARAM_STR);
   $this->stmt->bindParam(":senha", $this->MD5passe, PDO::PARAM_STR);
   $this->stmt->execute();
   $this->cont = $this->stmt->rowCount();
   if($this->cont == 0):
   $this->resposta = "no";
   elseif($this->cont > 0):
   $this->view = $this->stmt->fetch(PDO::FETCH_OBJ);
   $this->resposta = "yes";
   $this->ID_user = $this->view->id_user;
   endif;
   
    } catch (PDOException $ex) {
        $this->resposta = null;
        echo $ex->getMessage();
    }
 
    return $this->resposta;   
}

public function ver_Confirmacao(){
   $this->resposta = null;
    try{
   if($this->passe_nova == $this->passe_nova2):
   $this->resposta = "yes";
   else:
    $this->resposta = "no";
   endif;
 
    } catch (PDOException $ex) {
        $this->resposta = null;
        echo $ex->getMessage();
    }
 
    return $this->resposta;   
}

public function _salvar(){
    $this->resposta = null;
    $this->MD5passeNova=md5($this->passe_nova);
    $this->SQL = "update tbl_senhas set senha=:senha where id_user=:id_user";
    try {
        $this->stmt = $this->con->prepare($this->SQL);
        $this->stmt->bindParam(":senha", $this->MD5passeNova, PDO::PARAM_STR);
        $this->stmt->bindParam(":id_user", $this->ID_user, PDO::PARAM_STR);
        $this->stmt->execute();
        if(!$this->stmt):
        $this->resposta = "no";
        else:
        $this->resposta = "yes";
        endif;
    } catch (PDOException $exc) {
        echo $exc->getTraceAsString();
    }
    
    return $this->resposta;
}


}
