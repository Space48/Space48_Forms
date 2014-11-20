<?php

class Space48_Forms_Model_Resource_Form extends Space48_Forms_Model_Resource_Abstract
{
    /**
     * _construct
     */
    public function _construct()
    {
        $this->_init('space48_forms/form', 'form_id');
    }
    
    /**
     * take given fieldsets and create relationship between
     * form and fieldset in database
     *
     * @param  Space48_Forms_Model_Form $form
     * @param  array $fieldsets
     *
     * @return $this
     */
    public function applyFieldsetsToForm(Space48_Forms_Model_Form $form, array $fieldsets)
    {
        // form must have an id
        if ( ! $form->getId() ) {
            return $this;
        }
        
        // get write adapter
        $write = $this->_getWriteAdapter();
        
        // form fieldset index table
        $table = $this->getTable('space48_forms/form_fieldset_index');
        
        // delete all existing
        $write->query("DELETE FROM {$table} WHERE `form_id` = :form_id", array('form_id' => $form->getId()));
        
        // loop and insert
        foreach ( $fieldsets as $fieldset ) {
            $write->query("INSERT INTO `{$table}` (`form_id`, `fieldset_id`, `position`) VALUES (:form_id, :fieldset_id, :position);", array(
                'form_id'     => $form->getId(),
                'fieldset_id' => $fieldset['id'],
                'position'    => $fieldset['position'],
            ));
        }
        
        return $this;
    }
}
