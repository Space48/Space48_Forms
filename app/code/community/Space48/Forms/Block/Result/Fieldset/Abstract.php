<?php

abstract class Space48_Forms_Block_Result_Fieldset_Abstract extends Space48_Forms_Block_Result_Abstract
{
    /**
     * holds field
     *
     * @var Space48_Forms_Model_Form_Result_Fieldset
     */
    protected $_fieldset;
    
    /**
     * constructor
     */
    public function _construct()
    {
        parent::_construct();
        
        // set template
        $this->setTemplate('space48/forms/result/fieldset.phtml');
    }
    
    /**
     * set fieldset
     *
     * @param Space48_Forms_Model_Form_Result_Fieldset $fieldset
     */
    public function setFieldset(Space48_Forms_Model_Form_Result_Fieldset $fieldset)
    {
        $this->_fieldset = $fieldset;
        return $this;
    }
    
    /**
     * get fieldset
     *
     * @return Space48_Forms_Model_Form_Result_Fieldset
     */
    public function getFieldset()
    {
        return $this->_fieldset;
    }
    
    /**
     * get fields
     *
     * @return Space48_Forms_Model_Resource_Form_Result_Fieldset_Field_Collection
     */
    public function getFields()
    {
        return $this->getFieldset()->getResultFields();
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
        switch ( $field->getType() ) {
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_TEXT:
                $block = $this->getLayout()->getBlock('space48_forms_field_text');
                break;
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_TEXTAREA:
                $block = $this->getLayout()->getBlock('space48_forms_field_textarea');
                break;
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_SELECT:
                $block = $this->getLayout()->getBlock('space48_forms_field_select');
                break;
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_CHECKBOX:
                $block = $this->getLayout()->getBlock('space48_forms_field_checkbox');
                break;
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_RADIO:
                $block = $this->getLayout()->getBlock('space48_forms_field_radio');
                break;
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_FILE:
                $block = $this->getLayout()->getBlock('space48_forms_field_file');
                break;
            default:
                $block = $this->getLayout()->createBlock('core/template');
        }
        
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
}
