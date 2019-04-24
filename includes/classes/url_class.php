<?php

class URL 
{

    protected $locale; 
    protected $action;
    protected $type;
    protected $id;
    protected $url_component_array = array();

    public function __construct()
    {
        $this->ReadGET(); 
    }

    /**
     * ReadGet() Reads the $_GET[q] from the URL
     *
     * @return void
     */
    protected function ReadGET()
    {
        if (!empty($_GET['q']))
        {
            $this->ProcessURL($_GET['q']);
        }
        return $this;
    }


    /**
     * Processes the URL and updates the URL class 
     *
     * @param string $url
     * @return URL
     */
    protected function ProcessURL($url)
    {
        if (!is_string($url)) return false; 
    
        $url_array = explode("/",strip_tags($url),4);
        
        if (LOCALES_ENABLED){
            if (!empty($url_array[0])) 
            {
                $lang_array= Language::GetLocalesArray(); 
            
                #find if the first part of the path contains the language
                $lang_found= false;
                foreach ($lang_array as $lang) {
                    if (strtolower($url_array[0])==$lang['lang_descriptor']){
                        $lang_found= $lang['lang_descriptor'];
                    }
                }
                #if it does se the locale variables and the SESSION
                if ($lang_found){
                    $this->locale= $lang_found;
                    $this->url_component_array['locale']= $lang_found;
                    $_SESSION['locale']= $lang_found;
                } else {
                    #if not it may be an action/type path, 
                    #push the language path prefix to the array 
                    if (empty($_SESSION['locale'])) {
                        $language= Language::GetDefaultLang();
                    } else {
                        $language= Language::GetCurrentLocale(); 
                    }
                    $updated_url_array= array_merge(array($language),$url_array);
                    $url_array= $updated_url_array;
                }
                #if the $url_array is empty then set the locale according to SESSION
            } else {
                if (empty($_SESSION['locale'])){
                    $_SESSION['locale']= Language::GetDefaultLang();
                    $this->locale= Language::GetCurrentLocale(); 
                    array_unshift($url_array, Language::GetCurrentLocale()); 
                    $this->url_component_array['locale']= Language::GetCurrentLocale(); 
                } else {
                    $this->locale= Language::GetCurrentLocale();
                    $this->url_component_array['locale']= Language::GetCurrentLocale();
                }
            }
            if (!empty($url_array[1])) 
            {
                $this->action = $url_array[1];
                $this->url_component_array['action'] = $url_array[1];
            }
            if (!empty($url_array[2])) 
            {
                $this->type = $url_array[2];
                $this->url_component_array['type'] = $url_array[2];
            }
            if (!empty($url_array[3]) and is_numeric($url_array[3]))
            {
                $this->id = $url_array[3];
                $this->url_component_array['id'] = $url_array[3];
            }
        } else {
            if (!empty($url_array[0])) 
            {
                $this->action = $url_array[0];
                $this->url_component_array['action'] = $url_array[0];
            }
            if (!empty($url_array[1])) 
            {
                $this->type = $url_array[1];
                $this->url_component_array['type'] = $url_array[1];
            }

            if (!empty($url_array[2]) and is_numeric($url_array[2]))
            {
                $this->id = $url_array[2];
                $this->url_component_array['id'] = $url_array[2];
            }
        }
 
            return $this;
    }

   /**
    * Converts a URL to a string path
    *
    * @param string $locale
    * @return string|false 
    */
    public function URLtoPath($locale=null)
    {
        if (is_array($this->url_component_array) and count($this->url_component_array)>0)
        {
            $url= null;

            if (LOCALES_ENABLED and $locale==null) {$url.= $this->url_component_array['locale']."/";}
            if (LOCALES_ENABLED and Language::LocaleExists(strtolower($locale))) {
                $url.= strtolower($locale)."/";
            }

            $url.= $this->url_component_array['action'];

            if(!empty($this->url_component_array['type']))
            {
                $url.="/".$this->url_component_array['type'];
            }
            if(!empty($this->url_component_array['id']))
            {
                $url.="/".$this->url_component_array['id'];
            }
            return $url;   
        }
        return false; 
    }


    /**
     * Returns the url components into array format
     *
     * @return array
     */
    public function GetURLArray()
    {
        return $this->url_component_array; 
    }

    /**
     * Returns the URI of the current URL status
     *
     * @return string
     */
    public function GetCurrentURI()
    {
        $uri = CMS_BASE_URL;
        if (is_array($this->url_component_array) and count($this->url_component_array)>0)
        {
            $uri.= "?q=".$this->URLtoPath();
        }
        return $uri; 
    }

    /**
     * Sets the current URL
     *
     * @param string $url_path
     * @return void
     */
    public function SetURL($url_path)
    {
        if (empty($url_path)) return false; 
        $url_components = explode("/",$url_path);
        $this->ProcessURL($url_path);
        return $this;
    }

    /**
     * Redirects the System internally
     *
     * @param string $path
     * @return void
     */
    public function InternalRedirect($path = null)
    {
        if (empty($path)){
            $path= "Location:".CMS_BASE_URL."?q=".$this->URLtoPath();
            var_dump($path); 
            header($path);
            return true;
        }
        else 
        {
            if (LOCALES_ENABLED) {
                $path_pref= Language::GetCurrentLocale()."/";
            } else {
                $path_pref=null;
            }
            $path= "Location:".CMS_BASE_URL."?q=".$path_pref.$path;
            var_dump($path); 
            header($path);
            return true;
        }
    }

}

?>