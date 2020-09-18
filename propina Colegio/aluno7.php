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

<form name="fom4" method="POST" action="#" class="form-inline" >
<input type="hidden" name="processo" id="processo" class="form-control" value="<?php echo $_SESSION['processo34']; ?>"/>
<input type="hidden" name="nfatura" id="nfatura" class="form-control" value="<?php echo $redo->nfatura; ?>"/>
Valor: <input type="text" name="cb_valor" id="cb_valor" class="form-control" value="<?php echo $redo->valor; ?>"/>
Cliente: <input type="text" class="form-control" id="txt_cliente" name="txt_cliente" value="<?php echo $redo->cliente; ?>"/>
Data: <input type="text" name='data' id="data" class="form-control" value="<?php echo $redo->data_pagamento; ?>"/>
Usuario: <input type="text" name='usuario' id="usuario" class="form-control" value="<?php echo $redo->usuario; ?>"/>
<a href="desfaz_pagamento.php?id_pagamento=<?php echo $redo->id_pagamento;?>&&mes=<?php echo $redo->mes;?>&&ano=<?php echo $redo->ano_lectivo;?>&&id_aluno=<?php echo $redo->id_aluno;?>" class="btn btn-warning">Eliminar Pagamento</a>
</form>
</body>
</html>