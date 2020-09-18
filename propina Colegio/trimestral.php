<?php 
require_once("conn.php");
$ano=$_GET['ano'];
$mes=$_GET['mes'];
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>B</title>

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
</head>
<body>
<br />

<?php 
//pagamentos propina
$co="SELECT SUM(valor) FROM ver where ano_lectivo=:ano and mes=:mes";
$exe=$con->prepare($co);
$exe->bindParam(":ano",$ano,PDO::PARAM_STR);
$exe->bindParam(":mes",$mes,PDO::PARAM_STR);
$exe->execute();
$soma1=$exe->fetchColumn();

//femenino
$genero="Femenino";
$co="SELECT SUM(valor) FROM ver where ano_lectivo=:ano and genero=:genero and mes=:mes";
$exe=$con->prepare($co);
$exe->bindParam(":ano",$ano,PDO::PARAM_STR);
$exe->bindParam(":genero",$genero,PDO::PARAM_STR);
$exe->bindParam(":mes",$mes,PDO::PARAM_STR);
$exe->execute();
$soma=$exe->fetchColumn();
echo "<b>Genero Femenino:</b> ".$soma.".00<br/>";

//masculino
$genero="Masculino";
$co="SELECT SUM(valor) FROM ver where ano_lectivo=:ano and genero=:genero and mes=:mes";
$exe=$con->prepare($co);
$exe->bindParam(":ano",$ano,PDO::PARAM_STR);
$exe->bindParam(":genero",$genero,PDO::PARAM_STR);
$exe->bindParam(":mes",$mes,PDO::PARAM_STR);
$exe->execute();
$soma=$exe->fetchColumn();
echo "<b>Genero Masculino:</b> ".$soma.".00<br/>";

echo "<b>Total Geral:</b> ".($soma1).".00<br/>";
?>

</body>
</html>