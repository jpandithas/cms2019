<?php 

class DB
{
    /**
     * DBConnection variable
     *
     * @var [PDOStatement]
     */
    protected $DBConnection;
    /**
     * DBError variable
     *
     * @var [string]
     */
    protected $DBError; 
    /**
     * ISConnected variable
     *
     * @var [boolean]
     */
    protected $IsConnected; 

    public function __construct()
    {
        $this->DBConnect();
    }

    /**
     * DBConnect function
     *
     * @return mixed
     */
    protected function DBConnect()
    {
        try 
        {
           $conn_string = DB_ENGINE.':host='.DB_HOST.';dbname='.DB_NAME; 
           $dbc = new PDO($conn_string,DB_USER,DB_PASSWORD);
        } 
        catch (PDOException $Exception) 
        {
           $this->IsConnected = false; 
           return $this->DBError = $Exception->getMessage();
        }
        $this->IsConnected = true; 
        return $this->DBConnection = $dbc;  
    }
    
    /**
     * GetDBConnection function
     *
     * @return [PDOStatement]|[false]
     */
    public function GetDBConnection()
    {
        if ($this->IsConnected == false) return false; 
        return $this->DBConnection; 
    }

    /**
     * GetDBError function
     *
     * @return [string]|[false]
     */
    public function GetDBError ()
    {
        if ($this->IsConnected == true) return false;
        return $this->DBError; 
    }

    /**
     * DBQPrepStatement function
     *
     * @param [string] $query
     * @param array $params
     * @param boolean $return_value
     * @param boolean $return_insert_id
     * @return mixed
     */
    public function DBQPrepStatement($query, array $params, $return_value=false, $return_insert_id=false)
    {
    
       if ($this->IsConnected == false) return false;
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