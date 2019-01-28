<?php 

class DB
{
    protected $DBConnString;

    public function __construct()
    {
        $this->DBConnect();
    }

    protected function DBConnect()
    {
        $conn_string = DB_ENGINE.':host='.DB_HOST.';dbname='.DB_NAME; 
        $dbc = new PDO($conn_string,DB_USER,DB_PASSWORD);
        return $this->DBConnString = $dbc;  
    }

    public function GetDBConnection()
    {
        return $this->DBConnString; 
    }
}

?>