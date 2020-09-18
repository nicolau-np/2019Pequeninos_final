<?php
Class Marcar_multas{
    public $con;
    public $estado1;
    public $estado2;
    public $pago1;
    public $pago2;
    public $dia;
    public $mes;
    public $data;
    public $ano;
    public function __construct($con) {
        $this->con=$con;
        $this->estado1="on";
        $this->estado2="off";
        $this->pago1="sim";
        $this->pago2="nao";
        $this->dia=date("d");
        $this->data=date("d-m-Y");
        $this->ano=date("Y");
        $mesN=date("m");
        
        if($mesN==1){
            $this->mes="Janeiro";
        }
        elseif($mesN==2){
            $this->mes="Fevereiro";
        }
         elseif($mesN==3){
            $this->mes="Março";
        }
         elseif($mesN==4){
            $this->mes="Abril";
        }
         elseif($mesN==5){
            $this->mes="Maio";
        }
         elseif($mesN==6){
            $this->mes="Junho";
        }
         elseif($mesN==7){
            $this->mes="Julho";
        }
         elseif($mesN==8){
            $this->mes="Agosto";
        }
         elseif($mesN==9){
            $this->mes="Setembro";
        }
         elseif($mesN==10){
            $this->mes="Outubro";
        }
         elseif($mesN==11){
            $this->mes="Novembro";
        }
         elseif($mesN==12){
            $this->mes="Dezembro";
        }
      
    }


    
    public function verificar_alunos(){
    if($this->dia >= 11):
        try {
           $se="select *from ver where pago=:pago2 and ano_lectivo=:ano and mes=:mes";
    $run=  $this->con->prepare($se);
    $run->bindParam(":pago2",  $this->pago2,  PDO::PARAM_STR);
     $run->bindParam(":ano",  $this->ano,  PDO::PARAM_STR);
     $run->bindParam(":mes",  $this->mes, PDO::PARAM_STR);
    $run->execute();
    $contar=$run->rowCount();
  while($view=$run->fetch(PDO::FETCH_OBJ)){
      try {
          $ise="select *from tbl_multas where id_aluno=:id and ano_lectivo=:ano and mes_multa=:mes";
          $run0=  $this->con->prepare($ise); 
          $run0->bindParam(":id",$view->id_aluno,PDO::PARAM_STR);
       $run0->bindParam(":ano",$this->ano,PDO::PARAM_STR);
        $run0->bindParam(":mes",$this->mes,PDO::PARAM_STR);
        $run0->execute();
        $re=$run0->rowCount();
        if($re>0):
         
        else:
            $insert="insert into tbl_multas (id_aluno,ano_lectivo,mes_multa,estado)
              values(:id,:ano,:mes,:estado)";
      $run2=  $this->con->prepare($insert);
      $run2->bindParam(":id",$view->id_aluno,PDO::PARAM_STR);
       $run2->bindParam(":ano",$this->ano,PDO::PARAM_STR);
        $run2->bindParam(":mes",$this->mes,PDO::PARAM_STR);
         $run2->bindParam(":estado",  $this->estado1,PDO::PARAM_STR);
      $run2->execute(); 
      echo '<div class="alert alert-success">Estudantes Multados '.$contar.'</div>';
       
        endif;
          
    } catch (PDOException $e) {
        echo $e->getMessage();  
      }
 
              
  }
 
        } catch (PDOException $e) {
            echo $e->getMessage();
       
        }
  
    endif;
        
    

    }
    
}

?>
