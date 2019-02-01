<?php

class Security
{
    /* Santitizes a string
    * @input: String
    * @returns: Mixed | Boolean for Fail, Stripped Text for Success
    */
    public static function SanitizeString($string)
    {
        if (empty($string) or (!is_string($string))) return false;

        return strip_tags($string);
    }
}

?>