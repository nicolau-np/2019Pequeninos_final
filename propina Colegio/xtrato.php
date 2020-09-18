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


?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Extrato</title>

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
                        <h1 class="page-head-line">Extrato</h1>
                        </div>
                </div>
                <div class="row">
                <div class="col-md-12">
                         <div class="panel panel-success">
                             <?php 
                             if(isset($_GET['be4800'])):
                                 $processo=$_GET['be4800'];
                             $_SESSION['processo']=$_GET['be4800'];
                            elseif(!isset($_GET['be4800'])&&(isset($_SESSION['processo']))):
                                 $processo=$_SESSION['processo'];
                             endif;
                             ?>
                <div class="panel-heading">
                Pesquiza aluno
                </div>
                <div class="panel-body">
                <form role="form" action="ver_xtrat.php" method="POST">
                <div class="form-inline">
                <div class="form-inline">
                <label>Processo:</label>
                <input type="text" class="form-control" name="txtpro" id="txtpro" placeholder="Processo do aluno" value="<?php if(isset($_SESSION['processo'])): echo $_SESSION['processo'];endif;?>"/>
                <label>Ano Lectivo:</label>
                <input type="text" class="form-control" name="txtano" id="txtano" placeholder="Ano lectivo" value="<?php echo date("Y");?>"/>

<input type="submit" value="Entrar" class="btn btn-primary" id="bt1"/>
</div>
<br/>

                </div>
                
                
                </form>
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
