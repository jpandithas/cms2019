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


    $db = new DB();

    $query = new Query($db);

    $query->SetTable("testtable");
    $query->Insert(Array("1","2","3","4"));
    $query->UpdateByField(['tid','1'],['fields1'=>'value1','fields2'=>'value2']);
    $query->DeleteByField(["tid"=>"1"]);
    $query->Select(['id','text1'])->Where(['id','=',"1"]);
    var_dump($query->GetAllRows());
    
    $query->GetSelect();
    echo "<br/>";
    $query->getSQL();

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

/**
 * Autoloader for the Settings
 *
 * @return void
 */
function LoadSettings()
{
    include_once("settings\settings.php");
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