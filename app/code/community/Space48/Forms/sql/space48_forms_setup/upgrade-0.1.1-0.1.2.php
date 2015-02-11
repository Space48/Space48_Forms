<?php

$this->startSetup();

try {
    $path = Mage::helper('space48_forms/form')->getFileUploadPath();
    
    @mkdir($path, 0777, true);
    
} catch (Exception $e) {
    // oh well, will have to create it manually
}

$this->endSetup();




