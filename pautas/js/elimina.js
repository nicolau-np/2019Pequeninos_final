$(document).ready(function(){
var b=$("#selection59").val();
    if(b=="Professor Normal")
    {
     $(".aas").hide();   
    }
    else
    {
        $(".aas").show();
    }

$("#selection59").change(function(){
    var a=$("#selection59").val();
    if(a=="Professor Normal")
    {
     $(".aas").hide();   
    }
    else
    {
        $(".aas").show();
    }
}); 
});
