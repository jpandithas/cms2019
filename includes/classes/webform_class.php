<?php
/**
 * Webform Builder class
 */
class Webform
{
    protected $formdata;
    protected $formvars = array();
    public function __construct($action, $method, $name)
    {
        $this->formdata = "<form name = '$name' action = '$action' method = '$method'> ";
    }
    public function insert_textbox($text, $varname)
    {
        $this->formdata .= $text.": <input type='text' name=".$varname."><br>";
        $this->formvars[$varname] = $varname;
    }
    public function insert_data_textbox($text, $varname, $data)
    {
        $this->formdata .= $text.": <input type='text' name=".$varname." value=".$data."><br>";
        $this->formvars[$varname] = $varname;
    }
    public function insert_passwordbox($text, $varname)
    {
        $this->formdata .= $text.": <input type='password' name=".$varname."><br>";
        $this->formvars[$varname] = $varname;
    }
    public function insert_submit($text)
    {
        $this->formdata .= "<br><input type='submit' name='submit' value=".$text.">";
        $this->formvars['submit'] = $text;
    }
    public function insert_option($name, Array $options)
    {
        $this->formdata .= "<select name = '".$name."'>";
        foreach ($options as $tag_options)
        {
            $this->formdata .= "<option value = '".$tag_options."'>".$tag_options."</option>";
        }
        $this->formdata .= "</select>";
        $this->formvars['name'] = $name;
    }
    public function add_text($text)
    {
        $this->formdata .= $text;
    }
    public function add_textarea($text, $rows, $cols, $name, $data)
    {
        $this->formdata .= "$text <br> <textarea name='".$name."' rows='".$rows."' cols='".$cols."'> $data </textarea><br>";
        $this->formvars[$name] = $name;
    }
    public function login_form ()
    {
        $this->insert_textbox("Username ", "username");
        $this->insert_passwordbox("Password ", "password");
        $this->insert_submit("Login");
    }
    public function getForm()
    {
        return $this->formdata."</form>";
    }
    
    public function getFormVars(){
    return $this->formvars;
    }
}
?>