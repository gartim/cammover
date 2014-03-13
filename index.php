<!DOCTYPE html>
<html>
<body>
<?php

session_start();
if (!isset($_SESSION["position"])) {

	$_SESSION["position"]=5976;
 }

switch ($_GET['direction'])
{
     case c:
	#`$string="echo \"go Center [position] [5976] \"" . '>> /tmp/myfile.txt';
	#`shell_exec("$string");
	$_SESSION["position"] = 5976;
	shell_exec("sudo /usr/local/bin/maestro_set -t 5976");
     	break;
     case L:
	#$string="echo \"go W-Left [position] [8000] \"" . '>> /tmp/myfile.txt';
	#shell_exec("$string");
	$_SESSION["position"] = 8000;
	shell_exec("sudo /usr/local/bin/maestro_set -t 8000");
     	break;
     case R:
	#$string="echo \"go W-Right [position] [3968] \"" . '>> /tmp/myfile.txt';
	#shell_exec("$string");
	$_SESSION["position"] = 3968;
	shell_exec("sudo /usr/local/bin/maestro_set -t 3968");
     	break;
     case l:
	#$tmp=shell_exec('sudo /usr/local/bin/maestro_read');
	#$position=trim($tmp);
	$position = $_SESSION["position"];
	$position_left=$position+100;
	$_SESSION["position"] = $position_left;
	$string="echo \"go left [position/position_left] [$position/$position_left] \"" . '>> /tmp/myfile.txt';
	shell_exec("$string");
	shell_exec("sudo /usr/local/bin/maestro_set -t $position_left");
     	break;
     case r:
	#$tmp=shell_exec('sudo /usr/local/bin/maestro_read');
	#$position=trim($tmp);
	$position = $_SESSION["position"];
	$position_right=$position-100;
	$_SESSION["position"] = $position_right;
	$string="echo \"go right [position/position_right] [$position/$position_right] \"" . '>> /tmp/myfile.txt';
	shell_exec("$string");
	shell_exec("sudo /usr/local/bin/maestro_set -t $position_right");
     	break;
}  
echo <<<HTML
<head>
  <style type="text/css">
      body { background: white; color: #666f85; text-align: center }
      img  { border: none }
  </style>
	<!--
  <meta http-equiv="refresh" content="8;URL=http://localhost/index.php?direction=n" />
  <meta http-equiv="expires" content="0" /> 
  <title>Powered by lighttpd</title>
  <link rel="shortcut icon" href="favicon.ico" />
  <link rel="icon" href="favicon.ico" />
  <style type="text/css">
      body { background: white; color: #666f85; text-align: center }
      img  { border: none }
  </style>
</head>
<body>
    <hr> <center>Cam Tracker</center> </hr>
    <img src="http://localhost/video"><br />
    <img src="http://localhost:8081"><br />
	-->
    <p>
    <img src="http://localhost/video"><br />
    </p>
    <a href=?direction=L>&lt;&lt;</a>   &nbsp; &nbsp; <a href=?direction=l>&lt;</a> <a href=?direction=c>&#94;</a> <a href=?direction=r>&gt;</a>   &nbsp; &nbsp; <a href=?direction=R>&gt;&gt;</a>
</body>
</html>
HTML;
?>
</body>
</html> 
