<?php

class Space48_Forms_Block_Result_Email_Customer_Middle_Fieldset_Field_Select extends Space48_Forms_Block_Result_Fieldset_Field_Select
{
    /**
     * constructor
     */
    public function _construct()
    {
        parent::_construct();
        
        // set template
        $this->setTemplate('space48/forms/result/email/customer/fieldset/field/select.phtml');
    }
}
