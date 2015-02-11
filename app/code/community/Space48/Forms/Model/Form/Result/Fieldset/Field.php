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
        $helper  = Mage::helper('space48_forms/validation');
        $options = $this->getOptions(true);
        $value   = $this->getValue();
        $errors  = array();
        
        /**
         * if field is a required field then
         * a value must exist
         */
        if ( $this->getRequired() ) {
            if ( ! strlen($value) ) {
                $errors[] = $helper->__('This is a required field, please enter a value.');
            }
        }
        
        // field type based validation
        switch ( $this->getType() ) {
            
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_TEXT:
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_TEXTAREA:
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_CHECKBOX:
                // nothing to do, yet
                break;
            
            /**
             * file validation
             */
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_FILE:
                
                // check file size
                if ( $this->getFileSize() > $this->getFileSizeLimit() ) {
                    $errors[] = $helper->__('The file you uploaded exceeds the maximum allowed file size.');
                }
                
                // check file extension
                if ( ! in_array($this->getFileExtension(), $this->getAllowedFileExtensions()) ) {
                    $errors[] = $helper->__('The file you uploaded does not match the allowed formats.');
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
        
        // set errors
        $this->setErrors($errors);
        $this->save();
        
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
}
