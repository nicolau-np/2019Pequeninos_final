<?php

class Importar_Fatura {
    public $CON;
    
     public function __construct($con) {
        $this->CON=$con;
     
    }
    
public function  salvar_fatura($numero,$ano){
$sql="insert into tbl_fatura (numero,ano) values (:nu,:ano)";
try{
    $run=  $this->CON->prepare($sql);
    $run->bindParam(":nu",$numero,PDO::PARAM_STR);
    $run->bindParam(":ano",$ano,PDO::PARAM_STR);
    $run->execute();
    if($run):
        echo 'cadastrado com sucesso';
    endif;
} catch (PDOException $e) {
echo $e->getMessage();
}

}


}
?>