<?php

$d = file_get_contents('leeched/proxies.txt');

$d = explode("\n", $d);
echo count($d)."\n";
$d = array_unique($d);
echo count($d);

$d = implode("\n",$d)."\n";
file_put_contents('leeched/proxies.txt', $d);


?>