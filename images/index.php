<?php
if(isset($_GET['image']))
{
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		foreach (glob("./images/" . $_GET['image'] . ".*") as $filename) 
		{
			$filetype = finfo_file($finfo, $filename);
			finfo_close($finfo);
			$fp = fopen($filename, 'rb');
			header("Content-Type: " . $filetype);
			header("Content-Length: " . filesize($filename));
			header ("Connection: close");
			ob_end_clean();
			fpassthru($fp);
		}
}
elseif(isset($_GET['character_icon']))
{
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		foreach (glob("./icons/characters/" . $_GET['character_icon'] . ".*") as $filename) 
		{
			$filetype = finfo_file($finfo, $filename);
			finfo_close($finfo);
			$fp = fopen($filename, 'rb');
			header("Content-Type: " . $filetype);
			header("Content-Length: " . filesize($filename));
			header ("Connection: close");
			ob_end_clean();
			fpassthru($fp);
		}
}
elseif(isset($_GET['aura_icon']))
{
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		foreach (glob("./icons/auras/" . $_GET['aura_icon'] . ".*") as $filename) 
		{
			$filetype = finfo_file($finfo, $filename);
			finfo_close($finfo);
			$fp = fopen($filename, 'rb');
			header("Content-Type: " . $filetype);
			header("Content-Length: " . filesize($filename));
			header ("Connection: close");
			ob_end_clean();
			fpassthru($fp);
		}
}
elseif(isset($_GET['perk_icon']))
{
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		foreach (glob("./icons/perks/" . $_GET['perk_icon'] . ".*") as $filename) 
		{
			$filetype = finfo_file($finfo, $filename);
			finfo_close($finfo);
			$fp = fopen($filename, 'rb');
			header("Content-Type: " . $filetype);
			header("Content-Length: " . filesize($filename));
			header ("Connection: close");
			ob_end_clean();
			fpassthru($fp);
		}
}
elseif(isset($_GET['shout_icon']))
{
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		foreach (glob("./icons/shouts/" . $_GET['shout_icon'] . ".*") as $filename) 
		{
			$filetype = finfo_file($finfo, $filename);
			finfo_close($finfo);
			$fp = fopen($filename, 'rb');
			header("Content-Type: " . $filetype);
			header("Content-Length: " . filesize($filename));
			header ("Connection: close");
			ob_end_clean();
			fpassthru($fp);
		}
}
elseif(isset($_GET['attribute_icon']))
{
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		foreach (glob("./icons/attributes/" . $_GET['attribute_icon'] . ".*") as $filename) 
		{
			$filetype = finfo_file($finfo, $filename);
			finfo_close($finfo);
			$fp = fopen($filename, 'rb');
			header("Content-Type: " . $filetype);
			header("Content-Length: " . filesize($filename));
			header ("Connection: close");
			ob_end_clean();
			fpassthru($fp);
		}
}
else
header("HTTP/1.0 404 Not Found");
die();
?>