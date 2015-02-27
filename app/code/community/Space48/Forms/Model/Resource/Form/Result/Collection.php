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
    
    /**
     * add older than days filter
     *
     * @param int $days
     */
    public function addOlderThanDaysFilter($days)
    {
        // get now
        $timestamp = Mage::helper('space48_forms')->now();
        
        // minus 7 days
        $timestamp = $timestamp - ( $days * 24 * 60 * 60 );
        
        // get date string
        $date = date('Y-m-d H:i:s', $timestamp);
        
        // add where condition
        $this->getSelect()->where('created_at < ?', $date);
        
        return $this;
    }
    
    /**
     * add invalid status filter
     */
    public function addInvalidStatusFilter()
    {
        return $this->addStatusFilter(Space48_Forms_Model_Source_Form_Result_Status::STATUS_INVALID);
    }
    
    /**
     * add valid status filter
     */
    public function addValidStatusFilter()
    {
        return $this->addStatusFilter(Space48_Forms_Model_Source_Form_Result_Status::STATUS_VALID);
    }
    
    /**
     * add status filter
     *
     * @param string $status
     */
    public function addStatusFilter($status)
    {
        switch ( $status ) {
            case Space48_Forms_Model_Source_Form_Result_Status::STATUS_VALID:
            case Space48_Forms_Model_Source_Form_Result_Status::STATUS_INVALID:
                
                // add where condition
                $this->getSelect()->where('status = ?', $status);
                
                break;
        }
        
        return $this;
    }
}
