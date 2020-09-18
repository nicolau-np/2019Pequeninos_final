<?php
ob_start();
session_start();
class logar{
    
    public function entra($nome,$senha,$con){
      		$senha=md5($senha);
        try{		
		      $se="select *from view_logar where nome=:nome and senha=:senha";
		      $x=$con->prepare($se);
		      $x->bindParam(":nome",$nome,PDO::PARAM_STR);
		      $x->bindParam(":senha",$senha,PDO::PARAM_STR);
		      $x->execute();
		      $ver=$x->fetch(PDO::FETCH_OBJ);
		      $cont=$x->rowCount();
		      if($cont==0):
		      print("<div class='alert alert-danger'>Por favor, verifique os dados do login!</div>");
		      else:
		      if($ver->estado=="OFF"):
		      print("<div class='alert alert-info'>Usuário não permitido, contacte o Administrador!</div>");
		      else:
		      $_SESSION['nomeMRX']=$nome;
		      $_SESSION['senhaMRX']=$senha;
		      $_SESSION['fotoMRX']=$ver->foto;
		      $_SESSION['tituloMRX']=$ver->titulo;
		      $_SESSION['id_userMRX']=$ver->id_user;
		      $_SESSION['id_pessoaMRX']=$ver->id_pessoa;
		      print("<div class='alert alert-success'>Login feito com sucesso, a carregar...</div>");
		      header("refresh:2, dashboard.php");exit;
		      
		      endif;
		      endif;
		}catch(PDOException $e){ $e->getMessage(); echo '<script>alert("Erro ao fazer login!")</script>'; 
		      echo '<script>window.location="../index.php"</script>';  
		}      
        
        
    }
}

?>