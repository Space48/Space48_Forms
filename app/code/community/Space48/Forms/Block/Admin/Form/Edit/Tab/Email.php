<?php

class Space48_Forms_Block_Admin_Form_Edit_Tab_Email extends Space48_Forms_Block_Admin_Form_Edit_Tab_Abstract
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        
        // set form
        $this->setForm($form);
        
        // new fieldset
        $fieldset = $form->addFieldset('admin_email', array(
            'legend' => Mage::helper('space48_forms')->__('Admin Email Settings')
        ));
        
        // email_admin field
        $fieldset->addField('email_admin', 'select', array(
            'label'   => Mage::helper('space48_forms')->__('Send Email Nofication'),
            'name'    => 'email_admin',
            'note'    => Mage::helper('space48_forms')->__('Whether to send the admin user email notifications.'),
            'options' => $this->_getYesNoOptions(),
            'value'   => $this->_getModel()->getEmailAdmin(),
        ));
        
        // email_admin_address_to field
        $fieldset->addField('email_admin_address_to', 'textarea', array(
            'label' => Mage::helper('space48_forms')->__('Email Address To'),
            'name'  => 'email_admin_address_to',
            'note'  => Mage::helper('space48_forms')->__('One per line. If not set, will use default "general" contact from within system configuration settings.'),
            'value' => $this->_getModel()->getEmailAdminAddressTo(),
        ));
        
        // email_admin_address_cc field
        $fieldset->addField('email_admin_address_cc', 'textarea', array(
            'label' => Mage::helper('space48_forms')->__('Email Address CC'),
            'name'  => 'email_admin_address_cc',
            'note'  => Mage::helper('space48_forms')->__('One per line.'),
            'value' => $this->_getModel()->getEmailAdminAddressCc(),
        ));
        
        // email_admin_address_bcc field
        $fieldset->addField('email_admin_address_bcc', 'textarea', array(
            'label' => Mage::helper('space48_forms')->__('Email Address BCC'),
            'name'  => 'email_admin_address_bcc',
            'note'  => Mage::helper('space48_forms')->__('One per line.'),
            'value' => $this->_getModel()->getEmailAdminAddressBcc(),
        ));
        
        // email_admin_template field
        $fieldset->addField('email_admin_template', 'select', array(
            'label'   => Mage::helper('space48_forms')->__('Email Template'),
            'name'    => 'email_admin_template',
            'note'    => Mage::helper('space48_forms')->__('If not set, will use default template from within system configuration settings.'),
            'options' => $this->_getAdminEmailTemplateOptions(),
            'value'   => $this->_getModel()->getEmailAdminTemplate(),
        ));
        
        // new fieldset
        $fieldset = $form->addFieldset('customer_email', array(
            'legend' => Mage::helper('space48_forms')->__('Customer Email Settings')
        ));
        
        // email_customer field
        $fieldset->addField('email_customer', 'select', array(
            'label'   => Mage::helper('space48_forms')->__('Send Email Nofication'),
            'name'    => 'email_customer',
            'note'    => Mage::helper('space48_forms')->__('Whether to send the customer email notifications.'),
            'options' => $this->_getYesNoOptions(),
            'value'   => $this->_getModel()->getEmailCustomer(),
        ));
        
        // email_customer_address_cc field
        $fieldset->addField('email_customer_address_cc', 'textarea', array(
            'label' => Mage::helper('space48_forms')->__('Email Address CC'),
            'name'  => 'email_customer_address_cc',
            'note'  => Mage::helper('space48_forms')->__('One per line.'),
            'value' => $this->_getModel()->getEmailCustomerAddressCc(),
        ));
        
        // email_customer_address_bcc field
        $fieldset->addField('email_customer_address_bcc', 'textarea', array(
            'label' => Mage::helper('space48_forms')->__('Email Address BCC'),
            'name'  => 'email_customer_address_bcc',
            'note'  => Mage::helper('space48_forms')->__('One per line.'),
            'value' => $this->_getModel()->getEmailCustomerAddressBcc(),
        ));
        
        // email_customer_replyto field
        $fieldset->addField('email_customer_replyto', 'text', array(
            'label' => Mage::helper('space48_forms')->__('Reply To Email Address'),
            'name'  => 'email_customer_replyto',
            'note'  => Mage::helper('space48_forms')->__('The email address the customer will reply to.'),
            'value' => $this->_getModel()->getEmailCustomerReplyto(),
        ));
        
        // email_customer_template field
        $fieldset->addField('email_customer_template', 'select', array(
            'label'   => Mage::helper('space48_forms')->__('Email Template'),
            'name'    => 'email_customer_template',
            'note'    => Mage::helper('space48_forms')->__('If not set, will use default template from within system configuration settings.'),
            'options' => $this->_getCustomerEmailTemplateOptions(),
            'value'   => $this->_getModel()->getEmailCustomerTemplate(),
        ));
        
        // email_customer_content field
        $fieldset->addField('email_customer_content', 'editor', array(
            'label'   => Mage::helper('space48_forms')->__('Email Content'),
            'name'    => 'email_customer_content',
            'note'    => Mage::helper('space48_forms')->__('Main content within the email.'),
            'wysiwyg' => true,
            'config'  => $this->_getWywiwygConfig(),
            'style'   => 'width:800px',
            'value'   => $this->_getModel()->getEmailCustomerContent(),
        ));
        
        // email_customer_show_results field
        $fieldset->addField('email_customer_show_results', 'select', array(
            'label'   => Mage::helper('space48_forms')->__('Show Results'),
            'name'    => 'email_customer_show_results',
            'note'    => Mage::helper('space48_forms')->__('Whether to show results of the form to the customer.'),
            'options' => $this->_getYesNoOptions(),
            'value'   => $this->_getModel()->getEmailCustomerShowResults(),
        ));
        
        // email_customer_before_results_content field
        $fieldset->addField('email_customer_before_results_content', 'editor', array(
            'label'   => Mage::helper('space48_forms')->__('Before Results Content'),
            'name'    => 'email_customer_before_results_content',
            'note'    => Mage::helper('space48_forms')->__('This content appears immediately before the form results.'),
            'wysiwyg' => true,
            'config'  => $this->_getWywiwygConfig(),
            'style'   => 'width:800px',
            'value'   => $this->_getModel()->getEmailCustomerBeforeResultsContent(),
        ));
        
        // email_customer_after_results_content field
        $fieldset->addField('email_customer_after_results_content', 'editor', array(
            'label'   => Mage::helper('space48_forms')->__('After Results Content'),
            'name'    => 'email_customer_after_results_content',
            'note'    => Mage::helper('space48_forms')->__('This content appears immediately after the form results.'),
            'wysiwyg' => true,
            'config'  => $this->_getWywiwygConfig(),
            'style'   => 'width:800px',
            'value'   => $this->_getModel()->getEmailCustomerAfterResultsContent(),
        ));
        
        // email_customer_footer_content field
        $fieldset->addField('email_customer_footer_content', 'editor', array(
            'label'   => Mage::helper('space48_forms')->__('Footer Content'),
            'name'    => 'email_customer_footer_content',
            'note'    => Mage::helper('space48_forms')->__('This content appears in the footer of the email.'),
            'wysiwyg' => true,
            'config'  => $this->_getWywiwygConfig(),
            'style'   => 'width:800px',
            'value'   => $this->_getModel()->getEmailCustomerFooterContent(),
        ));
        
        return parent::_prepareForm();
    }
}
