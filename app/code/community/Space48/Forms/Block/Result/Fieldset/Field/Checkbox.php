<?php

class Space48_Forms_Block_Result_Fieldset_Field_Checkbox extends Space48_Forms_Block_Result_Fieldset_Field_Abstract
{
    /**
     * constructor
     */
    public function _construct()
    {
        parent::_construct();
        
        // set template
        $this->setTemplate('space48/forms/result/fieldset/field/checkbox.phtml');
    }
    
    /**
     * get options
     *
     * @return array
     */
    public function getOptions($asArray = true)
    {
        return array(
            '1' => $this->__('True'),
            '0' => $this->__('False'),
        );
    }
}
