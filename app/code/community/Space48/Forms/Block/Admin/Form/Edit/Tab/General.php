<?php

class Space48_Forms_Block_Admin_Form_Edit_Tab_General extends Space48_Forms_Block_Admin_Form_Edit_Tab_Abstract
{
    /**
     * prepare form
     * 
     * @return $this
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        
        // set form
        $this->setForm($form);
        
        // new fieldset
        $fieldset = $form->addFieldset('information', array(
            'legend' => Mage::helper('space48_forms')->__('General Information')
        ));
        
        // id field
        if ( $id = $this->_getModel()->getId() ) {
            $fieldset->addField('form_id', 'hidden', array(
                'name'  => 'form_id',
                'value' => $id,
            ));
        }
        
        // status field
        $fieldset->addField('status', 'select', array(
            'label'   => Mage::helper('space48_forms')->__('Enabled'),
            'name'    => 'status',
            'note'    => Mage::helper('space48_forms')->__('Enable or disable this form.'),
            'options' => $this->_getYesNoOptions(),
            'value'   => $this->_getModel()->getStatus(),
        ));
        
        // name field
        $fieldset->addField('code', 'text', array(
            'label'    => Mage::helper('space48_forms')->__('Code'),
            'required' => true,
            'name'     => 'code',
            'note'     => Mage::helper('space48_forms')->__('A unique code to identify this form.'),
            'value'    => $this->_getModel()->getCode(),
        ));
        
        // title field
        $fieldset->addField('title', 'text', array(
            'label' => Mage::helper('space48_forms')->__('Title'),
            'name'  => 'title',
            'note'  => Mage::helper('space48_forms')->__('The form title. If set, this will appear as a page title.'),
            'value' => $this->_getModel()->getTitle(),
        ));
        
        // description field
        $fieldset->addField('description', 'editor', array(
            'label'   => Mage::helper('space48_forms')->__('Description'),
            'name'    => 'description',
            'note'    => Mage::helper('space48_forms')->__('The form description. If set, this will appear after the page title.'),
            'wysiwyg' => true,
            'config'  => $this->_getWywiwygConfig(),
            'style'   => 'width:800px',
            'value'   => $this->_getModel()->getDescription(),
        ));
        
        // instructions field
        $fieldset->addField('instructions', 'editor', array(
            'label'   => Mage::helper('space48_forms')->__('Instructions'),
            'name'    => 'instructions',
            'note'    => Mage::helper('space48_forms')->__('The form instructions. If set, this will appear before the form in an attempt to provide instructions to the user.'),
            'wysiwyg' => true,
            'config'  => $this->_getWywiwygConfig(),
            'style'   => 'width:800px',
            'value'   => $this->_getModel()->getInstructions(),
        ));
        
        // success content field
        $fieldset->addField('success_content', 'editor', array(
            'label'   => Mage::helper('space48_forms')->__('Success Content'),
            'name'    => 'success_content',
            'note'    => Mage::helper('space48_forms')->__('This content appears on successfully submission of the form.'),
            'wysiwyg' => true,
            'config'  => $this->_getWywiwygConfig(),
            'style'   => 'width:800px',
            'value'   => $this->_getModel()->getSuccessContent(),
        ));
        
        
        /* currently no use case
        // failure content field
        $fieldset->addField('failure_content', 'editor', array(
            'label'   => Mage::helper('space48_forms')->__('Failure Content'),
            'name'    => 'failure_content',
            'note'    => Mage::helper('space48_forms')->__('This content appears on unsuccessful submission of the form.'),
            'wysiwyg' => true,
            'config'  => $wysiwygConfig,
            'value'   => $this->_getModel()->getFailureContent(),
        ));
        */
       
        // before form content
        $fieldset->addField('before_form_content', 'editor', array(
            'label'   => Mage::helper('space48_forms')->__('Before Form Content'),
            'name'    => 'before_form_content',
            'note'    => Mage::helper('space48_forms')->__('This content appears immediately before the form.'),
            'wysiwyg' => true,
            'config'  => $this->_getWywiwygConfig(),
            'style'   => 'width:800px',
            'value'   => $this->_getModel()->getBeforeFormContent(),
        ));
        
        // after form content
        $fieldset->addField('after_form_content', 'editor', array(
            'label'   => Mage::helper('space48_forms')->__('After Form Content'),
            'name'    => 'after_form_content',
            'note'    => Mage::helper('space48_forms')->__('This content appears immediately after the form.'),
            'wysiwyg' => true,
            'config'  => $this->_getWywiwygConfig(),
            'style'   => 'width:800px',
            'value'   => $this->_getModel()->getAfterFormContent(),
        ));
        
        return parent::_prepareForm();
    }
    
    /**
     * get tab label
     *
     * @return string
     */
    public function getTabLabel()
    {
        return $this->__('General');
    }

    /**
     * get tab title
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->__('General');
    }
}
