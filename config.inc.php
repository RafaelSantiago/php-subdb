<?php
// CONFIG
error_reporting('E_ALL ^ E_NOTICE');


// PATH TO SCAN
$path_scan = ".";

// MINIMUM FILE SIZE
$min_size = 50;

// ALLOWED FILE EXTENSIONS
$allowed_extensions = array('mp4','avi','mkv','mpeg','mpg','mov');

// SUBTITLE LANGUAGE
$language = "pt";

// USE PROWL (PUSH MESSAGE IOS)
$prowl_send = false;

// PROWL API KEY (REQUIRED IF PROWL_SEND IS TRUE)
$prowl_api_key = "";
?>