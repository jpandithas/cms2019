<?php

class URL 
{

    protected $action;
    protected $type;
    protected $id;
    protected $url_component_array;


    public function __construct()
    {
        $this->ReadGET(); 
    }

    protected function ReadGET()
    {
        if (!empty($_GET['q']))
        {
            $url_array = explode("/",$_GET['q'],4);
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
            if (!empty($url_array[2])) 
            {
                $this->id = $url_array[2];
                $this->url_component_array['id'] = $url_array[2];
            }
        }
    }

    public function URLToString()
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

    public function GetURLArray()
    {
        return $this->url_component_array; 
    }

    public function GetCurrentURI()
    {
        $uri = CMS_BASE_URL;
        if (is_array($this->url_component_array) and count($this->url_component_array)>0)
        {
            $uri.= "?q=".$this->URLToString();
        }
        return $uri; 
    }

}

?>