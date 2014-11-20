<?php

class Space48_Forms_Model_Form extends Space48_Forms_Model_Abstract
{
    /**
     * status
     */
    const STATUS_ENABLED  = '1';
    const STATUS_DISABLED = '2';
    
    /**
     * default renderer details
     */
    const DEFAULT_FRONTEND_BLOCK    = 'space48_forms/form';
    const DEFAULT_FRONTEND_TEMPLATE = 'space48/forms/form.phtml';
    
    /**
     * form methods
     */
    const FORM_METHOD_POST = 'POST';
    const FORM_METHOD_GET  = 'GET';
    
    const FORM_ENCTYPE_MULTIPART_FORM_DATA               = 'multipart/form-data';
    const FORM_ENCTYPE_APPLICATION_X_WWW_FORM_URLENCODED = 'application/x-www-form-urlencoded';
    const FORM_ENCTYPE_TEXT_PLAIN                        = 'text/plain';
    
    /**
     * holds fieldsets
     *
     * @var Space48_Forms_Model_Resource_Form_Fieldset_Collection
     */
    protected $_fieldsets;
    
    /**
     * _construct
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('space48_forms/form');
    }
    
    /**
     * on before save
     *
     * @return $this
     */
    protected function _beforeSave()
    {
        // ensure we have valid data
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
        $this->_saveFieldsets();
        
        parent::_afterSave();
    }
    
    /**
     * save fieldsets
     *
     * @return $this
     */
    protected function _saveFieldsets()
    {
        // we need to ensure that the "fieldsets"
        // variable exists in the data because
        // otherwise on save we will delete
        // existing relationships when we're
        // not supposed to
        if ( ! $this->hasData('fieldsets') ) {
            return $this;
        }
        
        // get posted data
        $fieldsets = $this->getData('fieldsets');
        
        // we need to decode this if set
        if ( $fieldsets ) {
            // decode the serialized input
            $fieldsets = Mage::helper('adminhtml/js')->decodeGridSerializedInput($fieldsets);
        }
        
        // should now be an array, otherwise
        // we create an empty array
        if ( ! is_array($fieldsets) ) {
            $fieldsets = array();
        }
        
        // we need to normalise this array
        $normalised = array();
        
        foreach ( $fieldsets as $id => $fieldset ) {
            $normalised[] = array(
                'id'       => $id,
                'position' => $fieldset['position'],
            );
        }
        
        // create relationships in database
        $this->getResource()->applyFieldsetsToForm($this, $normalised);
        
        return $this;
    }
    
    /**
     * validate data
     *
     * @return $this
     */
    public function validate()
    {
        // must have a unique code
        if ( ! $this->getCode() ) {
            Mage::helper('space48_forms')->throwException('Please enter a unique code to identify the form.');
        }
        
        // validate form method
        switch ( $this->getMethod() ) {
            case Space48_Forms_Model_Form::FORM_METHOD_POST:
            case Space48_Forms_Model_Form::FORM_METHOD_GET:
            break;
            default:
                Mage::helper('space48_forms')->throwException(
                    'Form method must either be "%s" or "%s".',
                    Space48_Forms_Model_Form::FORM_METHOD_POST,
                    Space48_Forms_Model_Form::FORM_METHOD_GET
                );
            break;
        }
        
        // validate enctype
        switch ( $this->getEnctype() ) {
            case Space48_Forms_Model_Form::FORM_ENCTYPE_MULTIPART_FORM_DATA:
            case Space48_Forms_Model_Form::FORM_ENCTYPE_APPLICATION_X_WWW_FORM_URLENCODED:
            case Space48_Forms_Model_Form::FORM_ENCTYPE_TEXT_PLAIN:
            break;
            default:
                Mage::helper('space48_forms')->throwException(
                    'Form method must either be "%s", "%s" or "%s".',
                    Space48_Forms_Model_Form::FORM_ENCTYPE_MULTIPART_FORM_DATA,
                    Space48_Forms_Model_Form::FORM_ENCTYPE_APPLICATION_X_WWW_FORM_URLENCODED,
                    Space48_Forms_Model_Form::FORM_ENCTYPE_TEXT_PLAIN
                );
            break;
        }
        
        // validate block
        if ( $this->getFrontendBlock() != Space48_Forms_Model_Form::DEFAULT_FRONTEND_BLOCK ) {
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
        
        return Space48_Forms_Model_Form::DEFAULT_FRONTEND_BLOCK;
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
        
        return Space48_Forms_Model_Form::DEFAULT_FRONTEND_TEMPLATE;
    }
    
    /**
     * get fieldsets
     *
     * @return Space48_Forms_Model_Resource_Form_Fieldset_Collection
     */
    public function getFieldsets()
    {
        if ( is_null($this->_fieldsets) ) {
            // load collection
            $collection = Mage::getResourceModel('space48_forms/form_fieldset_collection');
            $collection->addFormFilter($this);
            
            $this->_fieldsets = $collection;
        }
        
        return $this->_fieldsets;
    }
}
