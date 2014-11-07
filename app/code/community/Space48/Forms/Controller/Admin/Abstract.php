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
        return $this->getRequest()->getParam('form_id');
    }
    
    /**
     * init model
     *
     * @return Mage_Core_Model_Abstract
     */
    protected function _initModel()
    {
        $model = $this->_getModel();
        
        // must be instance of "Mage_Core_Model_Abstract"
        if ( ! ( $model instanceof Mage_Core_Model_Abstract ) ) {
            $this->_exception('Unable to initialise model.');
        }
        
        // load model if we have an id
        if ( $id = $this->_getModelId() ) {
            $model->load($id);
        }
        
        // see if we have stored session data
        if ( $data = $this->_getFormData() ) {
            $model->addData($data);
        }
        
        // register
        Mage::helper('space48_forms')->register($this->_getModelClass(), $model);
        
        return $model;
    }
    
    /**
     * index action
     *
     * @return void
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
    
    /**
     * new action
     *
     * @return void
     */
    public function newAction()
    {
        $this->_initModel();
        $this->loadLayout();
        $this->renderLayout();
    }
    
    /**
     * edit action
     *
     * @return void
     */
    public function editAction()
    {
        // try init model
        if ( ! $this->_initModel()->getId() ) {
            $this->_addError('Unable to load model.');
            
            $this->_redirect('*/*/index');
            return;
        }
        
        $this->loadLayout();
        $this->renderLayout();
    }
    
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
        //$this->_getSession()->setData('form_data', null);
        
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
