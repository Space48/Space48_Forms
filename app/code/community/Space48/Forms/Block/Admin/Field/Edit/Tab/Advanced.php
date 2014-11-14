<?php

class Space48_Forms_Block_Admin_Field_Edit_Tab_Advanced extends Space48_Forms_Block_Admin_Field_Edit_Tab_Abstract
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        
        // set form
        $this->setForm($form);
        
        // new fieldset
        $fieldset = $form->addFieldset('settings', array(
            'legend' => Mage::helper('space48_forms')->__('Advanced Settings')
        ));
        
        // css_style field
        $fieldset->addField('css_style', 'text', array(
            'label' => Mage::helper('space48_forms')->__('CSS Style'),
            'name'  => 'css_style',
            'note'  => Mage::helper('space48_forms')->__('Add additional styling to elements.'),
            'value' => $this->_getModel()->getCssStyle(),
        ));
        
        // css_class field
        $fieldset->addField('css_class', 'text', array(
            'label' => Mage::helper('space48_forms')->__('CSS Class'),
            'name'  => 'css_class',
            'note'  => Mage::helper('space48_forms')->__('This value will be set to the input element.'),
            'value' => $this->_getModel()->getCssClass(),
        ));
        
        // container_class field
        $fieldset->addField('container_class', 'text', array(
            'label' => Mage::helper('space48_forms')->__('Container CSS Class'),
            'name'  => 'container_class',
            'note'  => Mage::helper('space48_forms')->__('This value will be set to the utmost parent element.'),
            'value' => $this->_getModel()->getContainerClass(),
        ));
        
        // show_in_admin_email field
        $fieldset->addField('show_in_admin_email', 'select', array(
            'label'    => Mage::helper('space48_forms')->__('Show In Admin Email'),
            'name'     => 'show_in_admin_email',
            'note'     => Mage::helper('space48_forms')->__('Whether to show value in the admin email.'),
            'value'    => $this->_getModel()->getId() ? $this->_getModel()->getShowInAdminEmail() : Space48_Forms_Model_Source_Boolean::VALUE_YES,
            'options'  => $this->_getYesNoOptions(),
        ));
        
        // show_in_customer_email field
        $fieldset->addField('show_in_customer_email', 'select', array(
            'label'    => Mage::helper('space48_forms')->__('Show In Customer Email'),
            'name'     => 'show_in_customer_email',
            'note'     => Mage::helper('space48_forms')->__('Whether to show value in the customer email.'),
            'value'    => $this->_getModel()->getId() ? $this->_getModel()->getShowInCustomerEmail() : Space48_Forms_Model_Source_Boolean::VALUE_YES,
            'options'  => $this->_getYesNoOptions(),
        ));
        
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
            'options'  => $this->_getYesNoOptions(),
        ));
        
        // autocorrect field
        $fieldset->addField('autocorrect', 'select', array(
            'label'    => Mage::helper('space48_forms')->__('Autocorrect'),
            'name'     => 'autocorrect',
            'note'     => Mage::helper('space48_forms')->__('Whether to autocorrect the input.'),
            'value'    => $this->_getModel()->getAutocorrect(),
            'options'  => $this->_getYesNoOptions(),
        ));
        
        // spellcheck field
        $fieldset->addField('spellcheck', 'select', array(
            'label'    => Mage::helper('space48_forms')->__('Spellcheck'),
            'name'     => 'spellcheck',
            'note'     => Mage::helper('space48_forms')->__('Whether to spellcheck the input.'),
            'value'    => $this->_getModel()->getSpellcheck(),
            'options'  => $this->_getYesNoOptions(),
        ));
        
        // autocomplete field
        $fieldset->addField('autocomplete', 'select', array(
            'label'    => Mage::helper('space48_forms')->__('Autocomplete'),
            'name'     => 'autocomplete',
            'note'     => Mage::helper('space48_forms')->__('Whether to autocomplete the input.'),
            'value'    => $this->_getModel()->getAutocomplete(),
            'options'  => $this->_getYesNoOptions(),
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
        return $this->__('Advanced');
    }

    /**
     * get tab title
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->__('Advanced');
    }
}
