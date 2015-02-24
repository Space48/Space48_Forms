<?php

class Space48_Forms_Model_Resource_Form_Result_Collection extends Space48_Forms_Model_Resource_Collection_Abstract
{
    /**
     * _construct
     */
    public function _construct()
    {
        $this->_init('space48_forms/form_result');
    }
    
    /**
     * add form filter
     *
     * @param int|Space48_Forms_Model_Form $form
     */
    public function addFormFilter($form)
    {
        // get form id
        $formId = $form instanceof Space48_Forms_Model_Form
            ? $form->getId()
            : $form;
        
        // add where condition
        $this->getSelect()->where('form_id = ?', $formId);
        
        return $this;
    }
}
