<?php

class Space48_Forms_Block_Result_Email_Customer_Middle extends Mage_Core_Block_Template
{
    /**
     * construct
     */
    public function _construct()
    {
        parent::_construct();
        
        // set template
        $this->setTemplate('space48/forms/result/email/customer/middle.phtml');
    }
}
