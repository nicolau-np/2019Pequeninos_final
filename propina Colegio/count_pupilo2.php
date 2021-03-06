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
    <title>Corrigir pagamento</title>

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
<script src="assets/js/jquery-1.5.2.js"></script>
<script type="text/javascript" src="assets/js/permit.js"></script>
<script>
$(document).ready(function(e){
 $("#bt1").click(function()
 {
    var ano=$("#ano").val();
    var op=$("#txtop").val();
    if(op=="Fazer pagamento")
    {
      var p=$("#txtpro").val();
    $(".mostrar").load('aluno5.php?pro='+p+'&ano='+ano);  
    }
          else if(op=="declaracao")
    {
       var p=$("#txtpro").val();
    $(".mostrar").load('declaracao2.php?pro='+p+'&ano='+ano);     
    }
    
    else if(op=="transferencia")
    {
       var p=$("#txtpro").val();
    $(".mostrar").load('transferencia2.php?pro='+p+'&ano='+ano);     
    }
      else if(op=="folha")
    {
       var p=$("#txtpro").val();
    $(".mostrar").load('folha2.php?pro='+p+'&ano='+ano);     
    }
        else if(op=="certificado")
    {
       var p=$("#txtpro").val();
    $(".mostrar").load('certificado2.php?pro='+p+'&ano='+ano);     
    }
         else if(op=="transporte")
    {
       var p=$("#txtpro").val();
    $(".mostrar").load('transporte2.php?pro='+p+'&ano='+ano);     
    }
    
          else if(op=="PagarProvaExame")
    {
       var p=$("#txtpro").val();
    $(".mostrar").load('PagarProvaExame2.php?pro='+p+'&ano='+ano);     
    }
    
             else if(op=="Uniforme")
    {
       var p=$("#txtpro").val();
    $(".mostrar").load('Uniforme2.php?pro='+p+'&ano='+ano);     
    }
    
               else if(op=="Estágio")
    {
       var p=$("#txtpro").val();
    $(".mostrar").load('Estagio2.php?pro='+p+'&ano='+ano);     
    }
    
     else if(op=="comparticipacao")
    {
       var p=$("#txtpro").val();
    $(".mostrar").load('comparticipacao2.php?pro='+p+'&ano='+ano);     
    }
   
    else
    {
      var p=$("#txtpro").val();
    $(".mostrar").load('aluno6.php?pro='+p+'&ano='+ano);  
    }
    
 });

});
</script>

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
                        <h1 class="page-head-line">Corrigir pagamento</h1>
                        </div>
                </div>
                <div class="row">
                <div class="col-md-12">
            
                     <?php 
                             if(isset($_GET['be4800'])):
                                 $processo444=$_GET['be4800'];
                             $_SESSION['processo444']=$_GET['be4800'];
                           elseif(!isset($_GET['be4800'])&&(isset($_SESSION['processo444']))):
                                 $processo444=$_SESSION['processo444'];
                             endif;
                             ?>
                    
                <div class="panel panel-success">
                <div class="panel-heading">
                Pesquiza aluno
                </div>
                <div class="panel-body">
                <form role="form" action="" method="POST">
                <div class="form-inline">
                <label>Processo:</label>
                <input type="text" class="form-control" name="txtpro" id="txtpro" placeholder="Processo do aluno" value="<?php if(isset($_SESSION['processo444'])): echo $_SESSION['processo444'];endif;?>"/>
                <label>Operação:</label>
                <select size="1" class="form-control" id="txtop" name="txtop">
	<option value="Fazer pagamento">Propina</option>
    <option value="inscricao">Matrícula e Reconfirmação</option>
    <option value="comparticipacao">Comparticipação Encarregados</option>
     <option value="declaracao">Declaração</option>
     <option value="transferencia">Transferencia</option>
     <option value="folha">Folha de Prova</option>
      <option value="certificado">Certificado</option>
      <option value="transporte">Transporte</option>
        <option value="PagarProvaExame">Pagar Prova/Exame</option>
  <option value="Uniforme">Uniforme</option>
  <option value="Estágio">Estágio</option>

</select>
                <span id="exibe4">
                    <input name="ano" id="ano" class="form-control" style="width: 150px;" value="<?php echo date("Y");?>"/></span>
<input type="button" value="Entrar" class="btn btn-primary" id="bt1" />
<br/>
<br />
<div class="mostrar">
    <?php 
                if(isset($_GET['n']))
                {
                    if($_GET['n']=="e")
                    {
                        echo "<div class='alert alert-danger'>Processo nao encontrado</div>";
                    }
                }
                
                ?>
</div>
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
