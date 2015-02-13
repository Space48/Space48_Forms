<?php

abstract class Space48_Forms_Model_Observer_Result_Fieldset_Field_Validator_Abstract
{
    /**
     * holds transport object
     *
     * @var Space48_Forms_Model_Form_Result_Fieldset_Field_ValidationTransport
     */
    protected $_transport;
    
    /**
     * hold field
     *
     * @var Space48_Forms_Model_Form_Result_Fieldset_Field
     */
    protected $_field;
    
    /**
     * get field 
     *
     * @return Space48_Forms_Model_Form_Result_Fieldset_Field
     */
    protected function _getField()
    {
        return $this->_field;
    }
    
    /**
     * get transport 
     *
     * @return Space48_Forms_Model_Form_Result_Fieldset_Field_ValidationTransport
     */
    protected function _getTransport()
    {
        return $this->_transport;
    }
    
    /**
     * validate
     *
     * @return bool
     */
    final public function validate(Varien_Event_Observer $observer)
    {
        // extract vars from observer
        $transport = $observer->getEvent()->getTransport();
        $field     = $observer->getEvent()->getField();
        
        // must be instanceof...
        if ( ! ( $transport instanceof Space48_Forms_Model_Form_Result_Fieldset_Field_ValidationTransport ) ) {
            return $this;
        }
        
        // must be instanceof...
        if ( ! ( $field instanceof Space48_Forms_Model_Form_Result_Fieldset_Field ) ) {
            return $this;
        }
        
        // set vars
        $this->_transport = $transport;
        $this->_field = $field;
        
        // fire child class validate method
        $this->_validate();
        
        return $this;
    }
    
    /**
     * validate
     *
     * @return bool
     */
    abstract protected function _validate();
    
    /**
     * check if we have a value
     *
     * @param  string $value
     *
     * @return bool
     */
    protected function _isValue($value)
    {
        // check if value is null
        if ( $value === null ) {
            return false;
        }
        
        // if the value is a string, check we have
        // a length of more than zero, otherwise
        // it is not a value
        if ( is_string($value) ) {
            return strlen($value) > 0;
        }
        
        // check if value is numeric
        if ( is_numeric($value) ) {
            return true;
        }
        
        // check if is bool
        if ( is_bool($value) ) {
            return true;
        }
        
        return false;
    }
    
    /**
     * is string length
     *
     * @return $this
     */
    protected function _validateStringLength()
    {
        // get field and transport
        $field = $this->_getField();
        $trans = $this->_getTransport();
        
        // get value
        $value = $field->getValue();
        
        // get validator
        $validator = new Zend_Validate_StringLength();
        
        // set min
        if ( $min = $field->getValidationData('min') ) {
            $validator->setMin($min);
        }
        
        // set max
        if ( $max = $field->getValidationData('max') ) {
            $validator->setMax($max);
        }
        
        if ( ! $validator->isValid($value) ) {
            if ( $min && $max ) {
                $trans->addError('The value entered should be between %s and %s characters.', $min, $max);
            } elseif ($min) {
                $trans->addError('The value entered should be atleast %s characters.', $min);
            } elseif ($max) {
                $trans->addError('The value entered should be at most %s characters.', $max);
            }
        }
        
        return $this;
    }
    
    /**
     * validate case
     *
     * @return 
     */
    protected function _validateCase()
    {
        // get field and transport
        $field = $this->_getField();
        $trans = $this->_getTransport();
        
        // get value
        $value = $field->getValue();
        
        switch ( $field->getValidationData('case') ) {
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Validation_Case::CASE_UPPERCASE:
                if ( strtoupper($value) != $value ) {
                    $trans->addError('Please enter only uppercase letters.');
                }
            
                break;
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Validation_Case::CASE_LOWERCASE:
                if ( strtolower($value) != $value ) {
                    $trans->addError('Please enter only lowercase letters.');
                }
                
                break;
        }
        
        return $this;
    }
    
    /**
     * validate number
     *
     * @return $this
     */
    protected function _validateNumber()
    {
        // get field and transport
        $field = $this->_getField();
        $trans = $this->_getTransport();
        
        // get value
        $value = $field->getValue();
        
        // value must be numeric
        if ( ! is_numeric($value) ) {
            $trans->addError('Please enter a numeric value.');
            
            // because value is not numeric we don't need to continue
            // with other validations
            return $this;
        }
        
        // get min/max
        $min = $field->getValidationData('min');
        $max = $field->getValidationData('max');
        $inc = $field->getValidationData('inclusive');
        
        // min and max
        if ( $min && $max ) {
            // get validator
            $validator = new Zend_Validate_Between(array(
                'min' => $min,
                'max' => $max,
            ));
            
            // set inclusive if value is defined
            if ( $inc !== null ) {
                $validator->setInclusive($inc);
            }
            
            if ( ! $validator->isValid($value) ) {
                $trans->addError('Please enter a value between %s and %s.', $min, $max);
            }
        }
        
        // min only
        elseif ( $min ) {
            $validator = new Zend_Validate_GreaterThan(array(
                'min' => $min,
            ));
            
            if ( ! $validator->isValid($value) ) {
                $trans->addError('Please enter a value greater than %s.', $min);
            }
        }
        
        // max only
        elseif ( $max ) {
            $validator = new Zend_Validate_LessThan(array(
                'max' => $max,
            ));
            
            if ( ! $validator->isValid($value) ) {
                $trans->addError('Please enter a value less than %s.', $max);
            }
        }
        
        return $this;
    }
    
    /**
     * validate digits
     *
     * @return $this
     */
    protected function _validateDigits()
    {
        // get field and transport
        $field = $this->_getField();
        $trans = $this->_getTransport();
        
        // get value
        $value = $field->getValue();
        
        // get validator
        $validator = new Zend_Validate_Digits();
        
        // validate
        if ( ! $validator->isValid($value) ) {
            $trans->addError('Please enter digits (0-9) only.');
        }
        
        return $this;
    }
    
    /**
     * validate alphanumeric value
     *
     * @return $this
     */
    protected function _validateAlphanumeric()
    {
        // get field and transport
        $field = $this->_getField();
        $trans = $this->_getTransport();
        
        // get value
        $value = $field->getValue();
        
        // get validator
        $validator = new Zend_Validate_Alnum();
        
        // set whitespace allowed
        if ( $field->getValidationData('allow_whitespace') ) {
            $validator->setAllowWhiteSpace(true);
        }
        
        // check if is valid
        if ( ! $validator->isValid($value) ) {
            $trans->addError('This is a required field, please select a valid file.');
        }
        
        // if we have min or max values
        if ( $field->getValidationData('min') || $field->getValidationData('max') ) {
            $this->_validateStringLength();
        }
        
        if ( $field->getValidationData('case') ) {
            $this->_validateCase();
        }
        
        return $this;
    }
    
    /**
     * validate email address
     *
     * @return $this
     */
    protected function _validateEmail()
    {
        // get field and transport
        $field = $this->_getField();
        $trans = $this->_getTransport();
        
        // get value
        $value = $field->getValue();
        
        // get validator
        $validator = new Zend_Validate_EmailAddress();
        
        // validate
        if ( ! $validator->isValid($value) ) {
            $trans->addError('Please enter a valid email address.');
        }
        
        return $this;
    }
    
    /**
     * validate postcode
     *
     * @return $this
     */
    protected function _validatePostcode()
    {
        // get field and transport
        $field = $this->_getField();
        $trans = $this->_getTransport();
        
        // get value
        $postcode = $field->getValue();
        
        // do some general cleanup
        $postcode = str_replace(' ', null, $postcode);
        $postcode = trim($postcode);
        $postcode = strtolower($postcode);
        
        // permitted letters depend upon their position in the postcode.
        $alpha1 = "[abcdefghijklmnoprstuwyz]"; // character set 1
        $alpha2 = "[abcdefghklmnopqrstuvwxy]"; // character set 2
        $alpha3 = "[abcdefghjkpmnrstuvwxy]";   // character set 3
        $alpha4 = "[abehmnprvwxy]";            // character set 4
        $alpha5 = "[abdefghjlnpqrstuwxyz]";    // character set 5
        $BFPOa5 = "[abdefghjlnpqrst]{1}";      // bfpo character 5
        $BFPOa6 = "[abdefghjlnpqrstuwzyz]{1}"; // bfpo character 6
        
        // expressions
        $expressions = array(
            // expression for bf1 type postcodes 
            '/^(bf1)([[:space:]]{0,})([0-9]{1}' . $BFPOa5 . $BFPOa6 .')$/',
            
            // expression for postcodes: an naa, ann naa, aan naa, and aann naa with a space
            '/^('.$alpha1.'{1}'.$alpha2.'{0,1}[0-9]{1,2})([[:space:]]{0,})([0-9]{1}'.$alpha5.'{2})$/',
            
            // expression for postcodes: ana naa
            '/^('.$alpha1.'{1}[0-9]{1}'.$alpha3.'{1})([[:space:]]{0,})([0-9]{1}'.$alpha5.'{2})$/',
            
            // expression for postcodes: aana naa
            '/^('.$alpha1.'{1}'.$alpha2.'{1}[0-9]{1}'.$alpha4.')([[:space:]]{0,})([0-9]{1}'.$alpha5.'{2})$/',
            
            // exception for the special postcode gir 0aa
            '/^(gir)([[:space:]]{0,})(0aa)$/',
            
            // standard bfpo numbers
            '/^(bfpo)([[:space:]]{0,})([0-9]{1,4})$/',
            
            // c/o bfpo numbers
            '/^(bfpo)([[:space:]]{0,})(c\/o([[:space:]]{0,})[0-9]{1,3})$/',
            
            // overseas territories
            '/^([a-z]{4})([[:space:]]{0,})(1zz)$/',
        );
        
        // assume not found
        $found = false;
        
        // check the string against the six types of postcodes
        foreach ( $expressions as $regexp ) {
            if ( preg_match($regexp, $postcode) ) {
                // we have found a valid post code
                $found = true;
                
                // break out of loop
                break;
            }
        }
        
        if ( ! $found ) {
            $trans->addError('Please enter a valid postcode.');
        }
        
        return $this;
    }
}
