<?php

/**
 * Query class
 * PDO Wrapper that provides QoL for small/medium queries
 * 
 * TODO: HAVING clause, GROUP BY (count) ,JOIN
 * 
 */
class Query
{

    /**
     * table variable
     *
     * @var string
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

    public function __destruct()
    {
        $this->db= null; 
    }
    
    /**
     * Set the target table for the queries 
     *
     * @param string $table_name
     * @return Query
     */
    public function From($table_name)
    {
        if (!is_string($table_name)) return false; 
        $this->table = $table_name;
        return $this;
    }

    /**
     * Into Function (Alias of: 'From' Function)
     *
     * @see From Function
     * @param string $table_name
     * @return Query
     */
    public function Into_Table($table_name){
       
        return $this->From($table_name); 
    }

    /**
     * Table Function (Alias of: 'From' Function)
     *
     * @param string  $table_name
     * @return Query
     */
    public function Table($table_name)
    {
        return $this->From($table_name); 
    }
    /**
     * Insert SQL statement 
     *
     * @param array $values
     * @return integer 
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
    * Update SQL statemet wrapper
    *
    * @param array $fields_values
    * @return Query
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
     * Delete SQL statement 
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
     * Select SQL statement
     *
     * @param array $fields_array
     *
     * @return Query
     */
    public function Select(array $fields_array)
    {
        if (!is_array($fields_array) or count($fields_array)==0) return false;
        
        $this->params = array();
        $this->sql = "SELECT ";
        $count = 0;
        foreach ($fields_array as $field) 
        {
            $this->sql.= $field;
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
     * Where Clause for the Queries
     *
     * @param array $where_clause
     *
     * @return Query
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
     * And Clause for the Queries.
     * Input is given via an Array
     *
     * @param array $clause
     *
     * @return Query
     */
    public function AND_(array $clause)
    {
        if (!is_array($clause) or count($clause) != 3) return false;
        if (!isset($this->sql)) return false;
        $this->sql .=" AND {$clause[0]} {$clause[1]} ?";
        array_push($this->params,$clause[2]);
        return $this;
    }

    /**
     * Or Clause for the queries 
     * 
     * @param array $clause
     * @return Query
     */
    public function OR_(array $clause)
    {
        if (!is_array($clause) or count($clause) != 3) return false;
        if (!isset($this->sql)) return false;
        $this->sql .=" OR {$clause[0]} {$clause[1]} ?";
        array_push($this->params,$clause[2]);
        return $this;
    }

    /**
     * Limit Clause for the queries
     *
     * @param integer $rows
     * @param integer $offset
     *
     * @return Query
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
     * OrderBy Clause for the queries
     *
     * @param array $fields
     * @param string $order
     * @return Query
     */
    public function OrderBy(array $fields, $order="ASC")
    {
       if (empty($fields) or !is_array($fields)) return false;
       if (!in_array(strtoupper($order),array("ASC","DESC"))) return false;
       if (!isset($this->sql)) return false;
       $this->sql .= " ORDER BY ";
        $count = 0;
        foreach ($fields as $field) 
        {
            $this->sql .= $field;
            if ($count < count($fields)-1)
            {
                $this->sql.=",";
            }   
            $count++; 
        }
         $this->sql.= " ".strtoupper($order);
        return $this;
    }

    /**
     * Inner Join *Requires an ON Clause
     *
     * @param string $table
     * @return Query
     */
    public function Inner_Join($table){
        if(empty($table) or !is_string($table) ) return false; 
        if(!isset($this->sql)) return false; 

        $this->sql.= " INNER JOIN `{$table}` ";
        return $this; 
    }

    /**
     * ON Clause for JOINs
     *
     * @param array $expression
     * @return void
     */
    public function ON_(array $expression)
    {
        if (!is_array($expression) or count($expression)==0) return false;
        if (count($expression) != 3) return false;
        if (!isset($this->sql)) return false;

        $this->sql .= " ON ".$expression[0]." ".$expression[1]." ".$expression[2];
        return $this;
    }

    /**
     * Runs the Query and updates the class members
     * 
     * @return Query
     */
    public function Run()
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
     * Return the error code if a query fails
     *
     * @return string | false
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
     * Get LastInsert ID if an insert is issued
     *
     * @return integer|false
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
     * Get Returned Rows from a SELECT query
     *
     * @return array|false
     */
    public function GetReturnedRows()
    {
        if (!isset($this->returned_rows))
        {    
            return false;
        }
        return $this->returned_rows;
    }

    /**
     * return the SQL code for the query issued
     *
     * @return string
     */
    public function getSQL()
    {
        echo $this->sql;
        var_dump($this->params);
    }

}

?>