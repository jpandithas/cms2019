<?php 

class Language
{

    /**
     * Gets the Locales Array:
     * 'lang_descriptor','lang_display_name','lang_native_name'
     *
     * @return array
     */
    public static function GetLocalesArray()
    {
        $query= new Query(new DB());
        $query->SetTableName('languages');
        $query->Select(['lang_descriptor','lang_display_name','lang_native_name']);
        $query->Where(['lang_status','=','1']);
        $query->Run(); 

        $result= $query->GetReturnedRows(); 
        $query=null;
        return $result; 
    }

    /**
     * Gets the Default Language From the Languages Table
     *
     * @return string
     */
    public static function GetDefaultLang()
    {
        $query= new Query(new DB());
        $query->SetTableName('languages');
        $query->Select(['lang_descriptor']);
        $query->Where(['lang_default','=','1']);
        $query->Limit(1);
        $query->Run(); 

        $result= $query->GetReturnedRows(); 
        $query=null;
        return $result[0]['lang_descriptor']; 
    }


    /**
     * Finds if a Language Exists
     *
     * @param string $locale
     * @return boolean
     */
    public static function LocaleExists($locale){
        if (empty($locale)) return false; 

        $query= new Query(new DB());
        $query->SetTableName('languages');
        $query->Select(['langid']); 
        $query->Where(['lang_descriptor','=',strtolower($locale)]); 
        $query->Limit(1);
        $query->Run(); 

        $result= $query->GetReturnedRows(); 

        if ($result) return true;

        return false; 
    }

    /**
     * Gets the Current Locale form $_SESSION
     *
     * @return string|false
     */
    public static function GetCurrentLocale()
    {
        if (LOCALES_ENABLED){
            if (empty($_SESSION['locale'])) {
                return self::GetDefaultLang();
            } else {
            return strtolower($_SESSION['locale']);
            } 
        }
        return false; 
    }

    public static Function translate($translated_string){

        if (!LOCALES_ENABLED and !empty($_SESSION['strings'])) return false; 

        $strings= $GLOBALS['strings']; 

        $lang= Language::GetCurrentLocale();
        foreach($strings as $string){
            foreach ($string as $lang_key=>$text){
                 if ($translated_string==$text) return ($string[$lang]);           
         }
      }
    }
}

?>