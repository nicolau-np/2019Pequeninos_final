<?php

class ClassDisciplinas {
private $observacao;


public function retornaCla6_9($cf) {
   if($cf >= 9.5):
   $this->observacao = "Transita";
   elseif($cf <= 9):
   $this->observacao = "Nao Transita";
   endif; 
   
   return $this->observacao;  
}

public function retornaCla2_4($cf) {
  if($cf >= 4.5):
   $this->observacao = "Transita";
   elseif($cf <= 4):
   $this->observacao = "Nao Transita";
   endif; 
   
   return $this->observacao;   
}

}
