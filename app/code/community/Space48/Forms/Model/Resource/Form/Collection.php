<?php

class Space48_Forms_Model_Resource_Form_Collection extends Space48_Forms_Model_Resource_Collection_Abstract
{
    /**
     * _construct
     */
    public function _construct()
    {
        $this->_init('space48_forms/form');
    }
    
    /**
     * add results count to collection
     */
    public function addResultsCount()
    {
        // get select object
        $select = $this->getSelect();
        
        // get result table name
        $resultTable = $this->getTable('space48_forms/form_result');
        
        // create join
        $select->joinLeft(array('results' => $resultTable), 'results.form_id = main_table.form_id', array());
        
        // add count column
        $select->columns(new Zend_Db_Expr('COUNT(results.result_id) AS result_count'));
        
        // add group by clause
        $select->group('main_table.form_id');
        
        return $this;
    }
    
    /**
     * add enabled filter
     */
    public function addEnabledFilter()
    {
        return $this->addStatusFilter(Space48_Forms_Model_Source_Boolean::VALUE_YES);
    }
    
    /**
     * add disabled filter
     */
    public function addDisabledFilter()
    {
        return $this->addStatusFilter(Space48_Forms_Model_Source_Boolean::VALUE_NO);
    }
    
    /**
     * add status filter
     *
     * @param string $status
     */
    public function addStatusFilter($status)
    {
        switch ($status) {
            case Space48_Forms_Model_Source_Boolean::VALUE_YES:
            case Space48_Forms_Model_Source_Boolean::VALUE_NO:
                $this->getSelect()->where('status = ?', $status);
                break;
        }
        
        return $this;
    }
}
