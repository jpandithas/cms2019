<?php
/**
 * Webform Builder class
 */
class Webform
{
    protected $formdata;
    protected $formvars = array();
    /**
     * Class Webform
     *
     * @param string $action
     * @param string] $method
     * @param string $name
     */
    public function __construct($action="", $method="post", $name)
    {
        if (strtolower($method)!="post" or strtolower($method)!="get") {$method="post";}

        $this->formdata = "<div class=form-container>"; 
        $this->formdata .= "<form name = '$name' action = '$action' method = '$method'> ";
    }
    
    /**
     * Insert a Text Field in the Webform
     *
     * @param string $display_text
     * @param string $varname
     * @param string $prefill_value
     * @param string $placeholder_hint
     * @param boolean $is_required
     * @return void
     */
    public function webform_textbox($display_text, $varname, $prefill_value=null, $placeholder_hint=null, $is_required=FALSE){
        $this->formdata.="<div class='field-row'>";
        $this->formdata.="<div class='col-30'>"; 
        $this->formdata.="<label for={$varname}> {$display_text} </label>";
        $this->formdata.="</div>";
        $this->formdata.="<div class='col-70'>";
        
        $this->formdata.="<input type='text' name='{$varname}' value='{$prefill_value}'";
        if (!empty($placeholder_hint)) {$this->formdata.=" placeholder='{$placeholder_hint}' ";}
        if ($is_required) {$this->formdata.=" required='required' ";}
        $this->formdata.=">"; 

        $this->formdata.="</div>"; 
        $this->formdata.="</div>"; 
        $this->formvars[$varname] = $varname;
    }
    /**
     * Insert a Password Field in the Webform
     *
     * @param string $display_text
     * @param string $varname
     * @param string $placeholder_hint
     * @param boolean $is_required
     * @return void
     */
    public function webform_password_textbox($display_text, $varname, $placeholder_hint=null, $is_required=TRUE){
        $this->formdata.="<div class='field-row'>";
        $this->formdata.="<div class='col-30'>"; 
        $this->formdata.="<label for='{$varname}'> {$display_text} </label>";
        $this->formdata.="</div>";
        $this->formdata.="<div class='col-70'>";
        
        $this->formdata.="<input type='password' name='{$varname}' ";
        if (!empty($placeholder_hint)) {$this->formdata.=" placeholder='{$placeholder_hint}' ";}
        if ($is_required) {$this->formdata.=" required='required' ";}
        $this->formdata.=">"; 

        $this->formdata.="</div>"; 
        $this->formdata.="</div>"; 
    }

    /**
     * Inserts a Submit Button to the form
     *
     * @param string $text
     * @return void 
     */
    public function webform_submit_button($text){
        $this->formdata.= "<div class='field-row'>";
        $this->formdata.= "<br><input type='submit' name='submit' value='{$text}'>";
        $this->formdata.= "</div>"; 

        $this->formvars['submit'] = $text;
    }

    /**
     * Inserts a Select Menu in the form
     *
     * @param string $display_text
     * @param string $varname
     * @param Array $select_visible_options
     * @param Array $select_values
     * @return void
     */
    public function webform_option_menu($display_text, $varname, Array $select_visible_options, Array $select_values, $is_required=False){
        /**
         * checks the options if they match and sync them
         */
        if ((count($select_values)==0)  or (count($select_visible_options) != count($select_visible_options))){
            $select_values = $select_visible_options; 
        }
        $this->formdata.= "<div class='field-row'>";
        $this->formdata.= "<div class='col-30'>"; 
        $this->formdata.= "<label for={$varname}> {$display_text} </label>";
        $this->formdata.= "</div>"; 
        $this->formdata.="<div class='col-70'>";
        $this->formdata.= "<select name = {$varname}";
        if ($is_required) {$this->formdata.=" required='required' ";}
        $this->formdata.=">";
        
        for ($key=0; $key < count($select_visible_options) ; $key++) {  
            $this->formdata.= "<option class='webform-select' value = {$select_values[$key]}>{$select_visible_options[$key]}</option>";
        }
        $this->formdata.= "</select>";
        $this->formdata.= "</div>";
        $this->formdata.= "</div>"; 
        $this->formvars[$varname] = $varname;
    }

    /**
     * Adds text to the Webform
     *
     * @param [string] $text
     * @return void
     */
    public function webform_add_text($text){
        $this->formdata.= "<div class='field-row'>";
        $this->formdata.= $text;
        $this->formdata.= "</div>"; 
    }

    /**
     * Inserts a Textarea in the form
     *
     * @param [string] $display_text
     * @param [int] $rows
     * @param [int] $cols
     * @param [string] $varname
     * @param [string] $prefill_value
     * @param [string] $placeholder
     * @param boolean $is_required
     * @return void
     */
    public function webform_textarea($display_text, $rows, $cols, $varname, $prefill_value, $placeholder=null, $is_required=false){
        $this->formdata.= "<div class='field-row'>";
        $this->formdata.= "<div class='col-30'>"; 
        $this->formdata.= "<label for={$varname}> {$display_text} </label>";
        $this->formdata.= "</div>"; 
        $this->formdata.="<div class='col-70'>";
        $this->formdata.= "<textarea name={$varname} rows={$rows} cols={$cols}";
        if (!empty($placeholder)){$this->formdata.="placeholder={$placeholder}";}
        if ($is_required){$this->formdata.=" required='required' ";}
        $this->formdata.= "> {$prefill_value} </textarea>";
        $this->formdata.= "</div>"; 
        $this->formdata.= "</div>"; 
        $this->formvars[$varname] = $varname;
    }
    
    /**
     * Renders the form as html 
     *
     * @return void
     */
    public function webform_getForm(){

        $this->formdata.="</form></div>";
        return $this->formdata;
    }
    
    public function webform_getFormVars(){
    return $this->formvars;
    }
}
?>