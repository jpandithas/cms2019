<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php Page_Title();?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
</head>
<body>
    <div id="site-wrapper" class="site">
        <div id="header-wrapper">
            <div id="header-inner">
                <div id="logo"><?php Logo();?></div>
                <div id="site-name"><?php Site_Name();?></div>
                <div id="head-navi"><?php Head_Navigation();?></div>
            </div>
        </div>
        <div id="content-wrapper">
            <div id="content-inner">
                <div id="sidebar-left"><?php Main_Navi();?></div>
                <div id="content-main"><?php Content();?></div>
            </div>
        </div>
        <div id="footer-wrapper">
            <div id="footer-inner-left"><?php Footer_Navi();?></div>
            <div id="footer-inner-bottom"><?php Footer_Info();?></div>
        </div>
</div>
</body>
</html>