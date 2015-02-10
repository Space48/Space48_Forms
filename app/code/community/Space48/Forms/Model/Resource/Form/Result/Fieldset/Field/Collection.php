<?php

class Space48_Forms_Model_Resource_Form_Result_Fieldset_Field_Collection extends Space48_Forms_Model_Resource_Collection_Abstract
{
    /**
     * _construct
     */
    public function _construct()
    {
        $this->_init('space48_forms/form_result_fieldset_field');
    }
    
    /**
     * set form result fieldset filter
     *
     * @param int|Space48_Forms_Model_Form_Result_Fieldset $result
     */
    public function setFormResultFieldsetFilter($result)
    {
        // get id
        $id = $result instanceof Space48_Forms_Model_Form_Result_Fieldset ? $result->getId() : $result;
        
        // add where condition to select
        $this->getSelect()->where('fieldset_id = ?', $id);
        
        return $this;
    }
}
