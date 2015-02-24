<?php

class Space48_Forms_Block_Admin_Form_Grid extends Space48_Forms_Block_Admin_Abstract_Form_Grid_Abstract
{
    /**
     * constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setDefaultSort('form_id');
        $this->setDefaultDir('DESC');
    }
    
    /**
     * prepare collection
     *
     * @return $this
     */
    public function _prepareCollection()
    {
        // get collection
        $collection = Mage::getResourceModel('space48_forms/form_collection');
        
        // add results count
        $collection->addResultsCount();
        
        // set collection
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
        $this->addColumn('form_id', array(
            'header'    => 'ID',
            'index'     => 'form_id',
            'type'      => 'number',
            'width'     => '50px',
        ));
        
        // name column
        $this->addColumn('code', array(
            'header'    => 'Code',
            'index'     => 'code',
            'type'      => 'text',
            'width'     => '150px',
        ));
        
        // name column
        $this->addColumn('title', array(
            'header'    => 'Title',
            'index'     => 'title',
        ));
        
        // name column
        $this->addColumn('result_count', array(
            'header'   => 'Result Count',
            'index'    => 'result_count',
            'type'     => 'number',
            'renderer' => 'Space48_Forms_Block_Admin_Form_Grid_Column_Renderer_ResultCount',
            'width'    => '150px',
            'filter_condition_callback' => array($this, '_resultCountFilter'),
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
     * result counter filter callback
     *
     * @param  Space48_Forms_Model_Resource_Form_Collection $collection
     * @param  Mage_Adminhtml_Block_Widget_Grid_Column $column
     *
     * @return $this
     */
    protected function _resultCountFilter($collection, $column)
    {
        // get value
        $value = $column->getFilter()->getValue();
        
        // dont continue if value is not an array
        if ( ! $value || ! is_array($value) ) {
            return $this;
        }
        
        // get select object
        $select = $collection->getSelect();
        
        // get from and to
        $from = isset($value['from']) ? $value['from'] : null;
        $to   = isset($value['to'])   ? $value['to']   : null;
        
        if ( ! is_null($from) ) {
            $select->having('COUNT(results.result_id) >= ?', $from);
        }
        
        if ( ! is_null($to) ) {
            $select->having('COUNT(results.result_id) <= ?', $to);
        }
        
        return $this;
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
        return $this->getUrl('*/*/edit', array('form_id' => $row->getId()));
    }
}
