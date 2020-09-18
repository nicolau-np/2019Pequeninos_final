<?php



    /**
     * 
     */
    class SellUniforme
    { 
      private $conn;
      private $idWorker;
      private $idClass;
      private $idProdu;
      public $priceSell;
      public $priceBuy;
      public $product;
      public $quantity;      
      public $capital;
      public $profit;
      public $existence;
      public $year;
      public $worker;
      public $client;

      public function getConnection(){ return $this-> conn;}
      public function setConnection($conn){ $this-> conn = $conn; }
      public function getIdWorker(){ return $this-> idWorker;}
      public function setIdWorker($idWorker){ $this-> idWorker = $idWorker; }
      public function getIdClass(){ return $this-> idClass; }
      public function setIdClass($idClass){ $this-> idClass = $idClass; }
      public function getIdProdu(){ return $this-> idProdu; }
      public function setIdProdu($idProdu){ $this-> idProdu = $idProdu; }

      public function selectProduto(){
        if($this -> getIdProdu() > 0){
          $run= $this-> conn -> prepare("SELECT * produto WHERE idProd =:ID");
          $run->bindParam(":ID",$this -> getIdProdu(),PDO::PARAM_INT);
          if($run->execute()){
            if($run->rowCunt() >0){
               $row = $run->fetch(PDO::FETCH_OBJ);
               $this-> existence = $row->existencia;
               $this-> priceSell = $row->precoVenda;
            }
          }

        }
      }//End function
       public function saveProduct(){
        if(($this-> priceSell > 0) && ($this-> existence > $this-> quantity) && ($this-> getIdProdu() >0) ){
          if( ($this-> getIdWorker() >0) ){

              
          
          }
        }
      }//End function
      public function saveSell(){
        if(($this-> priceSell > 0) && ($this-> existence > $this-> quantity) && ($this-> getIdProdu() >0) ){
          if( ($this-> getIdWorker() >0) ){

              $run= $this-> conn -> prepare("SELECT * produto WHERE idProd =:ID");
              $run->bindParam(":ID",$this -> getIdProdu(),PDO::PARAM_INT);
              if($run->execute()){
                if($run->rowCunt() >0){
                   $row = $run->fetch(PDO::FETCH_OBJ);
                   $this-> existence = $row->existencia;
                   $this-> priceSell = $row->precoVenda;
                }
              }

          }
        }
      }//End function

      
      
    }//End class