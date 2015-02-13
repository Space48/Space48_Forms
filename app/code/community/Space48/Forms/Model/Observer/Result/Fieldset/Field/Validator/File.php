<?php

class Space48_Forms_Model_Observer_Result_Fieldset_Field_Validator_File
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
        
        // field is required
        if ( $field->getRequired() ) {
            
            // but has no value - no file was uploaded
            if ( ! $field->getValue() ) {
                $trans->addError('This is a required field, please select a valid file.');
            }
            
            // field has value but file does not exist
            elseif ( ! $field->getFileExists() ) {
                $trans->addError('Unable to upload file, please try again.');
            }
        }
        
        // field is not required
        else {
            // but a file was uploaded
            if ( $field->getValue() ) {
                // however it does not exist
                if ( ! $field->getFileExists() ) {
                    $trans->addError('Unable to upload file, please try again.');
                }
            }
            
            // we dont have a value, so we should just return
            else {
                return $this;
            }
        }
        
        // if there is a file size limit
        if ( $limit = $field->getFileSizeLimit() ) {
            // and the file size is greater than the limit
            if ( $field->getFileSize() > $limit ) {
                $trans->addError('The file you uploaded exceeds the maximum allowed file size.');
            }
        }
        
        // get allowed file extensions if they exist
        if ( $allowed = $field->getAllowedFileExtensions() ) {
            // they must be an array and more then zero
            if ( is_array($allowed) && count($allowed) ) {
                // if file extension is not in allowed list then
                if ( ! in_array($field->getFileExtension(), $allowed) ) {
                    $trans->addError('The file you uploaded does not match the allowed formats.');
                }
            }
        }
        
        return $this;
    }
}
