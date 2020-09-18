<?php

class salvar_aluno{
     var $idPessoa=0; var $idAluno=0; var $insertAlu=0;var $bi=""; var $resSelecPessoa; var $resSelecAluno;
 
     function getIdAluno() {
     return $this->idAluno;
     }

     public function numeroAlea($num, $no){
            $d="P";     $res =0;        $f="L#!";
            for($con = 0; $con <= $num; $con ++){               
                $dados = rand(0,100000) + $no;
                $res = $f.$dados.$d.$dados.$no." ";             
            }
            $this -> licenca = $res; 

    }    
    public function verificacaoDaPessoa($con,$bi){
         $res=0;
        try{
                    
                 $se="select *from tbl_pessoa where bi=:bi limit 1";
                 $ex=$con->prepare($se);
                 $ex->bindParam(":bi",$bi,PDO::PARAM_STR);
                if($ex->execute()):
                     $contar=$ex->rowCount();
                     if($contar>0):
                        $this -> resSelecPessoa ="Peaple_exists";
                         echo"<div class='alert alert-success'>This peaple already exists on database!</div>";
                    else:
                        $this -> resSelecPessoa ="Peaple_not_exists";
                    endif;
                endif;                 
        }catch(PDOException $e){$e -> getMessage();}        
           
    }//End function
    public function pesquisarIDPessoaBI($con,$bi){
         $res=0;
        try{
                    
                 $se="select *from tbl_pessoa where bi=:bi limit 1";
                 $ex=$con->prepare($se);
                 $ex->bindParam(":bi",$bi,PDO::PARAM_STR);

                if($ex->execute()):
                     $contar=$ex->rowCount();
                     if($contar >0):
                        //echo " BI PESSOA: ".$bi;
                        //$this -> resSelecPessoa ="Peaple_exists";
                        $array = $ex -> fetchAll(PDO::FETCH_ASSOC);
                        foreach ($array as $fila) {
                            $this -> idPessoa = $fila["id_pessoa"];
                            $this -> bi = $fila["bi"];
                        }                          
                    else:
                        $this -> resSelecPessoa ="Peaple_not_exists";
                    endif;
                       //echo " ID PESSOA: ".$this -> idPessoa;
                endif;    
             
        }catch(PDOException $e){$e -> getMessage();}        
           
    }//End function
    
    function cadastrarAlunoPessoa($nome,$curso,$classe,$turma,$turno,$genero,$data,$telefone,$emissao,$local_emissao,$bi,$arquivo,$arquivo_tmp,$ano,$pai,$mae,$provincia,$municipio,$con){              
            //cadastra a pessoa
         $titulo="aluno"; 
            if($arquivo==""):
            $foto="none.jpg";
            else:
            $foto=$arquivo;
             //mover a foto para a pasta
                    $destino='foto_alunos/'.$arquivo;
                    $arquivo_tmp1=$arquivo_tmp;
                    move_uploaded_file($arquivo_tmp1,$destino);
            endif;
            $res=0;

        try{    
            $ins="insert into tbl_pessoa (nome,genero,data_nascimento,bi,data_emissao,local_emissao,foto,telefone,titulo,pai,mae,provincia,municipio)values(:nome,:genero,:data_nascimento,:bi,:data_emissao,:local_emissao,:foto,:telefone,:titulo,:pai,:mae,:provincia,:municipio)";
           
            $ex1=$con->prepare($ins);
            $ex1->bindParam(":nome",$nome,PDO::PARAM_STR);
            $ex1->bindParam(":genero",$genero,PDO::PARAM_STR);
            $ex1->bindParam(":data_nascimento",$data,PDO::PARAM_STR);
            $ex1->bindParam(":bi",$bi,PDO::PARAM_STR);
            $ex1->bindParam(":data_emissao",$emissao,PDO::PARAM_STR);
            $ex1->bindParam(":local_emissao",$local_emissao,PDO::PARAM_STR);
            $ex1->bindParam(":foto",$foto,PDO::PARAM_STR);
            $ex1->bindParam(":telefone",$telefone,PDO::PARAM_STR);
            $ex1->bindParam(":titulo",$titulo,PDO::PARAM_STR);
            $ex1->bindParam(":pai",$pai,PDO::PARAM_STR);
            $ex1->bindParam(":mae",$mae,PDO::PARAM_STR);
            $ex1->bindParam(":provincia",$provincia,PDO::PARAM_STR);
            $ex1->bindParam(":municipio",$municipio,PDO::PARAM_STR);            
           echo"<div class='alert alert-success'>Info Pessoa: ".$this -> resSelecPessoa." IDPessoa: ".$this->idPessoa."</div>";
            if(($this -> resSelecPessoa =="Peaple_not_exists") && ($this -> idPessoa ==0) ){

                if(!$ex1->execute()):
                    $res="Peaple_NOT_registed";
                elseif($ex1->execute()):
                    $res="Peaple_registed";
                 echo"<div class='alert alert-success'>Pessoa cadastrada com sucesso!</div>";
                endif;
            }
        }catch(PDOException $e){$e -> getMessage();}     
        return $res;
    }//End function

    function selectIDAluno($con,$data,$resSavedPeaple,$bi){           
        $res=0; $id=0;
        //pesquizar id pessoa
        try{
            $pes="select *from tbl_aluno where id_pessoa=:id_pessoa limit 1";
            $ex2=$con->prepare($pes);
            $ex2->bindParam(":id_pessoa",$this->idPessoa,PDO::PARAM_STR);
            if( ($resSavedPeaple =="Peaple_registed") && ($this -> idPessoa >0)){
                if($ex2->execute()):                        
                        $ver=$ex2->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($ver as $value) {                            
                        $this -> idAluno = $value["id_aluno"];
                        return $resp = 1;
                    }
                    echo"<div class='alert alert-success'>Result SELECT pessoa: ".$resSavedPeaple." IDPessoa Captada: ".$this->idPessoa." IDAluno Captada: ".$this -> idAluno."</div>";    
                endif;    
                
            }else{ echo"<div class='alert alert-success'>Result Select pessoa: ".$resSavedPeaple." IDPessoa: ".$this->idPessoa."</div>";}
        }catch(PDOException $e){$e -> getMessage();} 
    }//End function

    function cadastrarAluno($con,$curso,$classe,$turma,$turno,$ano,$bi,$resSavedPeaple){
        $idPessoa = $this -> idPessoa;
        
        $cardeneta="nao"; 
        $res=0;
        try{
            //cadastra nos alunos
            $ins2="insert into tbl_aluno (id_pessoa,id_curso,id_classe,id_turma,id_turno,anolectivo,cardeneta)values(:id_pessoa,:id_curso,:id_classe,:id_turma,:id_turno,:anolectivo,:cardeneta)";
               
            $ex3=$con->prepare($ins2);
            $ex3->bindParam(":id_pessoa",$idPessoa,PDO::PARAM_STR);
            $ex3->bindParam(":id_curso",$curso,PDO::PARAM_STR);
            $ex3->bindParam(":id_classe",$classe,PDO::PARAM_STR);
            $ex3->bindParam(":id_turma",$turma,PDO::PARAM_STR);
            $ex3->bindParam(":id_turno",$turno,PDO::PARAM_STR);
            $ex3->bindParam(":anolectivo",$ano,PDO::PARAM_STR);
          
            $ex3->bindParam(":cardeneta",$cardeneta,PDO::PARAM_STR);
               
            if(($resSavedPeaple =="Peaple_registed") && ($this -> idPessoa >0) && ($this -> idAluno ==0)){
                echo"<div class='alert alert-success'>Cadastrando Aluno! IDPess: ".$idPessoa." RES Aluno: ".$resSavedPeaple." Proce: ".$this -> idAluno." Curso: ".$curso." Classe: ".$classe."- Turma: ".$turma." Turno: ".$turno." Ano: ".$ano." Cader: ".$cardeneta." </div>";
                if(!$ex3->execute()):
                     echo"<div class='alert alert-success'>Regist Class Failed!</div>";
                elseif($ex3->execute()):                    
                    $this -> insertAlu ="Aluno_registed";
                    
                    echo"<div class='alert alert-success'>Aluno cadastrado com sucesso!</div>";
                endif; 
            }else {
                echo "BI ja existe ".$this -> bi;
            } 
        }catch(PDOException $e){$e -> getMessage();} 
        
    }//End function

public function salvar_meses($resp66,$con,$ano){
        if($resp66==0){
            echo 'nao editou estudante';
        }
        elseif($resp66 ==1)
        {
            try
            {
              $sql3="select *from tb_folha";
              
                $resul3=$con->prepare($sql3);
                $resul3->execute(); 
                $pago="nao";
                
                
                while($mostra5=$resul3->fetch(PDO::FETCH_OBJ))
                {
                    try{
                      $mes=$mostra5->tipo_prova." Trimestre";
                    $sql="insert into tbl_pagamento (id_aluno,mes,ano_lectivo,pago)values(:id_aluno,:mes,:ano_lectivo,:pago)";
               
                        $result=$con->prepare($sql);
                        $result->bindParam(":id_aluno",  $this->idAluno,PDO::PARAM_STR);
                        $result->bindParam(":mes",$mes,PDO::PARAM_STR);
                        $result->bindParam(":ano_lectivo",$ano,PDO::PARAM_STR);
                        $result->bindParam(":pago",$pago,PDO::PARAM_STR);
                        
                        $result->execute();
                     
                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }
            
                }
                if($result):
                  $r=1;
                else:
                    $r=0;
               endif;   
            } catch (PDOException $e) {
echo $e->getMessage();
            }
        
        }
        return $r;  
    }
    
    public function edita_historico($resp77,$con,$curso,$classe,$turma,$turno,$ano){
    if($resp77==0):
        echo'nao salvou Meses';
    else:
      try{
       $ins2="insert into tbl_historico_aluno (id_pessoa,id_curso,id_classe,id_turma,id_turno,anolectivo,id_aluno)values(:id_pessoa,:id_curso,:id_classe,:id_turma,:id_turno,:anolectivo,:id_aluno)";
   
    $ex3=$con->prepare($ins2);
    $ex3->bindParam(":id_pessoa",$this->idPessoa,PDO::PARAM_STR);
    $ex3->bindParam(":id_curso",$curso,PDO::PARAM_STR);
    $ex3->bindParam(":id_classe",$classe,PDO::PARAM_STR);
    $ex3->bindParam(":id_turma",$turma,PDO::PARAM_STR);
    $ex3->bindParam(":id_turno",$turno,PDO::PARAM_STR);
    $ex3->bindParam(":anolectivo",$ano,PDO::PARAM_STR);
    $ex3->bindParam(":id_aluno",  $this->idAluno,PDO::PARAM_STR);
    $ex3->execute();  
    if($ex3):
   echo"<div class='alert alert-success'>Registos de aluno actualizado com sucesso!</div>";
    
    else:
        echo 'nao cadastrou no historico';
    endif;
    } catch (PDOException $ex) {
echo $ex->getMessage();
    }    
    endif;
 
}
    
    
}//End class



 /* */
    
?>
