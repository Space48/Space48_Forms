<?php

class Space48_Troubleshoot_Helper_Data extends Mage_Core_Helper_Abstract
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
        return Mage::getStoreConfig("space48_troubleshoot/{$section}/{$key}");
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
}
