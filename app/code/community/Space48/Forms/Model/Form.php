<?php

class Space48_Forms_Model_Form extends Space48_Forms_Model_Abstract
{
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
    
    /**
     * form enc types
     */
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
     * holds fields
     *
     * @var array
     */
    protected $_fields;
    
    /**
     * _construct
     */
    protected function _construct()
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
    
    /**
     * get fields
     *
     * @param  string $name
     *
     * @return Space48_Forms_Model_Form_Result_Fieldset_Field|array|null
     */
    public function getFields()
    {
        if ( is_null($this->_fields) ) {
            // default to empty array
            $fields = array();
            
            // loop through fieldsets
            foreach ( $this->getFieldsets() as $fieldset ) {
                // loop through fields
                foreach ( $fieldset->getFields() as $field ) {
                    // add to fields array
                    $fields[] = $field;
                }
            }
            
            // set fields
            $this->_fields = $fields;
        }
        
        // return all fields if no name given
        return $this->_fields;
    }
    
    /**
     * get field by name
     *
     * @param  string $name
     *
     * @return bool|Space48_Forms_Model_Form_Fieldset_Field
     */
    public function getFieldByName($name)
    {
        $fields = $this->getFields();
        
        foreach ( $fields as $field ) {
            if ( $field->getName() == $name ) {
                return $field;
            }
        }
        
        return false;
    }
    
    /**
     * has duplicated fields
     *
     * @return bool 
     */
    public function hasDuplicatedFields()
    {
        // get fields
        $fields = $this->getFields();
        
        // array of field names
        $names = array();
        
        // loop through fields
        foreach ( $fields as $field ) {
            
            // get name
            $name = $field->getName();
            
            // if the key does not exist, add it to the
            // names array
            if ( ! array_key_exists($name, $names) ) {
                $names[$name] = true;
            }
            
            // otherwise it did exist and therefore
            // the form has duplicates - return true
            else {
                return true;
            }
        }
        
        // no duplicates found
        return false;
    }
}
