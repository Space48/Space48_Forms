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
}
