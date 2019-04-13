<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php Page_Title();?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="themes\default\default.css">
    <link rel="stylesheet" type="text/css" media="screen" href="themes\default\forms.css">
</head>
<body>
    <div id="site-wrapper" class="site">
        <div id="header-wrapper">      
                <div id="logo"><?php Logo();?></div>
                <div id="site-name"><h1><?php Site_Name();?></h1></div>
                <div id="head-navi"><?php Head_Navigation();?></div>
        </div>
        <div id="content-wrapper" >
                <div id="sidebar-left"><?php Main_Navi();?> </div>
                <div id="content-main" ><?php Content();?>  </div>
        </div>
        <div id="footer-wrapper">
            <div id="footer-inner-left"><?php Footer_Navi();?></div>
            <div id="footer-inner-bottom"><?php Footer_Info();?></div>
        </div>
</div>
</body>
</html>