<?php

function add_user()
{
    Append_Content("<h2> Add User </h2>");

    Append_Content( Add_User_Form()); 

}

function Add_User_Form()
{
    $form = new Webform("","POST","add_user_form");
    $form->webform_textbox("Username","username",null,"Enter a username..",true); 
    $form->webform_password_textbox("Password","password1","Enter a password...",True); 
    $form->webform_password_textbox("Retype Password","password2","Type the password again..",true); 
    
    $query = new Query(new DB()); 
    $query->SetTableName("roles"); 
    $query->Select(['role_display_name','roleid']); 
    $query->Run(); 
    $result = $query->GetReturnedRows();
    
    //var_dump($result);  
    $roles_array = array(); 
    $roles_values = array(); 
    foreach ($result as $row){
        $roles_array[] = $row['role_display_name'];
        $roles_values[] = $row['roleid']; 
    }
  
    
    $form->webform_option_menu("User Role","role",$roles_array,$roles_values); 
    $form->webform_submit_button("Add User"); 

    return $form->webform_getForm();  
}

?>