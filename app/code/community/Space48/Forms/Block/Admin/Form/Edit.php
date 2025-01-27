<?php

class Space48_Forms_Block_Admin_Form_Edit extends Space48_Forms_Block_Admin_Abstract_Form_Edit_Abstract
{
    /**
     * constructor
     */
    public function __construct()
    {
        $this->_mode       = 'edit';
        $this->_objectId   = 'form_id';
        $this->_blockGroup = 'space48_forms';
        $this->_controller = 'admin_form';
        
        parent::__construct();
        
        // remove default save button
        $this->_removeButton('save');
        
        // add new save button
        $this->_addButton('save', array(
            'label'   => Mage::helper('adminhtml')->__('Save'),
            'onclick' => '(function(){ space48_form.save(); }()); return false;',
            'class'   => 'save',
        ), 1);
        
        // add save and continue button
        $this->_addButton('save_and_continue', array(
            'label'   => Mage::helper('space48_forms')->__('Save And Continue'),
            'onclick' => '(function(){ space48_form.save(true); }()); return false;',
            'class'   => 'save',
        ), 2);
        
        $this->_formScripts[] = "
            var space48_form = new Space48Forms.Form_Form(editForm);
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
    
    /**
     * get validation url
     *
     * @return string
     */
    public function getValidationUrl()
    {
        return $this->getUrl('*/*/validate');
    }
}
