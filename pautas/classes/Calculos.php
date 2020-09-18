<?php

class Calculos {
  private $resposta; 
  private $mac;
  private $cpp;
  private $ct;
  private $cap;
  private $cf;
  private $somatorioProvas;
  private $somatorioAvaliacao;
  private $quantProvas;
  private $quantAvaliacao;
  //variaveis de control
  private $stmt;
  private $con;
  private $view;
  private $cont;
  private $sql;
  

    
  function getCon() {
      return $this->con;
  }

  function setCon($con) {
      $this->con = $con;
  }

   public function retornaMac($somatorioAva, $quantAvaliacoes) {
       if($quantAvaliacoes == 0):
           $this->mac = 0;
           else:
           $this->mac = $somatorioAva/$quantAvaliacoes;
       endif;
      
      
      return $this->mac;
  }
  
  public function retornaCPP($somatorioProvas, $quantProvas){
      if($quantProvas == 0):
          $this->cpp = 0;
          else:
         $this->cpp = $somatorioProvas/$quantProvas; 
      endif;
      
      
      return $this->cpp;  
  }
  
  public function retornaCT($mac, $cpp){
      $this->ct = ($mac + $cpp)/2;
      
      return $this->ct;
  }
  
  public function retornaCF($cap, $cpe){
      $this->cf=($cap*0.4)+($cpe*0.6);
      
      return round($this->cf);
  }
  
  public function retornaCAP($ct1, $ct2, $ct3) {
      $this->cap = ($ct1 + $ct2 + $ct3)/3;
      
      return $this->cap;
  }
    
  public function somatorioAvaliacoe($id_aluno, $id_disciplina, $epoca, $ano){
      $this->sql = "SELECT SUM(valor) FROM tbl_avaliacao where ano=:ano and "
              . "id_aluno=:id_aluno and id_disciplina=:id_disciplina and epoca=:epoca";
      try {
          $this->stmt = $this->getCon()->prepare($this->sql);
          $this->stmt->bindParam(":ano", $ano, PDO::PARAM_STR);
          $this->stmt->bindParam(":id_aluno", $id_aluno, PDO::PARAM_STR);
          $this->stmt->bindParam(":id_disciplina", $id_disciplina, PDO::PARAM_STR);
          $this->stmt->bindParam(":epoca", $epoca, PDO::PARAM_STR);
          $this->stmt->execute();
          if($this->stmt):
           $this->somatorioAvaliacao = $this->stmt->fetchColumn();
           endif;   
         
      } catch (PDOException $ex) {
          echo ''.$ex;
      }
      return $this->somatorioAvaliacao;
  }
  
  public function somatorioProvas($id_aluno, $id_disciplina, $epoca, $ano){
      $this->sql = "SELECT SUM(valor) FROM tbl_provas where ano=:ano and "
              . "id_aluno=:id_aluno and id_disciplina=:id_disciplina and epoca=:epoca";
      try {
          $this->stmt = $this->getCon()->prepare($this->sql);
          $this->stmt->bindParam(":ano", $ano, PDO::PARAM_STR);
          $this->stmt->bindParam(":id_aluno", $id_aluno, PDO::PARAM_STR);
          $this->stmt->bindParam(":id_disciplina", $id_disciplina, PDO::PARAM_STR);
          $this->stmt->bindParam(":epoca", $epoca, PDO::PARAM_STR);
          $this->stmt->execute();
          if($this->stmt):
             $this->somatorioProvas = $this->stmt->fetchColumn();
          endif;
      } catch (PDOException $ex) {
          echo ''.$ex;
      }
    
      return $this->somatorioProvas;
  }
  
  public function quantAvaliacoes($id_aluno, $id_disciplina, $epoca, $ano) {
     $this->sql = "SELECT *FROM tbl_avaliacao where ano=:ano and "
              . "id_aluno=:id_aluno and id_disciplina=:id_disciplina and epoca=:epoca";
      try {
          $this->stmt = $this->getCon()->prepare($this->sql);
          $this->stmt->bindParam(":ano", $ano, PDO::PARAM_STR);
          $this->stmt->bindParam(":id_aluno", $id_aluno, PDO::PARAM_STR);
          $this->stmt->bindParam(":id_disciplina", $id_disciplina, PDO::PARAM_STR);
          $this->stmt->bindParam(":epoca", $epoca, PDO::PARAM_STR);
          $this->stmt->execute();
          if($this->stmt):
              $this->cont = $this->stmt->rowCount();
              $this->quantAvaliacao = $this->cont;
          
          endif;
      } catch (PDOException $ex) {
          echo ''.$ex;
      }
      return $this->quantAvaliacao;
  }
  
  public function quantidadeProvas($id_aluno, $id_disciplina, $epoca, $ano) {
   $this->sql = "SELECT *FROM tbl_provas where ano=:ano and "
              . "id_aluno=:id_aluno and id_disciplina=:id_disciplina and epoca=:epoca";
      try {
          $this->stmt = $this->getCon()->prepare($this->sql);
          $this->stmt->bindParam(":ano", $ano, PDO::PARAM_STR);
          $this->stmt->bindParam(":id_aluno", $id_aluno, PDO::PARAM_STR);
          $this->stmt->bindParam(":id_disciplina", $id_disciplina, PDO::PARAM_STR);
          $this->stmt->bindParam(":epoca", $epoca, PDO::PARAM_STR);
          $this->stmt->execute();
          if($this->stmt):
              $this->cont = $this->stmt->rowCount();
              $this->quantProvas = $this->cont;
          
          endif;
      } catch (PDOException $ex) {
          echo ''.$ex;
      }

      return $this->quantProvas;
  }
  
 public function FazerUpdates($mac, $cpp, $ct, $id_aluno, $id_disciplina, $epoca, $ano){
     $this->resposta = null;
     $this->sql = "update tbl_notas set mac = :mac, cpp = :cpp, ct = :ct where id_di2 = :id_disciplina and "
             . "epoca = :epoca and id_aluno = :id_aluno and anoLetivo = :ano";
     try{
         $this->stmt = $this->getCon()->prepare($this->sql);
         $this->stmt->bindParam(":mac", $mac, PDO::PARAM_STR);
         $this->stmt->bindParam(":cpp", $cpp, PDO::PARAM_STR);
         $this->stmt->bindParam(":ct", $ct, PDO::PARAM_STR);
         $this->stmt->bindParam(":id_disciplina", $id_disciplina, PDO::PARAM_STR);
         $this->stmt->bindParam(":epoca", $epoca, PDO::PARAM_STR);
         $this->stmt->bindParam(":id_aluno", $id_aluno, PDO::PARAM_STR);
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
