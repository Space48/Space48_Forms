<?php

class Space48_Forms_Block_Result_Email_Admin_Middle_Fieldset_Field_Checkbox extends Space48_Forms_Block_Result_Fieldset_Field_Checkbox
{
    /**
     * constructor
     */
    public function _construct()
    {
        parent::_construct();
        
        // set template
        $this->setTemplate('space48/forms/result/email/admin/fieldset/field/checkbox.phtml');
    }
}
