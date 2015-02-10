<?php

abstract class Space48_Forms_Model_Resource_Collection_Abstract extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * set is loaded
     *
     * @param bool $flag
     */
    public function setIsLoaded($flag = true)
    {
        $this->_setIsLoaded($flag);
        return $this;
    }
}
