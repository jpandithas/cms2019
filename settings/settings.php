<?php 
//System Settings
define("CMS_BASE_PATH",getcwd());
define("CMS_BASE_URL",$_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
//Database settings
define("DB_HOST","localhost");
define("DB_ENGINE","mysql");
define("DB_NAME","cms2019");
define("DB_USER","root");
//for your systems you may leave this value as ""
//check with your db first
define("DB_PASSWORD","root1234");
# Enable this if you wish to use Mulilingual Capabilities
# The site defaults to English 'en' if any errors take place 
# path prefix is akin to ?q=en/action/type/id
define("LOCALES_ENABLED",true); 
?>