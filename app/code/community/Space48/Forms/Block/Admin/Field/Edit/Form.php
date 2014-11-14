<?php

class Space48_Forms_Block_Admin_Field_Edit_Form extends Space48_Forms_Block_Admin_Abstract_Form_Edit_Form_Abstract
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
        
        return parent::_prepareForm();
    }
}
