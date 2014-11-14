<?php

abstract class Space48_Forms_Block_Admin_Abstract_Form_Edit_Tabs_Tab_Abstract 
    extends Space48_Forms_Block_Admin_Abstract_Form_Edit_Form_Abstract
        implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    /**
     * can show tab
     *
     * @return boolean
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * is tab hidden
     *
     * @return boolean
     */
    public function isHidden()
    {
        return false;
    }
}
