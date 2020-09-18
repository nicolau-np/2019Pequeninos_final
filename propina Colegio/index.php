<?php 
ob_start();
session_start();
if(isset($_SESSION['nomeS']) && (isset($_SESSION['senhaS'])))
{
    header("location:home.php");exit;
}
require_once("conn2.php");

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bem vindo ao sistema</title>

    <!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

</head>
<body style="background-color: #8574CC;">
    <div class="container">
        <div class="row text-center " style="padding-top:100px;">
            <div class="col-md-12">
                <img src="assets/img/logo.png" style="height: 50px; width: 40%;"/>
                <h3 style="color: #fff; font-weight:bold;" >Sistema de Gestão de Propinas</h3>
            </div>
        </div>
         <div class="row ">
               
                <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
                           
                            <div class="panel-body">
<?php 
if(isset($_GET['acao']))
{
    $ac=$_GET['acao'];
    if($ac="negado")
    {
        echo'<div class="alert alert-warning alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                 Usuário não está logado!!
                            </div>'; 
    }
}

if(isset($_POST['en']))
{
$nome=trim(strip_tags($_POST['nome']));
$senha=trim(strip_tags($_POST['senha']));

$sql="select *from view_logar where nome=:a and senha=:b";
try
{
   $s2=  md5($senha) ;
$result=$con2->prepare($sql);
$result->bindParam(":a",$nome, PDO::PARAM_STR);
$result->bindParam(":b",$s2, PDO::PARAM_STR);
$result->execute();
$contar=$result->rowCount();
if($contar>0)
{
 
$mostra=$result->fetch(PDO::FETCH_OBJ);
$id_pessoa33 = $mostra->id_pessoa;
$foto=$mostra->foto;
$titulo=$mostra->titulo;
if($titulo=="Administrador"):
    $titulo2="admin";
elseif($titulo=="Usuário Normal"):
     $titulo2="Usuário Normal";
elseif($titulo=="Usuário Normal 2"):
     $titulo2="admin2";
endif;
$estado=$mostra->estado;
$nome=$_POST['nome'];
$senha=$_POST['senha']; 
if($estado=="OFF")
{
  echo'<div class="alert alert-danger">
 <button type="button" class="close" data-dismiss="alert">×</button>
 Usuário não permitido!
 </div>';  
}
else{
    if(($titulo=="Administrador")||($titulo=="Usuário Normal 2")):
$_SESSION['nomeS']=$nome;
$_SESSION['senhaS']=$senha;
$_SESSION['tituloS']=$titulo2;
$_SESSION['fotoS']=$foto;
$_SESSION['id_pessoa33']=$id_pessoa33;
echo'<div class="alert alert-success">
Login feito com sucesso, a carregar...
</div>';
header("refresh:2, home.php");exit;  
    
    else:
         
      echo'<div class="alert alert-danger">
usuario nao permitido
</div>';  
    endif;

}

}
else
{
 echo'<div class="alert alert-danger">
 <button type="button" class="close" data-dismiss="alert">×</button>
 Erro ao fazer login!
 </div>';  
}

}catch(PDOException $e)
{
	echo $e;
}
    
}
?>
                            
                            
                                <form role="form" name='form1' action='index.php' method='POST'>
                                    <hr />
                                    <h5>Faça o seu login</h5>
                                       <br />
                                     <div class="form-group input-group">
                                            <span class="input-group-addon"><i class="fa fa-user"  ></i></span>
                                            <input type="text" class="form-control" placeholder="Nome de usuário " name="nome"/>
                                        </div>
                                                                              <div class="form-group input-group">
                                            <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                                            <input type="password" class="form-control"  placeholder="Palavra-passe" name="senha" />
                                        </div>
                                    <div class="form-group">
                                            <label class="checkbox-inline">
                                                <input type="checkbox" /> Lembrar-me
                                            </label>
                                        </div>
                                     
                                     <input type='submit' class="btn btn-primary " value="Entrar" name='en'/>
                                  
                                    <hr />
                                    
                                    </form>
                            </div>
                    <center> <a href="../index.php" class="" style="color:white; font-weight: bold; text-decoration: none;" title="voltar"><i class="fa fa-refresh fa-2x"></i></a>
                        </center></div>
                
                
        </div>
    </div>

</body>
</html>
