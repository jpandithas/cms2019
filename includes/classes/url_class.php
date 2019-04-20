<?php

class URL 
{

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

            return $this;
    }

    /**
     * Converts a URL to a string path
     *
     * @return string
     */
    public function URLtoPath()
    {
        if (is_array($this->url_component_array) and count($this->url_component_array)>0)
        {
            $url = $this->url_component_array['action'];
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
     * @return [void]
     */
    public function SetURL($url_path)
    {
        if (empty($url_path)) return false; 
        $url_components = explode("/",$url_path);
        $this->ProcessURL($url_path);
        return $this;
    }

    /**
     * Rredirects the System internally
     *
     * @param string $path
     * @return [void]
     */
    public function InternalRedirect($path = null)
    {
        if (empty($path)){
            header("Location:".CMS_BASE_URL."?q=".$this->URLtoPath());
        }
        else 
        {
            header("Location:".CMS_BASE_URL."?q=".$path);
        }
    }

}

?>