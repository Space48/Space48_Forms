<?php

class Space48_Forms_Block_Admin_Form_Edit_Tabs extends Space48_Forms_Block_Admin_Abstract_Form_Edit_Tabs_Abstract
{
    /**
     * constructor
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->setId('space48_forms_form_edit_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('space48_forms')->__('Field Information'));
    }
    
    /**
     * on before "toHtml"
     *
     * @return string
     */
    protected function _beforeToHtml()
    {
        // information tab
        $this->addTab('general', array(
            'label'   => Mage::helper('space48_forms')->__('General'),
            'title'   => Mage::helper('space48_forms')->__('General'),
            'content' => $this->getLayout()->createBlock('space48_forms/admin_form_edit_tab_general')->toHtml(),
        ));
        
        // settings tab
        $this->addTab('email', array(
            'label'   => Mage::helper('space48_forms')->__('Email'),
            'title'   => Mage::helper('space48_forms')->__('Email'),
            'content' => $this->getLayout()->createBlock('space48_forms/admin_form_edit_tab_email')->toHtml(),
        ));
        
        // settings tab
        $this->addTab('advanced', array(
            'label'   => Mage::helper('space48_forms')->__('Advanced'),
            'title'   => Mage::helper('space48_forms')->__('Advanced'),
            'content' => $this->getLayout()->createBlock('space48_forms/admin_form_edit_tab_advanced')->toHtml(),
        ));
        
        // set active tab
        if ( $tab = $this->getRequest()->getParam('tab') ) {
            $this->setActiveTab($tab);
        }
        
        return parent::_beforeToHtml();
    }
}
