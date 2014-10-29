<?php

class Space48_Forms_Block_Admin_Form_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare form
     */
    protected function _prepareForm()
    {
        // new form
        $form = new Varien_Data_Form(array(
            'id'     => 'space48_forms_form_edit',
            'action' => $this->getUrl('*/*/save'),
            'method' => 'post',
        ));
        
        // use container
        $form->setUseContainer(true);
        
        // set form
        $this->setForm($form);
        
        return parent::_prepareForm();
    }
}
