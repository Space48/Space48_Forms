<?php

class Space48_Troubleshoot_Block_Admin_Issue_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * constructor
     */
    public function __construct()
    {
        $this->_mode       = 'edit';
        $this->_objectId   = 'id';
        $this->_blockGroup = 'space48_troubleshoot';
        $this->_controller = 'admin_issue';
        
        // add new save button
        if ( $this->_getModel()->getId() ) {
            $this->_addButton('add_child', array(
                'label'   => Mage::helper('space48_troubleshoot')->__('Add Child'),
                'onclick' => '(function(){ setLocation(\'' . $this->getAddChildUrl() . '\'); }()); return false;',
                'class'   => 'add',
            ), 1);
        }
        
        $this->_formScripts[] = '(function($){
            // find select element
            var select = $("#form_id");
            
            // should have select element
            if ( ! select.length ) {
                return;
            }
            
            // create option
            var option = $(document.createElement("option"));
            
            // build option
            option.text("Please select...");
            
            // prepend option to select
            select.prepend(option);
            
            if ( ! select.children("[selected]").length ) {
                option.prop("selected", true);
            }
            
        }(jQuery));';
        
        parent::__construct();
    }
    
    /**
     * get add child url
     *
     * @return string
     */
    protected function getAddChildUrl()
    {
        return $this->getUrl('*/*/index', array(
            'parent_id' => $this->_getParentId(),
        ));
    }
    
    /**
     * get parent id
     *
     * @return int
     */
    protected function _getParentId()
    {
        if ( $id = $this->_getModel()->getId() ) {
            return $id;
        }
        
        return 0;
    }
    
    /**
     * get model
     *
     * @return Space48_Troubleshoot_Model_Issue
     */
    protected function _getModel()
    {
        return Mage::registry('current_issue');
    }
    
    /**
     * get header text
     *
     * @return string
     */
    public function getHeaderText()
    {
        return Mage::helper('space48_troubleshoot')->__('Issue');
    }
    
    /**
     * get header css class
     *
     * @return string
     */
    public function getHeaderCssClass()
    {
        return 'head-' . strtr($this->_controller, '_', '-');
    }
    
    /**
     * to html
     *
     * @return string
     */
    protected function _toHtml()
    {
        $data = Mage::app()->getRequest()->getParams();
        
        // if we have no id or parent id
        // then we only show a message
        if ( ! array_key_exists('id', $data) && ! array_key_exists('parent_id', $data) ) {
            return $this->__('Please select an item from the left menu.');
        }
        
        return parent::_toHtml();
    }
}
