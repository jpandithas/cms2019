<?php

class Main_Navigation {

    public static function ShowActiveLanguage()
    {
        if (LOCALES_ENABLED==False) return False; 

        $lang_array= Language::GetLocalesArray();
        $url= new URL();

        $html="<div class='language-bar'>";
        foreach ($lang_array as $lang){
            if ($lang['lang_descriptor']==Language::GetCurrentLocale())
            {
                $class= " class='lang-current'"; 
            } else {
                $class= " class='lang'";  
            }

            $link= "<a {$class} href='".CMS_BASE_URL."?q=".$url->URLtoPath($lang['lang_descriptor'])."'>"; 
            $link.= $lang['lang_descriptor'];
            $link.= "</a>";

           $html.= $link; 
        } 
        $html.= "</div>"; 
        print($html); 
    }

    public static function Render_Menu()
    {
    
       if (LOCALES_ENABLED) tt_register(Language::GetModuleTranslations());

        $query = new Query(new DB()); 
        $query->From("routes"); 
        $query->Select(['routeid','action','type','mod_display_name','mod_name']); 
        $query->Where(['status','=','1']);
        $query->AND_(['visible','=','1']); 
        $query->OrderBy(['mod_display_name']); 
        $query->Run(); 

        $result = $query->GetReturnedRows(); 
        
        
        $html = "<input type='checkbox' id='menu'>";
        $html .= "<label for='menu'><b>".tt('Navigation')."</b></label>";
        $html .= "<div id='menu' class='collapsible'>";
        $html .= "<ul id='main-nav' class='nav'>";
        foreach ($result as $row) {
            if (Security::UserIsLoggedIn()==true and $row['action']=='login') continue;
            if (Security::UserIsLoggedIn()==false and $row['action']=='logout') continue;
            
            if (Security::UserHasPerMission($row['mod_name'])==false) continue; 
        
            $html.="<li id='nav-item' class='nav'>";
            $html.="<a class='nav-link' href=".CMS_BASE_URL."?q=".$row['action'];
            if (!empty($row['type'])) {
                $html .= "/".$row['type'];
            }
            $html.=">".tt($row['mod_display_name'])."</a>";
            $html.="</li>";
        }
        $html .= "</ul>"; 
        $html .="</div>";


        print($html); 
    }

    public static function GreetUser()
    {
        if (Security::UserIsLoggedIn())
        {
            $html = "<h3 class='sidebar-row' id='user-hello'>";
            $html .= tt("User").": ".$_SESSION['username'];
            $html .= "</h3>"; 
            print($html); 
        }
    }

}

?>
