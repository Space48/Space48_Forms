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
    
    /**
     * get select count sql
     * 
     * @see http://stackoverflow.com/questions/3485455/using-group-breaks-getselectcountsql-in-magento
     *
     * @return Varien_Db_Select
     */
    public function getSelectCountSql()
    {   
        $this->_renderFilters();
        $countSelect = clone $this->getSelect();
        $countSelect->reset(Zend_Db_Select::ORDER);
        $countSelect->reset(Zend_Db_Select::LIMIT_COUNT);
        $countSelect->reset(Zend_Db_Select::LIMIT_OFFSET);
        $countSelect->reset(Zend_Db_Select::COLUMNS);

        // has group by clauses
        if ( count( $this->getSelect()->getPart(Zend_Db_Select::GROUP) ) > 0 ) {
            $countSelect->reset(Zend_Db_Select::GROUP);
            $countSelect->distinct(true);
            $group = $this->getSelect()->getPart(Zend_Db_Select::GROUP);
            $countSelect->columns('COUNT(DISTINCT ' . implode(', ', $group) . ')');
        }
        
        // has no group by clauses
        else {
            $countSelect->columns('COUNT(*)');
        }
        
        return $countSelect;
    }
    
    /**
     * set limit
     *
     * @param int $limit
     * @param int|null $offset
     */
    public function setLimit($limit, $offset = null)
    {
        $this->getSelect()->limit($limit, $offset);
        return $this;
    }
}
