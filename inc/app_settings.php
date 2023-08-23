<?php

$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
 
$url = $protocol . $_SERVER['HTTP_HOST'];
$documentRoot = $_SERVER['DOCUMENT_ROOT'];
define('BASE_URL', $url);
define('DOCUMENT_ROOT', $documentRoot);


