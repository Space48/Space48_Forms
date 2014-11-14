<?php

class Space48_Forms_Block_Admin_Fieldset extends Space48_Forms_Block_Admin_Abstract_Form_Abstract
{
    /**
     * @var string
     */
    protected $_addButtonLabel = 'Add Fieldset';
    
    /**
     * constructor
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->_controller = 'admin_fieldset';
        $this->_blockGroup = 'space48_forms';
        $this->_headerText = Mage::helper('space48_forms')->__('Fieldsets');
    }
}
