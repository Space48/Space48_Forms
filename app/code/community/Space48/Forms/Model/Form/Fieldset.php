<?php

class Space48_Forms_Model_Form_Fieldset extends Space48_Forms_Model_Abstract
{
    /**
     * default renderer details
     */
    const DEFAULT_FRONTEND_BLOCK    = 'space48_forms/form_fieldset';
    const DEFAULT_FRONTEND_TEMPLATE = 'space48/forms/form/fieldset.phtml';
    
    /**
     * holds fieldsets
     *
     * @var Space48_Forms_Model_Resource_Form_Fieldset_Field_Collection
     */
    protected $_fields;
    
    /**
     * _construct
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('space48_forms/form_fieldset');
    }
    
    /**
     * on before save
     *
     * @return $this
     */
    protected function _beforeSave()
    {
        $this->validate();
        
        return parent::_beforeSave();
    }
    
    /**
     * on after save
     *
     * @return $this
     */
    protected function _afterSave()
    {
        // save fieldsets
        $this->_saveFields();
        
        parent::_afterSave();
    }
    
    /**
     * save fields
     *
     * @return $this
     */
    protected function _saveFields()
    {
        // we need to ensure that the "fields"
        // variable exists in the data because
        // otherwise on save we will delete
        // existing relationships when we're
        // not supposed to
        if ( ! $this->hasData('fields') ) {
            return $this;
        }
        
        // get posted data
        $fields = $this->getData('fields');
        
        // we need to decode this if set
        if ( $fields ) {
            // decode the serialized input
            $fields = Mage::helper('adminhtml/js')->decodeGridSerializedInput($fields);
        }
        
        // should now be an array, otherwise
        // we create an empty array
        if ( ! is_array($fields) ) {
            $fields = array();
        }
        
        // we need to normalise this array
        $normalised = array();
        
        foreach ( $fields as $id => $field ) {
            $normalised[] = array(
                'id'       => $id,
                'position' => $field['position'],
            );
        }
        
        // create relationships in database
        $this->getResource()->applyFieldsToFieldset($this, $normalised);
        
        return $this;
    }
    
    /**
     * validate data
     *
     * @return $this
     */
    public function validate()
    {
        // validate block
        if ( $this->getFrontendBlock() != Space48_Forms_Model_Form_Fieldset::DEFAULT_FRONTEND_BLOCK ) {
            $block = Mage::app()->getLayout()->createBlock( $this->getFrontendBlock() );
            
            if ( ! ( $block instanceof Space48_Forms_Block_Form_Abstract ) ) {
                Mage::helper('space48_forms')->throwException('Please define a block which extends "Space48_Forms_Block_Form_Abstract".');
            }
        }
        
        return $this;
    }
    
    /**
     * get frontend block
     *
     * @return string
     */
    public function getFrontendBlock()
    {
        if ( $block = $this->_getData('frontend_block') ) {
            return $block;
        }
        
        return Space48_Forms_Model_Form_Fieldset::DEFAULT_FRONTEND_BLOCK;
    }
    
    /**
     * get frontend template
     *
     * @return string
     */
    public function getFrontendTemplate()
    {
        if ( $template = $this->_getData('frontend_template') ) {
            return $template;
        }
        
        return Space48_Forms_Model_Form_Fieldset::DEFAULT_FRONTEND_TEMPLATE;
    }
    
    public function getFields()
    {
        if ( is_null($this->_fields) ) {
            // load collection
            $collection = Mage::getResourceModel('space48_forms/form_fieldset_field_collection');
            $collection->addFieldsetFilter($this);
            
            $this->_fields = $collection;
        }
        
        return $this->_fields;
    }
}
