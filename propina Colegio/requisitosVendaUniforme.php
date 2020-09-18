<?php
session_start();
/**
 * @author lolkittens
 * @copyright 2016
 */

require_once("conn2.php");
$funcionario=$_SESSION['nomeS'];
$titulo=$_SESSION['tituloS'];
$id_aluno = 0;  $id_pessoa=0; $nome_aluno="?";
/*
$id_pessoa = $_SESSION['idpessoa'];*/

  if((isset($_SESSION['processo444'])) && (isset($_SESSION['processo444']) !=0)){
      $id_aluno = $_SESSION['processo444'];
     $run = $con2->prepare("SELECT * FROM view_estudante WHERE id_aluno =:IDALUNO");
     $run->bindParam(":IDALUNO",$id_aluno,PDO::PARAM_INT);
     if( ($run->execute()) && ($run->rowCount() >0)){
         $res = $run->fetch(PDO::FETCH_OBJ);
         $id_pessoa = $res->id_pessoa; 
         $nome_aluno = $res->nome;
     }
  }



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8" />
<script src="assets/js/jquery-1.5.2.js" type="text/javascript"></script>
<title>View</title>

<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   

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

</head>
<style type="text/css">
  /*.tableLeft{float: left;}*/
</style>

<body>
  <?php
   // require_once("menu.php");
  ?>

 

        <!-- ================== TABELA DE PRODUTOS SELECIONADOS PARA A COMPRA ===================-->      

          <div class="tableRight">
            <div class="row">
              <div class="col-md-12">
                <h2 class="page-head-li">Informe os Dados Abaixo</h2>
                <br>
              </div>
            </div>
              <div style="float: left; margin-right: 2%;">
                <img width="120" height="130" src="../pautas/fotos_usuarios/<?php echo $res->foto;?>" class="img-thumbnail"/>
              </div>
              <div style="float: left; margin-right: 3%;">
                <label>Aluno: </label><span><?php echo(" ".utf8_encode($res->nome));  ?></span><br>
                <label>Processo nº </label><span><?php echo(" ".$id_aluno);  ?></span><br>
                <label>Curso: </label><span><?php echo(" ".$res->curso);  ?></span><br>
              </div>
              <div style="">                
                <label>Classe: </label><span><?php echo(" ".$res->classe);  ?></span><br>
                <label>Turma: </label><span><?php echo(" ".$res->turma);  ?></span><br>
                <label>Período: </label><span><?php echo(" ".$res->turno);  ?></span><br>
              </div>           
              <br/><br/>
              <?php 
                    $_SESSION['idaluno'] = $id_aluno;
                    $_SESSION['idpessoa'] = $id_pessoa;
                    $_SESSION['nome_aluno'] = $nome_aluno;

              ?>
              <form action="venderUniforme.php" method="POST">
                <table>
                  <thead>
                     <tr>
                       <th>Cliente</th>
                       <th>Talão Nº</th>
                       <th>Data do Depósito</th>
                       <th>Ano Lectivo</th>
                     </tr>
                  </thead>
                  <tbody> 
                    <tr>                  
                      <td><input type="text" name="cliente" id="cliente" placeholder="Nome do Cliente" required class="form-control"></td>
                      <td><input type="number" name="numerotalao" id="numerotalao" placeholder="Talão de depósito nº " required class="form-control"></td>
                       <td><input type="date" name="dataDeposito" id="dataDeposito" required class="form-control"></td>
                       <td><input type="number" name="anoLectivo" id="anoLectivo" value="2018" required placeholder="Ano lectivo" class="form-control"></td>                    
                        <?php  //echo('<button> <a href="fatura_uniforme1.php?accao=save" target="blanck" >Save</a></button>'); ?>
                    </tr>                    
                    <tr>  
                      <td><input type="submit" value="SEGUINTE" name="seguinte" class="btn btn-success"></td>
                    </tr>
                  </tbody> 
                </table>
              </form>
              
      
    </div>
    </div>
    <!-- ===================== End of uniforme Table ====================-->
   

<script>
$("document").ready(function(e){
$("#btos1").hide();
$("#btos2").hide();	
$("#txtna").val(<?php echo $pagina;?>);
$("#txtna2").val(<?php echo $numpaginas;?>);
var a=$("#txtna").val();
var b=$("#txtna2").val();
if(a!=1)
{
$("#btos1").show();	
}
if(a!=b)
{
	
$("#btos2").show();	
}
});
</script>
</body>
</html>
