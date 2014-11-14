<?php

class Space48_Forms_Block_Admin_Form_Edit_Tab_Fieldsets
    extends Space48_Forms_Block_Admin_Fieldset_Grid
        implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    /**
     * constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setUseAjax(true);
        $this->setSaveParametersInSession(false);
        $this->setDefaultSort('fieldset_id');
        $this->setDefaultDir('DESC');
        $this->setId('fieldsets');
    }
    
    /**
     * prepare collection
     *
     * @return $this
     */
    public function _prepareCollection()
    {
        $collection = Mage::getResourceModel('space48_forms/form_fieldset_collection');
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    
    /**
     * get row url
     *
     * @param  Unknown $row
     *
     * @return string
     */
    public function getRowUrl($row)
    {
        return null;
    }
    
    /**
     * get grid url
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }

    /**
     * get model
     *
     * @return Mage_Core_Model_Abstract
     */
    protected function _getModel()
    {
        return Mage::helper('space48_forms')->registry('space48_forms/form');
    }
    
    protected function _addColumnFilterToCollection($column)
    {
        // Set custom filter for in category flag
        if ( $column->getId() == 'in_form' ) {
            
            $fieldsets = $this->getSelectedFieldsets();
            
            // default this to an array
            if ( ! $fieldsets ) {
                $fieldsets = array();
            }
            
            // if we have a filter value
            if ( $column->getFilter()->getValue() ) {
                $this->getCollection()->addFieldToFilter('fieldset_id', array('in' => $fieldsets));
            }
            
            // else if we have fieldsets that are selected
            elseif ( $fieldsets && count($fieldsets) ) {
                $this->getCollection()->addFieldToFilter('fieldset_id', array('nin' => $fieldsets));
            }
        }
        // for all other filters
        else {
            parent::_addColumnFilterToCollection($column);
        }
        
        return $this;
    }
    
    /**
     * prepare columns
     *
     * @return $this
     */
    public function _prepareColumns()
    {
        // id column
        $this->addColumn('in_form', array(
            'header_css_class' => 'a-center',
            'type'             => 'checkbox',
            'name'             => 'in_form',
            'values'           => $this->getSelectedFieldsets(),
            'align'            => 'center',
            'index'            => 'fieldset_id'
        ));
        
        return parent::_prepareColumns();
    }
    
    /**
     * get selected fieldsets
     *
     * @return array|null
     */
    public function getSelectedFieldsets()
    {
        $fieldsets = $this->getRequest()->getPost('selected_fieldsets');
        
        if ( is_null($fieldsets) ) {
            $fieldsets = $this->_getModel()->getFieldsetIds();
            
            if ( $fieldsets ) {
                return $fieldsets;
            }
        }
        
        return $fieldsets;
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
    
    /**
     * can show tab
     *
     * @return boolean
     */
    public function canShowTab()
    {
        if ( $this->_getModel()->getId() ) {
            return true;
        }
        
        return false;
    }
    
    /**
     * get tab label
     *
     * @return string
     */
    public function getTabLabel()
    {
        return $this->__('Fieldsets');
    }

    /**
     * get tab title
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->__('Fieldsets');
    }
    
    /**
     * override to allow us to attach additional
     * html to add serializer to grid.
     * 
     * we only add the serializer if this is
     * not an ajax request
     *
     * @return string
     */
    protected function _toHtml()
    {
        $html = parent::_toHtml();
        
        if ( ! $this->getRequest()->isXmlHttpRequest() ) {
            
            $block = $this->getLayout()->createBlock('adminhtml/widget_grid_serializer');
            $block->initSerializerBlock($this, 'getSelectedFieldsets', 'fieldsets', 'selected_fieldsets');
            
            if ( $block ) {
                $html .= $block->toHtml();
            }
        }
        
        return $html;
    }
}
