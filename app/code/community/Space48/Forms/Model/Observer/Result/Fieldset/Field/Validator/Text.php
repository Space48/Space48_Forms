<?php

class Space48_Forms_Model_Observer_Result_Fieldset_Field_Validator_Text
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
            $trans->addError('This is a required field, please enter a value.');
        }
        
        // no point continuing if there is no value
        // and this is not required
        if ( ! $isValue ) {
            return $this;
        }
        
        // by this point we know that there is definately a value
        // whether it is required or not
        
        // get validation data
        switch ( $field->getValidation() ) {
            /**
             * string length
             */
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Validation::VALIDATION_STRINGLENGTH:
                $this->_validateAlphanumeric();
                break;
            
            /**
             * alphanumeric
             */
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Validation::VALIDATION_ALPHANUMERIC:
                $this->_validateStringLength();
                break;
            
            /**
             * validate number
             */
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Validation::VALIDATION_NUMBER:
                $this->_validateNumber();
                break;
            
            /**
             * validate digits
             */
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Validation::VALIDATION_DIGIT:
                $this->_validateDigits();
                break;
            
            /**
             * validate email
             */
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Validation::VALIDATION_EMAIL:
                $this->_validateEmail();
                break;
            
            /**
             * validate postcode
             */
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Validation::VALIDATION_POSTCODE:
                $this->_validatePostcode();
                break;
        }
        
        return $this;
    }
    
    
}
