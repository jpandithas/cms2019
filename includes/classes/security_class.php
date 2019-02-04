<?php

class Security
{
    /**
     * SanitizeString function
     *
     * @param [string] $string
     * @return mixed 
     */
    public static function SanitizeString($string)
    {
        if (empty($string) or (!is_string($string))) return false;

        return strip_tags($string);
    }
}

?>