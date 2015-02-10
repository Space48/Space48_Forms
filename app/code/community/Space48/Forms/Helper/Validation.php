<?php

class Space48_Forms_Helper_Validation extends Mage_Core_Helper_Abstract
{
    /**
     * throw exception
     *
     * @return void
     */
    public function throwException()
    {
        $args = func_get_args();
        $message = call_user_func_array(array($this, '__'), $args);
        Mage::throwException($message);
    }
}
