<?php
//ob_start();
//session_start();
require_once("conn2.php");

/*$funcionario=$_SESSION['nomeS'];
$titulo=$_SESSION['tituloS'];
$id_aluno= $_SESSION['idaluno'];
$id_pessoa = $_SESSION['idpessoa'];
$arrayQntd = array();*/

//echo "IDA: ".$_POST['sv'];
/**
     * 
     */
    class PaymentsService
    { 
      private $conn;
      private $idWorker;
      private $idClass;
      private $idpagamento;
      private $idSubject;
      private $idPerson;
      public $numberFactura=0;
      private $ticketNumber=0;
      public $dataDeposito;
      public $priceSell;
      public $priceBuy;
      public $subject;
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
      public $type;
      public $category;
      public $response=0;
      public $totalPay=0;
      public $state;
      private $responseUpdate=false;
      private $responseSave=0;


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
      public function getIdPagamento(){ return $this-> idpagamento; }
      public function setIdPagamento($idpagamento){ $this-> idpagamento = $idpagamento; }
      public function getIdSubject(){ return $this-> idSubject; }
      public function setIdSubject($idSubject){ $this-> idSubject = $idSubject; }      
      public function getResponseSave(){ return $this-> responseSave; }
      public function setResponseSave($responseSave){ $this-> responseSave = $responseSave;}
      public function getResponseUpdate(){ return $this-> responseUpdate; }
      public function setResponseUpdate($responseUpdate){ $this-> responseUpdate = $responseUpdate; }
      public function getNumberFatura(){ return $this-> numberFactura; }
      public function setNumberFatura($numberFactura){ $this-> numberFactura = $numberFactura; }
      public function getTicketNumber(){ return $this-> ticketNumber; }
      public function setTicketNumber($ticketNumber){ $this-> ticketNumber = $ticketNumber; }

      public function selectClass(){
        try{
            $this-> dateSimple = date('d-m-Y');
            $this-> times = date("H:i:s");
            if($this-> getIdClass() >0){
                 
                $result=$this-> conn->prepare("SELECT*FROM view_historico WHERE id_aluno=:pro and anolectivo=:ano");
                $result->bindParam(":pro",$this-> idClass,PDO::PARAM_STR);
                $result->bindParam(":ano",$this-> year,PDO::PARAM_STR);
                if($result->execute()){
                  if($result->rowCount() >0){
                    $vt=$result->fetch(PDO::FETCH_OBJ);
                    $this-> name = utf8_encode($vt->nome);
                    $this-> course = utf8_encode($vt->curso);
                    $this-> level = $vt->classe;
                    $this-> classroom = $vt->turma;
                    $this-> period = $vt->turno;
                  }
                } 

            }
          }catch(PDOException $e){   echo $e;   }

      }//End function 
      public function selectSubject(){
        try{
            if($this-> getIdSubject() >0){
                 
                $result=$this-> conn->prepare("SELECT*FROM tbl_dis2 WHERE id_di2=:ID ");
                $result->bindParam(":ID",$this-> getIdSubject(),PDO::PARAM_INT);
                if($result->execute()){
                  $vt=$result->fetch(PDO::FETCH_OBJ);
                  //$this-> subject = utf8_encode($vt->nome);
                  $this-> subject = $vt->nome;  
                  
                }             

            }
          }catch(PDOException $e){   echo $e;   }

      }//End function
      public function selectPayment(){ $rs=0;
        try{
          if($this -> getIdPagamento() != 1){
            $run= $this-> conn -> prepare("SELECT * FROM tb_pagamento_provas WHERE id_aluno=:ID AND ano_lectivo=:ANO AND disciplina=:IDDISCI");
            $run->bindParam(":ID",$this -> getIdClass(),PDO::PARAM_INT);
            $run->bindParam(":ANO",$this -> year,PDO::PARAM_INT);
            $run->bindParam(":IDDISCI",$this -> getIdSubject(),PDO::PARAM_INT);
            if($run->execute()){
              if($run->rowCount() >0){
                 $row = $run->fetch(PDO::FETCH_OBJ);
                 $this-> idpagamento = $row->id_pagaprova;                
                 $this-> priceSell = $row->valor_pago;
                 $this-> type = $row->tipo;
                 $this-> category = $row->categoria;
                 $this-> state = $row->estado;                 
                 $rs = 1;
              }
            }

          }
        } catch(PDOException $e){  echo $e;  }
        return $rs;
      }//End function
      
       public function saveService(){ $rs=0;

          try{
            if((!empty($this-> subject)) && ($this-> getIdSubject() >0) ){
              if( ($this-> worker !="") ){
                $this-> state = "ON";
                
                $ru2=$this-> conn->prepare("INSERT INTO tb_pagamento_provas (id_aluno,ano_lectivo,data_pagamento,valor_pago,usuario,cliente,disciplina,tipo,categoria,n_fatura,numero_talao,data_deposito,estado) VALUES (:IDALU,:ANO,NOW(),:PRECO,:WORKER,:CLIENT,:DISCI,:TIPO,:CATEG,:FACTU,:TICKET,:DATEDEPO,:ESTADO)");
                $ru2->bindParam(":IDALU",$this-> getIdClass(),PDO::PARAM_INT);
                $ru2->bindParam(":ANO",$this-> year,PDO::PARAM_STR);
                $ru2->bindParam(":PRECO",$this-> priceSell,PDO::PARAM_STR);
                $ru2->bindParam(":WORKER",$this-> worker,PDO::PARAM_STR);
                $ru2->bindParam(":CLIENT",$this-> client,PDO::PARAM_STR);
                $ru2->bindParam(":DISCI",$this-> getIdSubject(),PDO::PARAM_STR);
                $ru2->bindParam(":TIPO",$this-> type,PDO::PARAM_STR);
                $ru2->bindParam(":CATEG",$this-> category,PDO::PARAM_STR);
                $ru2->bindParam(":FACTU",$this-> numberFactura,PDO::PARAM_STR);
                $ru2->bindParam(":TICKET",$this-> getTicketNumber(),PDO::PARAM_INT);
                $ru2->bindParam(":DATEDEPO",$this-> dataDeposito,PDO::PARAM_STR);
                $ru2->bindParam(":ESTADO",$this-> state,PDO::PARAM_STR);
                if($ru2->execute()):
                  $rs=1;
                  
                  $this-> setResponseSave(1);
                  
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
      public function relatorio(){ $respSave=0;
       
            $preco = number_format($this-> priceSell,2,',','.'); 
            $total = number_format($this-> total,2,',','.'); 
            $totalPay=0;
          
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
            <td colspan='2' id='pi'><b>PAGAMENTO DE {$this-> category} ESCOLAR</b></td>
            </tr>
            <tr>
            <td id='sec'>Fact. Nº: {$this-> numberFactura}</td>
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
            </tr>";

           if($_SESSION['IDDISCIPLINA'] !=0){ 
              foreach ($_SESSION['IDDISCIPLINA'] as $id) {
                $this-> setIdSubject($id);
                 
                $this-> selectSubject();
                $resp = $this-> selectPayment();
                if($resp !=1){
                   $respSave = $this-> saveService();
                   $this-> totalPay = $this-> totalPay + $this-> priceSell;
                   $totalPay = number_format($this-> totalPay,2,',','.'); 
                $html.="
                <tr>
                <tr>
                <td>{$this-> subject}</td>
                <td>$preco KZs</td>
                </tr>
                ";
              }elseif($resp ==1){
                $html.="
                <tr>
                <tr>
                <td>Pagamento já Efectuado</td>
                <td>? KZs</td>
                </tr>
                ";
              }
            }}

            $html.="
            <tr>
            <th class='bn'>Total Pago</th>";
            $html.="<td class='bn'>$totalPay KZs</td>
            </tr>
            </table>

            <br/>
            <pre>
  Funcionario
  ______________________________
  {$this-> worker}
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
            <td colspan='2' id='pi'><b>PAGAMENTO DE {$this-> category} ESCOLAR</b></td>
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
            </tr>";

           if($_SESSION['IDDISCIPLINA'] !=0){ 
              foreach ($_SESSION['IDDISCIPLINA'] as $id) {
                $this-> setIdSubject($id);
                 
                $this-> selectSubject();
                $resp = $this-> selectPayment();
                if($resp !=1){
                   $respSave = $this-> saveService();
                   $this-> totalPay = $this-> totalPay + $this-> priceSell;
                   $totalPay = number_format($this-> totalPay,2,',','.'); 
                $html.="
                <tr>
                <tr>
                <td>{$this-> subject}</td>
                <td>$preco KZs</td>
                </tr>
                ";
              }elseif($resp ==1){
                $html.="
                <tr>
                <tr>
                <td>Pagamento já Efectuado</td>
                <td>? KZs</td>
                </tr>
                ";
              }
            }}

            $html.="
            <tr>
            <th class='bn'>Total Pago</th>";
            $html.="<td class='bn'>$totalPay KZs</td>
            </tr>
            </table>

            <br/>
            <pre>
  Funcionario
  ______________________________
  {$this-> worker}
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
