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
        $this->sql.= str_repeat("?, ",($size-1))." ?";
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

    public function UpdateWithId(array $id_cond_array, array $cols, array $values)
    {
        if (!is_array($values) or count($values)==0) return false;
        if (count($cols)>0 and (count($cols) != count($values))) return false; 
        $this->sql = "UPDATE `".$this->table."` SET "; 
        foreach ($cols as $key => $field) {
            $this->sql .= $field; 
            if ($key < (count($cols)-1))
            {
                $this->sql.=" = ?, ";
            }
            else 
            {
                $this->sql.=" ? ";
            }
        }
        $this->sql .= "WHERE ".$id_cond_array[0]." = ? ";
        array_push($values,$id_cond_array[1]); 
        
    }

    public function DeleteWithId(array $condition)
    {
        if (!is_array($condition) or count($condition)==0) return false;
        $this->sql = "DELETE FROM `".$this->table."` WHERE ".$condition[0].$condition[1]." ? "; 
        $params = array($condition[2]);
    }

    public function getSQL()
    {
        echo $this->sql;
    }

}

?>