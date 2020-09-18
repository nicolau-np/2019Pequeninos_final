<?php


class _ConfigServidor {
    
 private $dia_actual;
 private $mes_actual;
 private $ano_actual;
 private $data_atual;
   
 function __construct() {
     $this->dia_actual = date("d");
     $this->mes_actual = date("m");
     $this->ano_actual = date("Y");
     $this->data_atual = date("d/m/Y");
 }



    
}
