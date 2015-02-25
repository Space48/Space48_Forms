<?php

class Space48_Forms_Block_Admin_Form_Result_Quickview extends Space48_Forms_Block_Admin_Form_Result_View
{
    /**
     * constructor
     *
     * @return void
     */
    public function _construct()
    {
        parent::_construct();
        
        // set template
        $this->setTemplate('space48/forms/form/result/quickview.phtml');
    }
}
