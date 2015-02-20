<?php

$this->startSetup();

$table = $this->getTable('space48_forms/form_result');

$sql = "
    ALTER TABLE `{$table}`   
      ADD COLUMN `status` VARCHAR(5) NOT NULL AFTER `customer_id`;
";

$this->run($sql);

$this->endSetup();
