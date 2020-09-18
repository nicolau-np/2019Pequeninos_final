<?php 
ob_start();
session_start();
     require_once("conn2.php");
if(!isset($_SESSION['nomeS']) && (!isset($_SESSION['senhaS'])))
{
    header("location:index.php?acao=negado");exit;
}

$nome=$_SESSION['nomeS'];
$titulo=$_SESSION['tituloS'];
$foto=$_SESSION['fotoS'];


?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Balanço Geral</title>

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
<script type="text/javascript" src="assets/js/jquery-1.10.2.js"></script>
<script type="text/javascript" src="assets/js/permit.js"></script>

</head>
<body>
     <?php
    require_once("menu.php");
	?>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">Balanço Geral</h1>
                        </div>
                </div>
                <div class="row">
                <div class="col-md-12">
              <div class="panel panel-default">
              <div class="panel-heading">
              Balança
              </div>
              <div class="panel-body">
                  <form role="form" method="POST" action="geral.php">
              <div class="form-inline">
              Ano Lectivo: <input type="text" name="ano" id="ano" value="<?php echo date('Y');?>" class="form-control"/>
              <input type="submit" name="bt1" id="btt" class="btn btn-primary" value="Balanço"/>
              </div>
              </form>
              
              <div class="mostra">
              <?php 
              if(isset($_POST['bt1'])):
$ano=$_POST['ano'];
              
              
echo '<br/><br/>';
              //pagamentos matricula
$co="SELECT SUM(valor) FROM matricula where ano=:ano";
$exe=$con2->prepare($co);
$exe->bindParam(":ano",$ano,PDO::PARAM_STR);
$exe->execute();
$soma1=$exe->fetchColumn();

echo "<b>Matrícula:</b> ".$soma1.".00<br/>";

//pagamentos normais
$co="SELECT SUM(valor) FROM ver where ano_lectivo=:ano";
$exe1=$con2->prepare($co);
$exe1->bindParam(":ano",$ano,PDO::PARAM_STR);
$exe1->execute();
$soma2=$exe1->fetchColumn();

echo "<b>Propinas:</b> ".$soma2.".00<br/>";

$co="SELECT SUM(valor_pago) FROM view_pagamento_declaracao where ano_lectivo=:ano";
$exe=$con2->prepare($co);
$exe->bindParam(":ano",$ano,PDO::PARAM_STR);
$exe->execute();
$soma3=$exe->fetchColumn();

echo "<b>Declarações:</b> ".$soma3.".00<br/>";

$co="SELECT SUM(valor_pago) FROM view_pagamento_certificados where ano_lectivo=:ano";
$exe=$con2->prepare($co);
$exe->bindParam(":ano",$ano,PDO::PARAM_STR);
$exe->execute();
$soma4=$exe->fetchColumn();

echo "<b>Certificados:</b> ".$soma4.".00<br/>";
$ESTADO69="ON";
$co="SELECT SUM(valor) FROM view_comp_pais where ano=:ano";
$exe=$con2->prepare($co);
$exe->bindParam(":ano",$ano,PDO::PARAM_STR);
$exe->execute();
$soma5=$exe->fetchColumn();

echo "<b>Comparticipação de Encarregados:</b> ".$soma5.".00<br/>";

$co="SELECT SUM(valor_pago) FROM view_pagamento_folhas where ano_lectivo=:ano";
$exe=$con2->prepare($co);
$exe->bindParam(":ano",$ano,PDO::PARAM_STR);
$exe->execute();
$soma6=$exe->fetchColumn();

echo "<b>Folha de Provas:</b> ".$soma6.".00<br/>";

$co="SELECT SUM(preco) FROM venderproduto where ano=:ano";
$exe=$con2->prepare($co);
$exe->bindParam(":ano",$ano,PDO::PARAM_STR);
$exe->execute();
$soma7=$exe->fetchColumn();

echo "<b>Uniformes:</b> ".$soma7.".00<br/>";

$co="SELECT SUM(valor_pago) FROM view_pagamento_transporte where ano_lectivo=:ano";
$exe=$con2->prepare($co);
$exe->bindParam(":ano",$ano,PDO::PARAM_STR);
$exe->execute();
$soma8=$exe->fetchColumn();

echo "<b>Transporte:</b> ".$soma8.".00<br/>";

//total
echo "<b>Total Geral:</b> ".($soma1+$soma2+$soma3+$soma4+$soma5+$soma6).".00<br/>";
              
              endif;
              ?>
              </div>
              </div>
              <div class="panel-footer">
              
              </div>
              
              </div>
                </div>
                </div>
                </div>
                </div>
                <!--/.ROW-->

            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->

    <div id="footer-sec" align='center'>
        <b>&copy; <?php echo date('Y');?> OKUSSOLEKA | Powered By : Nicolau Ngala Pungue </b>

    </div>
    <!-- /. FOOTER  -->
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
       <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
    


</body>
</html>
