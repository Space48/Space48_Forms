<?php

class Space48_Forms_Block_Admin_Form_Edit_Validation extends Mage_Adminhtml_Block_Template
{
    /**
     * holds errors
     *
     * @var array
     */
    protected $_errors;
    
    /**
     * constructor
     *
     * @return void
     */
    public function _construct()
    {
        parent::_construct();
        
        // set template
        $this->setTemplate('space48/forms/form/edit/validation.phtml');
    }
    
    /**
     * has errors
     *
     * @return bool 
     */
    public function hasErrors()
    {
        return count($this->getErrors()) > 0;
    }
    
    /**
     * get array of errors
     *
     * @return array
     */
    public function getErrors()
    {
        if ( is_null($this->_errors) ) {
            // an array of errors
            $errors = array();
            
            // get form
            $form = $this->getForm();
            
            // get fields
            $fields = $form->getFields();
            
            // must have at least one field
            if ( ! count($fields) ) {
                $errors[] = $this->__('This form has no fields.');
            }
            
            // if we are emailing the customer then...
            if ( $form->getEmailCustomer() ) {
                
                // get email field
                $emailField = $form->getEmailCustomerAddressField();
                
                // if we do not have a value
                if ( ! $emailField ) {
                    $errors[] = $this->__('Please enter the name of the field that will contain the customers email address.');
                }
                
                // otherwise if we do have a value
                else {
                    
                    // lets get this field
                    $field = $form->getFieldByName($emailField);
                    
                    // if we get a false value then this field does
                    // not exist
                    if ( ! $field ) {
                        $errors[] = $this->__('The email field you specified does not exist in the list of fields.');
                    }
                }
                
                // get name field(s)
                $nameField = $form->getEmailCustomerNameField();
                
                if ( ! $emailField ) {
                    $errors[] = $this->__('Please enter the name of the field(s) that will contain the customers name(s).');
                }
                
                // otherwise we do have a value
                else {
                    $fields = explode(',', $nameField);
                    
                    foreach ( $fields as $field ) {
                        
                        $field = trim($field);
                        
                        if ( ! $field ) {
                            continue;
                        }
                        
                        $field = $form->getFieldByName($field);
                        
                        if ( ! $field ) {
                            $errors[] = $this->__('One or more of the name fields you specified do not exist in the list of fields.');
                        }
                    }
                }
            }
            
            // check duplicated fields
            if ( $form->hasDuplicatedFields() ) {
                $errors[] = $this->__('The form has duplicated fields - please check.');
            }
            
            $this->_errors = $errors;
        }
        
        return $this->_errors;
    }
    
    protected function _hasDuplicatedFields()
    {
        
    }
    
    /**
     * get form
     *
     * @return Space48_Forms_Model_Form
     */
    public function getForm()
    {
        return Mage::helper('space48_forms')->registry('space48_forms/form');
    }
}
