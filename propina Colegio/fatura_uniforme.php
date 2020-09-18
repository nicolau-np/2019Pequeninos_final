<?php
//ob_start();
//session_start();
require_once("conn2.php");

$funcionario=$_SESSION['nomeS'];
$titulo=$_SESSION['tituloS'];
$id_aluno= $_SESSION['idaluno'];
$id_pessoa = $_SESSION['idpessoa'];
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
      public $resto=0;     
      public $capital;
      public $profit;
      public $existence;
      public $total=0;
      public $year;
      public $times;
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
      public $genero;

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
      public function selectProduto(){ $rs=0;
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
                 if($this-> existence > $this-> quantity){
                   $rs = $this-> saveSell();
                   $this-> selectClass();
                 }
              }
            }

          }
        } catch(PDOException $e){  echo $e;  }
        return $rs;
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
                 $this-> total = $this-> quantity * $row->precoVenda; 
                 $this-> saveSell();
              }
            }

          }
        } catch(PDOException $e){  echo $e;  }
      }//End function
       public function saveSell(){ $rs=0;
          try{
            if(($this-> priceSell > 0) && ($this-> getIdProdu() >0) ){
              if( ($this-> worker !="") ){
$anos33=date("Y");
                $this-> totalPay = $this-> totalPay + $this-> total;
                
                $sql88="select *from view_historico where id_pessoa=:id";
                $run88=  $this->conn->prepare($sql88);
                $run88->bindParam(":id", $this->idPerson, PDO::PARAM_STR);
                $run88->execute();
                $v88=$run88->fetch(PDO::FETCH_OBJ);
                
                
                $ru2=$this-> conn->prepare("INSERT INTO venderproduto (pessoa_id,cliente,produto,preco,quant,total,funcionario,ano,genrro,dataRegisto) VALUES (:IDPESS,:CLIENT,:PRODUTO,:PRECO,:QUANT,:TOTAL,:FUNCION,:ano,:genero,NOW())");
                $ru2->bindParam(":IDPESS",$this-> getIdPerson(),PDO::PARAM_INT);
                $ru2->bindParam(":CLIENT",$this-> client,PDO::PARAM_STR);
                $ru2->bindParam(":PRODUTO",$this-> product,PDO::PARAM_STR);
                $ru2->bindParam(":PRECO",$this-> priceSell,PDO::PARAM_STR);
                $ru2->bindParam(":QUANT",$this-> quantity,PDO::PARAM_STR);
                $ru2->bindParam(":TOTAL",$this-> total,PDO::PARAM_STR);
                $ru2->bindParam(":FUNCION",$this-> worker,PDO::PARAM_STR);
                $ru2->bindParam(":ano",$anos33,PDO::PARAM_STR);
                $ru2->bindParam(":genero",  $v88->genero,PDO::PARAM_STR);
                if($ru2->execute()):
                  $rs=1;
                  $this-> setResponseSave(1);
                  $this-> updateProduct();
                endif; 
              
              }
            }
          } catch(PDOException $e){  echo $e;  }
          return $rs;
      }//End function
      public function updateProduct(){
        try{
            if(($this-> existence > $this-> quantity) && ($this-> getIdProdu() >0) ){
                  $this-> resto = $this-> existence - $this-> quantity;
                  $run= $this-> conn -> prepare("UPDATE produto SET existencia=:EXIST, dataRegisto =NOW() WHERE idProd =:ID");
                  $run->bindParam(":ID",$this -> getIdProdu(),PDO::PARAM_INT);
                  $run->bindParam(":EXIST",$this -> resto,PDO::PARAM_INT);
                  if($run->execute()){
                    $this-> setResponseUpdate(true);
                  }
            }
          } catch(PDOException $e){  echo $e;  }
          return "OK";
      }//End function
      private function answer(){
        echo "Worker: ".$this -> worker." Produt: ".$this-> product." Preco: ".$this-> priceSell." Total: ".$this-> total." Cliente: ".$this-> client." NomeA: ".$this-> name." Curs: ".$this-> course." Classe: " .$this-> level." Periodo: ".$this-> period."<br/><br/>";
      }
      public function relatorio(){
       
            $preco = number_format($this-> priceSell,2,',','.'); 
            $total = number_format($this-> total,2,',','.'); 
            $totalPay = number_format($this-> totalPay,2,',','.'); 

           if($_SESSION['carrinho'] !=0){ 
              foreach ($_SESSION['carrinho'] as $id => $qntd) {
                
              }//End foreach
           }//End if
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
            <B>{$this-> client}</B><br/>
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
            <td id='sec'>Fact. Nº: {$this-> quantity}</td>
            <td>Data: {$this-> dateSimple} <br/> {$this-> times}</td>
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
            <td class='vfk'>{$this-> idClass}</td>
            <td class='vfk'>{$this-> name}</td>
            <td class='vfk'>{$this-> course}</td>
            <td class='vfk'>{$this-> level}</td>
            <td class='vfk'>{$this-> classroom}</td>
            <td class='vfk'>{$this-> period}</td>
            <td>{$this-> year}</td>
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

           /*foreach($_POST['tipo_produto'] as $num)
            {
                 
               $save-> setIdProdu($num);
               $save-> selectProduto();*/
                
                $html.="
                <tr>
                <tr>
                <td>{$this-> product}</td>
                <td>{$preco} KZs</td>
                <td >{$total} KZs</td>
                </tr>
                ";
            //}

            $html.="
            <tr>
            <th class='bn'>Total Pago</th>";
            $html.="<td class='bn'>{$totalPay} KZs</td>
            </tr>
            </table>

            <br/>
            <pre>
  Cliente                                 Funcionario
  _______________________                 ______________________
  {$this-> client}                                {$this-> worker}
----------------------------------------------------------------------------</pre>

            ";

            $html.="
            <div class='cabe'>
            <br/>
            <strong>ESCOLA PRIMÁRIA E Iº CÍCLO LAR DOS PEQUENINOS <BR/>DAS IRMÃS DO SANTÍSSIMO SALVADOR-HUAMBO</strong><br/>
            NIF: 5121019874<br/>
            </div>
            <div class='el'>
            Exmo. Sr.<br/>
            <B>{$this-> client}</B><br/>
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
            <td id='sec'>Fact. Nº: </td>
            <td>Data: {$this-> dateSimple} <br/>{$this-> times} </td>
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
            <td class='vfk'>{$this-> idClass}</td>
            <td class='vfk'>{$this-> name}</td>
            <td class='vfk'>{$this-> course}</td>
            <td class='vfk'>{$this-> level}</td>
            <td class='vfk'>{$this-> classroom}</td>
            <td class='vfk'>{$this-> period}</td>
            <td>{$this-> year}</td>
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

            /*foreach($_POST['tipo_produto'] as $num)
            {
               $save-> setIdProdu($num);
               $save-> selectProduto(); */
                  
                $html.="
                <tr>
                <tr>
                <td>{$this-> product}</td>
                <td>{$preco} KZs</td>
                <td class='bn'>{$total} KZs</td>
                </tr>
                ";

           // }
            $html.="
            <tr>
            <th class='bn'>Total</th>";

            $html.="<td class='bn'>$totalPay KZs</td>
            </table>
            <br/>
            <pre>
  Cliente                                 Funcionario
  _______________________                 ______________________
  {$this-> client}                                {$this-> worker}
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
            

      }//End function

      
      
    }//End class
    
?>
