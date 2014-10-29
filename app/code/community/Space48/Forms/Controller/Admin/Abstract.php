<?php

abstract class Space48_Forms_Controller_Admin_Abstract extends Mage_Adminhtml_Controller_Action
{
    /**
     * get model class
     *
     * @return string
     */
    protected function _getModelClass()
    {
        return $this->_modelClass;
    }
    
    /**
     * get model
     *
     * @return Mage_Core_Model_Abstract
     */
    protected function _getModel()
    {
        return Mage::getModel($this->_getModelClass());
    }
    
    /**
     * get model id
     *
     * @return int|null
     */
    protected function _getModelId()
    {
        return $this->getRequest()->getParam('id');
    }
    
    /**
     * init model
     *
     * @return Mage_Core_Model_Abstract
     */
    protected function _initModel()
    {
        $model = $this->_getModel();
        
        if ( ! ( $model instanceof Mage_Core_Model_Abstract ) ) {
            $this->_exception('Unable to initialise model.');
        }
        
        if ( $id = $this->_getModelId() ) {
            $model->load($id);
        }
        
        // register
        Mage::helper('space48_forms')->register($this->_getModelClass(), $model);
        
        return $model;
    }
    
    /**
     * add error message
     *
     * @param string $msg
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
     *
     * @param string $msg
     */
    protected function _addSuccess($msg)
    {
        $args = func_get_args();
        $message = call_user_func_array(array($this->_helper(), '__'), $args);
        $this->_getSession()->addSuccess($message);
        
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
    protected function _helper($helper = 'space48_forms')
    {
        return Mage::helper($helper);
    }
}
