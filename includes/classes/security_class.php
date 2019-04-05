<?php

class Security
{
    /**
     * SanitizeString function
     *
     * @param [string] $string
     * @return mixed 
     */
    public static function SanitizeString($string)
    {
        if (empty($string) or (!is_string($string))) return false;

        return strip_tags($string);
    }


    /**
     * Hashes the password
     *
     * @param [string] $password
     * @return [string]|[false]
     */
    public static function Password($password)
    {
        //revisit
        if (empty($password)) return false; 
        return md5($password); 
    }

    /**
     * Authenticates the user from the username and the password
     *
     * @param [string] $usenrame
     * @param [string] $password
     * @return [string]|[false]
     */
    public static function Authenticate($usenrame, $password)
    {   
        $query = new Query(new DB()); 
        $query->SetTableName('user'); 
        $query->Select(['uid']); 
        $query->Where(['username','=',$usenrame]);
        $query->AndClause(['password','=',self::Password($password)]); 
        $query->Limit(1); 
        $query->Run(); 

        if ($query->GetReturnedRows()){
            $uid = $query->GetReturnedRows();
            return $uid[0]['uid']; 
        }
        return false; 
    }

    /**
     * Asks if a user has logged in
     *
     * @return [boolean]
     */
    public static function UserIsLoggedIn()
    {
        if (isset($_SESSION['username']) and isset($_SESSION['role'])){
            if ($_SESSION['role']>1){
            return TRUE;
            }
        }
        return FALSE; 
    }

    public static function UserHasPerMission($mod_name)
    {
        if (empty($mod_name)) return FALSE; 

        $query = new Query(new DB()); 

        $query->SetTableName('routes'); 
        $query->Select(['routeid']); 
        $query->Where(['mod_name','=',$mod_name]);
        $query->Limit(1); 
        $query->Run(); 

        $routeid = $query->GetReturnedRows(); 
        if (!$routeid) return FALSE; 

        $rid = $routeid[0]['routeid']; 

        $query = null; 
        $query = new Query(new DB()); 

        $query->SetTableName('permissions'); 
        $query->Select(['allowed']); 
        $query->Where(['routeid','=',$rid]);
        $query->AndClause(['roleid','=',$_SESSION['role']]);
        $query->Limit(1); 
        $query->Run(); 
        
        $allowed = $query->GetReturnedRows(); 
        if (!$allowed) return FALSE;

        $isallowed = $allowed[0]['allowed']; 

        if ($isallowed == 0) return FALSE; 
        if ($isallowed == 1) return TRUE; 

    }
}

?>