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
            
            // get form model
            $form = $this->_getModel();
            
            // set data
            $form->setData($data);
            
            // save the form
            $form->save();
            
            if ( $this->_isSaveAndContinue() ) {
                // redirect to form edit
                $this->_redirect('*/*/edit', array('form_id' => $form->getId()));
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
}
