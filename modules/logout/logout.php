<?php 

function logout()
{
    unset($_SESSION['username']); 
    unset($_SESSION['userlevel']); 
    session_destroy(); 
    $url = new URL(); 
    $url->InternalRedirect('home'); 
}

?>