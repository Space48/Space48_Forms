<?php

abstract class Space48_Forms_Block_Admin_Form_Edit_Tab_Abstract extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * get form model
     *
     * @return Space48_Forms_Model_Form
     */
    protected function _getForm()
    {
        return Mage::helper('space48_forms')->registry('space48_forms/form');
    }
    
    /**
     * get wysiwyg config
     *
     * @return Varien_Object
     */
    protected function _getWywiwygConfig()
    {
        return Mage::getSingleton('cms/wysiwyg_config')->getConfig(array(
            'width' => '800px',
            'hidden' => true
        ));
    }
    
    /**
     * get yes/no options (boolean)
     *
     * @return array
     */
    protected function _getYesNoOptions()
    {
        return Mage::getSingleton('adminhtml/system_config_source_yesno')->toArray();
    }
    
    /**
     * get admin email template options
     *
     * @return array
     */
    protected function _getAdminEmailTemplateOptions()
    {
        $_options = Mage::getSingleton('adminhtml/system_config_source_email_template')
            ->setPath('space48_forms/general/admin_notification_email_template')
            ->toOptionArray();
        
        $options = array();
        
        foreach ( $_options as $option ) {
            $options[$option['value']] = $option['label'];
        }
        
        return $options;
    }
    
    /**
     * get customer email template options
     *
     * @return array
     */
    protected function _getCustomerEmailTemplateOptions()
    {
        $_options = Mage::getSingleton('adminhtml/system_config_source_email_template')
            ->setPath('space48_forms/general/customer_notification_email_template')
            ->toOptionArray();
        
        $options = array();
        
        foreach ( $_options as $option ) {
            $options[$option['value']] = $option['label'];
        }
        
        return $options;
    }
    
    /**
     * get form methods
     *
     * @return array
     */
    protected function _getFormMethodOptions()
    {
        return array(
            'POST' => 'POST',
            'GET'  => 'GET',
        );
    }
    
    /**
     * get form enctype
     *
     * @return array
     */
    protected function _getFormEnctypeOptions()
    {
        return array(
            'multipart/form-data'               => 'multipart/form-data',
            'application/x-www-form-urlencoded' => 'application/x-www-form-urlencoded',
            'text/plain'                        => 'text/plain',
        );
    }
}
