<?php

class Space48_Forms_Block_Admin_Form extends Space48_Forms_Block_Admin_Abstract_Form_Abstract
{
    /**
     * @var string
     */
    protected $_addButtonLabel = 'Add Form';
    
    /**
     * constructor
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->_controller = 'admin_form';
        $this->_blockGroup = 'space48_forms';
        $this->_headerText = Mage::helper('space48_forms')->__('Forms');
    }
}
