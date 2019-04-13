<?php

function denied()
{
    Append_Content("<h2> Access Denied </h2>");
    
    Append_Content( "<br/><a href='".CMS_BASE_URL."'> Return to Home Page </a><br/>");
}

?>