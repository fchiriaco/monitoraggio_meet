<?php
$dirsito = realpath(__DIR__);
include($dirsito. "/" . "configlocale.php");
/* echo $_SERVER['PHP_SELF'];
echo "<br>";
echo $_SERVER['SERVER_NAME'];
echo "<br>";
echo $_SERVER['HTTP_HOST'];
echo "<br>";
echo $_SERVER['HTTP_REFERER'];
echo "<br>";
$_SERVER['HTTPS'];
echo "<br>";
echo $_SERVER['SCRIPT_NAME'];
*/

$dirsitoscript = "";
if($_SERVER['HTTPS'])
	$dirsitoscript = "https://";
else
	$dirsitoscript = "http://";
$dirsitoscript .= $_SERVER['SERVER_NAME'] .  dirname($_SERVER["SCRIPT_NAME"]); 

echo $dirsitoscript;
?>
