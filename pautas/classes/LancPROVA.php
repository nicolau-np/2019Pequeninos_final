<?php

class LancPROVA {
 private $con;
 private $stmt;
 private $view;
 private $cont;
 private $sql;
 private $resposta;
 
 
 function getCon() {
     return $this->con;
 }

 function setCon($con) {
     $this->con = $con;
 }

  
 public function inserirProva($id_aluno, $id_disciplina, $epoca, $ano, $data, $valor){
     $this->resposta = null;
     $this->sql = "insert into tbl_provas (id_aluno, id_disciplina, epoca, ano, valor, data)"
             . "values (:id_aluno, :id_disciplina, :epoca, :ano, :valor, :data)";
     try {
         $this->stmt = $this->getCon()->prepare($this->sql);
         $this->stmt->bindParam(":id_aluno", $id_aluno, PDO::PARAM_STR);
         $this->stmt->bindParam(":id_disciplina", $id_disciplina, PDO::PARAM_STR);
         $this->stmt->bindParam(":epoca", $epoca, PDO::PARAM_STR);
         $this->stmt->bindParam(":ano", $ano, PDO::PARAM_STR);
         $this->stmt->bindParam(":valor", $valor, PDO::PARAM_STR);
         $this->stmt->bindParam(":data", $data, PDO::PARAM_STR);
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
 
}
