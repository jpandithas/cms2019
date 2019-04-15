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
    public function __construct($name, $action="", $method="post"){
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
     * @param boolean $is_disabled
     * @return void
     */
    public function webform_textbox($display_text, $varname, $prefill_value=null, $placeholder_hint=null, $is_required=FALSE, $is_disabled=false){
        $this->formdata.="<div class='field-row'>";
        $this->formdata.="<div class='col-30'>"; 
        $this->formdata.="<label for={$varname}> {$display_text} </label>";
        $this->formdata.="</div>";
        $this->formdata.="<div class='col-70'>";
        
        $this->formdata.="<input type='text' name='{$varname}' value='{$prefill_value}'";
        if (!empty($placeholder_hint)) {$this->formdata.=" placeholder='{$placeholder_hint}' ";}
        if ($is_required) {$this->formdata.=" required='required' ";}
        if ($is_disabled) {$this->formdata.= " disabled ";}
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
     * @param array $select_visible_options
     * @param array $select_values
     * @param boolean $is_disabled
     * @return void
     */
    public function webform_option_menu($display_text, $varname, Array $select_visible_options, Array $select_values, $is_required=False, $is_disabled=false){
        /**
         * checks the options if they match and sync them
         */
        if ((count($select_values)==0)  or (count($select_visible_options) != count($select_values))){
            $select_values = $select_visible_options; 
        }
        $this->formdata.= "<div class='field-row'>";
        $this->formdata.= "<div class='col-30'>"; 
        $this->formdata.= "<label for={$varname}> {$display_text} </label>";
        $this->formdata.= "</div>"; 
        $this->formdata.="<div class='col-70'>";
        $this->formdata.= "<select name = {$varname}";
        if ($is_required) {$this->formdata.=" required='required' ";}
        if ($is_disabled) {$this->formdata.= " disabled ";}
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
     * Inserts a Textarea in the form
     *
     * @param string $display_text
     * @param int $rows
     * @param int $cols
     * @param string $varname
     * @param string $prefill_value
     * @param string $placeholder
     * @param boolean $is_required
     * @param boolean $is_disabled
     * @return void
     */
    public function webform_textarea($display_text, $rows, $cols, $varname, $prefill_value, $placeholder=null, $is_required=false, $is_disabled=false){
        $this->formdata.= "<div class='field-row'>";
        $this->formdata.= "<div class='col-30'>"; 
        $this->formdata.= "<label for={$varname}> {$display_text} </label>";
        $this->formdata.= "</div>"; 
        $this->formdata.="<div class='col-70'>";

        $this->formdata.= "<textarea name={$varname} rows={$rows} cols={$cols}";
        if (!empty($placeholder)){$this->formdata.="placeholder={$placeholder}";}
        if ($is_required){$this->formdata.=" required='required' ";}
        if ($is_disabled) {$this->formdata.= " disabled ";}
        $this->formdata.= "> {$prefill_value} </textarea>";

        $this->formdata.= "</div>"; 
        $this->formdata.= "</div>"; 
        $this->formvars[$varname] = $varname;
    }

    /**
     * Adds a responsive checkbox to the webform
     *
     * @param string $varname
     * @param string $option_name
     * @param boolean $is_checked
     * @param boolean $is_required
     * @param boolean $is_disabled
     * @return void
     */
    public function weform_checkbox($varname, $option_name, $is_checked=False, $is_required=False, $is_disabled=false){
        $this->formdata.= "<div class='col-30'>"; 
        $this->formdata.= "</div>"; 
        $this->formdata.="<div class='col-70'>";
        $this->formdata.= "<input type='checkbox' name={$varname} class='form-checkbox'";
        if ($is_checked) {$this->formdata.= " checked='checked' ";}
        if ($is_required) {$this->formdata.= " required ='required'";}
        if ($is_disabled) {$this->formdata.= " disabled ";}
        $this->formdata.= ">"; 
        $this->formdata.= "<label for='checkbox'>{$option_name}</label>";
        $this->formdata.= "</div>";
    }

    /**
     * Adds an inline checkbox to the form
     *
     * @param string $varname
     * @param string $option_name
     * @param boolean $is_checked
     * @param boolean $is_required
     * @param boolean $is_disabled
     * @return void
     */
    public function webform_checkbox_inline($varname, $option_name, $is_checked=False, $is_required=False, $is_disabled=false)
    {
        $this->formdata.= "<input type='checkbox' name={$varname} class='form-checkbox'";
        if ($is_checked) {$this->formdata.= " checked='checked' ";}
        if ($is_required) {$this->formdata.= " required ='required'";}
        if ($is_disabled) {$this->formdata.= " disabled ";}
        $this->formdata.= ">"; 
        $this->formdata.= "<label for='checkbox'>{$option_name}</label>";
    }



    /**
     * Adds a Field Row to Group CheckBoxes and Radio Button.
     * Use The webform_add_fieldrow_end() to close it
     *
     * @return void
     */
    public function webform_add_fieldrow_start()
    {
        $this->formdata.= "<div class='field-row'>";
    }

    /**
     * Adds a Field Row END to Group CheckBoxes and Radio Button.
     * Follows a webform_add_fieldrow_start() to close it
     *
     * @return void
     */
    public function webform_add_fieldrow_end()
    {
        $this->formdata.= "</div>";
    }

     /**
     * Adds text to the Webform
     *
     * @param string $text
     * @return void
     */
    public function webform_add_text_row($text, $separator=False){
        $this->formdata.= "<div class='field-row ";
        if ($separator) {$this->formdata.=" form-separator";}
        $this->formdata.= "'>";
        $this->formdata.= $text;
        $this->formdata.= "</div>"; 
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