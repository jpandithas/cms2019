<?php 
/**
 * Login Function for the Login Module
 *
 * @return void
 */
function Login()
{
    Append_Title("Login");
    Append_Content("<h2> Login Page </h2>"); 

    if (isset($_POST['submit']) and ($_POST['submit']=='Login'))
    {
        
        if (empty($_POST['username']) or empty($_POST['password'])){
            Append_Content("<h4 class='error-bar'> Login Failed </h4>");
            Append_Content(login_form()); 
            return FALSE; 
        }
        $username = Security::SanitizeString($_POST['username']);
        $password = Security::SanitizeString($_POST['password']); 
        $uid = Security::Authenticate($username,$password);
    
        if ($uid){
            session_regenerate_id("TRUE");
            $_SESSION['username'] = $username; 
            
            $query = new Query(new DB()); 
            $query->SetTableName('user');
            $query->Select(['role']);
            $query->Where(['uid','=',$uid]);
            $query->Limit(1); 
            $query->Run(); 
            $result = $query->GetReturnedRows();
            
            $_SESSION['role'] = $result[0]['role'];

            $url = new URL();
            $url->InternalRedirect('home'); 
        }
        else 
        {
            Append_Content("<h4 class='error-bar'> &#9888; Login Failed </h4>");          
        }
    }

    Append_Content(login_form()); 
}


/**
 * Login Form
 *
 * @return string
 */

function login_form(){
    
    $form = new Webform("","post","login-form"); 
    $form->webform_textbox("Username","username",null,"Enter your username hare..",true);
    $form->webform_password_textbox("Password","password","Enter your password here..",TRUE); 
    $form->webform_submit_button("Login"); 
    $form_warp_end = "</div>";
    return $form->webform_getForm(); 
}



?>