<?php

class Space48_Forms_Model_Form_Result extends Space48_Forms_Model_Abstract
{
    /**
     * holds form model
     *
     * @var Space48_Forms_Model_Form
     */
    protected $_form;
    
    /**
     * holds result fieldsets
     *
     * @var Space48_Forms_Model_Resource_Form_Fieldset_Collection
     */
    protected $_resultFieldsets;
    
    /**
     * an array of all result fields
     *
     * @var array
     */
    protected $_resultFields;
    
    /**
     * _construct
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('space48_forms/form_result');
    }
    
    /**
     * set form
     *
     * @param Space48_Forms_Model_Form $form
     */
    public function setForm(Space48_Forms_Model_Form $form)
    {
        $this->_form = $form;
        
        // only continue if we have not
        // saved form details to db already
        if ( $this->getFormId() ) {
            return $this;
        }
        
        // add data
        $this->addData(array(
            'form_id'             => $form->getId(),
            'title'               => $form->getTitle(),
            'description'         => $form->getDescription(),
            'instructions'        => $form->getInstructions(),
            'before_form_content' => $form->getBeforeFormContent(),
            'after_form_content'  => $form->getAfterFormContent(),
            'registered_only'     => $form->getRegisteredOnly() ? '1' : '0',
        ));
        
        // get customer helper
        $helper = Mage::helper('customer');
        
        // if customer is logged in...
        if ( $helper->isLoggedIn() ) {
            // ...then set customer id
            $this->setCustomerId( $helper->getCustomer()->getId() );
        }
        
        // save at this point as we need the id
        $this->save();
        
        // get fieldsets in form
        foreach ( $form->getFieldsets() as $fieldset ) {
            // store as result fieldset
            $resultFieldset = Mage::getModel('space48_forms/form_result_fieldset');
            $resultFieldset->setFormResult($this);
            $resultFieldset->setFieldset($fieldset);
            $resultFieldset->save();
            
            // add to collection
            $this->getResultFieldsets()->addItem($resultFieldset);
        }
        
        // set collection to is loaded
        // this will ensure we don't load it twice
        $this->getResultFieldsets()->setIsLoaded(true);
        
        return $this;
    }
    
    /**
     * get result field
     *
     * @param  string $name
     *
     * @return Space48_Forms_Model_Form_Result_Fieldset_Field|array|null
     */
    public function getResultFields($name = null)
    {
        if ( is_null($this->_resultFields) ) {
            // default to empty array
            $fields = array();
            
            // loop through fieldsets
            foreach ( $this->getResultFieldsets() as $fieldset ) {
                // loop through fields
                foreach ( $fieldset->getResultFields() as $field ) {
                    // add to fields array
                    $fields[$field->getName()] = $field;
                }
            }
            
            // set fields
            $this->_resultFields = $fields;
        }
        
        // if a name has been given
        if ( ! is_null($name) ) {
            // check if it exists within array
            if ( array_key_exists($name, $this->_resultFields) ) {
                return $this->_resultFields[$name];
            }
            
            // else return null
            else {
                return null;
            }
        }
        
        // return all fields if no name given
        return $this->_resultFields;
    }
    
    /**
     * set form data
     *
     * @param array $data
     */
    public function setFormData(array $data)
    {
        foreach ( $data as $key => $value ) {
            // should have key
            if ( ! $key ) {
                continue;
            }
            
            // try find field
            $field = $this->getResultFields($key);
            
            // ignore and continue if field not found
            if ( ! $field ) {
                continue;
            }
            
            $field->setValue($value);
            $field->save();
        }
        
        return $this;
    }
    
    /**
     * validate
     *
     * @return $this
     */
    public function validate()
    {
        foreach ( $this->getResultFields() as $field ) {
            $field->validate();
        }
        
        return $this;
    }
    
    /**
     * get form 
     *
     * @return Space48_Forms_Model_Form
     */
    public function getForm()
    {
        if ( is_null($this->_form) ) {
            
            // assign model
            $this->_form = Mage::getModel('space48_forms/form');
            
            // if we have form id then load form
            if ( $id = $this->getFormId() ) {
                $this->_form->load($id);
            }
        }
        
        return $this->_form;
    }
    
    /**
     * get result fieldsets
     *
     * @return Space48_Forms_Model_Resource_Form_Result_Fieldset_Collection
     */
    public function getResultFieldsets()
    {
        if ( is_null($this->_resultFieldsets) ) {
            $this->_resultFieldsets = Mage::getResourceModel('space48_forms/form_result_fieldset_collection');
            $this->_resultFieldsets->setFormResultFilter($this);
        }
        
        return $this->_resultFieldsets;
    }
}
