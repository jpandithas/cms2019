<?php
/*
*The main Boot function for the CMS
*@returns: Void
*/
function boot()
{
    echo "Site booting..<br/>";
    
    LoadSettings();
    Autoload_Classes_Engines();


    //$db = new DB();
    //var_dump($db->GetDBConnection());

    $db = new DB();

    $data = $db->DBQPrepStatement("Select id, text1 from testtable where id = ?",array("1"),true);
    var_dump($data); 


    $url = new URL();
    echo $url->URLToString();
    var_dump($url->GetURLArray());
    echo $url->GetCurrentURI();
}

/*
* DB tester Function
* This returns the state of the DB
* REFACTOR
*/
function TestDB()
{
   #TODO
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