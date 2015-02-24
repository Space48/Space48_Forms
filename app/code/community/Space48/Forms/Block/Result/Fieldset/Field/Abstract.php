<?php

abstract class Space48_Forms_Block_Result_Fieldset_Field_Abstract extends Mage_Core_Block_Template
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
     * holds field
     *
     * @var Space48_Forms_Model_Form_Result
     */
    protected $_result;
    
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
     * get result
     *
     * @return Space48_Forms_Model_Form_Result
     */
    public function getResult()
    {
        return $this->_result;
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
