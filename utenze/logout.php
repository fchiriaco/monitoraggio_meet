<?php 
session_start();
include("configlocale.php");
session_destroy();
header("location: {$dirsitoscript}index.php");
?>