<?php

class Space48_Forms_Block_Result_Email_Admin_Middle extends Space48_Forms_Block_Result_Email_Abstract
{
    /**
     * construct
     */
    public function _construct()
    {
        parent::_construct();
        
        // set template
        $this->setTemplate('space48/forms/result/email/admin/middle.phtml');
    }
    
    /**
     * get result fieldsets
     *
     * @return Space48_Forms_Model_Resource_Form_Result_Fieldset_Collection
     */
    public function getFieldsets()
    {
        return $this->getResult()->getResultFieldsets();
    }
    
    /**
     * get fieldset html
     *
     * @param  Space48_Forms_Model_Form_Result_Fieldset $fieldset
     *
     * @return string
     */
    public function getFieldsetHtml(Space48_Forms_Model_Form_Result_Fieldset $fieldset)
    {
        if ( ! $this->_canShowFieldset($fieldset) ) {
            return '';
        }
        
        // create block
        $block = $this->getLayout()->createBlock('space48_forms/result_email_admin_middle_fieldset');
        
        if ( ! $block ) {
            return '';
        }
        
        // set fieldset
        $block->setFieldset($fieldset);
        $block->setParentBlock($this);
        
        return $block->toHtml();
    }
    
    /**
     * can we show fieldset?
     * 
     * @param  Space48_Forms_Model_Form_Result_Fieldset $fieldset
     * 
     * @return bool
     */
    protected function _canShowFieldset(Space48_Forms_Model_Form_Result_Fieldset $fieldset)
    {
        // must have at least one visible field
        $_hasVisibleFields = false;
        
        // loop through fields
        foreach ( $fieldset->getResultFields() as $field ) {
            // if this field is visible in email
            if ( $field->getShowInAdminEmail() ) {
                // set flag to true and break from loop
                $_hasVisibleFields = true;
                break;
            }
        }
        
        // by this point we should have determined that 
        // this fieldset has or hasn't any visible fields
        if ( ! $_hasVisibleFields ) {
            return false;
        }
        
        return true;
    }
    
    /**
     * get form data
     *
     * @return array
     */
    public function getFormData()
    {
        return array(
            'Form ID'    => $this->getForm()->getId(),
            'Form Title' => $this->getForm()->getTitle(),
            'Result ID'  => $this->getResult()->getId(),
            'Submitted'  => $this->getResult()->getCreatedAt(),
        );
    }
}
