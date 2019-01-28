<?php
/*
*The main Boot function for the CMS
*@returns Void
*/
function boot()
{
    echo "Site booting..<br/>";
    
    LoadSettings();
    Autoload_Classes_Engines();


    //$db = new DB();
    //var_dump($db->GetDBConnection());

    TestDB(); 

    $url = new URL();
    echo $url->URLToString();
    var_dump($url->GetURLArray());
    echo $url->GetCurrentURI();
}

/*
* DB tester Function
* This returns the state of the DB
*/
function TestDB()
{
    try
    {
      $db = new DB(); 
    }
    catch(PDOException $Exception)
    {
        print($Exception->getCode());
        print("<br>FAIL");
        return false; 
    }
    print("<br>PASS");
}

/*
* Loader for the settings file
*/
function LoadSettings()
{
    include_once("settings\settings.php");
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