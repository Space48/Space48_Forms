<?php

class Space48_Forms_Model_Observer_Result_Fieldset_Field_Validator_Checkbox
    extends Space48_Forms_Model_Observer_Result_Fieldset_Field_Validator_Abstract
{
    /**
     * validate
     *
     * @return bool
     */
    protected function _validate()
    {
        /**
         * field
         *
         * @var Space48_Forms_Model_Form_Result_Fieldset_Field
         */
        $field = $this->_getField();
        $trans = $this->_getTransport();
        
        // get value
        $value   = $field->getValue();
        $isValue = $this->_isValue($value);
        
        // field is required, but no value
        if ( $field->getRequired() && ! $isValue ) {
            $trans->addError('This is a required field - you must select this to continue.');
        }
        
        // no point continuing if there is no value
        // and this is not required
        if ( ! $isValue ) {
            return $this;
        }
        
        // cast as string
        $value = (string) $value;
        
        // must equal either '0' or '1'
        if ( $value !== '0' && $value !== '1' ) {
            $trans->addError('This is a required field - you must select this to continue.');
        }
        
        return $this;
    }
    
    
}
