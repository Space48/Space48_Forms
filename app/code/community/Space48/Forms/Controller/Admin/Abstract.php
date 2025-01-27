<?php

abstract class Space48_Forms_Controller_Admin_Abstract extends Mage_Adminhtml_Controller_Action
{
    /**
     * holds model
     *
     * @var Mage_Core_Model_Abstract
     */
    protected $_model;
    
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
        if ( is_null($this->_model) ) {
            $this->_model = Mage::getModel($this->_getModelClass());
        }
        
        return $this->_model;
    }
    
    /**
     * get model id
     *
     * @return int|null
     */
    protected function _getModelId()
    {
        return $this->getRequest()->getParam($this->_getIdFieldName());
    }
    
    /**
     * get id field name
     *
     * @return string
     */
    protected function _getIdFieldName()
    {
        return $this->_getModel()->getIdFieldName();
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
            $this->_exception('Unable to initialise selected item.');
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
            $this->_addError('Unable to load selected item.');
            
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
        $idField = $this->_getIdFieldName();
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
                
                // params to append to url
                $params = array($idField => $model->getId());
                
                // set active tab
                if ( $activeTab = $this->getRequest()->getParam('active_tab') ) {
                    $params['active_tab'] = $activeTab;
                }
                
                // show success message
                $this->_addSuccess('Your changes have successfully been saved.');
                
                // redirect to model edit
                $this->_redirect('*/*/edit', $params);
            } else {
                // redirect to grid
                $this->_redirect('*/*/index');
            }
        } catch (Exception $e) {
            
            // show error message
            $this->_addError( $e->getMessage() );
            
            // store data
            $this->_setFormData($data);
            
            if ( isset($data[$idField]) ) {
                $this->_redirect('*/*/edit', array($idField => $data[$idField]));
            } else {
                $this->_redirect('*/*/new');
            }
        }
    }
    
    /**
     * delete action
     *
     * @return void
     */
    public function deleteAction()
    {
        try {
            $model = $this->_initModel();
            
            // if we have not got a model
            if ( ! $model->getId() ) {
                $this->_exception('No form data has been entered.');
            }
            
            // try delete
            $model->delete();
            
        } catch (Exception $e) {
            // show error message
            $this->_addError( $e->getMessage() );
        }
        
        $this->_redirect('*/*/index');
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
