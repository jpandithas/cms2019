<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible">
    <title><?php Page_Title();?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="themes\default\default.css">
    <link rel="stylesheet" type="text/css" media="screen" href="themes\default\forms.css">
</head>
<body>
        <div class="header-wrapper">      
                <div class="logo"><?php Logo();?></div>
                <div class="site-name"><h1><?php Site_Name();?></h1></div>
                <div class="head-navi"><?php Head_Navigation();?></div>
        </div>
        <div class="content-wrapper" >
                <div class="sidebar-left"><?php Main_Navi();?> </div>
                <div class="content-main" ><?php Content();?>  </div>
        </div>
        <div class="footer-wrapper">
            <div class="footer-inner-left"><?php Footer_Navi();?></div>
            <div class="footer-inner-right"><?php Footer_Info();?></div>
        </div>
</body>
</html>