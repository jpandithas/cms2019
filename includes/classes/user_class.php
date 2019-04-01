<?php 

class User
{
    protected $uid;
    protected $username; 
    protected $password; 

    public function __construct($username, $password)
    {
         $this->ValidateUser($username, $password); 
    }

    protected function ValidateUser($username, $password)
    {
        $uid = Security::Authenticate($username,$password);
        if ($uid == false){
            $this->isAuthenticated = false; 
        }
        $this->uid = $uid;
        $this->username = $username;
        $this->password = $password; 
    }

    public function GetUID(){
        return $this->uid; 
    }
    

}

?>