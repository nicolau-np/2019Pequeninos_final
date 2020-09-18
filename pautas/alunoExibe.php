<?php 
session_start();
include_once 'config/conn.php';
$nome =addslashes(htmlspecialchars($_GET['nome']));
?>
<table id="tableM" class="table table-bordered responsive">
                    <colgroup>
                        <col class="con0" style="align: center; width: 4%" />
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                    </colgroup>
                    <thead>
                        <tr>
                          	<th class="head0 nosort"><input type="checkbox" class="checkall" /></th>
                            <th class="head0">Nº Proc.</th>
                            <th class="head1">Nome Completo</th>
							 <th class="head0">Curso</th>
                            <th class="head1">Classe</th>
                            <th class="head0">Editar</th>
                            <th class="head1">Declaração</th>
                            <th class="head0">Certificado</th>
                            <th class="head1">Confirmar</th>
                            <th class="head0">Transferencia</th>
                             <th class="head1">Desistência</th>
                          <th class="head0">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $select="select *from view_estudante where nome LIKE '%$nome%' OR bi='$nome' limit 16";
        $xe=$con->prepare($select);
        $xe->execute();
                    while($ver=$xe->fetch(PDO::FETCH_OBJ))
                    {
                        ?>
                        <tr class="gradeX">
                          <td class="aligncenter"><span class="center">
                            <input type="checkbox" />
                          </span></td>
                            <td><a href="historic.php?id_aluno=<?php echo $ver->id_aluno;?>"><?php echo $ver->id_aluno;?></a></td>
                            <td><?php echo $ver->nome;?></td>
							<td><?php echo $ver->curso;?></td>
                            <td><?php echo $ver->classe;?></td>
                            
                             <td><a href="editar_aluno.php?id_pessoa=<?php echo $ver->id_pessoa;?>&&id_aluno=<?php echo $ver->id_aluno;?>&&foto=<?php echo $ver->foto;?>" class="btn btn-primary">Editar</a></td>
                            <td><?php if($_SESSION['tituloMRX']!="Usuário Normal 2"): echo '<a href="declaracao.php?id_pessoa='.$ver->id_pessoa.'&&id_aluno='.$ver->id_aluno.'&&foto='.$ver->foto.'" class="btn btn-default">Declaração</a>';else: echo '----';endif;?></td>
                            <td><?php if($_SESSION['tituloMRX']!="Usuário Normal 2"): if(($ver->classe=="9ª")||($ver->classe=="6ª")): echo '<a href="certificado.php?id_pessoa='.$ver->id_pessoa.'&&id_aluno='.$ver->id_aluno.'&&classe='.$ver->classe.'" class="btn btn-info">Certificado</a>'; else: echo '<span style="color:red;">----</span>';endif; else: echo '----';endif;?></td>
                           <td><a href="confirm_Matricula.php?id_pessoa=<?php echo $ver->id_pessoa;?>&&id_aluno=<?php echo $ver->id_aluno;?>&&foto=<?php echo $ver->foto;?>" class="btn btn-success" style="color: #fff;">Confirmar</a></td>
                           <td><?php if($_SESSION['tituloMRX']!="Usuário Normal 2"): echo'<a href="transferencia.php?id_pessoa='.$ver->id_pessoa.'&&id_aluno='.$ver->id_aluno.'&&foto='.$ver->foto.'" class="btn btn-info" style="color: #fff;">Transferencia</a>'; else: echo '----';endif;?></td> 
                           <td><a href="m_desistencia.php?id_pessoa=<?php echo $ver->id_pessoa;?>&&id_aluno=<?php echo $ver->id_aluno;?>&&foto=<?php echo $ver->foto;?>" class="btn btn-warning" style="color: #fff;">Desistência</a></td>
                           <td><?php if($_SESSION['tituloMRX']!="Usuário Normal 2"): echo'<a href="confirm_dele.php?id_pessoa='.$ver->id_pessoa.'&&id_aluno='.$ver->id_aluno.'&&foto='.$ver->foto.'" class="btn btn-danger" style="color: #fff;">Eliminar</a>';endif;?></td>
                        </tr>
             <?php }?>
                    </tbody>
                </table>
