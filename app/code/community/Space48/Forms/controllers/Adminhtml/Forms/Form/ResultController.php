<?php

class Space48_Forms_Adminhtml_Forms_Form_ResultController
    extends Space48_Forms_Controller_Admin_Abstract
{
    /**
     * model class
     *
     * @var string
     */
    protected $_modelClass = 'space48_forms/form_result';
    
    /**
     * init form
     *
     * @return Space48_Form_Model_Form
     */
    protected function _initForm()
    {
        // get form model
        $form = Mage::getModel('space48_forms/form');
        
        // load form model if we have form id
        if ( $id = $this->getRequest()->getParam('form_id') ) {
            $form->load($id);
        }
        
        // register
        Mage::helper('space48_forms')->register('space48_forms/form', $form);
        
        return $form;
    }
    
    /**
     * index action
     *
     * @return void
     */
    public function indexAction()
    {
        $this->_initForm();
        parent::indexAction();
    }
    
    /**
     * view action
     *
     * @return void
     */
    public function viewAction()
    {
        $this->_initForm();
        $this->_initModel();
        $this->loadLayout();
        $this->renderLayout();
    }
}

