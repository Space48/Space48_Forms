<?php

class Space48_Forms_Block_Admin_Form_Edit_Tab_Advanced extends Space48_Forms_Block_Admin_Form_Edit_Tab_Abstract
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        
        // set data model
        $form->setDataObject($this->_getForm());
        
        // set form
        $this->setForm($form);
        
        // new fieldset
        $fieldset = $form->addFieldset('settings', array(
            'legend' => Mage::helper('space48_forms')->__('Advanced Settings')
        ));
        
        // registered_only field
        $fieldset->addField('registered_only', 'select', array(
            'label'   => Mage::helper('space48_forms')->__('Registered Customers Only'),
            'name'    => 'registered_only',
            'note'    => Mage::helper('space48_forms')->__('If yes then only registered customers can view or submit this form.'),
            'options' => $this->_getYesNoOptions(),
        ));
        
        // submit_button_text field
        $fieldset->addField('submit_button_text', 'text', array(
            'label' => Mage::helper('space48_forms')->__('Submit Button Text'),
            'name'  => 'submit_button_text',
            'note'  => Mage::helper('space48_forms')->__('Text which appears on the submit form button. This defaults to "Submit" if not set.'),
        ));
        
        // method field
        $fieldset->addField('method', 'select', array(
            'label'   => Mage::helper('space48_forms')->__('Form Method'),
            'name'    => 'method',
            'note'    => Mage::helper('space48_forms')->__('Whether to submit form using POST or GET.'),
            'options' => $this->_getFormMethodOptions(),
        ));
        
        // enctype field
        $fieldset->addField('enctype', 'select', array(
            'label'   => Mage::helper('space48_forms')->__('Form Enctype'),
            'name'    => 'enctype',
            'options' => $this->_getFormEnctypeOptions(),
        ));
        
        // redirect_url field
        $fieldset->addField('redirect_url', 'text', array(
            'label' => Mage::helper('space48_forms')->__('Redirect URL'),
            'name'  => 'redirect_url',
            'note'  => Mage::helper('space48_forms')->__('If set, will redirect to this URL after a successful form submission.'),
        ));
        
        // css_class field
        $fieldset->addField('css_class', 'text', array(
            'label' => Mage::helper('space48_forms')->__('CSS Class'),
            'name'  => 'css_class',
            'note'  => Mage::helper('space48_forms')->__('This value will be set to the utmost parent element.'),
        ));
        
        // frontend_block field
        $fieldset->addField('frontend_block', 'text', array(
            'label' => Mage::helper('space48_forms')->__('Frontend Block'),
            'name'  => 'frontend_block',
            'value' => $this->_getForm()->getFrontendBlock(),
        ));
        
        // frontend_template field
        $fieldset->addField('frontend_template', 'text', array(
            'label' => Mage::helper('space48_forms')->__('Frontend Template'),
            'name'  => 'frontend_template',
            'value' => $this->_getForm()->getFrontendTemplate(),
        ));
        
        // new fieldset
        $fieldset = $form->addFieldset('back_button', array(
            'legend' => Mage::helper('space48_forms')->__('Back Button')
        ));
        
        // back_button_show field
        $fieldset->addField('back_button_show', 'select', array(
            'label'   => Mage::helper('space48_forms')->__('Show Back Button'),
            'name'    => 'back_button_show',
            'note'    => Mage::helper('space48_forms')->__('Whether to show the "back" button or not.'),
            'options' => $this->_getYesNoOptions(),
        ));
        
        // back_button_text field
        $fieldset->addField('back_button_text', 'text', array(
            'label'   => Mage::helper('space48_forms')->__('Back Button Text'),
            'name'    => 'back_button_text',
            'note'    => Mage::helper('space48_forms')->__('Text which appears within the back button.'),
        ));
        
        // back_button_url field
        $fieldset->addField('back_button_url', 'text', array(
            'label'   => Mage::helper('space48_forms')->__('Back Button URL'),
            'name'    => 'back_button_url',
            'note'    => Mage::helper('space48_forms')->__('The URL the user is redirect to on back button click. If not set this defaults to going back in browser history.'),
        ));
        
        return parent::_prepareForm();
    }
}
