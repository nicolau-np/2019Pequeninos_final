<?php 
include("config/conn.php");
include("validarlogin.php");
$id=$_GET['id_disciplina'];

$sql="delete from tbl_disciplinas where id_disciplina=:id";
$run26=$con->prepare($sql);
$run26->bindParam(":id",$id,PDO::PARAM_STR);
$run26->execute();
if($run26):
    echo '<script>
        window.alert("Feito com sucesso");
        window.location.href="boxes.php";
    </script>';
endif;
?>