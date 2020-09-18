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

$cliente=$_POST['cliente'];
$quant=1;
$hora=date("H:i:s");
$ano=date("Y");
$data=date("d-m-Y");
$id_aluno=$_SESSION['idaluno'];
$usuario=$_SESSION['nomeS'];

$funcionario=$_SESSION['nomeS'];
$titulo=$_SESSION['tituloS'];
$id_aluno= $_SESSION['idaluno'];
$id_pessoa = $_SESSION['idpessoa'];
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
      public $response;
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

      public function selectClass(){
        try{
            if($this-> getIdClass() >0){
                 
                $result=$this-> conn->prepare("SELECT*FROM view_historico WHERE id_aluno=:pro and anolectivo=:ano");
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
      public function selectProduto(){
        try{
          if($this -> getIdProdu() > 0){
            $run= $this-> conn -> prepare("SELECT * FROM produto WHERE idProd =:ID");
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
            $run= $this-> conn -> prepare("SELECT * FROM produto WHERE idProd =:ID");
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
                $ru2=$this-> conn->prepare("INSERT INTO venderproduto (pessoa_id,cliente,produto,preco,quant,total,funcionario,dataRegisto) VALUES (:IDPESS,:CLIENT,:PRODUTO,:PRECO,:QUANT,:TOTAL,:FUNCION,NOW())");
                $ru2->bindParam(":IDPESS",$this-> getIdPerson(),PDO::PARAM_INT);
                $ru2->bindParam(":CLIENT",$this-> client,PDO::PARAM_STR);
                $ru2->bindParam(":PRODUTO",$this-> product,PDO::PARAM_STR);
                $ru2->bindParam(":PRECO",$this-> priceSell,PDO::PARAM_STR);
                $ru2->bindParam(":QUANT",$this-> quantity,PDO::PARAM_STR);
                $ru2->bindParam(":TOTAL",$this-> total,PDO::PARAM_STR);
                $ru2->bindParam(":FUNCION",$this-> worker,PDO::PARAM_STR);
                if($ru2->execute()):
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
                  $run= $this-> conn -> prepare("UPDATE produto SET existencia=:EXIST, dataRegisto =NOW() WHERE idProd =:ID");
                  $run->bindParam(":ID",$this -> getIdProdu(),PDO::PARAM_INT);
                  $run->bindParam(":EXIST",$this -> existence,PDO::PARAM_INT);
                  if($run->execute()){
                    //$this-> answer();
                  }
            }
          } catch(PDOException $e){  echo $e;  }
      }//End function
      private function answer(){
        echo "Worker: ".$this -> worker." Produt: ".$this-> product." Preco: ".$this-> priceSell." Total: ".$this-> total." Cliente: ".$this-> client." NomeA: ".$this-> name." Curs: ".$this-> course." Classe: " .$this-> level." Periodo: ".$this-> period."<br/><br/>";
      }

      
      
    }//End class
    $save = new SellUniforme();

    $save-> setConnection($con2);
$save-> setIdPerson($id_pessoa);
$save-> setIdClass($id_aluno);
$save-> client = $cliente;
$save-> worker = $funcionario;
$save-> year = $ano;
$save-> data = $data;
$save-> time = $hora;  



$pri="select *from tbl_fatura order by id_fatura desc";
$vbi=$con2->prepare($pri);
$vbi->execute();
$cc=$vbi->fetch(PDO::FETCH_OBJ);
if(($cc->ano!=$ano)&&($cc->numero>0))
{
$som=1;
$ins="insert into tbl_fatura(numero,ano) values(:numero,:ano)";
$reve=$con2->prepare($ins);
$reve->bindParam(":numero",$som,PDO::PARAM_STR);
$reve->bindParam(":ano",$ano,PDO::PARAM_STR);
$reve->execute();
if(!$reve)
{
    echo "erro";
}
else
{
  $numero_fatura=$ano."".date("md")."".$som;   
}
   
}
elseif(($cc->ano==$ano))
{
$sele="select *from tbl_fatura order by id_fatura desc";
$rvb=$con2->prepare($sele);
$rvb->execute();
$comt=$rvb->fetch(PDO::FETCH_OBJ);
$som=$comt->numero+1;
$ins="insert into tbl_fatura(numero,ano) values(:numero,:ano)";
$reve1=$con2->prepare($ins);
$reve1->bindParam(":numero",$som,PDO::PARAM_STR);
$reve1->bindParam(":ano",$ano,PDO::PARAM_STR);
$reve1->execute();
$numero_fatura=$ano."".date("md")."".$som;   
}

$a=0;
foreach($_POST['tipo_produto'] as $num)
{
    $a++;
}


$total_pagamento=$a;


$estado="on";
foreach($_POST['tipo_produto'] as $num)
{

    $save-> quantity = $quant;
    $save-> setIdProdu($num);
    $save-> selectProduto();

    $com="select *from tbl_pagamento_folha where id_aluno=:id  and tipo_prova=:tipo and hora=:hora and data_pagamento=:data";
    $ru1=$con2->prepare($com);
    $ru1->bindParam(":id",$id_aluno,PDO::PARAM_STR);
    $ru1->bindParam(":tipo",$num,PDO::PARAM_STR);
    $ru1->bindParam(":hora",$hora,PDO::PARAM_STR);
    $ru1->bindParam(":data",$data,PDO::PARAM_STR);
    $ru1->execute();
    $cont=$ru1->rowCount();
    if($cont>0){
        
    }
    else{
         
    }
}
$col="select *from view_historico where id_aluno=:pro and anolectivo=:ano";
try
{
    $result=$con2->prepare($col);
    $result->bindParam(":pro",$id_aluno,PDO::PARAM_STR);
	$result->bindParam(":ano",$ano,PDO::PARAM_STR);
    $result->execute();
 $vt=$result->fetch(PDO::FETCH_OBJ);

}
catch(PDOException $e)
{
    echo $e;
}




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
<td colspan='2' id='pi'><b>PAGAMENTO DE FOLHA DE PROVA</b></td>
</tr>
<tr>
<td id='sec'>Fact. Nº: {$numero_fatura}</td>
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
<td class='vfk'>{$vt->id_aluno}</td>
<td class='vfk'>{$vt->nome}</td>
<td class='vfk'>{$vt->curso}</td>
<td class='vfk'>{$vt->classe}</td>
<td class='vfk'>{$vt->turma}</td>
<td class='vfk'>{$vt->turno}</td>
<td>{$ano}</td>
</tr>
</table>
</div>
<br/>
";


$html.="<table class='table1' id='vb' width='500'>
<tr>
<th class='cvb'>Tipo de Prova</th>
<th class='cvb'>Valor Pago</th>

</tr>";

foreach($_POST['tipo_produto'] as $num)
{
       
$html.="
<tr>
<td>Amoxa</td>
<td>2,00</td>

</tr>
";
 
}
$html.="
<tr>
<th class='bn'>Total</th>";

$se2="SELECT SUM(valor_pago) FROM tbl_pagamento_folha where id_aluno=:id and ano_lectivo=:ano and data_pagamento=:data and hora=:hora";
$run2=$con2->prepare($se2);
$run2->bindParam(":id",$id_aluno,  PDO::PARAM_STR);
$run2->bindParam(":ano",$ano,  PDO::PARAM_STR);
$run2->bindParam(":data",$data,  PDO::PARAM_STR);
$run2->bindParam(":hora",$hora,  PDO::PARAM_STR);
$run2->execute();
$soma=$run2->fetchColumn();


$html.="<td class='bn'>$soma,00</td>
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
<td id='sec'>Fact. Nº: {$numero_fatura}</td>
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
<td class='vfk'>{$vt->id_aluno}</td>
<td class='vfk'>{$vt->nome}</td>
<td class='vfk'>{$vt->curso}</td>
<td class='vfk'>{$vt->classe}</td>
<td class='vfk'>{$vt->turma}</td>
<td class='vfk'>{$vt->turno}</td>
<td>{$ano}</td>
</tr>
</table>
</div>
<br/>
";


$html.="<table class='table1' id='vb' width='500'>
<tr>
<th class='cvb'>Tipo de Prova</th>
<th class='cvb'>Valor Pago</th>
</tr>";

foreach($_POST['tipo_produto'] as $num)
{
      
        $produto = $save-> product; 
$html.="
<tr>
<tr>
<td>$produto</td>
<td>1,00</td>
</tr>
";
 
}
$html.="
<tr>
<th class='bn'>Total</th>";

$se2="SELECT SUM(valor_pago) FROM tbl_pagamento_folha where id_aluno=:id and ano_lectivo=:ano and data_pagamento=:data and hora=:hora";
$run2=$con2->prepare($se2);
$run2->bindParam(":id",$id_aluno,  PDO::PARAM_STR);
$run2->bindParam(":ano",$ano,  PDO::PARAM_STR);
$run2->bindParam(":data",$data,  PDO::PARAM_STR);
$run2->bindParam(":hora",$hora,  PDO::PARAM_STR);
$run2->execute();
$soma=$run2->fetchColumn();
$html.="<td class='bn'>$soma,00</td>
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
?>
