<?php 

class DB
{
    protected $DBConnection;
    protected $DBError; 

    public function __construct()
    {
        $this->DBConnect();
    }

    protected function DBConnect()
    {
        try 
        {
           $conn_string = DB_ENGINE.':host='.DB_HOST.';dbname='.DB_NAME; 
           $dbc = new PDO($conn_string,DB_USER,DB_PASSWORD);
        } 
        catch (PDOException $Exception) 
        {
           return $this->DBError = $Exception->getMessage();
        }
        return $this->DBConnection = $dbc;  
    }

    public function GetDBConnection()
    {
        return $this->DBConnection; 
    }


    public function GetDBStatus()
    {
        if (!empty($this->DBError))
        {
            return "Connected"; 
        }
        else
        {
            return $this->DBError; 
        }
    }
}

?>