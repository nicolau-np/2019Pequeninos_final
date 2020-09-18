<?php 
include("config/conn.php");
include("validarlogin.php");
$id=$_GET['id_falta'];
  $estado1="ativo";
  $estado2="inativo";
  $ano=date("Y");
                      
                                $up="update tbl_falta_prof set estado=:estado2, motivo=:motivo where id_falta_prof=:id_prof and ano=:ano and estado=:estado1";
                            $run33=$con->prepare($up);
                            $run33->bindParam(":estado2",$estado2,PDO::PARAM_STR);
                             $run33->bindParam(":motivo",$motivo,PDO::PARAM_STR);
                              $run33->bindParam(":id_prof",$id,PDO::PARAM_STR);
                               $run33->bindParam(":ano",$ano,PDO::PARAM_STR);
                                $run33->bindParam(":estado1",$estado1,PDO::PARAM_STR);
                            $run33->execute();
                            
                       if($run33):
                           echo'<script> 
                               window.location.href="just_prof.php?jus=12123";
                           </script>';
                       
                       endif;

?>