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
   <div id="page-inner">
    <div class="row">
      <div class="col-md-12">
        <h1 class="page-head-line">VENDA DE UNIFORME</h1>
      </div>
    </div>
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

         
    </div>
    <!-- ===================== End of uniforme Table ====================-->
    

<script>
$("document").ready(function(e){
$("#btos1").hide();
$("#btos2").hide(); 
$("#txtna").val(<?php //echo $pagina;?>);
$("#txtna2").val(<?php //echo $numpaginas;?>);
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
</body>
</html>