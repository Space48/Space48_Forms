<?php

class Space48_Forms_Block_Admin_Form_Edit_Tab_Advanced extends Space48_Forms_Block_Admin_Form_Edit_Tab_Abstract
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
        
        // registered_only field
        $fieldset->addField('registered_only', 'select', array(
            'label'   => Mage::helper('space48_forms')->__('Registered Customers Only'),
            'name'    => 'registered_only',
            'note'    => Mage::helper('space48_forms')->__('If yes then only registered customers can view or submit this form.'),
            'options' => $this->_getYesNoOptions(),
            'value'   => $this->_getModel()->getRegisteredOnly(),
        ));
        
        // submit_button_text field
        $fieldset->addField('submit_button_text', 'text', array(
            'label' => Mage::helper('space48_forms')->__('Submit Button Text'),
            'name'  => 'submit_button_text',
            'note'  => Mage::helper('space48_forms')->__('Text which appears on the submit form button. This defaults to "Submit" if not set.'),
            'value' => $this->_getModel()->getSubmitButtonText(),
        ));
        
        // method field
        $fieldset->addField('method', 'select', array(
            'label'   => Mage::helper('space48_forms')->__('Form Method'),
            'name'    => 'method',
            'note'    => Mage::helper('space48_forms')->__('Whether to submit form using POST or GET.'),
            'options' => $this->_getFormMethodOptions(),
            'value'   => $this->_getModel()->getMethod(),
        ));
        
        // enctype field
        $fieldset->addField('enctype', 'select', array(
            'label'   => Mage::helper('space48_forms')->__('Form Enctype'),
            'name'    => 'enctype',
            'options' => $this->_getFormEnctypeOptions(),
            'value'   => $this->_getModel()->getEnctype(),
        ));
        
        // redirect_url field
        $fieldset->addField('redirect_url', 'text', array(
            'label' => Mage::helper('space48_forms')->__('Redirect URL'),
            'name'  => 'redirect_url',
            'note'  => Mage::helper('space48_forms')->__('If set, will redirect to this URL after a successful form submission.'),
            'value' => $this->_getModel()->getRedirectUrl(),
        ));
        
        // css_class field
        $fieldset->addField('css_class', 'text', array(
            'label' => Mage::helper('space48_forms')->__('CSS Class'),
            'name'  => 'css_class',
            'note'  => Mage::helper('space48_forms')->__('This value will be set to the utmost parent element.'),
            'value' => $this->_getModel()->getCssClass(),
        ));
        
        // frontend_block field
        $fieldset->addField('frontend_block', 'text', array(
            'label' => Mage::helper('space48_forms')->__('Frontend Block'),
            'name'  => 'frontend_block',
            'value' => $this->_getModel()->getFrontendBlock(),
        ));
        
        // frontend_template field
        $fieldset->addField('frontend_template', 'text', array(
            'label' => Mage::helper('space48_forms')->__('Frontend Template'),
            'name'  => 'frontend_template',
            'value' => $this->_getModel()->getFrontendTemplate(),
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
            'value'   => $this->_getModel()->getBackButtonShow(),
        ));
        
        // back_button_text field
        $fieldset->addField('back_button_text', 'text', array(
            'label' => Mage::helper('space48_forms')->__('Back Button Text'),
            'name'  => 'back_button_text',
            'note'  => Mage::helper('space48_forms')->__('Text which appears within the back button.'),
            'value' => $this->_getModel()->getBackButtonText(),
        ));
        
        // back_button_url field
        $fieldset->addField('back_button_url', 'text', array(
            'label' => Mage::helper('space48_forms')->__('Back Button URL'),
            'name'  => 'back_button_url',
            'note'  => Mage::helper('space48_forms')->__('The URL the user is redirect to on back button click. If not set this defaults to going back in browser history.'),
            'value' => $this->_getModel()->getBackButtonUrl(),
        ));
        
        return parent::_prepareForm();
    }
}
