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

//Start 

//Settings
error_reporting(E_ALL); 
ini_set('max_execution_time', 0);
require_once ('classes/class.multicurl.php'); 
set_time_limit(0);
//Short Delay
$delay = rand(2,4);
//Long Delay
$longdelay = rand(4,7);
//Checking Proxies
$fileName = "leeched/proxies.txt";  
//where to save successful proxies 
$success = "goodproxies/success.txt"; 
$source = file('sources/sources.txt');


//SET Cookie
$c = new Curl;
foreach( $source as $sources ) {
//Request To Delete Duplicate Proxies
$c->addRequest(trim($sources));

}
$c->chunk(25);
$c->perform();
$proxies = array();
foreach( $c->results as $url => $res ) {
//REGEX MATCH
	preg_match_all('@[0-9]{1,4}\.[0-9]{1,4}\.[0-9]{1,4}\.[0-9]{1,4}:[0-9]{1,6}@', $res, $m);

		$proxies[$url]= $m[0];
    sleep($delay);
}     

foreach($proxies as $url => $parr) {

	$str = implode("\n", $parr);
  file_put_contents( 'leeched/proxies.txt',$str);
	$k = count($parr);
	$str2 = date('h:i:s d m')." | \t".$k."\t".$url."\n";
	file_put_contents('logs/counts.txt', $str2, FILE_APPEND);
}

$uar = file('leeched/proxies.txt');
$uar = array_unique($uar);

	$str = implode("\n", $uar)."\n";
	$str = preg_replace('/^\h*\v+/m', '', $str);
  file_put_contents( 'leeched/proxies.txt',$str);
 

// EXTREME PROXY HARVESTER AND CHECKER
// CREATED WITH CURL AND PHP
// BY PHP NINJA JEFF CHILDERS
	
	
//Proxy Testing
if(!is_file($fileName)) die ('Proxy file not available'); 
$proxies = file($fileName);  
for($p=0; $p<count($proxies);$p++) {  

    $ch = curl_init(); //initizlize and set url 
    curl_setopt ($ch, CURLOPT_URL, "http://www.mydomain.com/check.php"); 
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
            

           $f=fopen($success, "a+"); 
            fwrite($f, $proxies[$p]); 
            fclose($f); 
    } 
   
            elseif (curl_errno($ch)) {
            
      
               echo   "<img src=\"images/bad.png\">&nbsp;&nbsp;<font color=\"white\"><strong>" .$proxies[$p] . " </font></strong><font color=\"red\"><strong>ERROR:</font></strong><font color=\"#00FFFF\"><strong> ".curl_error($ch)." </font></strong><img src=\"images/redx.png\"> <br/><br/>";
     
     }
    
   else        { 
                echo  "<img src=\"images/warning.png\">&nbsp;&nbsp;<font color=\"#7CFC00\"><strong> " .$proxies[$p] . "   </font></strong><font color=\"white\"><strong> THERE WAS NO ERROR CONNECTING BUT THIS PROXY IS NOT ANONYMOUS!  NOT SAVED</font></strong> <font color=\"#FF69B4\"><strong>(No content from source)</font></strong><img src=\"images/redx.png\"> <br/><br/>"; 
    } 
        
        
        
       
        
  
    flush();  
      
        curl_close($ch);
         
} 



 

$done = "done"; 
echo $done;


 

//END 

// EXTREME PROXY HARVESTER AND CHECKER

// CREATED WITH CURL AND PHP

// BY PHP NINJA JEFF CHILDERS
?>

</body></html>


