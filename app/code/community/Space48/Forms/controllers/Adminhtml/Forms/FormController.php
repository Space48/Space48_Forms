<?php

class Space48_Forms_Adminhtml_Forms_FormController
    extends Space48_Forms_Controller_Admin_Abstract
{
    /**
     * model class
     *
     * @var string
     */
    protected $_modelClass = 'space48_forms/form';
    
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
}
