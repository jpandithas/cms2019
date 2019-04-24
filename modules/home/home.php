<?php

function home()
{
   include("home.lang.php");

   Append_Title(tt('Home Page'));
   Append_Content("<h2> ".tt('Welcome')."! </h2>");
   $html = "<h3> ".tt('This is the CMS Landing page')." </h3>";
   $html .="<p> ".tt('This is a custom landing page that you can type all the intro text and code you wish')." </p>"; 

   Append_Content($html); 
}


?>