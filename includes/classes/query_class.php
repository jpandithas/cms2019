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
    protected $select;
    protected $where;
    protected $select_params = array();

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
     * Undocumented function
     *
     * @param array $values
     * @return [integer] 
     */
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

   /**
    * UpdateById
    *
    * @param array $id_name_value
    * @param array $fields_values
    * @return void
    */
   public function UpdateByField(array $id_name_value, array $fields_values)   
   {
    if (!is_array($id_name_value) 
    or count($id_name_value)==0 
    or !is_array($fields_values) 
    or count($fields_values)==0) return false;
    $params = array();
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
        array_push($params, $value);
    }
    if (count($id_name_value)== 2)
    {
        $this->sql .= " WHERE $id_name_value[0] = ?";
        array_push($params, $id_name_value[1]);
    }
    else
    {
        $keys = array_keys($id_name_value);
        $this->sql .= " WHERE ".$keys[0]." = ?"; 
        array_push($params,$id_name_value[$keys[0]]);
    }
   }
       

    /**
     * DeleteById
     *
     * @param array $id_values
     * @return void
     */
    public function DeleteByField(array $id_values)
    {
        if (!is_array($id_values) or count($id_values)==0) return false;
        $params = array();

        $this->sql = "DELETE FROM `".$this->table."` WHERE ";
        if (count($id_values)==1)
        {
            $keys = array_keys($id_values);
            $this->sql .= $keys[0]." = ? ";
            array_push($params,$id_values[$keys[0]]);
        }
        else
        {
            $this->sql .= $id_values[0]." = ?";
            array_push($params,$id_values[1]);
        }
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

        $this->select = "SELECT ";
        $count = 0;
        foreach ($fields_array as $field) 
        {
            $this->select .= $field;
            if ($count < count($fields_array)-1)
            {
                $this->select .=",";
            }
            $count++;
        }
        $this->select .=" FROM `".$this->table."` ";
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
        if (count($where_clause) > 4 or count($where_clause) < 2) return false;
        if (!isset($this->select)) return false;
        $this->select .= "WHERE ".$where_clause[0]." ".$where_clause[1]." ?";
        array_push($this->select_params, $where_clause[2]);
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
        if (!is_array($clause) or count($clause) < 2) return false;
        if (!isset($this->select)) return false;
        $this->select .=" AND {$clause[0]} {$clause[1]} ?";
        array_push($this->select_params,$clause[2]);
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
        if (!is_array($clause) or count($clause) < 2) return false;
        if (!isset($this->select)) return false;
        $this->select .=" OR {$clause[0]} {$clause[1]} ?";
        array_push($this->select_params,$clause[2]);
        return $this;
    }

    public function Limit($rows, $offset=null)
    {
        if (empty($rows)) return false;
        if (empty($rows) and empty($offset)) return false;
        if (!isset($this->sql)) return false;
        if (!isset($this->table)) return false;
        if (!is_int($rows)) return false;

        if (!isset($offset)) $this->select .= " LIMIT ".$rows;
        if (isset($offset) and is_int($offset)) $this->select .= " LIMIT {$rows},{$offset}";

        return $this;
    }

    /**
     * GetAllRows function
     * Returns all rows from the Select query
     * @return [array]
     */
    public function GetAllRows()
    {
        $dbo = $this->db->GetDBConnection();        
        $stmt = $dbo->prepare($this->select);
        $result = $stmt->execute($this->select_params);
        if ($result==false)
        {
            return $dbo->errorCode();
        }
        return $stmt->FetchAll();
    }

    public function GetSelect()
    {
        var_dump($this->select_params);
        echo $this->select;
    }
    public function getSQL()
    {
        echo $this->sql;
    }

}

?>