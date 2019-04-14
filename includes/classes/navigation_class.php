<?php

class Main_Navigation {

    public static function Render_Menu(){
        
        $query = new Query(new DB()); 
        $query->SetTableName("routes"); 
        $query->Select(['action','type','mod_display_name','mod_name']); 
        $query->Where(['status','=','1']);
        $query->AndClause(['visible','=','1']); 
        $query->OrderBy(['mod_display_name']); 
        $query->Run(); 

        $result = $query->GetReturnedRows(); 
        
        
        $html = "<input type='checkbox' id='menu'>";
        $html .= "<label for='menu'><b>Navigation</b></label>";
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
            $html.=">".$row['mod_display_name']."</a>";
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
            $html .= "User: ".$_SESSION['username'];
            $html .= "</h3>"; 
            print($html); 
        }
    }

}

?>
