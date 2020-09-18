
<?php 

try
{
$con=new PDO('mysql:host=localhost;dbname=_pp','root','');
$con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
	echo'ERRo'.$e->getMessage();
}



?>
