<?php

abstract class Space48_Forms_Block_Result_Fieldset_Field_Abstract extends Space48_Forms_Block_Result_Abstract
{
    /**
     * holds field
     *
     * @var Space48_Forms_Model_Form_Result_Fieldset_Field
     */
    protected $_field;
    
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
    }
    
    /**
     * set field
     *
     * @param Space48_Forms_Model_Form_Result_Fieldset_Field $field
     */
    public function setField(Space48_Forms_Model_Form_Result_Fieldset_Field $field)
    {
        $this->_field = $field;
        return $this;
    }
    
    /**
     * get field
     *
     * @return Space48_Forms_Model_Form_Result_Fieldset_Field
     */
    public function getField()
    {
        return $this->_field;
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
     * get options
     *
     * @return array
     */
    public function getOptions($asArray = true)
    {
        return $this->getField()->getOptions($asArray);
    }
    
    /**
     * get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->getField()->getValue();
    }
    
    /**
     * is selected option
     *
     * @param  string $option
     *
     * @return bool
     */
    public function isSelectedOption($option)
    {
        return $this->getValue() == $option;
    }
}
