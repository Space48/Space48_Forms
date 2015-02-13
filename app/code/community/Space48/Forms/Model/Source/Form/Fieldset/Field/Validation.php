<?php

class Space48_Forms_Model_Source_Form_Fieldset_Field_Validation extends Space48_Forms_Model_Source_Abstract
{
    const VALIDATION_STRINGLENGTH = 'string_length';
    const VALIDATION_NUMBER       = 'number';
    const VALIDATION_DIGIT        = 'digit';
    const VALIDATION_ALPHANUMERIC = 'alphanumeric';
    const VALIDATION_EMAIL        = 'email';
    const VALIDATION_POSTCODE     = 'postcode';
    
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
                    'label' => Mage::helper('space48_forms')->__('String Length'),
                    'value' => self::VALIDATION_STRINGLENGTH,
                ),
                array(
                    'label' => Mage::helper('space48_forms')->__('Number'),
                    'value' => self::VALIDATION_NUMBER,
                ),
                array(
                    'label' => Mage::helper('space48_forms')->__('Digits'),
                    'value' => self::VALIDATION_DIGIT,
                ),
                array(
                    'label' => Mage::helper('space48_forms')->__('Alphanumeric'),
                    'value' => self::VALIDATION_ALPHANUMERIC,
                ),
                array(
                    'label' => Mage::helper('space48_forms')->__('Email'),
                    'value' => self::VALIDATION_EMAIL,
                ),
                array(
                    'label' => Mage::helper('space48_forms')->__('Postcode'),
                    'value' => self::VALIDATION_POSTCODE,
                ),
            );
        }
        
        return parent::getAllOptions();
    }
}
