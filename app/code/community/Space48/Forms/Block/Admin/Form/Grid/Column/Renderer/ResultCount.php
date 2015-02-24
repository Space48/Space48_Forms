<?php

class Space48_Forms_Block_Admin_Form_Grid_Column_Renderer_ResultCount
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    /**
     * render
     *
     * @param  Varien_Object $row
     *
     * @return string
     */
    public function render(Varien_Object $row)
    {
        $count = $row->getResultCount() * 1;
        
        if ( ! $count ) {
            return '0';
        }
        
        $url = $this->getUrl('adminhtml/forms_form_result/index', array(
            'form_id' => $row->getId(),
        ));
        
        return $this->__('%s (<a href="%s" target="_blank">view</a>)', $count, $url);
    }
}
