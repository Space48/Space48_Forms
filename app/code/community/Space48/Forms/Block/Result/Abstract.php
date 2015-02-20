<?php

abstract class Space48_Forms_Block_Result_Abstract extends Mage_Core_Block_Template
{
    /**
     * holds form
     *
     * @var Space48_Forms_Model_Form
     */
    protected $_form;
    
    /**
     * holds form result
     *
     * @var Space48_Forms_Model_Form_Result
     */
    protected $_result;
    
    /**
     * set form
     *
     * @param Space48_Forms_Model_Form $form
     */
    public function setForm(Space48_Forms_Model_Form $form)
    {
        // set form
        $this->_form = $form;
        
        return $this;
    }
    
    /**
     * get form 
     *
     * @return Space48_Forms_Model_Form
     */
    public function getForm()
    {
        if ( is_null($this->_form) ) {
            $this->_form = Mage::registry('current_form');
            
            // if we do not have a model then it
            // is best to return an empty one
            if ( ! $this->_form ) {
                $this->_form = Mage::getModel('space48_forms/form');
            }
        }
        
        return $this->_form;
    }
    
    /**
     * set form result
     *
     * @param Space48_Forms_Model_Form_Result $result
     */
    public function setResult(Space48_Forms_Model_Form_Result $result)
    {
        // set result
        $this->_result = $result;
        
        return $this;
    }
    
    /**
     * get result
     *
     * @return Space48_Forms_Model_Form_Result
     */
    public function getResult()
    {
        if ( is_null($this->_result) ) {
            // get model
            $this->_result = Mage::registry('current_result');
            
            // if we do not have a model then it
            // is best to return an empty one
            if ( ! $this->_result ) {
                $this->_result = Mage::getModel('space48_forms/form_result');
            }
        }
        
        return $this->_result;
    }
}
