<?php

class Space48_Forms_Block_Admin_Form_Result extends Space48_Forms_Block_Admin_Abstract_Form_Abstract
{
    /**
     * constructor
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->_controller = 'admin_form_result';
        $this->_blockGroup = 'space48_forms';
        $this->_headerText = Mage::helper('space48_forms')->__('"%s" form results', $this->_getForm()->getTitle());
        
        $this->_removeButton('add');
    }
    
    /**
     * get form
     *
     * @return Space48_Forms_Model_Form
     */
    protected function _getForm()
    {
        return Mage::helper('space48_forms')->registry('space48_forms/form');
    }
}
