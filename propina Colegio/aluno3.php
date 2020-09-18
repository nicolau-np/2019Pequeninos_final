<html>
<head><title></title></head>
<body>
<?php
session_start();
require_once("conn2.php");
$mes=$_GET['mes'];
$id=$_GET['id'];
$ano=$_GET['anoL'];

$re="select *from tbl_pagamento where mes=:mes and id_aluno=:id and ano_lectivo=:an";
try
{
   $result=$con2->prepare($re);
   $result->bindParam(":mes",$mes,PDO::PARAM_STR);
   $result->bindParam(":id",$id,PDO::PARAM_STR);
   $result->bindParam(":an",$ano,PDO::PARAM_STR);
   $result->execute();

}
catch(PDOException $e)
{
    echo $e;
}
$redo=$result->fetch(PDO::FETCH_OBJ);
?>

<form name="fom4" method="POST" action="faz2.php" class="form-inline" >
<input type="hidden" name="processo" id="processo" class="form-control" value="<?php echo $_SESSION['processo34']; ?>"/>
<input type="hidden" name="nfatura" id="nfatura" class="form-control" value="<?php echo $redo->nfatura; ?>"/>
Valor: <input type="text" name="cb_valor" id="cb_valor" class="form-control" value="<?php echo $redo->valor; ?>"/>
Cliente: <input type="text" class="form-control" id="txt_cliente" name="txt_cliente" value="<?php echo $redo->cliente; ?>"/>
Data Registo: <input type="text" name='data' id="data" class="form-control" value="<?php echo $redo->data_pagamento; ?>"/>
Usuario: <input type="text" name='usuario' id="usuario" class="form-control" value="<?php echo $redo->usuario; ?>"/><br/><br/>
Talão nº <input type="text" name="boletim" id="boletim" class="form-control" placeholder="Nº de Boletim" value="<?php echo $redo->n_boletim; ?>" required/>
Forma de Pagamento: <input type="text" name="forma_pagamento" id="forma_pagamento" class="form-control" value="<?php echo $redo->forma_pagamento; ?>" placeholder="Forma de Pagamento" required/>
Banco: <input type="text" name="banco" id="banco" class="form-control" placeholder="Banco" value="<?php echo $redo->banco; ?>" required/><br/><br/>
Data do Talão: <input type="text" name="data_borderom" id="data_borderom" class="form-control" value="<?php echo $redo->data_pagamento_banco; ?>" placeholder="Data do Talão" required/>
<a href="faz2.php?id=<?php echo $id;?>&nfatura=<?php echo $redo->nfatura;?>&anoLE=<?php echo $redo->ano_lectivo;?>&&data=<?php echo $redo->data_pagamento;?>&&hora=<?php echo $redo->hora;?>" class="btn btn-primary" >Factura</a>

</form>
</body>
</html>