<?php

abstract class Space48_Forms_Block_Form_Fieldset_Field_Abstract
    extends Mage_Core_Block_Template
        implements Space48_Forms_Block_Form_Fieldset_Field_Interface
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
     * holds form fieldset
     *
     * @var Space48_Forms_Model_Form_Fieldset_Field
     */
    protected $_field;
    
    /**
     * field element id
     *
     * @var string
     */
    protected $_fieldId;
    
    /**
     * input element id
     *
     * @var string
     */
    protected $_inputId;
    
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
     * get field
     *
     * @return Space48_Forms_Model_Form_Fieldset_Field
     */
    public function getField()
    {
        return $this->_field;
    }
    
    /**
     * set field
     *
     * @param Space48_Forms_Model_Form_Fieldset_Field $field
     */
    public function setField(Space48_Forms_Model_Form_Fieldset_Field $field)
    {
        $this->_field = $field;
        return $this;
    }
    
    /**
     * can show comments
     *
     * @return bool
     */
    public function canShowComment()
    {
        if ( ! $this->getFieldComment() ) {
            return false;
        }
        
        return true;
    }
    
    /**
     * can show hints
     *
     * @return bool
     */
    public function canShowHint()
    {
        if ( ! $this->getFieldHint() ) {
            return false;
        }
        
        return true;
    }
    
    /**
     * get field type
     *
     * @return string
     */
    abstract public function getFieldType();
    
    /**
     * get field title
     *
     * @return string
     */
    public function getFieldTitle()
    {
        if ( $title = $this->getField()->getTitle() ) {
            return $title;
        }
        
        if ( $title = $this->getField()->getLabel() ) {
            return $title;
        }
        
        if ( $title = $this->getField()->getName() ) {
            return $title;
        }
        
        return $this->__('Field %s', $this->getField()->getId());
    }
    
    /**
     * get field label
     *
     * @return string
     */
    public function getFieldLabel()
    {
        if ( $label = $this->getField()->getLabel() ) {
            return $label;
        }
        
        if ( $label = $this->getField()->getTitle() ) {
            return $label;
        }
        
        if ( $label = $this->getField()->getName() ) {
            return $label;
        }
        
        return $this->__('Field %s', $this->getField()->getId());
    }
    
    /**
     * get field id
     *
     * @return string
     */
    public function getFieldId()
    {
        if ( is_null($this->_fieldId) ) {
            $this->_fieldId = 'field_' . uniqid() . '_' . $this->getField()->getId();
        }
        
        return $this->_fieldId;
    }
    
    /**
     * get form class (css class)
     *
     * @return string
     */
    public function getFieldClass()
    {
        $this->addFieldClass('form-field');
        
        $this->addFieldClass('form-field-'.$this->getField()->getType());
        
        if ( $this->isInputRequired() ) {
            $this->addFieldClass('input-required');
        }
        
        if ( $class = $this->getField()->getContainerClass() ) {
            $this->addFieldClass($class);
        }
        
        
        
        return implode(' ', $this->_classes);
    }
    
    /**
     * add field class
     *
     * @param string|array $class
     */
    public function addFieldClass($class)
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
     * get input element css class
     *
     * @return string
     */
    public function getCssClass()
    {
        $class = $this->getField()->getCssClass();
        
        if ( $this->isInputRequired() ) {
            $class .= ' required-entry';
        }
        
        return $class;
    }
    
    /**
     * get field name
     *
     * @return string
     */
    public function getFieldName()
    {
        return $this->getField()->getName();
    }
    
    /**
     * get default value
     *
     * @return string
     */
    public function getFieldValue()
    {
        return $this->getField()->getValue();
    }
    
    /**
     * get field comment
     *
     * @return string
     */
    public function getFieldComment()
    {
        return $this->getField()->getComment();
    }
    
    /**
     * get field hint
     *
     * @return string
     */
    public function getFieldHint()
    {
        return $this->getField()->getHint();
    }
    
    /**
     * is input required
     *
     * @return bool
     */
    public function isInputRequired()
    {
        return (bool) $this->getField()->getRequired();
    }
    
    /**
     * is autocapitalise
     *
     * @return bool
     */
    public function isAutoCapitalise()
    {
        return (bool) $this->getField()->getAutocapitalize();
    }
    
    /**
     * is autocorrect
     *
     * @return bool
     */
    public function isAutoCorrect()
    {
        return (bool) $this->getField()->getAutocorrect();
    }
    
    /**
     * is autocomplete
     *
     * @return bool
     */
    public function isAutoComplete()
    {
        return (bool) $this->getField()->getAutocomplete();
    }
    
    /**
     * is spellcheck
     *
     * @return bool
     */
    public function isSpellcheck()
    {
        return (bool) $this->getField()->getSpellcheck();
    }
    
    
    /**
     * get input id
     *
     * @return string
     */
    public function getInputId()
    {
        if ( is_null($this->_inputId) ) {
            $this->_inputId = 'input_' . uniqid() . '_' . $this->getField()->getId();
        }
        
        return $this->_inputId;
    }
    
    /**
     * get label element "for" attribute value
     *
     * @return string
     */
    public function getFor()
    {
        return $this->getInputId();
    }
}
