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
    <title>DADOS ALUNOS</title>

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
<script>
$(document).ready(function(){
    $(".coma2").hide();
    $("#txtna").hide();
    $("#txtna2").hide();
$("#carrega").load('alu1.php');

$("#btos1").click(function() {
		var c=$("#txtna").val();
		var i=parseInt(c)-1;

		$("#carrega").load('alu1.php?pagina='+i);
	});
	
	$("#btos2").click(function() {
		var c=$("#txtna").val();

	var o=parseInt(c)+1;
		$("#carrega").load('alu1.php?pagina='+o);
	});

$("#txtpes").keyup(function(){
    $(".coma2").show();
    $(".coma1").hide();
     $("#txtna3").hide();
    $("#txtna4").hide();
    
    var a=$("#txtpes").val();
    
    $.ajax({
		type:"GET",
		url:"alu2.php",
        data:"nome="+a,
		dataType:"html",	
		success: function(dados){
	$("#carrega").text('')
	.append(dados);},});
    
});

$("#btos3").click(function() {
		var c=$("#txtna3").val();
		var i=parseInt(c)-1;

		$("#carrega").load('alu2.php?pagina='+i);
	});
	
	$("#btos4").click(function() {
		var c=$("#txtna3").val();

	var o=parseInt(c)+1;
		$("#carrega").load('alu2.php?pagina='+o);
	});
    
    $("#bt2").click(function(){
      $(".coma2").hide();
      $(".coma1").show();
    $("#txtna").hide();
    $("#txtna2").hide();
$("#carrega").load('alu1.php');  
    });

});
</script>
</head>
<body>
<?php
    require_once("menu.php");
	?>
    
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">DADOS ALUNOS</h1>
                    </div>
                </div>
                          <!-- /. ROW  -->
                <div class="row">
                    <div class="col-md-12">
                    <?php 
                    if(isset($_GET['aviso']))
                    {
                        if($_GET['aviso']=='p')
                        {
                         echo('<div class="alert alert-success">
                            Aluno eliminado com sucesso!
                            </div>');   
                        }
                        elseif($_GET['aviso']=='b')
                        {
                          echo('<div class="alert alert-success">
                        Actualização feita com sucesso!
                </div>  ');
                        }
						 elseif($_GET['aviso']=='V5')
                        {
                          echo('<div class="alert alert-warning">
                        Já foi feita a confirmação para este ano!
                </div>  ');
                        }
                        
                    }
                    ?>
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                        <form class="form-inline" method="POST" role="form" name="form1">
                        Alunos Cadastrados&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="text" class="form-control" name="txtpes" id="txtpes" placeholder="Entre com o nome..."/>
                        <button name="bt2" class="btn btn-info" id="bt2"><span class="fa fa-repeat"></span> Todos</button>
                         </form>
                        </div>
                        <div class="panel-body" id="carrega">
                        
                        </div>
                        <div class="panel-footer" id="comandos">
                        <div class="coma1">
                        <form class="form-inline" role="form" name="form3">
                        <input type="text" name="txtna" id="txtna"/>
                        <input type="text" name="txtna2" id="txtna2"/>
                        <button type="button" name="btos1" id="btos1" class="btn btn-default btn-sm btn-round">Previous</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                         <button type="button" name="btos2" id="btos2" class="btn btn-default btn-sm btn-round">Next</button>
                        </form>
                        </div>
                        <div class="coma2">
                        <form class="form-inline" role="form" name="form7">
                        <input type="text" name="txtna3" id="txtna3"/>
                        <input type="text" name="txtna4" id="txtna4"/>
                        <button type="button" name="btos3" id="btos3" class="btn btn-default btn-sm btn-round">Previous</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                         <button type="button" name="btos3" id="btos4" class="btn btn-default btn-sm btn-round">Next</button>
                        </form>
                        </div>
                        
                        </div>
                        
                    </div>
     
                </div>
<!-- /. end ROW  -->

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