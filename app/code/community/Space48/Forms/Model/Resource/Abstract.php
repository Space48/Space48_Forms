<?php

abstract class Space48_Forms_Model_Resource_Abstract extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Perform actions before object save
     *
     * @param Varien_Object $object
     * @return Mage_Core_Model_Resource_Db_Abstract
     */
    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        $now = Mage::helper('space48_forms')->now();
        
        $object->setUpdatedAt($now);
        
        if ( ! $object->getCreatedAt() ) {
            $object->setCreatedAt($now);
        }
        
        return $this;
    }
}
