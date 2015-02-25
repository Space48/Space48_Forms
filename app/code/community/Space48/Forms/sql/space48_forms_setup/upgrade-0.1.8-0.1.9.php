<?php

$this->startSetup();

$table = $this->getTable('space48_forms/form');

$sql = "
    ALTER TABLE `{$table}`   
      ADD COLUMN `email_customer_name_field` VARCHAR(240) NOT NULL  COMMENT 'Field(s) which hold the customer name(s)' AFTER `email_customer`;
";

$this->run($sql);

$this->endSetup();



