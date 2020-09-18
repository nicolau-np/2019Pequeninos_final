
<?php 

try
{
$con2=new PDO('mysql:host=localhost;dbname=_pp','root','');
$con2->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
	echo'ERRo'.$e->getMessage();
}



?>
