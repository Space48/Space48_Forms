<?php

class Space48_Forms_Block_Admin_Field_Edit_Tab_Type extends Space48_Forms_Block_Admin_Field_Edit_Tab_Abstract
{
    /**
     * prepare form
     * 
     * @return $this
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        
        // set form
        $this->setForm($form);
        
        // new fieldset
        $fieldset = $form->addFieldset('type_fieldset', array(
            'legend' => Mage::helper('space48_forms')->__('Type')
        ));
        
        // type field
        $fieldset->addField('type', 'select', array(
            'label'    => Mage::helper('space48_forms')->__('Type'),
            'name'     => 'type',
            'required' => true,
            'note'     => Mage::helper('space48_forms')->__('Type of field.'),
            'options'  => $this->_getFieldTypeOptions(),
            'value'    => $this->_getModel()->getType(),
        ));
        
        // options field
        $fieldset->addField('options', 'textarea', array(
            'label'    => Mage::helper('space48_forms')->__('Options'),
            'name'     => 'options',
            'note'     => Mage::helper('space48_forms')->__('Please enter one option per line.'),
            'value'    => $this->_getModel()->getOptions(),
        ));
        
        // file_extensions field
        $fieldset->addField('file_extensions', 'textarea', array(
            'label'    => Mage::helper('space48_forms')->__('Accepted File Extensions'),
            'name'     => 'file_extensions',
            'note'     => Mage::helper('space48_forms')->__('One per line.'),
            'value'    => $this->_getModel()->getFileExtensions(),
            'required' => true,
        ));
        
        // file size limit field
        $fieldset->addField('file_size_limit', 'text', array(
            'label'    => Mage::helper('space48_forms')->__('File Size Limit'),
            'name'     => 'file_size_limit',
            'value'    => $this->_getModel()->getFileSizeLimit(),
            'note'     => Mage::helper('space48_forms')->__('In kilobytes (1000 kilobytes ~ 1 megabyte)'),
            'required' => true,
        ));
        
        // placeholder field
        $fieldset->addField('placeholder', 'text', array(
            'label'    => Mage::helper('space48_forms')->__('Placeholder'),
            'name'     => 'placeholder',
            'value'    => $this->_getModel()->getPlaceholder(),
        ));
        
        // value field
        $fieldset->addField('value', 'text', array(
            'label'    => Mage::helper('space48_forms')->__('Default Value'),
            'name'     => 'value',
            'value'    => $this->_getModel()->getValue(),
        ));
        
        return parent::_prepareForm();
    }
    
    /**
     * get tab label
     *
     * @return string
     */
    public function getTabLabel()
    {
        return $this->__('Type');
    }

    /**
     * get tab title
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->__('Type');
    }
}
