<?php

class Space48_Forms_Model_Form_Result_Fieldset_Field extends Space48_Forms_Model_Abstract
{
    /**
     * holds form result fieldset model
     *
     * @var Space48_Forms_Model_Form_Result_Fieldset
     */
    protected $_formResultFieldset;
    
    /**
     * _construct
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('space48_forms/form_result_fieldset_field');
    }
    
    /**
     * validate field value
     *
     * @return $this
     */
    public function validate()
    {
        $helper  = Mage::helper('space48_forms/validation');
        $options = $this->getOptions(true);
        $label   = $this->getLabel();
        $value   = $this->getValue();
        
        /**
         * if field is a required field then
         * a value must exist
         */
        if ( $this->getRequired() ) {
            if ( ! strlen($value) ) {
                $helper->throwException('%s is a required field, please enter a value and try again.', $label);
            }
        }
        
        switch ( $this->getType() ) {
            
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_TEXT:
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_TEXTAREA:
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_RADIO:
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_FILE:
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_CHECKBOX:
                // nothing to do, yet
                break;
            
            /**
             * select validation
             */
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_SELECT:
                
                // value must exist as one of the options
                if ( ! in_array($value, $options) ) {
                    $helper->throwException('Invalid option selected for %s. Please select an option and try again.', $label);
                }
                
                break;
        }
        
        return $this;
    }
    
    /**
     * set form result fieldset model
     *
     * @param Space48_Forms_Model_Form_Result_Fieldset $fieldset
     */
    public function setFormResultFieldset(Space48_Forms_Model_Form_Result_Fieldset $fieldset)
    {
        $this->_formResultFieldset = $fieldset;
        
        if ( $id = $fieldset->getId() ) {
            $this->setFieldsetId($id);
        }
        
        return $this;
    }
    
    /**
     * get form result fieldset model
     *
     * @return Space48_Forms_Model_Form_Result_Fieldset
     */
    public function getFormResultFieldset()
    {
        if ( is_null($this->_formResultFieldset) ) {
            $this->_formResultFieldset = Mage::getModel('space48_forms/form_result_fieldset');
            
            if ( $id = $this->getFieldsetId() ) {
                $this->_formResultFieldset->load($id);
            }
        }
        
        return $this->_formResultFieldset;
    }
    
    /**
     * set fieldset data
     *
     * @param Space48_Forms_Model_Form_Fieldset_Field $field
     */
    public function setField(Space48_Forms_Model_Form_Fieldset_Field $field)
    {
        $this->addData(array(
            'name'                   => $field->getName(),
            'label'                  => $field->getLabel(),
            'title'                  => $field->getTitle(),
            'type'                   => $field->getType(),
            'options'                => $field->getOptions(),
            'comment'                => $field->getComment(),
            'hint'                   => $field->getHint(),
            'required'               => $field->getRequired() ? '1' : '0',
            'show_in_admin_email'    => $field->getShowInAdminEmail() ? '1' : '0',
            'show_in_customer_email' => $field->getShowInCustomerEmail() ? '1' : '0',
        ));
        
        return $this;
    }
    
    /**
     * set value
     *
     * @param mixed $value
     */
    public function setValue($value)
    {
        switch ( $this->getType() ) {
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_TEXT:
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_TEXTAREA:
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_RADIO:
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_SELECT:
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_FILE:
                // nothing to do here
                break;
            
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_CHECKBOX:
                
                // only json encode if is an array
                if ( is_array($value) ) {
                    $value = json_encode($value);
                }
                
                break;
        }
        
        $this->setData('value', $value);
        
        return $this;
    }
    
    /**
     * get value
     *
     * @return array|string
     */
    public function getValue()
    {
        $value = $this->getData('value');
        
        switch ( $this->getType() ) {
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_TEXT:
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_TEXTAREA:
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_RADIO:
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_SELECT:
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_FILE:
                // nothing to do here
                break;
            
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_CHECKBOX:
                $value = json_decode($value);
                break;
        }
        
        return $value;
    }
    
    /**
     * get options
     *
     * @param  bool $asArray
     *
     * @return array|string
     */
    public function getOptions($asArray = false)
    {
        // get options
        $options = parent::getOptions();
        
        if ( $asArray ) {
            $options = Mage::helper('space48_forms/form')->explode($options, PHP_EOL);
        }
        
        return $options;
    }
}
