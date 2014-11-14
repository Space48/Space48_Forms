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
        $this->setTitle(Mage::helper('space48_forms')->__('Form Information'));
    }
    
    /**
     * on before "toHtml"
     *
     * @return string
     */
    protected function _beforeToHtml()
    {
        // information tab
        $this->addTab('general', 'space48_forms/admin_form_edit_tab_general');
        
        // email tab
        $this->addTab('email', 'space48_forms/admin_form_edit_tab_email');
        
        // settings tab
        $this->addTab('advanced', 'space48_forms/admin_form_edit_tab_advanced');
        
        // fieldsets
        $this->addTab('fieldsets', 'space48_forms/admin_form_edit_tab_fieldsets');
        
        return parent::_beforeToHtml();
    }
}
