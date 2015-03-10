<?php

class Space48_Troubleshoot_Adminhtml_Troubleshoot_IssueController extends Space48_Troubleshoot_Controller_Adminhtml_Abstract
{
    /**
     * init model
     *
     * @return Space48_Troubleshoot_Model_Issue
     */
    protected function _initModel()
    {
        // instantiate model
        $model = Mage::getModel('space48_troubleshoot/issue');
        
        // load model
        if ( $id = $this->getRequest()->getParam('id') ) {
            $model->load($id);
        }
        
        // register model
        Mage::register('current_issue', $model);
        
        return $model;
    }
    
    /**
     * index action
     *
     * @return void
     */
    public function indexAction()
    {
        $this->_initModel();
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
     * save action
     *
     * @return void
     */
    public function saveAction()
    {
        try {
            // get data
            $data = $this->getRequest()->getPost();
            
            // check if we have data
            if ( ! $data ) {
                $this->_exception('No form data has been entered.');
            }
            
            // unset form id
            if ( array_key_exists('form_id', $data) && ! $data['form_id'] ) {
                $data['form_id'] = '0';
            }
            
            // get model
            $model = $this->_initModel();
            
            // add data
            $model->addData($data);
            
            // save the model
            $model->save();
            
            // redirect to index
            $this->_redirect('*/*/index', array(
                'id' => $model->getId(),
            ));
            
            return;
            
        } catch (Exception $e) {
            // show error message
            $this->_addError( $e->getMessage() );
        }
        
        // redirect to grid
        $this->_redirect('*/*/index');
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
     * update node positions
     *
     * @return void
     */
    public function updateNodePositionsAction()
    {
        try {
            // get post data
            $data = $this->getRequest()->getPost();
            
            // unset form key
            unset($data['form_key']);
            
            // sort
            $sort = 1;
            
            foreach ( $data as $node ) {
                $model = Mage::getModel('space48_troubleshoot/issue')->load($node['id']);
                
                if ( $model->getId() ) {
                    $model->setParentId($node['parent_id']);
                    $model->setSort($sort);
                    $model->save();
                }
                
                $sort++;
            }
            
        } catch (Exception $e) {
            // do nothing
        }
    }
}
