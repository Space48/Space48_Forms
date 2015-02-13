<?php

class Space48_Forms_Block_Form_Fieldset_Field_Checkbox extends Space48_Forms_Block_Form_Fieldset_Field_Abstract
{
    /**
     * constructor
     */
    public function _construct()
    {
        parent::_construct();
        $this->setTemplate('space48/forms/form/fieldset/field/checkbox.phtml');
    }
    
    /**
     * get field type
     *
     * @return string
     */
    public function getFieldType()
    {
        return Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_CHECKBOX;
    }
    
    /**
     * get css class
     *
     * @return string
     */
    public function getInputClass()
    {
        return 'input-checkbox checkbox' . parent::getInputClass();
    }
}
