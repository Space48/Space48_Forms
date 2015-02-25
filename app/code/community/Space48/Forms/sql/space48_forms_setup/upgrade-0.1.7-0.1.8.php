<?php

$this->startSetup();

$table = $this->getTable('space48_forms/form');

$sql = "
    ALTER TABLE `{$table}`   
      ADD COLUMN `email_customer_address_field` VARCHAR(240) NOT NULL  COMMENT 'Field which holds the email address.' AFTER `email_customer`;
";

$this->run($sql);

$this->endSetup();

