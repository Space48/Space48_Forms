<?php

class Space48_Forms_Model_Form_Fieldset extends Space48_Forms_Model_Abstract
{
    /**
     * holds fieldsets
     *
     * @var Space48_Forms_Model_Resource_Form_Fieldset_Field_Collection
     */
    protected $_fields;
    
    /**
     * _construct
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('space48_forms/form_fieldset');
    }
}
