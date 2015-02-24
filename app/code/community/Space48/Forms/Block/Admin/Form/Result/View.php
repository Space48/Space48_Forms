<?php

class Space48_Forms_Block_Admin_Form_Result_View extends Mage_Adminhtml_Block_Template
{
    /**
     * constructor
     *
     * @return void
     */
    public function _construct()
    {
        parent::_construct();
        
        // set template
        $this->setTemplate('space48/forms/form/result/view.phtml');
    }
    
    /**
     * get fieldsets
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
        // get block
        $block = $this->getLayout()->getBlock('space48_forms_fieldset');
        
        // return empty string if we do not have it
        if ( ! $block ) {
            return '';
        }
        
        // set vars
        $block->setFieldset($fieldset);
        $block->setResult($this->getResult());
        $block->setParentBlock($this);
        
        return $block->toHtml();
    }
    
    /**
     * get result
     *
     * @return Space48_Forms_Model_Form_Result
     */
    public function getResult()
    {
        return Mage::helper('space48_forms')->registry('space48_forms/form_result');
    }
    
    /**
     * get form
     *
     * @return Space48_Forms_Model_Form
     */
    public function getForm()
    {
        return Mage::helper('space48_forms')->registry('space48_forms/form');
    }
    
    /**
     * get result meta data
     *
     * @return array
     */
    public function getResultMetaData()
    {
        return array_filter(array(
            'Title'                      => $this->getResult()->getTitle(),
            'Description'                => $this->getResult()->getDescription(),
            'Instructions'               => $this->getResult()->getInstructions(),
            'Before Form Content'        => $this->getResult()->getBeforeFormContent(),
            'After Form Content'         => $this->getResult()->getAfterFormContent(),
            'Registered Customers Only?' => $this->getResult()->getRegisteredOnly() ? $this->__('Yes') : $this->__('No'),
            'Customer ID'                => $this->_getCustomerMetaData(),
        ));
    }
    
    /**
     * get customer meta data
     *
     * @return string
     */
    protected function _getCustomerMetaData()
    {
        // get customer id
        $id = 1;$this->getResult()->getCustomerId();
        
        // if no id, then return empty string
        if ( ! $id ) {
            return '';
        }
        
        // build customer edit url
        $url = $this->getUrl('*/customer/edit', array('id' => $id));
        
        return $this->__('%s (<a href="%s" target="_blank">view</a>)', $id, $url);
    }
    
    /**
     * get back url
     *
     * @return string
     */
    public function getBackUrl()
    {
        return $this->getUrl('*/*/index', array(
            'form_id'   => $this->getForm()->getId(),
            'result_id' => $this->getResult()->getId(),
        ));
    }
}
