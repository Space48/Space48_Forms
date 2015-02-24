<?php

class Space48_Forms_Block_Admin_Form_Result_View_Fieldset extends Mage_Adminhtml_Block_Template
{
    /**
     * holds result
     *
     * @var Space48_Forms_Model_Form_Result
     */
    protected $_result;
    
    /**
     * holds fieldset
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
        $this->setTemplate('space48/forms/form/result/view/fieldset.phtml');
    }
    
    /**
     * set result
     *
     * @param Space48_Forms_Model_Form_Result $result
     */
    public function setResult(Space48_Forms_Model_Form_Result $result)
    {
        $this->_result = $result;
        return $this;
    }
    
    /**
     * return result
     *
     * @return Space48_Forms_Model_Form_Result
     */
    public function getResult()
    {
        return $this->_result;
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
     * get fieldset meta data
     *
     * @return array
     */
    public function getFieldsetMetaData()
    {
        return array_filter(array(
            'Name'                  => $this->getFieldset()->getName(),
            'Title'                 => $this->getFieldset()->getTitle(),
            'Description'           => $this->getFieldset()->getDescription(),
            'Instructions'          => $this->getFieldset()->getInstructions(),
            'Before Fields Content' => $this->getFieldset()->getBeforeFieldsContent(),
            'After Fields Content'  => $this->getFieldset()->getAfterFieldsContent(),
        ));
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
        
        // set vars
        $block->setField($field);
        $block->setFieldset($this->getFieldset());
        $block->setResult($this->getResult());
        $block->setParentBlock($this);
        
        // get html
        return $block->toHtml();
    }
}
