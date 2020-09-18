<script type="text/javascript" src="assets/js/jquery-1.5.2.js"></script>
<script type="text/javascript" >
$(document).ready(function(){
 var a=$("#tti").val();

if(a=="admin")
{
    $(".admin2").hide();
	$("#admin2").hide();
	$("#admin2c").hide();
}
else
{
 $(".admin").hide();
 $("#admin").hide();
  $("#adminc").hide();
  $("#adminb").hide();
}

});
</script>

<div id="wrapper">
        <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="home.php">Okussoleka</a>
            </div>

            <div class="header-right">

                <a href="my_profile.php" class="btn btn-info" ><b>Meu perfil</b></a>
                <a href="about.php" class="btn btn-info" ><b>Sobre </b><i class="fa fa-exclamation-circle "></i></a>
                <a href="logout.php" class="btn btn-danger" title="Sair"><b>Sair </b></a>

            </div>
        </nav>
        <!-- /. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    <li>
                        <div class="user-img-div" >
                            <img src="../pautas/fotos_usuarios/<?php echo $foto;?>" class="img-thumbnail"/>

                            <div >
						
                              <span class="text-center"style="color:#fff; font-weight:bold;"><?php echo $nome;?> </span>
							<form name="ola">
							<input type="hidden" id="tti" value="<?php $titulo=$_SESSION['tituloS']; echo $titulo;?>"/>
								</form>
                            <br />
                              
                            </div>
                        </div>

                    </li>


                   <li>
                        <a href="home.php?p=home_s" class="<?php if(isset($_GET['p'])){if($_GET['p']=="home_s"){echo "active-menu";}}?>"><i class="fa fa-home "></i>HOME</a>
                    </li>
               
                        <li class="<?php if(isset($_GET['p'])){if(($_GET['p']=="pupilo_s")||($_GET['p']=="view_s")||($_GET['p']=="pupilo2_s")){echo "active";}}?>">
                        <a  href="#" ><i class="fa fa-user"></i>ALUNOS <span class="fa arrow"></span></a>
                         <ul class="nav nav-second-level">
                       
                            
                         <li>
                                <a href="view_pupilo.php?p=view_s" class="<?php if(isset($_GET['p'])){if($_GET['p']=="view_s"){echo "selected";}}?>"><i class="fa fa-eye "></i>Dados</a>
                            </li>
                            
                        </ul>
                    </li>
                    
                     <li class="<?php if(isset($_GET['p'])){if(($_GET['p']=="cadUniforme_s")){echo "active";}}?>">
                        <a  href="#" ><i class="fa fa-th"></i>VENDAS <span class="fa arrow"></span></a>
                         <ul class="nav nav-second-level">
                       
                            
                         <li>
                                <a href="cadUniforme.php?p=cadUniforme_s" class="<?php if(isset($_GET['p'])){if($_GET['p']=="cadUniforme_s"){echo "selected";}}?>"><i class="fa fa-check "></i>Uniforme</a>
                            </li>
                            
                        </ul>
                    </li>
                    
                        
		
                    <li id="admin2c" class="<?php if(isset($_GET['p'])){if(($_GET['p']=="count_s")||($_GET['p']=="xtrat_s")||($_GET['p']=="comp_s")){echo "active";}}?>">
                        <a href="#"><i class="fa fa-money "></i>PAGAMENTO<span class="fa arrow"></span></a>
                         <ul class="nav nav-second-level">
                           
                             <li  class='sdp'>
                                <a href="count_pupilo.php?p=count_s" class="<?php if(isset($_GET['p'])){if($_GET['p']=="count_s"){echo "selected";}}?>"><i class="fa fa-usd"></i>Efectuar pagamento</a>
                            </li>
                             <li  class='sd'>
                                 <a href="comparticipacao.php?p=comp_s" class="<?php if(isset($_GET['p'])){if($_GET['p']=="comp_s"){echo "selected";}}?>"><i class="fa fa-group"></i>Modalidade</a>
                            </li>
                             <li  class='sd'>
                                <a href="xtrato.php?p=xtrat_s" class="<?php if(isset($_GET['p'])){if($_GET['p']=="xtrat_s"){echo "selected";}}?>"><i class="fa fa-th"></i>Levantar Extrato</a>
                            </li>

                        </ul>
                    </li>
                   
                   <li id="adminb" class="<?php if(isset($_GET['p'])){if(($_GET['p']=="efect_s")||($_GET['p']=="pendent_s")||($_GET['p']=="count2_s")||($_GET['p']=="efect2_s")||($_GET['p']=="efect3_s")){echo "active";}}?>">
                        <a href="#"><i class="fa fa-barcode "></i>LISTA NOMINAL<span class="fa arrow"></span></a>
                         <ul class="nav nav-second-level">
                           
                             <li  class='sdp'>
			<a href="pag_efect.php?p=efect_s" class="<?php if(isset($_GET['p'])){if($_GET['p']=="efect_s"){echo "selected";}}?>"><i class="fa fa-check"></i>Pagamentos Propinas</a>
                                
                            </li>
                            
                                  <li  class='sdp'>
			<a href="pag_efect2.php?p=efect2_s" class="<?php if(isset($_GET['p'])){if($_GET['p']=="efect2_s"){echo "selected";}}?>"><i class="fa fa-paypal"></i>Folhas de Prova</a>
                                
                            </li>
                            
                              <li  class='sdp'>
			<a href="pag_efect3.php?p=efect3_s" class="<?php if(isset($_GET['p'])){if($_GET['p']=="efect3_s"){echo "selected";}}?>"><i class="fa fa-group"></i>Comparticipação</a>
                                
                            </li>
                            
                            <li  class='sdp'>
                                <a href="count_pupilo2.php?p=count2_s" class="<?php if(isset($_GET['p'])){if($_GET['p']=="count2_s"){echo "selected";}}?>"><i class="fa fa-usd"></i>Corrigir Pagamento </a>
                                
                            </li>
                            
                        </ul>
                    </li>
                    
                      <li id="adminc" class="<?php if(isset($_GET['p'])){if(($_GET['p']=="an_s")||($_GET['p']=="me_s")||($_GET['p']=="ma_s")||($_GET['p']=="ge_s")||($_GET['p']=="dec_s")||($_GET['p']=="cer_s")||($_GET['p']=="fol_s")||($_GET['p']=="compa_s")||($_GET['p']=="uni_s")||($_GET['p']=="transpo_s")||($_GET['p']=="provaEx_s")||($_GET['p']=="estag_s")){echo "active";}}?>">
                        <a href="#"><i class="fa fa-qrcode "></i>BALANÇO<span class="fa arrow"></span></a>
                         <ul class="nav nav-second-level">
                           
                             <li  class='sdp'>
                                <a href="year.php?p=an_s" class="<?php if(isset($_GET['p'])){if($_GET['p']=="an_s"){echo "selected";}}?>"><i class="fa fa-compass"></i>Propina Anual </a>
                            </li>
                             <li  class='sd'>
                                <a href="mouth.php?p=me_s" class="<?php if(isset($_GET['p'])){if($_GET['p']=="me_s"){echo "selected";}}?>"><i class="fa fa-dribbble"></i>Propina Mensal</a>
                            </li>
                             <li  class='sd'>
                                <a href="baMa.php?p=ma_s" class="<?php if(isset($_GET['p'])){if($_GET['p']=="ma_s"){echo "selected";}}?>"><i class="fa fa-dribbble"></i>Matrícula</a>
                            </li>
                            <li  class='sd'>
                                <a href="declaracaoBA.php?p=dec_s" class="<?php if(isset($_GET['p'])){if($_GET['p']=="dec_s"){echo "selected";}}?>"><i class="fa fa-dribbble"></i>Declaração</a>
                            </li>
                             <li  class='sd'>
                                 <a href="certificadoBA.php?p=cer_s" class="<?php if(isset($_GET['p'])){if($_GET['p']=="cer_s"){echo "selected";}}?>"><i class="fa fa-dribbble"></i>Certificados</a>
                            </li>
                             <li  class='sd'>
                                 <a href="folhaBA.php?p=fol_s" class="<?php if(isset($_GET['p'])){if($_GET['p']=="fol_s"){echo "selected";}}?>"><i class="fa fa-dribbble"></i>Folhas</a>
                            </li>
                            
                            <li  class='sd'>
                                 <a href="transporteBA.php?p=transpo_s" class="<?php if(isset($_GET['p'])){if($_GET['p']=="transpo_s"){echo "selected";}}?>"><i class="fa fa-dribbble"></i>Transporte</a>
                            </li>
                            
                              <li  class='sd'>
                                  <a href="comparticipacaoBA.php?p=compa_s" class="<?php if(isset($_GET['p'])){if($_GET['p']=="compa_s"){echo "selected";}}?>"><i class="fa fa-dribbble"></i>Comparticipação</a>
                            </li>
                            
                            
                            <li  class='sd'>
                                 <a href="provaExameBA.php?p=provaEx_s" class="<?php if(isset($_GET['p'])){if($_GET['p']=="provaEx_s"){echo "selected";}}?>"><i class="fa fa-dribbble"></i>Prova/Exame</a>
                            </li>
                            
                              <li  class='sd'>
                                  <a href="estagioBA.php?p=estag_s" class="<?php if(isset($_GET['p'])){if($_GET['p']=="estag_s"){echo "selected";}}?>"><i class="fa fa-dribbble"></i>Estágio</a>
                            </li>
                            
                             <li  class='sd'>
                                  <a href="UniformesBA.php?p=uni_s" class="<?php if(isset($_GET['p'])){if($_GET['p']=="uni_s"){echo "selected";}}?>"><i class="fa fa-dribbble"></i>Uniformes</a>
                            </li>
                            
                            <li  class='sd'>
                                <a href="geral.php?p=ge_s" class="<?php if(isset($_GET['p'])){if($_GET['p']=="ge_s"){echo "selected";}}?>"><i class="fa fa-dribbble"></i>Geral</a>
                            </li>

                        </ul>
                    </li>
                    
                   
                    
                   
                 
                </ul>

            </div>

        </nav>
