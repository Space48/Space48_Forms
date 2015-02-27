<?php

class Space48_Forms_Model_Resource_Form_Result_Fieldset_Field extends Space48_Forms_Model_Resource_Abstract
{
    /**
     * _construct
     */
    public function _construct()
    {
        $this->_init('space48_forms/form_result_fieldset_field', 'result_field_id');
    }
    
    /**
     * check if file exists in db
     *
     * @param  string $file
     *
     * @return bool
     */
    public function hasFile($file)
    {
        // get read adapter
        $read = $this->_getReadAdapter();
        
        // get table name
        $table = $this->getMainTable();
        
        // get select object
        $select = $read->select();
        
        // add table
        $select->from($table, null);
        
        // add count
        $select->columns('COUNT(*)');
        
        // type must be file
        $select->where('`type` = ?', 'file');
        
        // filter on file
        $select->where('`value` = ?', $file);
        
        $count = 0;
        
        // get count from db
        try {
            $count = $read->fetchOne($select);
        } catch (Exception $e) {
            // do nothing
        }
        
        return $count > 0;
    }
}
