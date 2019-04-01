<?php
/*
*The main Boot function for the CMS
*@returns: Void
*/
function boot()
{
    //echo "Site booting..<br/>";
    
    LoadSettings();
    Autoload_Classes_Engines();


    RouteListener();

    //var_dump(Security::Authenticate('admin','admin'));
    //var_dump($_SESSION);
    //var_dump(Security::UserIsLoggedIn());
   // var_dump($GLOBALS);

    $theme = Theme::GetActiveTheme(); 
    if (is_dir('themes'.DIRECTORY_SEPARATOR.$theme)){
        include_once('themes'.DIRECTORY_SEPARATOR.$theme.DIRECTORY_SEPARATOR.$theme.'.tpl.php');
    }

    
}

 /**
     * Listens for a URL and Loads the module. Useful for bootstrapping
     *
     * @param [URL] $url
     * @return void
     */
    function RouteListener(){
        $url = new URL();
        
        if (count($url->GetURLArray()) == 0){
           $url->InternalRedirect('home'); 
           return false; 
        }
        
        $mod_name = Router::ResolveModuleURL($url); 
        
        if ($mod_name == true){
            Router::LoadModFromFiles($mod_name);    
        }
        else 
        {
          $url->InternalRedirect('not_found'); 
          return false;
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