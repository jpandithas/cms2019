<?php 


function Logo()
{
    print("Logo");
}

function Site_Name()
{
    print("MY SITE");
}

function Page_Title()
{
    print(Site_Name()." | Title"); 
}

function Head_Navigation()
{
    print("HEAD NAVI"); 
}

function Side_Navi()
{
    print("SIDE NAVI"); 
}

function Main_Navi()
{
    print("MAIN NAVI");
}

function Footer_Info()
{
    print("FOOTER INFO"); 
}

function Footer_Navi()
{
    print("FOOTER NAVI"); 
}

function Content()
{
   if (empty($GLOBALS['content']) or !isset($GLOBALS['content']))
   {
       $GLOBALS['content'] = "No Content";
   }
    print($GLOBALS['content']); 
}

function Append_Content($content)
{
    if (!isset($GLOBALS['content']))
    {
        $GLOBALS['content'] = ""; 
    }
    $GLOBALS['content'] .= $content; 
}

function Append_Title($title)
{
    # code...
}

?>