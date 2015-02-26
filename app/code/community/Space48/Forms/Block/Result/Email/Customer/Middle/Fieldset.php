<?php

class Space48_Forms_Block_Result_Email_Customer_Middle_Fieldset extends Space48_Forms_Block_Result_Fieldset_Abstract
{
    /**
     * constructor
     */
    public function _construct()
    {
        parent::_construct();
        
        // set template
        $this->setTemplate('space48/forms/result/email/customer/fieldset/fieldset.phtml');
    }
    
    /**
     * get field html
     *
     * @param  Space48_Forms_Model_Form_Result_Fieldset_Field $field
     *
     * @return string
     */
    public function getFieldHtml(Space48_Forms_Model_Form_Result_Fieldset_Field $field)
    {
        if ( ! $this->_canShowField($field) ) {
            return '';
        }
        
        // block
        $block = null;
        
        switch ( $field->getType() ) {
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_TEXT:
                $block = 'space48_forms/result_email_customer_middle_fieldset_field_text';
                break;
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_TEXTAREA:
                $block = 'space48_forms/result_email_customer_middle_fieldset_field_textarea';
                break;
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_SELECT:
                $block = 'space48_forms/result_email_customer_middle_fieldset_field_select';
                break;
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_CHECKBOX:
                $block = 'space48_forms/result_email_customer_middle_fieldset_field_checkbox';
                break;
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_RADIO:
                $block = 'space48_forms/result_email_customer_middle_fieldset_field_radio';
                break;
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_FILE:
                $block = 'space48_forms/result_email_customer_middle_fieldset_field_file';
                break;
        }
        
        // should have block name
        if ( ! $block ) {
            return '';
        }
        
        // create block
        $block = $this->getLayout()->createBlock($block);
        
        // should have block class
        if ( ! $block ) {
            return '';
        }
        
        // set vars
        $block->setField($field);
        $block->setFieldset($this->getFieldset());
        $block->setResult($this->getResult());
        $block->setParentBlock($this);
        
        // get html
        return $block->toHtml();
    }
    
    /**
     * can show field
     *
     * @return bool
     */
    protected function _canShowField(Space48_Forms_Model_Form_Result_Fieldset_Field $field)
    {
        if ( ! $field->getShowInCustomerEmail() ) {
            return false;
        }
        
        return true;
    }
}
