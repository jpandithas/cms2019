<?php 

function manage_permissions()
{

Append_Title("Manage Permissions"); 

Append_Content("<h2> Manage Permissions </h2>"); 

$query = new Query(new DB()); 
$query->SetTableName('permissions'); 
$query->Select(['DISTINCT roleid']); 
$query->OrderBy(['roleid']); 
$query->Run(); 
$roles_id= $query->GetReturnedRows(); 



}

?>