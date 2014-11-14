<?php

abstract class Space48_Forms_Block_Admin_Field_Edit_Tab_Abstract extends Space48_Forms_Block_Admin_Abstract_Form_Edit_Tabs_Tab_Abstract
{
    /**
     * registry key
     *
     * @var string
     */
    protected $_registryKey = 'space48_forms/form_fieldset_field';
    
    /**
     * get field type options
     *
     * @return array
     */
    protected function _getFieldTypeOptions()
    {
        $options = Mage::getSingleton('space48_forms/source_form_fieldset_field_type')->getOptionArray();
        $options = Mage::helper('space48_forms/form')->addBlankOption($options);
        
        return $options;
    }
}
