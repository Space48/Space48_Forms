<?php

class Space48_Forms_Block_Admin_Form_Result_View_Fieldset_Field_File extends Space48_Forms_Block_Result_Fieldset_Field_File
{
    /**
     * constructor
     */
    public function _construct()
    {
        parent::_construct();
        
        // set template
        $this->setTemplate('space48/forms/form/result/view/fieldset/field/file.phtml');
    }
}
