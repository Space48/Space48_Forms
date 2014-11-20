<?php

class Space48_Forms_Model_Resource_Form_Fieldset extends Space48_Forms_Model_Resource_Abstract
{
    /**
     * _construct
     */
    public function _construct()
    {
        $this->_init('space48_forms/form_fieldset', 'fieldset_id');
    }
    
    /**
     * apply fields to fieldset
     *
     * @param  Space48_Forms_Model_Form_Fieldset $fieldset
     * @param  array $fields
     *
     * @return $this
     */
    public function applyFieldsToFieldset(Space48_Forms_Model_Form_Fieldset $fieldset, array $fields)
    {
        // form must have an id
        if ( ! $fieldset->getId() ) {
            return $this;
        }
        
        // get write adapter
        $write = $this->_getWriteAdapter();
        
        // form fieldset index table
        $table = $this->getTable('space48_forms/form_fieldset_field_index');
        
        // delete all existing
        $write->query("DELETE FROM {$table} WHERE `fieldset_id` = :fieldset_id", array('fieldset_id' => $fieldset->getId()));
        
        // loop and insert
        foreach ( $fields as $field ) {
            $write->query("INSERT INTO `{$table}` (`fieldset_id`, `field_id`, `position`) VALUES (:fieldset_id, :field_id, :position);", array(
                'fieldset_id' => $fieldset->getId(),
                'field_id'    => $field['id'],
                'position'    => $field['position'],
            ));
        }
        
        return $this;
    }
}
