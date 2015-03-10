<?php

class Space48_Troubleshoot_Model_Source_Forms extends Space48_Troubleshoot_Model_Source_Abstract
{
    /**
     * Option values
     */
    const VALUE_YES = 1;
    const VALUE_NO  = 0;
    
    /**
     * get all options
     *
     * @return array
     */
    public function getAllOptions()
    {
        if ( is_null($this->_options) ) {
            
            $forms = Mage::getResourceModel('space48_forms/form_collection');
            $forms->addEnabledFilter();
            
            $options = array();
            
            foreach ( $forms as $form ) {
                $options[] = array(
                    'label' => Mage::helper('space48_troubleshoot')->__('%s (%s)', $form->getTitle(), $form->getCode()),
                    'value' => $form->getId(),
                );
            }
            
            $this->_options = $options;
        }
        
        return parent::getAllOptions();
    }
}
