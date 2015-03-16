<?php

class Space48_Troubleshoot_Model_Issue extends Mage_Core_Model_Abstract
{
    /**
     * holds children
     *
     * @var Space48_Troubleshoot_Model_Resource_Issue_Collection
     */
    protected $_children;
    
    /**
     * holds parents
     *
     * @var array
     */
    protected $_parents;
    
    /**
     * holds form
     *
     * @var Space48_Forms_Model_Form
     */
    protected $_form;
    
    /**
     * _construct
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init('space48_troubleshoot/issue');
    }
    
    /**
     * has children
     *
     * @return bool
     */
    public function hasChildren()
    {
        return $this->getResource()->hasChildren($this);
    }
    
    /**
     * get children
     *
     * @return Space48_Troubleshoot_Model_Resource_Issue_Collection
     */
    public function getChildren()
    {
        if ( is_null($this->_children) ) {
            $children = Mage::getResourceModel('space48_troubleshoot/issue_collection');
            $children->addParentFilter($this);
            
            $this->_children = $children;
        }
        
        return $this->_children;
    }
    
    /**
     * get parents
     *
     * @return array
     */
    public function getParents()
    {
        if ( is_null($this->_parents) ) {
            $this->_parents = $this->getResource()->getParents($this);
        }
        
        return $this->_parents;
    }
    
    /**
     * on before delete, delete all children first
     *
     * @return $this
     */
    protected function _beforeDelete()
    {
        foreach ( $this->getChildren() as $child ) {
            $child->delete();
        }
        
        return parent::_beforeDelete();
    }
    
    /**
     * get form
     *
     * @return Space48_Forms_Model_Form
     */
    public function getForm()
    {
        // init model
        if ( is_null($this->_form) ) {
            $this->_form = Mage::getModel('space48_forms/form');
        }
        
        // if we have not loaded the form
        if ( ! $this->_form->getId() ) {
            // if we have a form id
            if ( $id = $this->getFormId() ) {
                // load form
                $this->_form->load($id);
            }
        }
        
        return $this->_form;
    }
    
    /**
     * set form
     *
     * @param Space48_Forms_Model_Form $form
     */
    public function setForm(Space48_Forms_Model_Form $form)
    {
        // set form
        $this->_form = $form;
        
        // if form has id, then set id
        if ( $id = $form->getId() ) {
            $this->setFormId($id);
        }
        
        return $this;
    }
}
