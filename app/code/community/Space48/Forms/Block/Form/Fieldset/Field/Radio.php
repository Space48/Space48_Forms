<?php

class Space48_Forms_Block_Form_Fieldset_Field_Radio extends Space48_Forms_Block_Form_Fieldset_Field_Abstract
{
    /**
     * constructor
     */
    public function _construct()
    {
        parent::_construct();
        $this->setTemplate('space48/forms/form/fieldset/field/radio.phtml');
    }
    
    /**
     * get field type
     *
     * @return string
     */
    public function getFieldType()
    {
        return Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_RADIO;
    }
    
    /**
     * get css class
     *
     * @return string
     */
    public function getInputClass()
    {
        return 'input-radio radio ' . parent::getInputClass();
    }
}
