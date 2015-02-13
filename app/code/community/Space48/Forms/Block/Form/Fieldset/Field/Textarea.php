<?php

class Space48_Forms_Block_Form_Fieldset_Field_Textarea extends Space48_Forms_Block_Form_Fieldset_Field_Text
{
    /**
     * constructor
     */
    public function _construct()
    {
        parent::_construct();
        $this->setTemplate('space48/forms/form/fieldset/field/textarea.phtml');
    }
    
    /**
     * get field type
     *
     * @return string
     */
    public function getFieldType()
    {
        return Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_TEXTAREA;
    }
    
    /**
     * get css class
     *
     * @return string
     */
    public function getInputClass()
    {
        $class = 'input-textarea ' . parent::getInputClass();
        $class = str_replace('input-text ', null, $class);
        $class = trim($class);
        
        return $class;
    }
    
    /**
     * get input attributes
     *
     * @return array
     */
    protected function _getInputAttributes()
    {
        // merge attributes
        $attributes = parent::_getInputAttributes();
        
        // unset attributes not used (from parent class)
        unset($attributes['value'], $attributes['type']);
        
        return $attributes;
    }
}
