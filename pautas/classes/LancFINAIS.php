<?php

class LancFINAIS {
 private $con;
 private $stmt;
 private $view;
 private $cont;
 private $sql;
 private $resposta;
 
 private $ct1;
 private $ct2;
 private $ct3;
 
 private $cap;
 private $cpe;
 private $cf;

 
 function getCon() {
     return $this->con;
 }

 function setCon($con) {
     $this->con = $con;
 }
 
 function getCt1() {
     return $this->ct1;
 }

 function getCt2() {
     return $this->ct2;
 }

 function getCt3() {
     return $this->ct3;
 }
 
 
 function getCap() {
     return $this->cap;
 }

 function getCpe() {
     return $this->cpe;
 }

 function getCf() {
     return $this->cf;
 }

 
 public function buscaSomaCTs($id_aluno, $ano, $id_disciplina){
     $this->resposta = null;
     $epoca1 = 1;
     $epoca2 = 2;
     $epoca3 = 3;
     $this->sql = "select *from view_notas where id_aluno = :id_aluno and "
             . "id_di2 = :id_disciplina and anoLetivo = :ano and epoca = :epoca";
     try{
         //epoca 1
         $this->stmt = $this->getCon()->prepare($this->sql);
         $this->stmt->bindParam(":id_aluno", $id_aluno, PDO::PARAM_STR);
         $this->stmt->bindParam(":id_disciplina", $id_disciplina, PDO::PARAM_STR);
         $this->stmt->bindParam(":ano", $ano, PDO::PARAM_STR);
         $this->stmt->bindParam(":epoca", $epoca1, PDO::PARAM_STR);
         $this->stmt->execute();
         if($this->stmt):
         $this->view = $this->stmt->fetch(PDO::FETCH_OBJ);
         if($this->view == "---"):
         $this->ct1 = 0;
         else:
             $this->ct1 = $this->view->ct;
         endif;
         
         
         
         //epoca 2
          $this->stmt = $this->getCon()->prepare($this->sql);
         $this->stmt->bindParam(":id_aluno", $id_aluno, PDO::PARAM_STR);
         $this->stmt->bindParam(":id_disciplina", $id_disciplina, PDO::PARAM_STR);
         $this->stmt->bindParam(":ano", $ano, PDO::PARAM_STR);
         $this->stmt->bindParam(":epoca", $epoca2, PDO::PARAM_STR);
         $this->stmt->execute();
         if($this->stmt):
         $this->view = $this->stmt->fetch(PDO::FETCH_OBJ);
          if($this->view == "---"):
         $this->ct2 = 0;
         else:
             $this->ct2 = $this->view->ct;
         endif;
         
         //epoca 3
         
          $this->stmt = $this->getCon()->prepare($this->sql);
         $this->stmt->bindParam(":id_aluno", $id_aluno, PDO::PARAM_STR);
         $this->stmt->bindParam(":id_disciplina", $id_disciplina, PDO::PARAM_STR);
         $this->stmt->bindParam(":ano", $ano, PDO::PARAM_STR);
         $this->stmt->bindParam(":epoca", $epoca3, PDO::PARAM_STR);
         $this->stmt->execute();
         if($this->stmt):
         $this->view = $this->stmt->fetch(PDO::FETCH_OBJ);
           if($this->view == "---"):
         $this->ct3 = 0;
         else:
             $this->ct3 = $this->view->ct;
         endif;
         
         $this->resposta = "yes";
         
         endif;
         endif;
         endif;
     } catch (PDOException $ex) {
         echo ''.$ex;
     }
     return $this->resposta;
 }
 
 public function buscaFINAISCapCpeCF($id_aluno, $ano, $id_disciplina){
     $this->sql = "select *from tbl_cla_finais where id_aluno=:id and "
             . "id_di2=:id_di2 and anolectivo=:ano";
     try {
         $this->stmt = $this->getCon()->prepare($this->sql);
         $this->stmt->bindParam(":id", $id_aluno, PDO::PARAM_STR);
         $this->stmt->bindParam(":id_di2", $id_disciplina, PDO::PARAM_STR);
         $this->stmt->bindParam(":ano", $ano, PDO::PARAM_STR);
         $this->stmt->execute();
         $this->view = $this->stmt->fetch(PDO::FETCH_OBJ);
         if($this->stmt):
             if($this->view->cap == "---"):
             $this->cap = 0;
             else:
             $this->cap = $this->view->cap;
             endif;
             
             if($this->view->cpe == "---"):
             $this->cpe = 0;
             else:
             $this->cpe = $this->view->cpe;
             endif;
             
             if($this->view->cf == "---"):
             $this->cf = 0;
             else:
             $this->cf = $this->view->cf;
             endif;
             
         endif;
     } catch (PDOException $ex) {
         echo ''.$ex;
     }
 }
  
 public function updateFinal($cap, $cf, $ob, $cf_extenso, $id_aluno, $id_disciplina, $ano){
     $this->resposta = null;
     $this->sql = "update tbl_cla_finais set cap=:cap, cf=:cf, observacao=:ob, "
             . "cf_extensao=:cf_extensao where id_aluno=:id and id_di2=:id_di2 and anolectivo=:ano";
     try{
         $this->stmt = $this->getCon()->prepare($this->sql);
         $this->stmt->bindParam(":cap", $cap, PDO::PARAM_STR);
         $this->stmt->bindParam(":cf", $cf, PDO::PARAM_STR);
         $this->stmt->bindParam(":ob", $ob, PDO::PARAM_STR);
         $this->stmt->bindParam(":cf_extensao", $cf_extenso, PDO::PARAM_STR);
         $this->stmt->bindParam(":id", $id_aluno, PDO::PARAM_STR);
         $this->stmt->bindParam(":id_di2", $id_disciplina, PDO::PARAM_STR);
         $this->stmt->bindParam(":ano", $ano, PDO::PARAM_STR);
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

 public function updateCPE($cap, $cpe, $cf, $ob, $cf_extenso, $id_aluno, $id_disciplina, $ano){
     $this->resposta = null;
     $this->sql = "update tbl_cla_finais set cap=:cap, cpe = :cpe, cf=:cf, observacao=:ob, "
             . "cf_extensao=:cf_extensao where id_aluno=:id and id_di2=:id_di2 and anolectivo=:ano";
     try{
         $this->stmt = $this->getCon()->prepare($this->sql);
         $this->stmt->bindParam(":cap", $cap, PDO::PARAM_STR);
         $this->stmt->bindParam(":cpe", $cpe, PDO::PARAM_STR);
         $this->stmt->bindParam(":cf", $cf, PDO::PARAM_STR);
         $this->stmt->bindParam(":ob", $ob, PDO::PARAM_STR);
         $this->stmt->bindParam(":cf_extensao", $cf_extenso, PDO::PARAM_STR);
         $this->stmt->bindParam(":id", $id_aluno, PDO::PARAM_STR);
         $this->stmt->bindParam(":id_di2", $id_disciplina, PDO::PARAM_STR);
         $this->stmt->bindParam(":ano", $ano, PDO::PARAM_STR);
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
