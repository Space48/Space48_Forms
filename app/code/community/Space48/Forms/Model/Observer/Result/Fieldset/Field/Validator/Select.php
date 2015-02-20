<?php

class Space48_Forms_Model_Observer_Result_Fieldset_Field_Validator_Select
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
        $options = $field->getOptions(true);
        $isValue = $this->_isValue($value);
        
        // field is required, but no value
        if ( $field->getRequired() && ! $isValue ) {
            $trans->addError('This is a required field, please select an option.');
        }
        
        // no point continuing if there is no value
        // and this is not required
        if ( ! $isValue ) {
            return $this;
        }
        
        // value must exist as one of the options
        if ( ! in_array($value, $options) ) {
            $trans->addError('Invalid option selected. Please select a valid option and try again.');
        }
        
        return $this;
    }
}
