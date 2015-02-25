<?php

class Space48_Forms_Model_Resource_Process_Queue_Collection extends Space48_Forms_Model_Resource_Collection_Abstract
{
    /**
     * _construct
     */
    public function _construct()
    {
        $this->_init('space48_forms/process_queue');
    }
    
    /**
     * add fresh filter
     */
    public function addFreshFilter()
    {
        return $this->addAddStatusFilter(Space48_Forms_Model_Source_Process_Queue_Status::STATUS_FRESH);
    }
    
    /**
     * add complete filter
     */
    public function addCompletedFilter()
    {
        return $this->addAddStatusFilter(Space48_Forms_Model_Source_Process_Queue_Status::STATUS_COMPLETE);
    }
    
    /**
     * add status filter
     *
     * @param string $status
     */
    public function addAddStatusFilter($status)
    {
        switch ( $status ) {
            case Space48_Forms_Model_Source_Process_Queue_Status::STATUS_FRESH:
            case Space48_Forms_Model_Source_Process_Queue_Status::STATUS_COMPLETE:
                
                // add where condition
                $this->getSelect()->where('status = ?', $status);
                
                break;
        }
        
        return $this;
    }
}
