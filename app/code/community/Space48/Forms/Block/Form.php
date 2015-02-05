<?php

class Space48_Forms_Block_Form extends Space48_Forms_Block_Form_Abstract
{
    /**
     * get form
     * 
     * @todo remove this method
     * 
     * @return Space48_Forms_Model_Form
     */
    public function getForm()
    {
        if ( is_null($this->_form) ) {
            $this->_form = Mage::getModel('space48_forms/form')->load(3);
        }
        
        return parent::getForm();
    }
}
