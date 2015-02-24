<?php

class Space48_Forms_Block_Admin_Form_Result_Grid extends Space48_Forms_Block_Admin_Abstract_Form_Grid_Abstract
{
    /**
     * constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setDefaultSort('result_id');
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
        $collection = Mage::getResourceModel('space48_forms/form_result_collection');
        
        // add form filter
        $collection->addFormFilter( $this->_getForm() );
        
        // set collection
        $this->setCollection($collection);
        
        return parent::_prepareCollection();
    }
    
    /**
     * get form
     *
     * @return Space48_Forms_Model_Form
     */
    protected function _getForm()
    {
        return Mage::helper('space48_forms')->registry('space48_forms/form');
    }
    
    /**
     * prepare columns
     *
     * @return $this
     */
    public function _prepareColumns()
    {
        // id column
        $this->addColumn('result_id', array(
            'header'    => 'ID',
            'index'     => 'result_id',
            'type'      => 'number',
            'width'     => '50px',
        ));
        
        // quick_view column
        $this->addColumn('quick_view', array(
            'header'  => 'Quick View',
            'type'    => 'action',
            'index'   => 'result_id',
            'width'   => '150px',
            'align'   => 'center',
            'filter'  => false,
            'actions' => array(
                array(
                    'field'   => 'result_id',
                    'caption' => $this->__('Quick View'),
                    'url'     => array(
                        'base'   => '*/*/quickview',
                        'params' => array(
                            'form_id' => $this->_getForm()->getId(),
                        ),
                    ),
                ),
            ),
        ));
        
        // detailed_view column
        $this->addColumn('detailed_view', array(
            'header'  => 'Detailed View',
            'type'    => 'action',
            'index'   => 'result_id',
            'width'   => '150px',
            'align'   => 'center',
            'filter'  => false,
            'actions' => array(
                array(
                    'field'   => 'result_id',
                    'caption' => $this->__('Detailed View'),
                    'url'     => array(
                        'base'   => '*/*/view',
                        'params' => array(
                            'form_id' => $this->_getForm()->getId(),
                        ),
                    ),
                ),
            ),
        ));
        
        // empty column
        $this->addColumn('empty', array(
            'header'  => '',
            'index'   => 'empty',
            'type'    => 'text',
            'filter'  => false,
        ));
        
        // status column
        $this->addColumn('status', array(
            'header'  => 'Status',
            'index'   => 'status',
            'type'    => 'options',
            'options' => Mage::getModel('space48_forms/source_form_result_status')->getOptionArray(),
            'width'   => '150px',
        ));
        
        // updated_at column
        $this->addColumn('updated_at', array(
            'header' => 'Updated At',
            'index'  => 'updated_at',
            'type'   => 'datetime',
            'width'  => '150px',
        ));
        
        // created_at column
        $this->addColumn('created_at', array(
            'header' => 'Created At',
            'index'  => 'created_at',
            'type'   => 'datetime',
            'width'  => '150px',
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
        return null;
    }
}
