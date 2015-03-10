<?php

class Space48_Troubleshoot_Model_Issue extends Mage_Core_Model_Abstract
{
    /**
     * holds children
     *
     * @var Space48_Troubleshoot_Model_Resource_Issue_Collection
     */
    protected $_children;
    
    /**
     * _construct
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init('space48_troubleshoot/issue');
    }
    
    /**
     * has children
     *
     * @return bool
     */
    public function hasChildren()
    {
        return $this->getResource()->hasChildren($this);
    }
    
    /**
     * get children
     *
     * @return Space48_Troubleshoot_Model_Resource_Issue_Collection
     */
    public function getChildren()
    {
        if ( is_null($this->_children) ) {
            $children = Mage::getResourceModel('space48_troubleshoot/issue_collection');
            $children->addParentFilter($this);
            
            $this->_children = $children;
        }
        
        return $this->_children;
    }
    
    /**
     * on before delete, delete all children first
     *
     * @return $this
     */
    protected function _beforeDelete()
    {
        foreach ( $this->getChildren() as $child ) {
            $child->delete();
        }
        
        return parent::_beforeDelete();
    }
}
