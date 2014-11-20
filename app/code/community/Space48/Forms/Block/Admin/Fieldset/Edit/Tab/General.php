<?php

class Space48_Forms_Block_Admin_Fieldset_Edit_Tab_General extends Space48_Forms_Block_Admin_Fieldset_Edit_Tab_Abstract
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
            $fieldset->addField('fieldset_id', 'hidden', array(
                'name'  => 'fieldset_id',
                'value' => $id,
            ));
        }
        
        // status field
        $fieldset->addField('status', 'select', array(
            'label'   => Mage::helper('space48_forms')->__('Enabled'),
            'name'    => 'status',
            'note'    => Mage::helper('space48_forms')->__('Enable or disable this fieldset. <span style="color:red; display:block;">Please note that this will disable this across all forms which may not be the desired outcome.</span>'),
            'options' => $this->_getYesNoOptions(),
            'value'   => $this->_getModel()->getStatus(),
        ));
        
        // name field
        $fieldset->addField('name', 'text', array(
            'label'    => Mage::helper('space48_forms')->__('Name'),
            'required' => true,
            'name'     => 'name',
            'value'    => $this->_getModel()->getName(),
        ));
        
        // title field
        $fieldset->addField('title', 'text', array(
            'label'    => Mage::helper('space48_forms')->__('Title'),
            'required' => true,
            'name'     => 'title',
            'value'    => $this->_getModel()->getTitle(),
        ));
        
        // description field
        $fieldset->addField('description', 'editor', array(
            'label'   => Mage::helper('space48_forms')->__('Description'),
            'name'    => 'description',
            'note'    => Mage::helper('space48_forms')->__('The form description. If set, this will appear at the top of the fieldset.'),
            'wysiwyg' => true,
            'config'  => $this->_getWywiwygConfig(),
            'style'   => 'width:800px',
            'value'   => $this->_getModel()->getDescription(),
        ));
        
        // instructions field
        $fieldset->addField('instructions', 'editor', array(
            'label'   => Mage::helper('space48_forms')->__('Instructions'),
            'name'    => 'instructions',
            'note'    => Mage::helper('space48_forms')->__('The form instructions. If set, this will appear at the top of the fieldset after description.'),
            'wysiwyg' => true,
            'config'  => $this->_getWywiwygConfig(),
            'style'   => 'width:800px',
            'value'   => $this->_getModel()->getInstructions(),
        ));
        
        // before fields field
        $fieldset->addField('before_fields_content', 'editor', array(
            'label'   => Mage::helper('space48_forms')->__('Before Fields Content'),
            'name'    => 'before_fields_content',
            'note'    => Mage::helper('space48_forms')->__('Content that appears before the fields.'),
            'wysiwyg' => true,
            'config'  => $this->_getWywiwygConfig(),
            'style'   => 'width:800px',
            'value'   => $this->_getModel()->getBeforeFieldsContent(),
        ));
        
        // before fields field
        $fieldset->addField('after_fields_content', 'editor', array(
            'label'   => Mage::helper('space48_forms')->__('After Fields Content'),
            'name'    => 'after_fields_content',
            'note'    => Mage::helper('space48_forms')->__('Content that appears after the fields.'),
            'wysiwyg' => true,
            'config'  => $this->_getWywiwygConfig(),
            'style'   => 'width:800px',
            'value'   => $this->_getModel()->getAfterFieldsContent(),
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
