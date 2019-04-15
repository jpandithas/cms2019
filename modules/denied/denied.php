<?php

function denied()
{
    Append_Title("Access Denied"); 
    Append_Content("<h2 class='error-bar'> Access Denied </h2>");
    Append_Content("<p>You need to login and have sufficient privileges to view this content.</p>");
    Append_Content("<br/><a href='".CMS_BASE_URL."'> Return to Home Page </a><br/>");
}

?>