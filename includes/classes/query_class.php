<?php

class Query
{

    /**
     * table variable
     *
     * @var [string]
     */
    protected $table;
    protected $db;
    protected $sql;

    public function __construct(DB $db)
    {
        $this->db = $db;
    }
    
    /**
     * SetTable function
     *
     * @param [string] $table_name
     * @return [Query]
     */
    public function SetTable($table_name)
    {
        $this->table = $table_name;
        return $this;
    }

    public function Insert(array $values)
    {
    
        if (!is_array($values) or count($values)==0) return false;

        $size = count($values);
        $this->sql  = "INSERT INTO `".$this->table."` VALUES ";
        $this->sql.="(";
        
        foreach ($values as $key=>$param) 
        {
            if ($key < ($size-1))
            {
                $this->sql.="?, ";
            }
            else
            {
                $this->sql.="? ";
            }
        
        }
        $this->sql.=")";
        $this->params = $values;
        
        $dbo = $this->db->GetDBConnection();        
        $stmt = $dbo->prepare($this->sql);
        $result = $stmt->execute($this->params);
        
        if ($result==false)
        {
            return $dbo->errorCode();
        }
        return $dbo->lastInsertID(); 
    }

   

    public function getSQL()
    {
        echo $this->sql;
    }

}

?>