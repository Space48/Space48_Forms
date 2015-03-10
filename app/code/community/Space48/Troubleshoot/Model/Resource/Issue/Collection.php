<?php

class Space48_Troubleshoot_Model_Resource_Issue_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * _construct
     */
    public function _construct()
    {
        $this->_init('space48_troubleshoot/issue');
    }
    
    /**
     * add parent filter
     *
     * @param int|Space48_Troubleshoot_Model_Issue $parent [description]
     */
    public function addParentFilter($parent)
    {
        $id = $parent instanceof Space48_Troubleshoot_Model_Issue
            ? $parent->getId()
            : ((int) $parent);
        
        $this->getSelect()->where('parent_id = ?', $id);
        
        return $this;
    }
}
