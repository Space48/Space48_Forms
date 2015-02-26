<?php

abstract class Space48_Forms_Block_Form_Abstract
    extends Mage_Core_Block_Template
        implements Space48_Forms_Block_Form_Interface
{
    /**
     * holds form model
     *
     * @var Space48_Forms_Model_Form
     */
    protected $_form;
    
    /**
     * form container id (html)
     * not to be confused with form model id
     *
     * @var string
     */
    protected $_formId;
    
    /**
     * css classes
     *
     * @var array
     */
    protected $_classes = array('space48-form');
    
    /**
     * constructor
     */
    protected function _construct()
    {
        parent::_construct();
        
        /**
         * here we are trying to set the template
         * for this form that has been specified in
         * admin panel. if we are unable to set
         * the template then we use the module
         * default template
         */
        try {
            
            // get form model
            $form = $this->getForm();
            
            // if we do not have the model
            // then throw exception
            if ( ! $form ) {
                Mage::throwException('No form model loaded.');
            }
            
            // try get template from model
            $template = $form->getFrontendTemplate();
            
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
            $this->setTemplate('space48/forms/form.phtml');
        }
    }
    
    /**
     * get form
     * 
     * @return Space48_Forms_Model_Form
     */
    public function getForm()
    {
        if ( is_null($this->_form) ) {
            
            // get form identifier - could be int id or
            // it could be string code
            $id = $this->getData('identifier');
            
            // get form model
            $this->_form = Mage::getModel('space48_forms/form');
            
            if ( $id ) {
                if ( is_numeric($id) ) {
                    $this->_form->load($id);
                } else {
                    $this->_form->load($id, 'code');
                }
            }
        }
        
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
     * get form id
     * don't confuse this with form model id - this
     * is purely for html id and javascript
     *
     * @return string
     */
    public function getFormId()
    {
        if ( is_null($this->_formId) ) {
            $this->_formId = 'form_' . uniqid() . '_' . $this->getForm()->getId();
        }
        
        return $this->_formId;
    }
    
    /**
     * get current url
     *
     * @return string
     */
    public function getCurrentUrl()
    {
        return Mage::helper('core/url')->getCurrentUrl();
    }
     
    /**
     * get js form name
     *
     * @return string
     */
    public function getJsFormName()
    {
        return 'js_' . $this->getFormId();
    }
    
    /**
     * get json config
     *
     * @return string
     */
    public function getJsonConfig()
    {
        return json_encode(array(
            'key' => 'value', // leave this here, but ignore it
        ));
    }
    
    /**
     * get form class (css class)
     *
     * @return string
     */
    public function getFormClass()
    {
        if ( $class = $this->getForm()->getCssClass() ) {
            $this->addFormClass($class);
        }
        
        return implode(' ', $this->_classes);
    }
    
    /**
     * add form class
     *
     * @param string|array $class
     */
    public function addFormClass($class)
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
     * get form method
     *
     * @return string
     */
    public function getFormMethod()
    {
        return $this->getForm()->getMethod();
    }
    
    /**
     * get form action
     *
     * @return string
     */
    public function getFormAction()
    {
        if ( $this->getForm()->getMethod() == Space48_Forms_Model_Form::FORM_METHOD_POST ) {
            return $this->getUrl('forms/submit/post');
        }
        
        return $this->getUrl('forms/submit/get');
    }
    
    /**
     * get form enc type
     *
     * @return string
     */
    public function getFormEncType()
    {
        return $this->getForm()->getEnctype();
    }
    
    /**
     * can show form
     *
     * @return bool
     */
    public function canShowForm()
    {
        
        // must have form model
        if ( ! $this->getForm() ) {
            return false;
        }
        
        // must be loaded form model
        if ( ! $this->getForm()->getId() ) {
            return false;
        }
        
        // if only registered customers can view then...
        if ( $this->getForm()->getRegisteredOnly() ) {
            // ...customers must be logged in
            if ( ! Mage::helper('customer')->isLoggedIn() ) {
                return false;
            }
        }
        
        // must have at least one fieldset
        if ( $this->getForm()->getFieldsets()->count() < 1 ) {
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
        if ( ! $this->getFormTitle() ) {
            return false;
        }
        
        return true;
    }
    
    /**
     * can show description
     *
     * @return bool
     */
    public function canShowDescription()
    {
        if ( ! $this->getFormDescription() ) {
            return false;
        }
        
        return true;
    }
    
    /**
     * can show instructions
     *
     * @return bool
     */
    public function canShowInstructions()
    {
        if ( ! $this->getFormInstructions() ) {
            return false;
        }
        
        return true;
    }
    
    /**
     * can show before form content
     *
     * @return bool
     */
    public function canShowBeforeFormContent()
    {
        if ( ! $this->getBeforeFormContent() ) {
            return false;
        }
        
        return true;
    }
    
    /**
     * can show after form content
     *
     * @return bool
     */
    public function canShowAfterFormContent()
    {
        if ( ! $this->getAfterFormContent() ) {
            return false;
        }
        
        return true;
    }
    
    /**
     * can show back button
     *
     * @return bool
     */
    public function canShowBackButton()
    {
        if ( ! $this->getShowBackButton() ) {
            return false;
        }
        
        if ( ! $this->getBackButtonUrl() ) {
            return false;
        }
        
        return true;
    }
    
    /**
     * get form title
     *
     * @return string
     */
    public function getFormTitle()
    {
        return $this->getForm()->getTitle();
    }
    
    /**
     * get form description
     *
     * @return string
     */
    public function getFormDescription()
    {
        return $this->getForm()->getDescription();
    }
    
    /**
     * get form instructions
     *
     * @return string
     */
    public function getFormInstructions()
    {
        return $this->getForm()->getInstructions();
    }
    
    /**
     * get before form content
     *
     * @return string
     */
    public function getBeforeFormContent()
    {
        return $this->getForm()->getBeforeFormContent();
    }
    
    /**
     * get after form content
     *
     * @return string
     */
    public function getAfterFormContent()
    {
        return $this->getForm()->getAfterFormContent();
    }
    
    /**
     * get submit button text
     *
     * @return string
     */
    public function getSubmitButtonText()
    {
        return $this->getForm()->getSubmitButtonText();
    }
    
    /**
     * whether to show back button
     *
     * @return bool
     */
    public function getShowBackButton()
    {
        return (bool) $this->getForm()->getBackButtonShow();
    }
    
    /**
     * get back button text
     *
     * @return string
     */
    public function getBackButtonText()
    {
        return $this->getForm()->getBackButtonText();
    }
    
    /**
     * get back button url
     *
     * @return string
     */
    public function getBackButtonUrl()
    {
        return $this->getForm()->getBackButtonUrl();
    }
    
    /**
     * get fieldsets
     *
     * @return Space48_Forms_Model_Resource_Form_Fieldset_Collection
     */
    public function getFieldsets()
    {
        return $this->getForm()->getFieldsets();
    }
    
    /**
     * get fieldset block
     *
     * @param  Space48_Forms_Model_Form_Fieldset $fieldset
     *
     * @return Space48_Forms_Block_Form_Fieldset
     */
    public function getFieldsetBlock(Space48_Forms_Model_Form_Fieldset $fieldset)
    {
        // get block
        $block = $this->getLayout()->createBlock( $fieldset->getFrontendBlock() );
        
        // default to space48_forms/form_fieldset to avoid breaking
        if ( ! ( $block instanceof Space48_Forms_Block_Form_Fieldset_Abstract ) ) {
            $block = $this->getLayout()->createBlock('space48_forms/form_fieldset');
        }
        
        // default to core/template to avoid breaking
        if ( ! ( $block instanceof Space48_Forms_Block_Form_Fieldset_Abstract ) ) {
            $block = $this->getLayout()->createBlock('core/template');
        }
        
        // set variables
        $block->setParentBlock($this);
        $block->setForm($this->getForm());
        $block->setFieldset($fieldset);
        
        return $block;
    }
    
    /**
     * get fieldset html
     *
     * @param  Space48_Forms_Model_Form_Fieldset $fieldset
     *
     * @return string
     */
    public function getFieldsetHtml(Space48_Forms_Model_Form_Fieldset $fieldset)
    {
        return $this->getFieldsetBlock($fieldset)->toHtml();
    }
    
    /**
     * to html
     *
     * @return string
     */
    protected function _toHtml()
    {
        if ( ! Mage::helper('space48_forms')->isEnabled() ) {
            return '';
        }
        
        return parent::_toHtml();
    }
}
