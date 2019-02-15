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

    Listen();

    $url = new URL();
    echo $url->URLtoPath();
    var_dump($url->GetURLArray());
    echo $url->GetCurrentURI();
}

 /**
     * Listens for a URL and Loads the module. Useful for bootstrapping
     *
     * @param [URL] $url
     * @return void
     */
    function Listen(){
        $mod_name = Router::ResolveModuleURL(new URL()); 
        if ($mod_name == true){
            Router::LoadModFromFiles($mod_name,false);    
        }
        else 
        {
            //has to be handled 
            print("<h2> page not found </h2>");
        }
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

/**
 * Autoloader for the Settings
 *
 * @return void
 */
function LoadSettings()
{
    include_once("settings\settings.php");
}

function Load($class)
{
    $path = "includes\classes\/";
    include("{$path}{$class}_class.php"); 
}

/**
 * Autoloader Function for the Framework
 *
 * @return void
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