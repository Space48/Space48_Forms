<?php

class Space48_Forms_Model_Resource_Form extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * _construct
     */
    public function _construct()
    {
        $this->_init('space48_forms/form');
    }
}
