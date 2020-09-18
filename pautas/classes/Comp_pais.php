<?php

class Comp_pais {
    private $con;
    private $sql;
    private $stmt;
    private $resposta;
    private $id_aluno;
    private $nome_pai;
    private $id_pai;
    private $view;
    
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

    function getNome_pai() {
        return $this->nome_pai;
    }

    function setCon($con) {
        $this->con = $con;
    }

    function setId_aluno($id_aluno) {
        $this->id_aluno = $id_aluno;
    }

    function setNome_pai($nome_pai) {
        $this->nome_pai = $nome_pai;
    }

        
    public function verifica(){
        $this->resposta = null;
        $this->sql = "select *from tbl_pais where nome_pai = :pai";
        try{
            $this->stmt = $this->getCon()->prepare($this->sql);
            $this->stmt->bindParam(":pai", $this->getNome_pai(), PDO::PARAM_STR);
            $this->stmt->execute();
            $this->view = $this->stmt->fetch(PDO::FETCH_OBJ);
            if($this->stmt && $this->stmt->rowCount()>0):
            $this->id_pai = $this->view->id_pai;
            $this->resposta = "yes";
            elseif($this->stmt && $this->stmt->rowCount()<=0):
            $this->resposta = "no";
            endif;
        } catch (PDOException $ex) {
            echo ''.$ex;
        }
        return $this->resposta;
    }
    
    public function inserePai(){
        $this->resposta = null;
        $this->sql = "insert into tbl_pais (nome_pai) values(:pai)";
        try {
            $this->stmt = $this->getCon()->prepare($this->sql);  
            $this->stmt->bindParam(":pai", $this->getNome_pai(), PDO::PARAM_STR);
            $this->stmt->execute();
            if($this->stmt):
                $this->resposta = "yes";
            else:
            $this->resposta = "no";
            endif;
        } catch (PDOException $ex) {
            echo ''.$ex;
            
        }
        return $this->resposta;
    }
   
   public function insereFinanceiro(){
       $this->resposta = null;
       $this->sql = "insert into tbl_financeiros_filhos (id_pai, id_aluno) value(:id_pai, :id_aluno)";
       try {
           $this->stmt = $this->getCon()->prepare($this->sql);
           $this->stmt->bindParam(":id_pai", $this->getId_pai(), PDO::PARAM_STR);
           $this->stmt->bindParam(":id_aluno", $this->getId_aluno(), PDO::PARAM_STR);
           $this->stmt->execute();
           if($this->stmt):
           $this->resposta = "yes";
           else:
           $this->resposta = "no";
           endif;
       } catch (PDOException $ex) {
           echo ''.$ex;
       }
       return $this->resposta;
   }
   
   public function EditaFinanceiro(){
       $this->resposta = null;
       $this->sql = "update tbl_financeiros_filhos set id_pai=:id_pai where id_aluno=:id_aluno";
       try{
           $this->stmt = $this->getCon()->prepare($this->sql);
           $this->stmt->bindParam(":id_pai", $this->getId_pai(), PDO::PARAM_STR);
           $this->stmt->bindParam(":id_aluno", $this->getId_aluno(), PDO::PARAM_STR);
           $this->stmt->execute();
           if($this->stmt):
           $this->resposta = "yes";
           endif;
       } catch (PDOException $ex) {
           echo ''.$ex;
       }
       return $this->resposta;
   }

}
