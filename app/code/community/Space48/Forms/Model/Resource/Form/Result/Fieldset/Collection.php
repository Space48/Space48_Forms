<?php

class Space48_Forms_Model_Resource_Form_Result_Fieldset_Collection extends Space48_Forms_Model_Resource_Collection_Abstract
{
    /**
     * _construct
     */
    public function _construct()
    {
        $this->_init('space48_forms/form_result_fieldset');
    }
    
    /**
     * set form result filter
     *
     * @param int|Space48_Forms_Model_Form_Result $result
     */
    public function setFormResultFilter($result)
    {
        // get id
        $id = $result instanceof Space48_Forms_Model_Form_Result ? $result->getId() : $result;
        
        // add where condition to select
        $this->getSelect()->where('result_id = ?', $id);
        
        return $this;
    }
}
