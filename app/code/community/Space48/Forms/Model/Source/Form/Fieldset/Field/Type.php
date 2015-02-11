<?php

class Space48_Forms_Model_Source_Form_Fieldset_Field_Type extends Space48_Forms_Model_Source_Abstract
{
    const TYPE_TEXT     = 'text';
    const TYPE_TEXTAREA = 'textarea';
    const TYPE_SELECT   = 'select';
    const TYPE_CHECKBOX = 'checkbox';
    const TYPE_RADIO    = 'radio';
    const TYPE_FILE     = 'file';
    const TYPE_PASSWORD = 'password';
    
    /**
     * get all options
     *
     * @return array
     */
    public function getAllOptions()
    {
        if ( is_null($this->_options) ) {
            $this->_options = array(
                array(
                    'label' => Mage::helper('space48_forms')->__('Text'),
                    'value' => self::TYPE_TEXT,
                ),
                array(
                    'label' => Mage::helper('space48_forms')->__('Textarea'),
                    'value' => self::TYPE_TEXTAREA,
                ),
                array(
                    'label' => Mage::helper('space48_forms')->__('Select'),
                    'value' => self::TYPE_SELECT,
                ),
                array(
                    'label' => Mage::helper('space48_forms')->__('Checkbox'),
                    'value' => self::TYPE_CHECKBOX,
                ),
                array(
                    'label' => Mage::helper('space48_forms')->__('Radio'),
                    'value' => self::TYPE_RADIO,
                ),
                array(
                    'label' => Mage::helper('space48_forms')->__('File'),
                    'value' => self::TYPE_FILE,
                ),
                array(
                    'label' => Mage::helper('space48_forms')->__('Password'),
                    'value' => self::TYPE_PASSWORD,
                ),
            );
        }
        
        return parent::getAllOptions();
    }
}
