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
        
        // get files
        $files = count($_FILES) ? $_FILES : array();
        
        // handle data
        $this->_handle($data, $files);
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
    protected function _handle(array $data, array $files = array())
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
            
            try {
                // set form post data
                $result->setFormData($data);
                
                // set form uploaded files
                $result->setFormFiles($files);
                
                // set initial status
                $result->setStatus(Space48_Forms_Model_Source_Form_Result_Status::STATUS_INVALID);
                
                // validate
                $result->validate();
                
                // by this point we know that the form is valid
                $result->setStatus(Space48_Forms_Model_Source_Form_Result_Status::STATUS_VALID);
                
                // we don't need to persist this form 
                // result in the session from this
                // point forward
                $session->unsFormResult();
                
                // however we do want to store
                // the last completed form id and
                // the last completed result id
                $session->setLastCompletedFormId($form->getId());
                $session->setLastCompletedResultId($result->getId());
                
                // we need to queue this for processing
                $queue = Mage::getModel('space48_forms/process_queue');
                $queue->queue($form, $result);
                
                // get redirect url
                $url = $form->getRedirectUrl();
                
                // if we have been given a url, redirect
                // to this url
                if ( $url ) {
                    $this->_redirectUrl($url);
                    return;
                }
                
                // redirect to standard success page
                $this->_redirect('forms/success/index');
                return;
                
            } catch (Exception $e) {
                $this->_exception('There were errors in the form, please check and try again.');
            }
            
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
