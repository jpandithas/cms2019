<?php 

function admin_topnav()
{
    Append_Title("Administer Top Navigation Links"); 

    Append_Content("Administer Top Navigation Links"); 

}

function Show_links_table()
{
    $query = new Query(new DB()); 
    $query->Table("topnav"); 
    $query->Select(['linkid','link_path','link_text','weight']); 
    $query->OrderBy(['weight']); 
    $query->Run(); 
    $result= $query->GetReturnedRows();

    
    
    $rows = $result[0]; 
        
}

?>