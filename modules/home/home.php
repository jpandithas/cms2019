<?php

function home()
{
   Append_Title("Home Page");
   Append_Content("<h2> Welcome! </h2>");
   $html = "<h3> This is the CMS Landing page </h3>";
   $html .="<p> This is a custom landing page that you can type all the intro text and code you wish </p>"; 
   Append_Content($html); 
}


?>