<?php

class Space48_Forms_Block_Admin_Fieldset_Edit_Tabs extends Space48_Forms_Block_Admin_Abstract_Form_Edit_Tabs_Abstract
{
    /**
     * constructor
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->setId('space48_forms_fieldset_edit_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('space48_forms')->__('Fieldset Information'));
    }
    
    /**
     * on before "toHtml"
     *
     * @return string
     */
    protected function _beforeToHtml()
    {
        // information tab
        $this->addTab('general', 'space48_forms/admin_fieldset_edit_tab_general');
        
        // advanced tab
        $this->addTab('advanced', 'space48_forms/admin_fieldset_edit_tab_advanced');
        
        // fields tab
        $this->addTab('fields', 'space48_forms/admin_fieldset_edit_tab_fields');
        
        return parent::_beforeToHtml();
    }
}
