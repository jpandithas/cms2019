<?php 

function manage_permissions()
{
include('manage_permissions.lang.php'); 



Append_Title(tt("Manage Permissions")); 

$query= new Query(new DB()); 
$query->Table('roles'); 
$query->Select(['roleid','role_display_name']); 
$query->OrderBy(['roleid']); 
$query->Run(); 
$roles= $query->GetReturnedRows(); 
$query= null; 

$url = new URL(); 
$url_components= $url->GetURLArray();
Append_Content("<h2> ".tt("Manage Permissions")." </h2>"); 
Append_Content(role_selection_form($roles)); 

if (array_key_exists('id',$url_components)) {
    Append_Content("<h2> ".tt('Edit Permission')." </h2>"); 
    Append_Content(edit_permission_form($url_components['id'])); 
    Append_Content("<a class='link-button col-30' href=".CMS_BASE_URL."?q=manage/permissions> ".tt('Go Back')." </a>"); 
    return true; 
}

if (isset($_POST['submit']) and $_POST['submit']="Select Role"){
    if ($_POST['role']=='2') {
        Append_Content("<h3 class='warning-bar'>".tt('Administrators: Careful with your own permissions')."</h3>"); 
    }
    Append_Content(permissions_table($_POST['role']));
}

}

/**
 * Role Selection form
 *
 * @param array $roles
 * @return void
 */
function role_selection_form(array $roles)
{
    $form = new Webform('roles-form');
    $visible= array();
    $value= array(); 
    foreach ($roles as $role){
        $visible[]= $role['role_display_name']; 
        $value[]= $role['roleid']; 
    }
    $form->webform_option_menu(tt("Select a Role to edit Permissions for"),'role',$visible,$value);
    $form->webform_submit_button(tt("Select Role"));
    return $form->webform_getForm();  
}

/**
 * Permissions table for a role
 *
 * @param int $role
 * @return void
 */
function permissions_table($role){
    $query = new Query(new DB()); 
    $query->Table('permissions'); 
    $query->Select(['permid','routeid','allowed']); 
    $query->Where(['roleid','=',$role]); 
    $query->OrderBy(['roleid']);
    $query->Run(); 
    $permissions= $query->GetReturnedRows(); 
   // var_dump($permissions); 

    $query= new Query(new DB()); 
    $query->Table("routes"); 
    $query->Select(['routeid','mod_display_name']);
    $query->Run(); 
    $routes= $query->GetReturnedRows();
    $query= null; 
    //var_dump($routes); 

    $query= new Query(new DB()); 
    $query->Table("roles"); 
    $query->Select(['role_display_name']);
    $query->Where(['roleid','=',$role]);  
    $query->Run(); 
    $role_name= $query->GetReturnedRows();
    $query= null; 

        $table= "<table class='permissions-table' border=1>"; 
        $table.= "<thead> <tr> <th class='th-section-header' colspan=3>{$role_name[0]['role_display_name']}</th></tr>";
        $table.= "<tr> <th> ".tt('Module')." </th> <th> ".tt('Permission')." </th><th> ".tt('Action')." </th></tr> </thead>"; 
        foreach ($permissions as $permission_row){
                $table.="<tr>"; 
               foreach ($routes as $route_row){
                    if ($permission_row['routeid']==$route_row['routeid']){
                        $module_name = $route_row['mod_display_name'];
                    } 
                }
                $table.= "<td> ".tt($module_name)." </td>";
                if ($permission_row['allowed'] == '1'){
                    $text = "<span class='green'>".tt('Allowed')."</span>"; 
                } else {
                $text="<span class='red'>".tt('Denied')."</span>"; 
                }
                $table.= "<td>{$text}</td>";
                $button= "<a class='link-button full' href=".CMS_BASE_URL."?q=manage/permissions/".$permission_row['permid'].">";
                $button.= tt('Change')." </a>"; 
                $table.= "<td>{$button}</td>";
                $table.= "</tr>";
            
        }
    $table.= "</table>"; 

    return $table;
}

/**
 * Edit Permission form
 *
 * @param int $id
 * @return void
 */
function edit_permission_form($id)
{

    $query= new Query(new DB()); 
    $query->Table("permissions"); 
    $query->Select(['roleid','routeid','allowed']);
    $query->Where(['permid','=',$id]); 
    $query->Run(); 
    $result= $query->GetReturnedRows();
    $query= null; 
    $permissions= $result[0]; 
 
    $form= new Webform('edit-permissions-form'); 
    $query= new Query(new DB()); 
    $query->Table('roles'); 
    $query->Select(['role_display_name']); 
    $query->Where(['roleid','=',$permissions['roleid']]);
    $query->Run(); 
    $result= $query->GetReturnedRows(); 
    $role_name = $result[0]['role_display_name'];

    $form->webform_textbox(tt("Role"),'role',$role_name,null,false,true);

    $query= new Query(new DB()); 
    $query->Table('routes'); 
    $query->Select(['mod_display_name']); 
    $query->Where(['routeid','=',$permissions['routeid']]);
    $query->Run(); 
    $result= $query->GetReturnedRows(); 
    $mod_name = $result[0]['mod_display_name'];

    $form->webform_textbox(tt("Module"),'module',tt($mod_name),null,false,true);

    if ($permissions['allowed'] == '1') {
        $visible= [tt('Allowed'),tt('Denied')];
        $select= ['1','0'];
    } else {
        $visible= [tt('Denied'),tt('Allowed')];
        $select= ['0','1'];
    }
    $form->webform_option_menu(tt("Set Permission"),'allowed',$visible,$select,true); 
    $form->webform_submit_button(tt("Apply")); 
    return $form->webform_getForm(); 
}

?>