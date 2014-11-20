<?php

class Space48_Forms_Model_Resource_Form_Fieldset_Field_Collection extends Space48_Forms_Model_Resource_Collection_Abstract
{
    /**
     * _construct
     */
    public function _construct()
    {
        $this->_init('space48_forms/form_fieldset_field');
    }
    
    /**
     * add fieldset filter
     *
     * @param Space48_Forms_Model_Form_Fieldset|int $fieldset
     */
    public function addFieldsetFilter($fieldset)
    {
        if ( $fieldset instanceof Space48_Forms_Model_Form_Fieldset ) {
            $fieldset = $fieldset->getId();
        }
        
        // get select object
        $select = $this->getSelect();
        
        // get index table
        $table = $this->getResource()->getTable('space48_forms/form_fieldset_field_index');
        
        // create join
        $select->join(array('index' => $table), 'main_table.field_id = index.field_id', array('position'));
        
        // add where condition
        $select->where('index.fieldset_id = ?', $fieldset);
        
        return $this;
    }
}
