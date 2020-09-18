<?php
include("validarlogin.php");
include("config/conn.php");
$curso=$_GET['curso'];
$classe=$_GET['classe']; 
?>

<select name="disciplina" id="selection1" class="input-medium" required="">
    <option value="">Selecione</option>
                                <?php 
                                
$sql27="select *from tbl_disciplinas where id_classe=:id_classe and id_curso=:id_curso";
$run27=$con->prepare($sql27);
$run27->bindParam(":id_classe",$classe,PDO::PARAM_STR);
$run27->bindParam(":id_curso",$curso,PDO::PARAM_STR);
$run27->execute();
while($view=$run27->fetch(PDO::FETCH_OBJ)){
  
                                
                                
                                $sel1="select *from tbl_dis2 where id_di2=:id";
                                $ex1=$con->prepare($sel1);
                                $ex1->bindParam(":id",$view->id_di2,PDO::PARAM_STR);
                                $ex1->execute();
                              $ver4=$ex1->fetch(PDO::FETCH_OBJ);
                                ?>
                                          <option value="<?php echo $view->id_di2;?>"><?php echo $ver4->nome;?></option>
             <?php  }?>
                                </select>
               
