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
include_once 'conn2.php';

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Modalidade de Pagamento</title>

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
                        <h1 class="page-head-line">Modalidade de Pagamento</h1>
                        </div>
                </div>
                <div class="row">
                <div class="col-md-12">
            
                <div class="panel panel-success">
                <div class="panel-heading">
                Pesquiza alunos
                </div>
                <div class="panel-body">
                <?php 
                if(addslashes(htmlspecialchars(isset($_POST['btEnv'])))):
                    $id_aluno = addslashes(htmlspecialchars($_POST['proce']));
                    $ano_lectivo = addslashes(htmlspecialchars($_POST['ano']));
                    
                    echo 'ID ALUNO: '.$id_aluno.' ANO LECTIVO:'.$ano_lectivo.'<br/>';
                    
                    foreach ($_POST['epoca'] as $epocas):
                        
                      $eP=$epocas." Trimestre";
                      $sele20 = "select *from tbl_pagamento where id_aluno=:id and "
                            . "ano_lectivo=:ano and mes=:mes";
                      $run20=$con2->prepare($sele20);
                      $run20->bindParam(":id", $id_aluno, PDO::PARAM_STR);
                      $run20->bindParam(":ano", $ano_lectivo, PDO::PARAM_STR);
                      $run20->bindParam(":mes", $eP, PDO::PARAM_STR);
                      $run20->execute();
                      if($run20->rowCount()>0):
                            echo 'Cadastrou Epoca: '.$eP.'<br/>';
                      elseif($run20->rowCount()==0):
                          
                    try{
                      
                    $sql="insert into tbl_pagamento (id_aluno,mes,ano_lectivo,pago)values(:id_aluno,:mes,:ano_lectivo,:pago)";
               
                        $result=$con2->prepare($sql);
                        $result->bindParam(":id_aluno",  $id_aluno,PDO::PARAM_STR);
                        $result->bindParam(":mes",$eP,PDO::PARAM_STR);
                        $result->bindParam(":ano_lectivo",$ano_lectivo,PDO::PARAM_STR);
                        $result->bindParam(":pago",$pago,PDO::PARAM_STR);
                        
                        $result->execute();
                     
                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }
            
                if($result):
                    echo '<div class="alert alert-success">Cadastro feito com sucesso</div>';
                endif;
                      endif;
                    endforeach;
                    
                endif;
                ?>    
                    
                <form role="form" action="" method="POST">
                    <div class="form-inline">
                    <b>Processo:</b><input type="text" name="proce" value="<?php if(addslashes(htmlspecialchars(isset($_POST['proce'])))): echo addslashes(htmlspecialchars($_POST['proce']));endif;?>" placeholder="Processo" class="form-control"/>
                    <b>Ano Lectivo:</b><input type="text" name="ano" value="<?php if(addslashes(htmlspecialchars(isset($_POST['ano'])))): echo addslashes(htmlspecialchars($_POST['ano']));endif;?>" placeholder="Ano Lectivo" class="form-control"/>
                    </div>
                    <br/>
                    <div class="form-inline">
                        <input type="checkbox" name="epoca[]" value="1"> 1º Trimestre <br/>
                        <input type="checkbox" name="epoca[]" value="2"> 2º Trimestre <br/>
                        <input type="checkbox" name="epoca[]" value="3"> 3º Trimestre <br/>
                    </div>
                    <br/>
                    <input type="submit" name="btEnv" class="btn btn-primary" value="Inserir Epocas" />
                </form>
                    
                    <div id="exibeEstado">
                        
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
        <b>&copy; <?php echo date('Y');?> OKUSSOLEKA | Powered By : Nicolau Ngala Pungue</b>
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
