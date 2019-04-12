<?php

function add_user()
{
    Append_Content("<h2> Add User </h2>");

    Append_Content( Add_User_Form()); 

}

function Add_User_Form()
{
    $form = new Webform("","POST","add_user_form");
    $form->insert_data_textbox("Username","username",""); 
    $form->insert_passwordbox("Password","password1");
    $form->insert_passwordbox("Confirm Password", "password2"); 
    
    $query = new Query(new DB()); 
    $query->SetTableName("roles"); 
    $query->Select(['role_display_name','roleid']); 
    $query->Run(); 
    $result = $query->GetReturnedRows();
    //var_dump($result);  
    $roles_array = array(); 
    foreach ($result as $row){
        $roles_array[] = $row['role_display_name'];
    }
    var_dump($roles_array); 
    $form->insert_option("role",$roles_array); 
    $form->insert_submit("Add User"); 

    return $form->getForm(); 
}

?>