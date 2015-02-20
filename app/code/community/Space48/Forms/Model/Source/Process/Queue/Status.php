<?php

class Space48_Forms_Model_Source_Process_Queue_Status extends Space48_Forms_Model_Source_Abstract
{
    /**
     * Option values
     */
    const STATUS_FRESH = 'fresh';
    
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
                    'label' => Mage::helper('space48_forms')->__('Fresh'),
                    'value' => self::STATUS_FRESH,
                ),
            );
        }
        
        return parent::getAllOptions();
    }
}
