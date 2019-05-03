<?php
/*
*The main Boot function for the CMS
*@returns: Void
*/
function boot()
{
    #Loas the Settings from the file
    LoadSettings();
   
    #Autoloader for Classes and Engines 
    Autoload_Classes_Engines();

    Autoload_System_Translations();
   
   /************ WRITE BELOW THIS LINE ********************************************************/
    
    #Test the DB connection 
    $db= new DB();
    if ($db->GetDBError()==true) {
        $error= $db->GetDBError(); 
        $db= null; 
        print(ErrorPage("Database Error", $error)); 
        return false; 
        }
    $db= null; 

    #Check if user is Anonymous 
    CheckAnonymousUser(); 
    

    //$url= new URL();
    //var_dump($url->URLtoPath());
    //var_dump($url->GetURLArray()); 
    
    #Listen for Routes
    RouteListener();

   // var_dump($_SESSION);
    //var_dump($GLOBALS);

   /******** DO NOT WRITE ANY CODE BELOW THIS LINE ********************************************/
   
    #RENDER THE ACTIVE THEME
    $theme = Theme::GetActiveTheme(); 
    if (is_dir('themes'.DIRECTORY_SEPARATOR.$theme)){
        include_once('themes'.DIRECTORY_SEPARATOR.$theme.DIRECTORY_SEPARATOR.$theme.'.tpl.php');
    }

    #END BOOSTSTRAP 

    //var_dump(memory_get_usage(false)/1024);
}

 /**
     * Listens for a URL and Loads the module. Useful for bootstrapping
     *
     * @param URL $url
     * @return void
     */
    function RouteListener(){
        $url = new URL();
        

        if (count($url->GetURLArray()) == 0){
           $url->InternalRedirect('home'); 
           return false; 
        }
        
        $mod_name = Router::ResolveModuleURL($url); 

        if (Security::UserHasPerMission($mod_name)==False) {
            $url->InternalRedirect('denied');
            return false; 
        } 
        
        if ($mod_name == true){
            Router::LoadModFromFiles($mod_name);    
        }
        else 
        {
          $url->InternalRedirect('not_found'); 
          return false;
        }
    }

function CheckAnonymousUser()
{
    if (Security::UserIsLoggedIn()== FALSE) {
        $_SESSION['role'] = 1;
        return true; 
    }
    return false; 
}

/*
* Error Message Function
* 
*/
function ErrorPage($message_head,$error)
{
    $css= "<style>html {font-family: Arial; background:lightblue;} </style>"; 
    $html_head= "<!DOCTYPE html> <html> <head>";
    $html_head.= "<title> Plastelline | Error </title>";
    $html_head.= "</head>";

    $html_body= "<body>"; 
    $html_body.= $css; 
    $html_body.= "<h1> Plastelline </h1>";
    $html_body.= "<fieldset> <legend> <h2 style='background-color: pink;'> $message_head </h2> </legend>";
    $html_body.= "<h4> The CMS Cannot Continue. Please consult an administrator mentioning the error message below:</h4>"; 
    $html_body.= "<h3 style='color:red;'> {$error} </h3>";
    $html_body.= "</legend>";

    $html_closure= "</html>"; 

    return $html_head.$html_body.$html_closure; 
}

/**
 * Autoloader for the Settings
 *
 * @return void
 */
function LoadSettings()
{
    include_once("settings".DIRECTORY_SEPARATOR."settings.php");
}

function Load($class)
{
    $path = "includes".DIRECTORY_SEPARATOR."classes".DIRECTORY_SEPARATOR;
    include("{$path}{$class}_class.php"); 
}

/**
 * Autoloader Function for the Framework
 *
 * @return void
 */
function Autoload_Classes_Engines()
{
    $path='includes'.DIRECTORY_SEPARATOR.'*'.DIRECTORY_SEPARATOR.'*.php';
    $files_path_array = glob($path);
    foreach ($files_path_array as $path) 
    {
     if (!is_uploaded_file($path) and is_readable($path))
     { 
        include_once($path);
     }    
    }
}

function Autoload_System_Translations()
{
    $path='includes'.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'core_translations'.DIRECTORY_SEPARATOR.'*.lang.php';
    $files= glob($path); 
    foreach ($files as $file) {
        if(is_readable($file) and !is_uploaded_file($file)){
            include_once($file); 
        }
    }
}

?>