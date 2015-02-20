<?php

class Space48_Forms_SuccessController extends Space48_Forms_Controller_Abstract
{
    /**
     * init form
     *
     * @return Space48_Forms_Model_Form
     */
    protected function _initForm()
    {
        // get form model
        $form = Mage::getModel('space48_forms/form');
        
        // load last completed form id
        if ( $id = $this->_getSession()->getLastCompletedFormId() ) {
            $form->load($id);
        }
        
        // register form
        Mage::register('current_form', $form);
        
        return $form;
    }
    
    /**
     * init form result
     *
     * @return Space48_Forms_Model_Form_Result
     */
    protected function _initResult()
    {
        // get form model
        $result = Mage::getModel('space48_forms/form_result');
        
        // load last completed form id
        if ( $id = $this->_getSession()->getLastCompletedResultId() ) {
            $result->load($id);
        }
        
        // register form
        Mage::register('current_result', $result);
        
        return $result;
    }
    
    /**
     * get session
     *
     * @return Space48_Forms_Model_Session
     */
    protected function _getSession()
    {
        return Mage::getSingleton('space48_forms/session');
    }
    
    /**
     * index action
     *
     * @return void
     */
    public function indexAction()
    {
        try {
            // get form and result models
            $form   = $this->_initForm();
            $result = $this->_initResult();
            
            // unable to load form model
            if ( ! $form->getId() ) {
                $this->_exception('Unable to load form model for results.');
            }
            
            // unable to load results model
            if ( ! $result->getId() ) {
                $this->_exception('Unable to load result model for results.');
            }
            
            // load and render layout
            $this->loadLayout();
            $this->renderLayout();
            
        } catch (Exception $e) {
            // log error
            $this->_log($e->getMessage());
            
            // show user error
            $this->_addError('Oop\'s, something unexpected happened. Please contact us if this persists.');
            
            // redirect
            $this->_redirect('');
        }
    }
}
