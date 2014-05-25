<?php

ini_set('display_errors', '1');

require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/config.php');

$url = $_SERVER['REQUEST_URI'];
$url = rtrim($url, '/') . '/';
$urlArray = explode('/', substr($url, 1, -1));
if ($urlArray[0] == 'ja') { setLanguage('ja'); array_shift($urlArray); } else { setLanguage('en'); }
$i = 0; while ($i <= 3) { if (!isset($urlArray[$i])) { $urlArray[$i] = ''; } $i++; }

jagaBoogie($urlArray);

?>