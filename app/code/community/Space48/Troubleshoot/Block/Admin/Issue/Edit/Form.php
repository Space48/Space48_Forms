<?php

class Space48_Troubleshoot_Block_Admin_Issue_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare form
     */
    protected function _prepareForm()
    {
        // new form
        $form = new Varien_Data_Form(array(
            'id'     => 'edit_form',
            'action' => $this->getUrl('*/*/save'),
            'method' => 'post',
        ));
        
        // use container
        $form->setUseContainer(true);
        
        // set form
        $this->setForm($form);
        
        // main fieldset
        $fieldset = $form->addFieldset('main', array(
            'legend' => Mage::helper('space48_forms')->__('Main Information')
        ));
        
        // issue_id field
        if ( $id = $this->_getModel()->getId() ) {
            $fieldset->addField('issue_id', 'hidden', array(
                'name'  => 'issue_id',
                'value' => $id,
            ));
        }
        
        // parent_id field
        $fieldset->addField('parent_id', 'hidden', array(
            'name'  => 'parent_id',
            'value' => $this->_getParentId(),
        ));
        
        // status field
        $fieldset->addField('status', 'select', array(
            'label'   => Mage::helper('space48_forms')->__('Enabled'),
            'name'    => 'status',
            'value'   => $this->_getModel()->getStatus(),
            'options' => $this->_getYesNoOptions(),
        ));
        
        // title field
        $fieldset->addField('title', 'text', array(
            'label' => Mage::helper('space48_forms')->__('Title'),
            'name'  => 'title',
            'value' => $this->_getModel()->getTitle(),
        ));
        
        // description field
        $fieldset->addField('description', 'editor', array(
            'label'   => Mage::helper('space48_forms')->__('Description'),
            'name'    => 'description',
            'wysiwyg' => true,
            'config'  => $this->_getWywiwygConfig(),
            'style'   => 'width:800px',
            'value'   => $this->_getModel()->getDescription(),
        ));
        
        // solution fieldset
        $fieldset = $form->addFieldset('solution_fieldset', array(
            'legend' => Mage::helper('space48_forms')->__('Solution')
        ));
        
        // either...
        $fieldset->addField('either', 'note', array(
            'text'  => $this->__('Either...'),
        ));
        
        // form_id field
        $fieldset->addField('form_id', 'select', array(
            'label'   => Mage::helper('space48_forms')->__('Form'),
            'name'    => 'form_id',
            'value'   => $this->_getModel()->getFormId(),
            'options' => $this->_getFormOptions(),
        ));
        
        // or...
        $fieldset->addField('or_static_block', 'note', array(
            'text'  => $this->__('or...'),
        ));
        
        // block_id field
        $fieldset->addField('block_id', 'text', array(
            'label' => Mage::helper('space48_forms')->__('Static Block Identifier'),
            'name'  => 'block_id',
            'value' => $this->_getModel()->getBlockId(),
        ));
        
        // or...
        $fieldset->addField('or_html_content', 'note', array(
            'text'  => $this->__('or...'),
        ));
        
        // solution field
        $fieldset->addField('solution', 'editor', array(
            'label'   => Mage::helper('space48_forms')->__('Solution'),
            'name'    => 'solution',
            'wysiwyg' => true,
            'config'  => $this->_getWywiwygConfig(),
            'style'   => 'width:800px',
            'value'   => $this->_getModel()->getSolution(),
        ));
        
        return parent::_prepareForm();
    }
    
    /**
     * get parent id
     *
     * @return int
     */
    protected function _getParentId()
    {
        if ( $this->_getModel()->getId() ) {
            return $this->_getModel()->getParentId();
        }
        
        if ( $id = $this->getRequest()->getParam('parent_id') ) {
            return $id;
        }
        
        return 0;
    }
    
    /**
     * get model
     *
     * @return Space48_Troubleshoot_Model_Issue
     */
    protected function _getModel()
    {
        return Mage::registry('current_issue');
    }
    
    /**
     * get wysiwyg config
     *
     * @return Varien_Object
     */
    protected function _getWywiwygConfig()
    {
        return Mage::getSingleton('cms/wysiwyg_config')->getConfig(array(
            'width' => '800px',
            'hidden' => true
        ));
    }
    
    /**
     * get yes/no options (boolean)
     *
     * @return array
     */
    protected function _getYesNoOptions()
    {
        return Mage::getSingleton('space48_troubleshoot/source_boolean')->getOptionArray();
    }
    
    /**
     * get form options
     *
     * @return array
     */
    protected function _getFormOptions()
    {
        return Mage::getSingleton('space48_troubleshoot/source_forms')->getOptionArray();
    }
}
