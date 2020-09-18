<?php

class Conversao {
    private $comprensao;
    private $extensao;
    private $resposta;
    
    
    function getComprensao() {
        return $this->comprensao;
    }

    function getExtensao() {
        return $this->extensao;
    }

    function setComprensao($comprensao) {
        $this->comprensao = $comprensao;
    }

    function setExtensao($extensao) {
        $this->extensao = $extensao;
    }

        
    public function Converte(){

      if($this->getComprensao() == 0):
          $this->extensao = "Zero";
      elseif($this->getComprensao() == 1):
          $this->extensao = "Um valor";
      elseif($this->getComprensao() == 2):
          $this->extensao = "Dois valores";
       elseif($this->getComprensao() == 3):
          $this->extensao = "Três valores";
        elseif($this->getComprensao() == 4):
          $this->extensao = "Quatro valores";
        elseif($this->getComprensao() == 5):
          $this->extensao = "Cinco valores";
         elseif($this->getComprensao() == 6):
          $this->extensao = "Seis valores";
          elseif($this->getComprensao() == 7):
          $this->extensao = "Sete valores";
           elseif($this->getComprensao() == 8):
          $this->extensao = "Oito valores";
            elseif($this->getComprensao() == 9):
          $this->extensao = "Nove valores";
             elseif($this->getComprensao() == 10):
          $this->extensao = "Dez valores";
              elseif($this->getComprensao() == 11):
          $this->extensao = "Onze valores";
               elseif($this->getComprensao() == 12):
          $this->extensao = "Doze valores";
             elseif($this->getComprensao() == 13):
          $this->extensao = "Treze valores";
              elseif($this->getComprensao() == 14):
          $this->extensao = "Catorze valores";
               elseif($this->getComprensao() == 15):
          $this->extensao = "Quinze valores";
                elseif($this->getComprensao() == 16):
          $this->extensao = "Dezasseis valores";
                 elseif($this->getComprensao() == 17):
          $this->extensao = "Dezassete valores";
                  elseif($this->getComprensao() == 18):
          $this->extensao = "Dezoito valores";
                   elseif($this->getComprensao() == 19):
          $this->extensao = "Dezanove valores";
                    elseif($this->getComprensao() == 20):
          $this->extensao = "Vinte valores";
                
      endif;
      return $this->extensao;
    }

}
