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
       
        $query->Select(['lang_descriptor','lang_display_name','lang_native_name']);
        $query->From('languages');
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
        $query->Select(['lang_descriptor']);
        $query->From('languages');
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
        $query->From('languages');
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



    public static Function translate($string_to_translate)
    {
        if (!LOCALES_ENABLED ) return false; 

        $strings= $GLOBALS['strings'];         

        $lang= Language::GetCurrentLocale();
        foreach($strings as $string){
            foreach ($string as $lang_key=>$text){
                 if ($string_to_translate==$text) return ($string[$lang]);           
         }
      }
    }

    public static function GetModuleTranslations(){
        $query= new Query(new DB()); 
        $query->From('module_translations'); 
        $query->Select(['module_translations.routeid', 
                        'module_translations.mod_display_name',
                        'module_translations.lang', 
                        'routes.mod_display_name']); 
        $query->Inner_Join('routes');
        $query->ON_(['routes.routeid','=','module_translations.routeid']);
        $query->Run();

        $result= $query->GetReturnedRows();
        $mods_strings= array();

        foreach ($result as $row){
            $mods_strings[]=['en'=>$row['mod_display_name'],$row['lang']=>$row[1]];
        }
        
        return $mods_strings; 
        
    }

}

?>