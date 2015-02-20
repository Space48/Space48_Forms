<?php

class Space48_Forms_Model_Source_Form_Result_Status extends Space48_Forms_Model_Source_Abstract
{
    /**
     * Option values
     */
    const STATUS_INVALID = 'inval';
    const STATUS_VALID   = 'valid';
    
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
                    'label' => Mage::helper('space48_forms')->__('Invalid'),
                    'value' => self::STATUS_INVALID
                ),
                array(
                    'label' => Mage::helper('space48_forms')->__('Valid'),
                    'value' => self::STATUS_VALID
                ),
            );
        }
        
        return parent::getAllOptions();
    }
}
