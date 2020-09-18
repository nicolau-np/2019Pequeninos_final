<?php

   /**
    * 
    */
   class Factura
   {  
   	  private $conn;
   	  private $idFatura;
   	  public $numberF;
   	  public $init=0;
   	  public $year;
   	  public $ano;
   	  public $monthYear;

   	  public function getConnection(){ return $this-> conn; }
   	  public function setConnection($conn){ $this-> conn = $conn; }

   	  public function selectFactura(){
   	  	$this-> year = date('Y');
   	  	$this-> monthYear = date('md'); 
   	  	
		$vbi=$this-> getConnection() ->prepare("select *from tbl_fatura order by id_fatura desc");
		if($vbi->execute()){
			$cc=$vbi->fetch(PDO::FETCH_OBJ);
			$this-> ano = $cc->ano;
			if(($this-> year!=$this-> ano)&&($cc->numero>0))
			{
			 $this-> init =1;
			 $this-> saveFactura();
			}
		   
		}
		
   	  }//
   	  public function selectFactura1(){
   	  	
	   	  	if($this-> year == $this-> ano){
				$vbi=$this-> getConnection() ->prepare("select *from tbl_fatura order by id_fatura desc");
					if($vbi->execute()){
						$cc=$vbi->fetch(PDO::FETCH_OBJ);
						$this-> init = $cc->numero+1;						
						$this-> saveFactura();
					}
					   
				
			}	
	  }	
   	  public function saveFactura(){
   	  	
		$reve=$this-> getConnection() ->prepare("insert into tbl_fatura(numero,ano) values(:numero,:ano)");
		$reve->bindParam(":numero",$this-> init,PDO::PARAM_STR);
		$reve->bindParam(":ano",$this-> year,PDO::PARAM_STR);
		;
		if($reve->execute())
		{
		    $this-> numberF =$this-> year."".$this-> monthYear."".$this-> init;
		}
   	  }
   	
   }//End Class