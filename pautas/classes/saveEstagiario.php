<?php 

class SaveEstagiario{
    
    private $conn;
    public $IDEstag;
    public $nome; 
    public $curso;
    public $turma;
    public $classe;
    public $turno;
    public $bi;
    public $anoLectivo;
    public $supervisor;
    public $faltas;
    public $telefone;
    public $tele_supervisor;
    public $localEstagio;
    public $dataInicio;
    public $dataFim;
    public $provincia;
    public $municipio;
    public $verifyEstagio=0;
    public $save=0;
    public $request;
    public $dateDay;
    public $times;
    public $year;
    public $worker;
    private $numberFactura=0;

    public $idPessoa=0;
    public $idAluno=0;


    public function getConnection(){ return $this-> conn;}
    public function setConnection($conn){ $this-> conn = $conn; }
    public function getNumeroFatura(){ return $this-> numberFactura; }
    public function setNumeroFatura($numberFactura){ $this-> numberFactura = $numberFactura; }

    
public function verifyEstagio(){  
    $this-> dateDay = date('d-m-Y');  $this-> times = date('H-i-s'); $this-> year = date('Y');  
    $run = $this-> conn -> prepare("SELECT * FROM estagiarios WHERE curso=:CURSO AND classe=:CLASSE AND turma=:TURMA AND turno=:TURNO AND bi=:BI");
    $run->bindParam(":CURSO",$this-> curso,PDO::PARAM_STR);
    $run->bindParam(":CLASSE",$this-> classe,PDO::PARAM_STR);
    $run->bindParam(":TURMA",$this-> turma,PDO::PARAM_STR);
    $run->bindParam(":TURNO",$this-> turno,PDO::PARAM_STR);
    $run->bindParam(":BI",$this-> bi,PDO::PARAM_STR);
    if($run->execute()){ if($run->rowCount()>0){ $dados=$run->fetch(PDO::FETCH_OBJ);  $this-> IDEstag = $dados->idEsta;
        $this-> verifyEstagio = 1; echo"<div class='alert alert-success'>Estágio  já marcado!</div>";  }else{$this-> verifyEstagio = 0;} }
    

}//End function

public function savingEstagio(){
    try{
        if($this-> verifyEstagio == 0):
            $run = $this-> conn -> prepare("INSERT INTO estagiarios (nome,curso,classe,turma,turno,bi,anoLectivo,telefone,supervisor,telefSupervisor,faltas,localEstagio,provincia,municipio,dataInicio,dataFim) VALUES(:NOME,:CURSO,:CLASSE,:TURMA,:TURNO,:BI,:ANOLECT,:TELEFONE,:SUPERVISOR,:TELEFSUPERVISOR,:FALTAS,:LOCALESTA,:PROVINCIA,:MUNICIPIO,:DATAINICIO,:DATAFIM)");
                $run->bindParam(":NOME",$this-> nome,PDO::PARAM_STR);
                $run->bindParam(":CURSO",$this-> curso,PDO::PARAM_STR);
                $run->bindParam(":CLASSE",$this-> classe,PDO::PARAM_STR);
                $run->bindParam(":TURMA",$this-> turma,PDO::PARAM_STR);
                $run->bindParam(":TURNO",$this-> turno,PDO::PARAM_STR);
                $run->bindParam(":BI",$this-> bi,PDO::PARAM_STR);
                $run->bindParam(":ANOLECT",$this-> anoLectivo,PDO::PARAM_STR);
                $run->bindParam(":TELEFONE",$this-> telefone,PDO::PARAM_STR);
                $run->bindParam(":SUPERVISOR",$this-> supervisor,PDO::PARAM_STR);
                $run->bindParam(":TELEFSUPERVISOR",$this-> tele_supervisor,PDO::PARAM_INT);
                $run->bindParam(":FALTAS",$this-> faltas,PDO::PARAM_INT);
                $run->bindParam(":LOCALESTA",$this-> localEstagio,PDO::PARAM_STR);
                $run->bindParam(":PROVINCIA",$this-> provincia,PDO::PARAM_STR);
                $run->bindParam(":MUNICIPIO",$this-> municipio,PDO::PARAM_STR);
                $run->bindParam(":DATAINICIO",$this-> dataInicio,PDO::PARAM_STR);
                $run->bindParam(":DATAFIM",$this-> dataFim,PDO::PARAM_STR);
                if ($run->execute()) { $this-> save = 1;   }
                         
        endif;
   } catch (PDOException $ex) {   $ex->getMessage();   }
}

public function editarEstagio(){
    
   try{
        if(($this-> verifyEstagio == 1) && ($this-> request =="Edit")):
          
       
            $ex1= $this-> conn->prepare("UPDATE estagiarios SET telefone=:TELEFONE,supervisor=:SUPERVISOR,telefSupervisor=:TELEFSUPERVISOR,faltas=:FALTAS,localEstagio=:LOCALESTA,provincia=:PROVINCIA,municipio=:MUNICIPIO,dataInicio=:DATAINICIO,dataFim=:DATAFIM WHERE idEsta=:IDEstag LIMIT 1");
            $ex1->bindParam(":IDEstag",  $this->IDEstag,PDO::PARAM_INT);
            $ex1->bindParam(":TELEFONE",$this-> telefone,PDO::PARAM_INT);
            $ex1->bindParam(":SUPERVISOR",$this-> supervisor,PDO::PARAM_STR);
            $ex1->bindParam(":TELEFSUPERVISOR",$this-> tele_supervisor,PDO::PARAM_INT);
            $ex1->bindParam(":FALTAS",$this-> faltas,PDO::PARAM_INT);
            $ex1->bindParam(":LOCALESTA",$this-> localEstagio,PDO::PARAM_STR);
            $ex1->bindParam(":PROVINCIA",$this-> provincia,PDO::PARAM_STR);
            $ex1->bindParam(":MUNICIPIO",$this-> municipio,PDO::PARAM_STR);
            $ex1->bindParam(":DATAINICIO",$this-> dataInicio,PDO::PARAM_STR);
            $ex1->bindParam(":DATAFIM",$this-> dataFim,PDO::PARAM_STR);
                       
            if($ex1->execute()): $this-> relatorio();   //echo"<div class='alert alert-success'>Estágio editado como sucesso!</div>";                
            else:     echo"<div class='alert alert-warning'>Erro ao actualizar Estágio!</div>";               
            endif;
        endif;
   } catch (PDOException $ex) {   $ex->getMessage();   }
     
}//End function
public function deletaEstagio(){    
    try{
        if(($this-> IDEstag>0) && ($this-> request =="DeleteEsta")):
                
                $x=$this-> conn ->prepare("DELETE FROM estagiarios WHERE idEsta=:IDEstag");
                $x->bindParam(":IDEstag",$this->IDEstag,PDO::PARAM_INT);

                if($x->execute() ):    echo"<div class='alert alert-success'>Deleted successfull!</div>";                
                else: echo"<div class='alert alert-success'>Erro durante a eliminação!</div>";  
                endif;            
        endif;
    } catch (PDOException $e) {     $e->getMessage();   } 
   
}//End function
public function relatorio(){ 
       
            
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
            <B></B><br/>
            <b>HUAMBO-ANGOLA</b>
            </div>
            <br/>
            <br/>
            <div class='ely'>
            <table border='0' class='nm'>
            <tr>
            <td colspan='2' id='pi'><b>MARCAÇÃO DE ESTÁGIO CURRICULAR</b></td>
            </tr>
            <tr>
            <td id='sec'>Fact. Nº: </td>
            <td>Data:  <br/> </td>
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
            <td class='vfk'></td>
            <td class='vfk'></td>
            <td class='vfk'></td>
            <td class='vfk'></td>
            <td class='vfk'></td>
            <td class='vfk'></td>
            <td></td>
            </tr>
            </table>
            </div>
            <br/>
            ";


            $html.="<table class='table1' id='vb' width='500'>
           ";

              

            $html.="
            </table>

            <br/>
            <pre>
  Funcionario
  ______________________________
 
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
public function answers(){
    if(($this-> verifyEstagio == 0) && ($this-> save ==1)){ $this-> relatorio();  }elseif(($this-> verifyEstagio == 0) && ($this-> save ==0)){ 
         echo"<div class='alert alert-success'>Definição do Estágio falhou!</div>";
    }
}//End function



}//End Class


?>