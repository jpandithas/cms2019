<?php 


function Logo()
{
    print("Logo");
}

function Site_Name()
{
    $query = new Query(new DB());
    $query->SetTableName('variables');
    $query->Select(['value']); 
    $query->Where(['name','=','site_name']); 
    $query->Limit(1);
    $query->Run(); 

     
    $result = $query->GetReturnedRows();
    print($result[0]['value']); 
    $query = null; 
}

function Page_Title()
{
    
    $title = Site_Name(); 
    if (isset($GLOBALS['page_title'])){
        $title.=" | ".$GLOBALS['page_title']; 
    }
    print $title; 
}

function Head_Navigation()
{
    print("<a href=".CMS_BASE_URL."?q=home> Home </a>" ); 
}

function Side_Navi()
{
    print("SIDE NAVI"); 
    
}

function Main_Navi()
{
    Main_Navigation::GreetUser(); 
    Main_Navigation::Render_Menu(); 
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
    $GLOBALS['page_title'] = $title; 
}

?>