<?php

class Space48_Forms_Block_Admin_Form_Edit extends Space48_Forms_Block_Admin_Abstract_Form_Edit_Abstract
{
    /**
     * constructor
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->_mode       = 'edit';
        $this->_objectId   = 'form_id';
        $this->_blockGroup = 'space48_forms';
        $this->_controller = 'admin_form';
        
        $this->_addButton('save_and_continue', array(
            'label'   => Mage::helper('space48_forms')->__('Save And Continue'),
            'onclick' => 'saveAndContinue()',
            'class'   => 'save',
        ), -100);
        
        $this->_formScripts[] = "       
            function saveAndContinue() {
                editForm.submit( $('edit_form').action+'back/edit/' );
            }
        ";
    }
    
    /**
     * get header text
     *
     * @return string
     */
    public function getHeaderText()
    {
        return Mage::helper('space48_forms')->__('Add/Edit Form');
    }
}
