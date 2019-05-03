<?php 
/**
 * Login Function for the Login Module
 *
 * @return void
 */
function Login()
{
    include('login.lang.php'); 

    Append_Title(tt("Login"));
    Append_Content("<h2> ".tt('Login Page')." </h2>"); 

    if (isset($_POST['submit']) and ($_POST['submit']==tt('Login')))
    {
        
        if (empty($_POST['username']) or empty($_POST['password'])){
            Append_Content("<h4 class='error-bar'> ".tt('Login Failed')." </h4>");
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

            $query->Table('user');
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
            Append_Content("<h4 class='error-bar'> &#9888; ".tt('Login Failed')." </h4>");          
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
    
    $form = new Webform("login-form"); 
    $form->webform_textbox(tt("Username"),"username",null,tt('Enter your username hare..'),true);
    $form->webform_password_textbox(tt("Password"),"password",tt('Enter your password here..'),TRUE); 
    $form->webform_submit_button(tt('Login')); 
    $form_warp_end = "</div>";
    return $form->webform_getForm(); 
}



?>