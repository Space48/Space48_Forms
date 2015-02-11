<?php

class Space48_Forms_Block_Admin_Field_Edit_Tab_General extends Space48_Forms_Block_Admin_Field_Edit_Tab_Abstract
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
            $fieldset->addField('field_id', 'hidden', array(
                'name'  => 'field_id',
                'value' => $id,
            ));
        }
        
        // status field
        $fieldset->addField('status', 'select', array(
            'label'   => Mage::helper('space48_forms')->__('Enabled'),
            'name'    => 'status',
            'note'    => Mage::helper('space48_forms')->__('Enable or disable this fieldset. <span style="color:red; display:block;">Please note that this will disable this across all fieldsets which may not be the desired outcome.</span>'),
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
        
        // label field
        $fieldset->addField('label', 'text', array(
            'label'    => Mage::helper('space48_forms')->__('Label'),
            'required' => true,
            'name'     => 'label',
            'value'    => $this->_getModel()->getLabel(),
        ));
        
        // title field
        $fieldset->addField('title', 'text', array(
            'label'    => Mage::helper('space48_forms')->__('Title'),
            'name'     => 'title',
            'value'    => $this->_getModel()->getTitle(),
        ));
        
        // comment field
        $fieldset->addField('comment', 'text', array(
            'label'    => Mage::helper('space48_forms')->__('Comments'),
            'name'     => 'comment',
            'note'     => Mage::helper('space48_forms')->__('Comments will appear below the field.'),
            'value'    => $this->_getModel()->getComment(),
        ));
        
        // hint field
        $fieldset->addField('hint', 'text', array(
            'label'    => Mage::helper('space48_forms')->__('Hint'),
            'name'     => 'hint',
            'note'     => Mage::helper('space48_forms')->__('Will show a tooltip for hints.'),
            'value'    => $this->_getModel()->getHint(),
        ));
        
        // required field
        $fieldset->addField('required', 'select', array(
            'label'    => Mage::helper('space48_forms')->__('Required'),
            'name'     => 'required',
            'note'     => Mage::helper('space48_forms')->__('This field will be a required field if set to "Yes".'),
            'value'    => $this->_getModel()->getRequired(),
            'options'  => $this->_getYesNoOptions(),
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
