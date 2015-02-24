<?php

class Space48_Forms_Block_Result_Fieldset_Field_File extends Space48_Forms_Block_Result_Fieldset_Field_Abstract
{
    /**
     * constructor
     */
    public function _construct()
    {
        parent::_construct();
        
        // set template
        $this->setTemplate('space48/forms/result/fieldset/field/file.phtml');
    }
    
    /**
     * get value
     *
     * @return string
     */
    public function getValue()
    {
        // get value
        $value = $this->getField()->getValue();
        
        // if we have nothing - assume no file uploaded
        if ( ! $value ) {
            return $this->__('No file uploaded.');
        }
        
        // get file upload path
        $path = Mage::helper('space48_forms/form')->getFileUploadPath() . $value;
        
        // if file does not exist or we cannot read it then
        // show error
        if ( ! file_exists($path) || ! is_readable($path) ) {
            return 'Unable to locate uploaded file.';
        }
        
        // build url to file
        $url = Mage::helper('space48_forms/form')->getFileUploadUrl() . $value;
        
        return $this->__('<a href="%s" target="_blank">%s</a>', $url, $url);
    }
}
