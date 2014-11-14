<?php

class Space48_Forms_Block_Admin_Field_Grid extends Space48_Forms_Block_Admin_Abstract_Form_Grid_Abstract
{
    /**
     * constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setDefaultSort('field_id');
        $this->setDefaultDir('DESC');
    }
    
    /**
     * prepare collection
     *
     * @return $this
     */
    public function _prepareCollection()
    {
        $collection = Mage::getResourceModel('space48_forms/form_fieldset_field_collection');
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    
    /**
     * prepare columns
     *
     * @return $this
     */
    public function _prepareColumns()
    {
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
        
        return parent::_prepareColumns();
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
        return $this->getUrl('*/*/edit', array('field_id' => $row->getId()));
    }
}
