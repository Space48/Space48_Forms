<?php

class Space48_Forms_Model_Process_Queue extends Space48_Forms_Model_Abstract
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
     * _construct
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init('space48_forms/process_queue');
    }
    
    /**
     * queue form and result model for later processing
     *
     * @param  Space48_Forms_Model_Form $form
     * @param  Space48_Forms_Model_Form_Result $result
     *
     * @return $this
     */
    public function queue(Space48_Forms_Model_Form $form, Space48_Forms_Model_Form_Result $result)
    {
        // try load this queue item
        // if it already exists
        $this->getResource()->loadByFormAndResult($this, $form, $result);
        
        // set form
        $this->setForm($form);
        
        // set result
        $this->setResult($result);
        
        // set initial status
        $this->setFresh();
        
        // and save
        $this->save();
        
        return $this;
    }
    
    /**
     * set form
     *
     * @param Space48_Forms_Model_Form $form
     */
    public function setForm(Space48_Forms_Model_Form $form)
    {
        // set form
        $this->_form = $form;
        
        // set form id
        $this->setFormId($form->getId());
        
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
            // get model
            $this->_form = Mage::getModel('space48_forms/form');
            
            // load model if we have id
            if ( $id = $this->getFormId() ) {
                $this->_form->load($id);
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
        
        // set result id
        $this->setResultId($result->getId());
        
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
            $this->_result = Mage::getModel('space48_forms/form_result');
            
            // load model if we have id
            if ( $id = $this->getResultId() ) {
                $this->_result->load($id);
            }
        }
        
        return $this->_result;
    }
    
    /**
     * set fresh
     */
    public function setFresh()
    {
        return $this->setStatus(Space48_Forms_Model_Source_Process_Queue_Status::STATUS_FRESH);
    }
    
    /**
     * set complete
     */
    public function setComplete()
    {
        return $this->setStatus(Space48_Forms_Model_Source_Process_Queue_Status::STATUS_COMPLETE);
    }
    
    /**
     * set status
     *
     * @param string $status
     */
    public function setStatus($status)
    {
        switch ( $status ) {
            case Space48_Forms_Model_Source_Process_Queue_Status::STATUS_FRESH:
            case Space48_Forms_Model_Source_Process_Queue_Status::STATUS_COMPLETE:
                $this->setData('status', $status);
                break;
        }
        
        // save
        $this->save();
        
        return $this;
    }
}
