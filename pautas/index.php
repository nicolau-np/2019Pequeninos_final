<?php 
include("config/conn.php");
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Bem-Vindo ao Sistema</title>
<link rel="stylesheet" href="css/style.default.css" type="text/css" />
<link rel="stylesheet" href="css/style.shinyblue.css" type="text/css" />

<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/jquery-migrate-1.1.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.9.2.min.js"></script>
<script type="text/javascript" src="js/modernizr.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('#login').submit(function(){
            var u = jQuery('#username').val();
            var p = jQuery('#password').val();
            if(u == '' && p == '') {
                jQuery('.login-alert').fadeIn();
                return false;
            }
        });
    });
</script>
</head>

<body class="loginpage">

<div class="loginpanel">
    <div class="loginpanelinner">
        <div class="logo animate0 bounceIn"><img src="images/logo.png" alt="" /></div>
        
        
        <form id="login" action="index.php" method="POST">
            <div class="ty">
            <?php 
            include("classes/logar.php");
            if(isset($_POST['et']))
            {
              $nome=$_POST['nome'];
            $senha=$_POST['senha'];  
            
            $obj=new logar;
            $obj->entra($nome,$senha,$con);
            }
            if(isset($_GET['e'])){
             print("<div class='alert alert-info'>Usuário não logado, deve iniciar sessão!</div>");   
            }
            
            if((isset($_SESSION['nomeMRX']))&&(isset($_SESSION['tituloMRX'])))
            {
                header("location:dashboard.php");
            }
            ?>
              
            </div>
            <div class="inputwrapper animate1 bounceIn">
                <input type="text" name="nome" id="username" placeholder="Nome de utilizador" required=""/>
            </div>
            <div class="inputwrapper animate2 bounceIn">
                <input type="password" name="senha" id="password" placeholder="Senha de utilizador" required=""/>
            </div>
            <div class="inputwrapper animate3 bounceIn">
                <button type="submit" name="et">Entrar</button>
            </div>
            <div class="inputwrapper animate4 bounceIn">
                <label><input type="checkbox" class="remember" name="signin" />Guardar seus dados</label>
            </div>
            
        </form>
    </div><!--loginpanelinner-->
    <a href="../index.php" class="" style="color:white; font-weight: bold; text-decoration: none;" title="voltar"><i class="iconfa-refresh iconfa-2x"></i></a>
</div><!--loginpanel-->

<div class="loginfooter">
    <p> Todos os direitos reservados.</p>
</div>

</body>
</html>
