<?php

class Space48_Forms_Block_Form_Fieldset_Field_Select extends Space48_Forms_Block_Form_Fieldset_Field_Abstract
{
    /**
     * constructor
     */
    public function _construct()
    {
        parent::_construct();
        $this->setTemplate('space48/forms/form/fieldset/field/select.phtml');
    }
    
    /**
     * get field type
     *
     * @return string
     */
    public function getFieldType()
    {
        return Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_SELECT;
    }
    
    /**
     * get css class
     *
     * @return string
     */
    public function getCssClass()
    {
        return 'input-select ' . parent::getCssClass();
    }
}
