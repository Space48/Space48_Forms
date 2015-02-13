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
        
        $this->_validationSection($form);
        
        $this->_browserSection($form);
        
        return parent::_prepareForm();
    }
    
    /**
     * setup validation section
     *
     * @param  Varien_Data_Form $form
     *
     * @return $this
     */
    protected function _validationSection(Varien_Data_Form $form)
    {
        // new fieldset
        $fieldset = $form->addFieldset('validation_fieldset', array(
            'legend' => Mage::helper('space48_forms')->__('Validation')
        ));
        
        // required field
        $fieldset->addField('required', 'select', array(
            'label'    => Mage::helper('space48_forms')->__('Required'),
            'name'     => 'required',
            'note'     => Mage::helper('space48_forms')->__('This field will be a required field if set to "Yes".'),
            'value'    => $this->_getModel()->getRequired(),
            'options'  => $this->_getYesNoOptions(),
        ));
        
        // type field
        $fieldset->addField('validation', 'select', array(
            'label'    => Mage::helper('space48_forms')->__('Validation'),
            'name'     => 'validation',
            'note'     => Mage::helper('space48_forms')->__('Validate user input.'),
            'options'  => $this->_getValidationOptions(),
            'value'    => $this->_getModel()->getValidation(),
        ));
        
        // minimum field
        $fieldset->addField('validation_min', 'text', array(
            'label'    => Mage::helper('space48_forms')->__('Minimum'),
            'name'     => 'validation_data[min]',
            'value'    => $this->_getModel()->getValidationData('min'),
        ));
        
        // maximum field
        $fieldset->addField('validation_max', 'text', array(
            'label'    => Mage::helper('space48_forms')->__('Maximum'),
            'name'     => 'validation_data[max]',
            'value'    => $this->_getModel()->getValidationData('max'),
        ));
        
        // allow_whitespace field
        $fieldset->addField('validation_allow_whitespace', 'select', array(
            'label'    => Mage::helper('space48_forms')->__('Allow Whitespace'),
            'name'     => 'validation_data[allow_whitespace]',
            'options'  => $this->_getYesNoOptions(),
            'value'    => $this->_getModel()->getValidationData('allow_whitespace'),
        ));
        
        // case field
        $fieldset->addField('validation_case', 'select', array(
            'label'    => Mage::helper('space48_forms')->__('Case'),
            'name'     => 'validation_data[case]',
            'value'    => $this->_getModel()->getValidationData('case'),
            'options'  => $this->_getValidationCaseOptions(),
        ));
    }
    
    /**
     * setup browser specific section
     *
     * @param  Varien_Data_Form $form
     *
     * @return $this
     */
    protected function _browserSection(Varien_Data_Form $form)
    {
        // new fieldset
        $fieldset = $form->addFieldset('browser_settings', array(
            'legend' => Mage::helper('space48_forms')->__('Browser Dependent Settings')
        ));
        
        // autocapitalize field
        $fieldset->addField('autocapitalize', 'select', array(
            'label'    => Mage::helper('space48_forms')->__('Autocapitalise'),
            'name'     => 'autocapitalize',
            'note'     => Mage::helper('space48_forms')->__('Whether to autocapitalise the input.'),
            'value'    => $this->_getModel()->getAutocapitalize(),
            'options'  => $this->_getTernaryOptions(),
        ));
        
        // autocorrect field
        $fieldset->addField('autocorrect', 'select', array(
            'label'    => Mage::helper('space48_forms')->__('Autocorrect'),
            'name'     => 'autocorrect',
            'note'     => Mage::helper('space48_forms')->__('Whether to autocorrect the input.'),
            'value'    => $this->_getModel()->getAutocorrect(),
            'options'  => $this->_getTernaryOptions(),
        ));
        
        // spellcheck field
        $fieldset->addField('spellcheck', 'select', array(
            'label'    => Mage::helper('space48_forms')->__('Spellcheck'),
            'name'     => 'spellcheck',
            'note'     => Mage::helper('space48_forms')->__('Whether to spellcheck the input.'),
            'value'    => $this->_getModel()->getSpellcheck(),
            'options'  => $this->_getTernaryOptions(),
        ));
        
        // autocomplete field
        $fieldset->addField('autocomplete', 'select', array(
            'label'    => Mage::helper('space48_forms')->__('Autocomplete'),
            'name'     => 'autocomplete',
            'note'     => Mage::helper('space48_forms')->__('Whether to autocomplete the input.'),
            'value'    => $this->_getModel()->getAutocomplete(),
            'options'  => $this->_getTernaryOptions(),
        ));
        
        return $this;
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
