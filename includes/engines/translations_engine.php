<?php 

function tt($text){
    return Language::translate($text); 
}


function tt_register(array $strings){
    if (empty($GLOBALS['strings'])){
        $GLOBALS['strings'] = $strings;
    } else {
        $newarr= array_merge($GLOBALS['strings'], $strings); 
        $GLOBALS['strings']=$newarr;
    }
}



?>