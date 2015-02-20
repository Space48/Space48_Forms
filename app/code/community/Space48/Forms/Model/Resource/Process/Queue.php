<?php

class Space48_Forms_Model_Resource_Process_Queue extends Space48_Forms_Model_Resource_Abstract
{
    /**
     * _construct
     */
    public function _construct()
    {
        $this->_init('space48_forms/process_queue', 'queue_id');
    }
    
    /**
     * load by form and result
     *
     * @param  Space48_Forms_Model_Process_Queue $queue
     * @param  int|Space48_Forms_Model_Form $form
     * @param  int|Space48_Forms_Model_Form_Result $result
     *
     * @return $this
     */
    public function loadByFormAndResult(Space48_Forms_Model_Process_Queue $queue, $form, $result)
    {
        // get form id
        $formId = $form instanceof Space48_Forms_Model_Form
            ? $form->getId()
            : $form;
        
        // get result id
        $resultId = $result instanceof Space48_Forms_Model_Form_Result
            ? $result->getId()
            : $result;
        
        // get read connections
        $read = $this->_getReadAdapter();
        
        // must have this object
        if ( ! $read ) {
            return $this;
        }
        
        // get select object and set it up
        $select = $read->select();
        $select->from($this->getMainTable());
        
        // set where conditions
        $select->where('form_id   = ?', $formId);
        $select->where('result_id = ?', $resultId);
        
        // fetch result
        $data = $read->fetchRow($select);
        
        // no data, return
        if ( ! $data ) {
            return $this;
        }
        
        // set data to object
        $queue->setData($data);
        
        // fire after load 
        $this->_afterLoad($queue);
        
        return $this;
    }
}
