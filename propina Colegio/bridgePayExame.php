<?php
     session_start();

    require_once("conn2.php");  
    include("savingExame.php");
    include("savingEstagio.php");
    include("numberFactu.php");
    $_SESSION['nomeS'];
$_SESSION['tituloS'];
$_SESSION['fotoS'];
$_SESSION['processo444'];

        $save = new PaymentsService();
        $estag = new SaveEstagio();
        $fact = new Factura();

        $resposta=0;
               $preco = addslashes(htmlspecialchars($_POST['preco']));
               $cliente = addslashes(htmlspecialchars($_POST['cliente']));
               $categoria = addslashes(htmlspecialchars(isset($_POST['categoria'])? $_POST['categoria']:''));
               $numTalao = addslashes(htmlspecialchars($_POST['numerotalao']));
               $dataDeposito = addslashes(htmlspecialchars($_POST['dataDeposito']));
               $anoLectivo = addslashes(htmlspecialchars($_POST['anoLectivo']));

		   if((isset($_POST['sv'])) && ($_POST['sv'] =="Concluir") ){		   	  

		   	   $fact-> setConnection($con2); 
		   	   $fact-> selectFactura();
		   	   $fact-> selectFactura1();
               $save-> setTicketNumber($numTalao);
               $save-> dataDeposito = $dataDeposito;
		   	   $save-> setConnection($con2);
		   	   $save-> client = $cliente;
		   	   $save-> priceSell = $preco; 
		   	   $save-> type = $categoria; 
		   	   $save-> category = $categoria;
		   	   
		   	//echo("<script language='javascript'> parent.window.location.href='count_pupilo.php',location.target='blank'</script>");
		   	//header('window-target:blank');
		   	//header('Location:venderUniforme.php');
		   	
    		   	if(isset($_POST['disciplina'])){
    		   	  	$_SESSION['IDDISCIPLINA'] = $_POST['disciplina'];
                        $save-> setNumberFatura($fact-> numberF);
                    	$save-> worker = $_SESSION['nomeS'];
                    	$save-> setIdClass($_SESSION['processo444']);
                    	$save-> year = $anoLectivo;
                    	$save-> selectClass();
                
                    	$save-> relatorio();
                }else{ echo("Vazio");}
                
		   }elseif((isset($_POST['payEstagio'])) && ($_POST['payEstagio'] =="Concluir") ){
                $fact-> setConnection($con2); 
                $fact-> selectFactura();
                $fact-> selectFactura1();
                $estag-> setConnection($con2);
                $estag-> setNumeroFatura($fact-> numberF);
                $estag-> client = $cliente;
                $estag-> priceSell = $preco; 

                $estag-> category ="Estágio";
                $estag-> type ="Estágio";
                $estag-> worker = $_SESSION['nomeS'];
                $estag-> state = "ON";
                $estag-> setIdClass($_SESSION['processo444']);
                $estag-> setTalaoNumero($numTalao);
                $estag-> dataTalao = $dataDeposito;
                $estag-> year = $anoLectivo;
                $estag-> selectClass();                
                $resp = $estag-> selectPayment();
                    $estag-> savePayEstagio();
                    if($estag-> getResponseSave() ==1){
                        $estag-> relatorio();
                    }else{
                        echo("<script>alert('Estágio já pago!')</script>");
                        echo("<script language='javascript'> parent.window.location.href='count_pupilo.php',location.target='blank'</script>");
                       
                    }

           }//





		
   ?>
   


