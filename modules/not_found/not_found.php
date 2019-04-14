<?php

function not_found()
{
    Append_Title("Page Not Found"); 
    Append_Content("<h1> Page Not Found! </h1>");

    Append_Content( "<br/><a href='".CMS_BASE_URL."'> Return to Home Page </a><br/>");
}

?>