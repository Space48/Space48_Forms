<?php

abstract class Space48_Forms_Model_Cron_Abstract
{
    /**
     * run
     *
     * @return $this
     */
    final public function run()
    {
        // run if module is enabled
        if ( Mage::helper('space48_forms')->isEnabled() ) {
            $this->_run();
        }
        
        return $this;
    }
    
    /**
     * run cron
     *
     * @return void
     */
    abstract protected function _run();
}
