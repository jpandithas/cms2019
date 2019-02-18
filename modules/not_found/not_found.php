<?php

function not_found()
{
    print("<h1> Page Not Found! </h1>");

    $home = "<br/><a href='".CMS_BASE_URL."'> Home </a><br/>";
    print($home); 
}

?>