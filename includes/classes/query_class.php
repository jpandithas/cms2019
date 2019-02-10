<?php

/**
 * Query class
 * PDO WRAPPER
 */
class Query
{

    /**
     * table variable
     *
     * @var [string]
     */
    protected $table;
    protected $db;
    protected $dbo;
    protected $sql;
    protected $params = array();
    protected $errorCode;
    protected $returned_rows;
    protected $lastInsertId;

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
    public function SetTableName($table_name)
    {
        if (!is_string($table_name)) return false; 
        $this->table = $table_name;
        return $this;
    }

    /**
     * Insert function
     *
     * @param array $values
     * @return [integer] 
     */
    public function Insert(array $values)
    {
    
        if (!is_array($values) or count($values)==0) return false;
        $this->params = array();
        $size = count($values);
        $this->sql  = "INSERT INTO `".$this->table."` VALUES ";
        $this->sql.="(";
        
        /**
         * Can be done with:
         * $this->sql .= "(".str_repeat("?,"$size-1)."?)";
         */
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
        return $this;
    }
    
   /**
    * Update function
    *
    * @param [array] $fields_values
    * @return [Query]
    */
   public function Update(array $fields_values)   
   {
    if (!is_array($fields_values) 
    or count($fields_values)==0) 
    return false;

    $this->params = array();
    $this->sql = "UPDATE `".$this->table."` SET ";
    $count = 0;
    foreach ($fields_values as $field => $value) 
    {
        $this->sql .= "{$field} = ? ";
        if ($count < (count($fields_values)-1))
        {
           $this->sql .= ", ";
        }
        $count++;
        array_push($this->params, $value);
    }
    return $this;
   }
       

    /**
     * Delete function
     *
     * @param array $id_values
     * @return void
     */
    public function Delete()
    {
        $this->params = array();
        $this->sql = "DELETE FROM `".$this->table."` ";       
        return $this;
    }

    /**
     * Select function
     *
     * @param array $fields_array
     *
     * @return [Query]
     */
    public function Select(array $fields_array)
    {
        if (!is_array($fields_array) or count($fields_array)==0) return false;
        
        $this->params = array();
        $this->sql = "SELECT ";
        $count = 0;
        foreach ($fields_array as $field) 
        {
            $this->sql .= $field;
            if ($count < count($fields_array)-1)
            {
                $this->sql .=",";
            }
            $count++;
        }
        $this->sql .=" FROM `".$this->table."` ";
        return $this;
    }

    /**
     * Where function
     *
     * @param array $where_clause
     *
     * @return [Query]
     */
    public function Where(array $where_clause)
    {
        if (!is_array($where_clause) or count($where_clause)==0) return false;
        if (count($where_clause) != 3) return false;
        if (!isset($this->sql)) return false;

        $this->sql .= "WHERE ".$where_clause[0]." ".$where_clause[1]." ?";
        array_push($this->params, $where_clause[2]);
        return $this;
    }

    /**
     * AndClause function
     *
     * @param array $clause
     *
     * @return [Query]
     */
    public function AndClause(array $clause)
    {
        if (!is_array($clause) or count($clause) != 3) return false;
        if (!isset($this->sql)) return false;
        $this->sql .=" AND {$clause[0]} {$clause[1]} ?";
        array_push($this->params,$clause[2]);
        return $this;
    }

    /**
     * OrClause function
     * Adds an or clause
     * @param array $clause
     * @return [Query]
     */
    public function OrClause(array $clause)
    {
        if (!is_array($clause) or count($clause) != 3) return false;
        if (!isset($this->sql)) return false;
        $this->sql .=" OR {$clause[0]} {$clause[1]} ?";
        array_push($this->params,$clause[2]);
        return $this;
    }

    /**
     * Limit() function
     *
     * @param [integer] $rows
     * @param [integer] $offset
     *
     * @return [Query]
     */
    public function Limit($rows, $offset=null)
    {
        if (empty($rows)) return false;
        if (empty($rows) and empty($offset)) return false;
        if (!isset($this->sql)) return false;
        if (!isset($this->table)) return false;
        if (!is_int($rows)) return false;

        if (!isset($offset)) $this->sql .= " LIMIT ".$rows;
        if (isset($offset) and is_int($offset)) $this->sql .= " LIMIT {$rows},{$offset}";

        return $this;
    }

    /**
     * SendQuery()
     *
     * @return [Query]
     */
    public function SendQuery()
    {
        $dbo = $this->db->GetDBConnection();        
        $stmt = $dbo->prepare($this->sql);
        $result = $stmt->execute($this->params);
        if ($result==false)
        {
            $this->errorCode = $dbo->errorCode();
        }
        $this->returned_rows = $stmt->FetchAll();
        $this->lastInsertId = $dbo->lastInsertId();
        return $this;
    }

    /**
     * Undocumented function
     *
     * @return [string] | [false]
     */
    public function GetErrorCode()
    {
        if (!isset($this->errorCode))
        {
            return false;
        }
        return $this->errorCode;
    }
    
    /**
     * GetLastInsertID function
     *
     * @return [integer]|[false]
     */
    public function GetLastInsertId()
    {
        if (!isset($this->lastInsertId))
        {
            return false;
        }
        return $this->lastInsertId;
    }

    /**
     * GetRows function
     *
     * @return [array]|[false]
     */
    public function GetRows()
    {
        if (!isset($this->returned_rows))
        {
            return false;
        }
        return $this->returned_rows;
    }

    public function getSQL()
    {
        echo $this->sql;
        var_dump($this->params);
    }

}

?>