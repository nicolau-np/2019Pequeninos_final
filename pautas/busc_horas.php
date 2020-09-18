<?php
include_once 'config/conn.php';
include_once 'horario/Hora.php';
if(addslashes(htmlspecialchars($_GET['turno']))):
  $turno = addslashes(htmlspecialchars($_GET['turno']));  

$objHora = new Hora();
$objHora->setCon($con);
$objHora->setId_turno($turno);
$res = $objHora->_horas();

    
?>

    <p>
                            <label>Hora E/S:</label>
                            <span id="id_hora">
                                <select name="id_hora" required="">
                                    <option value="">Selecione</option>
                                    <?php 
                                    $res2 = $objHora->_horas();
                                    while(($view = $res->fetch(PDO::FETCH_OBJ)) && ($view2 = $res2->fetch(PDO::FETCH_OBJ))):
                                    ?>
                                    <option value="<?php echo $view->id_hora;?>"><?php echo $view->hora_e." / ".$view2->hora_s;?></option>
                                    <?php endwhile;?>
                                </select>
                            </span>
                            
                        </p>

<?php 
endif;
?>

