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
     * validate action
     *
     * @return void
     */
    public function validateAction()
    {
        // post data
        $data = $this->getRequest()->getPost();
        
        // build response object
        $response = new Varien_Object(array(
            'error'   => '',
            'message' => '',
        ));
        
        try {
            if ( ! $data ) {
                $this->_exception('No form data has been entered.');
            }
            
            // get model
            $model = $this->_getModel();
            
            // set data
            $model->setData($data);
            
            // validate the model
            $model->validate();
            
        } catch (Exception $e) {
            $response->setError(true);
            
            // instead of creating a whole new
            // block for this and a template etc
            // etc I though it was best to create
            // this very small snippet of html
            // within the controller itself.
            $message = '
                <ul class="messages">
                    <li class="error-msg">
                        <ul>
                            <li>
                                <span>'.$e->getMessage().'</span>
                            </li>
                        </ul>
                    </li>
                </ul>
            ';
            
            $response->setMessage( $message );
        }
        
        // echo json response
        $this->getResponse()->setBody( json_encode( $response->getData() ) );
    }
    
    /**
     * save action
     *
     * @return void
     */
    public function saveAction()
    {
        $data = $this->getRequest()->getPost();
        
        try {
            
            if ( ! $data ) {
                $this->_exception('No form data has been entered.');
            }
            
            // get model
            $model = $this->_getModel();
            
            // set data
            $model->setData($data);
            
            // save the model
            $model->save();
            
            if ( $this->_isSaveAndContinue() ) {
                // redirect to model edit
                $this->_redirect('*/*/edit', array('form_id' => $model->getId()));
            } else {
                // redirect to grid
                $this->_redirect('*/*/index');
            }
        } catch (Exception $e) {
            
            // show error message
            $this->_addError( $e->getMessage() );
            
            // store data
            $this->_setFormData($data);
            
            if ( isset($data['form_id']) ) {
                $this->_redirect('*/*/edit', array('form_id' => $data['form_id']));
            } else {
                $this->_redirect('*/*/new');
            }
        }
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
