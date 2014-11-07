<?php

class Space48_Forms_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * is module enabled
     *
     * @return bool
     */
    public function isEnabled()
    {
        return (bool) $this->getConfig('enabled');
    }
    
    /**
     * get config
     *
     * @param  string $key
     * @param  string $section
     *
     * @return string
     */
    public function getConfig($key, $section = 'general')
    {
        return Mage::getStoreConfig("space48_forms/{$section}/{$key}");
    }
    
    /**
     * return timestamp
     *
     * @return int
     */
    public function now()
    {
        return Mage::getModel('core/date')->timestamp() * 1;
    }
    
    /**
     * registers models in registry
     *
     * @param  string $key
     * @param  Varien_Object $model
     *
     * @return $this
     */
    public function register($key, Varien_Object $model)
    {
        $key = 'current/'.$key;
        Mage::register($key, $model);
        return $this;
    }
    
    /**
     * get model from registry
     *
     * @param  string $key
     *
     * @return Varien_Object
     */
    public function registry($key)
    {
        $key = 'current/'.$key;
        return Mage::registry($key);
    }
    
    /**
     * throw exception
     * 
     * this is here so we don't have to call the "__"
     * function at every point. DRY
     *
     * @return void
     */
    public function throwException()
    {
        $args = func_get_args();
        $message = call_user_func_array(array($this, '__'), $args);
        Mage::throwException($message);
    }
}
