<?php

class Space48_Forms_Model_Form_Result_Fieldset_Field extends Space48_Forms_Model_Abstract
{
    /**
     * holds form result fieldset model
     *
     * @var Space48_Forms_Model_Form_Result_Fieldset
     */
    protected $_formResultFieldset;
    
    /**
     * _construct
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('space48_forms/form_result_fieldset_field');
    }
    
    /**
     * validate field value
     *
     * @return bool
     */
    public function validate()
    {
        // transport object
        $transport = new Space48_Forms_Model_Form_Result_Fieldset_Field_ValidationTransport();
        
        // create event handles
        $standard = 'space48_forms_result_fieldset_field_validate';
        $specific = 'space48_forms_result_fieldset_field_validate_' . $this->getType();
        
        // event data
        $data = array(
            'field'     => $this,
            'transport' => $transport,
        );
        
        // dispatch events
        Mage::dispatchEvent($standard, $data);
        Mage::dispatchEvent($specific, $data);
        
        // get errors
        $errors = $transport->getErrors();
        
        // set errors
        $this->setErrors($errors);
        $this->save();
        
        if ( ! $transport->isValid() ) {
            // an empty exception will do
            throw new Exception();
        }
        
        return $this;
        
        
        // variables
        $helper  = Mage::helper('space48_forms/validation');
        $options = $this->getOptions(true);
        $value   = $this->getValue();
        
        // errors array
        $errors = array();
        
        // validation data
        $validation = $this->getValidation();
        $validationData = $this->getValidationData();
        
        /**
         * if field is a required field then
         * a value must exist
         */
        if ( $this->getRequired() ) {
            if ( ! strlen($value) ) {
                $errors[] = $helper->__('This is a required field.');
            }
        }
        
        // field type based validation
        switch ( $this->getType() ) {
            
            /**
             * text and textarea
             */
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_TEXT:
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_TEXTAREA:
                $helper->validate($validation, $validationData, $value);
                break;
            
            /**
             * checkbox
             */
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_CHECKBOX:
                break;
            
            /**
             * file validation
             */
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_FILE:
                
                // only continue if we require an upload
                // the required check is done above
                if ( ! strlen($value) ) {
                    break;
                }
                
                // check file size
                if ( $fileSizeLimit = $this->getFileSizeLimit() ) {
                    if ( $this->getFileSize() > $fileSizeLimit ) {
                        $errors[] = $helper->__('');
                    }
                }
                
                // check file extension
                if ( ! in_array($this->getFileExtension(), $this->getAllowedFileExtensions()) ) {
                    $errors[] = $helper->__('');
                }
                
                break;
            
            /**
             * select/radio validation
             */
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_RADIO:
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_SELECT:
                
                // value must exist as one of the options
                if ( ! in_array($value, $options) ) {
                    $errors[] = $helper->__('Invalid option selected. Please select a valid option and try again.');
                }
                
                break;
        }
        
        
        
        return count($errors) < 1;
    }
    
    /**
     * set errors
     *
     * @param array $errors
     */
    public function setErrors(array $errors)
    {
        if ( $errors && count($errors) ) {
            $this->setData('errors', json_encode($errors));
        } else {
            $this->setData('errors', '');
        }
        
        return $this;
    }
    
    /**
     * get errors
     *
     * @return array
     */
    public function getErrors()
    {
        $errors = $this->_getData('errors');
        
        if ( $errors ) {
            return json_decode($errors);
        }
        
        return array();
    }
    
    /**
     * set form result fieldset model
     *
     * @param Space48_Forms_Model_Form_Result_Fieldset $fieldset
     */
    public function setFormResultFieldset(Space48_Forms_Model_Form_Result_Fieldset $fieldset)
    {
        $this->_formResultFieldset = $fieldset;
        
        if ( $id = $fieldset->getId() ) {
            $this->setFieldsetId($id);
        }
        
        return $this;
    }
    
    /**
     * get form result fieldset model
     *
     * @return Space48_Forms_Model_Form_Result_Fieldset
     */
    public function getFormResultFieldset()
    {
        if ( is_null($this->_formResultFieldset) ) {
            $this->_formResultFieldset = Mage::getModel('space48_forms/form_result_fieldset');
            
            if ( $id = $this->getFieldsetId() ) {
                $this->_formResultFieldset->load($id);
            }
        }
        
        return $this->_formResultFieldset;
    }
    
    /**
     * set fieldset data
     *
     * @param Space48_Forms_Model_Form_Fieldset_Field $field
     */
    public function setField(Space48_Forms_Model_Form_Fieldset_Field $field)
    {
        $this->addData(array(
            'name'                   => $field->getName(),
            'label'                  => $field->getLabel(),
            'title'                  => $field->getTitle(),
            'type'                   => $field->getType(),
            'options'                => $field->getOptions(),
            'comment'                => $field->getComment(),
            'hint'                   => $field->getHint(),
            'file_extensions'        => $field->getFileExtensions(),
            'file_size_limit'        => $field->getFileSizeLimit(),
            'validation'             => $field->getValidation(),
            'validation_data'        => $field->getValidationDataJson(),
            'required'               => $field->getRequired() ? '1' : '0',
            'show_in_admin_email'    => $field->getShowInAdminEmail() ? '1' : '0',
            'show_in_customer_email' => $field->getShowInCustomerEmail() ? '1' : '0',
        ));
        
        return $this;
    }
    
    /**
     * set value
     *
     * @param mixed $value
     */
    public function setValue($value)
    {
        switch ( $this->getType() ) {
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_TEXT:
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_TEXTAREA:
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_RADIO:
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_SELECT:
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_FILE:
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_CHECKBOX:
                // nothing to do here
                break;
        }
        
        $this->setData('value', $value);
        
        return $this;
    }
    
    /**
     * get value
     *
     * @return array|string
     */
    public function getValue()
    {
        $value = $this->getData('value');
        
        switch ( $this->getType() ) {
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_TEXT:
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_TEXTAREA:
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_RADIO:
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_SELECT:
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_FILE:
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_CHECKBOX:
                // nothing to do here
                break;
        }
        
        return $value;
    }
    
    /**
     * get file upload directory
     *
     * @return string
     */
    public function getFileUploadDirectory()
    {
        return Mage::helper('space48_forms/form')->getFileUploadPath();
    }
    
    /**
     * get file path
     *
     * @return string
     */
    public function getFilePath()
    {
        return $this->getFileUploadDirectory() . DS . $this->getValue();
    }
    
    /**
     * get file size
     *
     * @return int
     */
    public function getFileSize()
    {
        return floor( filesize( $this->getFilePath() ) / 1000 );
    }
    
    /**
     * get file extension
     *
     * @return string
     */
    public function getFileExtension()
    {
        return pathinfo($this->getValue(), PATHINFO_EXTENSION);
    }
    
    /**
     * get file exists
     *
     * @return boolean
     */
    public function getFileExists()
    {
        return file_exists($this->getFilePath());
    }
    
    /**
     * get allowed file extensions
     *
     * @return array
     */
    public function getAllowedFileExtensions()
    {
        $extentions = $this->getFileExtensions();
        $extentions = Mage::helper('space48_forms/form')->explode($extentions, PHP_EOL);
        return $extentions;
    }
    
    /**
     * upload file
     *
     * @param  string $name
     * @param  array $data
     *
     * @return $this
     */
    public function upload($name, array $data)
    {
        try {
            // instantiate uploader
            $uploader = new Varien_File_Uploader($name);
            $uploader->setAllowCreateFolders(true);
            $uploader->setAllowRenameFiles(true);
            $uploader->setFilesDispersion(true);
            
            // set allowed file extensions
            $extentions = $this->getAllowedFileExtensions();
            
            if ( $extentions && count($extentions) ) {
                $uploader->setAllowedExtensions($extentions);
            }
            
            // get save path
            $path = $this->getFileUploadDirectory();
            
            // generate file name
            $name = $this->getName() . '.' . $uploader->getFileExtension();
            $name = strtolower($name);
            
            // upload the file
            $file = $uploader->save($path, $name);
            
            // set value
            $this->setValue($file['file']);
        }
        
        // catch exception
        catch (Exception $e) {
            
            // helper
            $helper = Mage::helper('space48_forms');
            
            // errors array
            $errors = array();
            
            // set specific error message for this exception
            if ( $e->getMessage() == 'Disallowed file type.' ) {
                $errors[] = $helper->__('Invalid file format, please select a valid file and try again.');
            }
            // any other exception
            else {
                $errors[] = $helper->__('Unable to upload your file, please reselect the file and try again.');
            }
            
            // set and store errors
            $this->setErrors($errors);
            $this->save();
            
            $helper->throwException('Unable to upload file.');
        }
        
        return $this;
    }
    
    /**
     * get options
     *
     * @param  bool $asArray
     *
     * @return array|string
     */
    public function getOptions($asArray = false)
    {
        // get options
        $options = parent::getOptions();
        
        if ( $asArray ) {
            $options = Mage::helper('space48_forms/form')->explode($options, PHP_EOL);
        }
        
        return $options;
    }
    
    /**
     * get validation data
     *
     * @param  string|null $key
     *
     * @return string|null
     */
    public function getValidationData($key = null)
    {
        if ( is_null($this->_validationData) ) {
            
            // get raw value
            $data = $this->_getData('validation_data');
            
            // check if is array
            if ( ! is_array($data) ) {
                // if not then json decode
                $data = (array) json_decode($data);
            }
            
            // cache value
            $this->_validationData = $data;
        }
        
        if ( is_null($key) ) {
            return $this->_validationData;
        }
        
        if ( array_key_exists($key, $this->_validationData) ) {
            return $this->_validationData[$key];
        }
        
        return null;
    }
    
    /**
     * get validation data json
     *
     * @return string
     */
    public function getValidationDataJson()
    {
        return $this->_getData('validation_data');
    }
}
