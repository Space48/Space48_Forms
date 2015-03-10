<?php

class Space48_Troubleshoot_Model_Resource_Issue extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * _construct
     */
    public function _construct()
    {
        $this->_init('space48_troubleshoot/issue', 'issue_id');
    }
    
    /**
     * Perform actions before object save
     *
     * @param Varien_Object $object
     * @return Mage_Core_Model_Resource_Db_Abstract
     */
    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        $now = Mage::helper('space48_troubleshoot')->now();
        
        $object->setUpdatedAt($now);
        
        if ( ! $object->getCreatedAt() ) {
            $object->setCreatedAt($now);
        }
        
        return $this;
    }
    
    /**
     * has children
     *
     * @param  Space48_Troubleshoot_Model_Issue $issue
     *
     * @return bool
     */
    public function hasChildren(Space48_Troubleshoot_Model_Issue $issue)
    {
        // get read connection
        $read = $this->_getReadAdapter();
        
        // get select object
        $select = $read->select();
        
        // get table name
        $table = $this->getTable('space48_troubleshoot/issue');
        
        // build select
        $select->from($table, array());
        $select->columns(new Zend_Db_Expr('COUNT(*)'));
        $select->where('parent_id = ?', $issue->getId());
        
        // get count
        try {
            $count = $read->fetchOne($select);
        } catch (Exception $e) {
            $count = 0;
        }
        
        return $count > 0;
    }
}
