<?php 
ob_start();
session_start();
if(!isset($_SESSION['nomeS']) && (!isset($_SESSION['senhaS'])))
{
    header("location:index.php?acao=negado");exit;
}
include 'conn2.php';
$nome=$_SESSION['nomeS'];
$titulo=$_SESSION['tituloS'];
$foto=$_SESSION['fotoS'];
  

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pagamento de Folha de Prova</title>

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
                        <h1 class="page-head-line">Pagamento de Folha de Prova</h1>
                        </div>
                </div>
                <div class="row">
                <div class="col-md-12">
                <div class="panel panel-success">
                <div class="panel-heading">
                Pesquize a turma
                </div>
                <div class="panel-body">
                <form role="form" action="p34.php" method="POST">
                <div class="form-inline">
                
 
                    <span class="field"><select name="curso" id="selection1" class="form-control" required="">
                            <option value="">Curso</option>
                                                    <?php 
$t="select *from tbl_curso";
$a=$con2->prepare($t);
$a->execute();
while($ver=$a->fetch(PDO::FETCH_OBJ))
{
?>
<option value="<?php echo $ver->curso;?>"><?php echo $ver->curso;?></option>
<?php }?>
</select></span>
			 
                    <span class="field"><select name="classe" id="selection1" class="form-control" required="">
                                        <option value="">Classe</option>
                                <?php 
                                $sel1="select *from tbl_classe";
                                $ex1=$con2->prepare($sel1);
                                $ex1->execute();
                                while($ver1=$ex1->fetch(PDO::FETCH_OBJ))
                                {
                                    
                               
                                ?>
                                          <option value="<?php echo $ver1->classe;?>"><?php echo $ver1->classe;?></option>
             <?php  }?>
                                </select></span>
                         
                             
                    <span class="field"><select name="turma" id="selection2" class="form-control" required="">
                                        <option value="">Turma</option>
                                <?php 
                                $sel2="select *from tbl_turma";
                                $ex2=$con2->prepare($sel2);
                                $ex2->execute();
                                while($ver2=$ex2->fetch(PDO::FETCH_OBJ))
                                {
                                    
                               
                                ?>
                                    <option value="<?php echo $ver2->turma;?>"><?php echo $ver2->turma; ?></option>
                   <?php  }?>
                                </select></span>
                       
                               
                    <span class="field"><select name="turno" id="selection3" class="form-control" required="">
                                        <option value="">Turno</option>
                                <?php 
                                $sel3="select *from tbl_turno";
                                $ex3=$con2->prepare($sel3);
                                $ex3->execute();
                                while($ver3=$ex3->fetch(PDO::FETCH_OBJ))
                                {
                                    
                               
                                ?>
                                    <option value="<?php echo $ver3->turno;?>"><?php echo $ver3->turno;?></option>
                             <?php  }?>
                                </select></span>
                         

                    <input type="text" name="anoS" value="<?php echo date("Y");?>" class="form-control"/>
<input type="submit" value="Entrar" class="btn btn-primary" id="bt1"/>
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

