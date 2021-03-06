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
    <title>Balanço de Certificados</title>

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
                        <h1 class="page-head-line">Balanço de Certificados</h1>
                        </div>
                </div>
                <div class="row">
                <div class="col-md-12">
              <div class="panel panel-default">
              <div class="panel-heading">
              Balança
              </div>
              <div class="panel-body">
                  <form role="form" method="POST" action="certificadoBA.php">
              <div class="form-inline">
              Ano Lectivo: <input type="text" name="ano" id="ano" value="<?php echo date('Y');?>" class="form-control"/>
              <input type="submit" id="btt" name="bt1" class="btn btn-primary" value="Balanço"/>
              </div>
              </form>
              
              <div class="mostra">
              <?php 
              if(isset($_POST['bt1'])){
                  $ano=$_POST['ano'];
                  //pagamentos normais
                  echo '<br/><br/>';
$co="SELECT SUM(valor_pago) FROM view_pagamento_certificados where ano_lectivo=:ano";
$exe=$con2->prepare($co);
$exe->bindParam(":ano",$ano,PDO::PARAM_STR);
$exe->execute();
$soma1=$exe->fetchColumn();



//femenino
$genero1="Femenino";
$co="SELECT SUM(valor_pago) FROM view_pagamento_certificados where ano_lectivo=:ano and genero=:genero";
$exe=$con2->prepare($co);
$exe->bindParam(":ano",$ano,PDO::PARAM_STR);
$exe->bindParam(":genero",$genero1,PDO::PARAM_STR);
$exe->execute();
$soma=$exe->fetchColumn();
echo "<b>Genero Femenino:</b> ".$soma.".00<br/>";

//masculino
$genero2="Masculino";
$co="SELECT SUM(valor_pago) FROM view_pagamento_certificados where ano_lectivo=:ano and genero=:genero";
$exe=$con2->prepare($co);
$exe->bindParam(":ano",$ano,PDO::PARAM_STR);
$exe->bindParam(":genero",$genero2,PDO::PARAM_STR);
$exe->execute();
$soma=$exe->fetchColumn();
echo "<b>Genero Masculino:</b> ".$soma.".00<br/>";

//total
echo "<b>Total Geral:</b> ".($soma1).".00<br/>";
                  
                  
                  
              }
              
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
