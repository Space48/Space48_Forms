<?php

class Space48_Forms_Adminhtml_Forms_FieldsetController
    extends Space48_Forms_Controller_Admin_Abstract
{
    /**
     * model class
     *
     * @var string
     */
    protected $_modelClass = 'space48_forms/form_fieldset';
    
    /**
     * grid action
     *
     * @return void
     */
    public function fieldsGridAction()
    {
        $this->_initModel();
        $this->loadLayout('empty');
        $this->renderLayout();
    }
}
