<?php

abstract class Space48_Forms_Block_Form_Fieldset_Abstract
    extends Mage_Core_Block_Template
        implements Space48_Forms_Block_Form_Fieldset_Interface
{
    /**
     * holds form model
     *
     * @var Space48_Forms_Model_Form
     */
    protected $_form;
    
    /**
     * holds form fieldset
     *
     * @var Space48_Forms_Model_Form_Fieldset
     */
    protected $_fieldset;
    
    /**
     * fieldset container id (html)
     * not to be confused with fieldset model id
     *
     * @var string
     */
    protected $_fieldsetId;
    
    /**
     * css classes
     *
     * @var array
     */
    protected $_classes = array();
    
    /**
     * constructor
     */
    protected function _construct()
    {
        parent::_construct();
        
        /**
         * here we are trying to set the template
         * for this fieldset that has been specified in
         * admin panel. if we are unable to set
         * the template then we use the module
         * default template
         */
        try {
            
            // get fieldset model
            $fieldset = $this->getFieldset();
            
            // if we do not have the model
            // then throw exception
            if ( ! $fieldset ) {
                Mage::throwException('No fieldset model loaded.');
            }
            
            // try get template from model
            $template = $fieldset->getFrontendTemplate();
            
            // if we have no template then throw
            // an exception
            if ( ! $template ) {
                Mage::throwException('No front end template specified');
            }
            
            // we should have a template by this
            // point so set template
            $this->setTemplate($template);
            
            
        } catch (Exception $e) {
            // all else failed therefore set
            // default module template
            $this->setTemplate('space48/forms/form/fieldset.phtml');
        }
    }
    
    /**
     * get form 
     *
     * @return Space48_Forms_Model_Form
     */
    public function getForm()
    {
        return $this->_form;
    }
    
    /**
     * set form 
     *
     * @param Space48_Forms_Model_Form $form
     */
    public function setForm(Space48_Forms_Model_Form $form)
    {
        $this->_form = $form;
        return $this;
    }
    
    /**
     * get fieldset
     *
     * @return Space48_Forms_Model_Form_Fieldset
     */
    public function getFieldset()
    {
        return $this->_fieldset;
    }
    
    /**
     * set fieldset
     *
     * @param Space48_Forms_Model_Form_Fieldset $fieldset
     */
    public function setFieldset(Space48_Forms_Model_Form_Fieldset $fieldset)
    {
        $this->_fieldset = $fieldset;
        return $this;
    }
    
    /**
     * get fieldset id
     * don't confuse this with fieldset model id
     * this is purely for html id and javascript
     *
     * @return string
     */
    public function getFieldsetId()
    {
        if ( is_null($this->_fieldsetId) ) {
            $this->_fieldsetId = 'fieldset_' . uniqid() . '_' . $this->getFieldset()->getId();
        }
        
        return $this->_fieldsetId;
    }
    
    /**
     * get fieldset class (css class)
     *
     * @return string
     */
    public function getFieldsetClass()
    {
        $this->addFieldsetClass('fieldset');
        $this->addFieldsetClass('form-fieldset');
        $this->addFieldsetClass('form-fieldset-'.$this->getFieldset()->getId());
        
        return implode(' ', $this->_classes);
    }
    
    /**
     * add form class
     *
     * @param string|array $class
     */
    public function addFieldsetClass($class)
    {
        if ( is_array($class) ) {
            $classes = $class;
        } else {
            $classes = explode(' ', $class);
        }
        
        foreach ( $classes as $class ) {
            $this->_classes[$class] = $class;
        }
        
        return $this;
    }
    
    /**
     * can show fieldset
     *
     * @return bool
     */
    public function canShowFieldset()
    {
        if ( ! $this->getFieldset() ) {
            return false;
        }
        
        if ( ! $this->getFieldset()->getId() ) {
            return false;
        }
        
        if ( $this->getFieldset()->getFields()->count() < 1 ) {
            return false;
        }
        
        return true;
    }
    
    /**
     * can show title
     *
     * @return bool
     */
    public function canShowTitle()
    {
        if ( ! $this->getFieldset()->getTitle() ) {
            return false;
        }
        
        return true;
    }
    
    /**
     * get fieldset title
     *
     * @return string
     */
    public function getFieldsetTitle()
    {
        return $this->getFieldset()->getTitle();
    }
    
    /**
     * get fields
     *
     * @return Space48_Forms_Model_Resource_Form_Fieldset_Field_Collection
     */
    public function getFields()
    {
        return $this->getFieldset()->getFields();
    }
    
    public function getFieldBlock(Space48_Forms_Model_Form_Fieldset_Field $field)
    {
        $blockType = '';
        
        switch ( $field->getType() ) {
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_TEXT:
                $blockType = 'space48_forms/form_fieldset_field_text';
                break;
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_TEXTAREA:
                $blockType = 'space48_forms/form_fieldset_field_text';
                break;
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_SELECT:
                $blockType = 'space48_forms/form_fieldset_field_select';
                break;
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_CHECKBOX:
                $blockType = 'space48_forms/form_fieldset_field_text';
                break;
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_RADIO:
                $blockType = 'space48_forms/form_fieldset_field_text';
                break;
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_FILE:
                $blockType = 'space48_forms/form_fieldset_field_text';
                break;
        }
        
        $block = $this->getLayout()->createBlock($blockType);
        
        if ( ! ( $block instanceof Space48_Forms_Block_Form_Fieldset_Field_Abstract ) ) {
            $block = $this->getLayout()->createBlock('core/template');
        }
        
        // set variables
        $block->setParentBlock($this);
        $block->setForm($this->getForm());
        $block->setFieldset($this->getFieldset());
        $block->setField($field);
        
        return $block;
    }
    
    /**
     * get field html
     *
     * @param  Space48_Forms_Model_Form_Fieldset_Field $field
     *
     * @return string
     */
    public function getFieldHtml(Space48_Forms_Model_Form_Fieldset_Field $field)
    {
        return $this->getFieldBlock($field)->toHtml();
    }
}
