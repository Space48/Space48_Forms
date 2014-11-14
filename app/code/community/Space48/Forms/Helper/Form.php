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
}
