<?php

class Space48_Forms_Adminhtml_Forms_FormController
    extends Space48_Forms_Controller_Admin_Abstract
{
    /**
     * model class
     *
     * @var string
     */
    protected $_modelClass = 'space48_forms/form';
    
    /**
     * grid action
     *
     * @return void
     */
    public function gridAction()
    {
        $this->_initModel();
        $this->loadLayout('empty');
        $this->renderLayout();
    }
}
