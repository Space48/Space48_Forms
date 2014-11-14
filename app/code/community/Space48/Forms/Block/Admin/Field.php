<?php

class Space48_Forms_Block_Admin_Field extends Space48_Forms_Block_Admin_Abstract_Form_Abstract
{
    /**
     * @var string
     */
    protected $_addButtonLabel = 'Add Field';
    
    /**
     * constructor
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->_controller = 'admin_field';
        $this->_blockGroup = 'space48_forms';
        $this->_headerText = Mage::helper('space48_forms')->__('Fields');
    }
}
