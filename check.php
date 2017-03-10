<?php
 
  echo $_SERVER['SERVER_NAME'];
  
   echo "<html><br/><br/>";
  $Anonymous = array( 
  'HTTP_FORWARDED',  
  'HTTP_X_FORWARDED_FOR',  
  'HTTP_CLIENT_IP');
 foreach($Anonymous as $x){
if (isset($_SERVER[$x])) die("Anonymous");
}
$ports = array(8080,80,81,1080,6588,8000,3128,553,554,4480);
foreach($ports as $port) {
if (@fsockopen($_SERVER['REMOTE_ADDR'], $port, $errno, $errstr, 30)) {
die("Anonymous");
    }
}

echo "</html>";


?>       