<?php

abstract class Space48_Forms_Block_Admin_Abstract_Form_Edit_Form_Abstract extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * registry key
     *
     * @var string
     */
    protected $_registryKey;
    
    /**
     * get registry key
     *
     * @return string
     */
    protected function _getRegistryKey()
    {
        if ( ! $this->_registryKey ) {
            Mage::throwException(
                $this->__('Registry key is not set.')
            );
        }
        
        return $this->_registryKey;
    }
    
    /**
     * get model
     *
     * @return Mage_Core_Model_Abstract
     */
    protected function _getModel()
    {
        return Mage::helper('space48_forms')->registry( $this->_getRegistryKey() );
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
        return Mage::getSingleton('space48_forms/source_boolean')->getOptionArray();
    }
}
