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

    public static function UserIsLoggedIn()
    {
        if (isset($_SESSION['username']) and isset($_SESSION['userlevel'])){
            return TRUE;
        }
        return FALSE; 
    }
}

?>