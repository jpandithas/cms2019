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

    //TODO: check for Bugs
    public function GetDBStatus()
    {
        if (!isset($this->DBError))
        {
            return true; 
        }
        else
        {
            return $this->DBError; 
        }
        
    }

    public function DBQPrepStatement($query, array $params, $return_value=false, $return_insert_id=false)
    {
    
       if ($this->GetDBStatus() != true) return false;
       if (empty($query) or !(is_array($params))) return false;

        $dbo = $this->DBConnection; 
        
        $stmt = $dbo->prepare($query);
        $result = $stmt->execute($params);

        if ($result==false)
        {
            return $dbo->errorCode();
        }
        
        if ($return_insert_id==true)
        {
            return $dbo->lastInsertId(); 
        }

        if ($return_value==true)
        {
            return $stmt->fetchAll();
        }
        
    }
}

?>