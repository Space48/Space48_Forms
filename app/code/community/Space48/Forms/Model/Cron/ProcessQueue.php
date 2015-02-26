<?php

class Space48_Forms_Model_Cron_ProcessQueue extends Space48_Forms_Model_Cron_Abstract
{
    /**
     * run cron
     *
     * @return $this
     */
    public function run()
    {
        // get queue items
        $queue = Mage::getResourceModel('space48_forms/process_queue_collection');
        $queue->addFreshFilter();
        $queue->setLimit(20);
        
        foreach ( $queue as $item ) {
            try {
                
                // dispatch event
                Mage::dispatchEvent('space48_forms_queue_process_run', array(
                    'item' => $item,
                ));
                
                // set item complete status. we are assuming
                // that if we get to this point we have executed
                // all the required actions to complete this
                // queued item
                //$item->setComplete();
                
            } catch (Exception $e) {
                
                // log the exception
                Mage::log($e->getMessage(), null, 'space48_forms_cron.log');
                
                // try/catch inception
                try {
                    // dispatch event to handle failure
                    Mage::dispatchEvent('space48_forms_queue_process_run_fail', array(
                        'exception' => $e,
                        'item'      => $item,
                    ));
                } catch (Exception $e) {
                    // do nothing what-so-ever
                }
            }
        }
        
        return $this;
    }
}
