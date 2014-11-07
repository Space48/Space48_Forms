<?php

abstract class Space48_Forms_Block_Admin_Form_Edit_Tab_Abstract extends Space48_Forms_Block_Admin_Abstract_Form_Edit_Tabs_Tab_Abstract
{
    /**
     * registry key
     *
     * @var string
     */
    protected $_registryKey = 'space48_forms/form';
    
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
