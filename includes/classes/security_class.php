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
     * @param string $usenrame
     * @param string $password
     * @return string|false
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
     * @return boolean
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

    /**
     * Gets the user Roles from the Session
     *
     * @return int
     */
    public static function GetUserRole_Session()
    {
        return $_SESSION['role']; 
    }

    /**
     * Checks if the use has permission to a module
     *
     * @param string $mod_name
     * @return boolean
     */
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
    /**
     * Gets the users list in an array: 
     * uid,username,role
     *
     * @return void
     */
    public static function Get_Users_Array()
    {
        $query= new Query(new DB()); 
        $query->SetTableName('user'); 
        $query->Select(['uid','username','role']); 
        $query->OrderBy(['role'],"DESC");
        $query->Run(); 
        $result= $query->GetReturnedRows(); 
        $query= null; 
        $users= array(); 

        foreach ($result as $row){
            $users[]= [
                'uid'=>$row['uid'],
                'username'=>$row['username'],
                'role'=>$row['role']
            ];
        }
        return $users; 

    }

    /**
     * Gets the Roles in an Array:
     * roleid,role_name,role_display_name,role_description
     *
     * @param boolean $remove_anoymous
     * @return void
     */
    public static function Get_Roles_Array($remove_anoymous=false)
    {
        $query= new Query(new DB()); 
        $query->SetTableName('roles'); 
        $query->Select(['roleid','role_name','role_display_name','role_description']); 
        if ($remove_anoymous){
            $query->Where(['roleid','>','1']); 
        }
        $query->OrderBy(['roleid'],"DESC");
        $query->Run(); 
        $result= $query->GetReturnedRows(); 
        $query= null; 
        $roles= array(); 

        foreach ($result as $row){
            $roles[]= [
                'roleid'=>$row['roleid'],
                'role_name'=>$row['role_name'],
                'role_display_name'=>$row['role_display_name'],
                'role_description'=>$row['role_description']
            ];
        }
        return $roles; 

    }

    /**
     * Gets the user from the user ID
     *
     * @param integer $uid
     * @return void
     */ 
    public static function Get_User_From_id($uid)
    {
        if (!is_numeric($uid)) {return false;}

        $query= new Query(new DB()); 

        $query->SetTableName('user');
        $query->Select(['uid','username','role']);
        $query->Where(['uid','=',$uid]);  
        $query->Limit(1);
        $query->Run(); 

        $result= $query->GetReturnedRows(); 
        if ($result){
            return $result[0];
        }
        return false; 
    }
}

?>