<?php

class Space48_Forms_Block_Admin_Field_Edit_Tabs extends Space48_Forms_Block_Admin_Abstract_Form_Edit_Tabs_Abstract
{
    /**
     * constructor
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->setId('space48_forms_field_edit_tabs');
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
        $this->addTab('general', 'space48_forms/admin_field_edit_tab_general');
        
        // type tab
        $this->addTab('type', 'space48_forms/admin_field_edit_tab_type');
        
        // advanced tab
        $this->addTab('advanced', 'space48_forms/admin_field_edit_tab_advanced');
        
        
        return parent::_beforeToHtml();
    }
}
