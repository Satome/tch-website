<?php
$inactive = 6000;  
if(isset($_SESSION['start']))
{
	$session_life = time() - $_SESSION['start'];
	if($session_life > $inactive)
	{
		header('Location: /Logout');
	}
}
$_SESSION['start'] = time();
?>
