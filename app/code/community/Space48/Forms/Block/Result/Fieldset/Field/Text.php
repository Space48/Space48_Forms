<?php

class Space48_Forms_Block_Result_Fieldset_Field_Text extends Space48_Forms_Block_Result_Fieldset_Field_Abstract
{
    /**
     * constructor
     */
    public function _construct()
    {
        parent::_construct();
        
        // set template
        $this->setTemplate('space48/forms/result/fieldset/field/text.phtml');
    }
}
