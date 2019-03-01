<?php 

class Theme
{
    /**
     * Gets the Active theme from the theme_registry
     *
     * @return [string]
     */
    public static function GetActiveTheme()
    {
        $query = new Query(new DB()); 
        $query->SetTableName("theme_registry"); 
        $query->Select(['theme_name']);
        $query->Where(['status','=','1']); 
        $query->Limit(1); 
        $query->Run();
        
        $result = $query->GetReturnedRows(); 
        
        return $result[0]['theme_name']; 
    }

    
}


?>