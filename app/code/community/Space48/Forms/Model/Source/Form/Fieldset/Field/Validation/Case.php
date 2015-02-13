<?php

class Space48_Forms_Model_Source_Form_Fieldset_Field_Validation_Case extends Space48_Forms_Model_Source_Abstract
{
    const CASE_UPPERCASE = 'uppercase';
    const CASE_LOWERCASE = 'lowercase';
    
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
                    'label' => Mage::helper('space48_forms')->__('Uppercase'),
                    'value' => self::CASE_UPPERCASE,
                ),
                array(
                    'label' => Mage::helper('space48_forms')->__('Lowercase'),
                    'value' => self::CASE_LOWERCASE,
                ),
            );
        }
        
        return parent::getAllOptions();
    }
}
