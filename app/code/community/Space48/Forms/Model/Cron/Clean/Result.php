<?php

class Space48_Forms_Model_Cron_Clean_Result extends Space48_Forms_Model_Cron_Abstract
{
    /**
     * run cron
     * 
     * scalability consideration
     * it may be that this is too inefficient at deleting
     * records. we could use the result resource model to
     * execute a "delete from" query however we would lose
     * the ability to observer "delete before" and
     * "delete after" events and the like. for now i have
     * left this as is to retain the flexibility.
     * 
     * @return $this
     */
    protected function _run()
    {
        $results = Mage::getResourceModel('space48_forms/form_result_collection');
        $results->addOlderThanDaysFilter(7);
        $results->addInvalidStatusFilter();
        $results->setLimit(500);
        
        foreach ( $results as $result ) {
            try {
                // delete result
                $result->delete();
            } catch (Exception $e) {
                // do nothing
            }
        }
        
        return $this;
    }
}
