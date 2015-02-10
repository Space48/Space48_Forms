<?php

class Space48_Forms_Model_Session extends Mage_Core_Model_Session_Abstract
{
    /**
     * holds form result
     *
     * @var Space48_Forms_Model_Form_Result
     */
    protected $_formResult;
    
    /**
     * constructor
     */
    public function __construct()
    {
        $this->init('space48_forms');
    }
    
    /**
     * set form result model
     *
     * @param Space48_Forms_Model_Form_Result $result
     */
    public function setFormResult(Space48_Forms_Model_Form_Result $result)
    {
        // set form result model
        $this->_formResult = $result;
        
        // set id if we have it
        if ( $id = $result->getId() ) {
            $this->setFormResultId($id);
        }
        
        return $this;
    }
    
    /**
     * get form result model
     *
     * @return Space48_Forms_Model_Form_Result
     */
    public function getFormResult()
    {
        if ( is_null($this->_formResult) ) {
            // set form result model
            $this->_formResult = Mage::getModel('space48_forms/form_result');
            
            // if we have id, then load model
            if ( $id = $this->getFormResultId() ) {
                $this->_formResult->load($id);
            }
        }
        
        return $this->_formResult;
    }
}
