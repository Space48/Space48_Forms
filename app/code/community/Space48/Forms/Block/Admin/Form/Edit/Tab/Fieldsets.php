<?php

class Space48_Forms_Block_Admin_Form_Edit_Tab_Fieldsets
    extends Space48_Forms_Block_Admin_Abstract_Form_Grid_Abstract
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
        $this->setDefaultSort('position');
        $this->setDefaultDir('ASC');
        $this->setId('fieldsets');
    }
    
    /**
     * prepare collection
     *
     * @return $this
     */
    public function _prepareCollection()
    {
        // load collection
        $collection = Mage::getResourceModel('space48_forms/form_fieldset_collection');
        
        // get select object
        $select = $collection->getSelect();
        
        // get index table
        $table = $collection->getResource()->getTable('space48_forms/form_fieldset_index');
        
        // create join
        $select->joinLeft(array('index' => $table), 'main_table.fieldset_id = index.fieldset_id', array('position'));
        
        // set collection
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
        return $this->getUrl('*/*/fieldsetGrid', array('_current' => true));
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
            
            $fieldsets = $this->_getSelectedFieldsets();
            
            // default this to an array
            if ( ! $fieldsets ) {
                $fieldsets = array();
            }
            
            // if we have a filter value
            if ( $column->getFilter()->getValue() ) {
                $this->getCollection()->addFieldToFilter('main_table.fieldset_id', array('in' => $fieldsets));
            }
            
            // else if we have fieldsets that are selected
            elseif ( $fieldsets && count($fieldsets) ) {
                $this->getCollection()->addFieldToFilter('main_table.fieldset_id', array('nin' => $fieldsets));
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
            'values'           => $this->_getSelectedFieldsets(),
            'align'            => 'center',
            'index'            => 'fieldset_id'
        ));
        
        // id column
        $this->addColumn('fieldset_id', array(
            'header'    => 'ID',
            'index'     => 'fieldset_id',
            'type'      => 'number',
            'width'     => '50px',
        ));
        
        // name column
        $this->addColumn('name', array(
            'header'    => 'Name',
            'index'     => 'name',
        ));
        
        // title column
        $this->addColumn('title', array(
            'header'    => 'Title',
            'index'     => 'title',
        ));
        
        // status column
        $this->addColumn('status', array(
            'header'  => 'Enabled',
            'index'   => 'status',
            'type'    => 'options',
            'options' => Mage::getModel('adminhtml/system_config_source_yesno')->toArray(),
            'width'   => '50px',
        ));
        
        // position column
        $this->addColumn('position', array(
            'header'       => Mage::helper('space48_forms')->__('Position'),
            'width'        => '1',
            'type'         => 'number',
            'index'        => 'position',
            'filter_index' => 'index.position',
            'editable'     => true,
        ));
        
        return parent::_prepareColumns();
    }
    
    /**
     * get selected fieldsets
     *
     * @return array
     */
    protected function _getSelectedFieldsets()
    {
        // see if any posted data
        $fieldsets = $this->getRequest()->getPost('selected_fieldsets');
        
        // if not, then return what the model has
        // got stored
        if ( ! $fieldsets ) {
            $fieldsets = array_keys($this->getSelectedFieldsets());
        }
        
        return $fieldsets;
    }
    
    /**
     * get selected fieldsets
     *
     * @return array|null
     */
    public function getSelectedFieldsets()
    {
        // try load fieldset collection
        $fieldsets = $this->_getModel()->getFieldsets();
        
        // return empty array if there are no records
        if ( ! $fieldsets->count() ) {
            return array();
        }
        
        // build array
        $data = array();
        
        // loop through each fieldset and build data
        // array
        foreach ( $fieldsets as $fieldset ) {
            $data[$fieldset->getId()] = array(
                'position' => $fieldset->getPosition(),
            );
        }
        
        return $data;
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
            
            // serializer block
            $block = $this->getLayout()->createBlock('adminhtml/widget_grid_serializer');
            
            if ( $block instanceof Mage_Adminhtml_Block_Widget_Grid_Serializer ) {
                $block->initSerializerBlock($this, 'getSelectedFieldsets', 'fieldsets', 'selected_fieldsets');
                $block->addColumnInputName('position');
                
                $html .= $block->toHtml();
            }
        }
        
        return $html;
    }
}
