<?php

class salvar_professor{
    var $idPess; var $idUser; var $idProfess;

    public function salvarDirector($curso,$classe,$turma,$turno,$ano,$con)
    {       
        $idProfess = $this -> idProfess;
            try{
                
                if($idProfess > 0):    
                     $in9="insert into tbl_diretores(id_professor,id_curso,id_classe,id_turma,id_turno,anolectivo)values(:id_professor,:id_curso,:id_classe,:id_turma,:id_turno,:anolectivo)";
                     $ex10=$con->prepare($in9);                     
                     $ex10->bindParam(":id_professor",$idProfess,PDO::PARAM_STR);
                     $ex10->bindParam(":id_curso",$curso,PDO::PARAM_STR);
                     $ex10->bindParam(":id_classe",$classe,PDO::PARAM_STR);
                     $ex10->bindParam(":id_turma",$turma,PDO::PARAM_STR);
                     $ex10->bindParam(":id_turno",$turno,PDO::PARAM_STR);
                     $ex10->bindParam(":anolectivo",$ano,PDO::PARAM_STR);
                     $ex10->execute();
                     if(!$ex10):
                     echo("<div class='alert alert-danger' style='color:red;'>Falha ao cadastrar!</div>");
                     else:
                     echo("<div class='alert alert-success'>Cadastro feito com sucesso!</div>");
                     endif;
                endif;
                     
           }catch(PDOException $e){ $e -> getMessage();}    
        
    }//End function
        
        
        //professor
    public function selectProfessor($agente,$con)
    {
            $res=0;
        try{      
            $sele="select *from tbl_professor where nAgente=:agente";
            $ex=$con->prepare($sele);
            $ex->bindParam(":agente",$agente,PDO::PARAM_STR);
            $ex->execute();    
            $contar=$ex->rowCount();
            if($contar>0):                
             print("<div class='alert alert-danger'>Numero de agente ja existente!</div>"); 
            elseif($contar ==0):
                $res ="NG_NOT_Exists";                         
            endif;   
        }catch(PDOException $e){ $e -> getMessage();} 
            
            return $res;

    }//End function
    public function selectProfessorID($con)
    {       $idPessoa=$this -> idPess; 
            $idProfess=0;
        try{      
            $se9="select *from tbl_professor where id_pessoa=:id";
            $ex9=$con->prepare($se9);
            $ex9->bindParam(":id",$idPessoa,PDO::PARAM_STR);
            $ex9->execute();
            $ver3=$ex9->fetch(PDO::FETCH_OBJ);
            $idProfess = $ver3->id_professor;    
            $this -> idProfess = $idProfess;
        }catch(PDOException $e){ $e -> getMessage();}     
    }//End function
    function salvarPessoa($con,$resNAGen,$nome,$agente,$data,$telefone,$bi,$data_emissao,$local_emissao,$genero,$titulo,$arquivo,$arquivo_tmp,$pai,$mae,$provincia,$municipio,$categoria_estudo){
             $res=0;

             //cadastra pessoa
                 if($arquivo==""):
                $foto="none.jpg";
                else:
                $foto=$arquivo;
                endif;
        try{        
            if($resNAGen =="NG_NOT_Exists"){ 
                
                $ins="insert into tbl_pessoa (nome,genero,data_nascimento,bi,data_emissao,local_emissao,foto,telefone,titulo,pai,mae,provincia,municipio)values(:nome,:genero,:data_nascimento,:bi,:data_emissao,:local_emissao,:foto,:telefone,:titulo,:pai,:mae,:provincia,:municipio)";
       
                $ex1=$con->prepare($ins);
                $ex1->bindParam(":nome",$nome,PDO::PARAM_STR);
                $ex1->bindParam(":genero",$genero,PDO::PARAM_STR);
                $ex1->bindParam(":data_nascimento",$data,PDO::PARAM_STR);
                $ex1->bindParam(":bi",$bi,PDO::PARAM_STR);
                $ex1->bindParam(":data_emissao",$data_emissao,PDO::PARAM_STR);
                $ex1->bindParam(":local_emissao",$local_emissao,PDO::PARAM_STR);
                $ex1->bindParam(":foto",$foto,PDO::PARAM_STR);
                $ex1->bindParam(":telefone",$telefone,PDO::PARAM_STR);
                $ex1->bindParam(":titulo",$titulo,PDO::PARAM_STR);
                  $ex1->bindParam(":pai",$pai,PDO::PARAM_STR);
                $ex1->bindParam(":mae",$mae,PDO::PARAM_STR);
                $ex1->bindParam(":provincia",$provincia,PDO::PARAM_STR);
                $ex1->bindParam(":municipio",$municipio,PDO::PARAM_STR);
                $ex1->execute();
                if(!$ex1):
                echo("<div class='alert alert-danger' style='color:red;'>Falha ao cadastrar!</div>");
                else:
                        //mover a foto para a pasta
                        $res="pessoa_inserted";
                    $destino='fotos_professores/'.$arquivo;
                    $arquivo_tmp1=$arquivo_tmp;
                    move_uploaded_file($arquivo_tmp1,$destino);
                endif;
                
            }  
        }catch(PDOException $e){ $e -> getMessage();}     
        return $res;
    }//End function
    function consultaPessoa($con,$resPess,$nome,$data){    
            //pesquisar id pessoa
        $id=0;
        
        try{
            if($resPess =="pessoa_inserted"){
                $pes="select *from tbl_pessoa where nome=:nome and data_nascimento=:data";
                $ex2=$con->prepare($pes);
                $ex2->bindParam(":nome",$nome,PDO::PARAM_STR);
                $ex2->bindParam(":data",$data,PDO::PARAM_STR);
                $ex2->execute();
                $ver=$ex2->fetchAll(PDO::FETCH_ASSOC);
                $id=10;
                foreach ($ver as $fila) {
                    $id=  $fila["id_pessoa"];
                    $this -> idPess = $id; 
                }
            }
        
        }catch(PDOException $e){ $e -> getMessage();}   
    }//End function

    function salvarProfessor($con,$agente,$titulo,$categoria_estudo,$resPess){
        $id_pessoa=$this -> idPess;    
        //cadastra nos professores

         $res=0;

        try{ 
            if($resPess =="pessoa_inserted"){
                 $ins2="insert into tbl_professor (id_pessoa,nAgente,titulo,categoria_estudo)values(:id_pessoa,:agente,:titulo,:categoria_estudo)";      
                $ex3=$con->prepare($ins2);
                $ex3->bindParam(":id_pessoa",$id_pessoa,PDO::PARAM_STR);
                $ex3->bindParam(":agente",$agente,PDO::PARAM_STR);
                $ex3->bindParam(":titulo",$titulo,PDO::PARAM_STR);
                $ex3->bindParam(":categoria_estudo",$categoria_estudo,PDO::PARAM_STR);
                $ex3->execute();
               
                if(!$ex3):
                echo("<div class='alert alert-danger' style='color:red;'>Falha ao cadastrar!</div>");
                else:
                    $res="inserted_Prof";
                endif;
            }        
        }catch(PDOException $e){ $e -> getMessage();} 
            return $res;
    }//End function  
    function salvarUSUARIO($con,$titulo,$resProf){  
        $idPess = $this -> idPess;
        //cadastra usuario
        try{

            if($resProf =="inserted_Prof"){
                $res=0;
                $agora="NOW what";
                $estado="ON";
                $in5="insert into tbl_user(id_pessoa,titulo,estado,agora) values(:id_pessoa,:titulo,:estado,:AGORA)";
                     $ex5=$con->prepare($in5);
                     $ex5->bindParam(":id_pessoa",$idPess,PDO::PARAM_STR);
                     $ex5->bindParam(":titulo",$titulo,PDO::PARAM_STR);
                     $ex5->bindParam(":estado",$estado,PDO::PARAM_STR);
                     $ex5->bindParam(":AGORA",$agora,PDO::PARAM_STR); 
                                  
                     if(!$ex5->execute()):
                        echo("<div class='alert alert-danger' style='color:red;'>Falha ao cadastrar!</div>");                          
                     else:
                        $res ="User_inserted";
                       // echo " resProf: ".$resProf." IDPEss: ".$idPess." ResU: ".$res." titu: ".$titulo." Esta: ".$estado;            
                     endif; 
            }
        }catch(PDOException $e){ $e -> getMessage();}   

        return $res;
    }//End function
    function consultaUsuario($con,$resU){
        //Consulting ID User through(over) the ID peaple 
        try{
            if($resU =="User_inserted"){
                $idPess=$this -> idPess;   
                 $se4="select *from tbl_user where id_pessoa=:id";
                 $ex4=$con->prepare($se4);
                 $ex4->bindParam(":id",$idPess,PDO::PARAM_STR);
                 $ex4->execute();
                 $ver2=$ex4->fetchAll(PDO::FETCH_ASSOC);
                 foreach ($ver2 as $value) {
                     $idUser = $value["id_user"];
                     $this -> idUser = $idUser;
                     //echo " USER_Id: ".$idUser;
                 }
               
            }  
        }catch(PDOException $e){ $e -> getMessage();}   
    }//End function
    function salvarSenhas($con,$telefone,$resU){
            $idUser = $this -> idUser;
             //cadastrar senha
            $resSenha=0; 
        try{    
             $palavraMD5=md5($telefone);
            if($resU =="User_inserted"){
                 $in5="insert into tbl_senhas(id_user,senha) values(:id_user,:senha)";
                 $ex6=$con->prepare($in5);
                 $ex6->bindParam(":id_user",$idUser,PDO::PARAM_STR);
                 $ex6->bindParam(":senha",$palavraMD5,PDO::PARAM_STR);
                 $ex6->execute();
                 if(!$ex6):
                     echo("<div class='alert alert-danger' style='color:red;'>Falha ao cadastrar!</div>");
                 else:
                    $resSenha ="PWDs_inserted";
                     //echo " ResPWS: ".$resSenha." IDUser: ".$idUser." Tele: ".$telefone." PASSMD5: ".$palavraMD5;
                     echo("<div class='alert alert-success'>Cadastro feito com sucesso!</div>");
                 endif;                
            }
        }catch(PDOException $e){ $e -> getMessage();}    
        return $resSenha;    
    }//End function
                


}//End Class

    
    
 
?>