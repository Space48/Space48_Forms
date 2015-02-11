<?php

class Space48_Forms_Helper_Form extends Mage_Core_Helper_Abstract
{
    /**
     * add a blank option to the beginning of an
     * array of options
     *
     * @param array $options
     */
    public function addBlankOption($options)
    {
        $options = array_reverse($options);
        $options[''] = $this->__('Please select...');
        return array_reverse($options);
    }
    
    /**
     * helper method to explode a string return clean values
     *
     * @param  string $delimiter
     * @param  string $string
     *
     * @return array
     */
    public function explode($string, $delimiter = ',')
    {
        $array = explode($delimiter, $string);
        
        foreach ( $array as $key => $value ) {
            $value = trim($value);
            $value = str_replace(array("\n", "\r"), null, $value);
            
            $array[$key] = $value;
        }
        
        return array_filter($array);
    }
    
    /**
     * get file upload path
     *
     * @return string
     */
    public function getFileUploadPath()
    {
        return Mage::getBaseDir('media') . DS . 'forms';
    }
}
