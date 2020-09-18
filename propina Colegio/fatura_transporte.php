<?php
ob_start();
session_start();
require_once("conn2.php");

$hora=date("H:i:s");
$ano=date("Y");
$data=date("d-m-Y");
$usuario=$_SESSION['nomeS'];

if(isset($_POST['local'])){

    $id_aluno= addslashes(htmlspecialchars(isset($_POST['id'])?$_POST['id']:0));
    echo("ID: ".$id_aluno);
    $precario= addslashes(htmlspecialchars(isset($_POST['preco'] )));
    $local= addslashes(htmlspecialchars($_POST['local']));
    $cliente = addslashes(htmlspecialchars($_POST['cliente']));
    $numTalao = addslashes(htmlspecialchars($_POST['numerotalao']));
    $dataDeposito = addslashes(htmlspecialchars($_POST['dataDeposito']));
    $anoLectivo = addslashes(htmlspecialchars($_POST['anoLectivo']));



        $string2=explode("-",$data);
        if($string2[1]==1):
        $mes2="Janeiro";
        elseif($string2[1]==2):
        $mes2="Fevereiro";
        elseif($string2[1]==3):
        $mes2="Março";
        elseif($string2[1]==4):
        $mes2="Abril";
        elseif($string2[1]==5):
        $mes2="Maio";
        elseif($string2[1]==6):
        $mes2="Junho";
        elseif($string2[1]==7):
        $mes2="Julho";
        elseif($string2[1]==8):
        $mes2="Agosto";
        elseif($string2[1]==9):
        $mes2="Setembro";
        elseif($string2[1]==10):
        $mes2="Outubro";
        elseif($string2[1]==11):
        $mes2="Novembro";
        elseif($string2[1]==12):
        $mes2="Dezembro";
        endif;

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
        foreach($_POST['meses'] as $num)
        {
            $a++;
        }


        $total_pagamento=$a*$precario;
        $servico="Transporte";
        $trans=$con2->prepare("SELECT * FROM tbl_servicos INNER JOIN tbl_precos ON id_preco=idPreco where idServico=:TRANS");
        $trans->bindParam(":TRANS",$local,PDO::PARAM_STR);
        $trans->execute();
        $val=$trans->fetch(PDO::FETCH_OBJ);
        $precoTrans = $val->preco;
        $local = $val->local;
        $estado="on";
        foreach($_POST['meses'] as $num)
        {
            
            $ru1=$con2->prepare("select *from tb_pagamento_transporte where id_aluno=:id and ano_lectivo=:anolectivo and numero_mes=:mes");
            $ru1->bindParam(":id",$id_aluno,PDO::PARAM_STR);
            $ru1->bindParam(":anolectivo",$ano,PDO::PARAM_STR);
            $ru1->bindParam(":mes",$num,PDO::PARAM_STR);
            $ru1->execute();
            $cont=$ru1->rowCount();
            if($cont>0){
                
            }
            else{
                $mes=$con2->prepare("select *from tbl_meses where numero_mes=:nu");
                $mes->bindParam(":nu",$num,PDO::PARAM_STR);
                $mes->execute();
                $valMes=$mes->fetch(PDO::FETCH_OBJ);
                $nome= utf8_encode($valMes->mes);
              
                $ru2=$con2->prepare("insert into tb_pagamento_transporte (id_aluno,ano_lectivo,data_pagamento,mes_pagamento,valor_pago,usuario,cliente,local,n_fatura,numero_talao,data_deposito,estado,numero_mes) values(:id,:anolectivo,NOW(),:mespaga,:valorpa,:usuario,:cliente,:local,:nfatura,:numeroTalao,:dataDeposito,:estado,:numeromes)");
                $ru2->bindParam(":id",$id_aluno,PDO::PARAM_INT);
                $ru2->bindParam(":anolectivo",$ano,PDO::PARAM_STR);
                $ru2->bindParam(":mespaga",$nome,PDO::PARAM_STR);
                $ru2->bindParam(":valorpa",$precoTrans,PDO::PARAM_STR);
                $ru2->bindParam(":usuario",$usuario,PDO::PARAM_STR);
                $ru2->bindParam(":cliente",$cliente,PDO::PARAM_STR);  
                $ru2->bindParam(":local",$local,PDO::PARAM_STR);  
                $ru2->bindParam(":nfatura",$numero_fatura,PDO::PARAM_STR);
                $ru2->bindParam(":numeroTalao",$numTalao,PDO::PARAM_INT);
                $ru2->bindParam(":dataDeposito",$dataDeposito,PDO::PARAM_STR);
                $ru2->bindParam(":estado",$estado,PDO::PARAM_STR);    
                $ru2->bindParam(":numeromes",$num,PDO::PARAM_INT);
                $ru2->execute();  
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


        $nome = utf8_decode($vt->nome);
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
        <td colspan='2' id='pi'><b>PAGAMENTO DE TRANSPORTE ESCOLAR</b></td>
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
        <td class='vfk'>$nome</td>
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
        <th class='cvb'>Meses Pagos</th>
        <th class='cvb'>Preço</th>

        </tr>";
        $totalPago =0;
        foreach($_POST['meses'] as $num)
        {
            $ru1=$con2->prepare("select *from tb_pagamento_transporte where id_aluno=:id and ano_lectivo=:anolectivo and numero_mes=:mes");
            $ru1->bindParam(":id",$id_aluno,PDO::PARAM_STR);
            $ru1->bindParam(":anolectivo",$ano,PDO::PARAM_STR);
            $ru1->bindParam(":mes",$num,PDO::PARAM_STR);
            $ru1->execute();
            $cont=$ru1->rowCount();
            
           while($bt=$ru1->fetch(PDO::FETCH_OBJ)) {
                $totalPago = $totalPago + $bt->valor_pago;
                $valor = $bt->valor_pago;
                $valor = number_format($valor,2,',','.');
                 $mespago = $bt->mes_pagamento;
        $html.="
        <tr>
        <td>$mespago</td>
        <td>$valor</td>

        </tr>
        ";
          }
        }
        $html.="
        <tr>
        <th class='bn'>Total</th>";


        $totalPago = number_format($totalPago,2,',','.');
        $html.="<td class='bn'>$totalPago</td>

        </tr>";

        $html.="
        <tr>
        <th class='bn'>Local:</th>";
        $html.="<td class='bn'>$local</td>

        </tr>

        </table>

        <br/>";

        $html.="
        <pre>
Funcionário
______________________
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
        <td class='vfk'>$nome</td>
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
        <th class='cvb'>Meses Pagos</th>
        <th class='cvb'>Preço</th>

        </tr>";
        $totalPago =0;
        foreach($_POST['meses'] as $num)
        {
            $ru1=$con2->prepare("select *from tb_pagamento_transporte where id_aluno=:id and ano_lectivo=:anolectivo and numero_mes=:mes");
            $ru1->bindParam(":id",$id_aluno,PDO::PARAM_STR);
            $ru1->bindParam(":anolectivo",$ano,PDO::PARAM_STR);
            $ru1->bindParam(":mes",$num,PDO::PARAM_STR);
            $ru1->execute();
            $cont=$ru1->rowCount();
            
           while($bt=$ru1->fetch(PDO::FETCH_OBJ)) {
                $totalPago = $totalPago + $bt->valor_pago;
                $valor = $bt->valor_pago;
                $valor = number_format($valor,2,',','.');
                $mespago = $bt->mes_pagamento;
        $html.="
        <tr>
        <td>$mespago</td>
        <td>$valor</td>
        </tr>
        ";
          }
        }
        $html.="
        <tr>
        <th class='bn'>Total</th>";

        $totalPago = number_format($totalPago,2,',','.');
        $html.="<td class='bn'>$totalPago</td>
        </tr>";
        
        $html.="
        <tr>
        <th class='bn'>Local:</th>";
        $html.="<td class='bn'>$local</td>

        </tr>
        </table>
        <br/>
        <pre>
Funcionário
______________________
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

}else{ echo '<script>alert("Seleccione um local por favor")</script>';  echo '<script>window.location="count_pupilo.php"</script>';}

?>
