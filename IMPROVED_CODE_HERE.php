<!DOCTYPE html>
<html lang="en">
<head>
<title>EXTREME PROXY HARVESTER AND CHECKER - ANONYMOUS PROXY HARVESTER AND CHECKER ALL IN ONE BY JEFF CHILDERS Chesapeake Virginia</title>
<meta name="description" content="EXTREME PROXY HARVESTER AND CHECKER - ANONYMOUS PROXY HARVESTER AND CHECKER ALL IN ONE BY PHP NINJA JEFF CHILDERS Chesapeake Virginia">
<meta name="author" content="Troy Jeffrey Childers Chesapeake Virginia 757-266-9111">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body> 
<h1>NOW CHECKING FOR ANONYMOUS PROXIES ONLY</h1>           
<?php
// EXTREME PROXY HARVESTER AND CHECKER
// CREATED WITH CURL AND PHP
// BY PHP NINJA JEFF CHILDERS
 

//Settings
error_reporting(0);
ini_set('max_execution_time', 0);
set_time_limit(0);
ob_implicit_flush(true);
//All Proxies Saved File
$leeched_proxies = "leeched/leeched_proxies.txt";  
//All Good Proxies Are Saved Here 
$success = "goodproxies/success.txt"; 
//Proxy Source URLS
$proxy_sources_file ='sources/sources.txt';
//Start


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
    while (($final = fgets($source)) !== false) {
$proxies = array();
$eachproxy = 	preg_match_all('@[0-9]{1,4}\.[0-9]{1,4}\.[0-9]{1,4}\.[0-9]{1,4}:[0-9]{1,6}@', $final, $matches);
$proxies[$final]= $matches[0];
foreach($matches as $proxy) {
$allproxies= implode(PHP_EOL, $proxy);
file_put_contents($leeched_proxies,$allproxies, FILE_APPEND);
ob_flush();
flush();
}
}
}
}
}
ob_end_clean();
}
sleep(5);

//SANITIZING PROXY FILE

ob_start();
$leechedproxyfile = file($leeched_proxies);
$uniquearray = array_unique($leechedproxyfile);
$implodefile = implode(PHP_EOL,$uniquearray);
$pregreplace = preg_replace('/^\h*\v+/m','', $implodefile);
$remove_empty_lines = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/","\r\n",$pregreplace);
file_put_contents($leeched_proxies,$remove_empty_lines, FILE_APPEND);
ob_flush();
flush();
ob_end_clean();

//MAKING SURE ALL DUPLICATES ARE REMOVED


{
ob_start();
$deletedupsagain = file($leeched_proxies); 
$anotheruniquearray = array_unique($deletedupsagain); 
file_put_contents($leeched_proxies,$anotheruniquearray, FILE_APPEND);  
ob_flush();
flush();
}
ob_end_clean();


//NOW TESTING PROXIES

{
ob_start();
echo '<h2>NOW TESTING PROXIES</h2>';
if(!is_file($leeched_proxies)) die ('Proxy file not available'); 
$proxies = file($leeched_proxies);  
for($p=0; $p<count($proxies);$p++) {  
    $ch = curl_init(); //initizlize and set url 
    curl_setopt ($ch, CURLOPT_URL, "http://www.exteriorexpertsofvirginia.com/check.php"); 
    curl_setopt($ch, CURLOPT_HEADER, 1); //show headers 
    curl_setopt($ch, CURLOPT_HTTPGET,1); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
    curl_setopt($ch, CURLOPT_HEADER, FALSE);  
    curl_setopt($ch, CURLOPT_VERBOSE, TRUE); 
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 7); 
    curl_setopt($ch, CURLOPT_TIMEOUT, 5); 
    curl_setopt($ch, CURLOPT_PROXY, trim($proxies[$p]));  
    $data = curl_exec($ch); 
if (strpos($data, 'Anonymous') !== false) { 
echo   "<img src=\"images/good.png\">&nbsp;&nbsp;<font color=\"#7CFC00\"><strong>" .$proxies[$p] . " </font></strong><font color=\"#FFFFE0\"><strong>   THIS IS A WORKING ANONYMOUS PROXY SAVED TO /goodproxies/success.txt</font></strong><font color=\"yellow\"><strong> " . "Total time: " .curl_getinfo($ch, CURLINFO_TOTAL_TIME)." seconds!</font></strong><img src=\"images/small.png\"> <br/><br/>"; 
$f=fopen($success, "a"); 
fwrite($f, $proxies[$p]); 
fclose($f); 
} 
elseif (curl_errno($ch)) {
echo "<img src=\"images/bad.png\">&nbsp;&nbsp;<font color=\"white\"><strong>" .$proxies[$p] . " </font></strong><font color=\"red\"><strong>ERROR:</font></strong><font color=\"#00FFFF\"><strong> ".curl_error($ch)." </font></strong><img src=\"images/redx.png\"> <br/><br/>";
}else{ 
echo "<img src=\"images/warning.png\">&nbsp;&nbsp;<font color=\"#7CFC00\"><strong> " .$proxies[$p] . "   </font></strong><font color=\"white\"><strong> THERE WAS NO ERROR CONNECTING BUT THIS PROXY IS NOT ANONYMOUS!  NOT SAVED</font></strong> <font color=\"#FF69B4\"><strong>(No content from source)</font></strong><img src=\"images/redx.png\"> <br/><br/>"; 
} 
curl_close($ch);
ob_flush();
flush();         
} 
}  
ob_end_clean();
$done = "FINISHED!"; 
file_put_contents("$leeched_proxies", "");
echo $done;
?>
</body></html>
