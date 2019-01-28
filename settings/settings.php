<?php 
//System Settings
define("CMS_BASE_PATH",getcwd());
define("CMS_BASE_URL",$_SERVER['REQUEST_SCHEME']."://".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']);
//Database settings
define("DB_HOST","localhost");
define("DB_ENGINE","mysql");
define("DB_NAME","cms2019");
define("DB_USER","root");
//for your systems you may leave this value as ""
//check with your db first
define("DB_PASSWORD","root1234");
?>