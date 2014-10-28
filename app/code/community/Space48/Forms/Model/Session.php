<?php

class Space48_Forms_Model_Session extends Mage_Core_Model_Session_Abstract
{
    /**
     * constructor
     */
    public function __construct($namespace = 'space48_forms')
    {
        $this->init($namespace);
    }
}
