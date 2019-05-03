<?php 
/**
 * Translations Engine
 */

/**
 * Translate Text
 *
 * @param string $text
 * @return string
 */
function tt($text){
    return Language::translate($text); 
}

/**
 * Register Translated Text Array
 *
 * @param array $strings
 * @return void
 */
function tt_register(array $strings){
    if (empty($GLOBALS['strings'])){
        $GLOBALS['strings'] = $strings;
    } else {
        $newarr= array_merge($GLOBALS['strings'], $strings); 
        $GLOBALS['strings']=$newarr;
    }
}



?>