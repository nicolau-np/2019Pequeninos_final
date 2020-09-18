$(document).ready(function(){
   var a=$("#titulo").val();
  if(a=="Administrador")
  {
   //administrador 
    $("#director67").hide();
   $("#director1").hide();
   $("#directorProfessor1").hide();
   $("#directorProfessor2").hide();
    $("#directorProfessor4").hide();
     $("#directorProfessor5").hide();
    
   
  }
  else if(a=="Usuário Normal")
  {
    //usuario Normal
    
     $("#usuarioAdmin5").hide();
     $("#usuarioAdmin8").hide();
	 $("#director67").hide();
     $("#director1").hide();
   $("#directorProfessor1").hide();
   $("#directorProfessor2").hide();
   $("#directorProfessor4").hide();
    $("#directorProfessor5").hide();
   $("#Admin1").hide();
   $("#Admin2").hide();
  }
  else if(a=="Professor Director")
   {
    //professor director
   $("#usuarioAdmin13").hide();
   $("#usuarioAdmin14").hide();
    $("#usuarioAdmin1").hide();
   $("#usuarioAdmin2").hide();
   $("#Admin1").hide();
   $("#Admin2").hide();
   $("#usuarioAdmin5").hide();
   $("#usuarioAdmin6").hide();
   $("#usuarioAdmin7").hide();
   $("#usuarioAdmin8").hide();
   $("#usuarioAdmin9").hide();
   $("#usuarioAdmin10").hide();
   
  }
  else if(a=="Professor Normal")
   {
    //professor normal
       $("#usuarioAdmin13").hide();
   $("#usuarioAdmin14").hide();
	 $("#director67").hide();
        $("#usuarioAdmin1").hide();
   $("#usuarioAdmin2").hide();
   $("#Admin1").hide();
   $("#Admin2").hide();
   $("#director1").hide();
     $("#usuarioAdmin5").hide();
        $("#usuarioAdmin6").hide();
   $("#usuarioAdmin7").hide();
   $("#usuarioAdmin8").hide();
   $("#usuarioAdmin9").hide();
   $("#usuarioAdmin10").hide();
  
  }
  else if(a=="Usuário Normal 2"){
   $("#usuarioAdmin13").hide();
   $("#usuarioAdmin14").hide();
   $("#director1").hide();
   $("#directorProfessor1").hide();
   $("#directorProfessor2").hide();
    $("#directorProfessor4").hide();
     $("#directorProfessor5").hide();
      	 $("#director67").hide();
     /**   $("#usuarioAdmin1").show();*/
   $("#usuarioAdmin2").hide();
   $("#Admin1").hide();
   $("#Admin2").hide();
   $("#director1").hide();
     $("#usuarioAdmin5").hide();
        $("#usuarioAdmin6").hide();
   $("#usuarioAdmin7").hide();
   $("#usuarioAdmin8").hide();
   $("#usuarioAdmin9").hide();
   $("#usuarioAdmin10").hide();
  
  }
 
  
  
});
