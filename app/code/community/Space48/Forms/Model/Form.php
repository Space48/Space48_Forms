<?php

class Space48_Forms_Model_Form extends Mage_Core_Model_Abstract
{
    /**
     * status
     */
    const STATUS_ENABLED  = '1';
    const STATUS_DISABLED = '2';
    
    /**
     * holds fieldsets
     *
     * @var Space48_Forms_Model_Resource_Form_Fieldset_Collection
     */
    protected $_fieldsets;
    
    /**
     * _construct
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('space48_forms/form');
    }
}
