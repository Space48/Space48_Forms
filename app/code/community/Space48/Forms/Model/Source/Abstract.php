<?php

abstract class Space48_Forms_Model_Source_Abstract
{
    /**
     * holds option array
     *
     * @var array
     */
    protected $_options;
    
    /**
     * get all options
     *
     * @return array
     */
    public function getAllOptions()
    {
        if ( is_null($this->_options) ) {
            $this->_options = array();
        }
        
        return $this->_options;
    }
    
    /**
     * get option array
     *
     * @return array
     */
    public function getOptionArray()
    {
        $options = array();
        
        foreach ( $this->getAllOptions() as $option ) {
            $options[$option['value']] = $option['label'];
        }
        
        return $options;
    }
    
    /**
     * get value array
     *
     * @return array
     */
    public function getValueArray()
    {
        return $this->getAllOptions();
    }
    
    /**
     * get label given value
     *
     * @param string|integer $value
     * @return string
     */
    public function getOptionText($value, $default = null)
    {
        foreach ( $this->getAllOptions() as $option ) {
            if ( $option['value'] == $value ) {
                return $option['label'];
            }
        }
        
        return $default;
    }
}
