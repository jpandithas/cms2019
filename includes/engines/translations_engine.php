<?php 

function tt($text){
    return Language::translate($text); 
}

function tt_register(array $strings){
    if (empty($GLOBALS['strings'])){
        $GLOBALS['strings'] = $strings;
    } else {
        array_push($GLOBALS['strings'], $strings); 
    }
}



?>