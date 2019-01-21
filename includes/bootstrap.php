<?php
/*
*The main Boot function for the CMS
*/
function boot()
{
    echo "Site booting..<br/>"; 
    
    Autoload_Classes_Engines(); 
}

/*
* Autoloader Function for the Framework
*@input: none
*@returns: none
*/
function Autoload_Classes_Engines()
{
    $path='includes\*\*.php';
    $files_path_array = glob($path);
    foreach ($files_path_array as $path) 
    {
     if (!is_uploaded_file($path) and is_readable($path))
    {
        include_once($path);
    }    
    }
}

?>