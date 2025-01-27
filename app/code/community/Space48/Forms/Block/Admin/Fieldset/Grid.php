<?php

class Space48_Forms_Block_Admin_Fieldset_Grid extends Space48_Forms_Block_Admin_Abstract_Form_Grid_Abstract
{
    /**
     * constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setDefaultSort('fieldset_id');
        $this->setDefaultDir('DESC');
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
     * prepare columns
     *
     * @return $this
     */
    public function _prepareColumns()
    {
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
        return $this->getUrl('*/*/edit', array('fieldset_id' => $row->getId()));
    }
}
