<?php

abstract class Space48_Troubleshoot_Controller_Adminhtml_Abstract extends Mage_Adminhtml_Controller_Action
{
    /**
     * returns whether or not "save and continue"
     * button was clicked
     *
     * @return bool
     */
    protected function _isSaveAndContinue()
    {
        return $this->getRequest()->getParam('back') == 'edit';
    }
    
    /**
     * set form data
     *
     * @param mixed $data
     */
    protected function _setFormData($data)
    {
        $this->_getSession()->setData('form_data', $data);   
        return $this;
    }
    
    /**
     * get form data
     *
     * @return mixed
     */
    protected function _getFormData()
    {
        // retrieve data
        $data = $this->_getSession()->getData('form_data');
        
        // unset data
        $this->_getSession()->setData('form_data', null);
        
        return $data;
    }
    
    /**
     * add error message
     */
    protected function _addError()
    {
        $args = func_get_args();
        $message = call_user_func_array(array($this->_helper(), '__'), $args);
        $this->_getSession()->addError($message);
        
        return $this;
    }
    
    /**
     * add success message
     */
    protected function _addSuccess()
    {
        $args = func_get_args();
        $message = call_user_func_array(array($this->_helper(), '__'), $args);
        $this->_getSession()->addSuccess($message);
        
        return $this;
    }
    
    /**
     * add notice message
     */
    protected function _addNotice()
    {
        $args = func_get_args();
        $message = call_user_func_array(array($this->_helper(), '__'), $args);
        $this->_getSession()->addNotice($message);
        
        return $this;
    }
    
    /**
     * throw exception
     *
     * @return void
     */
    protected function _exception()
    {
        $args = func_get_args();
        $message = call_user_func_array(array($this->_helper(), '__'), $args);
        Mage::throwException($message);
    }
    
    /**
     * get helper
     *
     * @return Space48_Forms_Helper_Data
     */
    protected function _helper($helper = 'space48_troubleshoot')
    {
        return Mage::helper($helper);
    }
}
