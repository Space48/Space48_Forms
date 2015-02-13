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
     * holds errors for given field
     *
     * @var array
     */
    protected $_errors;
    
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
        $this->addFieldClass('fieldset-field');
        
        $this->addFieldClass('fieldset-field-'.$this->getField()->getId());
        
        $this->addFieldClass('fieldset-field-'.$this->getField()->getType());
        
        if ( $this->hasErrors() ) {
            $this->addFieldClass('has-errors');
        }
        
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
     * alias for "getInputClass"
     *
     * @return string
     */
    public function getCssClass()
    {
        return $this->getInputClass();
    }
    
    /**
     * get field class
     *
     * @return string
     */
    public function getInputClass()
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
     * get errors html
     *
     * @return string
     */
    public function getErrorsHtml()
    {
        if ( ! $this->hasErrors() ) {
            return '';
        }
        
        return $this->getLayout()->createBlock('core/template')
            ->setTemplate('space48/forms/form/fieldset/field/errors.phtml')
            ->setErrors($this->getErrors())
            ->toHtml();
    }
    
    /**
     * get errors
     *
     * @return array
     */
    public function getErrors()
    {
        if ( is_null($this->_errors) ) {
            $this->_errors = array();
            
            $result = Mage::getSingleton('space48_forms/session')->getFormResult();
            
            // if we get a result model
            if ( $result && $result->getId() ) {
                // lets get the result field that this
                // field relates to
                $field = $result->getResultFields( $this->getField()->getName() );
                
                // if we have got the result field
                // then we return the captured value
                if ( $field ) {
                    // get errors
                    $errors = $field->getErrors();
                    
                    // must have errors to continue
                    if ( $errors && count($errors) ) {
                        $this->_errors = $errors;
                    }
                }
            }
        }
        
        return $this->_errors;
    }
    
    /**
     * has errors
     *
     * @return bool
     */
    public function hasErrors()
    {
        return count($this->getErrors()) > 0;
    }
    
    /**
     * get field placeholder
     *
     * @return string
     */
    public function getFieldPlaceholder()
    {
        return $this->getField()->getPlaceholder();
    }
    
    /**
     * get default value
     *
     * @return string
     */
    public function getFieldValue()
    {
        // lets check if we have an active result model in our session - this
        // basically means the user has tried to submit their form but for some
        // reason (probably a missed field) it cannot be submitted. we will
        // load all values they filled into their form so they do no have to repeat
        if ( $this->_canRestoreCapturedData() ) {
            $result = Mage::getSingleton('space48_forms/session')->getFormResult();
            
            // if we get a result model
            if ( $result && $result->getId() ) {
                // lets get the result field that this
                // field relates to
                $field = $result->getResultFields( $this->getField()->getName() );
                
                // if we have got the result field
                // then we return the captured value
                if ( $field ) {
                    return $field->getValue();
                }
            }
        }
        
        return $this->getField()->getValue();
    }
    
    /**
     * whether we can restore captured data
     * when a form has been submitted but
     * failed submission and is shown again
     * to the user
     *
     * @return bool
     */
    protected function _canRestoreCapturedData()
    {
        switch ( $this->getType() ) {
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_PASSWORD:
            case Space48_Forms_Model_Source_Form_Fieldset_Field_Type::TYPE_FILE:
                return false;
                break;
        }
        
        return true;
    }
    
    /**
     * get field options
     *
     * @return array
     */
    public function getFieldOptions($blank = true)
    {
        // options array
        $options = $blank ? array('' => $this->__('Please select...')) : array();
        
        // get field options
        foreach ( Mage::helper('space48_forms/form')->explode($this->getField()->getOptions(), PHP_EOL) as $option ) {
            // append to array
            $options[$option] = $option;
        }
        
        return $options;
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
    
    /**
     * get input attributes
     *
     * @return array
     */
    protected function _getInputAttributes()
    {
        $attributes = array(
            'id'    => $this->getInputId(),
            'class' => $this->getInputClass(),
            'name'  => $this->getFieldName(),
            'title' => $this->getFieldTitle(),
        );
        
        if ( $this->isInputRequired() ) {
            $attributes['required'] = null;
        }
        
        return $attributes;
    }
    
    /**
     * get input attributes
     *
     * @return string
     */
    public function getInputAttributes()
    {
        // attributes
        $attributes = '';
        
        foreach ( $this->_getInputAttributes() as $key => $value ) {
            if ( $value ) {
                $attributes .= " {$key}=\"{$value}\" ";
            } else {
                $attributes .= " {$key} ";
            }
        }
        
        return $attributes;
    }
}
