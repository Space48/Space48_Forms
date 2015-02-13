<?php

class Space48_Forms_Block_Form_Fieldset_Field_File extends Space48_Forms_Block_Form_Fieldset_Field_Abstract
{
    /**
     * constructor
     */
    public function _construct()
    {
        parent::_construct();
        $this->setTemplate('space48/forms/form/fieldset/field/file.phtml');
    }
    
    /**
     * get field type
     *
     * @return string
     */
    public function getFieldType()
    {
        return Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_FILE;
    }
    
    /**
     * get css class
     *
     * @return string
     */
    public function getInputClass()
    {
        return 'input-file ' . parent::getInputClass();
    }
    
    /**
     * we're always going to show comments
     * because we want to show file size and
     * extension limits
     *
     * @return bool
     */
    public function canShowComment()
    {
        return true;
    }
    
    /**
     * get field file extensions
     *
     * @return string
     */
    public function getFieldFileExtensions()
    {
        $exts = $this->getField()->getFileExtensions();
        $exts = Mage::helper('space48_forms/form')->explode($exts, PHP_EOL);
        
        return implode(', ', $exts);
    }
    
    /**
     * get field file size limit
     *
     * @return string
     */
    public function getFieldFileSizeLimit()
    {
        $limit = $this->getField()->getFileSizeLimit() * 1;
        
        if ( $limit < 1000 ) {
            return $this->__('%sKB', $limit);
        }
        
        return $this->__('%sMB', ceil($limit / 1000));
    }
}
