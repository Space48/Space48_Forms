<?php

class Space48_Troubleshoot_Model_Source_Boolean extends Space48_Troubleshoot_Model_Source_Abstract
{
    /**
     * Option values
     */
    const VALUE_YES = 1;
    const VALUE_NO  = 0;
    
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
                    'label' => Mage::helper('space48_troubleshoot')->__('Yes'),
                    'value' => self::VALUE_YES
                ),
                array(
                    'label' => Mage::helper('space48_troubleshoot')->__('No'),
                    'value' => self::VALUE_NO
                ),
            );
        }
        
        return parent::getAllOptions();
    }
}
