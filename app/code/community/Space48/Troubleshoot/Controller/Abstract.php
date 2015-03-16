<?php

abstract class Space48_Troubleshoot_Controller_Abstract extends Mage_Core_Controller_Front_Action
{
    /**
     * add error to session
     */
    protected function _addError()
    {
        $args = func_get_args();
        $message = call_user_func_array(array($this->_helper(), '__'), $args);
        $this->_getSession()->addError($message);
        
        return $this;
    }
    
    /**
     * add error to session
     */
    protected function _addNotice()
    {
        $args = func_get_args();
        $message = call_user_func_array(array($this->_helper(), '__'), $args);
        $this->_getSession()->addNotice($message);
        
        return $this;
    }
    
    /**
     * add success to session
     */
    protected function _addSuccess()
    {
        $args = func_get_args();
        $message = call_user_func_array(array($this->_helper(), '__'), $args);
        $this->_getSession()->addSuccess($message);
        
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
     * log
     */
    protected function _log()
    {
        $args = func_get_args();
        $message = call_user_func_array(array($this->_helper(), '__'), $args);
        
        try {
            Mage::log($message, null, 'space48_troubleshoot.log');
        } catch (Exception $e) {
            // do nothing
        }
        
        return $this;
    }
    
    /**
     * get helper
     *
     * @param  string $helper
     *
     * @return Mage_Core_Helper_Abstract
     */
    protected function _helper($helper = 'space48_troubleshoot')
    {
        return Mage::helper($helper);
    }
    
    /**
     * get customer session
     *
     * @return Mage_Core_Model_Session
     */
    protected function _getSession()
    {
        return Mage::getSingleton('core/session');
    }
}
