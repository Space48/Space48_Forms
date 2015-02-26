<?php

class Space48_Forms_Block_Result_Email_Customer_Footer extends Space48_Forms_Block_Result_Email_Abstract
{
    /**
     * construct
     */
    public function _construct()
    {
        parent::_construct();
        
        // set template
        $this->setTemplate('space48/forms/result/email/customer/footer.phtml');
    }
}
