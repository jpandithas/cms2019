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
            Append_Content("<h3> Login Failed </h3>");
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
            $query->Select(['userlevel']);
            $query->Where(['uid','=',$uid]);
            $query->Limit(1); 
            $query->Run(); 
            $result = $query->GetReturnedRows();
            
            $_SESSION['userlevel'] = $result[0]['userlevel'];

            $url = new URL();
            $url->InternalRedirect('home'); 
        }
        else 
        {
            Append_Content("<h3> Login Failed </h3>");          
        }
    }

    Append_Content(login_form()); 
}


/**
 * Login Form
 *
 * @return [string]
 */
function login_form()
{
    $form  = "<form name='login' id='login-form' action='' method='post'>";
    $form .= "<table>";
    $form .= "<tr> <td> Username </td><td><input type='text' name='username' required='required'></td></tr>";
    $form .= "<tr> <td> Password </td><td><input type='password' name='password' required='required'></td></tr>";
    $form .= "<tr><td colspan='2'><input type='submit' name='submit' value='Login'></td></tr>";
    $form .= "</table>";
    $form .= "</form>";
    return $form;
}

?>