<?php

class Space48_Forms_Model_Resource_Form_Fieldset_Collection extends Space48_Forms_Model_Resource_Collection_Abstract
{
    /**
     * _construct
     */
    public function _construct()
    {
        $this->_init('space48_forms/form_fieldset');
    }
    
    /**
     * add form filter
     *
     * @param Space48_Forms_Model_Form|int $form
     */
    public function addFormFilter($form)
    {
        if ( $form instanceof Space48_Forms_Model_Form ) {
            $form = $form->getId();
        }
        
        // get select object
        $select = $this->getSelect();
        
        // get index table
        $table = $this->getResource()->getTable('space48_forms/form_fieldset_index');
        
        // create join
        $select->join(array('index' => $table), 'main_table.fieldset_id = index.fieldset_id', array('position'));
        
        // add where condition
        $select->where('index.form_id = ?', $form);
        
        return $this;
    }
}
