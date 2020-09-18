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
include('conn2.php');
include '../_ClaS/Passe.php';

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Meu perfil</title>

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
                        <h1 class="page-head-line">Meu perfil</h1>
                        </div>
                </div>
                
                <div class="row">
                <div class="col-md-12">
                <div class="panel panel-default">
                <div class="panel-heading">
                Estado perfil
                </div>
                <div class="panel-body">
                <?php
                if(isset($_POST['bt34'])):
                $passe_antiga = $_POST['txtpasse_antiga'];
                $passe_nova = $_POST['txtpasse'];
                $passe_nova2 = $_POST['txtpasse2'];
                $id_pessoa33 = $_SESSION['id_pessoa33'];
         
                /** seters */
                                $Passe = new Passe;
                                $Passe->setID_pessoa($id_pessoa33);
                                $Passe->setCon($con2);
                                $Passe->setPasse_antiga($passe_antiga);
                                $Passe->setPasse_nova($passe_nova);
                                $Passe->setPasse_nova2($passe_nova2);
                                /** end seters */
                                $resp1 = $Passe->Ver_passeantiga();
                                if($resp1 == "no"){
                                    echo "<div class='alert alert-danger'>Passe antiga errada!</div>";
                                }
                                else{
                                   $resp2 = $Passe->ver_Confirmacao();
                                    if($resp2 == "no"){
                                      echo "<div class='alert alert-danger'>Confirmação de Senha errada!</div>";  
                                    }
                                    else{
                                      $resp3 = $Passe->_salvar();
                                        if($resp3 == "no"){
                                          echo "<div class='alert alert-danger'>erro ao salvar</div>";     
                                        }
                                        else{
                                          echo "<div class='alert alert-success'>Feito com sucesso</div>";    
                                        }    
                                    }
                                }
                
                endif;
                ?>
                    
                <form role="form" method="POST" enctype="multipart/form-data" action="">
                Foto:<br />
                <img src='foto/<?php echo $foto;?>' width="40%" height="150px"/><br />
                <input type="file" size="20" class="form-control" id="foto" name="foto"/>
                <br />
                Palavra passe Actual:<input type="text" size="30" class="form-control" name="txtpasse_antiga" id="txtpasse_antiga" placeholder="palavra passe actual" required/>
                <br />
                Nova palavra passe:<input type="text" size="30" class="form-control" name="txtpasse" id="txtpasse" placeholder="nova palavra passe" required/>
                 <br />
                Confirma Nova palavra passe:<input type="text" size="30" class="form-control" name="txtpasse2" id="txtpasse" placeholder="confirma nova palavra passe" required/>
                </div>
                <div class="panel-footer">
                <input type="submit" class="btn btn-primary" value="Salvar Alteração" name="bt34"/>
                </form>
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
