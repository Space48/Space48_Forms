<?php

class Space48_Forms_SubmitController extends Space48_Forms_Controller_Abstract
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
        
        // if we have an id, load it
        if ( $id = $this->_getFormId() ) {
            $form->load($id);
        }
        
        // register form
        Mage::register('current_form', $form);
        
        return $form;
    }
    
    /**
     * get form id
     *
     * @return int
     */
    protected function _getFormId()
    {
        return $this->getRequest()->getParam('__form', 0);
    }
    
    /**
     * get return url 
     *
     * @return string
     */
    protected function _getReturnUrl()
    {
        return $this->getRequest()->getParam('__url', '');
    }
    
    /**
     * post action
     *
     * @return void
     */
    public function postAction()
    {
        // get form data
        $data = $this->getRequest()->getPost();
        
        // handle data
        $this->_handle($data);
    }
    
    /**
     * get action
     *
     * @return void
     */
    public function getAction()
    {
        // get form data
        $data = $this->getRequest()->getQuery();
        
        // handle data
        $this->_handle($data);
    }
    
    /**
     * handle form submission
     *
     * @param  array $data
     *
     * @return void
     */
    protected function _handle(array $data)
    {
        try {
            // try load form
            $form = $this->_initForm();
            
            // space48 form session
            $session = Mage::getSingleton('space48_forms/session');
            
            // check if we have a form model
            if ( ! $form->getId() ) {
                $this->_log('Unable to load form model: %s', $this->_getFormId());
                $this->_exception('Oops, something unexpected happened, please try again later.');
            }
            
            /**
             * form result model
             *
             * @var Space48_Forms_Model_Form_Result
             */
            $result = $session->getFormResult();
            $result->setForm($form);
            $result->save();
            
            // store back into session
            $session->setFormResult($result);
            
            // set form data
            $result->setFormData($data);
            
            // validate
            $result->validate();
            
        } catch (Exception $e) {
            // add error message to session
            $this->_addError($e->getMessage());
            
            // return to passed url
            if ( $url = $this->_getReturnUrl() ) {
                $this->_redirectUrl($url);
                return;
            }
        }
        
        // redirect to home if all else fails
        $this->_redirectUrl('');
        return;
    }
}
