<?php

class Space48_Forms_Block_Admin_Form_Result_Quickview_Fieldset_Field_Checkbox extends Space48_Forms_Block_Admin_Form_Result_View_Fieldset_Field_Checkbox
{
    /**
     * constructor
     */
    public function _construct()
    {
        parent::_construct();
        
        // set template
        $this->setTemplate('space48/forms/form/result/quickview/fieldset/field/checkbox.phtml');
    }
}
