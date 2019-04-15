<?php

function add_user()
{
    Append_Title("Add User"); 
    Append_Content("<h2> Add User </h2>");
    $form_errors= array(); 

    if (isset($_POST['submit']) and ($_POST['submit']=='Add User')){
        if (empty($_POST['username']) or empty($_POST['password1']) or empty('passowrd2')){    
            $form_errors[]="There were empty fields in the form";
        }

        $query = new Query(new DB()); 
        $query->SetTableName("user"); 
        $query->Select(['uid']); 
        $query->Where(['username','=',$_POST['username']]); 
        $query->Run(); 
        $result = $query->GetReturnedRows();
        $query=null; 

        if ($result){
            $form_errors[]="User <i>".$_POST['username']."</i> Exists";
        }
        
        if (strlen($_POST['password1'])<7){
            $form_errors[]="Password is less than 6 characters long"; 
        }
        if ($_POST['password1']!=$_POST['password2']){
            $form_errors[]="Passwords do not match!";
        }

        if (count($form_errors)>0){ 
            $html="<h4 class='error-bar'>There were errors with the form:";
            $html.="<ul>";
            foreach ($form_errors as $error){
                $html.="<li>{$error}</li>";
            }
            $html.="</ul>"; 
            $html.="</h4>"; 
            Append_Content($html); 
            Append_Content(Add_User_Form());
            return false; 
        }

        Append_Content("<h4 class='success-bar'>Operation Successful!</h4>"); 
        Append_Content("<h4 class='info-bar'>User <i>".$_POST['username']."</i> was added Successfully!</h4>");
    }
    Append_Content(Add_User_Form()); 

}

function Add_User_Form()
{
    $form = new Webform("add_user_form");
    $form->webform_textbox("Username","username",null,"Enter a username..",true); 
    $form->webform_password_textbox("Password","password1","Enter a password (6 characters minimum) ...",True); 
    $form->webform_password_textbox("Retype Password","password2","Type the password again..",true); 
    
    $query = new Query(new DB()); 
    $query->SetTableName("roles"); 
    $query->Select(['role_display_name','roleid']); 
    $query->Run(); 
    $result = $query->GetReturnedRows();
    
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