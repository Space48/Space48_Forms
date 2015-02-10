<?php

class Space48_Forms_Model_Form_Result_Fieldset extends Space48_Forms_Model_Abstract
{
    /**
     * holds form result model
     *
     * @var Space48_Forms_Model_Form_Result
     */
    protected $_formResult;
    
    /**
     * holds result fields
     *
     * @var Space48_Forms_Model_Resource_Form_Result_Fieldset_Field_Collection
     */
    protected $_resultFields;
    
    /**
     * _construct
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('space48_forms/form_result_fieldset');
    }
    
    /**
     * set form result model
     *
     * @param Space48_Forms_Model_Form_Result $result
     */
    public function setFormResult(Space48_Forms_Model_Form_Result $result)
    {
        $this->_formResult = $result;
        
        if ( $id = $result->getId() ) {
            $this->setResultId($id);
        }
        
        return $this;
    }
    
    /**
     * get form result model
     *
     * @return Space48_Forms_Model_Form_Result
     */
    public function getFormResult()
    {
        if ( is_null($this->_formResult) ) {
            $this->_formResult = Mage::getModel('space48_forms/form_result');
            
            if ( $id = $this->getResultId() ) {
                $this->_formResult->load($id);
            }
        }
        
        return $this->_formResult;
    }
    
    /**
     * set fieldset data
     *
     * @param Space48_Forms_Model_Form_Fieldset $fieldset
     */
    public function setFieldset(Space48_Forms_Model_Form_Fieldset $fieldset)
    {
        // copy data from form fieldset
        $this->addData(array(
            'name'                  => $fieldset->getName(),
            'title'                 => $fieldset->getTitle(),
            'description'           => $fieldset->getDescription(),
            'instructions'          => $fieldset->getInstructions(),
            'before_fields_content' => $fieldset->getBeforeFieldsContent(),
            'after_fields_content'  => $fieldset->getAfterFieldsContent(),
        ));
        
        // save this as we need the model id
        $this->save();
        
        // get fields in fieldset
        foreach ( $fieldset->getFields() as $field ) {
            // store as result field
            $resultField = Mage::getModel('space48_forms/form_result_fieldset_field');
            $resultField->setFormResultFieldset($this);
            $resultField->setField($field);
            $resultField->save();
            
            // add to collection
            // this will ensure we don't load it twice
            $this->getResultFields()->addItem($resultField);
        }
        
        // set collection as loaded
        $this->getResultFields()->setIsLoaded(true);
        
        return $this;
    }
    
    /**
     * get result fields
     *
     * @return Space48_Forms_Model_Resource_Form_Result_Fieldset_Field_Collection
     */
    public function getResultFields()
    {
        if ( is_null($this->_resultFields) ) {
            $this->_resultFields = Mage::getResourceModel('space48_forms/form_result_fieldset_field_collection');
            $this->_resultFields->setFormResultFieldsetFilter($this);
        }
        
        return $this->_resultFields;
    }
}
