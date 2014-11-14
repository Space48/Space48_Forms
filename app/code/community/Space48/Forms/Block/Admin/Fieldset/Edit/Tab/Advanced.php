<?php

class Space48_Forms_Block_Admin_Fieldset_Edit_Tab_Advanced extends Space48_Forms_Block_Admin_Fieldset_Edit_Tab_Abstract
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        
        // set form
        $this->setForm($form);
        
        // new fieldset
        $fieldset = $form->addFieldset('settings', array(
            'legend' => Mage::helper('space48_forms')->__('Advanced Settings')
        ));
        
        // css_class field
        $fieldset->addField('css_class', 'text', array(
            'label' => Mage::helper('space48_forms')->__('CSS Class'),
            'name'  => 'css_class',
            'note'  => Mage::helper('space48_forms')->__('This value will be set to the utmost parent element.'),
            'value' => $this->_getModel()->getCssClass(),
        ));
        
        // frontend_block field
        $fieldset->addField('frontend_block', 'text', array(
            'label' => Mage::helper('space48_forms')->__('Frontend Block'),
            'name'  => 'frontend_block',
            'value' => $this->_getModel()->getFrontendBlock(),
        ));
        
        // frontend_template field
        $fieldset->addField('frontend_template', 'text', array(
            'label' => Mage::helper('space48_forms')->__('Frontend Template'),
            'name'  => 'frontend_template',
            'value' => $this->_getModel()->getFrontendTemplate(),
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
        return $this->__('Advanced');
    }

    /**
     * get tab title
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->__('Advanced');
    }
}
