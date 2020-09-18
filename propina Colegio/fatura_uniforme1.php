<?php
ob_start();
session_start();
if(!isset($_SESSION['nomeS']) && (!isset($_SESSION['senhaS'])))
{
    header("location:index.php?acao=negado");exit;
}

$nome=$_SESSION['nomeS'];
$titulo=$_SESSION['tituloS'];
$foto=$_SESSION['fotoS'];

require_once("conn2.php");

$funcionario=$_SESSION['nomeS'];
$titulo=$_SESSION['tituloS'];
$id_aluno= $_SESSION['idaluno'];
$id_pessoa = $_SESSION['idpessoa'];
$nome_aluno = $_SESSION['nome_aluno'];
$cliente = $_SESSION['cliente'];  $numerotalao= $_SESSION['numerotalao']; 
$dataDeposito = $_SESSION['dataDeposito'];
$anoLectivo = $_SESSION['anoLectivo'];

$arrayQntd = array();
/**
     * 
     */
    class SellUniforme
    { 
      private $conn;
      private $idWorker;
      private $idClass;
      private $idProdu;
      private $idPerson;
      public $priceSell;
      public $priceBuy;
      public $product;
      public $quantity;      
      public $capital;
      public $profit;
      public $existence;
      public $total=0;
      public $year;
      public $time;
      public $dateSimple;
      public $worker;
      public $client;
      public $response=0;
      private $responseUpdate=false;
      private $responseSave=0;
      public $totalPay=0;

      public $name;
      public $course;
      public $level;
      public $classroom;
      public $period;

      public function getConnection(){ return $this-> conn;}
      public function setConnection($conn){ $this-> conn = $conn; }
      public function getIdPerson(){ return $this-> idPerson;}
      public function setIdPerson($idPerson){ $this-> idPerson = $idPerson; }
      public function getIdWorker(){ return $this-> idWorker;}
      public function setIdWorker($idWorker){ $this-> idWorker = $idWorker; }
      public function getIdClass(){ return $this-> idClass; }
      public function setIdClass($idClass){ $this-> idClass = $idClass; }
      public function getIdProdu(){ return $this-> idProdu; }
      public function setIdProdu($idProdu){ $this-> idProdu = $idProdu; }
      public function getResponseSave(){ return $this-> responseSave; }
      public function setResponseSave($responseSave){ $this-> responseSave = $responseSave;}
      public function getResponseUpdate(){ return $this-> responseUpdate; }
      public function setResponseUpdate($responseUpdate){ $this-> responseUpdate = $responseUpdate; }

      public function selectClass(){
        try{
            if($this-> getIdClass() >0){
                 
                $result=$this-> getConnection() ->prepare("SELECT*FROM view_historico WHERE id_aluno=:pro and anolectivo=:ano");
                $result->bindParam(":pro",$this-> idClass,PDO::PARAM_STR);
                $result->bindParam(":ano",$this-> year,PDO::PARAM_STR);
                $result->execute();
                $vt=$result->fetch(PDO::FETCH_OBJ);
                $this-> name = utf8_encode($vt->nome);
                $this-> course = utf8_encode($vt->curso);
                $this-> level = $vt->classe;
                $this-> classroom = $vt->turma;
                $this-> period = $vt->turno; 

            }
          }catch(PDOException $e){   echo $e;   }

      }//End function
      public function selectProduto(){echo "Dentro da classe";
        try{
          if($this -> getIdProdu() > 0){
            $run= $this-> getConnection() -> prepare("SELECT * FROM produto WHERE idProd =:ID");
            $run->bindParam(":ID",$this -> getIdProdu(),PDO::PARAM_INT);
            if($run->execute()){
              if($run->rowCount() >0){
                 $row = $run->fetch(PDO::FETCH_OBJ);
                 $this-> product = utf8_encode($row->produto);
                 $this-> existence = $row->existencia;
                 $this-> priceSell = $row->precoVenda;
                 $this-> total = $this-> quantity * $this-> priceSell; 
                 $this-> saveSell();
                 $this-> selectClass();
              }
            }

          }
        } catch(PDOException $e){  echo $e;  }
        
      }//End function
      public function selectSelled(){        
        try{
          if($this -> getIdProdu() > 0){
            $run= $this-> getConnection() -> prepare("SELECT * FROM produto WHERE idProd =:ID");
            $run->bindParam(":ID",$this -> getIdProdu(),PDO::PARAM_INT);
            if($run->execute()){
              if($run->rowCount() >0){
                 $row = $run->fetch(PDO::FETCH_OBJ);
                 $this-> product = utf8_encode($row->produto);
                 $this-> existence = $row->existencia;
                 $this-> priceSell = $row->precoVenda;
                 $this-> total = $this-> quantity * $this-> priceSell; 
                 $this-> saveSell();
              }
            }

          }
        } catch(PDOException $e){  echo $e;  }
      }//End function
       public function saveSell(){
          try{
            if(($this-> priceSell > 0) && ($this-> existence >= $this-> quantity) && ($this-> getIdProdu() >0) ){
              if( ($this-> worker !="") ){

                $this-> totalPay = $this-> totalPay + $this-> total;
                $ru2=$this-> getConnection() ->prepare("INSERT INTO venderproduto (pessoa_id,cliente,produto,preco,quant,total,funcionario,dataRegisto) VALUES (:IDPESS,:CLIENT,:PRODUTO,:PRECO,:QUANT,:TOTAL,:FUNCION,NOW())");
                $ru2->bindParam(":IDPESS",$this-> getIdPerson(),PDO::PARAM_INT);
                $ru2->bindParam(":CLIENT",$this-> client,PDO::PARAM_STR);
                $ru2->bindParam(":PRODUTO",$this-> product,PDO::PARAM_STR);
                $ru2->bindParam(":PRECO",$this-> priceSell,PDO::PARAM_STR);
                $ru2->bindParam(":QUANT",$this-> quantity,PDO::PARAM_STR);
                $ru2->bindParam(":TOTAL",$this-> total,PDO::PARAM_STR);
                $ru2->bindParam(":FUNCION",$this-> worker,PDO::PARAM_STR);
                if($ru2->execute()):
                  $this-> setResponseSave(1);
                  $this-> updateProduct();
                endif; 
              
              }
            }
          } catch(PDOException $e){  echo $e;  }
      }//End function
      public function updateProduct(){
        try{
            if(($this-> existence > $this-> quantity) && ($this-> getIdProdu() >0) ){
                  $this-> existence = $this-> existence - $this-> quantity;
                  $run= $this-> getConnection() -> prepare("UPDATE produto SET existencia=:EXIST, dataRegisto =NOW() WHERE idProd =:ID");
                  $run->bindParam(":ID",$this -> getIdProdu(),PDO::PARAM_INT);
                  $run->bindParam(":EXIST",$this -> existence,PDO::PARAM_INT);
                  if($run->execute()){
                    $this-> setResponseUpdate(true);
                  }
            }
          } catch(PDOException $e){  echo $e;  }
      }//End function
      public function answer(){
        echo "Worker: ".$this -> worker." Produt: ".$this-> product." Preco: ".$this-> priceSell." Total: ".$this-> total." Cliente: ".$this-> client." NomeA: ".$this-> name." Curs: ".$this-> course." Classe: " .$this-> level." Periodo: ".$this-> period."<br/><br/>";
      }

      
      
    }//End class
    $save = new SellUniforme();
    if(!isset($_GET['accao'])):
    elseif((isset($_GET['accao'])) && ($_GET['accao'] =="save")):
         
        if(count($_SESSION['carrinho']) ==0){
           echo ('<tr><td colspan="5">Não há produto no carrinho! </td></tr>') ;
               
        }else{ $run=0;
              $totalPay=0;
              //Percorrendo o array de  session carrinho
                  foreach ($_SESSION['carrinho'] as $id => $qtd) {                

                     try{
                         $result=$con2->prepare("SELECT*FROM produto WHERE idProd=:IDPRO ORDER BY produto ASC");
                         $result->bindParam(":IDPRO",$id,PDO::PARAM_STR);
                        
                        if($result->execute()){
                          if($result->rowCount() >0){
                            $va=$result->fetch(PDO::FETCH_OBJ);
                            //prod[] é um array que armazena uma pilha de IDs e quantidades dos produtos
                            $idPFarma = $va->idProd;
                            $produto = $va->produto;
                            $code = $va->precoCompra;
                            $forma = $va->precoVenda;
                            $id;
                            $qtd;
                            $preco =$va->precoVenda;
                            $subtotal = $va->precoVenda * $qtd;
                           
                            $totalPay = $totalPay + $subtotal;
                            echo($cliente);
                            //echo $id." _Nome: ".$produto." Quantidade: ".$qtd." Preço: ".$preco." SubTotal: ".$subtotal." TotalPay: ".$totalPay;

                            
                          }
                        }
                    }catch(PDOException $e) {       echo $e;    }

                  }
        }  
    endif;
/*
$cliente=$_POST['cliente'];
$quant=1;
$hora=date("H:i:s");
$ano=date("Y");
$data=date("d-m-Y");

$usuario=$_SESSION['nomeS'];


$save-> setConnection($con2);
$save-> setIdPerson($id_pessoa);
$save-> setIdClass($id_aluno);
$save-> client = $cliente;
$save-> worker = $funcionario;
$save-> year = $ano;
$save-> data = $data;
$save-> time = $hora;  

$string2=explode("-",$data);
if($string2[1]==1):
$mes2="Janeiro";

endif;

if((isset($_POST['tipo_produto'])) && (isset($_POST['qntd']))):
    $a=0;$i=0; $j=0;

    if(is_array($_POST['qntd'])){
      foreach ($_POST['qntd'] as $id =>$qntd) {$i++;
        //$arrayQntd[$i] = $qntd; 
        $qntd=intval($qntd);  
        echo "QNTD: ".$qntd." ID: ".$id.' <br>';  
      }
    } 
   
    foreach($_POST['tipo_produto'] as $num => $D)
    {
        $a++;
        
        echo "Contador: ".$num." Q: ".$D;
    }

    foreach($_POST['tipo_produto'] as $value)
    { $j++;        
       
        $save-> quantity = $quant;
        $save-> setIdProdu($value);
        $save-> selectProduto(); 

        
    }
endif;*/
/*
$html="<html>
<head><title></title>
<style>
.cabe
{
   font-family:arial; 
   font-size:12px;
    }
    .el{
 margin-left:460px;
 margin-top:-80px; 
     font-family:arial;
     border:1px solid #000;
     padding-left:3px;
     padding-top:2px; 
     padding-bottom:2px;
     font-size:12px;
        }
        
        .nm{ 
     font-family:arial;
     border: 1px solid #000;
     background-color:#f5f5f5;
     font-size:12px;
     
        }
        #pi
        {
            padding-top:5px;
            padding-bottom:5px;
         border-bottom: 1px solid #000;
         text-align:center;
         font-size:12px;   
            }
            #sec
            {
         border-right: 1px solid #000;

                }
    .b
    {
        text-align:center;
       
        }
        .desig
        {
            font-weight:bold;
   text-align:center; 
   font-size:12px;
            }
              .design
        {
   text-align:center; 
            }

       #iop
       {
        font-family:arial;
        font-size:12px;
        width:100%;
        border:1px solid #000;
        font-size:12px;
        }
        .table1
        {
           border: 1px solid #000;
           font-family:arial;
           font-size:12px; 
            }
            .cvb
            {
               border-bottom:1px solid #000;
               background-color:#f5f5f5; 
                }
                 .bn
            {
               border-top:1px solid #000;
               background-color:#f5f5f5; 
                }
                .vfg
                {
                  border-bottom:1px solid #000;
                   background-color:#f5f5f5;
                    }
                    .vfk
                {
                  border-right:1px solid #000;
                    }
                    #fafa
                    {
                        border:1px solid #000;
                        font-family:arial;
                        background-color:#f5f5f5;
                        font-size:12px;
                        
                        }
                    #fafa1
                    {
                        border-right:1px solid #000;
                        }
</style>

</head>
<body>
<div class='cabe'>
<br/>
<strong>ESCOLA PRIMÁRIA E Iº CÍCLO LAR DOS PEQUENINOS <BR/>DAS IRMÃS DO SANTÍSSIMO SALVADOR-HUAMBO</strong><br/>
NIF: 5121019874<br/>
</div>
<div class='el'>
Exmo. Sr.<br/>
<B>{$cliente}</B><br/>
<b>HUAMBO-ANGOLA</b>
</div>
<br/>
<br/>
<div class='ely'>
<table border='0' class='nm'>
<tr>
<td colspan='2' id='pi'><b>VENDA DE UNIFORME ESCOLAR</b></td>
</tr>
<tr>
<td id='sec'>Fact. Nº: {$quant}</td>
<td>Data: {$data} <br/> {$hora}</td>
</tr>
</table>
</div>
<div class='dados_a'>
<table border='0' id='iop'>
<tr>
<td  class='vfg'>Nº Processo</td>
<td  class='vfg'>Nome Completo</td>
<td  class='vfg'>Curso</td>
<td  class='vfg'>Classe</td>
<td  class='vfg'>Turma</td>
<td  class='vfg'>Turno</td>
<td  class='vfg'>Ano Lectivo</td>
</tr>
<tr>
<td class='vfk'>{$save-> getIdClass()}</td>
<td class='vfk'>{$save-> name}</td>
<td class='vfk'>{$save-> course}</td>
<td class='vfk'>{$save-> level}</td>
<td class='vfk'>{$save-> classroom}</td>
<td class='vfk'>{$save-> period}</td>
<td>{$ano}</td>
</tr>
</table>
</div>
<br/>
";


$html.="<table class='table1' id='vb' width='500'>
<tr>
<th class='cvb'>Uniforme</th>
<th class='cvb'>Preço</th>
<th class='cvb'>Total</th>

</tr>";

foreach($_POST['tipo_produto'] as $num)
{
     
   $save-> setIdProdu($num);
   $save-> selectProduto();
   
    $html.="
    <tr>
    <tr>
    <td>{$save-> product}</td>
    <td>{$save-> priceSell},00 KZs</td>
    <td >{$save-> total},00 KZs</td>
    </tr>
    ";
}

$html.="
<tr>
<th class='bn'>Total Pago</th>";
$html.="<td class='bn'>{$save-> totalPay},00 KZs</td>
</tr>
</table>

<br/>
<pre>
      Encarregado                                           Secretaria
_______________________                               ______________________
                                                              {$usuario}
----------------------------------------------------------------------------</pre>

";

$html.="<div class='ely'>
<table border='0' class='nm'>
<tr>
<td colspan='2' id='pi'><b>PAGAMENTO DE FOLHA DE PROVA</b></td>
</tr>
<tr>
<td id='sec'>Fact. Nº: {$quant}</td>
<td>Data: {$data} <br/> {$hora}</td>
</tr>
</table>
</div>
<div class='dados_a'>
<table border='0' id='iop'>
<tr>
<td  class='vfg'>Nº Processo</td>
<td  class='vfg'>Nome Completo</td>
<td  class='vfg'>Curso</td>
<td  class='vfg'>Classe</td>
<td  class='vfg'>Turma</td>
<td  class='vfg'>Turno</td>
<td  class='vfg'>Ano Lectivo</td>
</tr>
<tr> 
<td class='vfk'>{$save-> getIdClass()}</td>
<td class='vfk'>{$save-> name}</td>
<td class='vfk'>{$save-> course}</td>
<td class='vfk'>{$save-> level}</td>
<td class='vfk'>{$save-> classroom}</td>
<td class='vfk'>{$save-> period}</td>
<td>{$ano}</td>
</tr>
</table>
</div>
<br/>
";

$html.="<table class='table1' id='vb' width='500'>
<tr>
<th class='cvb'>Uniforme</th>
<th class='cvb'>Preço</th>
<th >Total</th>
</tr>";

foreach($_POST['tipo_produto'] as $num)
{
   $save-> setIdProdu($num);
   $save-> selectProduto();
      
    $html.="
    <tr>
    <tr>
    <td>{$save-> product}</td>
    <td>{$save-> priceSell},00 KZs</td>
    <td class='bn'>{$save-> total},00 KZs</td>
    </tr>
    ";

}
$html.="
<tr>
<th class='bn'>Total</th>";

$html.="<td class='bn'>{$save-> total},00 KZs</td>
</table>
<br/>
<pre>
      Encarregado                                           Secretaria
_______________________                               ______________________
                                                              {$usuario}
----------------------------------------------------------------------------</pre>
";




$html.="
</body>
</html>";

include("mpdf/mpdf.php");
$mpdf=new mPDF('c','A4'); 
$mpdf->WriteHTML($html);
$mpdf->Output();
exit;
 */
?>
