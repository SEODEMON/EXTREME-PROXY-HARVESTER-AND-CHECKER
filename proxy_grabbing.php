<!DOCTYPE html>
<html lang="en">
<head>
<title>STAGE 1 - NOW GRABBING PROXIES - EXTREME PROXY HARVESTER AND CHECKER - ANONYMOUS PROXY HARVESTER AND CHECKER ALL IN ONE BY JEFF CHILDERS Chesapeake Virginia</title>
<meta name="description" content="STAGE 1 - NOW GRABBING PROXIES, EXTREME PROXY HARVESTER AND CHECKER - ANONYMOUS PROXY HARVESTER AND CHECKER ALL IN ONE BY PHP NINJA JEFF CHILDERS Chesapeake Virginia">
<meta name="author" content="Troy Jeffrey Childers Chesapeake Virginia 757-266-9111">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body> 
<h1>STAGE 1 - NOW GRABBING PROXIES</h1>           
<?php
// EXTREME PROXY HARVESTER AND CHECKER
// CREATED WITH CURL AND PHP
// BY PHP NINJA JEFF CHILDERS


//STAGE 1 PROXY GRABBING


//Start
 

//Settings
error_reporting(0);
ini_set('max_execution_time', 259200);
set_time_limit(0);
ob_implicit_flush(true);
//All Proxies Saved File
$leeched_proxies = "leeched/leeched_proxies.txt";  
//All Good Proxies Are Saved Here 
$success = "goodproxies/success.txt"; 
//Proxy Source URLS
$proxy_sources_file ='sources/sources.txt';



//REMOVE EMPTY LINES IN PROXY SOURCE URLS FILE

{
ob_start();
$remove_empty_lines_of_proxy_sources_file = file_get_contents("$proxy_sources_file");
$remove_empty_lines_of_proxy_sources_file = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $remove_empty_lines_of_proxy_sources_file);
file_put_contents("$proxy_sources_file", "$remove_empty_lines_of_proxy_sources_file");
ob_flush();
flush();
ob_end_clean();
}

//GRAB PROXIES
{
ob_start();
$proxy_source = @fopen("$proxy_sources_file", "r")or die("Unable to open file!");
if ($proxy_source) {
while (($eachsourceurl = fgets($proxy_source)) !== false) {
$context = stream_context_create(array(
'http' => array(
'header' => array('User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; rv:2.2) Gecko/20110201'),),));
$source = @fopen("$eachsourceurl", "r", true, $context)or ("Unable to open file!");
if ($source) {
    while (($proxies_grabbed = fgets($source)) !== false) {
$proxies = array();
$eachproxy = 	preg_match_all('@[0-9]{1,4}\.[0-9]{1,4}\.[0-9]{1,4}\.[0-9]{1,4}:[0-9]{1,6}@', $final, $matches);
$proxies[$proxies_grabbed]= $matches[0];
foreach($matches as $proxy) {
$allproxies= implode(PHP_EOL, $proxy);
file_put_contents($leeched_proxies,$allproxies .PHP_EOL, FILE_APPEND); 
}
}
}
}
}
ob_end_clean();
}


//SANITIZING PROXY FILE

ob_start();
$leechedproxyfile = file($leeched_proxies);
$uniquearray = array_unique($leechedproxyfile);
$implodefile = implode(PHP_EOL,$uniquearray);
$pregreplace = preg_replace('/^\h*\v+/m','', $implodefile);
$remove_empty_lines = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/","\r\n",$pregreplace);
file_put_contents($leeched_proxies, $remove_empty_lines);
ob_flush();
flush();
ob_end_clean();

//MAKING SURE ALL DUPLICATES ARE REMOVED


{
ob_start();
$deletedupsagain = file($leeched_proxies); 
$anotheruniquearray = array_unique($deletedupsagain); 
file_put_contents($leeched_proxies,$anotheruniquearray);  
ob_flush();
flush();
}
ob_end_clean();




$done = "FINISHED GRABBING PROXIES!  ALL PROXIES GRABBED ARE SAVED IN  leeched/leeched_proxies.txt   NOW MOVING TO STAGE 2, PROXY TESTING!";
echo $done;
 sleep(5);
//NOW MOVE ON TO STAGE 2, PROXY TESTING
if ($done == TRUE) 
{
  include("proxy_testing.php");
}


// EXTREME PROXY HARVESTER AND CHECKER
// CREATED WITH CURL AND PHP
// BY PHP NINJA JEFF CHILDERS
?>



</body></html>
