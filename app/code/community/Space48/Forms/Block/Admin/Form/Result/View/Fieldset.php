<?php

class Space48_Forms_Block_Admin_Form_Result_View_Fieldset extends Space48_Forms_Block_Result_Fieldset_Abstract
{
    /**
     * constructor
     */
    public function _construct()
    {
        parent::_construct();
        
        // set template
        $this->setTemplate('space48/forms/form/result/view/fieldset.phtml');
    }
    
    /**
     * get fieldset meta data
     *
     * @return array
     */
    public function getFieldsetMetaData()
    {
        return array_filter(array(
            'Name'                  => $this->getFieldset()->getName(),
            'Title'                 => $this->getFieldset()->getTitle(),
            'Description'           => $this->getFieldset()->getDescription(),
            'Instructions'          => $this->getFieldset()->getInstructions(),
            'Before Fields Content' => $this->getFieldset()->getBeforeFieldsContent(),
            'After Fields Content'  => $this->getFieldset()->getAfterFieldsContent(),
        ));
    }
}
