<?php

class Space48_Forms_Model_Form_Result_Fieldset_Field_ValidationTransport
{
    /**
     * an array holds errors
     *
     * @var array
     */
    protected $_errors = array();
    
    /**
     * add error
     */
    public function addError()
    {
        $args  = func_get_args();
        $error = call_user_func_array(array($this->helper(), '__'), $args);
        
        // add to errors array
        $this->_errors[$error] = $error;
        
        return $this;
    }
    
    /**
     * get errors
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->_errors;
    }
    
    /**
     * is valid
     *
     * @return bool
     */
    public function isValid()
    {
        return count($this->_errors) === 0;
    }
    
    /**
     * get helper
     *
     * @return Space48_Forms_Helper_Data
     */
    public function helper()
    {
        return Mage::helper('space48_forms');
    }
}
