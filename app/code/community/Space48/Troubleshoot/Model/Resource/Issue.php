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
    
    /**
     * get parents
     *
     * @param  Space48_Troubleshoot_Model_Issue $issue
     *
     * @return array
     */
    public function getParents(Space48_Troubleshoot_Model_Issue $issue)
    {
        // init parents array
        $parents = array();
        
        // get parents
        $this->_getParents($issue, $parents);
        
        // reverse array for correct order
        $parents = array_reverse($parents);
        
        return $parents;
    }
    
    /**
     * get parents
     *
     * @param  Space48_Troubleshoot_Model_Issue $issue
     * @param  array &$parents
     *
     * @return $this
     */
    protected function _getParents(Space48_Troubleshoot_Model_Issue $issue, array &$parents)
    {
        // get parent id
        $parentId = $issue->getParentId();
        
        // if we dont have a parent id, nothing to do
        if ( ! $parentId ) {
            return $this;
        }
        
        // load parent
        $parent = Mage::getModel('space48_troubleshoot/issue')->load($parentId);
        
        // add to parents array
        $parents[] = $parent;
        
        // if we have a model, then recurse
        if ( $parent->getId() ) {
            $this->_getParents($parent, $parents);
        }
        
        return $this;
    }
}
