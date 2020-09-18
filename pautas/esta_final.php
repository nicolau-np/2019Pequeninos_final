<table class="table table-bordered">
                    <thead>
                    <tr>
                        <th colspan="16">tabela de Estatísticas Estudantes</th>
                    </tr>
                    <tr>
                        <th colspan="2">Aproveitamento de Estudantes</th>
                        <th colspan="3">Estudantes Existentes</th>
                        <th colspan="3">Estudantes Desistidos</th>
                        <th colspan="3">Estudantes Transferidos</th>
                    </tr>
                    <tr>
                        <td>Áptos</td>
                        <td>N/Áptos</td>
                        
                        <td>Masculino</td>
                        <td>Femenino</td>
                        <td>Total</td>
                        
                        <td>Masculino</td>
                        <td>Femenino</td>
                        <td>Total</td>
                        
                        <td>Masculino</td>
                        <td>Femenino</td>
                        <td>Total</td>
                    </tr>
                    
                         <tr>   

<?php          
                             //aqui o ano Letivo
                             
                             //fim
                             
                             $apto="Transita";
                             $napto="Não Transita";
                             //aproveitamento
                             $se00="select *from view_historico where anolectivo=:ano and aproveitamento=:apto";
                             $r00=$con->prepare($se00);
                             $r00->bindParam(":ano",$a,PDO::PARAM_STR);
                             $r00->bindParam(":apto",$apto,PDO::PARAM_STR);
                             $r00->execute();
                             $conta_aptos=$r00->rowCount();
                             
                              $se01="select *from view_historico where anolectivo=:ano and aproveitamento=:napto";
                             $r01=$con->prepare($se01);
                             $r01->bindParam(":ano",$a,PDO::PARAM_STR);
                             $r01->bindParam(":napto",$napto,PDO::PARAM_STR);
                             $r01->execute();
                             $conta_naptos=$r01->rowCount();//fim aproveitamento
                             ?>
                        <td><?php echo $conta_aptos;?> </td>
                        <td><?php echo $conta_naptos;?> </td>
                    
                        <?php 
                        $desis="Desistencia";
                        $trans="Transferencia";
                        $genero1="Femenino";
                        $genero2="Masculino";
                         //existentes
                             $se02="select *from view_historico where anolectivo=:ano and genero=:genero and (aproveitamento!=:trans and aproveitamento!=:desis)";
                             $r02=$con->prepare($se02);
                             $r02->bindParam(":ano",$a,PDO::PARAM_STR);
                             $r02->bindParam(":genero",$genero1,PDO::PARAM_STR);
                             $r02->bindParam(":trans",$trans,PDO::PARAM_STR);
                             $r02->bindParam(":desis",$desis,PDO::PARAM_STR);
                             $r02->execute();
                             $conta_existentes_femenino=$r02->rowCount();
                             
                                $se03="select *from view_historico where anolectivo=:ano and genero=:genero and (aproveitamento!=:trans and aproveitamento!=:desis)";
                             $r03=$con->prepare($se03);
                             $r03->bindParam(":ano",$a,PDO::PARAM_STR);
                             $r03->bindParam(":genero",$genero2,PDO::PARAM_STR);
                             $r03->bindParam(":trans",$trans,PDO::PARAM_STR);
                             $r03->bindParam(":desis",$desis,PDO::PARAM_STR);
                             $r03->execute();
                             $conta_existentes_masculino=$r03->rowCount();;//fim aproveitamento
                        
                        ?>
                        <td> <?php echo $conta_existentes_masculino;?></td>
                        <td> <?php echo $conta_existentes_femenino;?></td>
                        <td> <?php echo ($conta_existentes_masculino + $conta_existentes_femenino);?></td>
                        
                        
                        <?php 
                        //desistidos
                             $se04="select *from view_historico where anolectivo=:ano and genero=:genero and aproveitamento=:desis";
                             $r04=$con->prepare($se04);
                             $r04->bindParam(":ano",$a,PDO::PARAM_STR);
                             $r04->bindParam(":genero",$genero1,PDO::PARAM_STR);
                         
                             $r04->bindParam(":desis",$desis,PDO::PARAM_STR);
                             $r04->execute();
                             $conta_desistidos_femenino=$r04->rowCount();
                             
                                $se05="select *from view_historico where anolectivo=:ano and genero=:genero and aproveitamento=:desis";
                             $r05=$con->prepare($se05);
                             $r05->bindParam(":ano",$a,PDO::PARAM_STR);
                             $r05->bindParam(":genero",$genero2,PDO::PARAM_STR);
                         
                             $r05->bindParam(":desis",$desis,PDO::PARAM_STR);
                             $r05->execute();
                             $conta_desistidos_masculino=$r05->rowCount();;//fim aproveitamento
                        
                        ?>
                        <td> <?php echo $conta_desistidos_masculino;?></td>
                        <td> <?php echo $conta_desistidos_femenino;?></td>
                        <td> <?php echo ($conta_desistidos_masculino + $conta_desistidos_femenino);?></td>
                        
                        <?php 
                        //desistidos
                             $se06="select *from view_historico where anolectivo=:ano and genero=:genero and aproveitamento=:trans";
                             $r06=$con->prepare($se06);
                             $r06->bindParam(":ano",$a,PDO::PARAM_STR);
                             $r06->bindParam(":genero",$genero1,PDO::PARAM_STR);
                         
                             $r06->bindParam(":trans",$trans,PDO::PARAM_STR);
                             $r06->execute();
                             $conta_transferidos_femenino=$r06->rowCount();
                             
                                $se07="select *from view_historico where anolectivo=:ano and genero=:genero and aproveitamento=:trans";
                             $r07=$con->prepare($se07);
                             $r07->bindParam(":ano",$a,PDO::PARAM_STR);
                             $r07->bindParam(":genero",$genero2,PDO::PARAM_STR);
                         
                             $r07->bindParam(":trans",$trans,PDO::PARAM_STR);
                             $r07->execute();
                             $conta_transferidos_masculino=$r07->rowCount();;//fim aproveitamento
                        
                        ?>
                        <td> <?php echo $conta_transferidos_masculino;?></td>
                        <td> <?php echo $conta_transferidos_femenino;?></td>
                        <td> <?php echo ($conta_transferidos_masculino + $conta_transferidos_femenino);?></td>
                    </tr>
                    
                    </thead>
                </table>
