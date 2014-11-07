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
        $this->validate();
        
        return parent::_beforeSave();
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
        $block = Mage::app()->getLayout()->createBlock( $this->getFrontendBlock() );
        
        if ( ! ( $block instanceof Space48_Forms_Block_Form_Abstract ) ) {
            Mage::helper('space48_forms')->throwException('Please define a block which extends "Space48_Forms_Block_Form_Abstract".');
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
}
