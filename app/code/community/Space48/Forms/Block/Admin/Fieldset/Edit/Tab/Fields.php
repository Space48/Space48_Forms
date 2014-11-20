<?php

class Space48_Forms_Block_Admin_Fieldset_Edit_Tab_Fields
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
        $this->setId('fields');
    }
    
    /**
     * prepare collection
     *
     * @return $this
     */
    public function _prepareCollection()
    {
        // load collection
        $collection = Mage::getResourceModel('space48_forms/form_fieldset_field_collection');
        
        // get select object
        $select = $collection->getSelect();
        
        // get index table
        $table = $collection->getResource()->getTable('space48_forms/form_fieldset_field_index');
        
        // create join
        $select->joinLeft(array('index' => $table), 'main_table.field_id = index.field_id', array('position'));
        
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
        return $this->getUrl('*/*/fieldsGrid', array('_current' => true));
    }

    /**
     * get model
     *
     * @return Mage_Core_Model_Abstract
     */
    protected function _getModel()
    {
        return Mage::helper('space48_forms')->registry('space48_forms/form_fieldset');
    }
    
    protected function _addColumnFilterToCollection($column)
    {
        // Set custom filter for in category flag
        if ( $column->getId() == 'in_fieldset' ) {
            
            $fields = $this->_getSelectedFields();
            
            // default this to an array
            if ( ! $fields ) {
                $fields = array();
            }
            
            // if we have a filter value
            if ( $column->getFilter()->getValue() ) {
                $this->getCollection()->addFieldToFilter('main_table.field_id', array('in' => $fields));
            }
            
            // else if we have fields that are selected
            elseif ( $fields && count($fields) ) {
                $this->getCollection()->addFieldToFilter('main_table.field_id', array('nin' => $fields));
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
        $this->addColumn('in_fieldset', array(
            'header_css_class' => 'a-center',
            'type'             => 'checkbox',
            'name'             => 'in_fieldset',
            'values'           => $this->_getSelectedFields(),
            'align'            => 'center',
            'index'            => 'field_id'
        ));
        
        // id column
        $this->addColumn('field_id', array(
            'header'    => 'ID',
            'index'     => 'field_id',
            'type'      => 'number',
            'width'     => '50px',
        ));
        
        // name column
        $this->addColumn('name', array(
            'header'    => 'Name',
            'index'     => 'name',
        ));
        
        // label column
        $this->addColumn('label', array(
            'header'    => 'Label',
            'index'     => 'label',
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
    protected function _getSelectedFields()
    {
        // see if any posted data
        $fields = $this->getRequest()->getPost('selected_fields');
        
        // if not, then return what the model has
        // got stored
        if ( ! $fields ) {
            $fields = array_keys($this->getSelectedFields());
        }
        
        return $fields;
    }
    
    /**
     * get selected fieldsets
     *
     * @return array|null
     */
    public function getSelectedFields()
    {
        // try load fieldset collection
        $fields = $this->_getModel()->getFields();
        
        // return empty array if there are no records
        if ( ! $fields->count() ) {
            return array();
        }
        
        // build array
        $data = array();
        
        // loop through each fieldset and build data
        // array
        foreach ( $fields as $field ) {
            $data[$field->getId()] = array(
                'position' => $field->getPosition(),
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
        return $this->__('Fields');
    }

    /**
     * get tab title
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->__('Fields');
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
                $block->initSerializerBlock($this, 'getSelectedFields', 'fields', 'selected_fields');
                $block->addColumnInputName('position');
                
                $html .= $block->toHtml();
            }
        }
        
        return $html;
    }
}
