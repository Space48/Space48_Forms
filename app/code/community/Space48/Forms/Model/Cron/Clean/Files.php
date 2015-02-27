<?php

class Space48_Forms_Model_Cron_Clean_Files extends Space48_Forms_Model_Cron_Abstract
{
    /**
     * holds path
     *
     * @var string
     */
    protected $_basePath;
    
    /**
     * holds result field resource
     *
     * @var Space48_Forms_Model_Resource_Form_Result_Fieldset_Field
     */
    protected $_resource;
    
    /**
     * run cron
     * 
     * @return $this
     */
    protected function _run()
    {
        $path = $this->_getBasePath();
        
        $this->_traverse($path);
    }
    
    /**
     * get base path
     *
     * @return string
     */
    protected function _getBasePath()
    {
        if ( is_null($this->_basePath) ) {
            $this->_basePath = Mage::helper('space48_forms/form')->getFileUploadPath();
        }
        
        return $this->_basePath;
    }
    
    /**
     * get resource model
     *
     * @return Space48_Forms_Model_Resource_Form_Result_Fieldset_Field
     */
    protected function _getResource()
    {
        if ( is_null($this->_resource) ) {
            $this->_resource = Mage::getResourceModel('space48_forms/form_result_fieldset_field');
        }
        
        return $this->_resource;
    }
    
    /**
     * traverse through directory and identify
     * and process every file
     *
     * @param  string $path
     *
     * @return $this
     */
    protected function _traverse($path)
    {
        $contents = scandir($path);
        
        foreach ( $contents as $file ) {
            if ( $file == '.' || $file == '..' ) {
                continue;
            }
            
            // build full file path
            $file = $path . DS . $file;
            
            // if this is a directory
            if ( is_dir($file) ) {
                $this->_traverse($file);
                continue;
            }
            
            // only continue if we have write
            // access to this file
            if ( ! is_writable($file) ) {
                continue;
            }
            
            // process file
            $this->_handleFile($file);
        }
        
        return $this;
    }
    
    /**
     * handle file
     *
     * @param  string $file
     *
     * @return $this
     */
    protected function _handleFile($file)
    {
        // we want the relative path
        // we stored in the database
        $search = substr($file, strlen($this->_basePath));
        
        // check whether such file exists in database
        $hasFile = $this->_getResource()->hasFile($search);
        
        // if we have file then we do not do anything
        if ( $hasFile ) {
            return $this;
        }
        
        // now we delete this file as it is redundant
        @unlink($file);
        
        return $this;
    }
}
