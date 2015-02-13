<?php

class Space48_Forms_Model_Form_Fieldset_Field extends Space48_Forms_Model_Abstract
{
    /**
     * validation data
     *
     * @var array
     */
    protected $_validationData;
    
    /**
     * _construct
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('space48_forms/form_fieldset_field');
    }
    
    /**
     * on before save
     *
     * @return $this
     */
    protected function _beforeSave()
    {
        $this->validate();
        
        $this->_saveValidationData();
        
        return parent::_beforeSave();
    }
    
    /**
     * validate data
     *
     * @return $this
     */
    public function validate()
    {
        return $this;
    }
    
    /**
     * save validation data
     *
     * @return $this
     */
    protected function _saveValidationData()
    {
        // get data
        $data = $this->_getData('validation_data');
        
        // convert to json
        if ( $data ) {
            $data = json_encode($data);
        } else {
            $data = '';
        }
        
        // store as json
        $this->setData('validation_data', $data);
        
        return $this;
    }
    
    /**
     * get validation data
     *
     * @param  string|null $key
     *
     * @return string|null
     */
    public function getValidationData($key = null)
    {
        if ( is_null($this->_validationData) ) {
            
            // get raw value
            $data = $this->_getData('validation_data');
            
            // check if is array
            if ( ! is_array($data) ) {
                // if not then json decode
                $data = (array) json_decode($data);
            }
            
            // cache value
            $this->_validationData = $data;
        }
        
        if ( is_null($key) ) {
            return $this->_validationData;
        }
        
        if ( array_key_exists($key, $this->_validationData) ) {
            return $this->_validationData[$key];
        }
        
        return null;
    }
    
    /**
     * get validation data json
     *
     * @return string
     */
    public function getValidationDataJson()
    {
        return $this->_getData('validation_data');
    }
}
