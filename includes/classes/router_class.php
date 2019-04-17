<?php

class Router 
{

   

    /**
     * Loads the module from the filesystem with optional namecheck
     *
     * @param string $mod_name
     * @return void
     */
    public static function LoadModFromFiles($mod_name)
    {
        if (empty($mod_name) or !is_string($mod_name)) return false;
        if (self::ModCanRun($mod_name)==false) return false;

        $module_path ="modules".DIRECTORY_SEPARATOR.$mod_name; 

        if (is_dir($module_path)){
            if(is_file($module_path.DIRECTORY_SEPARATOR.$mod_name.".php")){
                include_once($module_path.DIRECTORY_SEPARATOR.$mod_name.".php");
                if (is_callable($mod_name,true))
                {
                    call_user_func($mod_name);
                }
            }
        }
    }

    /**
     * Resolves module from an Instance of the URL class
     *
     * @param URL $url
     * @return string|false
     */
    public static function ResolveModuleURL(URL $url){
        $url_array = $url->GetURLArray();
        if (count($url_array) == 0) return false; 

        $query = new Query(new DB()); 
        $query->SetTableName('routes');
        $query->Select(['mod_name']);
        $query->Where(["action","=",$url_array['action']]);

        if (array_key_exists('type', $url_array)){
            $query->AndClause(['type','=',$url_array['type']]);
        }

        $query->Limit(1); 
        $query->Run();
        $result = $query->GetReturnedRows();

        if (count($result) == 0) return false; 

        return $result[0]['mod_name'];
    }

    /**
     * Check the routing table if a module exists
     *
     * @param string $mod_name
     * @return string|false
     */
    public static function ModuleNameExists($mod_name){
        $query = new Query(new DB());

        $query->SetTableName("routes");
        $query->Select(['mod_name']);
        $query->Where(['mod_name','=',$mod_name]);
        $query->Run();
        $result = $query->GetReturnedRows();
        
        if (count($result) == 0) return false; 
        return $result[0]['mod_name'];
    }

    /**
     * Checks if the module is system and enabled 
     *
     * @param string $mod_name
     * @return boolean
     */
    public static function ModCanRun($mod_name)
    {
        if (empty($mod_name) or !is_string($mod_name)) return false; 

        $query = new Query(new DB()); 
        $query->SetTableName("routes");
        $query->Select(['status','system']);
        $query->Where(['mod_name','=',$mod_name]);
        $query->Run(); 

        $result = $query->GetReturnedRows(); 
        if (count($result)==0) return false;

        $status = $result[0]['status'];
        $system = $result[0]['system']; 
        
        switch ($system) {
            case '1':
            return true;
                break;

            case '0':
                if ($status == 1){
                    return true;
                }
                else{
                    return false; 
                }
                break;
            default:
                return false;
                break;
        }
    }

}

?>