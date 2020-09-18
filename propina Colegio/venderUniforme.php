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
include("fatura_uniforme.php");


$hora=date("H:i:s");
$ano=date("Y");
$data=date("Y-m-d");
$respostaSave=0;

$funcionario=$_SESSION['nomeS'];
$titulo=$_SESSION['tituloS'];
$id_aluno= $_SESSION['idaluno'];
$id_pessoa = $_SESSION['idpessoa'];
$nome_aluno = $_SESSION['nome_aluno'];

$cliente = addslashes(htmlspecialchars( isset($_POST['cliente'])? $_POST['cliente']:''));
$numerotalao = addslashes(htmlspecialchars( isset($_POST['numerotalao'])? $_POST['numerotalao']:''));
$dataDeposito = addslashes(htmlspecialchars( isset($_POST['dataDeposito'])? $_POST['dataDeposito']:''));
$anoLectivo = addslashes(htmlspecialchars( isset($_POST['anoLectivo'])? $_POST['anoLectivo']:''));

if( (is_string($cliente)) && (is_numeric($numerotalao)) && (is_string($dataDeposito)) && (is_numeric($anoLectivo)) ){
  $_SESSION['cliente'] = $cliente;  $_SESSION['numerotalao'] = $numerotalao; $_SESSION['dataDeposito']=$dataDeposito;
  $_SESSION['anoLectivo'] = $anoLectivo;
} 

    
    //Passando um aaray de dados numa Sessão
  if(!isset($_SESSION['carrinho'])){
    $_SESSION['carrinho'] = array();
    $_SESSION['arrayProdutos'] = array();
  }
  //Adicionar produto
  if(isset($_GET['accao'])){
    //Adicionar carrinho
    if($_GET['accao'] =='add'){
      $id=intval($_GET['id']);
      if(!isset($_SESSION['carrinho'][$id])){//Se o produto não está dentro da sessão carrinho
        //Coloca o produto no carrinho
        $_SESSION['carrinho'][$id] =1;
      }else{//Caso já existir fazer autoincrementação
        $_SESSION['carrinho'][$id] +=1;
      }
    }
     

    //Remover produto do carrinho
    if($_GET['accao'] == 'del'){ 
      $id=intval($_GET['id']);
      if(isset($_SESSION['carrinho'][$id])){//Se a ID do produto existir Remove do carrinho
        unset($_SESSION['carrinho'][$id]);
      }
    }
    //ALTERAR QUANTIDADE DE PRODUTOS NO CARRINHO
    if($_GET['accao'] =='update'){
      //Verificando se o valor vindo do formulário é um array
      if(isset($_POST['prod'])):
        if(is_array($_POST['prod'])){ //Se for verdade percorre o array retornando o ID e quantidade de cada produto
          foreach ($_POST['prod'] as $id => $qtd) {
            //Verificando se os valores são números inteiros
            $id=intval($id);
            $qtd=intval($qtd);
            //Se a quantidade não for vazia ou for diferente de zero actualiza o carrinho
            if(!empty($qtd) || $qtd <> 0){
              $_SESSION['carrinho'][$id] = $qtd;
            }else{ //Caso a condição for falsa apaga o valor
              unset($_SESSION['carrinho'][$id]);
            }
          }
        }
      endif;
    }
  }

    $save = new SellUniforme();

  if ( !isset($_POST['salvar']) ):
  elseif ( (isset($_POST['salvar'])) && ($_POST['salvar'] =="Salvar") ):
        
     // relatorio($quant,$hora,$ano,$funcionario);
    
        if(count($_SESSION['carrinho']) ==0){
           //echo ('<tr><td colspan="5">Não há produto no carrinho! </td></tr>') ;               
        }else{ $run=0;
              $totalPay=0;
              //Percorrendo o array de  session carrinho
                  foreach ($_SESSION['carrinho'] as $id => $qtd):  
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


                            $save-> setConnection($con2);
                            $save-> setIdPerson($id_pessoa);
                            $save-> setIdClass($id_aluno);
                            $save-> client = $_SESSION['cliente'];
                            $save-> worker = $funcionario;
                            $save-> year = $ano;
                            $save-> dataSimple = $data;
                            $save-> times = $hora;
                                                       
                            $save-> quantity = $qtd;
                            //$save-> setIdProdu($va->idProd);
                            //$respostaSave = $save-> selectProduto();

                            relatorio($con2,$save,$id,$qtd,$hora,$ano,$funcionario);
                           
                            if($respostaSave >0){
                              //unset($_SESSION['carrinho'][$id]);
                             
                            }//End if
                          }
                        }
                         
                    }catch(PDOException $e) { echo $e;    }

                  endforeach;
            /*    ======Gerar  Factura ======================*/    
                  if( $respostaSave ==1){
                    if(count($_SESSION['carrinho']) >0){
                    
                             //relatorio($con2,$save,$id,$qtd,$hora,$ano,$funcionario);
                             //$save-> relatorio();
                    }         
                  }//Fim verificação
            /*============= Fim Gerar Factura ===================== */      

        }  
       
        //header("location:teste.php?add='".$id."' ");
           
  endif;
   if((isset($_POST['limpar'])) && ($_POST['limpar'] =="Limpar")){
            if(count($_SESSION['carrinho']) !=0){ unset($_SESSION['carrinho'][$id]);}                                    
    }
 
 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8" />
<script src="assets/js/jquery-1.5.2.js" type="text/javascript"></script>
<title>View</title>

<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   

    <!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!--CUSTOM BASIC STYLES-->
    <link href="assets/css/basic.css" rel="stylesheet" />
    <!--CUSTOM MAIN STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

<script src="assets/js/jquery-1.5.2.js" type="text/javascript"></script>
<script type="text/javascript" src="assets/js/permit.js"></script>

</head>
<style type="text/css">
  /*.tableLeft{float: left;}*/
</style>

<body>
  <?php
    require_once("menu.php");
  ?>
  <div id="page-wrapper">
   <div id="page-inner">
    <div class="row">
      <div class="col-md-12">
        <h1 class="page-head-line">VENDA DE UNIFORME</h1>
      </div>
    </div>
    <!-- /. ROW  -->
    <!--<div class="row">
    <div class="col-md-12">
    <div class="tableLeft">-->
        <!-- ==============  UNIFORME TABLE ===================-->
        
         <table class="table table-striped table-hover table-bordered" id="polo">
            <thead>
              <tr>
                <th>Peça</th>
                <th>Existencia</th>
                <th>Custo de Compra</th>
                <th>Preço de Venda</th>
                <th>Rendimento</th>
                <th>Options</th>
                
              </tr>
              </thead>
            <tbody>
             
            <?php 
            $pagina=(isset($_GET['pagina']))?$_GET['pagina']:1;

            $sql="select *from produto";
            try{
               $result=$con2->prepare($sql);
               $result->execute(); 
            }
            catch(PDOException $e)
            {
                echo $e;
            }
            $total=$result->rowCount();
            $registros=7;
            $numpaginas=ceil($total/$registros);
            $inicio=($registros*$pagina)-$registros;

            $sql="select *from produto order by produto asc limit $inicio,$registros ";
            try{
               $result=$con2->prepare($sql);
               $result->execute(); 
            }
            catch(PDOException $e)
            {
                echo $e;
            }
            $total=$result->rowCount();
            while($ver=$result->fetch(PDO::FETCH_OBJ))
            {  $sub_array = array();
              
            ?>
             <tr>
             <td style="display: none;"><?php echo $ver->idProd;?></td>
              <td><?php echo utf8_encode($ver->produto);?></td>
              <td><?php echo $ver->existencia; ?></td>
             <td><?php echo number_format($ver->precoCompra,2,',','.')." KZs";  ?></td>
            <td><?php echo number_format($ver->precoVenda,2,',','.')." KZs"; ?></td>
             
            <td><?php echo number_format($ver->capital,2,',','.')." KZs"; ?></td>
             <?php if($_SESSION['tituloS']=="admin2"): 
                      echo $sub_array[] = ' 
                          <td>
                               <button class="btn btn-warning btn-xs"> <a href="venderUniforme.php?accao=add&id='.$ver->idProd.'">Comprar</a> </button>             
                              <button type="button" name="delete" id="deleteProduct" class="btn btn-danger btn-xs delete" onclick="deletePro('.$ver->idProd.')"><span class="glyphicon  glyphicon-trash"></button>
                              <a href="count_pupilo.php?be4800='.$ver->idProd.'" class="btn btn-primary btn-xs"><i class="fa fa-usd"></i> Pagar</a>
                              <a href="xtrato.php?be4800='.$ver->idProd.'" class="btn btn-success btn-xs"><i class="fa fa-th"></i> Extrato</a>
                          </td>
                      ';
                     
                endif;?> 
             
             </tr>
              <?php }?>
              </tbody>
            </table>

        <!-- ================== TABELA DE PRODUTOS SELECIONADOS PARA A COMPRA ===================-->      

          <div class="tableRight">
            <div class="row">
              <div class="col-md-12">
                <h5 class="page-head-line">PEÇAS SELECCIONADAS</h5>
              </div>
            </div>
            <table class="table table-striped table-hover table-bordered" id="polo">
              <thead>
                <tr>
                  <th width="244">Peça</th>
                  <th width="79">Quantidade</th>
                  <th width="89">Preço</th>
                  <th width="100">Subtotal</th>
                  <th>Option</th>
                </tr>
                </thead>

                <form action="?accao=update" method="POST">
                  <tfoot>
                    <tr>
                      <td colspan="5"> <input type="submit" value="Actualizar" class="btn btn-primary">
                        <input type="submit" value="Salvar" name="salvar" class="btn btn-success">
                        <?php  
                             if($respostaSave >0){ echo('<button name="fatura" value="'.$respostaSave.'" class="btn-primary">Fatura</button>'); } 
                        ?>
                      </td>
                        
                    </tr>
                  </tfoot>
              <tbody>
               
    <?php 
              $pagina=(isset($_GET['pagina']))?$_GET['pagina']:1;
              $total=0;
          if(count($_SESSION['carrinho']) ==0){
                  echo ('<tr><td colspan="5">Não há produto no carrinho! </td></tr>') ;
                  echo($cliente);
          }else{ $run=0;
                  //Percorrendo o array de  session carrinho
              foreach ($_SESSION['carrinho'] as $id => $qtd) {

              try{
                 $result=$con2->prepare("SELECT*FROM produto WHERE idProd=:IDPRO ORDER BY produto ASC");
                 $result->bindParam(":IDPRO",$id,PDO::PARAM_STR);
                 $result->execute(); 
              }
              catch(PDOException $e)
              {
                  echo $e;
              }
              if($result->rowCount() >0){
                        $ver=$result->fetch(PDO::FETCH_OBJ);
                
              ?>
              <tr>
                <td><?php echo utf8_encode($ver->produto);?></td>
                <td><?php echo('<input type="number" size="3" name="prod['.$id.']" value="'.$qtd.'" class="form-control" />'); ?></td>
                <td><?php echo number_format($ver->precoVenda,2,',','.'); ?></td>
                <td><?php echo number_format($ver->precoVenda * $qtd,2,',','.'); $total = $total + $ver->precoVenda *$qtd; ?></td>                
                <td><?php echo('<button class="btn btn-danger"><span class="glyphicon  glyphicon-trash"> <a href="?accao=del&id='.$id.'" >Rem</a>');  ?></td>
              </tr>
                <?php }}}?>
                </tbody>
                <?php  
                             if($_SESSION['carrinho'] >0){ echo('<button name="limpar" value="Limpar" class="btn-danger btn-xs"><span class="glyphicon  glyphicon-trash">Limpar</button>');  } 
                        ?>
              </form>
              </table>
              <tr>
                 <td colspan="5"> <h3> <a href="dataTableProdutos.php"><?php echo('TOTAL a PAGAR: '.number_format($total,2,',','.')); ?> KZs</a></h3> </td>
              </tr>
      
    </div>
    </div>
    <!-- ===================== End of uniforme Table ====================-->
    
  </div> 
</div>  

<script>
$("document").ready(function(e){
$("#btos1").hide();
$("#btos2").hide();	
$("#txtna").val(<?php echo $pagina;?>);
$("#txtna2").val(<?php echo $numpaginas;?>);
var a=$("#txtna").val();
var b=$("#txtna2").val();
if(a!=1)
{
$("#btos1").show();	
}
if(a!=b)
{
	
$("#btos2").show();	
}
});
</script>

<script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS -->
<script src="assets/js/bootstrap.js"></script>
    <!-- METISMENU SCRIPTS -->
<script src="assets/js/jquery.metisMenu.js"></script>
    <!-- CUSTOM SCRIPTS -->
<script src="assets/js/custom.js"></script>

</body>
</html>


<?php


      function relatorio($con2,$save,$id,$qtd,$hora,$ano,$funcionario){
       

        $save-> name = $_SESSION['nome_aluno'];

        $save-> setIdPerson($_SESSION['idpessoa']);
        $save-> setIdClass($_SESSION['idaluno']);
        $save-> client = $_SESSION['cliente'];
        $save-> worker = $_SESSION['nomeS'];
        $save-> year = $ano;
        $save-> dataSimple = $data;
        $save-> times = $hora;
                                
        $preco=0;  $total=0; $totalPay=0; $respostaSave=0;
        $save-> setConnection($con2);
        $save-> client = $_SESSION['cliente'];

        $save-> selectClass(); 
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
                              <B> {$save-> client}</B><br/>
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
                              <td id='sec'>Fact. Nº:{$save-> getIdClass()} </td>
                              <td>Data:{$save-> dataSimple}  <br/> {$save-> times} </td>
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
                              <td>{$save-> year}</td>
                              </tr>
                              </table>
                              </div>
                              <br/>
                              ";


                              $html.="<table class='table1' id='vb' width='500'>
                              <tr>
                              <th class='cvb'>Uniforme</th>
                              <th class='cvb'>Quant</th>
                              <th class='cvb'>Preço</th>
                              <th class='cvb'>Total</th>

                              </tr>";

                             foreach ($_SESSION['carrinho'] as $id => $qtd)
                              {
                                try{

                                  $result=$save-> getConnection()->prepare("SELECT*FROM produto WHERE idProd=:IDPRO ORDER BY produto ASC");
                                     $result->bindParam(":IDPRO",$id,PDO::PARAM_STR);
                                    
                                    if($result->execute()){
                                      if($result->rowCount() >0){
                                        $va=$result->fetch(PDO::FETCH_OBJ);
                                        
                                        

                                        $save-> quantity = $qtd;
                                        $save-> setIdProdu($id);
                                        $respostaSave = $save-> selectProduto();
                                        $preco = number_format($save-> priceSell,2,',','.');
                                        $total = number_format($save-> total,2,',','.');
                                     if($respostaSave >0){ $subtotal = $va->precoVenda * $qtd;
                                      $totalPay = $totalPay + $subtotal;  
                                      unset($_SESSION['carrinho'][$id]);
                                  $html.="
                                  <tr>
                                  <tr>
                                  <td>{$save-> product}</td>
                                  <td>{$save-> quantity}</td>
                                  <td>$preco KZs</td>
                                  <td >$total KZs</td>
                                  </tr>
                                  "; }
                                
                                }}
                                }catch(PDOException $e) { echo $e;    }
                              }

                              $html.="
                              <tr>
                              <th class='bn'>Total Pago</th>";
                              $html.="<td class='bn'>$totalPay,00 KZs</td>
                              </tr>
                              </table>

                              <br/>
                              <pre>
  Cliente                                 Funcionario
  _______________________                 ______________________
  {$save-> client}                                  {$save-> worker}
-----------------------------------------------------------------------------</pre>

                              ";






                              $html.="
                              </body>
                              </html>";

                              include("mpdf/mpdf.php");
                              $mpdf=new mPDF('c','A4'); 
                              $mpdf->WriteHTML($html);
                              $mpdf->Output();
                              exit;   
                        

      }//End if
        
          

?>