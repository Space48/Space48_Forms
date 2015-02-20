<?php

class Space48_Forms_Block_Form_Fieldset_Field_Text extends Space48_Forms_Block_Form_Fieldset_Field_Abstract
{
    /**
     * constructor
     */
    public function _construct()
    {
        parent::_construct();
        $this->setTemplate('space48/forms/form/fieldset/field/text.phtml');
    }
    
    /**
     * get field type
     *
     * @return string
     */
    public function getFieldType()
    {
        return Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_TEXT;
    }
    
    /**
     * get css class
     *
     * @return string
     */
    public function getInputClass()
    {
        return 'input-text ' . parent::getInputClass();
    }
    
    /**
     * get input attributes
     *
     * @return array
     */
    protected function _getInputAttributes()
    {
        // merge attributes
        $attributes = array_merge(parent::_getInputAttributes(), array(
            'value'       => $this->getFieldValue(),
            'type'        => $this->getFieldType(),
            'placeholder' => $this->getFieldPlaceholder(),
        ));
        
        /**
         * auto capitalise
         */
        switch ( $this->getField()->getAutocapitalize() ) {
            case Space48_Forms_Model_Source_Ternary::VALUE_YES:
                $attributes['autocapitalize'] = 'on';
                break;
            case Space48_Forms_Model_Source_Ternary::VALUE_NO:
                $attributes['autocapitalize'] = 'off';
                break;
        }
        
        /**
         * auto correct
         */
        switch ( $this->getField()->getAutocorrect() ) {
            case Space48_Forms_Model_Source_Ternary::VALUE_YES:
                $attributes['autocorrect'] = 'on';
                break;
            case Space48_Forms_Model_Source_Ternary::VALUE_NO:
                $attributes['autocorrect'] = 'off';
                break;
        }
        
        /**
         * auto complete
         */
        switch ( $this->getField()->getAutocomplete() ) {
            case Space48_Forms_Model_Source_Ternary::VALUE_YES:
                $attributes['autocomplete'] = 'on';
                break;
            case Space48_Forms_Model_Source_Ternary::VALUE_NO:
                $attributes['autocomplete'] = 'off';
                break;
        }
        
        /**
         * spell check
         */
        switch ( $this->getField()->getSpellcheck() ) {
            case Space48_Forms_Model_Source_Ternary::VALUE_YES:
                $attributes['spellcheck'] = 'true';
                break;
            case Space48_Forms_Model_Source_Ternary::VALUE_NO:
                $attributes['spellcheck'] = 'false';
                break;
        }
        
        return $attributes;
    }
}
